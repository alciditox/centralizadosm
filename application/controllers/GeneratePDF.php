<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

require APPPATH . '/libraries/dompdf/autoload.inc.php';

class GeneratePDF extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Load library
		$this->load->library('pdf');
		$this->load->model('model_apis');
		$this->load->model('model_invoices');
	}

	public function index()
	{
		$html = $this->load->view('GeneratePDF/GeneratePdfView', [], true);
		$this->pdf->createPDF($html, 'mypdf', false);
	}

	public function statements($add = null)
	{
		$explode = explode("_", $add);
		$customer_id = $explode[0];
		$contrato = $explode[1];

		$data = [
			'api'          => $this->model_apis->CustomerCrmId($customer_id),
			'contratos'    => $this->model_invoices->detailInvoices($contrato),
		];
		$html = $this->load->view('GeneratePDF/detailInvoices', $data, true);
		$this->pdf->createPDF($html, 'notaEntrega', false);
	}

	public function notaEntrega($rif = null)
	{

		$apiReq = $this->model_apis->apiCustomer($rif);
		$data['api'] = $apiReq;
		$data['contratos'] = $this->model_apis->apiContracts($apiReq['id']);

		$html = $this->load->view('GeneratePDF/notaEntrega', $data, true);
		$this->pdf->createPDF($html, 'notaEntrega', false);
	}
}
