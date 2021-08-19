<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Videos extends CI_Controller
{
    private $table = 'NWS_VIDEOS';
    public function __construct()
    {
        parent::__construct();
		
		if (!$this->session->userdata('login')) {
			redirect('login');
            return;
		}
		
        $this->load->model('M_Videos');
    }
    public function index()
    {
        $data = array(
            'videos' => $this->M_Videos->all(),
            'header' => '<link href="' . base_url('assets/css/video.css') . '" rel="stylesheet">',
            'footer' => '<script src="' . base_url('assets/js/video.js') . '"></script>'
        );
        template('admin/videos/index', $data);
    }
    public function do_upload()
    {
        $config['upload_path']          = './file/videos/';
        $config['allowed_types']        = 'mp4|3gp|flv';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('video')) {
			return $this->upload->display_errors();
        } else {
            return $this->upload->data('file_name');
        }
    }
    public function create()
    {
        if ($this->validate()) {
            $data = array(
                'TITLE' => $this->input->post('title'),
                'STATUS' => $this->input->post('status'),
                'VIDEO' => $this->do_upload(),
            );
			if($data['VIDEO'] === $this->upload->data('file_name')){
				if ($this->db->insert($this->table, $data)) {
					$this->session->set_flashdata('success', true);
					$this->session->set_flashdata('alert', 'Data Berhasil Ditambah!');
					echo json_encode(array('status' => 200));
					return;
				}
			}
            $this->session->set_flashdata('success', false);
            $this->session->set_flashdata('alert', $this->upload->display_errors() ? $this->upload->display_errors() :'Data Gagal Ditambah!');
            echo json_encode(array('status' => 404));
            return;
        }
        redirect('/admin/videos/');
    }

    public function find($id)
    {
        echo json_encode($this->db->where('ID', $id)->get($this->table)->row_object());
    }
    public function update($id = null)
    {
        if ($this->validate(true) && $id != null) {
            $data = array(
                'TITLE' => $this->input->post('title'),
                'STATUS' => $this->input->post('status'),
            );
            $this->db->where('ID', $id);
            if ($this->db->update($this->table, $data)) {
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Diubah!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Diubah!');
            }
        }
        redirect('/admin/videos/');
    }
    public function delete($id = null)
    {
        if ($id != null) {
            $data = $this->db->where("ID", $id)->get($this->table)->row_object();
            if ($this->db->where('ID', $id)->delete($this->table)) {
                if ($data->VIDEO != 0 || !is_null($data->VIDEO)) {
                    if (file_exists('./file/videos/' . $data->VIDEO)) {
                        unlink('./file/videos/' . $data->VIDEO);
                    }
                }
                $this->session->set_flashdata('success', true);
                $this->session->set_flashdata('alert', 'Data Berhasil Dihapus!');
            } else {
                $this->session->set_flashdata('success', false);
                $this->session->set_flashdata('alert', 'Data Gagal Dihapus!');
            }
        }
        redirect('/admin/videos/');
    }
    private function validate($update = false)
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        return true;
    }
}
