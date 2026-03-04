<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_aplicated extends CI_Model
{

    public function conteo()
    {
        $this->db->select("COUNT(*) AS conteo");
        $this->db->from("cobranza_aplicated");
        $this->db->where("create_user", $this->session->userdata['logged_in']['id']);
        $query = $this->db->get();
        $r = $query->row();
        return $r->conteo;
    }

    public function conteo_total()
    {
        // Optimización: Retorno rápido si la tabla está vacía
        if ($this->db->count_all_results('cobranza_aplicated') == 0) {
            return [];
        }

        /**
         * Optimización de rendimiento:
         * Primero agrupamos los IDs en la tabla principal (cobranza_aplicated)
         * y luego hacemos los JOINs con las tablas descriptoras.
         * Esto evita multiplicar el número de filas antes de agrupar.
         */
        $sql = "
            SELECT
                resumen.*,
                u.nombre,
                b.nombre AS banco,
                b.codigo AS codigo_banco
            FROM (
                SELECT
                    cuenta_contable,
                    create_user,
                    COUNT(*) AS conteo_total,
                    SUM(CASE WHEN tipo = 'Credicard' THEN 1 ELSE 0 END) AS conteo_credicard,
                    SUM(CASE WHEN tipo = 'reporte' THEN 1 ELSE 0 END) AS conteo_reporte
                FROM cobranza_aplicated
                WHERE tipo IN ('Credicard', 'reporte')
                GROUP BY cuenta_contable, create_user
            ) AS resumen
            LEFT JOIN usuarios u ON resumen.create_user = u.id
            LEFT JOIN cobranza_bancos b ON resumen.cuenta_contable = b.codigo
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function errores()
    {
        $this->db->select("COUNT(*) AS errores");
        $this->db->from("cobranza_aplicated");
        $this->db->where("tipo", "Aplicado");
        $query = $this->db->get();
        $r = $query->row();
        return $r->errores;
    }

    public function bancos()
    {
        $this->db->from("cobranza_bancos");
        $query = $this->db->get();
        return $query->result();
    }

    public function no_cobro($concatenar, $cocatena_fecha)
    {
        $this->db->select("no_cobro");
        $this->db->from("cobranza_aplicated");
        $this->db->where("tipo", "Reporte");
        $this->db->where("concatenar", $concatenar);
        $this->db->where("cocatena_fecha", $cocatena_fecha);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->no_cobro;
        }

        return null; // o ""
    }

    public function codigo_cliente($concatenar, $cocatena_fecha)
    {
        $this->db->select("codigo_cliente");
        $this->db->from("cobranza_aplicated");
        $this->db->where("tipo", "Reporte");
        $this->db->where("concatenar", $concatenar);
        $this->db->where("cocatena_fecha", $cocatena_fecha);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->codigo_cliente;
        }

        return null; // o ""
    }

    public function eliminar_registro($cuenta_contable, $create_user)
    {
        // Optimizar eliminación masiva
        $this->db->save_queries = false;

        // Ejecutar DELETE directo para evitar overhead de CI
        $sql = "DELETE FROM cobranza_aplicated WHERE cuenta_contable = ? AND create_user = ?";
        $this->db->query($sql, array($cuenta_contable, $create_user));

        $this->db->save_queries = true;
    }

    public function procesado($codigo_banco = null)
    {
        $add = [
            'tipo' => "Aplicado",
            'concatenar' => null,
            'cuenta_contable' => $codigo_banco,
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
            'create_user' => $this->session->userdata['logged_in']['id'],
        ];
        $this->db->insert("cobranza_aplicated", $add);
    }

    public function crear_reporte_mejorado()
    {
        $sql = "
            SELECT c1.*, b1.cuenta_contable as cuentaContable
            FROM cobranza_aplicated c1
            INNER JOIN cobranza_aplicated c2 
                ON c1.concatenar = c2.concatenar 
                AND c2.cocatena_fecha = c1.cocatena_fecha
                AND c2.monto = c1.monto
                AND c2.tipo = 'Reporte'
            INNER JOIN cobranza_bancos b1 ON c1.cuenta_contable = b1.codigo
            WHERE c1.tipo = 'Credicard'
            and c1.create_user = " . $this->session->userdata['logged_in']['id'] . "
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function crear_reporte_monto_no_coincide()
    {
        $sql = "
            SELECT c1.*, c2.monto as rpc, b1.cuenta_contable as cuentaContable
            FROM cobranza_aplicated c1
            INNER JOIN cobranza_aplicated c2 
                ON c1.concatenar = c2.concatenar 
                AND c2.cocatena_fecha = c1.cocatena_fecha
                AND c2.monto <> c1.monto
                AND c2.tipo = 'Reporte'
            INNER JOIN cobranza_bancos b1 ON c1.cuenta_contable = b1.codigo
            WHERE c1.tipo = 'Credicard'
            and c1.create_user = " . $this->session->userdata['logged_in']['id'] . "
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function crear_reporte_no_coincide_concatenar()
    {
        $sql = "
            SELECT c1.*, b1.cuenta_contable as cuentaContable
            FROM cobranza_aplicated c1
            INNER JOIN cobranza_bancos b1 ON c1.cuenta_contable = b1.codigo
            WHERE c1.tipo = 'Credicard'
            AND NOT EXISTS (
            SELECT 1
            FROM cobranza_aplicated c2
            WHERE c2.concatenar = c1.concatenar
            AND c2.cocatena_fecha = c1.cocatena_fecha
            AND c2.tipo = 'Reporte'
            )
            and c1.create_user = " . $this->session->userdata['logged_in']['id'] . "
            ;
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function crear_reporte_duplicados()
    {
        $sql = "
            SELECT c1.*, b1.cuenta_contable as cuentaContable
            FROM cobranza_aplicated c1
            INNER JOIN cobranza_aplicated c2 
                ON c1.concatenar = c2.concatenar 
                AND c2.cocatena_fecha = c1.cocatena_fecha
                AND c2.monto = c1.monto
                AND c2.tipo = 'Reporte'
            INNER JOIN cobranza_bancos b1 ON c1.cuenta_contable = b1.codigo
            WHERE c1.tipo = 'Credicard'
            and c1.create_user = " . $this->session->userdata['logged_in']['id'] . "
            GROUP BY c1.concatenar, c1.cocatena_fecha, c1.monto, c1.tipo
            HAVING COUNT(*) > 1;
        ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function verificar_unificado()
    {
        $errores = [];

        $sql = "
            SELECT c1.*
            FROM cobranza_aplicated c1
            WHERE c1.tipo = 'Credicard'
            AND NOT EXISTS (
                SELECT 1 
                FROM cobranza_aplicated c2
                WHERE c2.tipo = 'Reporte'
                AND c2.concatenar = c1.concatenar
                AND c2.cocatena_fecha = c1.cocatena_fecha
        )
        ";

        $resultado = $this->db->query($sql)->result();

        foreach ($resultado as $row) {

            if (!empty($row->concatenar)) {
                $errores[] = "AFILIADO:" . $row->codigo_afiliacion . " - FECHA: " . $row->fecha . "\n";
            }
        }

        return implode("\n", $errores);
    }

    /*public function crear_reporte()
    {
        $this->db->from("cobranza_aplicated");
        $this->db->where("tipo", "Credicard");
        $query = $this->db->get();
        return $query->result();
    }*/

    /*public function verificar($concatenar, $fecha)
    {
        $this->db->select('*');
        $this->db->from('cobranza_aplicated');
        $this->db->where("tipo", "Reporte");
        $this->db->where("concatenar", $concatenar);
        $this->db->where("fecha", $fecha);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }*/
}
