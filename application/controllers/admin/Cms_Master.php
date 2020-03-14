<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Cms_master extends CI_Controller {

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
		$page['page_name'] = 'Trader Network:Manage CMS';
		$data['allcms'] = $this->AdminModel->getdata('trader_cms');
		  
		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/cms/cms_main',$data);
		$this->load->view('admin/common/footer');
		 
	}
	public function update()
	{  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		 $page['page_name'] = 'Trader Network:Manage CMS';
		if($this->input->post())
		{
			$slug = $this->input->post('pageslug');
			$cond = array('slug' => $slug);
			$result = $this->AdminModel->get_singlerecord('trader_cms',$cond);

			
				if($this->input->post('homehidden') == 'homesection1'){

					$data = array(
						'page_title' => $this->input->post('pagetitle1'),
						'contain'     		 => $this->input->post('pagecontent1'),
						'updatedDate'        => date("Y-m-d H:i:s")
						);
					$this->AdminModel->updatedata("trader_cms",'cms_ID',1,$data);
					
					if($this->input->post('homehidden2') == 'homesection2'){

						$data2 = array(
							'page_title' => $this->input->post('pagetitle2'),
							'contain'     		 => $this->input->post('pagecontent2'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',3,$data2);
							// $this->session->set_flashdata('message','CMS page successfully updated'); 
						    
						 //    redirect(base_url('admin/Cms_Master/'));
						}	 	
					$this->session->set_flashdata('message','CMS page successfully updated'); 
				    redirect(base_url('admin/Cms_Master/'));
				}
				else if($this->input->post('stephidden1') == 'step1'){

				//echo "<pre>";	print_r($_POST); echo "</pre>"; exit;

						$data1 = array(
							'page_title' => $this->input->post('steptitle1'),
							'contain'     		 => $this->input->post('stepcontent1'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',8,$data1);
					
						$data2 = array(
							'page_title' => $this->input->post('steptitle2'),
							'contain'     		 => $this->input->post('stepcontent2'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',9,$data2);

						$data3 = array(
							'page_title' => $this->input->post('steptitle3'),
							'contain'     		 => $this->input->post('stepcontent3'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',10,$data3);

						$data4 = array(
							'page_title' => $this->input->post('steptitle4'),
							'contain'     		 => $this->input->post('stepcontent4'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',11,$data4);

						$data5 = array(
							'page_title' => $this->input->post('usertitle'),
							'contain'     		 => $this->input->post('usercontent'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',12,$data5);

						$data6 = array(
							'page_title' => $this->input->post('pretitle'),
							'contain'     		 => $this->input->post('precontent'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',13,$data6);

						$data7 = array(
							'page_title' => $this->input->post('atttitle'),
							'contain'     		 => $this->input->post('attcontent'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',14,$data7);
						
						$data8 = array(
							'page_title' => $this->input->post('paytitle'),
							'contain'     		 => $this->input->post('paycontent'),
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',15,$data8);	 

						$data9 = array(
							'page_title' => $this->input->post('pagetitle'),
							'contain'     		 => '',
							'updatedDate'        => date("Y-m-d H:i:s")
							);
							$this->AdminModel->updatedata("trader_cms",'cms_ID',16,$data9);	 
					 	 	 

					$this->session->set_flashdata('message','CMS page successfully updated'); 
				    redirect(base_url('admin/Cms_Master/'));
				} 
			else{
				if(!empty($result)){
					$data = array(
					'page_title' => $this->input->post('pagetitle'),
					'slug'			 => $this->input->post('pageslug'),
					'contain'     		 => $this->input->post('pagecontent'),
					'updatedDate'        => date("Y-m-d H:i:s")
					);
					$this->AdminModel->updatedata("trader_cms",'slug',$slug,$data);
					$this->session->set_flashdata('message','CMS page successfully updated'); 
				    
				    redirect(base_url('admin/Cms_Master/'));
				}
			}
		/*	else{
				$data = array(
				'page_title' => $this->input->post('pagetitle'),
				'slug'			 => $this->input->post('pageslug'),
				'contain'     		 => $this->input->post('pagecontent'),
				'createdDate'        => date("Y-m-d H:i:s"),
				'updatedDate'        => date("Y-m-d H:i:s")
				);
				$this->AdminModel->insertdata("trader_cms",$data);
				$this->AdminModel->updatedata("trader_cms",'slug',$slug,$data);
				$this->session->set_flashdata('message','Data Inserted Successfully'); 
			    redirect(base_url('admin/Cms_Master/'));
			}*/
  		} 
		 
	}
	
	 

}