<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_Front extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('MainModel');
		$this->load->library('pagination');
		$this->form_validation->set_error_delimiters('<label class="error">', '</lable>'); 
	}
	public function index()
	{	

	}
	public function how_its_work()
	{	
	    $header['page_title'] = 'Trader Network: How Its Work';
		$cond = array(
		    "slug"=>'howitworks'
	    );

	    $data['data'] = $this->MainModel->runselect('SELECT * from trader_cms where cms_ID in("8","9","10","11","12","13","14","15","16")');
 	
		$this->load->view("front/common/header",$header);
		$this->load->view('front/how-its-works',$data);
		$this->load->view("front/common/footer");
		
	}
	public function about_us()
	{	
		$cond = array(
		    "slug"=>'about-us'
	    );

	    $header['page_title'] = 'Trader Network: About Us';
		$data = $this->MainModel->fetchrow('trader_cms',$cond);

		$contentdata['contain']=$data->contain;
		$contentdata['title']=$data->page_title;
	
		$this->load->view("front/common/header",$header);
		$this->load->view('front/about-us',$contentdata);
		$this->load->view("front/common/footer");
		
	}
	public function privacy_policy()
	{	
		$cond = array(
		    "slug"=>'privacypolicy'
	    );

	    $header['page_title'] = 'Trader Network: Privacy Policy';
		$data = $this->MainModel->fetchrow('trader_cms',$cond);

		$contentdata['contain']=$data->contain;
		$contentdata['title']=$data->page_title;
		$contentdata['date']=$data->updatedDate;
	
		$this->load->view("front/common/header",$header);
		$this->load->view('front/privacy-policy',$contentdata);
		$this->load->view("front/common/footer");
		
	}
	public function term_condition()
	{	
		$cond = array(
		    "slug"=>'terms-condition'
	    );

	    $header['page_title'] = 'Trader Network: Terms & Condition';
		$data = $this->MainModel->fetchrow('trader_cms',$cond);

		$contentdata['contain']=$data->contain;
		$contentdata['title']=$data->page_title;
	
		$this->load->view("front/common/header",$header);
		$this->load->view('front/terms-condition',$contentdata);
		$this->load->view("front/common/footer");
		
	}
	public function faq()
	{	
		$cond = array(
		    "1"=>'1'
	    );

	    $header['page_title'] = 'Trader Network: FAQ';
		$data['trader_faq'] = $this->MainModel->fetchallrow('trader_faq',$cond);

		$this->load->view("front/common/header",$header);
		$this->load->view('front/faq',$data);
		$this->load->view("front/common/footer");
		
	}
	public function contact(){
		$header['page_title'] = 'Trader Network: Contact Us';
		$data['details'] = $setting = $this->MainModel->get_singlerecord('trader_settings',array('setting_ID'=> 1));

		$this->load->view("front/common/header",$header);
		$this->load->view('front/contact_us',$data);
		$this->load->view("front/common/footer");
    }
    public function contactmail(){  
 
        if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
 
 		//$this->form_validation->set_error_delimiters('<div class="test">', '</div>'); 
		//$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		//$this->form_validation->set_rules('subject', 'Email', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
 
        // $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdfSEIUAAAAACr9VayU46bGQSUzsrcsCdb_-Ic6&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        // if($response['success'] == false){ echo '<h2>You are spammer ! Get the @$%K out</h2>'; }
		if ($this->form_validation->run() == FALSE){
			$header['page_title'] = 'Trader Network: Contact Us';
			$data['details'] = $this->MainModel->get_singlerecord('trader_settings',array('setting_ID'=> 1));
			$this->load->view("front/common/header",$header);
			$this->load->view('front/contact_us',$data);
			$this->load->view("front/common/footer");
		}
        else
        {  
	        $data['firstname'] = $this->input->post('firstname');
	        $data['lastname'] = $this->input->post('lastname');
	        $data['subject'] = $this->input->post('subject');
	        $data['email'] = $this->input->post('email');
	        $data['message'] = $this->input->post('message');
	        $logo = $this->MainModel->get_singlerecord('trader_settings',array('setting_ID'=> 1));
	        $data['logo'] = base_url().'upload/logo/27112018172130trader-logo.png';
	       
	        $contactdata = $this->load->view("templates/contactus",$data,true);
	        
	        //print_r($contactdata);exit;

	        if($contactdata){

	        $condarr = array('user_ID'=>'1');
	        $rs = $this->MainModel->get_singlerecord("trader_user",$condarr);
	        $email = $rs->email;
	        //$usersubject = "Hi ".$this->input->post('firstname').' '.$this->input->post('lastname').', Your message has been received by us.';
	        $usersubject = 'Thank you for contacting Trader Network';
	        $senddata['name'] = $this->input->post('firstname').' '.$this->input->post('lastname');

	        $uscontent = $this->load->view("templates/usercontactus",$senddata,true);

	        //usermail mail
	        $useremail = $this->input->post('email');
	        //$useremail = "kishan.nyusoft@gmail.com";
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

			        $this->load->library('email', $config);
			        $this->email->set_newline("\r\n");

                    $this->email->from('support@trader-network.com','Trader Network');
			        $this->email->to($useremail);
			        $this->email->subject($usersubject);
			        $this->email->message($uscontent);
			        $this->email->set_mailtype("html");
			        $this->email->send();


			//admin mail        
 					$config2 = Array(
			                  //'protocol' => 'smtp',
			                  //'smtp_host' => 'ssl://smtp.googlemail.com',
			                  //'smtp_port' => 465,
			                  //'smtp_user' => 'abc@gmail.com', 
			                  //'smtp_pass' => 'passwrd', 
			                  'mailtype' => 'html',
			                  //'charset' => 'iso-8859-1',
			                  'wordwrap' => TRUE
			                );
	                    $this->load->library('email', $config2);
	                    $this->email->set_newline("\r\n");

	                    $this->email->from($useremail);
	                    $this->email->to($email);
	                    $this->email->subject("User Contact Request");
	                    $this->email->message($contactdata);
	                    $this->email->set_mailtype("html");
	                    $this->email->send();
	                   // redirect(base_url('front/user/contactmail'));
	                $errorfailed = "Your request has been successfully submitted.";
	                $this->session->set_flashdata('contactsuccess',$errorfailed);
	            }else{
	                $errorfailed = "Invalid Email Address.";
	                $this->session->set_flashdata('contacterror',$errorfailed);
	            }

	        redirect(base_url('contact-us'));
	    }
 	}
	
}
