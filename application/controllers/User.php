<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_Master');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['assets'] = $this->M_Master->getAssetsData()->result();

        template('user/index', $data);
    }

    public function datatables_ajax()
    {
        $dataItamUser = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        if ($this->input->is_ajax_request()) {
            $datatables  = $_POST;
            $datatables['table']    = 'monitoringassets_dataitam';
            $datatables['id-table'] = 'id';
            $datatables['filterkey'] = $dataItamUser['nik'];


            $datatables['col-display'] = array(
                'checked_out',
                'category',
                'model',
                'status',
                'user_pilih_status',
            );
            $this->M_Master->DatatablesUser($datatables);
        }
        return;
    }

    public function view_data_where()
    {
        $dataItamUser = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $nik = $dataItamUser['nik'];
        $tables = "monitoringassets_dataitam";
        $search = array('checked_out', 'category', 'model', 'status', 'user_pilih_status');
        $where  = array('nik' => $nik);
        $isWhere = null;

        header('Content-Type: application/json');
        echo $this->M_Master->get_tables_where($tables, $search, $where, $isWhere);
    }

    public function itam()
    {
        $data['title'] = 'Itam Data';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['itam'] = $this->M_Master->getItamData()->result();       

        $this->form_validation->set_rules('jenis_kebutuhan', 'Kenis_kebutuhan', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            template('user/edit', $data);
        } else {
            $data = array(
                'user_pilih_status' => $this->input->post('jenis_kebutuhan'),
                'user_pilih_type' => $this->input->post('type'),
                'user_pilih_date' => date("Y-m-d H:i:s")
            );

            $where = array(
                'id' => $this->input->post('id')
            );
            $this->db->update('monitoringassets_dataitam', $data, $where);            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Itam Data Update</div>');
            redirect('user');
        }
    }
}
