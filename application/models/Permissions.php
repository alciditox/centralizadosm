<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permissions extends CI_Model
{
    public function call($menu)
    {
        $rol = $this->session->userdata['logged_in']['rol'];

        $this->db->select(' count(id) AS conteo ');
        $this->db->from('roles_permisos');
        $this->db->where('rol_id', $rol);
        $this->db->where('menu_id', $menu);
        $query = $this->db->get();
        $row = $query->row();

        if ($row->conteo == 0) {
            $this->session->set_flashdata('error', 'Modulo no encontrado.');
            redirect('/dashboard');
        }
    }
}
