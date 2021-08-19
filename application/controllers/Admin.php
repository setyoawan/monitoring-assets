<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->helper(array('url', 'download'));
        $this->load->model('M_Admin');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['itam'] = $this->M_Admin->countItamData();
        $data['assets'] = $this->M_Admin->countAssetsData();
        $data['usercount'] = $this->M_Admin->countUserData();
        $data['email'] = $this->M_Admin->countUserEmail();

        template('admin/index', $data);
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        template('admin/role', $data);
    }

    public function editRole()
    {

        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required|trim');

        if ($this->form_validation->run() ==  false) {
            $data['title'] = 'Role';
            template('admin/role', $data);
        } else {
            $data = array(
                'role' => $this->input->post('role')
            );

            $where = array(
                'id' => $this->input->post('id')
            );
            $this->db->update('user_role', $data, $where);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Update Data.</div>');
            redirect('admin/role');
        }
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();

        $data['role'] = $this->db->get_where('user_role', array('id' => $role_id))->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        template('admin/role-access', $data);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = array(
            'role_id' => $role_id,
            'menu_id' => $menu_id
        );

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function downloadtemplate()
    {
        force_download('assets/doc/template/user.xlsx', NULL);
    }

    public function userManagement()
    {
        $data['title'] = 'User';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $data['usermanagement'] = $this->M_Admin->getUserData()->result();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('nik', 'Nik', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            array(
                'is_unique' => 'This email has already registered!'
            )
        );
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|matches[password2]',
            array(
                'matches' => 'Password dont match!',
                'min_length' => 'Password too short!'
            )
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() ==  false) {
            template('admin/user_management', $data);
        } else {
            $email = $this->input->post('email', true);
            $data = array(
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'nik' => $this->input->post('nik'),
                'image' => 'default.jpg',
                'password' => md5($this->input->post('password1')),
                'role_id' => $this->input->post('role_id'),
                'is_active' => 1,
                'date_created' => time()
            );
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New user added!</div>');
            redirect('admin/usermanagement');
        }
    }

    public function editUser()
    {
        $data['title'] = 'User';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('nik', 'Nik', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email',
            array(
                'is_unique' => 'This email has already registered!'
            )
        );
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'trim|min_length[3]',
            array(
                'min_length' => 'Password too short!'
            )
        );
        // $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() ==  false) {
            template('admin/user_management', $data);
        } else {
            if ($this->input->post('password1') == '' || NULL) {
                $email = $this->input->post('email', true);
                $data = array(
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'nik' => $this->input->post('nik'),
                    'image' => 'default.jpg',
                    'role_id' => $this->input->post('role_id'),
                    'is_active' => 1,
                );
            } else {
                $email = $this->input->post('email', true);
                $data = array(
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'nik' => $this->input->post('nik'),
                    'image' => 'default.jpg',
                    'password' => md5($this->input->post('password1')),
                    'role_id' => $this->input->post('role_id'),
                    'is_active' => 1,
                );
            }
            $where = array(
                'id' => $this->input->post('id')
            );
            $this->db->update('user', $data, $where);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Update Data.</div>');
            redirect('admin/usermanagement');
        }
    }

    public function hapusUser($id)
    {
        $data = array(
            'is_active' => 0
        );
        $where = array('id' => $id);
        $this->M_Admin->deleteUser($where, $data, 'user');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User Deleted!</div>');
        redirect('admin/usermanagement');
    }

    public function uploadUser()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path']      = 'assets/doc/user/'; // path (folder)
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
            $loadexcel     = $excelreader->load('assets/doc/user/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet         = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $data = array();

            $numrow = 1;
            foreach ($sheet as $row) {
                if ($numrow > 1) {
                    array_push($data, array(
                        'id' => $row['A'],
                        'name' => $row['B'],
                        'email' => $row['C'],
                        'nik' => $row['D'],
                        'image'   => $row['E'],
                        'password'   => $row['F'],
                        'role_id'   => $row['G'],
                        'is_active'   => $row['H'],
                        'date_created' => time()
                    ));
                }
                $numrow++;
            }
            $this->db->insert_batch('user', $data);
            //delete file from server
            unlink(realpath('assets/doc/user/' . $data_upload['file_name']));

            //upload success
            $this->session->set_flashdata('message', '<div class="alert alert-success">User Import Success!</div>');
            redirect('admin/userManagement');
        }
    }

    public function tessend()
    {

        $send_mail['to'] = 'setyoawanprakoso@gmail.com';
        $send_mail['cc'] = 'setyoawan8@gmail.com';
        $send_mail['subject'] = "Batas waktu Closed LTK tanggal ";
        $send_mail['isi'] = "Dengan Hormat,<br/><br/>								
        Demikian, atas perhatian dan kerjasamanya disampaikan terima kasih.";

        $this->sendemail($send_mail);
    }

    public function userList()
    {
        // POST data
        $postData = $this->input->post();
        // Get data
        $data = $this->M_Admin->getUsers($postData);
        echo json_encode($data);
    }

    public function email()
    {
        $data['title'] = 'Email';
        $data['user'] = $this->db->get_where('user', array('email' => $this->session->userdata('email')))->row_array();
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        // $this->form_validation->set_rules('subject','Subject','required|trim|');

        if ($this->form_validation->run() ==  false) {
            template('admin/email', $data);
        } else {

            $data = array(
                'to' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'isi' => $this->input->post('isi'),
                'date_created' => time()
            );
            $this->db->insert('user_email', $data);
            $this->sendemail($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sending Email!</div>');
            redirect('admin/email');
        }
    }

    public function get_data()
    {
        $keyword = $this->uri->segment(3);
        $data = $this->db->from('countries')->like('list_name', $keyword)->get();

        foreach ($data->result() as $row) {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value'    => $row->list_name
            );
        }
        echo json_encode($arr);
    }

    public function sendemail($data, $debug = false)
    {
        $config['protocol']  = "smtp";
        $config['smtp_host'] = "relay.sig.id";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "";
        $config['smtp_pass'] = "";
        $config['mailtype']  = "html";
        $config['newline']   = "\r\n";
        $config['charset']   = 'utf-8';
        $config['wordwrap']  = true;
        $config['crlf']      = "\r\n";
        $this->email->initialize($config);

        $this->email->from("noreply-monitoring@sig.id", "Aplikasi Monitoring Assets");

        if (isset($data['to']) && is_array($data['to'])) {
            $data['to'] = array_unique($data['to']);
        }

        $this->email->to($data['to']);
        //$this->email->to("taufik.dev@gmail.com");
        //$this->email->to("drajad.latif@sisi.id");
        //print_r($data['to']);
        //exit;
        //$this->email->to("galih.purdaniyanto@semenindonesia.com");
        if (isset($data['cc']) && !empty($data['cc']) && count($data['cc']) > 0) {
            if (isset($data['cc']) && is_array($data['cc'])) {
                $data['cc'] = array_unique($data['cc']);
            }
            $this->email->cc($data['cc']);
            //$this->email->to("drajadcareer@gmail.com");
        }
        //add bcc for dev
        //$this->email->bcc('drajad.latif@sisi.id','hery.kurniawan@semenindonesia.com');
        //$this->email->bcc('drajad.latif@sisi.id','test.email@semenindonesia.com');

        $this->email->subject($data['subject']);
        $this->email->message($data['isi']);
        // comment by awp
        // if (isset($data['attach']) && !empty($data['attach']) && count($data['attach']) > 0) {
        //     for ($i = 0; $i < count($data['attach']); $i++) {
        //         $this->email->attach($data['attach'][$i]);
        //     }
        // }
        if ($debug == true) {
            $smail = $this->email->send(FALSE);
            echo $this->email->print_debugger(array('headers'));
            die();
        } else {
            $smail = $this->email->send();
        }
        return $smail;
    }
}
