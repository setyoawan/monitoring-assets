<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activities extends CI_Controller
{
    private $table = 'NWS_ACTIVITIES';
    public function __construct()
    {
        parent::__construct();
		
        if (!$this->session->userdata('login')) {
			redirect('login');
            return;
		}
        $this->load->model('M_Activities');
       
    }
    public function index()
    {
        $data = array(
            'activities' => $this->M_Activities->all(),
            'footer' => '<script src="' . base_url('assets/js/activity.js') . '"></script>'
        );
        template('admin/activities/index', $data);
    }

    public function create()
    {
        if ($this->validate()) {
            $data = $this->getData();

            if ($this->M_Activities->create($data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Ditambah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Ditambah!');
            }
        }
        redirect('/admin/activities/');
    }


    public function find($id = null)
    {
        if ($id != null) {
            $data = $this->db->where('ID', $id)->get($this->table)->row_object();
            $data->TANGGAL_AKTIFITAS = date('Y-m-d', strtotime($data->TANGGAL_AKTIFITAS));
            echo json_encode($data);
        } else {
            redirect('/admin/activities/');
        }
    }
    public function update($id = null)
    {
        if ($this->validate() && $id !== null) {
            $data = $this->getData();
            if ($this->db->where('ID', $id)->update($this->table, $data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Diubah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Diubah!');
            }
        }
        redirect('/admin/activities/');
    }
    public function delete($id = null)
    {
        if ($id != null) {
            if ($this->db->where('ID', $id)->delete($this->table)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Dihapus!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Dihapus!');
            }
        }
        redirect('/admin/activities/');
    }

    private function getData()
    {
        return array(
            'TANGGAL_AKTIFITAS' => date('d-M-Y', strtotime($this->input->post('tanggal'))),
            'JAM' => $this->input->post('jam'),
            'NAMA' => $this->input->post('nama'),
            'AKTIFITAS' => $this->input->post('aktifitas'),
            'STATUS' => $this->input->post('status'),
        );
    }

    private function validate()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('jam', 'jam', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('aktifitas', 'aktifitas', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        return true;
    }
}
