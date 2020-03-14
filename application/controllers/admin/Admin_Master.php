<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Admin_master extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->helper(array('url','form','text'));
		$this->load->library(array('form_validation','session','upload','form_validation'));
		$this->load->model(array('admin/AdminModel','admin/MainModel'));
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>'); 
		$this->form_validation->set_message('required','%s');
		$this->form_validation->set_message('valid_email','Please enter valid email.');
		$this->form_validation->set_message('is_unique','email is already registered.');
		$this->form_validation->set_message('matches','Password does not match.');
		$this->form_validation->set_message('alpha','Please enter alphabat only.');
	}

	public function user_login_process(){	
    
		if($this->session->userdata['logged_in']['adminid'] != ''){
			redirect(base_url('admin/dashboard'));
		}
	    $this->form_validation->set_rules('user_email', 'email', 'trim|required');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required');		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/login');
		}else{
			$data = array(
				'email' => $this->input->post('user_email'),
				'password' => md5($this->input->post('password'))
			);	
			//print_r($data);		
			$result = $this->MainModel->login($data);
			//print_r($result);
		//echo 	$this->db->last_query();
		
			if($result){
				$session_data = array('adminid' => $result->user_ID,
									'first_name' => $result->first_name,
									'last_name' => $result->last_name,
								 );

				$data = $this->session->set_userdata('logged_in',$session_data);
				redirect(base_url('admin/dashboard'));
			}else{
					$this->session->set_flashdata('errmsg', 'Invalid Email or Password.');
					redirect(base_url('admin'));
				// $data = array(
				// 	'error_message' => 'Invalid Username or Password....'
				// );
				// $this->load->view('admin/login',$data);
			}
		}
	}
	public function logout(){
		$this->session->unset_userdata(array('logged_in'));
		$this->session->set_flashdata('message_display', 'Successfully Logout');
		redirect(base_url('admin'));
	}
	public function forgotpass(){
		
        $this->form_validation->set_rules('txtemail', 'Email', 'required');
        $title['datatitle'] = "Forgot Password";
        if ($this->form_validation->run() == FALSE){
            $this->load->view('admin/master/header');
		 	$this->load->view('admin/user/forgot',$title);
		 	$this->load->view('admin/master/footer');
        }else{
		    $uscond = array("_Email" => $this->input->post('txtemail'));
		    $emailex = $this->MainModel->getcount("users",$uscond);
		    if($emailex > 0){
	            $newpass = $this->genratepassword();
	            $email = $this->input->post('txtemail');
	            $data = array(
	                        '_Password'=>$newpass 
	                    );
	            $condition = array(
		                    "_Email"=>$email,
		                    "_IsActive"=>"1",
		                    "_IsDeleted"=>"0"
	                    );
	            $result  = $this->MainModel->forgotpassword($data,$email);
	            $userdata = $this->MainModel->fetchrow("users",$condition);
	            $data['mailed_data'] = $userdata;
	            $usercontent = $this->load->view("templates/admin_forgot_password",$data,true);
	            $config = Array(
	                      'mailtype' => 'html',
	                      'wordwrap' => TRUE
	                    );
	            $this->load->library('email', $config);
	            $this->email->set_newline("\r\n");
	            $this->email->from('harshpatel.nyusoft@gmail.com','Smartverc');
	            $this->email->to('ravi.nyusoft@gmail.com');
	            $this->email->subject("Smartverc: Reset Password");
	            $this->email->message($usercontent);
	            $this->email->set_mailtype("html");
	            $this->email->send();
	            redirect(base_url('admin'));
	  		}else{
		        $errorfailed = "Invalid Email Address.";
		        $this->session->set_flashdata('forgoterror',$errorfailed);
		        $this->load->view('admin/master/header');
			 	$this->load->view('admin/user/forgot',$title);
			 	$this->load->view('admin/master/footer');
   			}
	  	}
	}
    public function genratepassword(){
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
		return $randomString;
    }
	public function get_header(){
		$this->load->view('admin/master/header');
	}
	public function get_footer(){
		$this->load->view('admin/master/footer');
	}
	public function do_upload($filename,$path){
		$image_path = realpath(APPPATH ."../images/".$path);
        $config['upload_path']          = $image_path;
        $config['allowed_types']        = 'gif|jpg|png|pdf|doc';
        $config['max_size']             = 5000000;
        $config['max_width']            = 2000000;
        $config['max_height']           = 76800000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($filename))
        {
			$file_data = array('error' => $this->upload->display_errors());
        }
        else
		{ 
			$file_data = array('upload_data' => $this->upload->data());
        }
		return $file_data;
    }

}