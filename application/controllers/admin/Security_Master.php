<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Security_Master extends CI_Controller {

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
	public function index()
	{	 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Security Question';
		$data['securitydata'] = $this->AdminModel->getdata('trader_users_security_que');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/security_question/question_main',$data);
			$this->load->view('admin/common/footer');
	}
	public function add_question()
	{   
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Add FAQ';
   		$this->form_validation->set_rules('question', 'Please Enter Question', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['securitydata'] = $this->AdminModel->getdata('trader_users_security_que');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/security_question/question_main',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$this->session->set_flashdata('success','Security Question Successfully Added..');
			$this->AdminModel->insertdata("trader_users_security_que",array('question' => $this->input->post('question')));
			redirect(base_url('admin/security-question'));
		}
	}
	public function edit($id = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit Question';
		$this->form_validation->set_rules('question', 'Question', 'required');
		 
		if ($this->form_validation->run() == FALSE) { 
			$data['securitydata'] = $this->AdminModel->get_singlerecord('trader_users_security_que',array('que_ID'=>$id));
			$data['allquedata'] = $this->AdminModel->getdata('trader_users_security_que');
			//print_r($data['faqdata']); exit;
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/security_question/edit_question',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$up = $this->AdminModel->updatedata('trader_users_security_que','que_ID',$id,array('question' => $this->input->post('question'),));
			if($up){
				$this->session->set_flashdata('success','Security Question successfully updated.');	
				redirect(base_url('admin/security-question'));		
			}
		
		}
	}
	public function delete($id)
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$del = $this->AdminModel->removedata('trader_users_security_que',"que_ID",$id);
		if($del){
			$this->session->set_flashdata('success','Security Question successfully Deleted..');	
			redirect(base_url('admin/security-question'));
		}
	}
}
