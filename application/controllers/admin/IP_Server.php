<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IP_Server extends CI_Controller
{
    private $table = 'NWS_IP';
	
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('login')) {
			redirect('login');
            return;
		}
	}
    public function index()
    {
	
        date_default_timezone_set('Asia/Jakarta');
        $IP = $this->db->get($this->table)->result_array();
        $data = array(
            'footer' => '<script src="' . base_url('assets/js/IP.js') . '"></script>',
            'IP' => $IP,
        );
        template('admin/IP/index', $data);
    }

    public function create()
    {
        if ($this->validate()) {
            $data = $this->getData();
            // var_dump($data);
            // die;
            if ($this->db->insert($this->table, $data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Ditambah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Ditambah!');
            }
        }
        redirect('admin/IP_Server');
    }
    public function find($id = null)
    {
        if ($id != null) {
            $data = $this->db->where('ID', $id)->get($this->table)->row_object();
            echo json_encode($data);
        } else {
            redirect('/admin/IP_Server/');
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
        redirect('/admin/IP_Server/');
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
        redirect('/admin/IP_Server/');
    }
   

    public function getData()
    {
		exec("ping -n 1 ".$this->input->post('ip'), $output, $status);
        return array(
            'IP' => $this->input->post('ip'),
            'LOKASI' => $this->input->post('lokasi'),
            'STATUS' => $status == 1 ? 0 : 1,
			'LAST_UPDATE' => date('Y-m-d H:i:s')
         );
    }

    public function validate()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('ip', 'ip', 'required');
        $this->form_validation->set_rules('lokasi', 'lokasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        return true;
    }
}
