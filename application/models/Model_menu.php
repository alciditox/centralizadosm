<?php

defined('BASEPATH') || exit('No direct script access allowed');


class Model_menu extends CI_Model
{
    public function menuPrincipal($permiso)
    {

        $query = "
			SELECT men.*
			FROM menu men
			INNER JOIN roles_permisos rol ON rol.menu_id = men.id
			WHERE men.status='Activo'
			AND men.parent IS NULL
			AND rol.rol_id = {$permiso}
			ORDER BY men.id ASC
		";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    public function menuSubMenu($num = null, $permiso = null)
    {

        $query = "
			SELECT men.*
			FROM menu men
			INNER JOIN roles_permisos rol ON rol.menu_id = men.id
			WHERE men.status='Activo'
			AND men.parent='{$num}'
			AND men.parent IS NOT NULL
			AND rol.rol_id = {$permiso}
			ORDER BY men.id ASC
		";
        $sql = $this->db->query($query);
        return $sql->result();
    }

    public function list()
    {
        $this->db->select('menu.*, parent_menu.nombre as parent_nombre');
        $this->db->from('menu');
        $this->db->join('menu as parent_menu', 'parent_menu.id = menu.parent', 'left');
        $this->db->order_by('menu.id', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('menu.*, parent_menu.nombre as parent_nombre');
        $this->db->from('menu');
        $this->db->join('menu as parent_menu', 'parent_menu.id = menu.parent', 'left');
        $this->db->where('menu.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function create($data)
    {
        return $this->db->insert('menu', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('menu', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('menu');
    }

    public function get_parent_menus()
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('parent IS NULL');
        $this->db->order_by('id', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_for_select()
    {
        $this->db->select('id, nombre, parent, status');
        $this->db->from('menu');
        $this->db->order_by('id', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
}
