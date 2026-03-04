<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ccr_uno extends CI_Model
{

    public function conteo()
    {
        $this->db->select("COUNT(*) AS conteo");
        $this->db->from("cobranza_ccr_uno");
        $this->db->where("tipo IN ('Credicard', 'Reporte') ");
        $query = $this->db->get();
        $r = $query->row();
        return $r->conteo;
    }

    public function no_cobro($concatenar)
    {
        $this->db->select("no_cobro");
        $this->db->from("cobranza_ccr_uno");
        $this->db->where("tipo", "Reporte");
        $this->db->where("concatenar", $concatenar);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->no_cobro;
        }

        return null; // o ""
    }

    public function codigo_cliente($concatenar/*, $fecha*/)
    {
        $this->db->select("codigo_cliente");
        $this->db->from("cobranza_ccr_uno");
        $this->db->where("tipo IN ('Reporte') ");
        $this->db->where("concatenar", $concatenar);
        //$this->db->where("fecha", $fecha);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->codigo_cliente;
        }

        return null; // o ""
    }

    public function errores()
    {
        $this->db->select("COUNT(*) AS errores");
        $this->db->from("cobranza_ccr_uno");
        $this->db->where("tipo IN ('Aplicado') ");
        $query = $this->db->get();
        $r = $query->row();
        return $r->errores;
    }

    public function truncate()
    {
        $this->db->truncate('cobranza_ccr_uno');
    }

    public function procesado()
    {
        $add = [
            'tipo' => "Aplicado",
            'concatenar' => null,
            'fecha' => null,
            'codigo_cliente' => null,
            'termin_dial_mesl' => null,
            'tipo_operacion' => "Cobro",
            'operacion' => "credito",
            'monto' => null,
            'tasa' => null,
            'bs' => null,
            'rif' => null,
            'codigo_afiliacion' => null,
        ];
        $this->db->insert("cobranza_ccr_uno", $add);
    }

    public function verificar($concatenar/*, $fecha*/)
    {
        $this->db->select('*');
        $this->db->from('cobranza_ccr_uno');
        $this->db->where("tipo IN ('Reporte') ");
        $this->db->where("concatenar", $concatenar);
        //$this->db->where("fecha", $fecha);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function obtener_errores_verificacion($limit = null, $offset = null)
    {
        // Optimización: Usar LEFT JOIN para encontrar registros sin coincidencia en una sola consulta
        // Seleccionamos T1 (Credicard) donde NO existe T2 (Reporte)
        $this->db->select('T1.*');
        $this->db->from('cobranza_ccr_uno T1');
        // Unimos con la misma tabla (alias T2) buscando coincidencia por concatenar y que sea tipo Reporte
        $this->db->join('cobranza_ccr_uno T2', 'T2.concatenar = T1.concatenar AND T2.tipo = "Reporte"', 'left');
        // Filtramos solo los registros base que son Credicard
        $this->db->where('T1.tipo', 'Credicard');
        // La condición de error es que T2.concatenar sea NULL (no hubo match)
        $this->db->where('T2.concatenar IS NULL');

        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function crear_reporte()
    {
        $this->db->from("cobranza_ccr_uno");
        $this->db->where("tipo IN ('Credicard') ");

        $query = $this->db->get();
        return $query->result();
    }
    public function )
    {
        $sql = "
        SELECT c1.*
        FROM cobranza_ccr_uno c1
        LEFT JOIN cobranza_ccr_uno c2 
            ON c1.concatenar = c2.concatenar 
            AND c2.tipo = 'Reporte'
        WHERE c1.tipo = 'Credicard'
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }


    public function verificar_unificado()
    {
        $errores = [];

        $sql = "
        SELECT c1.*
        FROM cobranza_ccr_uno c1
        WHERE c1.tipo = 'Credicard'
        AND NOT EXISTS (
            SELECT 1 
            FROM cobranza_ccr_uno c2
            WHERE c2.tipo = 'Reporte'
            AND c2.concatenar = c1.concatenar
        )
        ";

        $resultado = $this->db->query($sql)->result();

        foreach ($resultado as $row) {

            if (!empty($row->concatenar)) {

                $errores[] = "AFILIADO: " . $row->codigo_afiliacion . " - FECHA: " . $row->fecha . "<br/>";
            } else {
                //$errores[] = "AFILIADO:" . $row->codigo_afiliacion . " - FECHA: " . $row->fecha . "\n";
            }
        }

        return implode("\n", $errores);
    }
}
