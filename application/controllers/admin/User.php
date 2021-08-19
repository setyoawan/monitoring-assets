<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $table = 'NWS_USER';
	
	
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('login') || $this->session->userdata('role') !== '1') {
			redirect('login');
            return;
		}
	}
	
    public function index()
    {
        $data = array(
            'users' => $this->db->get($this->table)->result_array(),
            'footer' => '<script src="' . base_url('assets/js/user.js') . '"></script>'
        );
        template('admin/user/index', $data);
    }
    public function create()
    {
        $data = array(

            'footer' => '<script src="' . base_url('assets/js/user.js') . '"></script>'
        );
        template('admin/user/create', $data);
    }

    public function insert()
    {
        if (!$this->validate())
            return;

        $data = $this->getData();
        if ($data['LDAP_FLAG'] == 1) {
            $data['PASSWORD'] = md5($this->input->post('password'));
        }
        if ($this->db->insert($this->table, $data)) {
            $this->session->set_flashdata('success', true);
            $this->session->set_flashdata('alert', 'Data Berhasil Ditambah!');
        } else {
            $this->session->set_flashdata('success', false);
            $this->session->set_flashdata('alert', 'Data Gagal Ditambah!');
        }

        redirect('/admin/user/');
    }

    public function edit($id)
    {
        if ($id == null) {
            redirect('/admin/user/');
        }
        $data = array(
            'user' => $this->db->where('ID', $id)->get($this->table)->row_array(),
            'footer' => '<script src="' . base_url('assets/js/user.js') . '"></script>'
        );
        template('admin/user/update', $data);
        return;
    }

    public function update($id)
    {
        if ($id == null) {
            redirect('/admin/user/');
        }
        if (!$this->validate()) {
            return;
        }
        $data = $this->getData();
        if ($data['LDAP_FLAG'] == 1 && $this->input->post('password')) {
            $user = $this->db->where('ID', $id)->get($this->table)->row_array();
            if ($user['PASSWORD'] != md5($this->input->post('currentPass'))) {

                $dataUser = array(	
                    'user' => $this->db->where('ID', $id)->get($this->table)->row_array(),
                    'footer' => '<script src="' . base_url('assets/js/user.js') . '"></script>'
                );
                $this->session->set_flashdata('alert', 'Password Salah');
                template('admin/user/update', $dataUser);
                return;
            }
            $data['PASSWORD'] = md5($this->input->post('password'));
        }


        $this->db->where('ID', $id);
        if ($this->db->update($this->table, $data)) {
            $this->session->set_flashdata('success', true);
            $this->session->set_flashdata('alert', 'Data Berhasil Diubah!');
        } else {
            $this->session->set_flashdata('success', false);
            $this->session->set_flashdata('alert', 'Data Gagal Diubah!');
        }

        redirect('/admin/user/');
    }
    public function delete($id)
    {
        if ($id != null) {
            $this->db->where('ID', $id);
            if ($this->db->delete($this->table)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Dihapus!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Dihapus!');
            }
        }
        redirect('/admin/user/');
    }


    private function getData()
    {
        $data = array(
            'USERNAME' => $this->input->post('username'),
            'NAMA' => $this->input->post('nama'),
            'LDAP_FLAG' => $this->input->post('jenis_user'),
            'ROLE' => $this->input->post('role'),
        );

        return $data;
    }

    private function validate()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('jenis_user', 'jenis_user', 'required');
        $this->form_validation->set_rules('role', 'role', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        return true;
    }
}
