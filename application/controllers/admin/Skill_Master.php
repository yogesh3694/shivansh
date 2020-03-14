<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Skill_Master extends CI_Controller {

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
		$page['page_name'] = 'Trader Network:Skill Management';
		$data['skilldata'] = $this->AdminModel->getdata('trader_skills');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/skill/skill_main',$data);
			$this->load->view('admin/common/footer');
	}
	public function add_skill()
	{   
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Add Skill';
   		$this->form_validation->set_rules('skill', 'Please Enter skill', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['skilldata'] = $this->AdminModel->getdata('trader_skills');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/skill/skill_main',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$this->session->set_flashdata('success','Skill Successfully Added..');
			$this->AdminModel->insertdata("trader_skills",array('name' => $this->input->post('skill'),'isActive'=>'1','isDelete'=>'0'));
			redirect(base_url('admin/skills'));
		}
	}
	public function edit($id = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit Skill';
		$this->form_validation->set_rules('skill', 'skill', 'required');
		 
		if ($this->form_validation->run() == FALSE) { 
			$data['skilldata'] = $this->AdminModel->get_singlerecord('trader_skills',array('skill_ID'=>$id));
			$data['allskill'] = $this->AdminModel->getdata('trader_skills');
			//print_r($data['faqdata']); exit;
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/skill/edit_skill',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			$up = $this->AdminModel->updatedata('trader_skills','skill_ID',$id,array('name' => $this->input->post('skill'),'isActive'=>'1','isDelete'=>'0'));
			if($up){
				$this->session->set_flashdata('success','Skill successfully updated.');	
				redirect(base_url('admin/skills'));		
			}
		
		}
	}
	public function delete($id)
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$del = $this->AdminModel->removedata('trader_skills',"skill_ID",$id);
		if($del){
			$this->session->set_flashdata('success','Skill successfully Deleted..');	
			redirect(base_url('admin/skills'));
		}
	}
}
