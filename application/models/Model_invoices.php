<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_invoices extends CI_Model
{
	public function banks()
	{
		$this->db->from('banks');
		$this->db->where('estatus', 'Activo');
		$query = $this->db->get();
		return $query->result();
	}

	public function detailInvoices($contract_id)
	{
		$this->db->select('*');
		$this->db->from('invoices');
		$this->db->where('contract_id', $contract_id);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*public function totalCreateInvoices()
	{
		$sql = " 
			SELECT bank.description, count(collection.banco) AS cantidad 
			FROM `invoices` collection
			left join banks bank on collection.banco = bank.id
			WHERE collection.monto IS NULL
			AND collection.fecha_generado IS NULL
			GROUP by banco;
			";
		$query = $this->db->query($sql);
		return $query->result();
	}*/

	public function detail($id)
	{
		// Obtener datos de la tabla domiciliations
		$this->db->select('banco, fecha_generado, fecha_conciliado, numcobro');
		$this->db->from('domiciliations');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$row = $query->row();

		if (!$row) {
			return FALSE;
		}

		// Convertir numcobro a array de IDs limpios (sin comillas)
		$ids = array_filter(array_map(function ($v) {
			return trim($v, " '\""); // elimina espacios y comillas
		}, explode(',', $row->numcobro)));

		if (empty($ids)) {
			return [];
		}

		// Tamaño del chunk
		$chunkSize = 300;
		$chunks = array_chunk($ids, $chunkSize);

		// Construcción de la consulta
		$this->db->select('invoice.*');
		$this->db->select('ban.description AS bancoName');
		$this->db->from('invoices invoice');
		$this->db->join('banks ban', 'ban.id = invoice.banco');

		// Aplicar where_in por bloques
		foreach ($chunks as $c) {
			$this->db->or_where_in('invoice.id', $c);
		}

		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Obtener detalle paginado para DataTables AJAX server-side
	 */
	public function detail_ajax($id, $start, $length, $search = '', $orderCol = 0, $orderDir = 'asc')
	{
		// Obtener IDs de domiciliations
		$this->db->select('numcobro');
		$this->db->from('domiciliations');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$row = $query->row();

		if (!$row) {
			return ['data' => [], 'total' => 0, 'filtered' => 0];
		}

		$ids = array_filter(array_map(function ($v) {
			return trim($v, " '\"");
		}, explode(',', $row->numcobro)));

		if (empty($ids)) {
			return ['data' => [], 'total' => 0, 'filtered' => 0];
		}

		$chunkSize = 300;
		$chunks = array_chunk($ids, $chunkSize);

		// --- Total sin filtro ---
		$this->db->from('invoices invoice');
		$this->db->join('banks ban', 'ban.id = invoice.banco');
		foreach ($chunks as $c) {
			$this->db->or_where_in('invoice.id', $c);
		}
		$total = $this->db->count_all_results();

		// --- Columnas mapeadas para orden y búsqueda ---
		$columnMap = [
			0 => 'invoice.id',
			1 => 'ban.description',
			2 => 'invoice.rif',
			3 => 'invoice.afiliado',
			4 => 'invoice.nropos',
			5 => 'invoice.cuota',
			6 => 'invoice.residuo',
			7 => 'invoice.excedente',
			8 => 'invoice.fecha_mes_cobro',
			9 => 'invoice.status',
		];

		// --- Consulta con filtro de búsqueda ---
		$this->db->select('invoice.*, ban.description AS bancoName');
		$this->db->from('invoices invoice');
		$this->db->join('banks ban', 'ban.id = invoice.banco');

		// where_in por bloques
		if (count($chunks) == 1) {
			$this->db->where_in('invoice.id', $chunks[0]);
		} else {
			$this->db->group_start();
			foreach ($chunks as $c) {
				$this->db->or_where_in('invoice.id', $c);
			}
			$this->db->group_end();
		}

		// Filtro de búsqueda
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('invoice.id', $search);
			$this->db->or_like('ban.description', $search);
			$this->db->or_like('invoice.rif', $search);
			$this->db->or_like('invoice.afiliado', $search);
			$this->db->or_like('invoice.nropos', $search);
			$this->db->or_like('invoice.cuota', $search);
			$this->db->or_like('invoice.status', $search);
			$this->db->group_end();
		}

		// Total filtrado
		$filteredQuery = clone $this->db;
		$filtered = $this->db->count_all_results('', false);

		// Orden
		$orderColumn = isset($columnMap[$orderCol]) ? $columnMap[$orderCol] : 'invoice.id';
		$this->db->order_by($orderColumn, $orderDir === 'desc' ? 'DESC' : 'ASC');

		// Paginación
		$this->db->limit($length, $start);
		$query = $this->db->get();

		return [
			'data'     => $query->result(),
			'total'    => $total,
			'filtered' => $filtered,
		];
	}

	public function anular($add, $id, $columna, $table)
	{
		$this->db->where($columna, $id);
		$this->db->update($table, $add);
	}

	public function insert_in_invoices($postData)
	{
		// 1) Último día del mes y formato YYYY-MM
		$last_day   = date('Y-m-t', strtotime($postData['fecha_generado']));
		$year_month = date('Y-m', strtotime($postData['fecha_generado']));

		// 2) Obtener contratos del banco desde la API
		$contracts = $this->model_apis->dcontracts($postData['bank_id']);

		if (empty($contracts)) {
			return [
				'status'  => 'error',
				'message' => 'No se encontraron contratos para el banco seleccionado.'
			];
		}

		// 3) Crear array de claves únicas: "afiliado-nropos"
		$keys = array_map(function ($c) {
			return $c['afiliado'] . '-' . $c['nropos'];
		}, $contracts);

		// Escapar para SQL
		$keys = array_map(function ($v) {
			return $this->db->escape_str($v);
		}, $keys);

		// 4) Verificar existencia en **una sola consulta**
		$this->db->select('1');
		$this->db->from('invoices');
		$this->db->where("CONCAT(afiliado,'-',nropos) IN ('" . implode("','", $keys) . "')", null, false);
		$this->db->like('fecha_mes_cobro', $year_month . '-', 'after');
		$this->db->limit(1);
		$exists = ($this->db->count_all_results() > 0);

		if ($exists) {
			return [
				'status'  => 'info',
				'message' => 'Ya existen cobros generados para el mes en curso.'
			];
		}

		// 5) Preparar batch de inserción
		$batch = [];
		foreach ($contracts as $c) {
			$cuota = ($c['type_invoice'] === 'D') ? $c['cuota'] * 30 : $c['cuota'];

			$batch[] = [
				'contract_id'      => $c['contrato'],
				'banco'            => $c['bank_id'],
				'razon'            => $c['razon'],
				'cuenta'           => $c['cuenta'],
				'rif'              => $c['rif'],
				'periodicidad'     => $c['type_invoice'],
				'afiliado'         => $c['afiliado'],
				'nropos'           => $c['nropos'],
				'cuota'            => $cuota,
				'residuo'          => $cuota,
				'fecha_mes_cobro'  => $last_day,
			];
		}

		// 6) Insertar batch
		if (!empty($batch)) {
			$this->db->insert_batch('invoices', $batch);
		}

		return [
			'status'  => 'success',
			'message' => "Se generaron " . count($batch) . " cobros correctamente.",
			'count'   => count($batch)
		];
	}

	public function searchInvoicesConsolidated($dataBase)
	{
		// #1 SubQueries no.1 -------------------------------------------

		$this->db->select("alfa.*");
		$this->db->select("beta.nombre, beta.apellido, beta.create_at AS fecha_registrado, beta.status AS status_contrato");
		$this->db->select("bank.nombre AS nbanco");
		$this->db->select('perio.nombre AS nperiodicidad');
		$this->db->from("invoices alfa");
		$this->db->join('contracts beta', 'beta.id = alfa.contract_id');
		$this->db->join('banks bank', 'bank.id = alfa.banco');
		$this->db->join('parameters perio', 'perio.id = alfa.periodicidad', 'left');
		$this->db->order_by("alfa.contract_id ASC, alfa.id ASC");
		$query = $this->db->get();
		return $query->result();
	}

	public function list_archives_conciliate()
	{
		$this->db->select('domil.*');
		$this->db->select('ban.description AS bancoName');
		$this->db->from('domiciliations domil');
		$this->db->join('banks ban', 'ban.id = domil.banco');
		$this->db->order_by('domil.id', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_invoices($tabla, $add)
	{
		$this->db->insert($tabla, $add);
	}

	public function verificar_archivo_pendiente($postData)
	{
		$this->db->select('*');
		$this->db->from('domiciliations');
		$this->db->where('banco', $postData['banco']);
		$this->db->where('fecha_generado', $postData['fecha_generado']);
		$this->db->where("status IN ('Pendiente', 'Por Conciliar')");
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			$this->session->set_flashdata('error', 'Tienes un archivo de conciliacion pendiente.');
			redirect('/invoices/domiciliations');
		} else {
			return false;
		}
	}


	//////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////

	// Buscar invoices por banco y mes/año
	public function search_in_invoices($postData)
	{
		$ym = date('Y-m', strtotime($postData['fecha_generado']));

		$this->db->from("invoices");
		$this->db->where("banco", $postData['banco']);
		$this->db->like('fecha_mes_cobro', $ym, 'after');  // "YYYY-MM%"
		$this->db->where("status IN ('Pendiente','Rechazado')");
		$query = $this->db->get();
		return $query->result_array();
	}

	// Insert masivo en domiciliations
	public function insert_archive_batch($banco, $name, $route, $tasa, $fecha_generado, array $ids)
	{
		if (empty($ids)) return false;

		$fecha_obj = date_create($fecha_generado);
		$fecha_generado_fmt = $fecha_obj ? $fecha_obj->format('Y-m-d') : null;
		$month = $fecha_obj ? $fecha_obj->format('m') : null;
		$year  = $fecha_obj ? $fecha_obj->format('Y') : null;

		$chunkSize = 5000000;
		$chunks = array_chunk($ids, $chunkSize);

		$batchData = [];
		foreach ($chunks as $c) {
			$batchData[] = [
				'banco'          => $banco,
				'name'           => $name,
				'route'          => $route,
				'total_register' => count($c),
				'fecha_generado' => $fecha_generado_fmt,
				'numcobro'       => implode(',', $c),
				'tasa'           => $tasa,
				'month'          => $month,
				//'year'           => $year,
			];
		}

		$this->db->insert_batch('domiciliations', $batchData);
		return $this->db->affected_rows();
	}
}
