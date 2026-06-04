<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
		$this->load->model('model_profile');

		//redirect to login off
		if (empty($this->session->userdata['logged_in'])) {
			redirect('login');
		}
	}


	public function index($url)
	{
		switch ($url) {

			case 'profile':
				$this->session->set_flashdata('success', 'Modulo de usuario, Informacion');
				redirect('profile/profile');
				break;
		}
	}

	public function profile()
	{
		$data['info'] = $this->model_profile->info();

		$data['main_content'] = 'profile/profile.php';
		$this->load->view('layout/template', $data);
	}



	public function edit($type = null)
	{
		$id = $this->session->userdata['logged_in']['id'];
		$postData = $this->input->post();

		switch ($type) {

			case 'password':

				if (!$this->model_profile->verificPassword($postData['password'])) {
					$this->session->set_flashdata('error', 'Contraseña Actual erronea, favor verificar.');
					redirect('/profile/profile');
				}

				if ($postData['newpassword'] != $postData['repeat']) {
					$this->session->set_flashdata('error', 'Las contraseñas no coinciden, favor verificar.');
					redirect('/profile/profile');
				}

				if ($postData['password'] == $postData['newpassword']) {
					$this->session->set_flashdata('error', 'La contraseña nueva no puede ser igual a la anterior, favor verificar.');
					redirect('/profile/profile');
				}

				$add = [
					'clave' 		=> $this->passEncrypt($postData['newpassword']),
				];
				$this->parameters->edit($add, $id, "id", "usuarios");

				$this->session->set_flashdata('success', 'Modificacion realizada con exito');
				redirect('/profile/profile');
				break;

			case 'mobile':

				$this->noRepeatDates($postData);

				$add = [
					'movil' => $postData['movil'],
				];
				$this->parameters->edit($add, $id, "id", "usuarios");

				$this->session->set_flashdata('success', 'Modificacion realizada con exito');
				redirect('/profile/profile');
				break;

			default:
				$this->session->set_flashdata('error', 'Funcion no valida en el sistema.');
				redirect('/profile/profile');
				break;
		}
	}

	public function passEncrypt($password)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
		return $hash;

		//return password_hash($text, PASSWORD_DEFAULT);
	}

	function noRepeatDates($postData)
	{
		$error = "";
		$result = $this->model_profile->noRepeatDates($postData['movil']);
		if (!empty($result['movil']))	$error = $error . "El movil se encuentra en uso <br>";

		if (!empty($error)) {
			$this->session->set_flashdata('error', $error);
			redirect('/profile/profile');
		}
	}
}
