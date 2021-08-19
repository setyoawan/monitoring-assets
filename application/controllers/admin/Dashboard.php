<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function index()
    {
		if (!$this->session->userdata('login')) {
			redirect('login');
			return;
		}
        $this->load->model('M_Videos');
        $this->load->model('M_Activities');
        $this->load->model('M_Room');
        $data = array(
            'videos' => $this->M_Videos->count(),
            'activities' => $this->M_Activities->count(),
            'rooms' => $this->M_Room->count(),
			'dataAgenda' =>$this->M_Room->inprogress(),
            'footer' => '<script src="' . base_url('vendor/admin-template/assets/libs/chartist/dist/chartist.min.js') . '"></script>
			<script src="' . base_url('assets/js/dashboard.js') . '"></script>
            <script src="' . base_url('vendor/admin-template/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') . '"></script>'
        );
        template('admin/dashboard', $data);
    }
}
