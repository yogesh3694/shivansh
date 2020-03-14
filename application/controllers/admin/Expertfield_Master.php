<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expertfield_Master extends CI_Controller {

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
		$page['page_name'] = 'Trader Network:Expert Field Management';
		$data['fielddata'] = $this->AdminModel->getdata('trader_expert_field');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/expert_field/field_main',$data);
			$this->load->view('admin/common/footer');
	}
	public function add_field()
	{   
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Add Expert Field';
   		$this->form_validation->set_rules('field', 'Please Enter skill', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['skilldata'] = $this->AdminModel->getdata('trader_skills');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/expert_field/field_main',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$this->session->set_flashdata('success','Expert Field Successfully Added.');
			$this->AdminModel->insertdata("trader_expert_field",array('name' => $this->input->post('field'),'createdDate'=>date("Y-m-d H:i:s"),'updatedDate'=>date("Y-m-d H:i:s")));
			redirect(base_url('admin/expert-fields'));
		}
	}
	public function edit($id = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit Expert Field';
		$this->form_validation->set_rules('field', 'field', 'required');
		 
		if ($this->form_validation->run() == FALSE) { 
			$data['fielddata'] = $this->AdminModel->get_singlerecord('trader_expert_field',array('field_ID'=>$id));
			$data['allfield'] = $this->AdminModel->getdata('trader_expert_field');
			//print_r($data['faqdata']); exit;
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/expert_field/edit_field',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$up = $this->AdminModel->updatedata('trader_expert_field','field_ID',$id,array('name' => $this->input->post('field'),'updatedDate'=>date("Y-m-d H:i:s")));
			if($up){
				$this->session->set_flashdata('success','Expert Field Successfully Updated.');	
				redirect(base_url('admin/expert-fields'));		
			}
		
		}
	}
	public function delete($id)
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$del = $this->AdminModel->removedata('trader_expert_field',"field_ID",$id);
		if($del){
			$this->session->set_flashdata('success','Expert Field Successfully Deleted.');	
			redirect(base_url('admin/expert-fields'));
		}
	}
}
