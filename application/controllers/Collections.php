<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collections extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('session');

		$this->load->helper('form');
		$this->load->model('model_invoices');
		$this->load->model('model_collections');
		$this->load->model('model_domiciliations');

		$this->load->library('email');

		// Load database
		$this->load->model('model_apis');
		$this->load->model('permissions');
		$this->load->model('parameters');
	}

	// -----------------------------------------------------------------------

	/**
	 * 
	 * 
	 */

	public function upload()
	{
		ini_set('post_max_size', '100M');
		ini_set('upload_max_filesize', '100M');

		$this->load->library('upload');
		$postData = $this->input->post();

		///////////////////////////////////////////////
		// 1. DATOS DEL BANCO
		///////////////////////////////////////////////
		$bank_api = $this->model_apis->banks($postData['banco']);
		$basePath = "./Storage/domiciliations/" . $bank_api['bank_code'] . "/";

		$recivedPath = $basePath . "recived/";
		$sentPath    = $basePath . "create/";

		///////////////////////////////////////////////
		// 2. CREAR CARPETAS SI NO EXISTEN
		///////////////////////////////////////////////
		$this->ensure_directory($recivedPath);
		$this->ensure_directory($sentPath);

		///////////////////////////////////////////////
		// 3. NOMBRE DEL ARCHIVO A SUBIR
		///////////////////////////////////////////////
		$path = $_FILES['userfile']['name'];
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$fileName  = "recived_" . $postData['fecha_generado'] . "." . $extension;

		///////////////////////////////////////////////
		// 4. CONFIGURAR LA SUBIDA
		///////////////////////////////////////////////
		$this->upload->initialize($this->set_upload_options($fileName, $recivedPath));

		if (!$this->upload->do_upload('userfile')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('/invoices/domiciliations');
			return;
		}

		///////////////////////////////////////////////
		// 5. GUARDAR RUTA EN BD
		///////////////////////////////////////////////
		$add = [
			'recived' => $recivedPath . $fileName,
			'status'  => "Por Conciliar",
		];

		$this->parameters->edit($add, $postData['id'], "id", "domiciliations");

		///////////////////////////////////////////////
		// 6. MENSAJE DE ÉXITO
		///////////////////////////////////////////////
		$this->session->set_flashdata('success', 'Archivo Subido con Éxito.');
		redirect('/invoices/domiciliations');
	}

	private function set_upload_options($name, $route)
	{
		//upload an image options
		$config = array();
		$config['upload_path'] =  $route;
		$config['file_name'] = $name;
		$config['overwrite'] = TRUE;
		$config['allowed_types'] = 'txt|xlsx|xls|csv';
		$config['max_size'] = "11000";
		$config['max_width'] = 0;
		$config['max_height'] = 0;

		return $config;
	}

	/**
	 * Crea directorios si no existen (recursivo)
	 */
	private function ensure_directory($path)
	{
		if (!is_dir($path)) {
			if (!mkdir($path, 0777, TRUE)) {
				$this->session->set_flashdata('error', "No se pudo crear la carpeta: {$path}");
				redirect('/invoices/domiciliations');
				exit;
			}
		}
	}


	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////

	public function conciliar()
	{
		$postData = $this->input->post();
		$conciliar = $this->conciliar_bank($postData);

		if ($conciliar === FALSE) {
			$this->session->set_flashdata('error', 'Error al conciliar el banco.');
			redirect('/invoices/domiciliations');
			return;
		}

		// -----------------------------
		// Modal HTML con estadísticas
		// -----------------------------
		
		$nombres_metricas = [
		    'archivo_total'         => 'Registros Totales en Archivo',
		    'encontrados'           => 'Registros Encontrados (Coincidencias)',
		    'actualizados'          => 'Registros Actualizados',
		    'total_updates_invoice' => 'Facturas (Invoices) Afectadas',
		    'ya_conciliados'        => 'Registros Previamente Conciliados',
		    'no_encontrados'        => 'Registros No Encontrados'
		];

		$msn = '<div class="row text-center">';
		foreach ($conciliar as $k => $v) {
			if (is_array($v)) continue;
			
			$nombre_amigable = isset($nombres_metricas[$k]) ? $nombres_metricas[$k] : ucfirst(str_replace('_', ' ', $k));
			
			// Si el valor es mayor a cero agregar clase text-primary, sino text-muted
			$text_class = ($v > 0) ? 'text-primary' : 'text-muted';
			
			$msn .= '
			<div class="col-md-4 mb-3">
			    <div class="card card-body p-3 shadow-sm border-0 d-flex flex-column justify-content-center align-items-center">
			        <span class="font-weight-semibold text-muted mb-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">' . $nombre_amigable . '</span>
			        <span class="font-weight-bold ' . $text_class . '" style="font-size: 1.5rem;">' . $v . '</span>
			    </div>
			</div>';
		}
		$msn .= '</div>';

		if (!empty($conciliar['errores'])) {
			$msn .= '<div class="alert alert-danger mt-3 mb-0 border-0 shadow-sm">';
			$msn .= '<h6 class="alert-heading font-weight-bold"><i class="fal fa-exclamation-triangle"></i> Errores Detectados:</h6>';
			$msn .= '<hr class="mt-1 mb-2">';
			$msn .= '<ul class="mb-0 pl-3"><li>' . implode("</li><li>", $conciliar['errores']) . '</li></ul>';
			$msn .= '</div>';
		}

		// Marcar domicialiation como conciliado
		$this->parameters->edit(["status" => "Conciliado"], $postData['id'], "id", "domiciliations");

		$this->session->set_flashdata('modal', $msn);
		redirect('/invoices/domiciliations');
	}


	/* ---------------------------------------------------
   FUNCIÓN PRINCIPAL DE CONCILIACIÓN
   --------------------------------------------------- */

	private function conciliar_bank($postData)
	{
		$this->db->trans_begin();

		// ---------- 1. buscar archivo ----------
		$ruta = $this->model_collections->search_domiciliations_archive($postData);

		$headers = [];
		$dataRows = [];
		$line = 0;

		$total_usd = 0;
		$total_amount = 0;

		$stats = [
			"archivo_total"          => 0,
			"encontrados"            => 0,
			"actualizados"           => 0,
			"total_updates_invoice"  => 0,
			"ya_conciliados"         => 0,
			"errores"                => [],
			"no_encontrados"         => 0,
		];

		// ---------- 2. obtener domiciliacion y numcobro ----------
		$domiciliation = $this->db->get_where('domiciliations', ['id' => $postData['id']])->row();
		if (!$domiciliation || empty($domiciliation->numcobro)) {
			$stats["errores"][] = "No hay numcobro en la domiciliación.";
			if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
			return $stats;
		}

		$numcobros_ids = array_filter(array_map('intval', explode(',', $domiciliation->numcobro)), function ($v) {
			return $v > 0;
		});

		// ---------- 3. leer CSV ----------
		if (($handle = fopen($ruta, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 90000, ";")) !== FALSE) {
				$line++;
				if (count($data) === 1 && trim($data[0]) === "") continue;
				// limpiar cada campo
				$data = array_map(function ($v) {
					return trim(str_replace(['"', "'"], "", (string)$v));
				}, $data);

				if ($line == 1) {
					$headers = $data;
					continue;
				}

				if (count($data) !== count($headers)) {
					$stats["errores"][] = "Fila $line tiene columnas inválidas.";
					continue;
				}

				$dataRows[] = array_merge(array_combine($headers, $data), ['_line' => $line]);
			}
			fclose($handle);
		}

		$stats["archivo_total"] = count($dataRows);
		if (empty($dataRows)) {
			if ($this->db->trans_status() === FALSE) $this->db->trans_rollback();
			return $stats;
		}

		// ---------- 4. decidir mes/año del archivo ----------
		$sampleFila = reset($dataRows);
		$mesAnoArchivo = "20" . $sampleFila["ANOL2"] . '-' . str_pad($sampleFila["MESL"], 2, "0", STR_PAD_LEFT);

		// ---------- 5. traer invoices del mes/año ----------
		$this->db->from('invoices');
		$this->db->like('fecha_mes_cobro', $mesAnoArchivo, 'after');
		$allInvoices = $this->db->get()->result_array();

		$filteredInvoices = [];
		$numcobros_set = array_flip($numcobros_ids);
		foreach ($allInvoices as $inv) {
			$iid = intval($inv['id']);
			if (isset($numcobros_set[$iid])) {
				$filteredInvoices[] = $inv;
			}
		}

		// ---------- 6. indexar invoices ----------
		$invIndex = [];
		foreach ($filteredInvoices as $inv) {
			$af = $inv['afiliado'];
			$np = $inv['nropos'];
			$ym = substr($inv['fecha_mes_cobro'], 0, 7);

			$k = $af . '|' . $np . '|' . $ym;
			if (!isset($invIndex[$k])) $invIndex[$k] = [];
			$invIndex[$k][] = $inv;
		}

		$ids_encontrados = [];

		// ---------- 7. procesar cada fila ----------
		foreach ($dataRows as $fila) {
			$codafi = $fila["CODAFI"];
			$nropos = $fila["TERMIN"];
			$ymCSV = "20" . $fila["ANOL2"] . '-' . str_pad($fila["MESL"], 2, "0", STR_PAD_LEFT);
			$keyCSV = $codafi . '|' . $nropos . '|' . $ymCSV;

			// 1) intento match exacto en invIndex
			$foundInvoices = [];
			if (isset($invIndex[$keyCSV])) {
				$foundInvoices = $invIndex[$keyCSV];
			} else {
				$keyCSV_norm = strtolower(preg_replace('/\s+/', '', $keyCSV));
				foreach ($invIndex as $k => $arrInv) {
					$k_norm = strtolower(preg_replace('/\s+/', '', $k));
					if ($k_norm === $keyCSV_norm) {
						$foundInvoices = $arrInv;
						break;
					}
				}
				if (empty($foundInvoices)) {
					foreach ($invIndex as $k => $arrInv) {
						list($af_k, $np_k, $ym_k) = explode('|', $k);
						if (
							(is_numeric($af_k) && is_numeric($codafi) && intval($af_k) === intval($codafi)) &&
							(is_numeric($np_k) && is_numeric($nropos) && intval($np_k) === intval($nropos)) &&
							$ym_k === $ymCSV
						) {
							$foundInvoices = $arrInv;
							break;
						}
						if (
							ltrim($af_k, '0') === ltrim($codafi, '0') &&
							ltrim($np_k, '0') === ltrim($nropos, '0') &&
							$ym_k === $ymCSV
						) {
							$foundInvoices = $arrInv;
							break;
						}
						if (
							strcasecmp(preg_replace('/\s+/', '', $af_k), preg_replace('/\s+/', '', $codafi)) === 0 &&
							strcasecmp(preg_replace('/\s+/', '', $np_k), preg_replace('/\s+/', '', $nropos)) === 0 &&
							$ym_k === $ymCSV
						) {
							$foundInvoices = $arrInv;
							break;
						}
					}
				}
			}

			if (empty($foundInvoices)) {
				$stats["no_encontrados"]++;
				//$stats["errores"][] = "Fila {$fila['_line']} no coincide con ninguna invoice (key: $keyCSV).";
				continue;
			}

			foreach ($foundInvoices as $dbData) {
				$stats["encontrados"]++;
				$ids_encontrados[] = $dbData["id"];

				$fecha_generado = $ymCSV . '-' . str_pad($fila["DIAL"], 2, "0", STR_PAD_LEFT);

				$existe = $this->model_collections->existe_collection($dbData["afiliado"], $dbData["nropos"], $ymCSV);
				if ($existe) {
					$stats["ya_conciliados"]++;
					continue; // no insertamos ni actualizamos invoice
				}

				// insertar collection
				$tasa   = isset($fila["TASA$"]) ? floatval(str_replace(",", ".", $fila["TASA$"])) : 0;
				$monto  = isset($fila["COMIBS"]) ? floatval(str_replace(",", ".", $fila["COMIBS"])) : 0;
				$usd    = isset($fila["COMI$"]) ? floatval(str_replace(",", ".", $fila["COMI$"])) : 0;

				$addCollections = [
					"invoice_id"       => $dbData["id"],
					"contract_id"      => $dbData["contract_id"],
					"afiliado"         => $dbData["afiliado"],
					"nropos"           => $dbData["nropos"],
					"fecha_generado"   => $fecha_generado,
					"fecha_conciliado" => $fecha_generado,
					"fecha_procesado"  => date('Y-m-d'),
					"tasa"             => $tasa,
					"monto"            => $monto,
					"usd"              => $usd,
				];
				$this->parameters->add($addCollections, "collections");
				$stats["actualizados"]++;

				// actualizar invoice SOLO si no existe collection
				$residuo_actual = floatval($dbData["residuo"]);
				if ($usd > $residuo_actual) {
					$excedente = $usd - $residuo_actual;
					$nuevo_residuo = 0;
					$status = "Aprobado";
				} else {
					$excedente = 0;
					$nuevo_residuo = $residuo_actual - $usd;
					$status = ($nuevo_residuo <= 0) ? "Aprobado" : "Pendiente";
				}

				$updateData = [
					"residuo"   => $nuevo_residuo,
					"status"    => $status,
					"excedente" => $excedente
				];
				$this->parameters->edit($updateData, $dbData["id"], "id", "invoices");

				$hubo_cambio = ($residuo_actual != $nuevo_residuo) || ($dbData["status"] != $status) || ($excedente > 0);
				if ($hubo_cambio) $stats["total_updates_invoice"]++;

				$total_usd    += $usd;
				$total_amount += $monto;
			}
		}

		// actualizar totales en domiciliations
		$updateDomiciliation = [
			'total_usd'    => $total_usd,
			'total_amount' => $total_amount,
		];
		$this->parameters->edit($updateDomiciliation, $postData['id'], "id", "domiciliations");

		// finalizar transacción
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}

		$this->db->trans_commit();

		return $stats;
	}
}
