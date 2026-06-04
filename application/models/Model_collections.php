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

	/* ---------------------------------------------------
	   CONSOLIDADO DE PAGOS PROCESADOS
	   --------------------------------------------------- */

	private $_cp_columns = [
		0  => 'i.id',
		1  => 'i.contract_id',
		2  => 'i.banco',
		3  => 'i.cuenta',
		4  => 'i.rif',
		5  => 'i.razon',
		6  => 'i.afiliado',
		7  => 'i.periodicidad',
		8  => 'i.nropos',
		9  => 'i.status',
		10 => 'c.fecha_generado',
		11 => 'c.fecha_conciliado',
		12 => 'c.fecha_procesado',
		13 => 'c.tasa',
		14 => 'c.monto',
		15 => 'c.usd',
		16 => 'c.nropos',
	];

	/**
	 * Aplica filtros y búsqueda al Query Builder (reutilizable)
	 */
	private function _cp_apply_filters($postData, $withSearch = true)
	{
		$this->db->from('invoices i');
		$this->db->join('collections c', 'c.invoice_id = i.id', 'left');

		if (!empty($postData['fecha_desde'])) {
			$this->db->where('i.fecha_mes_cobro >=', $postData['fecha_desde']);
		}
		if (!empty($postData['fecha_hasta'])) {
			$this->db->where('i.fecha_mes_cobro <=', $postData['fecha_hasta']);
		}
		if (!empty($postData['banco'])) {
			$this->db->where('i.banco', $postData['banco']);
		}
		if (!empty($postData['status'])) {
			$this->db->where('i.status', $postData['status']);
		}

		if ($withSearch) {
			$searchValue = isset($postData['search']['value']) ? $postData['search']['value'] : '';
			if (!empty($searchValue)) {
				$this->db->group_start();
				$this->db->like('i.id', $searchValue);
				$this->db->or_like('i.contract_id', $searchValue);
				$this->db->or_like('i.rif', $searchValue);
				$this->db->or_like('i.razon', $searchValue);
				$this->db->or_like('i.afiliado', $searchValue);
				$this->db->or_like('i.nropos', $searchValue);
				$this->db->or_like('i.cuenta', $searchValue);
				$this->db->or_like('i.status', $searchValue);
				$this->db->group_end();
			}
		}
	}

	/**
	 * Datos paginados para DataTables server-side
	 */
	public function get_consolidado_procesado($postData)
	{
		$this->db->select('
			i.id, i.contract_id, i.banco, i.cuenta, i.rif, i.razon,
			i.afiliado, i.periodicidad, i.nropos, i.status,
			c.fecha_generado  AS c_fecha_generado,
			c.fecha_conciliado AS c_fecha_conciliado,
			c.fecha_procesado  AS c_fecha_procesado,
			c.tasa  AS c_tasa,
			c.monto AS c_monto,
			c.usd   AS c_usd,
			c.nropos AS c_nropos
		');

		$this->_cp_apply_filters($postData);

		// Orden
		if (isset($postData['order'][0])) {
			$colIdx = intval($postData['order'][0]['column']);
			$dir    = ($postData['order'][0]['dir'] === 'desc') ? 'DESC' : 'ASC';
			$col    = isset($this->_cp_columns[$colIdx]) ? $this->_cp_columns[$colIdx] : 'i.id';
			$this->db->order_by($col, $dir);
		} else {
			$this->db->order_by('i.id', 'DESC');
		}

		// Paginación
		$start  = isset($postData['start'])  ? intval($postData['start'])  : 0;
		$length = isset($postData['length']) ? intval($postData['length']) : 25;
		if ($length > 0) {
			$this->db->limit($length, $start);
		}

		return $this->db->get()->result();
	}

	/**
	 * Conteo total (con filtros del form, sin búsqueda DataTables)
	 * Optimizado: solo tabla invoices, sin LEFT JOIN
	 */
	public function count_consolidado_procesado($postData)
	{
		$this->db->from('invoices');

		if (!empty($postData['fecha_desde'])) {
			$this->db->where('fecha_mes_cobro >=', $postData['fecha_desde']);
		}
		if (!empty($postData['fecha_hasta'])) {
			$this->db->where('fecha_mes_cobro <=', $postData['fecha_hasta']);
		}
		if (!empty($postData['banco'])) {
			$this->db->where('banco', $postData['banco']);
		}
		if (!empty($postData['status'])) {
			$this->db->where('status', $postData['status']);
		}

		return $this->db->count_all_results();
	}

	/**
	 * Conteo filtrado (con filtros del form + búsqueda DataTables)
	 */
	public function count_filtered_consolidado_procesado($postData)
	{
		$this->_cp_apply_filters($postData, true);
		return $this->db->count_all_results();
	}

	/**
	 * Todos los registros (sin paginar) para exportar a Excel
	 */
	public function get_consolidado_procesado_all($postData)
	{
		$this->db->select('
			i.id, i.contract_id, i.banco, i.cuenta, i.rif, i.razon,
			i.afiliado, i.periodicidad, i.nropos, i.status,
			c.fecha_generado  AS c_fecha_generado,
			c.fecha_conciliado AS c_fecha_conciliado,
			c.fecha_procesado  AS c_fecha_procesado,
			c.tasa  AS c_tasa,
			c.monto AS c_monto,
			c.usd   AS c_usd,
			c.nropos AS c_nropos
		');

		$this->_cp_apply_filters($postData, false);
		$this->db->order_by('i.id', 'DESC');

		return $this->db->get()->result();
	}
}
