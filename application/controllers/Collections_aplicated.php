<?php
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class Collections_aplicated extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_collections');
        $this->load->model('model_aplicated');
        // Load database
        $this->load->helper('download');
    }

    public function generate()
    {
        $data['conteo'] = $this->model_aplicated->conteo();
        $data['conteo_total'] = $this->model_aplicated->conteo_total();
        $data['errores'] = $this->model_aplicated->errores();
        $data['bancos'] = $this->model_aplicated->bancos();

        $data['main_content'] = 'collections/generate_aplicated.php';

        $this->load->view('layout/template', $data);
    }

    public function eliminar_registro()
    {
        $cuenta_contable = $this->input->post('cuenta_contable');
        $create_user = $this->input->post('create_user');

        if (!is_null($cuenta_contable) && !is_null($create_user)) {
            $this->model_aplicated->eliminar_registro($cuenta_contable, $create_user);
            $this->session->set_flashdata('modal', 'Registros eliminados correctamente');
        } else {
            $this->session->set_flashdata('modal', 'Error: No se pudieron identificar los registros a eliminar');
        }

        redirect('collections_aplicated/generate');
    }

    // ==========================================
    // MODULE: collections_banks
    // ==========================================

    public function collections_banks()
    {
        $data['main_content'] = 'collections/collections_banks.php';
        $this->load->view('layout/template', $data);
    }

    public function get_collections_banks_ajax()
    {
        $postData = $this->input->post();
        $data = $this->model_aplicated->get_all_collection_banks($postData);
        $result = array();
        foreach ($data as $bank) {
            $row = array();
            $row[] = $bank->codigo;
            $row[] = $bank->nombre;
            $row[] = $bank->cuenta_contable;
            
            $status_badge = ($bank->status == 'Activo') ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
            $row[] = $status_badge;
            
            $actions = '
                <button type="button" class="btn btn-primary btn-sm btn-icon" onclick="editBank('.$bank->id.')">
                    <span class="ul-btn__icon"><i class="fal fa-edit"></i></span>
                </button>
                <button type="button" class="btn btn-danger btn-sm btn-icon" onclick="deleteBank('.$bank->id.')">
                    <span class="ul-btn__icon"><i class="fal fa-trash-alt"></i></span>
                </button>
            ';
            $row[] = $actions;
            $result[] = $row;
        }

        $output = array(
            "draw" => isset($postData['draw']) ? intval($postData['draw']) : 0,
            "recordsTotal" => $this->model_aplicated->count_all_collection_banks(),
            "recordsFiltered" => $this->model_aplicated->count_filtered_collection_banks($postData),
            "data" => $result,
        );
        echo json_encode($output);
    }

    public function get_collection_bank($id)
    {
        $data = $this->model_aplicated->get_collection_bank_by_id($id);
        echo json_encode($data);
    }

    public function save_collection_bank()
    {
        $id = $this->input->post('id');
        $data = array(
            'codigo' => $this->input->post('codigo'),
            'nombre' => $this->input->post('nombre'),
            'cuenta_contable' => $this->input->post('cuenta_contable'),
            'status' => $this->input->post('status') ? $this->input->post('status') : 'Activo',
        );

        if (empty($id)) {
            $insert = $this->model_aplicated->insert_collection_bank($data);
            echo json_encode(array("status" => TRUE, "action" => "inserted"));
        } else {
            $update = $this->model_aplicated->update_collection_bank($id, $data);
            echo json_encode(array("status" => TRUE, "action" => "updated"));
        }
    }

    public function delete_collection_bank($id)
    {
        $this->model_aplicated->delete_collection_bank($id);
        echo json_encode(array("status" => TRUE));
    }

    public function generate_all($banco)
    {
        //$data['dashboard'] = $this->model_collections->cobranza_generate($banco);
        $data['banco'] = $banco;

        $data['main_content'] = 'collections/generate_all.php';
        $this->load->view('layout/template', $data);
    }

    public function subeDataClient()
    {

        if (empty($this->input->post('cuenta_contable'))) {
            $this->session->set_flashdata('modal', 'Error: No se especifico el banco');
            redirect('collections_aplicated/generate');
            return;
        }

        // Configuración para procesamiento largo
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');
        set_time_limit(0);
        ignore_user_abort(true);
        $startTime = microtime(true);
        log_message('error', 'Iniciando subeDataClient...');

        // Output buffering para mantener conexión activa con nginx
        ob_implicit_flush(true);
        if (ob_get_level()) ob_end_flush();
        header('Content-Type: text/html; charset=utf-8');
        echo '<!-- Procesando archivos... -->';
        flush();

        // Validar que se hayan subido archivos
        if (empty($_FILES) || !isset($_FILES['userfile']) || empty($_FILES['userfile']['name'])) {
            $this->session->set_flashdata('modal', 'Error: No se recibieron archivos. El archivo puede ser demasiado grande.');
            redirect('collections_aplicated/generate');
            return;
        }

        $this->load->library('upload');
        $dataInfo = array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
        $cuenta_contable = $this->input->post('cuenta_contable');

        // Limpiar archivos anteriores para evitar conflictos por case-sensitivity en Linux
        $oldFiles = glob(FCPATH . "Storage/concatena/file_*");
        foreach ($oldFiles as $oldFile) {
            if (is_file($oldFile)) {
                unlink($oldFile);
            }
        }

        for ($i = 0; $i < $cpt; $i++) {
            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $path = $_FILES['userfile']['name'];
            $name = "file_" . $i . "_" . $cuenta_contable . "." . strtolower(pathinfo($path, PATHINFO_EXTENSION));

            $this->upload->initialize($this->set_upload_options($name));
            if (!$this->upload->do_upload('userfile')) {
                $this->session->set_flashdata('modal', $this->upload->display_errors());
                redirect('collections_aplicated/generate');
                return;
            }
            $dataInfo[] = $this->upload->data();
        }

        // ===== OPTIMIZACIÓN: Cachear valores repetidos fuera de los loops =====
        $create_user = $this->session->userdata['logged_in']['id'];
        $batchSize = 20000;
        $totalRegistros = 0;

        // Liberar sesión para evitar bloqueos
        session_write_close();

        // ===== OPTIMIZACIÓN: MySQL tuning para importación masiva =====
        $this->db->query('SET autocommit=0');
        $this->db->query('SET unique_checks=0');
        $this->db->query('SET foreign_key_checks=0');
        $this->db->save_queries = false;

        // ===== ARCHIVO 1: CREDICARD (CSV o XLSX) =====
        $files_found = glob(FCPATH . "Storage/concatena/file_0_" . $cuenta_contable . ".*");
        if (!empty($files_found)) {
            $enlace = $files_found[0];
            $ext = strtolower(pathinfo($enlace, PATHINFO_EXTENSION));
            log_message('error', "Procesando file_0_{$cuenta_contable} (Credicard) - Ext: $ext");

            if ($ext === 'csv') {
                $totalRegistros += $this->_processCredicardCSV($enlace, $cuenta_contable, $create_user, $batchSize);
            } else {
                $totalRegistros += $this->_processCredicardXLSX($enlace, $cuenta_contable, $create_user, $batchSize);
            }
        } else {
            log_message('error', "No se encontró file_0_{$cuenta_contable}");
        }

        // ===== ARCHIVO 2: REPORTE (CSV o XLSX) =====
        $files_found = glob(FCPATH . "Storage/concatena/file_1_" . $cuenta_contable . ".*");
        if (!empty($files_found)) {
            $enlace = $files_found[0];
            $ext = strtolower(pathinfo($enlace, PATHINFO_EXTENSION));
            log_message('error', "Procesando file_1_{$cuenta_contable} (Reporte) - Ext: $ext");

            if ($ext === 'csv') {
                $totalRegistros += $this->_processReporteCSV($enlace, $cuenta_contable, $create_user, $batchSize);
            } else {
                $totalRegistros += $this->_processReporteXLSX($enlace, $cuenta_contable, $create_user, $batchSize);
            }
        } else {
            log_message('error', "No se encontró file_1");
        }

        // ===== Finalizar: COMMIT y restaurar configuración MySQL =====
        $this->db->query('COMMIT');
        $this->db->query('SET autocommit=1');
        $this->db->query('SET unique_checks=1');
        $this->db->query('SET foreign_key_checks=1');
        $this->db->save_queries = true;

        // Calcular duración
        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        $minutes = floor($duration / 60);
        $seconds = floor($duration % 60);
        $timeStr = ($minutes > 0) ? "{$minutes}m {$seconds}s" : "{$seconds}s";

        log_message('error', "Fin subeDataClient. Total: $totalRegistros. Tiempo: $timeStr. Redirigiendo...");
        echo "<!-- Procesamiento finalizado. Redirigiendo... -->";
        echo '<div style="background:green;color:white;padding:20px;text-align:center">Proceso Completado en ' . $timeStr . '. Redirigiendo...</div>';
        echo '<script>setTimeout(function(){ window.location.href = "' . base_url('collections_aplicated/generate') . '"; }, 2000);</script>';

        // Forzar envío final
        if (ob_get_length()) ob_end_flush();
        flush();
    }


    private function _insertBatch(&$batchData, &$totalRegistros, $tipo)
    {
        if (empty($batchData)) return;

        $requested = count($batchData);
        $inserted = 0;

        try {
            $inserted = $this->model_collections->addBatchRaw($batchData, "cobranza_aplicated");
        } catch (Exception $e) {
            log_message('error', "ERROR addBatchRaw {$tipo}: " . $e->getMessage());
        }

        $totalRegistros += $inserted;

        if ($inserted < $requested) {
            log_message('error', "_insertBatch {$tipo}: ADVERTENCIA - Solo se insertaron {$inserted} de {$requested} registros");
        }

        // COMMIT después de cada batch para asegurar persistencia
        $this->db->query('COMMIT');
        $this->db->query('SET autocommit=0');

        $batchData = [];
        echo "<!-- Procesados: $totalRegistros registros (batch {$tipo}: {$inserted}/{$requested}) -->";
        flush();
    }

    private function _processCredicardCSV($enlace, $cuenta_contable, $create_user, $batchSize)
    {
        $total = 0;
        $batchData = [];
        $linesRead = 0;
        $linesSkipped = 0;
        log_message('error', "_processCredicardCSV: Archivo={$enlace} Tamaño=" . filesize($enlace) . " bytes");
        if (($handle = fopen($enlace, "r")) !== FALSE) {
            fgetcsv($handle, 0, ";", "\"", ""); // Skip header - escape vacío para PHP 8.4+
            while (($t = fgetcsv($handle, 0, ";", "\"", "")) !== FALSE) {
                $linesRead++;
                $t = array_map('trim', $t);
                if (empty($t[2])) {
                    $linesSkipped++;
                    continue;
                }

                // Mapeo Credicard (CSV)
                if ($cuenta_contable == '40') {
                    $fecha = $t[1];
                    $dia = substr($fecha, 6, 2);
                    $mes = substr($fecha, 4, 2);
                    $concatenar = $t[4] . $t[5] . str_pad($dia, 2, "0", STR_PAD_LEFT);
                    $termin_dial_mesl = $t[5] . str_pad($dia, 2, "0", STR_PAD_LEFT) . str_pad($mes, 2, "0", STR_PAD_LEFT);
                    $fecha_norm = substr($fecha, 0, 4) . '-' . substr($fecha, 4, 2) . '-' . substr($fecha, 6, 2);
                    $fecha_final = date("Y-m-d", strtotime($fecha_norm));
                    $monto = str_replace(",", ".", $t[12]);
                    $val_tas = (is_numeric(str_replace(".", "", $t[17])) ? (float)str_replace(".", "", $t[17]) : 0) / 1000000;
                    $tasa = number_format($val_tas, 2, '.', '');
                    $bs = str_replace(",", ".", $t[11]);
                    $codigo_afiliacion = $t[4];
                    $termin = $t[5];
                } else {
                    $concatenar = $t[2] . $t[3] . str_pad($t[4], 2, "0", STR_PAD_LEFT);
                    $termin_dial_mesl = $t[4] . str_pad($t[4], 2, "0", STR_PAD_LEFT) . str_pad($t[5], 2, "0", STR_PAD_LEFT);
                    $fecha_norm = $t[6] . "-" . $t[5] . "-" . $t[4];
                    $fecha_final = date("Y-m-d", strtotime($fecha_norm));
                    $monto = str_replace(",", ".", $t[16]);
                    $tasa = str_replace(",", ".", $t[10]);
                    $bs = str_replace(",", ".", $t[15]);
                    $codigo_afiliacion = $t[2];
                    $termin = $t[3];
                }

                $batchData[] = [
                    'tipo' => "Credicard",
                    'cuenta_contable' => $cuenta_contable,
                    'concatenar' => $concatenar,
                    'fecha' => $fecha_final,
                    'cocatena_fecha' => str_replace("-", "", $fecha_final),
                    'codigo_cliente' => null,
                    'no_cobro' => null,
                    'termin_dial_mesl' => $termin_dial_mesl,
                    'tipo_operacion' => "Cobro",
                    'operacion' => "credito",
                    'monto' => $monto,
                    'tasa' => $tasa,
                    'bs' => $bs,
                    'rif' => null,
                    'codigo_afiliacion' => $codigo_afiliacion,
                    'serial' => null,
                    'termin' => $termin,
                    'create_user' => $create_user
                ];

                if (count($batchData) >= $batchSize) {
                    $this->_insertBatch($batchData, $total, "Credicard CSV");
                }
            }
            fclose($handle);
        }
        $this->_insertBatch($batchData, $total, "Residual Credicard CSV");
        log_message('error', "_processCredicardCSV RESULTADO: Leidas={$linesRead} Saltadas={$linesSkipped} Insertadas={$total}");
        return $total;
    }

    private function _processCredicardXLSX($enlace, $cuenta_contable, $create_user, $batchSize)
    {
        $total = 0;
        $batchData = [];
        try {
            $reader = IOFactory::createReaderForFile($enlace);
            $reader->setReadDataOnly(true);
            // Suppress deprecation warnings during load for PHP 8.3+
            $oldErrorLevel = error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
            $spreadsheet = $reader->load($enlace);
            error_reporting($oldErrorLevel);
            $worksheet = $spreadsheet->getActiveSheet();
            $isFirstRow = true;

            foreach ($worksheet->getRowIterator() as $row) {
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $t = [];
                foreach ($cellIterator as $cell) {
                    $t[] = $cell->getValue();
                }

                if (empty($t[2])) continue;

                // Mapeo Credicard (XLSX) - Basado en la misma lógica que CSV pero asumiendo índices similares
                /* if ($cuenta_contable == '40') {
                    $fecha = $t[1];
                    $concatenar = $t[4] . $t[5] . date("d", strtotime($fecha));
                    $termin_dial_mesl = $t[5] . date("dm", strtotime($fecha));
                    $fecha_final = date("Y-m-d", strtotime($fecha));
                    $monto = $t[13];
                    $tasa = $t[18];
                    $bs = $t[14];
                    $codigo_afiliacion = $t[4];
                    $termin = $t[5];
                } else {*/
                $concatenar = $t[2] . $t[3] . str_pad($t[4], 2, "0", STR_PAD_LEFT);
                $termin_dial_mesl = $t[4] . str_pad($t[4], 2, "0", STR_PAD_LEFT) . str_pad($t[5], 2, "0", STR_PAD_LEFT);
                $fecha_norm = $t[6] . "-" . $t[5] . "-" . $t[4];
                $fecha_final = date("Y-m-d", strtotime($fecha_norm));
                $monto = $t[16];
                $tasa = $t[10];
                $bs = $t[15];
                $codigo_afiliacion = $t[2];
                $termin = $t[3];
                //}

                $batchData[] = [
                    'tipo' => "Credicard",
                    'cuenta_contable' => $cuenta_contable,
                    'concatenar' => $concatenar,
                    'fecha' => $fecha_final,
                    'cocatena_fecha' => str_replace("-", "", $fecha_final),
                    'codigo_cliente' => null,
                    'no_cobro' => null,
                    'termin_dial_mesl' => $termin_dial_mesl,
                    'tipo_operacion' => "Cobro",
                    'operacion' => "credito",
                    'monto' => $monto,
                    'tasa' => $tasa,
                    'bs' => $bs,
                    'rif' => null,
                    'codigo_afiliacion' => $codigo_afiliacion,
                    'serial' => null,
                    'termin' => $termin,
                    'create_user' => $create_user
                ];

                if (count($batchData) >= $batchSize) {
                    $this->_insertBatch($batchData, $total, "Credicard XLSX");
                }
            }
            unset($spreadsheet);
        } catch (Exception $e) {
            log_message('error', "Error en _processCredicardXLSX: " . $e->getMessage());
        }
        $this->_insertBatch($batchData, $total, "Residual Credicard XLSX");
        return $total;
    }

    private function _processReporteCSV($enlace, $cuenta_contable, $create_user, $batchSize)
    {
        $total = 0;
        $batchData = [];
        if (($handle = fopen($enlace, "r")) !== FALSE) {
            fgetcsv($handle, 0, ";", "\"", ""); // Skip header - escape vacío para PHP 8.4+
            while (($t = fgetcsv($handle, 0, ";", "\"", "")) !== FALSE) {
                $t = array_map('trim', $t);
                if (empty($t[4])) continue;

                $batchData[] = [
                    'tipo' => "Reporte",
                    'cuenta_contable' => $cuenta_contable,
                    'concatenar' => $t[14] . $t[15] . date("d", strtotime($t[8])),
                    'fecha' => date("Y-m-d", strtotime($t[8])),
                    'cocatena_fecha' => str_replace("-", "", date("Y-m-d", strtotime($t[8]))),
                    'codigo_cliente' => $t[2],
                    'no_cobro' => $t[1],
                    'termin_dial_mesl' => null,
                    'tipo_operacion' => "Cobro",
                    'operacion' => "credito",
                    'monto' => str_replace(",", ".", $t[10]),
                    'tasa' => null,
                    'bs' => null,
                    'rif' => $t[4],
                    'codigo_afiliacion' => $t[14],
                    'serial' => $t[16],
                    'termin' => null,
                    'create_user' => $create_user
                ];

                if (count($batchData) >= $batchSize) {
                    $this->_insertBatch($batchData, $total, "Reporte CSV");
                }
            }
            fclose($handle);
        }
        $this->_insertBatch($batchData, $total, "Residual Reporte CSV");
        return $total;
    }

    private function _processReporteXLSX($enlace, $cuenta_contable, $create_user, $batchSize)
    {
        $total = 0;
        $batchData = [];
        try {
            $reader = IOFactory::createReaderForFile($enlace);
            $reader->setReadDataOnly(true);
            // Suppress deprecation warnings during load for PHP 8.3+
            $oldErrorLevel = error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
            $spreadsheet = $reader->load($enlace);
            error_reporting($oldErrorLevel);
            $worksheet = $spreadsheet->getActiveSheet();
            $isFirstRow = true;
            foreach ($worksheet->getRowIterator() as $row) {
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $t = [];
                foreach ($cellIterator as $cell) {
                    $t[] = $cell->getValue();
                }

                if (empty($t[4])) continue;

                $batchData[] = [
                    'tipo' => "Reporte",
                    'cuenta_contable' => $cuenta_contable,
                    'concatenar' => $t[14] . $t[15] . date("d", strtotime($t[8])),
                    'fecha' => date("Y-m-d", strtotime($t[8])),
                    'cocatena_fecha' => str_replace("-", "", date("Y-m-d", strtotime($t[8]))),
                    'codigo_cliente' => $t[2],
                    'no_cobro' => $t[1],
                    'termin_dial_mesl' => null,
                    'tipo_operacion' => "Cobro",
                    'operacion' => "credito",
                    'monto' => str_replace(",", ".", $t[10]),
                    'tasa' => null,
                    'bs' => null,
                    'rif' => $t[4],
                    'codigo_afiliacion' => $t[14],
                    'serial' => $t[16],
                    'termin' => null,
                    'create_user' => $create_user
                ];

                if (count($batchData) >= $batchSize) {
                    $this->_insertBatch($batchData, $total, "Reporte XLSX");
                }
            }
            unset($spreadsheet);
        } catch (Exception $e) {
            log_message('error', "Error en _processReporteXLSX: " . $e->getMessage());
        }
        $this->_insertBatch($batchData, $total, "Residual Reporte XLSX");
        return $total;
    }

    private function set_upload_options($name)
    {
        set_time_limit(0);
        ini_set("upload_max_filesize", 25);

        //upload an image options
        $config = [];
        $config['upload_path'] = './Storage/concatena';
        $config['file_name'] = $name;
        $config['overwrite'] = true;
        $config['allowed_types'] = 'pdf|xlsx|jpg|jpeg|png|zip|rar|gif|doc|docx|csv';
        $config['max_size'] = "200000000"; //2MB
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        return $config;
    }

    /**
     * Método alternativo usando LOAD DATA INFILE para 400k+ registros
     * 10-20x más rápido que insert_batch
     */
    public function subeDataClientLoadData()
    {
        if (empty($this->input->post('cuenta_contable'))) {
            $this->session->set_flashdata('modal', 'Error: No se especifico el banco');
            redirect('collections_aplicated/generate');
            return;
        }

        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        // Output buffering
        ob_implicit_flush(true);
        if (ob_get_level()) ob_end_flush();
        header('Content-Type: text/html; charset=utf-8');
        echo '<!-- Iniciando importación masiva con LOAD DATA INFILE... -->';
        flush();

        // Validar archivos
        if (empty($_FILES) || !isset($_FILES['userfile']) || empty($_FILES['userfile']['name'])) {
            $this->session->set_flashdata('modal', 'Error: No se recibieron archivos.');
            redirect('collections_aplicated/generate');
            return;
        }

        // Subir archivos
        $this->load->library('upload');
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
        for ($i = 0; $i < $cpt; $i++) {
            $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
            $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
            $_FILES['userfile']['size'] = $files['userfile']['size'][$i];

            $path = $_FILES['userfile']['name'];
            $name = "file_" . $i . "." . pathinfo($path, PATHINFO_EXTENSION);

            $this->upload->initialize($this->set_upload_options($name));
            if (!$this->upload->do_upload('userfile')) {
                $this->session->set_flashdata('modal', $this->upload->display_errors());
                redirect('collections_aplicated/generate');
                return;
            }
        }

        // Crear archivo CSV temporal para LOAD DATA INFILE
        $tempCsvPath = FCPATH . "Storage/concatena/temp_import_" . time() . ".csv";
        $tempHandle = fopen($tempCsvPath, 'w');

        // Header del CSV con las columnas de la tabla
        $columns = [
            'tipo',
            'cuenta_contable',
            'concatenar',
            'fecha',
            'cocatena_fecha',
            'codigo_cliente',
            'no_cobro',
            'termin_dial_mesl',
            'tipo_operacion',
            'operacion',
            'monto',
            'tasa',
            'bs',
            'rif',
            'codigo_afiliacion',
            'serial',
            'termin',
            'create_user'
        ];
        fputcsv($tempHandle, $columns, ';', '"', '\\');

        $totalRegistros = 0;

        // Procesar archivo credicard (file_0)
        $files_found = glob(FCPATH . "Storage/concatena/file_0.*");
        if (!empty($files_found)) {
            $enlace = $files_found[0];
            $extension = strtolower(pathinfo($enlace, PATHINFO_EXTENSION));

            if ($extension === 'csv' && ($handle = fopen($enlace, "r")) !== FALSE) {
                fgetcsv($handle, 0, ";", "\"", "\\"); // Skip header
                while (($t = fgetcsv($handle, 0, ";", "\"", "\\")) !== FALSE) {
                    $t = array_map('trim', $t);
                    if (empty($t[2])) continue;

                    if ($this->input->post('cuenta_contable') == '40') {
                        $fecha = $t[0];
                        $dia = substr($fecha, 6, 2);
                        $mes = substr($fecha, 4, 2);
                        $concatenar = $t[4] . $t[5] . str_pad($dia, 2, "0", STR_PAD_LEFT);
                        $termin_dial_mesl = $t[5] . str_pad($dia, 2, "0", STR_PAD_LEFT) . str_pad($mes, 2, "0", STR_PAD_LEFT);
                        $fecha = substr($fecha, 0, 4) . '-' . substr($fecha, 4, 2) . '-' . substr($fecha, 6, 2);
                        $fecha_final = date("Y-m-d", strtotime($fecha));
                        $monto = str_replace(",", ".", $t[13]);
                        $valor_limpio = str_replace(".", "", $t[18]);
                        $valor = (is_numeric($valor_limpio) ? (float)$valor_limpio : 0) / 1000000;
                        $tasa = number_format($valor, 2, '.', '');
                        $bs = str_replace(",", ".", $t[14]);
                        $codigo_afiliacion = $t[4];
                        $termin = $t[5];
                    } else {
                        $concatenar = $t[2] . $t[3] . str_pad($t[4], 2, "0", STR_PAD_LEFT);
                        $termin_dial_mesl = $t[4] . str_pad($t[4], 2, "0", STR_PAD_LEFT) . str_pad($t[5], 2, "0", STR_PAD_LEFT);
                        $fecha = $t[6] . "-" . $t[5] . "-" . $t[4];
                        $fecha_final = date("Y-m-d", strtotime($fecha));
                        $monto = str_replace(",", ".", $t[16]);
                        $tasa = str_replace(",", ".", $t[10]);
                        $bs = str_replace(",", ".", $t[15]);
                        $codigo_afiliacion = $t[2];
                        $termin = $t[3];
                    }

                    // Escribir fila al CSV temporal
                    fputcsv($tempHandle, [
                        "Credicard",
                        $this->input->post('cuenta_contable'),
                        $concatenar,
                        $fecha_final,
                        str_replace("-", "", $fecha_final),
                        "", // codigo_cliente
                        "", // no_cobro
                        $termin_dial_mesl,
                        "Cobro",
                        "credito",
                        $monto,
                        $tasa,
                        $bs,
                        "", // rif
                        $codigo_afiliacion,
                        "", // serial
                        $termin,
                        $this->session->userdata['logged_in']['id']
                    ], ';', '"', '\\');

                    $totalRegistros++;

                    // Keep-alive cada 50k
                    if ($totalRegistros % 50000 == 0) {
                        echo "<!-- Escritos: $totalRegistros registros al CSV -->";
                        flush();
                    }
                }
                fclose($handle);
            }
        }

        fclose($tempHandle);
        echo "<!-- CSV temporal creado con $totalRegistros registros. Importando... -->";
        flush();

        // Usar LOAD DATA LOCAL INFILE
        $result = $this->model_collections->loadDataInfile($tempCsvPath, 'cobranza_aplicated', $columns);

        // Eliminar CSV temporal
        if (file_exists($tempCsvPath)) {
            unlink($tempCsvPath);
        }

        if ($result === true) {
            $this->session->set_flashdata('modal', "Importación LOAD DATA completada. Total: $totalRegistros registros.");
        } else {
            $this->session->set_flashdata('modal', "Error en LOAD DATA: $result. Usa el método estándar.");
        }

        echo '<script>window.location.href = "' . base_url('collections_aplicated/generate') . '";</script>';
    }

    public function verificar($codigo_banco = null)
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        $msn = "verificacion terminada \n";

        $msn .= $this->model_aplicated->verificar_unificado();
        $this->model_aplicated->procesado($codigo_banco);
        $this->session->set_flashdata('modal', $msn);

        // Usar JS redirect para evitar error de headers si hubo output previo
        echo '<script>window.location.href = "' . base_url('collections_aplicated/generate') . '";</script>';
    }

    public function excel_cobranza($variable = null)
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        $cargarData = $nombre_archivo = "";

        switch ($variable) {
            case 'aprobados':
                $cargarData = $this->model_aplicated->crear_reporte_mejorado();
                $nombre_archivo = "Aprobados";
                break;
            case 'errados':
                $cargarData = $this->model_aplicated->crear_reporte_monto_no_coincide();
                $nombre_archivo = "Monto no coincide";
                break;
            case 'rechazados':
                $cargarData = $this->model_aplicated->crear_reporte_no_coincide_concatenar();
                $nombre_archivo = "Rechazados";
                break;
            case 'duplicados':
                $cargarData = $this->model_aplicated->crear_reporte_duplicados();
                $nombre_archivo = "Duplicados";
                break;
            default:
                break;
        }

        //$cargarData = $this->model_aplicated->crear_reporte();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("REPORTE");
        $contador = 1;
        $array_cab = array(
            'Tipo Operación' => 'A',
            'Cobro/Contrato' => 'B',
            'Operación' => 'C',
            'Fecha' => 'D',
            'Tipo Pago' => 'E',
            'Cuenta Contable' => 'F',
            'Monto' => 'G',
            'Tasa Cambio' => 'H',
            'Monto Bs' => 'I',
            'Referencia' => 'J',
            'Observaciones' => 'K'
        );

        if ($variable == "errados") {
            $array_cab['Monto Plan Eureka'] = 'L';
        }

        if ($variable == "rechazados") {
            $array_cab['Codigo Afiliado'] = 'L';
            $array_cab['Terminal'] = 'M';
        }

        if ($variable == "duplicados") {
            $array_cab['Codigo Afiliado'] = 'L';
            $array_cab['Terminal'] = 'M';
        }

        foreach ($array_cab as $nombre => $letra) {
            $sheet->getColumnDimension($letra)->setWidth(20);
            $styleArray = [
                'font' => ['bold' => true, 'color' => array('rgb' => 'FFFFFF')],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '1C235A']
                ],
            ];
            $sheet->getStyle("$letra$contador")->applyFromArray($styleArray);
            $sheet->setCellValue("$letra$contador", $nombre);
        }

        //Definimos la data del cuerpo.  
        foreach ($cargarData as $l) {
            $contador++;
            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A$contador", $l->tipo_operacion);
            $no_cobro = $this->model_aplicated->no_cobro($l->concatenar, $l->cocatena_fecha);
            $sheet->setCellValue("B$contador", (!empty($no_cobro)) ? $no_cobro : "");
            $sheet->setCellValue("C$contador", $l->operacion);
            $sheet->setCellValue("D$contador", $l->fecha);
            $sheet->setCellValue("E$contador", "Transferencia");
            $sheet->setCellValue("F$contador", $l->cuentaContable);
            $sheet->setCellValueExplicit("G$contador", $l->monto, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("H$contador", $l->tasa, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I$contador", $l->bs, DataType::TYPE_STRING);
            $codigo_cliente = $this->model_aplicated->codigo_cliente($l->concatenar, $l->cocatena_fecha);

            $complemento = "CCC CCR " . $codigo_cliente . $l->termin_dial_mesl;

            if (empty($codigo_cliente)) {
                $codigo_cliente = "CCC CCR ";
            } else {
                $codigo_cliente = $complemento;
            }

            $sheet->setCellValue("J$contador", $codigo_cliente);
            $sheet->setCellValue("K$contador", "CCC CCR - Observaciones");

            if ($variable == "errados") {
                $sheet->setCellValueExplicit("L$contador", $l->rpc, DataType::TYPE_STRING);
            }
            if ($variable == "rechazados") {
                $sheet->setCellValue("L$contador", $l->codigo_afiliacion);
                $sheet->setCellValue("M$contador", $l->termin);
            }
            if ($variable == "duplicados") {
                $sheet->setCellValue("L$contador", $l->codigo_afiliacion);
                $sheet->setCellValue("M$contador", $l->termin);
            }
        }

        $archivo = $nombre_archivo . " - Carga Masiva.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function excel_cobranza_csv($variable = null)
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        $cargarData = $nombre_archivo = "";

        switch ($variable) {
            case 'aprobados':
                $cargarData = $this->model_aplicated->crear_reporte_mejorado();
                $nombre_archivo = "Aprobados";
                break;
            case 'errados':
                $cargarData = $this->model_aplicated->crear_reporte_monto_no_coincide();
                $nombre_archivo = "Monto no coincide";
                break;
            case 'rechazados':
                $cargarData = $this->model_aplicated->crear_reporte_no_coincide_concatenar();
                $nombre_archivo = "Rechazados";
                break;
            case 'duplicados':
                $cargarData = $this->model_aplicated->crear_reporte_duplicados();
                $nombre_archivo = "Duplicados";
                break;
            default:
                break;
        }

        //$cargarData = $this->model_aplicated->crear_reporte();

        $archivo = $nombre_archivo . " - Carga Masiva.csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');

        $output = fopen('php://output', 'w');

        // UTF-8 BOM para Excel
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        $header = [
            'Tipo Operación',
            'Cobro/Contrato',
            'Operación',
            'Fecha',
            'Tipo Pago',
            'Cuenta Contable',
            'Monto',
            'Tasa Cambio',
            'Monto Bs',
            'Referencia',
            'Observaciones'
        ];

        if ($variable == "errados") {
            $header[] = 'Monto Plan Eureka';
        }

        if ($variable == "rechazados") {
            $header[] = 'Codigo Afiliado';
            $header[] = 'Terminal';
        }
        if ($variable == "duplicados") {
            $header[] = 'Codigo Afiliado';
            $header[] = 'Terminal';
        }

        // PHP 8.4+ requiere el parámetro escape explícitamente
        fputcsv($output, $header, ";", "\"", "\\");

        foreach ($cargarData as $l) {


            $no_cobro = $this->model_aplicated->no_cobro($l->concatenar, $l->cocatena_fecha);

            $codigo_cliente = $this->model_aplicated->codigo_cliente($l->concatenar, $l->cocatena_fecha);
            $complemento = "CCC CCR " . $codigo_cliente . $l->termin_dial_mesl;
            $referencia = (empty($codigo_cliente)) ? "CCC CCR " : $complemento;

            $row = [
                $l->tipo_operacion,
                (!empty($no_cobro)) ? $no_cobro : "",
                $l->operacion,
                $l->fecha,
                "Transferencia",
                $l->cuentaContable,
                $l->monto,
                $l->tasa,
                $l->bs,
                $referencia,
                "CCC CCR - Observaciones"
            ];

            if ($variable == "errados") {
                $row[] = $l->rpc;
            }
            if ($variable == "rechazados") {
                $row[] = $l->codigo_afiliacion;
                $row[] = $l->termin;
            }
            if ($variable == "duplicados") {
                $row[] = $l->codigo_afiliacion;
                $row[] = $l->termin;
            }

            // PHP 8.4+ requiere el parámetro escape explícitamente
            fputcsv($output, $row, ";", "\"", "\\");
        }

        fclose($output);
        exit;
    }
}
