<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_profile extends CI_Model
{

	public function info()
	{
		$this->db->select('usu.*, rol.tipo AS departamento');
		$this->db->from('usuarios usu');
		$this->db->join('roles rol', 'usu.rol = rol.codigo', 'left');
		$this->db->where('usu.id', $this->session->userdata['logged_in']['id']);
		$query = $this->db->get();
		return $query->row();
	}

	// Read data using username and password
	public function verificPassword($password)
	{
		$this->db->select('clave');
		$this->db->from('usuarios');
		$this->db->where("id", $this->session->userdata['logged_in']['id']);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $this->passVerify($row->clave, trim($password));
		} else {
			return false;
		}
	}

	//VERIFICO Y CREO EL HASH DE CLAVE ENCRIPTADA
	public function passVerify($db_pass, $send_pass)
	{
		if (password_verify($send_pass, $db_pass)) {
			return true;
		} else {
			return false;
		}
	}

	public function noRepeatDates($movil)
	{
		$this->db->select("movil");
		$this->db->from('usuarios');
		$this->db->where('movil', $movil);
		$this->db->limit(1);
		$query = $this->db->get();
		$row = $query->row();

		return ['movil' => $row->movil];
	}
}
