<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<?php
defined('BASEPATH') || exit('No direct script access allowed');

class Model_collections extends CI_Model
{
	public function dashboard($banco = null, $fecha = null)
	{

		//VERIFICACION DE DIA LUNES, PARA TARER DATA DE DOS DIAS ANTES
		$diaDeLaSemana = date('w', strtotime((string) $fecha));
		$fechaDia = date('d', strtotime((string) $fecha));

		if (empty($banco)) {
			$banco = '99';
		}

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		//Cargamos la otra base de datos
		$DB2 = $this->load->database('app', true);
		$sql = "
				SELECT
                pri.id AS contrato, pri.customer_id AS IdCustomers, pri.terminal_id AS terminal, pri.term_id AS condicion, pri.nropos AS nPos, 
				DATE_FORMAT(sec.posted_at, '%d-%m-%Y') AS feOrders,
				cus.rif AS Rif, cus.business_name AS name,
				dcus.affiliate_number AS afiliado, dcus.bank_id AS IdBank, dcus.account_number AS cuenta,
				ban.description AS bankName,
				ter.comission_flatrate AS comicion, ter.type_invoice AS tipeComi,
				equi.serial AS sTerminal
				FROM contracts pri 
				INNER JOIN orders sec ON pri.id = sec.contract_id AND sec.posted_at IS NOT NULL
				INNER JOIN customers cus ON pri.customer_id = cus.id
				INNER JOIN dcustomers dcus ON pri.dcustomer_id = dcus.id
				INNER JOIN bancos ban ON dcus.bank_id = ban.id
				INNER JOIN terms ter ON pri.term_id = ter.id AND ter.comission_flatrate IS NOT NULL
				INNER JOIN terminals equi ON pri.terminal_id = equi.id
				WHERE pri.status='activo' 
                	AND dcus.bank_id = '{$banco}' 
			";
		$sql .= " ORDER BY feOrders ASC ";

		$DB2->query('SET SQL_BIG_SELECTS=1');
		$query = $DB2->query($sql);
		return $query->result();
	}


	public function recive($banco, $fecha = null, $status = null)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
			SELECT pri.*, if(exc.id >= 1, 'Pago excluido', '') as excluido,
			(SELECT SUM(sec.comicion) FROM cobranza sec WHERE pri.contrato=sec.contrato AND sec.status IN ('R','P') LIMIT 1) AS acumulado
			/*, if(left(pri.termino,1) = 'D','Pago Diario', if(left(pri.termino,1) = 'M', 'Pago Mensual', '')) as tipoPago*/
			FROM cobranza pri
			LEFT JOIN cobranza_excluidos exc ON pri.contrato = exc.contrato
			WHERE pri.banco='{$banco}' 
			";
		if (!empty($fecha)) {
			$sql .= "
			AND DATE_FORMAT(pri.fecha, '%Y-%m') = DATE_FORMAT('{$fecha}', '%Y-%m')
			/*AND ( (pri.fecha <= '{$fecha}') OR (pri.status IN ('P','R')) )*/
			";
		}

		if (!empty($status)) {
			if ($status === 'T') {
				$sql .= " AND pri.status IN ('A','R','P') ";
			} else {
				$sql .= " AND pri.status IN ('" . $status . "') ";
			}
		}

		$sql .= " ORDER BY pri.id ASC ";

		//pri.fecha='$fecha'
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function txt($banco, $fecha = null)
	{
		$fecha_format = date('Y-m', strtotime((string) $fecha));

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
				SELECT pri.* FROM cobranza pri WHERE 
				pri.status IN ('P','R') AND pri.banco='{$banco}' 
				";

		if (!empty($fecha)) {
			$sql .= "
				AND ( (pri.termino='M' AND DATE_FORMAT(pri.fecha, '%Y-%m')='{$fecha_format}' )
					OR
					(pri.termino='D' AND DATE_FORMAT(pri.fecha, '%Y-%m-%d')='{$fecha}') )
				";
		}


		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function txt_afiliate($banco)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
				SELECT pri.*, ban.description nameBank
				FROM cobranza_afiliacion pri
				INNER JOIN bancos ban ON pri.banco = ban.id
				WHERE pri.status IN ('pendiente') AND pri.banco='{$banco}' 
				AND pri.delete_at IS NULL
				";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}


	public function cobranza_afiliacion_search($banco)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
				SELECT pri.*, ban.description nameBank
				FROM cobranza_afiliacion pri
				INNER JOIN bancos ban ON pri.banco = ban.id
				WHERE banco = '{$banco}'
				AND pri.delete_at IS NULL
				";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function currencyvalues()
	{
		$DB2 = $this->load->database('app', true);
		$DB2->from('currencyvalues');
		$DB2->order_by('date_value', 'DESC');
		$DB2->limit(1);

		$query = $DB2->get();
		return $query->row();
	}

	public function buscaCorreoTelefono($rif)
	{
		$vowels = ["-", " "];
		$rif = str_replace($vowels, "", $rif);

		$this->db->select("reg_email,reg_movil");
		$this->db->from("registro_cliente");
		$this->db->where("reg_rif", $rif);

		$query = $this->db->get();
		$result = $query->row();

		if (empty($result->reg_movil)) {

			return "/alcides@alcides.com/04140000000//";
		}

		$mobile = str_replace("-", "", $result->reg_movil);
		return "/" . $result->reg_email . "/" . $mobile . "//";
	}

	public function aporte($id)
	{
		$this->db->select('montoCobrar');
		$this->db->from('cobranza');
		$this->db->where("id", $id);

		$query = $this->db->get();
		$rest = $query->row();
		return $rest->montoCobrar;
	}

	public function bancos($afiliate = null)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = " SELECT * FROM bancos WHERE status ='Activo' ";
		if (!empty($afiliate)) {
			$sql .= " AND bank_afiliate ='Y' ";
		}

		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}


	public function verificaExcluidos($contrato, $cuenta, $afiliado)
	{
		$this->db->select('*');
		$this->db->from('cobranza_excluidos');
		$this->db->where("contrato", $contrato);
		$this->db->where("cuenta", $cuenta);
		$this->db->where("afiliado", $afiliado);

		$this->db->limit(1);

		$query = $this->db->get();
		return $query->num_rows() === 1;
	}

	public function existe_en_afiliate($contrato)
	{
		$this->db->select('*');
		$this->db->from('cobranza_afiliacion');
		$this->db->where("contrato", $contrato);
		$this->db->where("delete_at IS NULL");
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->num_rows() === 1;
	}

	public function agrupado_afiliado()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
			SELECT col.status AS estatus, col.banco AS banCode,  
			ban.description AS banName,
			COUNT(col.status) AS cantidad 
			FROM cobranza_afiliacion col
			INNER JOIN bancos ban ON ban.id = col.banco AND col.delete_at IS NULL
			GROUP BY col.status, col.banco
			ORDER BY col.banco ASC, col.status DESC
		";
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->query('SET SQL_BIG_SELECTS=1');

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function agrupado_afiliado_detalle($banco, $status)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
			SELECT pri.*, ban.description AS nameBank FROM cobranza_afiliacion pri
			INNER JOIN bancos ban ON ban.id = pri.banco
			WHERE pri.banco = '{$banco}'
			AND pri.status = '{$status}'
			AND pri.delete_at IS NULL
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function verifica($banco, $contrato, $fecha, $tipo)
	{
		$fecha_format = date('Y-m', strtotime((string) $fecha));

		$this->db->select('*');
		$this->db->from('cobranza');
		$this->db->where("contrato", $contrato);
		$this->db->where("banco", $banco);

		switch ($tipo) {
			case 'M':
				$this->db->where(sprintf(" DATE_FORMAT(fecha, '%%Y-%%m') = DATE_FORMAT('%s', '%%Y-%%m')", $fecha));
				//$this->db->where(" DATE_FORMAT('fecha', '%Y-%m') = '$fecha_format' ");
				break;
			case 'D':
				$this->db->where(sprintf(" DATE_FORMAT(fecha, '%%Y-%%m-%%d') = DATE_FORMAT('%s', '%%Y-%%m-%%d')", $fecha));
				break;
		}

		$this->db->limit(1);
		$query = $this->db->get();
		return $query->num_rows() === 1;
	}


	public function verificaProrrateo($banco, $contrato, $posted, $fecha)
	{
		$this->db->select('*');
		$this->db->from('cobranza');
		$this->db->where("contrato", $contrato);
		$this->db->where("banco", $banco);
		$this->db->where(sprintf(" fecha BETWEEN '%s' AND '%s' AND contrato='%s' ", $posted, $fecha, $contrato));
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->num_rows() === 1;
	}

	public function buscaExcluidos($contrato)
	{
		$this->db->select('*');
		$this->db->from('cobranza_excluidos');
		$this->db->where("contrato", $contrato);
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->num_rows() === 1;
	}

	public function buscaExcluidosExiste($rif, $contrato)
	{
		$sql = " 
			SELECT * FROM cobranza_excluidos WHERE
			rif='{$rif}'
			AND contrato='{$contrato}'
			ORDER BY id DESC
			LIMIT 1
		 ";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function datosCliente($rif)
	{
		$DB2 = $this->load->database('app', true);
		$DB2->from('customers');
		$DB2->where('rif', $rif);
		$DB2->limit(1);

		$query = $DB2->get();
		return $query->row();
	}

	public function buscarContratos($rif)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		//Cargamos la otra base de datos
		$DB2 = $this->load->database('app', true);

		$sql = "
			SELECT  cus.rif AS rif, cus.business_name AS name,
			con.id AS contrato,
			ter.serial AS serialT,
			modt.description AS terminal
			FROM customers cus
			INNER JOIN contracts con ON cus.id = con.customer_id
			INNER JOIN terminals ter ON con.terminal_id = ter.id
			INNER JOIN modelTerminal modt ON ter.modelTerminal_id = modt.id
			WHERE cus.rif='{$rif}'
			";

		$DB2->query('SET SQL_BIG_SELECTS=1');
		$query = $DB2->query($sql);
		return $query->result();
	}

	public function exclude()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '10000');
		$sql = "
				SELECT pri.*, ban.description AS bancoName, usu.usu_usuario AS nameUser
				FROM cobranza_excluidos pri
				LEFT JOIN bancos ban ON ban.id = pri.banco
				LEFT JOIN usuarios usu ON pri.usuario = usu.usu_rif 
				WHERE pri.userDelete IS NULL AND pri.delete IS NULL
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function tipoGestion()
	{
		$this->db->from('suspension_argumento');
		$this->db->where('sc_categoria', 'llamadasCobranza');

		$query = $this->db->get();
		return $query->result();
	}

	public function hisCallCustomers()
	{
		$sql = "
				SELECT a.*, b.sc_nombre AS tipoGestion, e.usu_usuario AS name
				FROM cobranza_llamadas a
				LEFT JOIN suspension_argumento b ON b.sc_id = a.tipoGestion
				LEFT JOIN usuarios e ON e.usu_rif = a.usuario
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function historialCrediticio($rif)
	{

		$sql = "
			SELECT pri.*, if(exc.id >= 1, 'Pago excluido', '') as excluido,
(SELECT SUM(sec.comicion) FROM cobranza sec WHERE pri.contrato=sec.contrato AND sec.status IN ('R','P')) AS acumulado,
(SELECT COUNT(ter.comicion) FROM cobranza ter WHERE pri.contrato=ter.contrato AND ter.status IN ('R','P')) AS cantidadDeudas,
if(left(pri.termino,1) = 'D','Pago Diario', if(left(pri.termino,1) = 'M', 'Pago Mensual', '')) as tipoPago
			FROM cobranza pri
			LEFT JOIN cobranza_excluidos exc ON pri.contrato = exc.contrato
			WHERE pri.rif = '{$rif}'
                ORDER BY pri.id ASC
				
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function ultimo()
	{
		$this->db->from("cobranza_llamadas");
		$this->db->join("usuarios", "usu_rif = usuario");
		$this->db->where("usuario", $this->session->userdata['logged_in']['rif']);
		$this->db->order_by("id", "desc");
		$this->db->limit("1");

		$query = $this->db->get();
		return $query->result();
	}

	public function traeCorreoCobranza()
	{
		$this->db->from("usuarios");
		$this->db->where("usu_tipoUsuario IN ('25','26','27') ");

		$query = $this->db->get();
		return $query->result();
	}

	public function traeConteo($contrato)
	{
		$this->db->select("*, COUNT(*) AS conteo");
		$this->db->from("cobranza");
		$this->db->where("contrato", $contrato);

		$query = $this->db->get();
		return $query->row();
	}

	public function historialCliente($rif)
	{
		$sql = "
		SELECT a.*, b.sc_nombre AS tipoGestion, e.usu_usuario AS name
		FROM cobranza_llamadas a
		LEFT JOIN suspension_argumento b ON b.sc_id = a.tipoGestion
		LEFT JOIN usuarios e ON e.usu_rif = a.usuario
		WHERE a.rif = '" . $rif . "'
		ORDER BY a.fecha_create DESC
		LIMIT 10
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function mensajeriaIndividual($rif)
	{
		$sql = "
			SELECT *, count(contrato) FROM `cobranza`
			WHERE status IN ('P','R')
			AND rif='{$rif}'
			GROUP BY contrato
		";
		$this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		$this->db->query('SET SQL_BIG_SELECTS=1');

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function add($add, $tabla)
	{
		$this->db->insert($tabla, $add);
	}

	/**
	 * Inserta múltiples registros en lote (mucho más rápido)
	 * Optimizado para grandes volúmenes de datos
	 */
	public function addBatch($data, $tabla)
	{
		if (!empty($data)) {
			// Desactivar logging de queries para ahorrar memoria
			$this->db->save_queries = false;

			$this->db->insert_batch($tabla, $data);

			// Reactivar logging
			$this->db->save_queries = true;
		}
	}

	/**
	 * Inserta múltiples registros usando SQL directo (máxima velocidad)
	 * Construye INSERT INTO ... VALUES (...),(...),(...) sin pasar por CI Query Builder
	 * 3-5x más rápido que insert_batch para volúmenes grandes
	 * Internamente divide en chunks de 300 filas para no exceder max_allowed_packet (16MB en producción)
	 *
	 * @param array  $data   Array de arrays asociativos con los datos
	 * @param string $tabla  Nombre de la tabla destino
	 * @return int   Número de filas insertadas exitosamente
	 */
	public function addBatchRaw($data, $tabla)
	{
		if (empty($data)) {
			return 0;
		}

		$this->db->save_queries = false;
		$inserted = 0;

		// Obtener las columnas del primer registro
		$columns = array_keys($data[0]);
		$columnList = '`' . implode('`,`', $columns) . '`';

		// Dividir en chunks de 300 filas para no exceder max_allowed_packet (16MB)
		$chunks = array_chunk($data, 300);

		foreach ($chunks as $chunk) {
			$valueRows = [];
			foreach ($chunk as $row) {
				$values = [];
				foreach ($columns as $col) {
					$val = $row[$col] ?? null;
					$values[] = $val === null ? 'NULL' : $this->db->escape($val);
				}

				$valueRows[] = '(' . implode(',', $values) . ')';
			}

			$sql = sprintf('INSERT INTO `%s` (%s) VALUES ', $tabla, $columnList) . implode(',', $valueRows);
			$result = $this->db->query($sql);

			if ($result === false) {
				$error = $this->db->error();
				log_message('error', sprintf('addBatchRaw ERROR en tabla %s: Code=%s Msg=%s Chunk=', $tabla, $error['code'], $error['message']) . count($chunk) . " filas, SQL size=" . mb_strlen($sql) . " bytes");

				// Reintentar con chunks más pequeños (mitad)
				$subChunks = array_chunk($chunk, 150);
				foreach ($subChunks as $subChunk) {
					$subValueRows = [];
					foreach ($subChunk as $row) {
						$values = [];
						foreach ($columns as $col) {
							$val = $row[$col] ?? null;
							$values[] = $val === null ? 'NULL' : $this->db->escape($val);
						}

						$subValueRows[] = '(' . implode(',', $values) . ')';
					}

					$subSql = sprintf('INSERT INTO `%s` (%s) VALUES ', $tabla, $columnList) . implode(',', $subValueRows);
					$subResult = $this->db->query($subSql);
					if ($subResult !== false) {
						$inserted += count($subChunk);
					} else {
						$subError = $this->db->error();
						log_message('error', sprintf('addBatchRaw RETRY FAILED: Code=%s Msg=%s SubChunk=', $subError['code'], $subError['message']) . count($subChunk) . " filas");
					}
				}
			} else {
				$inserted += count($chunk);
			}
		}

		$this->db->save_queries = true;
		return $inserted;
	}

	/**
	 * Inicia una transacción para operaciones masivas
	 */
	public function startTransaction()
	{
		$this->db->save_queries = false;
		$this->db->trans_start();
	}

	/**
	 * Finaliza una transacción
	 */
	public function endTransaction()
	{
		$this->db->trans_complete();
		$this->db->save_queries = true;
		return $this->db->trans_status();
	}

	/**
	 * Reinicia la transacción (commit + start)
	 * Útil para liberar logs de undo en importaciones masivas
	 */
	public function restartTransaction()
	{
		$this->db->trans_complete();
		$this->db->trans_start();
		$this->db->save_queries = false; // Mantener apagado el logging
	}

	/**
	 * Importación ultra-rápida usando LOAD DATA LOCAL INFILE
	 * 10-20x más rápido que insert_batch para grandes volúmenes
	 *
	 * @param string $csvPath Ruta absoluta al archivo CSV temporal
	 * @param string $tabla Nombre de la tabla destino
	 * @param array $columns Columnas en orden del CSV
	 * @return bool|string True si éxito, mensaje de error si falla
	 */
	public function loadDataInfile($csvPath, $tabla, $columns)
	{
		// Convertir path a formato MySQL (barras normales)
		$csvPath = str_replace('\\', '/', $csvPath);

		$columnList = implode(',', $columns);

		$sql = "LOAD DATA LOCAL INFILE '{$csvPath}' 
                INTO TABLE {$tabla} 
                FIELDS TERMINATED BY ';' 
                ENCLOSED BY '\"' 
                LINES TERMINATED BY '\\n'
                IGNORE 1 LINES
                ({$columnList})";

		try {
			$this->db->save_queries = false;
			$result = $this->db->query($sql);
			$this->db->save_queries = true;
			return $result ? true : $this->db->error()['message'];
		} catch (Exception $exception) {
			$this->db->save_queries = true;
			return $exception->getMessage();
		}
	}

	/**
	 * Verifica si LOAD DATA LOCAL INFILE está habilitado
	 */
	public function isLoadDataEnabled()
	{
		try {
			$result = $this->db->query("SHOW VARIABLES LIKE 'local_infile'")->row();
			return $result && mb_strtolower((string) $result->Value) === 'on';
		} catch (Exception $e) {
			return false;
		}
	}

	public function edit($add, $tabla, $column, $id, $fecha)
	{
		$this->db->where($column, $id);
		$this->db->where("fecha", $fecha);
		$this->db->update($tabla, $add);
	}

	public function editar_txt($add, $rif = null, $cuenta = null, $banco = null, $fecha = null, $contrato = null, $afiliado = null, $nConteo = null)
	{
		ini_set('display_errors', 1);
		error_reporting(E_ALL);

		if (!empty($rif)) {
			$this->db->where("rif", $rif);
		}

		if (!empty($cuenta)) {
			$this->db->where("cuenta", $cuenta);
		}

		if (!empty($contrato)) {
			$this->db->where("contrato", $contrato);
		}

		if (!empty($fecha)) {
			//$this->db->where("fecha", $fecha);
			$this->db->where(sprintf(" DATE_FORMAT(fecha, '%%Y-%%m') = DATE_FORMAT('%s', '%%Y-%%m')", $fecha));
		}

		if (!empty($afiliado)) {
			$this->db->where("afiliado", $afiliado);
		}

		if (!empty($nConteo)) {
			$this->db->where("nConteo", $nConteo);
		}

		$this->db->where("banco", $banco);
		$this->db->where("status IN ('P','R')");
		$this->db->update("cobranza", $add);
	}

	public function editar_txt_afiliate($add, $banco, $ordenante = null, $sTerminal = null)
	{
		$this->db->where("banco", $banco);
		if (!empty($ordenante)) {
			$this->db->where("contrato", $ordenante);
		}

		if (!empty($sTerminal)) {
			$this->db->where("sTerminal", $sTerminal);
		}

		$this->db->where("status IN ('pendiente','rechazado')");
		$this->db->update("cobranza", $add);
	}

	public function edito($add, $tabla, $column, $id)
	{
		$this->db->where($column, $id);
		$this->db->update($tabla, $add);
	}

	public function delete($tabla, $add, $column, $id)
	{
		$this->db->where($column, $id);
		$this->db->update($tabla, $add);
	}

	public function cobranza_generate($banco)
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '1000000');
		$sql = "
			SELECT * FROM cobranza_generate
			WHERE idbanco = '{$banco}'
		";
		$this->db->query('SET SQL_BIG_SELECTS=1');
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function generate_delete($tabla, $column, $id)
	{
		$this->db->where($column, $id);
		$this->db->delete($tabla);
	}

	public function search_nConteo($banco)
	{
		$this->db->select("nConteo");
		$this->db->from("cobranza");
		$this->db->where("banco", $banco);
		$this->db->order_by("nConteo", "DESC");
		$this->db->limit("1");

		$query = $this->db->get();
		$return = $query->row();
		return $return->nConteo;
	}

	/**
	 * Busca la ruta del archivo recibido de una domiciliación
	 */
	public function search_domiciliations_archive($postData)
	{
		$this->db->select("recived");
		$this->db->from("domiciliations");
		$this->db->where("id", $postData['id']);
		$query = $this->db->get();
		$row = $query->row();

		if ($row && !empty($row->recived)) {
			return $row->recived;
		}

		return FALSE;
	}

	/**
	 * Verifica si ya existe una collection para un afiliado/nropos en un mes/año específico
	 */
	public function existe_collection($afiliado, $nropos, $fecha_mes)
	{
		$this->db->from("collections");
		$this->db->where("afiliado", $afiliado);
		$this->db->where("nropos", $nropos);
		$this->db->like("fecha_generado", $fecha_mes, "after");
		$count = $this->db->count_all_results();

		return ($count > 0);
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
