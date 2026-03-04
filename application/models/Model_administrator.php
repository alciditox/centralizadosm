<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_administrator extends CI_Model
{
	public function users()
	{
		$this->db->select('usu.id, usu.usuario, usu.nombre, usu.clave, usu.correo, usu.movil, usu.status, usu.rol');
		$this->db->select("(SELECT count(id) FROM usuarios_intentos WHERE id_usuario=usu.id AND accion='Fallidos') AS fallidos");
		$this->db->select('rol.tipo AS tipo');
		$this->db->from('usuarios usu');
		$this->db->join('roles rol', 'rol.codigo = usu.rol', 'left');
		$this->db->order_by('usu.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function rols()
	{
		$this->db->from('roles');
		$this->db->where('status', 'Activo');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
	///////////////////////////////////////////////
	///////////////////////////////////////////////
	public function webConfigure()
	{
		$this->db->from('web_configurations');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	public function webDatatable($id)
	{
		$this->db->from('web_configurations');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	///////////////////////////////////////////////
	///////////////////////////////////////////////
	public function menuConfigure()
	{
		$this->db->from('menu');
		$query = $this->db->get();
		return $query->result();
	}

	public function menuDatatable($id)
	{
		$this->db->from('menu');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	///////////////////////////////////////////////
	///////////////////////////////////////////////
	public function rols_all()
	{
		$this->db->select('rols.*');
		$this->db->select("(SELECT COUNT(id) FROM usuarios WHERE rol=rols.codigo) AS agentes");
		$this->db->from('roles rols');
		$this->db->order_by('rols.id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function count_rols()
	{
		$this->db->select('count(*) AS conteo');
		$this->db->from('roles');
		$query = $this->db->get();
		$row = $query->row();
		return $row->conteo + 1;
	}

	public function existe_correo($correo = null, $usuario = null, $id = null)
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		if (!empty($correo)) $this->db->where('correo', $correo);
		if (!empty($usuario)) $this->db->where('usuario', $usuario);
		if (!empty($id)) {
			$this->db->where("id <> '" . $id . "'");
		}
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function menuUno()
	{
		$this->db->from('menu');
		$this->db->where('parent IS NULL');
		$this->db->order_by('id', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}

	public function menuDos()
	{
		$this->db->from('menu');
		$this->db->where('parent IS  NOT NULL');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function roles_permisos_menu($rol)
	{

		$this->db->select(' menu_id, rol_id');
		$this->db->from('roles_permisos');
		$this->db->where('rol_id = ' . $rol);
		$query = $this->db->get();
		return $query->result();
	}
}
