<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_Controller extends CI_Controller 
{	
	public function __construct() {
        parent::__construct();
		
	}
   
    public function SendMail($data,$debug=false)
    {
        $this->load->library('email');
		// print_r($data);
        $config['protocol']  = "smtp";
        $config['smtp_host'] = "relay.sig.id";
        $config['smtp_port'] = "25";
        $config['smtp_user'] = "";
        $config['smtp_pass'] = "";
        $config['mailtype']  = "html";
        $config['newline']   = "\r\n";
		$config['charset']   = 'utf-8';
		$config['wordwrap']  = true;
		$config['crlf'] 	 = "\r\n";
        $this->email->initialize($config);

        $this->email->from("noreply-monitoring@sig.id","Aplikasi Monitoring Assets");

		if(isset($data['to']) && is_array($data['to'])){
			$data['to'] = array_unique($data['to']);
		}

        $this->email->to($data['to']);
		//$this->email->to("taufik.dev@gmail.com");
		//$this->email->to("drajad.latif@sisi.id");
        //print_r($data['to']);
        //exit;
        // $this->email->to("galih.purdaniyanto@semenindonesia.com");
		if(isset($data['cc']) && !empty($data['cc']) && count($data['cc'])>0){
			if(isset($data['cc']) && is_array($data['cc'])){
				$data['cc'] = array_unique($data['cc']);
			}
			$this->email->cc($data['cc']);
			//$this->email->to("drajadcareer@gmail.com");
		}
		//add bcc for dev
		//$this->email->bcc('drajad.latif@sisi.id','hery.kurniawan@semenindonesia.com');
//		$this->email->bcc('drajad.latif@sisi.id','test.email@semenindonesia.com');

        $this->email->subject($data['subject']);
        $this->email->message($data['isi']);
		if(isset($data['attach']) && !empty($data['attach']) && count($data['attach'])>0){
			for($i=0;$i<count($data['attach']);$i++){
				$this->email->attach($data['attach'][$i]);
			}
        }
		if($debug==true){
			$smail = $this->email->send(FALSE);
			echo $this->email->print_debugger(array('headers')) ;
			die();
		}else{
			$smail = $this->email->send();
		}
		return $smail;
    }

}
