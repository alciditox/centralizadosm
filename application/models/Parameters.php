<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parameters extends CI_Model
{
	public function webConfigurations()
	{
		$this->db->from('web_configurations');
		$this->db->where("id = '1' ");
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	public function deleteFallidos($tabla, $columna, $valor)
	{
		$this->db->where($columna, $valor);
		$this->db->where("accion", "Fallidos");
		$this->db->delete($tabla);
	}

	function addReturID($add, $tabla)
	{
		if ($this->db->insert($tabla, $add)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function editReturn($add, $id, $columna, $table)
	{
		if ($this->db->where($columna, $id)->update($table, $add)) {
			return true;
		} else {
			return false;
		}
	}

	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////

	public function edit($data, $id, $field, $table)
	{
		$this->db->where($field, $id);
		return $this->db->update($table, $data);
	}

	public function add($data, $table)
	{
		return $this->db->insert($table, $data);
	}

	public function get_by_id($table, $id)
	{
		return $this->db->where("id", $id)->get($table)->row();
	}

	public function delete($tabla, $columna, $valor)
	{
		$this->db->where($columna, $valor);
		$this->db->delete($tabla);
	}
}
