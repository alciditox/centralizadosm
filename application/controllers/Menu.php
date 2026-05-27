<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('model_menu');
        $this->load->model('Permissions');
    }

    public function index()
    {
        $data['list'] = $this->model_menu->list();
        $data['main_content'] = 'menu/index';
        $this->load->view('layout/template', $data);
    }

    public function view($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID de menú no válido.');
            redirect('/menu');
            return;
        }

        $data['menu'] = $this->model_menu->get_by_id($id);

        if (empty($data['menu'])) {
            $this->session->set_flashdata('error', 'Menú no encontrado.');
            redirect('/menu');
            return;
        }

        $data['main_content'] = 'menu/view';
        $this->load->view('layout/template', $data);
    }

    public function create()
    {
        $postData = $this->input->post();

        if ($postData) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url', 'URL', 'trim|xss_clean');
            $this->form_validation->set_rules('icon', 'Icono', 'trim|xss_clean');
            $this->form_validation->set_rules('parent', 'Menú Padre', 'trim|xss_clean');
            $this->form_validation->set_rules('status', 'Estado', 'trim|required|xss_clean');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $add = [
                    'nombre' 	=> $postData['nombre'],
                    'url' 		=> $postData['url'] ?? null,
                    'icon' 		=> $postData['icon'] ?? null,
                    'parent' 	=> empty($postData['parent']) ? null : $postData['parent'],
                    'status' 	=> $postData['status']
                ];

                $result = $this->model_menu->create($add);

                if ($result) {
                    $this->session->set_flashdata('success', 'Menú creado exitosamente.');
                    redirect('/menu');
                    return;
                }

                $this->session->set_flashdata('error', 'Error al crear el menú.');
            }
        }

        $data['parent_menus'] = $this->model_menu->get_all_for_select();
        $data['main_content'] = 'menu/create';
        $this->load->view('layout/template', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID de menú no válido.');
            redirect('/menu');
            return;
        }

        $data['menu'] = $this->model_menu->get_by_id($id);

        if (empty($data['menu'])) {
            $this->session->set_flashdata('error', 'Menú no encontrado.');
            redirect('/menu');
            return;
        }

        $postData = $this->input->post();

        if ($postData) {
            $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url', 'URL', 'trim|xss_clean');
            $this->form_validation->set_rules('icon', 'Icono', 'trim|xss_clean');
            $this->form_validation->set_rules('parent', 'Menú Padre', 'trim|xss_clean');
            $this->form_validation->set_rules('status', 'Estado', 'trim|required|xss_clean');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
            } else {
                $update = [
                    'nombre' 	=> $postData['nombre'],
                    'url' 		=> $postData['url'] ?? null,
                    'icon' 		=> $postData['icon'] ?? null,
                    'parent' 	=> empty($postData['parent']) ? null : $postData['parent'],
                    'status' 	=> $postData['status']
                ];

                $result = $this->model_menu->update($id, $update);

                if ($result) {
                    $this->session->set_flashdata('success', 'Menú actualizado exitosamente.');
                    redirect('/menu');
                    return;
                }

                $this->session->set_flashdata('error', 'Error al actualizar el menú.');
            }
        }

        $data['parent_menus'] = $this->model_menu->get_all_for_select();
        $data['main_content'] = 'menu/edit';
        $this->load->view('layout/template', $data);
    }

    public function delete($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID de menú no válido.');
            redirect('/menu');
            return;
        }

        $menu = $this->model_menu->get_by_id($id);

        if (empty($menu)) {
            $this->session->set_flashdata('error', 'Menú no encontrado.');
            redirect('/menu');
            return;
        }

        $result = $this->model_menu->delete($id);

        if ($result) {
            $this->session->set_flashdata('success', 'Menú eliminado exitosamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al eliminar el menú.');
        }

        redirect('/menu');
    }

    public function change_status($id = null)
    {
        if (!$id) {
            $this->session->set_flashdata('error', 'ID de menú no válido.');
            redirect('/menu');
            return;
        }

        $menu = $this->model_menu->get_by_id($id);

        if (empty($menu)) {
            $this->session->set_flashdata('error', 'Menú no encontrado.');
            redirect('/menu');
            return;
        }

        $new_status = ($menu->status === 'Activo') ? 'Inactivo' : 'Activo';

        $update = [
            'status' => $new_status
        ];

        $result = $this->model_menu->update($id, $update);

        if ($result) {
            $this->session->set_flashdata('success', 'Estado actualizado exitosamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar el estado.');
        }

        redirect('/menu');
    }
}
