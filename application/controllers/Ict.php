<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ict extends CI_Controller
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
        $data['itam'] = $this->M_Master->getItamData()->result();
       
        template('ict/index', $data);
        
    }

    public function datatables_ajax()
    {		
		if($this->input->is_ajax_request()) {			
			$datatables  = $_POST;
			$datatables['table']    = 'monitoringassets_dataitam';
			$datatables['id-table'] = 'id';
					
			$datatables['col-display'] = array(
			               'company',
			               'model',
			               'category',
			               'username',
			               'harga',
                           'jumlah_device'
			             );			
			$this->M_Master->Datatables($datatables);
		}
		return;
    }
}
