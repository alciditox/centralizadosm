<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('pdf');

		$this->load->helper('form');
		$this->load->model('parameters');
		$this->load->model('model_invoices');

		$this->load->library('email');

		// Load database

		// Load APIS
		$this->load->model('model_apis');
	}

	// -----------------------------------------------------------------------

	/**
	 * 
	 * 
	 */

	public function domiciliations()
	{
		//$data['banks'] = $this->model_invoices->banks();
		$data['banks'] = $this->model_apis->banks();
		$data['list'] = $this->model_invoices->list_archives_conciliate();
		//$data['totals'] = $this->model_invoices->totalCreateInvoices();

		$data['main_content'] = 'invoices/domiciliations';
		$this->load->view('layout/template', $data);
	}

	public function consolidated($action = null, $idBanco = null)
	{
		switch ($action) {

			case 'search':
				$idBanco = $this->input->post('banco');

				if (empty($idBanco)) {
					$this->session->set_flashdata('error', 'Debe llenar el Banco');
					redirect('/invoices/consolidated');
				}

				redirect('/invoices/consolidated/view/' . $idBanco . '');
				break;

			case 'view':

				$data['list'] = $this->model_invoices->searchInvoicesConsolidated("invoices");
				$data['row'] = "invoices";
				break;

			default:
				# code...
				break;
		}
		$data['main_content'] = 'invoices/consolidated';
		$this->load->view('layout/template', $data);
	}

	public function detail($id)
	{
		$data['domiciliation_id'] = $id;
		$data['main_content'] = 'invoices/detail';
		$this->load->view('layout/template', $data);
	}

	/**
	 * Endpoint AJAX para DataTables server-side processing
	 */
	public function detail_ajax($id)
	{
		$draw    = intval($this->input->get('draw'));
		$start   = intval($this->input->get('start'));
		$length  = intval($this->input->get('length'));
		$search  = $this->input->get('search[value]');
		$orderCol = intval($this->input->get('order[0][column]'));
		$orderDir = $this->input->get('order[0][dir]');

		$result = $this->model_invoices->detail_ajax($id, $start, $length, $search, $orderCol, $orderDir);

		$data = [];
		foreach ($result['data'] as $k) {
			// Generar HTML del estatus con colores
			$statusHtml = '';
			switch ($k->status) {
				case 'Pendiente':
					$statusHtml = '<span class="text-primary"><strong>' . $k->status . '</strong></span>';
					break;
				case 'Por Conciliar':
					$statusHtml = '<span class="text-warning"><strong>' . $k->status . '</strong></span>';
					break;
				case 'Conciliado':
				case 'Aprobado':
				case 'Manual':
					$statusHtml = '<span class="text-success"><strong>' . $k->status . '</strong></span>';
					break;
				case 'Anulado':
				case 'Rechazado':
					$statusHtml = '<span class="text-danger"><strong>' . $k->status . '</strong></span>';
					break;
				default:
					$statusHtml = $k->status;
					break;
			}

			$data[] = [
				$k->id,
				$k->bancoName,
				$k->rif,
				$k->afiliado,
				$k->nropos,
				$k->cuota,
				$k->residuo,
				isset($k->excedente) ? $k->excedente : '',
				date('Y-m', strtotime($k->fecha_mes_cobro)),
				$statusHtml,
			];
		}

		$output = [
			'draw'            => $draw,
			'recordsTotal'    => $result['total'],
			'recordsFiltered' => $result['filtered'],
			'data'            => $data,
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	public function generate()
	{
		$postData = $this->input->post();
		$result = $this->model_invoices->insert_in_invoices($postData);

		$this->session->set_flashdata('modal', $result['message']);
		redirect('/invoices/domiciliations');
	}


	public function create()
	{
		$postData = $this->input->post();

		////////////////////////////////
		$bank_api = $this->model_apis->banks($postData['banco']);
		$route = "Storage/domiciliations/" . $bank_api['bank_code'] . "/" . "create/";
		$this->model_invoices->verificar_archivo_pendiente($postData);

		///////////////////////////////////////////////
		$this->createArchive($postData, $route);

		$this->session->set_flashdata('success', 'Creacion de archivo exitosa.');
		redirect('/invoices/domiciliations');
	}

	public function anular()
	{
		$id = $this->input->post('id');
		$observacion = $this->input->post('observacion');

		$add = [
			'status' => "Anulado",
			'observacion' => $observacion,
		];
		$this->parameters->edit($add, $id, "id", "domiciliations");

		$this->session->set_flashdata('success', 'Archivo anulado con exito.');
		redirect('/invoices/domiciliations');
	}

	public function validateDateinsert($fecha_generado)
	{
		$date = date('Y-m-d');

		$fecha_actual = strtotime($date);
		$fecha_entrada = strtotime($fecha_generado);

		if ($fecha_entrada < $fecha_actual) {
			$this->session->set_flashdata('error', 'La fecha ingresada no puede ser menor a la fecha actual.');
			redirect('/invoices/domiciliations');
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function createArchive($postData, $route)
	{
		// Buscar invoices pendientes/rechazadas para el banco y mes/año
		$masive = $this->model_invoices->search_in_invoices($postData);

		if (empty($masive)) {
			$this->session->set_flashdata('error', 'No tiene cobros disponibles para poder generar archivo.');
			redirect('/invoices/domiciliations');
		}

		// Extraer IDs en array
		$ids = array_column($masive, 'id');

		// Insert batch en domiciliations
		$this->model_invoices->insert_archive_batch(
			$postData['banco'],
			"BancoId",
			$route,
			"0.00",
			$postData['fecha_generado'],
			$ids
		);

		$this->session->set_flashdata('success', 'Creacion de archivo exitosa.');
		redirect('/invoices/domiciliations');
	}



	public function test()
	{
		$msn = $this->model_apis->banks();
		echo json_encode($msn);
	}
}
