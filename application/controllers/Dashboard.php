<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$this->load->model('model_dashboard');
	}

	// -----------------------------------------------------------------------

	/**
	 * 
	 * 
	 */
	public function index()
	{
		//$data['list'] = $this->model_dashboard->conteo();
		$data['list'] = "";
		$data['main_content'] = 'dashboard.php';
		$this->load->view('layout/template', $data);
	}
}
