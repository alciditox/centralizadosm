<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_collections extends CI_Model
{

	/* ---------------------------------------------------
   EVITAR DUPLICADOS EN COLLECTIONS
   --------------------------------------------------- */
	public function existe_collection($afiliado, $nropos, $fecha_generado)
	{
		$this->db->from("collections");
		$this->db->where("afiliado", $afiliado);
		$this->db->where("nropos", $nropos);
		$this->db->where("DATE_FORMAT(fecha_generado, '%Y-%m-%d') =", $fecha_generado);
		return $this->db->get()->num_rows() > 0;
	}

	// Buscar invoice por afiliado, nropos y mes/año
	public function buscar_por_codafi($codafi, $nropos, $fecha_generado)
	{
		$codafi = trim((string)$codafi);
		$nropos = trim((string)$nropos);

		if ($codafi === '' || $nropos === '') return null;

		$ym = date('Y-m', strtotime($fecha_generado));

		$this->db->from('invoices');
		$this->db->where('afiliado', $codafi);
		$this->db->where('nropos', $nropos);
		$this->db->like('fecha_mes_cobro', $ym, 'after'); // YYYY-MM%
		return $this->db->get()->row_array();
	}

	// Contar invoices por mes/año
	public function contar_por_fecha($fecha)
	{
		$ym = date('Y-m', strtotime($fecha));

		$this->db->like('fecha_mes_cobro', $ym, 'after'); // YYYY-MM%
		return $this->db->count_all_results('invoices');
	}

	public function search_domiciliations_archive($postData)
	{
		$this->db->from('domiciliations');
		$this->db->where('id', $postData['id']);
		$this->db->where('banco', $postData['banco']);
		$this->db->where('fecha_generado', $postData['fecha_generado']);
		$result = $this->db->get()->row();

		return $result ? $result->recived : null;
	}
}
