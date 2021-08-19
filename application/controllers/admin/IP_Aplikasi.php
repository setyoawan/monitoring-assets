<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IP_Aplikasi extends CI_Controller
{
    private $table = 'NWS_IP';
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
        redirect('admin/IP_Aplikasi');
    }
    public function find($id = null)
    {
        if ($id != null) {
            $data = $this->db->where('ID', $id)->get($this->table)->row_object();
            echo json_encode($data);
        } else {
            redirect('/admin/IP_Aplikasi/');
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
        redirect('/admin/IP_Aplikasi/');
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
        redirect('/admin/IP_Aplikasi/');
    }

    public function oracle_date($timestamp = '')
    {
        $this->load->helper('date');
        if ($timestamp == 'date') {
            $datestring = '%d-%M-%Y';
        } else {
            $datestring = '%d-%M-%Y %h.%i.%s %a';
        }

        $time = time();
        $timestamp = strtoupper(mdate($datestring, $time));
        return $timestamp;
    }
    public function ping()
    {
        $ip =   "10.15.5.150";
        exec("ping -n 3 $ip", $output, $status);
        print_r($output);
        echo exec("ping www.google.com");
    }

    public function getData()
    {
        return array(
            'IP' => $this->input->post('ip'),
            'LOKASI' => $this->input->post('lokasi'),
            'STATUS' => 1,
            'LAST_UPDATE' =>  $this->oracle_date('timestamp')
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
