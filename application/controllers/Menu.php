<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {           
            template('menu/index', $data);            
        } else {
            $this->db->insert('user_menu', array('menu' => $this->input->post('menu')));
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }


    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $this->load->model('M_Menu', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() ==  false) {           
            template('menu/submenu', $data);          
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('menu/submenu');
        }
    }

    public function editMenu()
    {

        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            $data['title'] = 'Menu Management';           
            template('menu/index', $data);          
        } else {
            $data = array(
                'menu' => $this->input->post('menu')
            );

            $where = array(
                'id' => $this->input->post('id')
            );
            $this->db->update('user_menu', $data, $where);
            $this->session->set_flashdata('alert', '<div class="alert alert-success" role="alert">Success Update Data!</div>');
            redirect('menu');
        }
    }

    public function hapusMenu($id)
    {
        $where = array('id' => $id);
        $this->db->delete('user_menu', $where);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu Deleted!</div>');
        redirect('menu');
    }
}
