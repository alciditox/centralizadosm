<?php
defined('BASEPATH') or exit('No direct script access allowed');
//session_start(); //we need to start session in order to access it through CI

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Load helper
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('url');
		// Load library
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('email');
		// Load database
		$this->load->model('parameters');
		$this->load->model('Permissions');
		$this->load->model('model_login');
		$this->load->model('model_administrator');
	}

	public function index()
	{
		$this->load->view('login');
	}


	// Check for user login process
	public function user_login_process()
	{

		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			if (isset($this->session->userdata['logged_in'])) {
				//$this->load->view('admin_page');
				redirect('/dashboar');
			} else {
				$this->session->set_flashdata('warning', 'Error en los datos subministrados');
				redirect('/login');
			}
		} else {

			$data = array(
				'username' => $this->input->post('email'),
				'password' => $this->input->post('password'),
			);

			if ($this->model_login->login($data) == TRUE) {

				$result = $this->model_login->read_user_information($data);
				if ($result != false) {

					$session_data = array(
						'id' 		=> $result[0]->id,
						'nombre' 	=> $result[0]->nombre,
						'correo' 	=> $result[0]->correo,
						'usuario' 	=> $result[0]->usuario,
						'rol' 		=> $result[0]->codigo,
						'tipo' 		=> $result[0]->tipo,
						'user_key' 	=> $result[0]->user_key,
					);

					// Add user data in session
					$this->session->set_userdata('logged_in', $session_data);
					$this->session->set_flashdata('success', 'Bienvenido ' . $session_data['nombre'] . ', Ingreso exitoso');
					redirect('/dashboard');
				}
			} else {
				$this->session->set_flashdata('error', 'Error en los datos subministrados');
				redirect('/login');
			}
		}
	}

	// Logout from admin page
	public function logout()
	{
		// Removing session data
		$sess_array = array(
			'id' 		=> '',
			'nombre' 	=> '',
			'correo' 	=> '',
			'usuario' 	=> '',
			'rol' 		=> '',
			'tipo' 		=> '',
			'user_key' 	=> '',
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$this->session->sess_destroy();
		redirect('login/exit');
	}

	public function exit()
	{
		$this->session->set_flashdata('success', 'Cierre de sesion exitoso.');
		redirect('login');
	}


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function signup()
	{
		$this->load->view('signup');
	}

	public function add()
	{
		$postData = $this->input->post();
		$this->noRepeatDates($postData);

		$createPass = $this->createPass();
		$add = [
			'usuario' 		=> $postData['correo'],
			'nombre' 		=> $postData['nombre'] . " " . $postData['apellido'],
			'movil' 		=> $postData['movil'],
			'correo' 		=> $postData['correo'] . $postData['dominio'],
			'status' 		=> "Activo",
			'rol' 			=> "17",
			'clave' 		=> $this->passEncrypt($createPass),
			'user_key' 		=> $this->createUserKey(),
		];
		$return = $this->parameters->addReturID($add, "usuarios");

		if ($return == false) {
			$this->session->set_flashdata('danger', 'No se pudo crear la cuenta, contactar con el administrador de sistemas.');
			redirect('/login/signup');
		} else {
			$this->session->set_flashdata('success', 'Cuenta creada de manera exitosa <br> Verificar su correo de confirmaci&oacute;n');
			redirect('/login');
		}
	}

	function noRepeatDates($postData)
	{
		$error = "";
		$result = $this->model_login->noRepeatDates($postData['correo'] . $postData['dominio'], $postData['movil']);
		if (!empty($result['email']))	$error = $error . "El correo se encuentra en uso <br>";
		if (!empty($result['movil'])) $error = $error . "El movil se encuentra en uso <br>";

		//////////////////////////////////////////////////////////////
		if (filter_var($postData['correo'] . $postData['dominio'], FILTER_VALIDATE_EMAIL)) {
		} else {
			$error = $error . "El correo que intenta ingresar no es correcto.";
		}
		//////////////////////////////////////////////////////////////

		if (!empty($error)) {
			$this->session->set_flashdata('error', $error);
			redirect('/login/signup');
		}
	}

	function createUserKey()
	{
		$z = 1;
		while ($z <= 5) {

			$length = 15;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';

			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}

			$verify = $this->model_login->noRepeatUserKey($randomString);
			if ($verify == true) {
				break;
			}
		}
		return $randomString;
	}


	function createPass()
	{
		$z = 1;
		while ($z <= 5) {

			$length = 8;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';

			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			break;
		}
		return $randomString;
	}

	public function passEncrypt($password)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
		return $hash;

		//return password_hash($text, PASSWORD_DEFAULT);
	}
}
