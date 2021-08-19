<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Room extends CI_Controller
{
    private $table = 'NWS_ROOM_BOOKING';

    public function __construct()
    {
        parent::__construct();
		if (!$this->session->userdata('login')) {
			redirect('login');
            return;
		}
        $this->load->model('M_Karyawan');
        $this->load->model('M_Room');
    }

    public function index()
    {

        $rooms = $this->M_Room->all();
        $newData = array();
        foreach ($rooms as $i => $room) {
            $newData[$i] = $room;
            $newData[$i]['TANGGAL'] = date('Y-m-d', strtotime($room['TANGGAL']));
        }
        $data = array(
            'room' => $newData,
            'footer' => '<script src="' . base_url('assets/js/room.js') . '"></script>'
        );
        template('admin/room/index', $data);
    }

    public function create()
    {
        $data = array(
            'footer' => '<script src="' . base_url('assets/js/room.js') . '"></script>'
        );
        template('admin/room/create', $data);
    }
    public function insert()
    {
        if ($this->validate()) {
            $data = $this->getData();
            if ($this->db->insert($this->table, $data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Ditambah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Ditambah!');
            }
        }
        redirect('/admin/room/');
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $room = $this->M_Room->find($id);
            $room['TANGGAL'] = date('Y-m-d', strtotime($room['TANGGAL']));
            $data = array(
                'room' => $room,
                'footer' => '<script src="' . base_url('assets/js/room.js') . '"></script>'
            );

            template('admin/room/update', $data);
            return;
        }
        redirect('/admin/room/');
    }
    public function update($id = null)
    {
        if ($this->validate(true) && $id != null) {
            $data = $this->getData();
            $this->db->where('ID', $id);
			
			
            if ($this->db->update($this->table, $data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Diubah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Diubah!');
            }
        }
        redirect('/admin/room/');
    }


    public function delete($id = null)
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
        redirect('/admin/room/');
    }


    private function getData()
    {
        return array(
            'USER_ID' => $this->input->post('user'),
            'TANGGAL' => date('d-M-Y', strtotime($this->input->post('tanggal'))),
            'JAM_MULAI' => $this->input->post('jam_mulai'),
            'JAM_SELESAI' => $this->input->post('jam_selesai'),
            'UNIT' => $this->input->post('unit'),
			'STATUS' => $this->input->post('status'),
        );
    }
    private function validate()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('user', 'user', 'required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        $this->form_validation->set_rules('jam_mulai', 'jam_mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'jam_selesai', 'required');
        $this->form_validation->set_rules('unit', 'unit', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        return true;
    }
}
