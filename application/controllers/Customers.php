<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Load helper
		$this->load->helper('url');
		$this->load->helper('form');
		// Load library
		$this->load->library('session');
		$this->load->library('email');
		// Load database
		$this->load->model('parameters');
		$this->load->model('Permissions');
		$this->load->model('model_apis');
		$this->load->model('model_customers');
	}

	public function statements($variable = null)
	{
		switch ($variable) {
			case 'rif':
				$postData = $this->input->post();

				$apiReq = $this->model_apis->apiCustomer($postData['rif']);
				if (!isset($apiReq)) {
					$this->session->set_flashdata('error', 'Cliente no entrado o no existe');
					redirect('customers/statements');
				}
				$contratos = $this->model_apis->apiContracts($apiReq['id']);

				$data = [
					'api'          => $apiReq,
					'contratos'    => $contratos,
					'main_content' => 'customers/statements.php'
				];
				$this->load->view('layout/template', $data);
				break;

			case 'contrato':
				$postData = $this->input->post();

				$apiReq = $this->model_apis->apiBuscoClienteXContrato($postData['contrato']);
				if (!isset($apiReq)) {
					$this->session->set_flashdata('error', 'Cliente no entrado o no existe');
					redirect('customers/statements');
				}
				$contratos = $this->model_apis->apiContracts($apiReq['id']);

				$data = [
					'api'          => $apiReq,
					'contratos'    => $contratos,
					'main_content' => 'customers/statements.php'
				];
				$this->load->view('layout/template', $data);
				break;

			default:
				$data['main_content'] = 'customers/statements.php';
				$this->load->view('layout/template', $data);
				break;
		}

		/*if (!isset($apiReq)) {
			$this->session->set_flashdata('error', 'Cliente no entrado o no existe');
			redirect('customers/register');
		}*/
	}

	/*public function register()
	{
		$data['main_content'] = 'customers/statements.php';
		$this->load->view('layout/template', $data);
	}*/

	public function invoices($contrato = null)
	{
		$data = [
			'list'          => $this->model_customers->search_invoices($contrato),
			'main_content' => 'customers/invoices.php'
		];
		$this->load->view('layout/template', $data);
	}

	public function collections($invoices = null)
	{
		$data = [
			'list'          => $this->model_customers->search_collections($invoices),
			'main_content' => 'customers/collections.php'
		];
		$this->load->view('layout/template', $data);
	}
}
