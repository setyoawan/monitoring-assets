<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_Master');
    }

    public function index()
    {
        $data['title'] = 'Master Data';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();

        template('master/index', $data);
    }

    public function itam()
    {
        $data['title'] = 'Data Itam';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['itam'] = $this->M_Master->getItamData()->result();

        template('master/data_itam', $data);
    }

    function datatables_ajax()
    {
        /** AJAX Handle */
        if ($this->input->is_ajax_request()) {

            // $this->load->model('M_Karyawan');

            /**
             * Mengambil Parameter dan Perubahan nilai dari setiap 
             * aktifitas pada table
             *
             */
            $datatables  = $_POST;
            $datatables['table']    = 'monitoringassets_dataitam';
            $datatables['id-table'] = 'id';

            /**
             * Kolom yang ditampilkan
             */
            $datatables['col-display'] = array(
                'company',
                'model',
                'category',
                'username',
                'harga',
                'jumlah_device'
            );
            /**
             * menggunakan table join
             */
            // $datatables['join']    = 'INNER JOIN position ON position = id_position';
            $this->M_Master->Datatables($datatables);
        }
        return;
    }

    public function uploadItam()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path']      = 'assets/doc/itam/'; // path (folder)
        $config['allowed_types']    = 'xlsx|xls|csv';
        $config['max_size']         = '10000';
        $config['encrypt_name']     = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('message', '<div class="alert alert-danger"><b>Proses import gagal!</b> ' . $this->upload->display_errors() . '</div>');
            redirect('admin/');
        } else {

            $data_upload   = $this->upload->data();
            $excelreader   = new PHPExcel_Reader_Excel2007();
            $loadexcel     = $excelreader->load('assets/doc/itam/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet         = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                if ($numrow > 1) {
                    array_push($data, array(
                        'id' => $row['A'],
                        'company' => $row['B'],
                        'asset_tag' => $row['C'],
                        'column2'   => $row['D'],
                        'model'   => $row['E'],
                        'column3'   => $row['F'],
                        'category'   => $row['G'],
                        'column4'   => $row['H'],
                        'nik'   => $row['I'],
                        'manufacturer'   => $row['J'],
                        'serial'   => $row['K'],
                        'purchased'   => $row['L'],
                        'supplier'   => $row['M'],
                        'default_location'   => $row['N'],
                        'opco_itam'   => $row['O'],
                        'checked_out'   => $row['P'],
                        'username'   => $row['Q'],
                        'band'   => $row['R'],
                        'harga'   => $row['S'],
                        'harga_per_tahun'   => $row['T'],
                        'count'   => $row['U'],
                        'opco_hris_update_fix'   => $row['V'],
                        'directorate_hris'   => $row['W'],
                        'direktorat'   => $row['X'],
                        'departemen_kerja_hris_update_fix'   => $row['Y'],
                        'kompartemen_hris_update_fix'   => $row['Z'],
                        'column1'   => $row['AA'],
                        'status'   => $row['AB'],
                        'jumlah_device'   => $row['AC'],
                        'jenis'   => $row['AD'],
                        'column5'   => $row['AE'],
                        'notes'   => $row['AF'],
                        'no_kontrak'   => $row['AG'],
                        'validasi'   => $row['AH'],
                        'status_assets'   => $row['AI'],
                        'column6'   => $row['AJ'],
                        'request'   => $row['AK'],
                        'lokasi_unit'   => $row['AL'],
                        'cek_kontrak'   => $row['AM'],
                        'user_pilih_status'   => $row['AN'],
                        'user_pilih_date'   => $row['AO'],
                        'user_pilih_type'   => $row['AP']
                    ));
                }
                $numrow++;
            }
            // var_dump($data);
            // die();
            $this->db->insert_batch('monitoringassets_dataitam', $data);
            //delete file from server
            // unlink(realpath('excel/' . $data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('message', '<div class="alert alert-success">Proses import berhasil! Data berhasil diimport!</div>');
            redirect('master/itam');
        }
    }

    public function assets()
    {
        $data['title'] = 'Type Assets';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['assets'] = $this->M_Master->getAssetsData()->result();

        $this->form_validation->set_rules('code', 'Code', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        $this->form_validation->set_rules('specs', 'Specs', 'required|trim');
        $this->form_validation->set_rules('budget', 'Budget', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            template('master/data_assets', $data);
        } else {
            $data = array(
                'code' => $this->input->post('code'),
                'category' => $this->input->post('category'),
                'budget_alct' => $this->input->post('budget'),
                'specs' => $this->input->post('specs')
            );
            $this->db->insert('monitoringassets_typeassets', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Assets added!</div>');
            redirect('master/assets');
        }
    }

    public function editAssets()
    {
        $data['title'] = 'Type Assets';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['assets'] = $this->M_Master->getAssetsData()->result();

        $this->form_validation->set_rules('code', 'Code', 'required|trim');
        $this->form_validation->set_rules('category', 'Category', 'required|trim');
        $this->form_validation->set_rules('specs', 'Specs', 'required|trim');
        $this->form_validation->set_rules('budget', 'Budget', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            template('master/data_assets', $data);
        } else {
            $data = array(
                'code' => $this->input->post('code'),
                'category' => $this->input->post('category'),
                'budget_alct' => $this->input->post('budget'),
                'specs' => $this->input->post('specs')
            );

            $where = array(
                'id' => $this->input->post('id')
            );
            $this->db->update('monitoringassets_typeassets', $data, $where);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Update Data!</div>');
            redirect('master/assets');
        }
    }

    public function deleteAssets($id)
    {
        $where = array('id' => $id);
        $this->db->delete('monitoringassets_typeassets', $where);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Assets Deleted!</div>');
        redirect('master/assets');
    }
}
