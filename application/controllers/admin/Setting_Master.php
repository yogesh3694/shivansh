<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_master extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->helper(array('url','form','text'));
		$this->load->library(array('form_validation','session','upload'));
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
		$page['page_name'] = "Setting";
		$data['admindata'] = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=> $this->session->userdata['logged_in']['adminid'] ));
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/setting/admin_profile',$data);
			$this->load->view('admin/common/footer');
	}
	public function edit($id = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = "Setting";
		$this->form_validation->set_rules('first_name', 'firstname', 'required');
		$this->form_validation->set_rules('last_name', 'lastname', 'required');
		if ($this->form_validation->run() == FALSE) {   
			$data['admindata'] = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=> $this->session->userdata['logged_in']['adminid'] ));
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/setting/admin_profile',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{  
			$profile = date("dmYHis").$_FILES["profile"]['name'];
            $image_path = realpath(APPPATH . '../upload/profile/');

            $config['file_name']            = $profile;
            $config['upload_path']          = $image_path;
            $config['allowed_types']        = 'jpg|png|jpeg';
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);	
            if( ! $this->upload->do_upload('profile'))
            {  
				$data['imgerr'] = $this->upload->display_errors();
                $data['cnt'] = $this->AdminModel->getdata('trader_countries');
				$this->load->view('admin/common/nav',$page);
				$this->load->view('admin/common/header');
				$this->load->view('admin/setting/admin_profile',$data);
				$this->load->view('admin/common/footer');
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'updatedDate'=> date("Y-m-d H:i:s") 
				);
				$up = $this->AdminModel->updatedata('trader_user','user_ID',$id,$data);
				if($up){
					$this->session->set_flashdata('success','Profile successfully updated.');	
					redirect(base_url('admin/Setting_Master'));		
				}
			}
			else
			{  
				$image = $this->upload->data('file_name');
				$fullpath = $this->upload->data();
				$this->resize_image($fullpath,40,40);
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'profile_photo' => $image,
					'updatedDate'=> date("Y-m-d H:i:s") 
				); 
				$up = $this->AdminModel->updatedata('trader_user','user_ID',$id,$data);
				if($up){
					$this->session->set_flashdata('success','Profile successfully updated.');	
					redirect(base_url('admin/Setting_Master'));		
				}
			}
		
		}
	}
	public function edit_setting($sid = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
			   
	$page['page_name'] = "Trader Network :: Setting";
		if($this->input->post('logosubmit') != ''){
			if(isset($_FILES['sitelogo']['name'])){

				$logo = date("dmYHis").$_FILES["sitelogo"]['name'];
	            $image_path = realpath(APPPATH . '../upload/logo/');
	            $config['file_name']            = $logo;
	            $config['upload_path']          = $image_path;
	            $config['allowed_types']        = 'jpg|png|jpeg|svg';
	            //$config['allowed_types']        = 'png';

				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);	
	            if( ! $this->upload->do_upload('sitelogo'))
	            { 
	       			$data['imgerr'] = $this->upload->display_errors();
	       			$data['setting'] = $this->AdminModel->get_singlerecord('trader_settings',array('setting_ID'=>1));
					$this->load->view('admin/common/nav');
					$this->load->view('admin/common/header');
					$this->load->view('admin/setting/setting',$data);
					$this->load->view('admin/common/footer');     		
	            }
	            else{
	            	$data = array(
						'logo' => $this->upload->data('file_name'),
						'updatedDate'=> date("Y-m-d H:i:s") 
					); 
				$id = 1;
				$up = $this->AdminModel->updatedata('trader_settings','setting_ID',$id,$data);
	            	$this->session->set_flashdata('success','Logo Set Successfullly..');	
					redirect(base_url('admin/Setting_Master/edit_setting'));		
	            }

			}
		}
		elseif ($this->input->post('keepinsubmit') != '') {
			$data = array(
					'footer_email' => $this->input->post('adminemail'),
					'footer_skype' => $this->input->post('adminskype'),
					'fb_link' => $this->input->post('fblink'),
					'linkedin_link' => $this->input->post('linkedinlink'),
					'insta_link' => $this->input->post('instalink'),
					'skype_link' => $this->input->post('skypelink'),
					'updatedDate'=> date("Y-m-d H:i:s") 
				); 
				$id = 1;
				$up = $this->AdminModel->updatedata('trader_settings','setting_ID',$id,$data);
				//$up = $this->AdminModel->insertdata('trader_settings',$data);

				if($up){
					$this->session->set_flashdata('success','Setting Successfullly Updated.');	
					redirect(base_url('admin/Setting_Master/edit_setting'));		
				}
				
		}
		else{
			$data['setting'] = $this->AdminModel->get_singlerecord('trader_settings',array('setting_ID'=>1));
  			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/setting/setting',$data);
			$this->load->view('admin/common/footer'); 
		}
	
	}
	public function resize_image($upload_data,$width,$height)
    {
        $this->load->library('image_lib');
        $config1 = array(
            'image_library'=>'gd2',
            'source_image' => $upload_data['full_path'],
            //'create_thumb'=>'150x150',
            'new_image' => $upload_data['raw_name']. "-".$width."x".$height.$upload_data['file_ext'],
            'maintain_ratio' => false,
            'width' => $width,
            'height' => $height
        );
        //Image Autorotating Resize Orientation Setting
        $filename = $upload_data['full_path'];
        $this->image_lib->initialize($config1);
        $this->image_lib->resize();
        $this->image_lib->clear();

        return $config1['new_image'];  
    }
}
