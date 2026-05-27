<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_login extends CI_Model
{


	// Read data using username and password
	public function login($data)
	{
		$condition = "correo =" . "'" . $data['username'] . "' AND status='Activo' ";
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $this->passVerify($row->clave, $data['password'], $row->id);
		} else {
			return false;
		}
	}

	//VERIFICO Y CREO EL HASH DE CLAVE ENCRIPTADA
	public function passVerify($db_pass, $send_pass, $id_usuario)
	{

		//VERIFICA CANTIDAD DE INTENTOS FALLIDOS
		$this->intentosFallidos($id_usuario);

		if (password_verify($send_pass, $db_pass)) {
			return true;
		} else {
			//AGREGA A INTENTOS FALLIDOS POR ERROR EN CLAVE
			$add = ['id_usuario' => $id_usuario, 'accion' => 'Fallidos'];
			$this->db->insert("usuarios_intentos", $add);
			return false;
		}
	}


	//VERIFICO SI TIENE EL LIMITE DE INTENTOS FALLIDOS
	public function intentosFallidos($id_usuario)
	{
		$sql = " SELECT id FROM usuarios_intentos  WHERE id_usuario='$id_usuario' AND accion='Fallidos' ";
		$query = $this->db->query($sql);

		if ($query->num_rows() >= 3) {
			$this->session->set_flashdata('error', 'Usuario bloqueado por exceso de intentos fallidos.');
			redirect('/login');
		}
	}


	// Read data from database to show data in admin page
	public function read_user_information($data)
	{
		$username = $data['username'];
		$sql = " SELECT usu.id, usu.correo, usu.usuario, usu.user_key, usu.nombre,
						rol.codigo, rol.tipo
				 FROM usuarios usu 
				 INNER JOIN roles rol ON rol.codigo = usu.rol
				 WHERE correo='$username'
				 LIMIT 1 ";

		$query = $this->db->query($sql);

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function noRepeatDates($correo, $movil)
	{
		$this->db->select("(SELECT movil FROM usuarios WHERE movil='$movil' LIMIT 1) AS movil");
		$this->db->select("uno.correo");
		$this->db->from('usuarios uno');
		$this->db->where('uno.correo', $correo);
		$this->db->limit(1);
		$query = $this->db->get();
		$row = $query->row();

		return ['email' => $row->correo, 'movil' => $row->movil];
	}

	public function noRepeatUserKey($value)
	{
		$this->db->select("*");
		$this->db->from('usuarios');
		$this->db->where('user_key', $value);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return false;
		} else {
			return true;
		}
	}
}
