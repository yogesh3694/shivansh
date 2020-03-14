<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Faq_master extends CI_Controller {

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
		$page['page_name'] = 'Trader Network:FAQ';
		$data['faqdata'] = $this->AdminModel->getdata('trader_faq');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/faq/faq_main',$data);
			$this->load->view('admin/common/footer');
	}
	public function add_faq()
	{   
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Add FAQ';
   		$this->form_validation->set_rules('question', 'Please Enter Question', 'required');
   		$this->form_validation->set_rules('answer', 'Please Enter  Answer', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/faq/add_faq');
			$this->load->view('admin/common/footer');
		}
		else
		{
			$data = array(
				'question' => $this->input->post('question'),
				'answer' => $this->input->post('answer'), 
				'createdDate'=> date("Y-m-d H:i:s"),
				'updatedDate'=> date("Y-m-d H:i:s")
				/*'_IsActive'=> '1',
				'_IsDeleted'=> '0'*/
			);
			$this->session->set_flashdata('success','FAQ Successfully Added..');
			$this->AdminModel->insertdata("trader_faq",$data);
			redirect(base_url('admin/faqs'));
		}
	}
	public function edit($id = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit FAQ';
		$this->form_validation->set_rules('question', 'Question', 'required');
		$this->form_validation->set_rules('answer', 'Answer', 'required');
		if ($this->form_validation->run() == FALSE) { 
			$data['faqdata'] = $this->AdminModel->get_singlerecord('trader_faq',array('faq_ID'=>$id));
			$data['allfaqdata'] = $this->AdminModel->getdata('trader_faq');
			//print_r($data['faqdata']); exit;
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/faq/edit_faq',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{
			$data = array(
				'question' => $this->input->post('question'),
				'answer' => $this->input->post('answer'),
				'updatedDate'=> date("Y-m-d H:i:s") 
				/*'_IsActive'=> '1',
				'_IsDeleted'=> '0'*/
			);
			$up = $this->AdminModel->updatedata('trader_faq','faq_ID',$id,$data);
			if($up){
				$this->session->set_flashdata('success','FAQ successfully updated.');	
				redirect(base_url('admin/faqs'));		
			}
		
		}
	}
	public function delete($id)
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$del = $this->AdminModel->removedata('trader_faq',"faq_ID",$id);
		if($del){
			$this->session->set_flashdata('success','FAQ successfullly Deleted..');	
			redirect(base_url('admin/faqs'));
		}
	}
}
