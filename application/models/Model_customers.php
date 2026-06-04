<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_customers extends CI_Model
{

	public function search_invoices($contrato)
	{
		$this->db->from('invoices');
		$this->db->where('contract_id', $contrato);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function search_collections($invoice_id)
	{
		$this->db->from('collections');
		$this->db->where('invoice_id', $invoice_id);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
}
