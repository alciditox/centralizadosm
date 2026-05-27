<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parametros extends CI_Controller
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
		$this->load->model('model_parametros');
	}

	// -----------------------------------------------------------------------

	/**
	 * 
	 * 
	 */
	public function users($type = null)
	{
		//SE VERIFICA PERMISO DE ENTRADA EBN EL MODULO
		$this->Permissions->call("2");

		$data['users'] = $this->model_administrator->users();
		$data['rols'] = $this->model_administrator->rols();
		$correo = $this->input->post('correo');

		switch ($type) {
			case 'add':

				$existe_correo = $this->model_administrator->existe_correo($correo);
				if (!empty($existe_correo)) {
					$this->session->set_flashdata('error', 'El correo ya se encuentra en uso con otro usuario');
					redirect('/administrator/users');
				}

				$add = [
					'nombre' 		=> $this->input->post('nombre'),
					'usuario' 		=> $this->input->post('usuario'),
					'correo' 		=> $correo,
					'movil' 		=> $this->input->post('movil'),
					'status' 		=> $this->input->post('status'),
					'rol' 			=> $this->input->post('rol'),
					'clave' 		=> $this->passEncrypt($this->input->post('clave')),
					'user_key' 		=> $this->createUserKey(),
				];

				$this->parameters->add($add, "usuarios");

				////////////////////////////////////////////////////////////////////
				$wcon = $this->parameters->webConfigurations();

				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				$this->session->set_flashdata('success', 'usuario creado de manera exitoza');
				redirect('/administrator/users');
				return;
				break;

			case 'edit':

				$id = $this->input->post('id');
				$clave = $this->input->post('clave');

				$existe_correo = $this->model_administrator->existe_correo($correo, $id);
				if (!empty($existe_correo)) {
					$this->session->set_flashdata('error', 'El correo ya se encuentra en uso con otro usuario');
					redirect('/administrator/users');
				}

				$add = [
					'nombre' 		=> $this->input->post('nombre'),
					'usuario' 		=> $this->input->post('usuario'),
					'correo' 		=> $correo,
					'movil' 		=> $this->input->post('movil'),
					'status' 		=> $this->input->post('status'),
					'rol' 			=> $this->input->post('rol'),
				];
				$this->parameters->edit($add, $id, "id", "usuarios");

				if (!empty($clave)) {
					$add = [
						'clave' 		=> $this->passEncrypt($clave),
					];
					$this->parameters->edit($add, $id, "id", "usuarios");

					////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				}

				$this->session->set_flashdata('success', 'Usuario Modificado de manera exitosa');
				redirect('/administrator/users');
				return;
				break;

			case 'reset':
				$postData = $this->input->post();
				$this->parameters->deleteFallidos("usuarios_intentos", "id_usuario", $postData['id']);

				$createPass = $this->createPass();
				$add = [
					'clave' => $this->passEncrypt($createPass),
				];
				$this->parameters->edit($add, $this->input->post('id'), "id", "usuarios");

				////////////////////////////////////////////////////////////////////

				//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				$this->session->set_flashdata('success', 'Usuarios reseteado con exito');
				redirect('/administrator/users');
				return;
				break;

			default:
				break;
		}

		$data['main_content'] = 'administrator/users.php';
		$this->load->view('layout/template', $data);
	}

	public function roles($type = null)
	{
		//SE VERIFICA PERMISO DE ENTRADA EBN EL MODULO
		$this->Permissions->call("3");

		$data['rols'] = $this->model_administrator->rols_all();
		$data['count_rols'] = $this->model_administrator->count_rols();

		switch ($type) {
			case 'add':
				$add = [
					'codigo' 	=> $this->input->post('codigo'),
					'tipo' 		=> $this->input->post('tipo'),
					'status' 	=> $this->input->post('status'),
				];
				$this->parameters->add($add, "roles");
				$this->session->set_flashdata('success', 'Rol creado de manera exitosa.');
				redirect('/administrator/roles');
				break;

			case 'view':

				$data['id'] = $this->input->post('id');
				$data['tipo'] = $this->input->post('tipo');
				$data['codigo'] = $this->input->post('codigo');
				$data['status'] = $this->input->post('status');
				$data['agentes'] = $this->input->post('agentes');

				$data['menuUno'] = $this->model_administrator->menuUno();
				$data['menuDos'] = $this->model_administrator->menuDos();

				$data['rpm'] = $this->model_administrator->roles_permisos_menu($this->input->post('codigo'));

				$data['main_content'] = 'administrator/modals/roles_edit.php';
				$this->load->view('layout/template', $data);
				return;
				break;

			case 'edit':
				$id = $this->input->post('id');
				$codigo = $this->input->post('codigo');
				$add = [
					'tipo' 		=> $this->input->post('tipo'),
					'status' 	=> $this->input->post('status'),
				];
				$this->parameters->edit($add, $id, "id", "roles");

				$menu_id = $this->input->post('menu_id');

				$this->parameters->delete("roles_permisos", "rol_id", $codigo);

				for ($i = 0; $i < sizeof($menu_id); $i++) {
					$add = array('menu_id' => $menu_id[$i], 'rol_id' => $codigo);
					$this->db->insert('roles_permisos', $add);
				}

				$this->session->set_flashdata('success', 'Proceso realizado con exito.');
				redirect('/administrator/roles');
				break;

			default:
				# code...
				break;
		}

		$data['main_content'] = 'administrator/roles.php';
		$this->load->view('layout/template', $data);
	}

	public function webConfigure($type = null)
	{
		//SE VERIFICA PERMISO DE ENTRADA EBN EL MODULO
		$this->Permissions->call("4");

		$data['webConfigure'] = $this->model_administrator->webConfigure();

		$postData = $this->input->post();

		switch ($type) {
			case 'add':
				break;

			case 'view':
				$data['main_content'] = 'administrator/modals/webConfigure_edit.php';
				$this->load->view('layout/template', $data);
				return;
				break;

			case 'edit':
				$add = [
					'tittle' 	=> $postData['tittle'],
					'name' 		=> $postData['name'],
					'email' 	=> $postData['email'],
					'web' 		=> $postData['web'],
					'url' 		=> $postData['url'],
				];
				$this->parameters->edit($add, $postData['id'], "id", "web_configurations");

				$this->session->set_flashdata('success', 'Proceso realizado con exito.');
				redirect('/administrator/webConfigure');
				break;

			default:
				# code...
				break;
		}

		$data['main_content'] = 'administrator/webConfigure.php';
		$this->load->view('layout/template', $data);
	}

	public function menuConfigure($type = null)
	{
		//SE VERIFICA PERMISO DE ENTRADA EBN EL MODULO
		$this->Permissions->call("5");

		$data['menuConfigure'] = $this->model_administrator->menuConfigure();

		$postData = $this->input->post();

		switch ($type) {
			case 'add':
				$parent = $postData['parent'];
				if (empty($parent)) $parent = NULL;
				$add = [
					'nombre' 	=> $postData['nombre'],
					'url' 		=> $postData['url'],
					'parent' 	=> $parent,
					'icon' 		=> $postData['fabicon'],
					'status' 	=> $postData['status'],
				];
				$this->parameters->add($add, "menu");
				$this->session->set_flashdata('success', 'Proceso realizado con exito.');
				redirect('/administrator/menuConfigure');
				break;

			case 'edit':
				$parent = $postData['parent'];
				if (empty($parent)) $parent = NULL;
				$add = [
					'nombre' 	=> $postData['nombre'],
					'url' 		=> $postData['url'],
					'parent' 	=> $parent,
					'icon' 		=> $postData['fabicon'],
					'status' 	=> $postData['status'],
				];
				$this->parameters->edit($add, $postData['id'], "id", "menu");

				$this->session->set_flashdata('success', 'Proceso realizado con exito.');
				redirect('/administrator/menuConfigure');
				break;

			default:
				# code...
				break;
		}

		$data['main_content'] = 'administrator/menuConfigure.php';
		$this->load->view('layout/template', $data);
	}

	public function rols()
	{
		$resp = $this->model_administrator->rols();
		echo json_encode($resp);
	}

	public function webDatatable($id)
	{
		$resp = $this->model_administrator->webDatatable($id);
		echo json_encode($resp);
	}

	public function menuDatatable($id)
	{
		$resp = $this->model_administrator->menuDatatable($id);
		echo json_encode($resp);
	}

	public function status()
	{
		$status = '[
			{"status":"Activo"},
			{"status":"Inactivo"}
			]';
		echo $status;
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

	public function passEncrypt($password)
	{
		$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
		return $hash;

		//return password_hash($text, PASSWORD_DEFAULT);
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
}
