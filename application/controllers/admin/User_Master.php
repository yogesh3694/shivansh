<?php   
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class User_master extends CI_Controller {

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
		$this->form_validation->set_error_delimiters('<label class="error" for="virtual_name">', '</label>');
	}
	public function index()
	{  
		//print_r($this->session->userdata); exit;
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		//$page['page_name'] = "All Users"; 
		$page['page_name'] = 'Trader Network:All Users';
		 
		$data['userdata'] = $this->AdminModel->get_user();
		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/user/user_main',$data);
		$this->load->view('admin/common/footer');
		 
	} 
	public function userlist_ajax(){  
	error_reporting(!E_NOTICE);
//$_REQUEST['search']['value']="kis";
		if($_REQUEST['search']['value']!=''){
			$search="AND first_name LIKE '".$_REQUEST['search']['value']."%' OR last_name LIKE '".$_REQUEST['search']['value']."%' OR total_skill_points LIKE '".$_REQUEST['search']['value']."%' OR market_point LIKE '".$_REQUEST['search']['value']."%' OR (SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`) LIKE '".$_REQUEST['search']['value']."%' OR (SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`) LIKE '".$_REQUEST['search']['value']."%'";
		}else{
			$search="";
		}

	 	$selquerycount =$this->AdminModel->runselect("SELECT `u`.*, `u`.`user_ID` as `uid`, `u`.`email` as `useremail`, CONCAT((SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`), ', ', (SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`)) AS location FROM `trader_user` as `u` WHERE `u`.`role_type` != '0' AND `u`.`isDelete` = '0' ".$search."");

 		 $selquery ="SELECT `u`.*, `u`.`user_ID` as `uid`, `u`.`email` as `useremail`, CONCAT((SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`), ', ', (SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`)) AS location FROM `trader_user` as `u` WHERE `u`.`role_type` != '0' AND `u`.`isDelete` = '0' ".$search." LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'];

        $disdata1 = $this->AdminModel->runselect($selquery);

        
      
         	$i=$_REQUEST['start'];
            foreach($disdata1 as $user){ $i++;
 
	            $action = '<a href="'.base_url().'admin/view-user/'.$user->user_ID.'" title="View"><i class="icon icon-20"></i></a><a href="'.base_url().'admin/edit-user/'.$user->user_ID.'" title="Edit"><i class="icon icon-19"></i></a><a href="'.base_url().'admin/User_Master/delete/'.$user->user_ID.'" onclick="return confirm(\'Are you sure you want to delete this user?\')" title="Remove"><i class="icon icon-18"></i></a>';
 
                if($user->profile_photo !=''){
                	
		            $image_path = base_url('upload/profile/' . $user->profile_photo);
	                $thumb_path = preg_replace('~\.(?!.*\.)~', '-37x37.', $image_path);

	                ini_set('allow_url_fopen', true);

	                if (getimagesize($thumb_path)) {
	                    $image_path2 = $thumb_path;
	                }
	          		 $img='<img src="'.$image_path2.'">'.$user->first_name.' '.$user->last_name;
            	}else{
					$img='<img src="'.base_url().'assets/images/none-user-47x39.jpg">'.$user->first_name.' '.$user->last_name;
				}

setlocale(LC_MONETARY, 'en_IN');
$markerpoint = money_format('%!.0n',$user_Details[0]->market_point);
	            $data[] = array( $i.'.',
	            				 $img,
	            				 $user->location !='' ? $user->location : '-',
	            				 $user->total_skill_points !=''?money_format('%!.0n',$user->total_skill_points): '-',
	            				 $user->market_point !='' ?money_format('%!.0n',$user->market_point):'-',
	            				 $action); 
	            				  
            }

        $dataCount = count($selquerycount);

        	if(empty($data)){ $data = 0; }
			
			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);

         
	}
	public function withdrawallist_ajax(){  
	error_reporting(!E_NOTICE);


		$selquerycount =$this->AdminModel->runselect("SELECT `u`.*, `u`.`user_ID` as `uid`, `u`.`email` as `useremail`, CONCAT((SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`), ', ', (SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`)) AS location FROM `trader_user` as `u` WHERE `u`.`role_type` != '0' AND `u`.`isDelete` = '0'");
		$disdata1 = $this->AdminModel->getalldata('trader_withdrawal_request');
		$disdata1 = $this->AdminModel->getalldata('trader_withdrawal_request');

 		 $selquery ="SELECT `u`.*, `u`.`user_ID` as `uid`, `u`.`email` as `useremail`, CONCAT((SELECT `name` FROM `trader_countries` WHERE `country_ID`=`u`.`country`), ', ', (SELECT `name` FROM `trader_cities` WHERE `city_ID`=`u`.`city`)) AS location FROM `trader_user` as `u` WHERE `u`.`role_type` != '0' AND `u`.`isDelete` = '0'  LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'];

        $disdata1 = $this->AdminModel->runselect($selquery);

        
      
         	$i=$_REQUEST['start'];
            foreach($disdata1 as $user){ $i++;
 
	            $action = '<a href="'.base_url().'admin/view-user/'.$user->user_ID.'" title="View"><i class="icon icon-20"></i></a><a href="'.base_url().'admin/edit-user/'.$user->user_ID.'" title="Edit"><i class="icon icon-19"></i></a><a href="'.base_url().'admin/User_Master/delete/'.$user->user_ID.'" onclick="return confirm(\'Are you sure you want to delete this user?\')" title="Remove"><i class="icon icon-18"></i></a>';
 
                if($user->profile_photo !=''){
                	
		            $image_path = base_url('upload/profile/' . $user->profile_photo);
	                $thumb_path = preg_replace('~\.(?!.*\.)~', '-37x37.', $image_path);

	                ini_set('allow_url_fopen', true);

	                if (getimagesize($thumb_path)) {
	                    $image_path2 = $thumb_path;
	                }
	          		 $img='<img src="'.$image_path2.'">'.$user->first_name.' '.$user->last_name;
            	}else{
					$img='<img src="'.base_url().'assets/images/none-user-47x39.jpg">'.$user->first_name.' '.$user->last_name;
				}

setlocale(LC_MONETARY, 'en_IN');
$markerpoint = money_format('%!.0n',$user_Details[0]->market_point);
	            $data[] = array( $i.'.',
	            				 $img,
	            				 $user->location !='' ? $user->location : '-',
	            				 $user->total_skill_points !=''?money_format('%!.0n',$user->total_skill_points): '-',
	            				 $user->market_point !='' ?money_format('%!.0n',$user->market_point):'-',
	            				 $action); 
	            				  
            }

        $dataCount = count($selquerycount);

        	if(empty($data)){ $data = 0; }
			
			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);

         
	}
	public function city_ajax()
	{ 
		if($this->input->post('countryid') != ''){
		$res = $this->AdminModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
			FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$this->input->post('countryid').'" ');

	        $html = '<option value="">Select City</option>';
			if($res){
				foreach($res as $rw){
					$html .= '<option value="'.$rw->city_ID.'">'.$rw->name.'</option>';
				}
			}
		}
		else{
			$html = '<option value="">Select City</option>';
		}
			echo json_encode(array('citydata'=>$html));
	}
	public function billingcity_ajax()
	{	
	/*	if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}*/ 
		$res = $this->AdminModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
			FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$this->input->post('countryid').'" ');

        	$html = '<option value="">Select City</option>';
		if($res){
			foreach($res as $rw){
				$html .= '<option value="'.$rw->city_ID.'">'.$rw->name.'</option>';
			}
		}
		echo json_encode(array('citydata'=>$html));
	}

	public function add_user()
	{ 	  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Add Users';
   		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		//$this->form_validation->set_rules('virtual_name', 'Virtual Name', 'required');
		$this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('skypeid', 'Skypeid', 'required');
		//$this->form_validation->set_rules('expert[]', 'Expert Field', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		// $this->form_validation->set_rules('billing_address', 'Biling Address', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		// $this->form_validation->set_rules('billing_country', 'Billing Country', 'required');
		// $this->form_validation->set_rules('billing_city', 'Billing City', 'required');

		// $this->form_validation->set_rules('facebooklink', 'Facebook Link', 'required');
		// $this->form_validation->set_rules('linkedinink', 'Linkedin Link', 'required');
		// $this->form_validation->set_rules('instagramlink', 'Instagram Link', 'required');
		$this->form_validation->set_message('required', "<label class='error'>%s field is required.</label>");
 
		if ($this->form_validation->run() == FALSE) 
		{
			$data['cnt'] = $this->AdminModel->getdata('trader_countries');
			$data['expertfield'] = $this->AdminModel->getdata('trader_expert_field');
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/user/add_user',$data);
			$this->load->view('admin/common/footer');
			 
		}else {  
		 
                $profile = date("dmYHis").$_FILES["image"]['name'];
                $image_path = realpath(APPPATH . '../upload/profile/');
          
                $config['file_name']            = $profile;
                $config['upload_path']          = $image_path;
                $config['allowed_types']        = 'jpg|png|jpeg';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('image'))
                { 
                        $data['imgerr'] = $this->upload->display_errors();
                        //$this->load->view('upload_form', $error);
                        $data['cnt'] = $this->AdminModel->getdata('trader_countries');
						$this->load->view('admin/common/nav',$page);
						$this->load->view('admin/common/header');
						$this->load->view('admin/user/add_user',$data);
						$this->load->view('admin/common/footer');
                }
                else
                {
                	$image = $this->upload->data('file_name');
                    $fullpath = $this->upload->data();
                    		$this->resize_image($fullpath,158,158);
                            $this->resize_image($fullpath,60,60);
                            $this->resize_image($fullpath,46,46);
                            $this->resize_image($fullpath,47,39);
                            $this->resize_image($fullpath,37,37);
                            $this->resize_image($fullpath,96,96);
                            $this->resize_image($fullpath,70,70);
                            $this->resize_image($fullpath,76,76);
                }

                $newpass = $this->genratepassword();
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'=> $this->input->post('last_name'),
					'virtual_name' => $this->input->post('virtual_name'),
					'profile_photo'	=> $image,
					'date_of_birth' 	=> date('Y-m-d',strtotime($this->input->post('dob'))),
					'email'	=> $this->input->post('email'),
					'password' => md5($newpass),
					'skype_id'	=> $this->input->post('skypeid'),
					'expert_field'	=> implode(',',$this->input->post('expert')),
					'address_line1'	=> $this->input->post('address'),
					'billing_address_line1'     => $this->input->post('billing_address'),
					'country'=> $this->input->post('country'),
					'city'    => $this->input->post('city'),
					'billing_country'=> $this->input->post('billing_country'),
					'billing_city'    => $this->input->post('billing_city'),
					'fb_link'=> $this->input->post('facebooklink'),
					'linkedin_link'    => $this->input->post('linkedinink'),
					'insta_link'    => $this->input->post('instagramlink'),
					'createdDate'  => date("Y-m-d H:i:s"),
					'updatedDate' => date("Y-m-d H:i:s"),
					'isVerify' => '1',
					'isActive'=> '1',
					'isDelete'=> '0'
				);
			//echo "<pre>"; print_r($data); exit; echo "</pre>";
          	$insert = $this->AdminModel->insertdata("trader_user",$data);
          	//$insert = 1;//$this->AdminModel->insertdata("trader_user",$data);
          	if($insert){
          		$usersubject = "Hi ".$this->input->post('first_name').' '.$this->input->post('last_name').', Welcome to Trader Network.';
          		//$verify_link = md5($insert);
					$maildata['mailed_data'] = array(
					                    "username"=>$this->input->post('first_name').' '.$this->input->post('last_name'),
					                    'email'     => $this->input->post('email'),
					                    'password'  => $newpass,
					                    'logo'    => base_url().'assets/images/trader-logo.png'
					                    //'verify_link'     => $verify_link
					                );
				$newuser = $this->load->view("templates/adminadduser",$maildata,true);
				//echo $newuser; exit;
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
			        $this->email->to($this->input->post('email'));
			        $this->email->subject($usersubject);
			        $this->email->message($newuser);
			        $this->email->set_mailtype("html");
			        $this->email->send();
			$this->session->set_flashdata('success','User successfully added.');
			redirect(base_url('admin/users'));
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
	public function edit($uid = "")
	{  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit Users';
  		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		// $this->form_validation->set_rules('virtual_name', 'Virtual Name', 'required');
		$this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('skypeid', 'Skypeid', 'required');
		//$this->form_validation->set_rules('expert[]', 'Expert Field', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		// $this->form_validation->set_rules('billing_address', 'Biling Address', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		// $this->form_validation->set_rules('billing_country', 'Billing Country', 'required');
		// $this->form_validation->set_rules('billing_city', 'Billing City', 'required');

		// $this->form_validation->set_rules('facebooklink', 'Facebook Link', 'required');
		// $this->form_validation->set_rules('linkedinink', 'Linkedin Link', 'required');
		// $this->form_validation->set_rules('instagramlink', 'Instagram Link', 'required');
		$this->form_validation->set_message('required', "<label class='error'>%s field is required.</label>");
		if ($this->form_validation->run() == FALSE) {  

			$data['userdata'] = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
			$data['cnt'] = $this->AdminModel->getdata('trader_countries');
			$data['expertfield'] = $this->AdminModel->getdata('trader_expert_field');
			//$data['city'] = $this->AdminModel->fetchrows("trader_cities","_StateID",$data['userdata']->_Region);
			$data['city'] = $this->AdminModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
			FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$data['userdata']->country.'" ');

			$data['billingcity'] = $this->AdminModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
			FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$data['userdata']->billing_country.'" ');
  
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/user/edit_user',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{ 
			//$id = $this->input->post('userid');
			$profile = date("dmYHis").$_FILES["image"]['name'];
            $image_path = realpath(APPPATH . '../upload/profile/');

            $config['file_name']            = $profile;
            $config['upload_path']          = $image_path;
            $config['allowed_types']        = 'jpg|png|jpeg';
			 
			$this->load->library('upload', $config);
			$this->upload->initialize($config);	
            if( ! $this->upload->do_upload('image'))
            {		 
				$data['imgerr'] = $this->upload->display_errors();
                $data['cnt'] = $this->AdminModel->getdata('trader_countries');
				$this->load->view('admin/common/nav',$page);
				$this->load->view('admin/common/header');
				$this->load->view('admin/user/edit_user',$data);
				$this->load->view('admin/common/footer');
					  
				 	$edit_data = array(
							'first_name' 	 => $this->input->post('first_name'),
							'last_name'		 => $this->input->post('last_name'),
							'virtual_name'	 => $this->input->post('virtual_name'),
							'profile_photo'	 => $this->input->post('imghidden'),
							'date_of_birth'  => date('Y-m-d',strtotime($this->input->post('dob'))),
							'email'			 => $this->input->post('email'),
							'skype_id'		 => $this->input->post('skypeid'),
							'expert_field'	 => implode(',',$this->input->post('expert')),
							'address_line1'	 => $this->input->post('address'),
							'billing_address_line1'     => $this->input->post('billing_address'),
							'country'		 => $this->input->post('country'),
							'city'    		 => $this->input->post('city'),
							'billing_country'=> $this->input->post('billing_country'),
							'billing_city'   => $this->input->post('billing_city'),
							'fb_link'		 => $this->input->post('facebooklink'),
							'linkedin_link'  => $this->input->post('linkedinink'),
							'insta_link'     => $this->input->post('instagramlink'),
							//'createdDate'  => date("Y-m-d H:i:s"),
							'updatedDate' 	 => date("Y-m-d H:i:s"),
							'isActive'		 => $this->input->post('userstatus') 
							//'isDelete'		 => '0'
						);
					$update = $this->AdminModel->updatedata('trader_user','user_ID',$uid ,$edit_data);		
					if($update){  
      				$this->session->set_flashdata('success','user successfully updated.');
					redirect(base_url('admin/users'));
					}	
			    }
                else
                { 		      
                    $image = $this->upload->data('file_name');
						$fullpath = $this->upload->data();
						$this->resize_image($fullpath,158,158);
                        $this->resize_image($fullpath,60,60);
                        $this->resize_image($fullpath,46,46);
                        $this->resize_image($fullpath,47,39);
                        $this->resize_image($fullpath,37,37);
                        $this->resize_image($fullpath,96,96);
                        $this->resize_image($fullpath,70,70);
                        $this->resize_image($fullpath,76,76);
                            
                      
					$edit_data = array(
							'first_name' => $this->input->post('first_name'),
							'last_name'=> $this->input->post('last_name'),
							'virtual_name' => $this->input->post('virtual_name'),
							'profile_photo'	=> $image,
							'date_of_birth' 	=> date('Y-m-d',strtotime($this->input->post('dob'))),
							'email'	=> $this->input->post('email'),
							'skype_id'	=> $this->input->post('skypeid'),
							'expert_field'	=> implode(',',$this->input->post('expert')),
							'address_line1'	=> $this->input->post('address'),
							'billing_address_line1'     => $this->input->post('billing_address'),
							'country'=> $this->input->post('country'),
							'city'    => $this->input->post('city'),
							'billing_country'=> $this->input->post('billing_country'),
							'billing_city'    => $this->input->post('billing_city'),
							'fb_link'=> $this->input->post('facebooklink'),
							'linkedin_link'    => $this->input->post('linkedinink'),
							'insta_link'    => $this->input->post('instagramlink'),
							//'createdDate'  => date("Y-m-d H:i:s"),
							'updatedDate' => date("Y-m-d H:i:s"),
							'isActive'=> $this->input->post('userstatus') 
							//'isDelete'=> '0'
					);   
					$update = $this->AdminModel->updatedata('trader_user','user_ID',$uid ,$edit_data);			
					if($update){  
      				$this->session->set_flashdata('success','user successfully updated.');
					redirect(base_url('admin/users'));
					}	
				}
					//echo $id = $this->input->post('userid'); exit;			
       }
	}
	public function image_resizer($path, $width, $height)
	{
		if(empty($path)):
		return '';
		endif;
		$info = getimagesize($path);
		$mime = $info['mime'];
		header('Content-type: $mime');

		$ratio_orig = ($info[0] / $info[1]);

		if(($width / $height) > $ratio_orig):
		$width = ($height * $ratio_orig);
		else:
		$height = ($width / $ratio_orig);
		endif;
		$image_p = imagecreatetruecolor($width,$height);
		switch($mime):
		case 'image/jpeg':
		$image = imagecreatefromjpeg($path);
		imagecopyresampled($image_p,$image,0,0,0,0,$width,$height,$info[0],$info[1]);
		imagejpeg($image_p,null,100);
		break;
		case 'image/png':
		$image = imagecreatefrompng($path);
		imagealphablending($image_p,false);
		imagesavealpha($image_p,true);
		imagefilledrectangle($image_p,0,0,$width,$height,imagecolorallocatealpha($image_p,255,255,255,127));
		imagecopyresampled($image_p,$image,0,0,0,0,$width,$height,$info[0],$info[1]);
		imagepng($image_p,null,9);
		break;
		default: 
		throw new Exception('Unknown image type.');
		endswitch;
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
	public function view($id){
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:View Users';
		$userdata = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$id));
		$data['viewuser'] = $userdata;
		$data['country'] = $this->AdminModel->get_singlerecord('trader_countries',array('country_ID'=>$userdata->country));
		$data['city'] = $this->AdminModel->get_singlerecord('trader_cities',array('city_ID'=>$userdata->city));

		$data['billingcountry'] = $this->AdminModel->get_singlerecord('trader_countries',array('country_ID'=>$userdata->billing_country));
		$data['billingcity'] = $this->AdminModel->get_singlerecord('trader_cities',array('city_ID'=>$userdata->billing_city));
		  
		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/user/view_user',$data);
		$this->load->view('admin/common/footer');
	}
	public function delete($id)
	{  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$data['isDelete'] = "1";
		$del = $this->AdminModel->deleterecord('trader_user',array("user_ID"=>$id),$data);
		if($del){
			$this->session->set_flashdata('success','User Deleted successfully...');
			redirect(base_url('admin/users'));
		}
	}
	public function statusajax()
	{  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		} 
		if($this->input->post('userid')!=''){
			$uid = $this->input->post('userid');
			$user = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
			if($user->isActive == '1'){
				$data = array(
						'updatedDate' => date("Y-m-d H:i:s"),
						'isActive'=> '0',
				);
				$status = 'deactived';
			}
			else{
				$data = array(
						'updatedDate' => date("Y-m-d H:i:s"),
						'isActive'=> '1',
				);
				$status = 'actived';
			}
				$up = $this->AdminModel->updatedata('trader_user','user_ID',$uid ,$data);			
				if($up){
					echo json_encode(array('status'=>$status));
				}
		}
	}

    public function rudr_mailchimp_curl_connect( $url, $request_type, $api_key, $data = array() ) {
        if( $request_type == 'GET' )
            $url .= '?' . http_build_query($data);
     
        $mch = curl_init();
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic '.base64_encode( 'user:'. $api_key )
        );
        curl_setopt($mch, CURLOPT_URL, $url );
        curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
        curl_setopt($mch, CURLOPT_CUSTOMREQUEST, $request_type); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
        curl_setopt($mch, CURLOPT_TIMEOUT, 10);
        curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
     
        if( $request_type != 'GET' ) {
            curl_setopt($mch, CURLOPT_POST, true);
            curl_setopt($mch, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
        }
     
        return curl_exec($mch);
    }
    public function subscriber_list()
    { 
        $api_key = '37340da126b61807626d31302a1de63c-us19';
        $list_id = 'd1176aafba';
       
        $dc = substr($api_key,strpos($api_key,'-')+1); // us5, us8 etc
         
        // URL to connect
        $url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id;
         
        // connect and get results
        $body = json_decode( $this->rudr_mailchimp_curl_connect( $url, 'GET', $api_key ) );
         
        // number of members in this list
        $member_count = $body->stats->member_count;
        $result = array();
         
        for( $offset = 0; $offset < $member_count; $offset += 50 ) :
         
            $data = array(
                'offset' => $offset,
                'count'  => 50
            );
         
            // URL to connect
            $url = 'https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$list_id.'/members';
         
            // connect and get results
            $body = json_decode( $this->rudr_mailchimp_curl_connect( $url, 'GET', $api_key, $data ) );
         $i=0;
             foreach ( $body->members as $member ) {
				$result['subscribers'][$i] = $member->email_address;
				$i++;
            }
         
        endfor;
		 
	    $this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/subscriber/subscribers',$result);
		$this->load->view('admin/common/footer');
	}
public function notification()
{
	if($this->session->userdata['logged_in']['adminid'] == ""){
		redirect(base_url('admin'));
	}
    $page['page_name'] = 'Trader Network:Notification'; 

    $cond = array(
            "touser_ID"=>$this->session->userdata['logged_in']['adminid']
        );
    $data['noti'] = $this->AdminModel->get_notification($this->session->userdata['logged_in']['adminid']);
     
    $this->load->view('admin/common/nav',$title);
	$this->load->view('admin/common/header');
	$this->load->view('admin/user/notification',$data);
	$this->load->view('admin/common/footer');
         
}
public function notification_ajax()
{
    if($this->session->userdata['logged_in']['adminid'] == ""){
        redirect(base_url('login'));
    }
    $cond = array(
            "touser_ID"=>$this->session->userdata['logged_in']['adminid']
        );
    $noti = $this->AdminModel->get_notification($this->session->userdata['logged_in']['adminid'],5);
    /*foreach ($noti as $not) {

        $joinascond = array("user_ID"=>$not->touser_ID,"dscussion_ID"=>$not->post_discu_ID);
        $join = $this->AdminModel->get_singlerecord("trader_bid",$joinascond);
        $joinas = $join->join_as; 

        $not->joinas = $joinas;
    }    
    $noticount = $this->AdminModel->get_notificationcount($this->session->userdata['logged_in']['adminid']);
        if($noticount != "0"){
            $noticount=$noticount;
        }else{
            $noticount='0';
        }   */
?>
  <!-- <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-icon-9"></i><span class="n_count"><?php echo $noticount;?></span></a> -->
		<a href="<?php echo base_url('admin/notification'); ?>" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-24"></i>
                <?php $noticount = $this->AdminModel->get_notificationcount($this->session->userdata['logged_in']['adminid']); ?>
                <?php if($noticount != '0'){ echo "<span class='n_count_admin'>".$noticount."</span>"; } ?>
                </a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton05">
                    <?php
      //echo "<pre>"; print_r($noti);  
if(!empty($noti)){ 
      foreach ($noti as $not) {
       if($not->joinas = '1'){ $joinas='as Attendee'; }else{ $joinas='as Presenter'; }
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; }
        ?><li class="dropdown-item">
        	<div class="notification_main_content <?php echo $ncls; ?>">
            <a href="javascript:void(0)" class="noti_close noti_closesmall" data-id="<?php echo $not->notification_ID;?>">x</a>
            <div class="noti_img">
              <?php 
                    if($not->profile_photo != ''){
                      $image_path = base_url('upload/profile/' . $not->profile_photo);
                      $thumb_path = preg_replace('~\.(?!.*\.)~', '-70x70.', $image_path);

                      ini_set('allow_url_fopen', true);

                      if (getimagesize($thumb_path)) {
                          $image_path2 = $thumb_path;
                      }
                      if($image_path2 != ''){
                      ?>
                          <img src="<?php echo $image_path2; ?>" />    
                      <?php
                      }
                      else{
                      ?> 
                        <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                  <?php }  
                    }
                else{
                 ?>
                    <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                 <?php
                } ?>
            </div> 
              <?php
                if($not->type == '15'){
                ?>
                  <a href="<?php echo base_url() ?>admin/view-withdrow/">
                <?php
                }
                else{
                ?>
                  <a href="<?php echo base_url() ?>admin/view-discussion/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
                <?php
                }
              ?>
              <div class="noti_text">
               <div class="noti_title">
           <h3><?php 
                        if($not->type == '1'){
                          echo ucwords($not->virtual_name).' has bid on <b>'.ucwords($not->discussion_title).'</b> Discussion'; 
                        }
                        elseif($not->type == '2'){
                          echo ucwords($not->virtual_name).' has bid on <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '3'){
                          echo ucwords($not->virtual_name).' has approve your bid for the <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '4'){
                          echo ucwords($not->virtual_name).' sent request to decrease your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '5'){
                          echo ucwords($not->virtual_name).' sent request to increase your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;  
                        }
                        elseif($not->type == '6'){
                          echo ucwords($not->virtual_name).' has rebid on <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '7'){
                          echo ucwords($not->virtual_name).' has accept the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '8'){
                          echo ucwords($not->virtual_name).' has decline the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '9'){
                          echo ucwords($not->virtual_name).' has Cancelled <b>'.ucwords($not->discussion_title). '</b> Discussion';
                        }
                        elseif($not->type == '10'){
                          echo '<b>'.ucwords($not->discussion_title).'</b> Discussion is completed';
                        }
                        elseif($not->type == '11'){
                          echo 'Discussion Date is changed for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '12'){
                          echo 'Please Give Your Feedback to Presenter for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '14'){
                          echo 'Congratulation You are earning for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '15'){
	                      echo 'New withdraw request from '.ucwords($not->virtual_name);
	                    }
                          
                    ?></h3>
                	</div>
                    <?php
                    $datetime1 = new DateTime("now");
                    $datetime2 = new DateTime($not->createdDate);
                    $interval = $datetime1->diff($datetime2);
                     
                    if(strtotime($not->createdDate) < strtotime('-1 days')) {
                        
                         ?>
                         <div class="noti_time">
                             <ul>
                                 <li><?php echo  date('d F Y',strtotime($not->createdDate));?></li>
                                 <li><?php echo date('h:i A',strtotime($not->createdDate));?></li>
                             </ul>
                         </div>
                             <?php
                                  
                    }     
                    else{
                        
                        if($interval->format("%H") == '0')
                        {
                           echo '<div class="noti_hours"><p>'.$interval->format("%I").'min ago.</p></div>';
                            
                        }
                        else
                        {
                           
                            echo "<div class='noti_hours'><p>".$interval->format("%h").' hour ago'."</p></div>";
                            
                        }  
                    }
            ?>
        </div>
          </a>
      </div>
      </li>
      <?php } ?>
           <li class="dropdown-item">
                <div class="see_all_noti"> 
                <a href="<?php echo base_url(); ?>admin/notification" >See all notifications</a>
                </div>
            </li>
      <?php }else{ ?>
        <li class="dropdown-item"><div class="no_noti_found">Notifications not found.</div></li>
      <?php } ?></ul><?php   
 
}
//---load notification function
public function notificationdefault(){
         $this->AdminModel->updatedata("trader_notifications","touser_ID",$this->session->userdata['logged_in']['adminid'],array("status" =>'1'));
        $noti = $this->AdminModel->get_notification($this->session->userdata['logged_in']['adminid']);
            
            ?>
            <div class="notification_page">
    <div class="container noti_main">
      <?php
      //echo "<pre>"; print_r($noti);  
if(!empty($noti)){ 
      foreach ($noti as $not) {
       if($not->joinas = '1'){ $joinas='as Attendee'; }else{ $joinas='as Presenter'; }
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; } ?>
        <div class="notification_main_content <?php echo $ncls; ?>">
            <a href="javascript:void(0)" class="noti_close" data-id="<?php echo $not->notification_ID; ?>"></a>
            <div class="noti_img">
              <?php 
                    if($not->profile_photo != ''){
                      $image_path = base_url('upload/profile/' . $not->profile_photo);
                      $thumb_path = preg_replace('~\.(?!.*\.)~', '-70x70.', $image_path);

                      ini_set('allow_url_fopen', true);

                      if (getimagesize($thumb_path)) {
                          $image_path2 = $thumb_path;
                      }
                      if($image_path2 != ''){
                      ?>
                          <img src="<?php echo $image_path2; ?>" />    
                      <?php
                      }
                      else{
                      ?> 
                        <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                  <?php }  
                    }
                else{
                 ?>
                    <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                 <?php
                } ?>
            </div>
            <?php
                if($not->type == '15'){
                ?>
                  <a href="<?php echo base_url() ?>admin/view-withdrow/">
                <?php
                }
                else{
                ?>
                  <a href="<?php echo base_url() ?>admin/view-discussion/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
                <?php
                }
              ?>
            <div class="noti_text">
               <div class="noti_title">
                   <h3>
                      <?php
                        if($not->type == '1'){
                          ?>
                          <?php
                         	echo ucwords($not->virtual_name).' has bid on <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion'; 
                        }
                        elseif($not->type == '2'){
                          ?>
                          <?php
                          echo ucwords($not->virtual_name).' has bid on <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '3'){
                          echo ucwords($not->virtual_name).' has approve your bid for the <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '4'){
                          echo ucwords($not->virtual_name).' sent request to decrease your bid in <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '5'){
                          echo ucwords($not->virtual_name).' sent request to increase your bid in <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;  
                        }
                        elseif($not->type == '6'){
                          echo ucwords($not->virtual_name).' has rebid on <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '7'){
                          echo ucwords($not->virtual_name).' has accept the presenter request for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '8'){
                          echo ucwords($not->virtual_name).' has decline the presenter request for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '9'){
                          echo ucwords($not->virtual_name).' has Cancelled <span class="bold_text">'.ucwords($not->discussion_title). '</span> Discussion';
                        }
                        elseif($not->type == '10'){
                          echo '<span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion is completed';
                        }
                        elseif($not->type == '11'){
                          echo 'Discussion Date is changed for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '12'){
                          echo 'Please Give Your Feedback to Presenter for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '14'){
                          echo 'Congratulation You are earning for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '15'){
	                      echo 'New withdraw request from '.ucwords($not->virtual_name);
	                    }
                          ?>
                    </h3>
               </div>
                <?php 

                    $datetime1 = new DateTime("now");
                    $datetime2 = new DateTime($not->createdDate);
                    $interval = $datetime1->diff($datetime2);
                     
                    if(strtotime($not->createdDate) < strtotime('-1 days')) {
                        ?>
                         <div class="noti_time">
                             <ul>
                                 <li><?php echo date('d F Y',strtotime($not->createdDate)); ?></li>
                                 <li><?php echo date('h:i A',strtotime($not->createdDate)); ?></li>
                             </ul>
                         </div>
                        <?php           
                    }
                    else{
                        
                        if($interval->format("%H") == '0')
                        {
                            ?>
                            <div class="noti_hours">
                                <span><?php echo $interval->format("%I").' min ago'; ?></span>
                           </div>
                            <?php
                        }
                        else
                        {
                           ?>
                            <div class="noti_hours">
                              <span><?php echo $interval->format("%h").' hour ago'; ?></span>
                            </div>
                            <?php
                        }  
                    }
                ?>
            </div>
          </a>
        </div>
<?php 
    }
}
else{
  ?>
  <div class="discu_notfound">Notification Not Found.</div>
  <?php
}
 ?>
    </div>
  </div>
            <?php
    
}
public function close_notification()
{

    if($this->session->userdata['logged_in']['adminid'] != '' && $this->input->post("nid") != ''){
        $dltnoti = $this->AdminModel->removedata('trader_notifications',array('notification_ID'=>$this->input->post("nid")));
        if($dltnoti){
            $ncond = array('touser_ID'=>$this->session->userdata['logged_in']['adminid'],'status'=>'0');
            $noticount = $this->AdminModel->getcount('trader_notifications',$ncond);
            $ncond2 = array('touser_ID'=>$this->session->userdata['logged_in']['adminid']);
            $noticount2 = $this->AdminModel->getcount('trader_notifications',$ncond2);
            echo json_encode(array('remove'=>'yes','count'=>$noticount,'count2'=>$noticount2));
        }
    }
    else{
        redirect(base_url('admin'));
    }
         
}

public function userwithdrow()
	{  
		//print_r($this->session->userdata); exit;
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		
		$page['page_name'] = 'Trader Network:View withdrow Request';

		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/user/withdrawal_main');
		$this->load->view('admin/common/footer');
		 
	} 

public function userwithdrow_ajax(){

	
if($_REQUEST['search']['value']!=''){
			$search="AND  amount LIKE '".$_REQUEST['search']['value']."%' OR createdDate LIKE '".$_REQUEST['search']['value']."%' OR note LIKE '".$_REQUEST['search']['value']."%'";
			$search1="AND first_name LIKE '".$_REQUEST['search']['value']."%' OR last_name LIKE '".$_REQUEST['search']['value']."%'";
		}else{
			$search="";
			$search1="";
		}
		$datacount =$this->AdminModel->runselect("SELECT * from trader_withdrawal_request WHERE withdrawal_ID!=0 ".$search);
//echo "SELECT * from trader_withdrawal_request WHERE withdrawal_ID!=0  ".$search." ORDER BY `withdrawal_ID` DESC LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'];
		$data_withdrow =$this->AdminModel->runselect("SELECT * from trader_withdrawal_request WHERE withdrawal_ID!=0  ".$search." ORDER BY `withdrawal_ID` DESC LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'] );
		$data['userdata'] = $this->AdminModel->get_user();
		$i=$_REQUEST['start'];
		$data=array();
		foreach ($data_withdrow as $keyvalue) { $i++;
			// $user =$this->AdminModel->runselect("SELECT * from trader_user WHERE user_ID!=".$keyvalue->user_ID." ".$search1);
					$user = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$keyvalue->user_ID));
					if($user->profile_photo !=''){

					$image_path = base_url('upload/profile/' . $user->profile_photo);
					$thumb_path = preg_replace('~\.(?!.*\.)~', '-37x37.', $image_path);

					ini_set('allow_url_fopen', true);

							if (getimagesize($thumb_path)) {
							$image_path2 = $thumb_path;
							}
					$img='<img src="'.$image_path2.'">'.$user->first_name.' '.$user->last_name;
					}else{
					$img='<img src="'.base_url().'assets/images/none-user-47x39.jpg">'.$user->first_name.' '.$user->last_name;
					}

					if($keyvalue->pament_method==1){
						$method="Paypal";
					}else if($keyvalue->pament_method==2){
						$method="Bank Account";
					}else{
						$method="Method Not Set.";
					}
					$notehtml = '';
					$notehtml .= '<div class="tooltip_div big_width_tooltip">'.mb_strimwidth($keyvalue->note, 0, 15,"..");
                                if(strlen($keyvalue->note) > 15 ){
                        			$notehtml .= '<span class="tooltiptext">'.$keyvalue->note.'</span>';                     
                                }
                    $notehtml .= '</div>';
					 

		            $data[] = array( $i.'.',
	            				 $img,
	            				 
	            				 ($keyvalue->amount)? '$'.$keyvalue->amount: '-',
	            				
	            				$method,
	            				 ($keyvalue->note)? $notehtml: '-',
	            				 ($keyvalue->createdDate)? date('d F,Y',strtotime($keyvalue->createdDate)): '-',
	            				($keyvalue->status==2)? "Completed": "<button name='apstatus' id=".$keyvalue->withdrawal_ID." class='withstatus'  value='0' >Approve</button>",
	            				
	            				);
	            				  
				      }    

				      if(empty($data)){ $data = 0; }
			$dataCount = count($datacount);

			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);
}
public function withdrowrequeststatus(){

		if($this->input->post("with_ID")!=''){
//LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length']

	

		$userwith = $this->AdminModel->get_singlerecord('trader_withdrawal_request',array('withdrawal_ID'=>$this->input->post("with_ID")));
		$user = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$userwith->user_ID));

		$marketpointval = $this->AdminModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));

		$upd=$this->MainModel->updaterecord("trader_withdrawal_request","withdrawal_ID",$this->input->post("with_ID"),array("status" =>'2'));
		$amount=($userwith->amount*$marketpointval->em_point);
		$finalpoint=$user->market_point-$amount;	
	
		  $this->AdminModel->updaterecord('trader_user',array('user_ID'=>$userwith->user_ID),array('market_point'=>$finalpoint));	

		  $notidata = array(
                    'post_discu_ID'=>'0',
                    'fromuser_ID'=>$this->session->userdata['logged_in']['adminid'],
                    'touser_ID'=>$userwith->user_ID,
                    'type'=>'16',
                    "createdDate"=>date("Y-m-d H:i:s")
                );
            $this->MainModel->insertrow('trader_notifications',$notidata);													
 
		}
		if($upd){
		$this->session->set_flashdata('success','Withdrow request is approved successfully.');
		}
}

	
}