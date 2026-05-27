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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Collections_ccr_uno extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_collections');
        $this->load->model('model_ccr_uno');
        // Load database
        $this->load->helper('download');
    }

    public function generate()
    {
        $data['conteo'] = $this->model_ccr_uno->conteo();
        $data['errores'] = $this->model_ccr_uno->errores();
        $data['main_content'] = 'collections/generate_ccr_uno.php';

        $this->load->view('layout/template', $data);
    }

    public function truncate()
    {
        $this->model_ccr_uno->truncate();

        $this->session->set_flashdata('modal', "Limpieza de tabla completada.");
        redirect('collections_ccr_uno/generate', 'refresh');
    }

    public function subeDataClient()
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '50M');
        ini_set('upload_max_filesize', '50M');
        set_time_limit(0);
        ignore_user_abort(true);

        // Output buffering para mantener conexión activa con nginx
        ob_implicit_flush(true);
        if (ob_get_level()) ob_end_flush();
        header('Content-Type: text/html; charset=utf-8');
        echo '<!-- Procesando archivos... -->';
        flush();

        // Validar que se hayan subido archivos
        if (empty($_FILES) || !isset($_FILES['userfile']) || empty($_FILES['userfile']['name'])) {
            $this->session->set_flashdata('modal', 'Error: No se recibieron archivos. El archivo puede ser demasiado grande.');
            redirect('collections_ccr_uno/generate');
            return;
        }

        $this->load->library('upload');
        $dataInfo = array();
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
            $this->upload->do_upload('userfile');
            $dataInfo[] = $this->upload->data();
            if (!$this->upload->do_upload('userfile')) {
                $this->session->set_flashdata('modal', $this->upload->display_errors());
                redirect('collections_ccr_uno/generate');
                return;
            }
        }

        $totalRegistros = 0;

        //ARCHIVO CREDICARD//////////////////////////////////////
        $files_found = glob(FCPATH . "Storage/ccruno/file_0.*");
        if (empty($files_found)) {
            $this->session->set_flashdata('modal', 'Error: No se encontró el archivo file_0');
            redirect('collections_ccr_uno/generate');
            return;
        }
        $enlace = $files_found[0];
        $extension = strtolower(pathinfo($enlace, PATHINFO_EXTENSION));

        $batchData = [];
        $batchSize = 1000; // Lotes más grandes para mayor velocidad
        $rowCount = 0;

        if ($extension === 'csv') {
            // PARSING NATIVO CSV - Mucho más rápido
            if (($handle = fopen($enlace, "r")) !== FALSE) {
                fgetcsv($handle, 0, ";", "\"", "\\"); // Skip header
                while (($t = fgetcsv($handle, 0, ";", "\"", "\\")) !== FALSE) {
                    $t = array_map('trim', $t); // Eliminar espacios en blanco
                    if (empty($t[2])) continue; // Skip empty rows

                    //$concatenar = $t[2] . intval($t[3]);
                    $concatenar = $t[2] . $t[3] . str_pad($t[4], 2, "0", STR_PAD_LEFT);

                    $termin_dial_mesl = $t[4] . str_pad($t[4], 2, "0", STR_PAD_LEFT) . str_pad($t[5], 2, "0", STR_PAD_LEFT);
                    $fecha = "20" . $t[6] . "-" . $t[5] . "-" . $t[4];

                    $batchData[] = [
                        'tipo' => "Credicard",
                        'cuenta_contable' => null,
                        'concatenar' => $concatenar,
                        'fecha' => date("Y-m-d", strtotime($fecha)),
                        'codigo_cliente' => null,
                        'no_cobro' => null,
                        'termin_dial_mesl' => $termin_dial_mesl,
                        'tipo_operacion' => "Contrato",
                        'operacion' => "debito",
                        'monto' => str_replace(",", ".", $t[16]),
                        'tasa' => str_replace(",", ".", $t[10]),
                        'bs' => str_replace(",", ".", $t[15]),
                        'rif' => null,
                        'codigo_afiliacion' => $t[2],
                    ];

                    if (count($batchData) >= $batchSize) {
                        $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
                        $totalRegistros += count($batchData);
                        $batchData = [];
                        echo ' ';
                        flush(); // Keep-alive
                    }
                    $rowCount++;
                }
                fclose($handle);
            }
        } else {
            // XLSX - Usar PhpSpreadsheet con supresión de errores
            $errorLevel = error_reporting(0);
            $spreadsheet = IOFactory::load($enlace);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            error_reporting($errorLevel);
            unset($sheetData[0]);

            foreach ($sheetData as $t) {
                if (empty($t[2])) continue;

                //$concatenar = $t[2] . intval($t[3]);
                $concatenar = $t[2] . $t[3] . str_pad($t[4], 2, "0", STR_PAD_LEFT);

                $termin_dial_mesl = $t[4] . str_pad($t[4], 2, "0", STR_PAD_LEFT) . str_pad($t[5], 2, "0", STR_PAD_LEFT);
                $fecha = "20" . $t[6] . "-" . $t[5] . "-" . $t[4];

                $batchData[] = [
                    'tipo' => "Credicard",
                    'cuenta_contable' => null,
                    'concatenar' => $concatenar,
                    'fecha' => date("Y-m-d", strtotime($fecha)),
                    'codigo_cliente' => null,
                    'no_cobro' => null,
                    'termin_dial_mesl' => $termin_dial_mesl,
                    'tipo_operacion' => "Contrato",
                    'operacion' => "debito",
                    'monto' => str_replace(",", ".", $t[16]),
                    'tasa' => str_replace(",", ".", $t[10]),
                    'bs' => str_replace(",", ".", $t[15]),
                    'rif' => null,
                    'codigo_afiliacion' => $t[2],
                ];

                if (count($batchData) >= $batchSize) {
                    $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
                    $totalRegistros += count($batchData);
                    $batchData = [];
                    echo ' ';
                    flush();
                }
            }
            unset($spreadsheet, $sheetData); // Liberar memoria
        }

        if (!empty($batchData)) {
            $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
            $totalRegistros += count($batchData);
        }

        //////////ARCHIVO REPORTE//////////////////////////////////////////////////////////
        $files_found = glob(FCPATH . "Storage/ccruno/file_1.*");
        if (empty($files_found)) {
            $this->session->set_flashdata('modal', 'Error: No se encontró el archivo file_1');
            redirect('collections_ccr_uno/generate');
            return;
        }
        $enlace = $files_found[0];
        $extension = strtolower(pathinfo($enlace, PATHINFO_EXTENSION));

        $batchData = [];

        if ($extension === 'csv') {
            // PARSING NATIVO CSV
            if (($handle = fopen($enlace, "r")) !== FALSE) {
                fgetcsv($handle, 0, ",", "\"", "\\"); // Skip header
                while (($t = fgetcsv($handle, 0, ",", "\"", "\\")) !== FALSE) {
                    $t = array_map('trim', $t); // Eliminar espacios en blanco
                    if (empty($t[4])) continue;

                    $no_terminal = isset($t[26]) ? intval($t[26]) : 0;
                    //$concatenar = $t[4] . $no_terminal;
                    $concatenar = $t[14] . $t[15] . date("d", strtotime($t[8]));

                    $codigo_cliente = $t[0];
                    $contrato_no = $t[1];
                    $rif = $t[7];
                    $codigo_afiliacion = $t[4];

                    $batchData[] = [
                        'tipo' => "Reporte",
                        'cuenta_contable' => null,
                        'concatenar' => $concatenar,
                        'fecha' => null,
                        'codigo_cliente' => $codigo_cliente,
                        'no_cobro' => $contrato_no,
                        'termin_dial_mesl' => null,
                        'tipo_operacion' => "Contrato",
                        'operacion' => "debito",
                        'monto' => str_replace(",", ".", $t[10]),
                        'tasa' => null,
                        'bs' => null,
                        'rif' => $rif,
                        'codigo_afiliacion' => $codigo_afiliacion,
                    ];

                    if (count($batchData) >= $batchSize) {
                        $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
                        $totalRegistros += count($batchData);
                        $batchData = [];
                        echo ' ';
                        flush();
                    }
                }
                fclose($handle);
            }
        } else {
            // XLSX
            $errorLevel = error_reporting(0);
            $spreadsheet = IOFactory::load($enlace);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            error_reporting($errorLevel);
            unset($sheetData[0]);

            foreach ($sheetData as $t) {
                if (empty($t[4])) continue;

                $no_terminal = isset($t[26]) ? intval($t[26]) : 0;
                //$concatenar = $t[4] . $no_terminal;
                $concatenar = $t[14] . $t[15] . date("d", strtotime($t[8]));
                $codigo_cliente = $t[0];
                $contrato_no = $t[1];
                $rif = $t[7];
                $codigo_afiliacion = $t[4];

                $batchData[] = [
                    'tipo' => "Reporte",
                    'cuenta_contable' => null,
                    'concatenar' => $concatenar,
                    'fecha' => null,
                    'codigo_cliente' => $codigo_cliente,
                    'no_cobro' => $contrato_no,
                    'termin_dial_mesl' => null,
                    'tipo_operacion' => "Contrato",
                    'operacion' => "debito",
                    'monto' => str_replace(",", ".", $t[10]),
                    'tasa' => null,
                    'bs' => null,
                    'rif' => $rif,
                    'codigo_afiliacion' => $codigo_afiliacion,
                ];

                if (count($batchData) >= $batchSize) {
                    $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
                    $totalRegistros += count($batchData);
                    $batchData = [];
                    echo ' ';
                    flush();
                }
            }
            unset($spreadsheet, $sheetData);
        }

        if (!empty($batchData)) {
            $this->model_collections->addBatch($batchData, "cobranza_ccr_uno");
            $totalRegistros += count($batchData);
        }

        $this->session->set_flashdata('modal', "Proceso completado. Total registros procesados: " . $totalRegistros);
        echo '<script>window.location.href = "' . base_url('collections_ccr_uno/generate') . '";</script>';
    }

    private function set_upload_options($name)
    {
        set_time_limit(0);
        ini_set("upload_max_filesize", 25);

        //upload an image options
        $config = [];
        $config['upload_path'] = './Storage/ccruno';
        $config['file_name'] = $name;
        $config['overwrite'] = true;
        $config['allowed_types'] = 'pdf|xlsx|jpg|jpeg|png|zip|rar|gif|doc|docx|csv';
        $config['max_size'] = "200000000"; //2MB
        $config['max_width'] = 0;
        $config['max_height'] = 0;

        return $config;
    }

    public function verificar()
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        $msn = "verificacion terminada \n";

        $msn .= $this->model_ccr_uno->verificar_unificado();
        $this->model_ccr_uno->procesado();
        $this->session->set_flashdata('modal', $msn);

        // Usar JS redirect para evitar error de headers si hubo output previo
        echo '<script>window.location.href = "' . base_url('collections_ccr_uno/generate') . '";</script>';
    }

    public function excel_cobranza()
    {
        // Configuración para procesamiento largo
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);
        ignore_user_abort(true);

        //$cargarData = $this->model_ccr_uno->crear_reporte();
        $cargarData = $this->model_ccr_uno->crear_reporte_mejorado();

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
            //$result = $this->model_ccr_uno->verificar($l->concatenar);
            //if ($result == TRUE) {
            //Incrementamos una fila más, para ir a la siguiente.
            $contador++;
            //Informacion de las filas de la consulta.
            $sheet->setCellValue("A$contador", $l->tipo_operacion);
            $no_cobro = $this->model_ccr_uno->no_cobro($l->concatenar/*, $l->fecha*/);
            $sheet->setCellValue("B$contador", (!empty($no_cobro)) ? $no_cobro : "");
            $sheet->setCellValue("C$contador", $l->operacion);
            $sheet->setCellValue("D$contador", $l->fecha);
            $sheet->setCellValue("E$contador", "Transferencia");
            $sheet->setCellValue("F$contador", $l->cuenta_contable);
            $sheet->setCellValue("G$contador", $l->monto);
            $sheet->setCellValue("H$contador", $l->tasa);
            $sheet->setCellValue("I$contador", $l->bs);

            $codigo_cliente = $this->model_aplicated->codigo_cliente($l->concatenar, $l->fecha);
            $complemento = "CCC CCR " . $codigo_cliente . $l->termin_dial_mesl;

            if (empty($codigo_cliente)) {
                $codigo_cliente = "CCC CCR ";
            } else {
                $codigo_cliente = $complemento;
            }

            $sheet->setCellValue("J$contador", $codigo_cliente);
            $sheet->setCellValue("K$contador", "CCC CCR - Observaciones");
            // }
        }

        $archivo = "Carga Masiva Entrada.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); //mime type
        header('Content-Disposition: attachment;filename="' . $archivo . '"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        //ob_end_clean();
        $writer->save('php://output');
    }
}
