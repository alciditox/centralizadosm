<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{

	public function historial()
	{
		$user_id = $this->session->userdata['logged_in']['id'];
		$user_key = $this->session->userdata['logged_in']['user_key'];

		$this->db->from('crediticio');
		$this->db->where('user_id', $user_id);
		$this->db->where('user_key', $user_key);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function conteo()
	{
		$this->db->select('status, count(status) AS conteo');
		$this->db->from('requests');
		$this->db->group_by('status');
		$query = $this->db->get();
		return $query->result();
	}

	public function sum()
	{
		$user_id = $this->session->userdata['logged_in']['id'];
		$user_key = $this->session->userdata['logged_in']['user_key'];

		$this->db->select('sum(amount) AS amount');
		$this->db->select('sum(blocked) AS blocked');
		$this->db->from('accounts');
		$this->db->where('user_id', $user_id);
		$this->db->where('user_key', $user_key);
		$query = $this->db->get();
		return $query->row();
	}
}
