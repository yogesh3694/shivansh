<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class User_master extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->helper(array('url','form','text','admin_email'));
		$this->load->library(array('form_validation','session','upload','form_validation'));
		$this->load->model(array('admin/AdminModel','MainModel'));
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>'); 
		$this->form_validation->set_message('required','%s');
		$this->form_validation->set_message('valid_email','Please enter valid email.');
		$this->form_validation->set_message('is_unique','email is already registered.');
		$this->form_validation->set_message('matches','Password does not match.');
		$this->form_validation->set_message('alpha','Please enter alphabat only.');
        include_once 'MailChimp.php';
	}
	public function index(){  
		if($this->session->userdata('userid')) {
                redirect(base_url());
        }
		$this->form_validation->set_error_delimiters('<div class="test">', '</div>'); 
		$this->form_validation->set_rules('user_email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');	 
		$data['page_title'] = "Trader Network :: Sign In";
		if ($this->form_validation->run() == FALSE){
			$this->load->view('front/common/header',$data);
			$this->load->view('front/login');
			$this->load->view('front/common/footer');
			
		}else{
            if($this->input->post('rememberme'))
            {
                setcookie('rememail', $this->input->post('user_email'), time() + (10 * 365 * 24 * 60 * 60),'/');
                setcookie('rempwd', $this->input->post('password'), time() + (10 * 365 * 24 * 60 * 60),'/');
            }
		  $this->login_user();
		}
	}
	public function login_user()
	{  
		if($_POST) {  
            $result = $this->MainModel->validate_user($_POST);
            
            if(!empty($result)) {
                if($result->isVerify == "1"){

                            $firstname = $result->first_name;
                            $lastname = $result->last_name;

                            if($result->profile_photo != ""){
                                $profileimg = "uploads/profilepictures/".$result->_Profileimage;
                            }else{
                                $profileimg = "assets/images/radio-user-icon.png";                   
                            }

                    	$data = [
                            'userid' => $result->user_ID,
                            'email' => $result->email,
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                        ];
         
                        $this->session->set_userdata($data);
                       
                    $this->session->set_flashdata('loginsucess', '');
                       redirect(base_url());			   
                }else{

                    /*$userrow = $this->MainModel->get_singlerecord("trader_user",array('email' => $this->input->post('user_email')));    
                    $maildata['mailed_data'] = array(
                                        "username"=>$userrow->first_name.' '.$userrow->last_name,
                                        'email'     => $userrow->email,
                                        'password'  => $this->input->post('password'),
                                        'logo'    => base_url().'assets/images/trader-logo.png',
                                        'verify_link'     => $userrow->verify_link
                                    );
                     
                    $usercontent = $this->load->view("templates/welcome",$maildata,true);
                    // echo "<pre>";
                    $email = $this->input->post('user_email');
                    //$email = "kishan.nyusoft@gmail.com";
                    $config = Array(
                              //'protocol' => 'smtp',
                              //'smtp_host' => 'ssl://smtp.googlemail.com',
                              //'smtp_port' => 465,
                              //'smtp_user' => 'abc@gmail.com', 
                              //'smtp_pass' => 'passwrd', 
                              'mailtype' => 'html',
                              //'charset' => 'iso-8859-1',
                              'wordwrap' => TRUE
                            );

                    //$subject = "Hi ".$this->input->post('first_name').", it’s Rita from Trader Network.";
                    $subject = "Hi ".$userrow->first_name.", Welcome to Trader Network";

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");

                    $this->email->from('support@trader-network.com','Trader Network');
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message($usercontent);
                    $this->email->set_mailtype("html");
                    $this->email->send();*/

                    $this->session->set_flashdata('loginfailed', 'An email has been sent to you. Please verify your account before sign in.');
	                $this->load->view('front/common/header');
					$this->load->view('front/login');
					$this->load->view('front/common/footer');
                    //redirect(base_url('login'));
                }
            } else {
                $this->session->set_flashdata('loginfailed', 'Your email address or password is invalid.');
                $this->load->view('front/common/header');
				$this->load->view('front/login');
				$this->load->view('front/common/footer');
            }
        }
    } 

	public function logout() {
        setcookie('rememail', '', time() - (10 * 365 * 24 * 60 * 60),'/');
        setcookie('rempwd', '', time() - (10 * 365 * 24 * 60 * 60),'/');
        $data = array('userid','firstname','lastname');
        $this->session->unset_userdata($data);
        $this->session->set_flashdata('loginsucess', 'Logout successfully..');
        redirect(base_url());
    }
	public function forgotpass(){
		
        $this->form_validation->set_rules('user_email', 'Email', 'required');
        $title['datatitle'] = "Forgot Password";
        
        if ($this->form_validation->run() == FALSE){
            $this->load->view('admin/master/header');
		 	$this->load->view('admin/user/forgot',$title);
		 	$this->load->view('admin/master/footer');
        }else{
		    $uscond = array("_Email" => $this->input->post('user_email'));
		    $emailex = $this->MainModel->getcount("users",$uscond);
		    if($emailex > 0){
	            $newpass = $this->genratepassword();
	            $email = $this->input->post('user_email');
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
		        $this->load->view('admin/master/header',$title);
			 	$this->load->view('admin/user/forgot');
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

 	public function subscribe_mailchimp()
    {       
     
    if (isset($_POST['subbtn'])) {
         
        if (empty($_POST['subscribe_mail'])) {
                //echo 'Please enter a name and email address.';
                $this->session->set_flashdata('err_msg','Please enter email address.');
        } else {
            //$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $email = filter_var($_POST['subscribe_mail'], FILTER_SANITIZE_EMAIL);
            /*
             * Place here your validation and other code you're using to process your contact form.
             * For example: mail('your@mail.com', 'Subject: contact form', $_POST['message']);
             * Don't forget to validate all your form input fields!
             */
                $mc = new \Drewm\MailChimp('37340da126b61807626d31302a1de63c-us19');


                    //$mvars = array('optin_ip'=> $_SERVER['REMOTE_ADDR'], 'FNAME' => $name);

                $result = $mc->call('lists/subscribe', array(
                        'id'                => 'd1176aafba',
                        'email'             => array('email'=>$email),
                        //'merge_vars'        => $mvars,
                        'double_optin'      => true,
                        'update_existing'   => false,
                        'replace_interests' => false,
                        'send_welcome'      => false
                    )
                );
                if (!empty($result['euid'])) {
                    //echo 'Thanks, please check your mailbox and confirm the subscription.';
                    $this->session->set_flashdata('suc_msg', 'Please check your inbox or spam folder to confirm your subscription.');
                } else {
                    if (isset($result['status'])) {
                        switch ($result['code']) {
                            case 214:
                            //echo 'You\'re already a member of this list.';
                            $this->session->set_flashdata('err_msg','You\'re already a member of this list.');
                            break;
                            // check the MailChimp API docs for more codes
                            default:
                            //echo 'An unknown error occurred.';
                            $this->session->set_flashdata('err_msg','An unknown error occurred.');
                            break;
                        }
                    }
                }
             
        }
    }
    // redirect to homepage
    redirect(base_url('#footerpart'));

    } 



}