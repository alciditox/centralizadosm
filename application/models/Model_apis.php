<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_apis extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }



    /**
     * API Generalizada
     * ----------------
     * Endpoint: segmento después de /Applications/
     * Ejemplo: "Banks/123"
     */
    private function call_api($endpoint, $retry = 2)
    {
        $api_base_url = $_ENV['API_BASE_URL'] ?? $_SERVER['API_BASE_URL'] ?? getenv('API_BASE_URL');
        $api_url = $_ENV['API_URL'] ?? $_SERVER['API_URL'] ?? getenv('API_URL');
        $base = $api_base_url ?: $api_url;

        $base = rtrim((string)$base, '/') . '/';
        $url = $base . ltrim($endpoint, '/');

        $api_port = $_ENV['API_PORT'] ?? $_SERVER['API_PORT'] ?? getenv('API_PORT');
        $port = $api_port ?: 8000;

        for ($i = 0; $i <= $retry; $i++) {

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_TIMEOUT        => 15, // No dejar colgar el servidor
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_PORT           => (int)$port
            ]);

            // Add SSL Version only for HTTPS connections
            if (strpos($url, 'https://') === 0) {
                curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            }

            $output = curl_exec($ch);
            $error  = curl_error($ch);
            $errno  = curl_errno($ch);

            curl_close($ch);

            // Si no hay error → devolver respuesta
            if (!$errno) {
                return json_decode($output, true);
            }

            // Log del error por intento
            log_message('error', "API ERROR (#$i): $endpoint → $error");

            // Espera 300ms antes de reintentar (anti-saturación)
            usleep(300000);
        }

        // Devuelve FALSE si falla todos los intentos
        return false;
    }

    /**
     * Obtiene bancos según ID
     */
    public function banks($bank_id = null)
    {
        return $this->call_api("Banks/$bank_id");
    }

    /**
     * Obtiene contratos domiciliados según banco
     */
    public function dcontracts($bank_id)
    {
        return $this->call_api("Dcontracts/$bank_id");
    }

    public function apiCustomer($rif)
    {
        return $this->call_api("CustomerCrm/$rif");
    }

    public function CustomerCrmId($customer_id)
    {
        return $this->call_api("CustomerCrmId/$customer_id");
    }

    public function apiContracts($customer_id)
    {
        return $this->call_api("ContractsCrm/$customer_id");
    }

    public function apiBuscoClienteXContrato($contract_id)
    {
        return $this->call_api("BuscoClienteXContrato/$contract_id");
    }
}
