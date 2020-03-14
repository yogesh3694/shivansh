<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'User_Master.php';
//require_once "../third_party/stripe/init.php";
//include_once $_SERVER['DOCUMENT_ROOT']."/Trader-Network/application/third_party/stripe/init.php";
include_once APPPATH."third_party/stripe/init.php";
class User_Main extends User_master {

	public function __construct(){
		parent::__construct();
        //$this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->set_error_delimiters('<label id="dob-error" class="error" for="virtual_name">', '</label>');
         
	}
	public function index(){  
		$cond = array(
		    "isActive"=>"1",
	    );
	     $current_date=date('Y-m-d h:i:s');
	    $select = "SELECT `td`.*,`tc`.`name` as cat_name,`ts`.`name` as sub_cat,(select count(dscussion_ID) from trader_bid where dscussion_ID= td.discussion_ID and approve_status='1' and join_as='1' and payment_status='1' AND isActive='1' AND isDelete='0')as attendee,
			(select count(dscussion_ID) from trader_bid where dscussion_ID= td.discussion_ID and approve_status='1' and join_as='2' and pre_accept='1' AND isActive='1' AND isDelete='0')as presenter
			FROM `trader_discussion` td LEFT JOIN `trader_category` AS tc ON `td`.`category_ID` = `tc`.`category_ID` LEFT JOIN `trader_sub_category` AS ts ON `td`.`sub_category` = `ts`.`sub_category_ID` where td.status='1' AND td.isActive ='1'  AND td.closing_date >='". $current_date."' AND td.isDelete='0'  order by discussion_ID DESC limit 6";
		$data['discussions'] = $this->MainModel->runselect($select);
		
        $cond1 = array(
            "slug"=>'home'
        );

        $idcond1 = array(
            "cms_ID"=>'1'
        );
        $idcond2 = array(
            "cms_ID"=>'3'
        );
        $home = $this->MainModel->fetchrow('trader_cms',$cond1);
        $data['content']=$home->contain;

        $home1 = $this->MainModel->fetchrow('trader_cms',$idcond1);
        $home2 = $this->MainModel->fetchrow('trader_cms',$idcond2);
        $idcond3 = array(
            "status"=>'1'
        );
        $fetchmaxamount = $this->MainModel->fetchmaxamount('trader_discussion',$idcond3);
        
        $maxprice=round($fetchmaxamount[0]->base_price);
         $diffval=round($maxprice/10);
          
             // echo $rounded_value = $diffval - ($diffval % 0 - 0);
        $homeamountarr = $this->MainModel->getamountrange($maxprice,round($diffval));
         $data['homeamountarr']=$homeamountarr;
         $amountnumber=strlen($maxprice);

         $data['homedata'] = $this->MainModel->runselect('SELECT * from trader_cms where cms_ID in("1","3","8","9","10","11","12")');
  
        $cond2 = array(
            "isActive"=>'1'
        );
        $categoryarr = $this->MainModel->fetchrowsall('trader_category',$cond2);
        $data['category']=$categoryarr;
	    $data['page_title']="Trader Network :: Home";
		$this->load->view('front/common/header',$data);
		$this->load->view('front/home',$data);
		$this->load->view('front/common/footer');
		 
	}
	public function signup(){
        if($this->session->userdata('userid') != "") {
            redirect(base_url());
        }
    		$this->form_validation->set_rules('first_name', 'First Name', 'required',array('required' => 'Please Enter Name.'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'required',array('required' => 'Please Enter Last Name.'));
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email',array('required' => 'Please Enter Email,.','valid_email'=>'Please Enter Valid Email-id.'));
            $this->form_validation->set_rules('password', 'Password', 'required',array('required'=>'Please Enter Password.'));
            //$this->form_validation->set_rules('txtcpassword', 'Confirm Password', 'required|matches[newpass]',array('required'=>'Please Enter Confirm Password.','matches'=>'Password Does Not Matched.'));
            $title['page_title'] = "Trader Network :: Sign Up";
          
            if ($this->form_validation->run() == FALSE){ 
                $this->load->view('front/common/header',$title);
                $this->load->view('front/register');
                $this->load->view('front/common/footer');
            }else{  
                $data['postdata'] = $_POST;
                $title['page_title'] = "Trader Network :: Sign Up";
                $data['question'] = $this->MainModel->fetchrowsall('trader_users_security_que');
                $this->load->view('front/common/header',$title);
                $this->load->view('front/register_step_2',$data);
                $this->load->view('front/common/footer');
              	// redirect(base_url('login'), 'refresh');
            }
    }
    public function getajaxemail(){
        $emailid = $this->input->post('email');
        $results = $this->MainModel->emailexists($emailid);
        if($results > 0){

            $res = "false";
        }else{

            $res = "true";
        }
        echo $res;
    }
    public function adduser(){  

        if($this->session->userdata('userid') != "") {
            redirect(base_url());
        }

        $this->form_validation->set_rules('sec_question', 'Security Question', 'required',array('required' => 'Please Select Security Question.'));
        $this->form_validation->set_rules('sec_answer', 'Security Answer', 'required',array('required' => 'Please Select Security Answer.'));
       
        if ($this->form_validation->run() == FALSE){
            $this->load->view('front/common/header');
            $this->load->view('front/register_step_2');
            $this->load->view('front/common/footer');
        }else{  

            $data = array(
                    'first_name'        => $this->input->post('first_name'),
                    'last_name'         => $this->input->post('last_name'),
                    'virtual_name'      => $this->input->post('first_name').' '.$this->input->post('last_name'),
                    'email'             => $this->input->post('email'),
                    'password'          => md5($this->input->post('password')),
                    'security_question' => $this->input->post('sec_question'),
                    'sq_answer'         => $this->input->post('sec_answer'),
                    'createdDate'       => date("Y-m-d H:i:s"),
                    'updatedDate'       => date("Y-m-d H:i:s"),
                    'isActive'          => "1",
                    'isDelete'          => "0"
                );
                    $newuser = $this->MainModel->insertdata('trader_user',$data);
                    $verify_link = md5($newuser);
                    $upuser = $this->MainModel->updaterecord("trader_user","user_ID",$newuser,array("verify_link" => $verify_link));

                    $maildata['mailed_data'] = array(
                                        "username"=>$this->input->post('first_name').' '.$this->input->post('last_name'),
                                        'email'     => $this->input->post('email'),
                                        'password'  => $this->input->post('password'),
                                        'logo'    => base_url().'assets/images/trader-logo.png',
                                        'verify_link'     => $verify_link
                                    );
                    $usercontent = $this->load->view("templates/welcome",$maildata,true);
                    // echo "<pre>";
                    // echo $usercontent;exit;
                    $email = $this->input->post('email');
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
                    $subject = "Hi ".$this->input->post('first_name').", Welcome to Trader Network";

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");

                    $this->email->from('support@trader-network.com','Trader Network');
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message($usercontent);
                    $this->email->set_mailtype("html");
                    $this->email->send();

            $this->session->set_flashdata('verification_msg',"We sent verification email to your ".$this->input->post('email').". Please verify your account to activate.");
            redirect(base_url('login'));
        }
    }
    public function verify_email($id){    

        $user = $this->MainModel->get_singlerecord('trader_user',array('verify_link' => $id));
        if($user){
        $uplink = $this->MainModel->updaterecord("trader_user","user_ID",$user->user_ID,array("isVerify" => "1","verify_link" => ""));

        if($uplink){
        $userdata = array('user_email'=>$user->email,'password'=>$user->password);
        $result = $this->MainModel->verify_validate_user($userdata);
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
                       
                    $this->session->set_flashdata('success', 'Your email account verified successfully.');
                    redirect(base_url('my-account-dashboard'));               
                }
                else{
                    $this->session->set_flashdata('verification_msg',"We sent verification email to your ".$result->email.". Please verify your account to activate.");
                    redirect(base_url('login'));           
                }
            }
        }
        }
        else{
            $this->session->set_flashdata('success', 'Your email already verified.');
            redirect(base_url('my-account-dashboard'));               
        }
    }
    public function forgotpass(){
        if($this->session->userdata('userid') != "") {
            redirect(base_url());
        }
        $header['page_title'] = 'Trader Network :: Forgot Password';
        $this->form_validation->set_rules('forgotemail', 'Email', 'required');
        if ($this->form_validation->run() == FALSE){  
            //echo "hi";exit;
            $this->load->view('front/common/header',$header);
            $this->load->view('front/forgot_password');
            $this->load->view('front/common/footer');
        }else{  
            $uscond = array("email"=>$this->input->post('forgotemail'));
            $emailex = $this->MainModel->getcount("trader_user",$uscond);
            if($emailex > 0){
                 $header['page_title'] = 'Trader Network :: Security Question';
                $userrow = $this->MainModel->get_singlerecord("trader_user",$uscond);    
                $que = $this->MainModel->get_singlerecord("trader_users_security_que",array('que_ID' => $userrow->security_question));    
                $data['forgotemail'] = array('email'=> $this->input->post('forgotemail'),'question'=>$que->question,'answer'=>$userrow->sq_answer);     
                $this->load->view('front/common/header',$header);
                $this->load->view('front/retrieve_password',$data);
                $this->load->view('front/common/footer');       
                 
            }else{
                $errorfailed = "Email is not registered";
                $this->session->set_flashdata('forgoterror',$errorfailed);
                $this->load->view('front/common/header',$header);
                $this->load->view('front/forgot_password');
                $this->load->view('front/common/footer');
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
    public function updatepassword(){
        if($this->session->userdata('userid') != "") {
            redirect(base_url());
        }
             //$data['page_title'] = "Trader Network :: Password & Password";
            $this->form_validation->set_rules('txtanswer', 'Answer', 'required');
            if ($this->form_validation->run() == FALSE){ 
                $uscond = array("email"=>$this->input->post('forgotemail'));
                $userrow = $this->MainModel->get_singlerecord("trader_user",$uscond);    
                $que = $this->MainModel->get_singlerecord("trader_users_security_que",array('que_ID' => $userrow->security_question));    

                $data['forgotemail'] = array('email'=> $this->input->post('forgotemail'),'question'=>$que->question,'answer'=>$userrow->sq_answer);      
                $this->load->view('front/common/header');
                $this->load->view('front/retrieve_password',$data);
                $this->load->view('front/common/footer');
            }
            else
            {  
                if($this->input->post('answer') == $this->input->post('txtanswer')){

                    $uscond2 = array("email"=>$this->input->post('forgotemail'));
                    $singleuser = $this->MainModel->get_singlerecord("trader_user",$uscond2);    
                    //print_r($singleuser); exit;
                    if($singleuser->isVerify == '0'){
                        $this->session->set_flashdata('loginfailed', 'Your email is not verified yet. Please verify your email account before login.');
                        $this->load->view('front/common/header');
                        $this->load->view('front/login');
                        $this->load->view('front/common/footer');
                    }
                    else{
                
                        $newpass = $this->genratepassword();
                        $email = $this->input->post('forgotemail');
                        $result  = $this->MainModel->forgotpassword(array('password'=>md5($newpass)),$email);
                        $condition = array(
                                "email"=>$email,
                                "isActive"=>"1",
                                "isDelete"=>"0"
                                );
                        $userdata = $this->MainModel->get_singlerecord("trader_user",$condition);
                        $data['mailed_data'] = $userdata;
                        $data['pass'] = $newpass;
                        $data['logo'] = base_url().'assets/images/trader-logo.png';
                        $usercontent = $this->load->view("templates/forgot_password",$data,true);
                        // echo "<pre>";
                        // echo $usercontent;exit;
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
                        $this->email->to($email);
                        $this->email->subject("Trader Network: Forgot Password");
                        $this->email->message($usercontent);
                        $this->email->set_mailtype("html");
                        $this->email->send();
                        $this->session->set_flashdata('forgotsuccess', 'New Password has been Sent To Your Email.');
                        redirect(base_url('login'));
                    }
                }
                else{

                    $error = "Invalid Answer.";
                    $this->session->set_flashdata('retriverror',$error);

                    $uscond = array("email"=>$this->input->post('forgotemail'));
                    $userrow = $this->MainModel->get_singlerecord("trader_user",$uscond);    
                    $que = $this->MainModel->get_singlerecord("trader_users_security_que",array('que_ID' => $userrow->security_question));    
                    $data['forgotemail'] = array('email'=> $this->input->post('forgotemail'),'question'=>$que->question,'answer'=>$userrow->sq_answer);     
                    $this->load->view('front/common/header');
                    $this->load->view('front/retrieve_password',$data);
                    $this->load->view('front/common/footer');
                }
        }
    }
    public function my_profile()
    {  
        if($this->session->userdata('userid') == ""){
            redirect(base_url('login'));
        }
        $title['page_title'] = "Trader Network :: My Profile";
        $uid = $this->session->userdata('userid');
        $page['page_name'] = "Edit User";
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        //$this->form_validation->set_rules('virtual_name', 'Virtual Name', 'required');
        $this->form_validation->set_rules('dob', 'date of birth', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('skypeid', 'Skypeid', 'required');
        //$this->form_validation->set_rules('expert[]', 'Expert Field', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('billing_address', 'Biling Address', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
      

        $this->form_validation->set_message('required', "<label class='error'>Please select %s.</label>");
        if ($this->form_validation->run() == FALSE) {  

            $data['userdata'] = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
            $data['cnt'] = $this->MainModel->fetchrowsall('trader_countries');
            $data['expertfield'] = $this->MainModel->fetchrowsall('trader_expert_field');
            //$data['city'] = $this->MainModel->fetchrows("trader_cities","_StateID",$data['userdata']->_Region);
            $data['city'] = $this->MainModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
            FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$data['userdata']->country.'" ');

            $data['billingcity'] = $this->MainModel->runselect('SELECT `ci`.*,`st`.`country_ID` as statecountry_ID,`cu`.`country_ID` as cuncountry_ID
            FROM `trader_cities` ci LEFT JOIN `trader_states` AS st ON `ci`.`state_ID` = `st`.`state_ID` LEFT JOIN `trader_countries` AS cu ON `st`.`country_ID` = `cu`.`country_ID` where `st`.`country_ID` = "'.$data['userdata']->billing_country.'" ');
  
            $this->load->view('front/common/header',$title);
            $this->load->view('front/my_profile',$data);
            $this->load->view('front/common/footer');
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
            {        //echo 'Noo'.$_FILES['image']['name'];
                $data['imgerr'] = $this->upload->display_errors();
                $data['cnt'] = $this->MainModel->fetchrowsall('trader_countries');
                $this->load->view('front/common/header');
                $this->load->view('front/my_profile',$data);
                $this->load->view('front/common/footer');
                      
                    $edit_data = array(
                            'first_name'     => $this->input->post('first_name'),
                            'last_name'      => $this->input->post('last_name'),
                            'virtual_name'   => $this->input->post('virtual_name'),
                            'profile_photo'  => $this->input->post('imghidden'),
                            'date_of_birth'  => date('Y-m-d',strtotime($this->input->post('dob'))),
                            'email'          => $this->input->post('email'),
                            'skype_id'       => $this->input->post('skypeid'),
                            'expert_field'   => implode(',',$this->input->post('expert')),
                            'address_line1'  => $this->input->post('address'),
                            'billing_address_line1'     => $this->input->post('billing_address'),
                            'country'        => $this->input->post('country'),
                            'city'           => $this->input->post('city'),
                            'billing_country'=> $this->input->post('billing_country'),
                            'billing_city'   => $this->input->post('billing_city'),
                            'fb_link'        => $this->input->post('facebooklink'),
                            'linkedin_link'  => $this->input->post('linkedinink'),
                            'insta_link'     => $this->input->post('instagramlink'),
                            //'createdDate'  => date("Y-m-d H:i:s"),
                            'updatedDate'    => date("Y-m-d H:i:s"),
                            'isActive'       => '1',
                            'isDelete'       => '0'
                        );
                    $update = $this->MainModel->updaterecord('trader_user','user_ID',$uid ,$edit_data);      
                    if($update){  
                    $this->session->set_flashdata('success','Profile updated successfully.');
                    //redirect(base_url('my-profile'));
                    redirect("my-account-dashboard","refresh");
                    
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
                            'profile_photo' => $image,
                            'date_of_birth'     => date('Y-m-d',strtotime($this->input->post('dob'))),
                            'email' => $this->input->post('email'),
                            'skype_id'  => $this->input->post('skypeid'),
                            'expert_field'  => implode(',',$this->input->post('expert')),
                            'address_line1' => $this->input->post('address'),
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
                            'isActive'=> '1',
                            'isDelete'=> '0'
                    );   
                    $update = $this->MainModel->updaterecord('trader_user','user_ID',$uid ,$edit_data);          
                    if($update){  
                    $this->session->set_flashdata('success','Profile updated successfully.');
                     
                    redirect("my-account-dashboard","refresh");
                    }   
                }
                    //echo $id = $this->input->post('userid'); exit;            
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
    public function change_password()
    {
        if(!$this->session->userdata('userid')) {
            redirect(base_url('login'));
        } 
        $title['page_title'] = "Trader Network :: Password & Security";
        $this->form_validation->set_rules('currentpass', "Current Password", 'required|callback_pwd_check',array('required' => "<label class='error'>Please Enter Current Password.</label>"));
        $this->form_validation->set_rules('newpass', "Password", 'required',array('required' => "<label class='error'>Please Enter New Password.</label>"));
        $this->form_validation->set_rules('confirmpass', "Please Re-type Password", 'required|matches[newpass]',array('required' => "<label class='error'>Please Enter Confirm Password.</label>","matches"=>"<label class='error'>Wrong Re-type Password.</label>"));

        if ($this->form_validation->run() == FALSE){

            $where = array('user_ID' => $this->session->userdata('userid'));
            $data['sec_detail'] = $this->MainModel->customjoinrow('trader_user','trader_users_security_que','security_question','que_ID',$where); 
            //print_r($data['sec_detail']); exit;
            $data['questions'] = $this->MainModel->fetchrowsall('trader_users_security_que');
                $this->load->view('front/common/header', $title);
                $this->load->view('front/change_password',$data);
                $this->load->view('front/common/footer');
        }else{
                $userid = $this->session->userdata("userid");
                $condition = array("user_ID"=>$userid);
                $data = array(
                        "password" => md5($this->input->post("newpass")),
                        "updatedDate" => date("Y-m-d H:i:s")
                        );
                $changed = $this->MainModel->updaterecord("trader_user","user_ID",$userid,$data);
                $statusMsg = $changed ? 'Password changed successfully.':'password not changed successfully.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
                redirect(base_url('change-password'));
        }
    }
    public function pwd_check($pwd) //check current pass in ci
    {
        $user = $this->MainModel->get_singlerecord("trader_user",array("user_ID"=>$this->session->userdata("userid")));
        if($user->password == md5($pwd)){
            return true;
        }else {
            $this->form_validation->set_message('pwd_check', "<label class='error'>The {field} doesn't match.</label>");
            return false;
        }
    }
    public function checkoldpwd() //check current pass in jquery
    {  
        $user = $this->MainModel->get_singlerecord("trader_user",array("user_ID"=>$this->session->userdata("userid")));
        if($user->password == md5($this->input->post('oldpwd'))){
            echo 'true';
        }else {
            echo 'false';
        }
    }
    public function security_question()
    {
        if(!$this->session->userdata('userid')) {
            redirect(base_url('login'));
        } 
     
        $title['page_title'] = "Trader Network :: Security Question";
        $this->form_validation->set_rules('sec_question', "Please Select Security Question", 'required');
        $this->form_validation->set_rules('answer', "Please enter Answer", 'required');
          
        if ($this->form_validation->run() == FALSE){
            $where = array('user_ID' => $this->session->userdata('userid'));
            $data['sec_detail'] = $this->MainModel->customjoinrow('trader_user','trader_users_security_que','user_ID','que_ID',$where); 
            $data['questions'] = $this->MainModel->fetchrowsall('trader_users_security_que');
                $this->load->view('front/common/header',$title);
                $this->load->view('front/change_password',$data);
                $this->load->view('front/common/footer');
        }else{

                $userid = $this->session->userdata("userid");
                $condition = array("user_ID"=>$userid);
                $data = array(
                        "security_question" => $this->input->post("sec_question"),
                        "sq_answer" => $this->input->post("answer")
                        );
                $set = $this->MainModel->updaterecord("trader_user","user_ID",$userid,$data);
                $setMsg = $set ? 'Security question set successfully.':'security question not set successfully.';
                $this->session->set_flashdata('statusMsg',$setMsg);
                redirect(base_url('change-password'));
        }
    }


 public function image_resizer($path, $width = 50, $height = 50)
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
public function noti_setting()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
        $uid = $this->session->userdata('userid');
        $title['page_title'] = "Trader Network :: Notification Setting";
        $this->form_validation->set_rules('noti_email', 'Email', 'required|valid_email');         
        $this->form_validation->set_message('required', "<label class='error'>Please Enter %s.</label>");
        $this->form_validation->set_message('valid_email', "<label class='error'>Please Enter Valid %s.</label>");
        if ($this->form_validation->run() == FALSE) {

            $data['not_email'] = $this->MainModel->get_singlerecord("trader_user",array("user_ID"=>$this->session->userdata("userid")));
                $this->load->view('front/common/header',$title);
                $this->load->view('front/notification_setting',$data);
                $this->load->view('front/common/footer');                       
        } 
        else{
            $data = array(
                         'notification_email'=>$this->input->post("noti_email"),
                         "updatedDate" => date("Y-m-d H:i:s")
                    );
            $update = $this->MainModel->updaterecord('trader_user','user_ID',$uid ,$data);      
            $setMsg = $update ? 'Email updated successfully.':'Email not updated..';
            $this->session->set_flashdata('noti_msg',$setMsg);
            redirect(base_url('notification-setting'));
        } 
}	
public function validatecard($cardnumber) {
    $cardnumber=preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
    $cardlength=strlen($cardnumber);
    $parity=$cardlength % 2;
    $sum=0;
    for ($i=0; $i<$cardlength; $i++) {
      $digit=$cardnumber[$i];
      if ($i%2==$parity) $digit=$digit*2;
      if ($digit>9) $digit=$digit-9;
      $sum=$sum+$digit;
    }
    $valid=($sum%10==0);
    return $valid;
}
public function check_cc($cc, $extra_check = false){
    $cards = array(
        "visa" => "(4\d{12}(?:\d{3})?)",
        "amex" => "(3[47]\d{13})",
        "jcb" => "(35[2-8][89]\d\d\d{10})",
        "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
        "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
        "mastercard" => "(5[1-5]\d{14})",
        "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
    );
    $names = array("Visa", "American Express", "JCB", "Maestro", "Solo", "Mastercard", "Switch");
    $matches = array();
    $pattern = "#^(?:".implode("|", $cards).")$#";
     $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
    if($extra_check && $result > 0){
        $result = ($this->validatecard($cc))?1:0;
        
    }
    return ($result>0)?$names[sizeof($matches)-2]:0;
}

public function billing_method()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
      
        $uid = $this->session->userdata('userid');
        $title['page_title'] = "Trader Network :: Billing Method";
        $data['cards'] = $this->MainModel->fetchallrow('trader_user_card_details',array('user_ID'=>$this->session->userdata('userid'),'isDeleted'=>'0'));
        $this->form_validation->set_rules('card_no', 'card number', 'required');         
        $this->form_validation->set_rules('valid_thrugh', 'valid throw', 'required');    
        $this->form_validation->set_rules('cvv_no', 'cvv no', 'required');              
        $this->form_validation->set_message('required', "<label class='error'>Please enter %s.</label>");
        if ($this->form_validation->run() == FALSE) {

            if($this->input->post("cardpopoup")!= ''){
                //redirect(base_url('my-account-dashboard'));
                $this->load->view('front/common/header',$title);
                $this->load->view('front/my-account-dashboard',$data);
                $this->load->view('front/common/footer');                       
            }else{
                $this->load->view('front/common/header',$title);
                $this->load->view('front/billing_method',$data);
                $this->load->view('front/common/footer');                       
            }
        } 
        else{
           
            //--------for stripe payment-----------
            $cardexp=explode('/',$this->input->post("valid_thrugh"));

            
            \Stripe\Stripe::setApiKey("sk_test_b3lLzyTbVwjJyaBLOe3s0rRS");
            
            //-------------------------------------
            try {
                $token =Stripe\Token::create(array(
                    "card" => array(
                    "number" => $this->input->post("card_no"),
                    "exp_month" => intval($cardexp[0]),
                    "exp_year" => intval($cardexp[1]),
                    "cvc" => $this->input->post("cvv_no")
                    )
                    ));
                $success = 1;
                
            } catch(Stripe_CardError $e) {
              $error1 = $e->getMessage();
            } catch (Stripe_InvalidRequestError $e) {
              $error1 = $e->getMessage();
            } catch (Stripe_AuthenticationError $e) {
              $error1 = $e->getMessage();
            } catch (Stripe_ApiConnectionError $e) {
              $error1 = $e->getMessage();
            } catch (Stripe_Error $e) {
              $error1 = $e->getMessage();
            } catch (Exception $e) {
              $error1 = $e->getMessage();
            }
            if ($success!=1)
            {

                $this->session->set_flashdata('bidfail',$error1);
                
                if($this->input->post("cardpopoup")!= ''){
                    redirect(base_url('my-account-dashboard'));
                }
                else{
                    redirect(base_url('billing-method'));
                } 
            }

            //--------------------------------------
          
            $customer = \Stripe\Customer::create(array(
                
                "source" => $token,
                'email' =>$this->session->userdata('email'),
                "description" =>'Trader::User')
            );
                //------------------------------
            $no = str_replace(' ', '', $this->input->post("card_no"));
            $cardno = substr($no,-4);  
            $card_type=$this->check_cc($this->input->post("card_no"),true);
           
            $data = array(
                         'user_ID'=>$this->session->userdata('userid'),
                         'card_last_degits'=>$cardno,
                         'card_name'=>$card_type,
                         'stripe_customer_id'=>$customer->id,
                         'valid_through'=>$this->input->post("valid_thrugh"),
                         'cvc_number'=>$this->input->post("cvv_no"),
                         "createdDate" => date("Y-m-d H:i:s"),
                         "updatedDate" => date("Y-m-d H:i:s"),
                         "isActive"=> '1',
                         "isDeleted"=> '0'
                    );
            $insert = $this->MainModel->insertdata('trader_user_card_details',$data);      
            $setMsg = $insert ? 'Card details added successfully.':'Card details not added..';
            $this->session->set_flashdata('billing_msg',$setMsg);

            if($this->input->post("cardpopoup")!= ''){
                redirect(base_url('my-account-dashboard'));
            }
            else{
                redirect(base_url('billing-method'));
            }
        } 
}
public function remove_card($card)
{
    if($card != ''){
        $data = array('isDeleted'=>'1');
        $update = $this->MainModel->updaterecord('trader_user_card_details','card_ID',$card,$data);      
        $setMsg = $update ? 'Card removed successfully.':'Card not removed..';
        $this->session->set_flashdata('billing_msg',$setMsg);
        redirect(base_url('billing-method'));
    }
} 
public function notification()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
    $title['page_title'] = "Trader Network :: Notification"; 

    $cond = array("touser_ID"=>$this->session->userdata('userid'));



    $data['noti'] = $this->MainModel->get_notification($this->session->userdata('userid'));

    foreach ($data['noti'] as $not) {

        $joinascond = array("user_ID"=>$not->touser_ID,"dscussion_ID"=>$not->post_discu_ID);
        $join = $this->MainModel->get_singlerecord("trader_bid",$joinascond);
        $joinas = $join->join_as; 

        $not->joinas = $joinas;
    }    


  
    $this->load->view('front/common/header',$title);
    $this->load->view('front/notification',$data);
    $this->load->view('front/common/footer');                       
         
} 
public function notification_ajax()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
    $cond = array(
            "touser_ID"=>$this->session->userdata('userid')
        );
    $noti = $this->MainModel->get_notification($this->session->userdata('userid'),5);
    foreach ($noti as $not) {

        $joinascond = array("user_ID"=>$not->touser_ID,"dscussion_ID"=>$not->post_discu_ID);
        $join = $this->MainModel->get_singlerecord("trader_bid",$joinascond);
        $joinas = $join->join_as; 

        $not->joinas = $joinas;
    }    
    $noticount = $this->MainModel->get_notificationcount($this->session->userdata('userid'));
        if($noticount != "0"){
            $noticount=$noticount;
        }else{
            $noticount='0';
        }   
?>
    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-icon-9"></i><span class="n_count"><?php echo $noticount;?></span></a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton05">
                    <?php
      //echo "<pre>"; print_r($noti);  
if(!empty($noti)){ 
      foreach ($noti as $not) {
       if($not->joinas = '1'){ $joinas='as attendee'; }else{ $joinas='as presenter'; }
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; }
        ?><li class="dropdown-item <?php echo $ncls;?>">
            <div class="notification_main_content <?php echo $ncls; ?>">
            <!-- <a href="javascript:void(0)" class="noti_close" data-id="<?php echo $not->notification_ID; ?>"></a> -->
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

              if($not->type == '13' || $not->type == '2' || $not->type == '6'){

                  ?><a href="<?php echo base_url();?>view-discussion/<?php echo $not->post_discu_ID;?>?n=<?php echo  $not->notification_ID;?>">
             <?php
              }
              elseif($not->type == '16'){ ?>
                <a href="<?php echo base_url();?>my-account-dashboard">
                <?php
              }
              else{
                  ?>
                  <a href="<?php echo  base_url();?>discussion-details/<?php echo $not->post_discu_ID;?>?n=<?php echo $not->notification_ID;?>">
            <?php } ?>
            <div class="noti_text">
            <div class="noti_title">
           <h3><?php 
                         if($not->type == '1'){
                          ?>
                          <?php
                          if($not->as_Type == '1'){
                            $astype = 'presenter';
                          }
                          else{
                            $astype = 'attendee'; 
                          }
                          echo ucwords($not->virtual_name).' has invited you for <b>'.ucwords($not->discussion_title).'</b> Discussion as '.$astype; 
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
                        elseif($not->type == '16'){
                          echo 'Admin has approve your withdraw request <b>'.ucwords($not->discussion_title).'</b>';
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
        <?php
                }
            ?>
           <li class="dropdown-item"><div class="see_all_noti"><a href="<?php echo base_url(); ?>notification" >See all notifications</a></div></li>
      <?php }else{ ?>
        <li class="dropdown-item"><div class="no_noti_found">Notifications not found.</div></li>
      <?php } ?></ul><?php

    // $this->load->view('front/common/header',$title);
    // $this->load->view('front/notification',$data);
    // $this->load->view('front/common/footer');                       
      // echo  $notificatio;  
} 
public function close_notification()
{

    if($this->session->userdata('userid') != '' && $this->input->post("nid") != ''){
        $dltnoti = $this->MainModel->removedata('trader_notifications',array('notification_ID'=>$this->input->post("nid")));
        if($dltnoti){
            $ncond = array('touser_ID'=>$this->session->userdata('userid'),'status'=>'0');
            $noticount = $this->MainModel->getcount('trader_notifications',$ncond);
            $ncond2 = array('touser_ID'=>$this->session->userdata('userid'));
            $noticount2 = $this->MainModel->getcount('trader_notifications',$ncond2);
            echo json_encode(array('remove'=>'yes','count'=>$noticount,'count2'=>$noticount2));
        }
    }
    else{
        redirect(base_url('login'));
    }
         
} 



public function getcustomerstripe_ID($cardno){
	
	$custid = $this->MainModel->get_singlerecord('trader_user_card_details',array('card_ID'=>$cardno));
	
	return $custid->stripe_customer_id;
} 
public function my_payments()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
    $title['page_title'] = "Trader Network :: My Payments"; 

    $datamarketpoint = $this->MainModel->get_singlerecord('trader_user',array('user_ID' => $this->session->userdata('userid')));

    
    $data['wallet_balance']=$datamarketpoint->market_point;		
    $data['payments'] = $this->MainModel->fetchallrow('trader_transaction',array('user_ID'=>$this->session->userdata('userid')));
    $data['cards'] = $this->MainModel->fetchallrow('trader_user_card_details',array('user_ID'=>$this->session->userdata('userid'),'isDeleted'=>'0'));
    $useramount = $this->MainModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));

	$data['dollar_point'] =$useramount->em_point;	
    $this->load->view('front/common/header',$title);
    $this->load->view('front/my-payments',$data);
    $this->load->view('front/common/footer');                       
         
}
public function withdrawal_request()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
        $title['page_title'] = "Trader Network :: Withdrawal";
        $this->form_validation->set_rules('withdrow', 'Withdrawal', 'required');
        $this->form_validation->set_rules('method', 'Withdrawal', 'required');

        //$this->form_validation->set_message('required', "<label class='error'>%s field is required.</label>");
        $datamarketpoint = $this->MainModel->get_singlerecord('trader_user',array('user_ID' => $this->session->userdata('userid')));
        $data['userrow'] = $datamarketpoint;
        $data['totalmpoint'] = $datamarketpoint->market_point;
         if ($this->form_validation->run() == FALSE){
            $this->load->view('front/common/header');
            $this->load->view('front/withdrawal',$data);
            $this->load->view('front/common/footer');
        }else{

    $user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid'))); 
    $admin = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>'1')); 


    /*transaction table add data*/
    $data2 = array(
                'transaction_number'=>'',
                'user_ID'=>$this->session->userdata('userid'),
                'disussion_ID'=>'0',
                'debit_credit'=>'1',
                'amount'=>$this->input->post('withdrow'),
                'description'=>'withdrawal request',
                "updatedDate"=>date("Y-m-d H:i:s")
            );
 
    $inserttransaction = $this->MainModel->insertdata('trader_transaction',$data2); 
     
    if($inserttransaction):

            $data = array(
                    'user_ID'=>$this->session->userdata('userid'),
                    'amount'=>$this->input->post('withdrow'),
                    'pament_method'=>$this->input->post('method'),
                    'transaction_ID'=>$inserttransaction,
                    'note'=>$this->input->post('note'),
                    'status'=>'1',
                    "createdDate"=>date("Y-m-d H:i:s")
                );
     
            $insert = $this->MainModel->insertdata('trader_withdrawal_request',$data); 
     
        
        //send notification 
            $notidata = array(
                    'post_discu_ID'=>'0',
                    'fromuser_ID'=>$this->session->userdata('userid'),
                    'touser_ID'=>'1',
                    'type'=>'15',
                    "createdDate"=>date("Y-m-d H:i:s")
                );
            $this->MainModel->insertrow('trader_notifications',$notidata);
            
            $emarketpointrow = $this->MainModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));

            $adminamount = $this->input->post('withdrow')/$emarketpointrow->em_point;

            //send email notification 
            $usersubject = "New withdrawal request found";
                    $maildata['mailed_data'] = array(
                                        "username"=>$user->virtual_name,
                                        "adminusername"=>$admin->first_name.' '.$admin->last_name,
                                        "method"=>($this->input->post('method') == '1'?'1':'2'),
                                        "amount"=>$adminamount,
                                        "paypalemail"=>$user->paypal_email,
                                        "accountname"=>$user->account_name,
                                        "accountnumber"=>$user->account_number,
                                        "bankname"=>$user->bank_name,
                                        "note"=>$this->input->post('note'),
                                        'logo'    => base_url().'assets/images/trader-logo.png'
                                    );
                $withdr_msg = $this->load->view("templates/admin_withdrawal",$maildata,true);
                //echo $withdr_msg; exit;
                 
                if($admin->notification_email != ''){
                    $notiemail = $admin->notification_email;
                }
                else{
                    $notiemail = $admin->email;
                }
                $config = Array(
                              'mailtype' => 'html',
                              'wordwrap' => TRUE
                            );

                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");

                    $this->email->from(admin_email(),'Trader Network');
                    $this->email->to($notiemail);
                    $this->email->subject($usersubject);
                    $this->email->message($withdr_msg);
                    $this->email->set_mailtype("html");
                    $this->email->send();
    endif;

    $this->session->set_flashdata('paypalmsg','Withdrawal request send successfully.');
     redirect(base_url('withdrawal'));                  
    }   
}
public function paypalform(){
    $this->form_validation->set_rules('paypalemail', 'Paypalemail', 'required');
         if ($this->form_validation->run() == FALSE){
            $datamarketpoint = $this->MainModel->get_singlerecord('trader_user',array('user_ID' => $this->session->userdata('userid')));
            $data['totalmpoint'] = $datamarketpoint->market_point;
            $data['userrow'] = $datamarketpoint;
            $this->load->view('front/common/header');
            $this->load->view('front/withdrawal',$data);
            $this->load->view('front/common/footer');
        }else{
            //$userrow = $this->MainModel->get_singlerecord('trader_user',array('user_ID' => $this->session->userdata('userid')));
            if($this->input->post('paypalemail') != ''){

                $paypal = $this->MainModel->updaterecord("trader_user","user_ID",$this->session->userdata('userid'),array("paypal_email" =>$this->input->post('paypalemail')));  
                if($paypal){
                    $this->session->set_flashdata('paypalmsg','Paypal email set successfully. ');
                    redirect(base_url('withdrawal')); 
                }
                    
            }
             
        }
}
public function bankform(){
        
        $this->form_validation->set_rules('accountname', 'Account name', 'required');
        $this->form_validation->set_rules('accountnumber', 'Account number', 'required');
        $this->form_validation->set_rules('bankname', 'Bank name', 'required');
         if ($this->form_validation->run() == FALSE){

            $datamarketpoint = $this->MainModel->get_singlerecord('trader_user',array('user_ID' => $this->session->userdata('userid')));
            $data['totalmpoint'] = $datamarketpoint->market_point;
            $data['userrow'] = $datamarketpoint;
            $this->load->view('front/common/header');
            $this->load->view('front/withdrawal', $data);
            $this->load->view('front/common/footer');
        }else{
                $data = array(
                        "account_name" =>$this->input->post('accountname'),
                        "account_number" =>$this->input->post('accountnumber'),
                        "bank_name" =>$this->input->post('bankname')
                    );
                $bank = $this->MainModel->updaterecord("trader_user","user_ID",$this->session->userdata('userid'),$data);  
                if($bank){
                    $this->session->set_flashdata('paypalmsg','Bank details set successfully. ');
                    redirect(base_url('withdrawal')); 
                }
                    
             
        }   
}

//---load notification function
public function notificationdefault(){
         $this->MainModel->updaterecord("trader_notifications","touser_ID",$this->session->userdata('userid'),array("status" =>'1'));
        $noti = $this->MainModel->get_notification($this->session->userdata('userid'));
            
            ?>
<div class="notification_page">
    <div class="container noti_main">
      <?php
      //echo "<pre>"; print_r($noti);  
if(!empty($noti)){ 
      foreach ($noti as $not) {
       if($not->joinas = '1'){ $joinas='as attendee'; }else{ $joinas='as presenter'; }
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
              if($not->type == '13' || $not->type == '2' || $not->type == '6'){
              ?>
                  <a href="<?php echo base_url(); ?>view-discussion/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
              <?php
              }
              elseif($not->type == '16'){ ?>
                <a href="<?php echo base_url();?>my-account-dashboard">
                <?php
              }
              else{
              ?>
                  <a href="<?php echo base_url(); ?>discussion-details/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
              <?php
              }
            ?>
          
            <div class="noti_text">
               <div class="noti_title">
                   <h3>
                      <?php
                        if($not->as_Type == '1'){
                            $astype = 'presenter';
                        }
                        else{
                            $astype = 'attendee'; 
                        }
                        if($not->type == '1'){
                          ?>
                          <?php
                          echo ucwords($not->virtual_name).' has invited you for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion as '.$astype; 
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
                        elseif($not->type == '16'){
                          echo 'Admin has approve your withdraw request <span class="bold_text">'.ucwords($not->discussion_title).'</span>';
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
//------default load payment data--------------
public function defaultmy_paymentsloaddata()
{  
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }

            $per_page=2;
            
            $offset = $per_page * ($this->input->post("current_page") -1);
            if($this->input->post("current_page") != ""){
                $page_limit = " LIMIT 2 OFFSET ".$offset;
                $ldmore=$offset;
               }else{
               $page_limit = " LIMIT 2 OFFSET 0";
               $ldmore=$per_page;
               }
            
    // $data = $this->MainModel->getdescdata('trader_transaction',array('user_ID'=>$this->session->userdata('userid')),array('transaction_ID'=>'DESC'),array('2'=>'2'));
    $select='select * from trader_transaction where  user_ID='.$this->session->userdata('userid').' ORDER BY `transaction_ID` DESC';
    // exit;
     $data1=$this->MainModel->runselect($select);
     $data=$this->MainModel->runselect($select.' '.$page_limit);
                $rand=rand(); 
                $html='';      
                setlocale(LC_MONETARY, 'en_IN'); 
                if($data){
                foreach($data as $keyvalue){
                    if($keyvalue->disussion_ID == 0 && $keyvalue->debit_credit==2){
                        $htmlval1='<b>Add Point To Wallet</b>';
                        $icons='zmdi zmdi-plus'; 
                       }else if($keyvalue->debit_credit == 1 && $keyvalue->disussion_ID !=0){
                        $htmlval1='<b>Paid For Discussion</b>';
                        $icons='zmdi zmdi-long-arrow-up';
                      }else if($keyvalue->disussion_ID > 0 && $keyvalue->debit_credit==2){ 
                        $htmlval1='<b>Earn For Discussion</b>';
                        $icons='zmdi zmdi-long-arrow-down'; 
                      }  
                      else if($keyvalue->disussion_ID == 0 && $keyvalue->debit_credit==1){ 
                        $htmlval1='<b>Withdrawal Amount</b>';
                        $icons='zmdi zmdi-long-arrow-up'; 
                      } 

                       if($keyvalue->disussion_ID != 0){ 
                        $htmlval2='<br>Discussion ID #'.str_pad($keyvalue->disussion_ID, 7, '0', STR_PAD_LEFT);
                      } 
  
                    if($keyvalue->debit_credit==1){  $debit='$'.money_format('%!.0n',$keyvalue->amount);}else{ $debit="-"; }
                       if($keyvalue->debit_credit==2){ $credit='$'.money_format('%!.0n',$keyvalue->amount); }else{ $credit="-"; }
 
    $withdrwcheck = $this->MainModel->get_singlerecord('trader_withdrawal_request',array('transaction_ID'=>$keyvalue->transaction_ID));

//print_r($withdrwcheck); exit;

                if(!empty($withdrwcheck)){
                    if($withdrwcheck->status == '1'){
                        $succ = 'processing';            
                    }   
                    else{
                        $succ = 'approved';            
                    } 
                }
                else{
                    $succ = 'success';
                }

                    $html.='<tr class="trcls_'.$keyvalue->transaction_ID.'"><td class="td-title">
                    <div class="doller-rectangle-icon">$
                    <i class="'.$icons.'"></i>
                    </div>
                    <div class="bt-content">';
                    $html.=$htmlval1.''.$htmlval12;
                     
                    $html.='<br>trasaction ID '.str_pad($keyvalue->transaction_ID, 7, '0', STR_PAD_LEFT);

                    $html.='</div>
                </td>
                <td>'.$debit.'</td>
                <td>'.$credit.'</td>
                <td>'.$succ.'</td>
                <td>'.date('d F, Y h:i A',strtotime($keyvalue->createdDate)).'</td></tr>';
                }
                if(count($data1) > $ldmore){
                    $html.='<tr class="load_tr"><td colspan="5" ><div class="load-more-btn" >
                    <a href="javascript:void(0)" class="btn-bule-outline loadpaymenddata" id="1"  data-id="trcls_'.$keyvalue->transaction_ID.'">load more</a>
               </div></td></tr>';
                    }
            }else{
                    $html.='<tr class="load_tr"><td colspan="5" ><div class="load-more-btn" >No Data Found.</div></td></tr>';  
                }

               
    echo $html;
}  
public function ajaxmy_paymentsloaddata()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
            //$limitefrom=($this->input->post("limit"));
            //$limiteto=($this->input->post("limit"))+2;
            $per_page=2;
            $start=$this->input->post("current_page")*$per_page;
            $start1=$start*$per_page;
             $select='select * from trader_transaction where  user_ID='.$this->session->userdata('userid').' ORDER BY `transaction_ID` DESC';
           // exit;
            $data1=$this->MainModel->runselect($select);
            $data=$this->MainModel->runselect($select.' limit '.$start.','. $per_page);
                          $html=''; 
                          $rand=rand();
                          $b=1;     
                          setlocale(LC_MONETARY, 'en_IN');  
                          foreach($data as $keyvalue){
                            if($keyvalue->disussion_ID == 0 && $keyvalue->debit_credit==2){
                                $htmlval1='<b>Add Point To Wallet</b>';
                                $icons='zmdi zmdi-plus'; 
                               }else if($keyvalue->debit_credit == 1){
                                $htmlval1='<b>Paid For Discussion</b>';
                                $icons='zmdi zmdi-long-arrow-up';
                              }else if($keyvalue->disussion_ID > 0 && $keyvalue->debit_credit==2){ 
                                $htmlval1='<b>Earn For Discussion</b>';
                                $icons='zmdi zmdi-long-arrow-down';
                              }  
                               if($keyvalue->disussion_ID != 0){ 
                                $htmlval2='<br>Discussion ID #'.str_pad($keyvalue->disussion_ID, 7, '0', STR_PAD_LEFT);
                              } 
        
                              if($keyvalue->debit_credit==1){  $debit='$'.money_format('%!.0n',$keyvalue->amount);}else{ $debit="-"; }
                               if($keyvalue->debit_credit==2){ $credit='$'.money_format('%!.0n',$keyvalue->amount);}else{ $credit="-"; }
                            $html.='<tr class="trcls_'.$keyvalue->transaction_ID.'"><td class="td-title">
                            <div class="doller-rectangle-icon">$
                            <i class="'.$icons.'"></i>
                            </div>
                            <div class="bt-content">';
                            $html.=$htmlval1.''.$htmlval12;
                             
                            $html.='<br>trasaction ID '.str_pad($keyvalue->transaction_ID, 7, '0', STR_PAD_LEFT);
        
                            $html.='</div>
                        </td>
                        <td>'.$debit.'</td>
                        <td>'.$credit.'</td>
                        <td>success</td>
                        <td>'.date('d F, Y h:i A',strtotime($keyvalue->createdDate)).'</td></tr>';
                        }
                        
                        if(count($data1) > $start1){
                        $html.='<tr class="load_tr"><td colspan="5" ><div class="load-more-btn" >
                        <a href="javascript:void(0)" class="btn-bule-outline loadpaymenddata"  id="'.$start.'" data-id="trcls_'.$keyvalue->transaction_ID.'">load more</a>
                   </div></td></tr>';
                        }
                        echo $html;

                    
               
}  
public function add_emarket_pointtowallet()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
 
    $customerID = $this->getcustomerstripe_ID($this->input->post('cardno'));
    \Stripe\Stripe::setApiKey("sk_test_b3lLzyTbVwjJyaBLOe3s0rRS");
		
    $cents =  (int) ( ( (string) ( $this->input->post('amount') * 100 ) ) );
    
   try {
       $charge = \Stripe\Charge::create(array(
           "amount" => $cents, 
           "currency" => "usd",
           "customer" => $customerID)
        );
       $success = 1;
       
   } catch(Stripe_CardError $e) {
     $error1 = $e->getMessage();
   } catch (Stripe_InvalidRequestError $e) {
     $error1 = $e->getMessage();
   } catch (Stripe_AuthenticationError $e) {
     $error1 = $e->getMessage();
   } catch (Stripe_ApiConnectionError $e) {
     $error1 = $e->getMessage();
   } catch (Stripe_Error $e) {
     $error1 = $e->getMessage();
   } catch (Exception $e) {
     $error1 = $e->getMessage();
   }
   if ($success!=1)
   {
   $this->session->set_flashdata('paymentsfail',$error1);
   redirect(base_url().'my-payments');
   }
//print_r($charge); exit;
   if($charge->id!=''){
    
       $data = array(
           'user_ID'=>$this->session->userdata('userid'),
           'transaction_number'=>$charge->id,
           'disussion_ID'=>0,
           'debit_credit'=>2,
           'amount'=>$this->input->post("amount"),
           'description'=>'Add E-market point to wallet.',
           "createdDate" => date("Y-m-d H:i:s"),
           "updatedDate" => date("Y-m-d H:i:s")
      );
      $insert = $this->MainModel->insertdata('trader_transaction',$data); 
      $userwalletbalcurrent = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
      $userwalletbal=($userwalletbalcurrent->market_point)+($this->input->post('emarket_point'));

     
      $dataval = array('market_point'=>$userwalletbal);
				$condval = array('user_ID'=>$this->session->userdata('userid'));
			    
				$updateuserwallet = $this->MainModel->updaterecords('trader_user',$condval,$dataval);
       }

       $this->session->set_flashdata('paymentsuccess','E-market point added to your wallet successed.');
       redirect(base_url().'my-payments');
         
}   

public function my_account_dashbord()
{
    if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
    $title['page_title'] = "Trader Network :: Dashboard";
    $userselect='SELECT trader_user.*, trader_countries.name as country_name,trader_cities.name as city_name, trader_countries.country_ID,trader_cities.city_ID  FROM trader_user  LEFT JOIN trader_countries ON trader_user.country=trader_countries.country_ID
    LEFT JOIN trader_cities ON trader_cities.city_ID=trader_user.city where trader_user.user_ID='.$this->session->userdata("userid");
    $data['user_Details']=$this->MainModel->runselect($userselect);
   
    $precon1 = array("user_ID"=>$this->session->userdata('userid'),'join_as'=>'2','pre_accept'=>'1');
    $data['Aspresenter'] = $this->MainModel->getcount("trader_bid",$precon1);
    $precon2 = array("user_ID"=>$this->session->userdata('userid'),'join_as'=>'1','payment_status'=>'1');
    $data['Asattendee'] = $this->MainModel->getcount("trader_bid",$precon2);
    $createddis = array("user_ID"=>$this->session->userdata('userid'));
    $data['Ascreated'] = $this->MainModel->getcount("trader_discussion",$createddis);
    $latescreateddiscu='select * from trader_discussion where  user_ID='.$this->session->userdata('userid').'  ORDER BY `discussion_ID` DESC limit 10';
    $data['createdlist']=$this->MainModel->runselect($latescreateddiscu);
    //$latestattendee='SELECT trader_bid.*, trader_discussion.*, trader_bid.dscussion_ID FROM trader_discussion  INNER JOIN trader_bid ON trader_discussion.discussion_ID=trader_bid.dscussion_ID where trader_discussion.status=3 and trader_bid.user_ID='.$this->session->userdata("userid");
    $latestattendee='SELECT trader_bid.*, trader_discussion.*, trader_bid.dscussion_ID FROM trader_discussion  INNER JOIN trader_bid ON trader_discussion.discussion_ID=trader_bid.dscussion_ID where IF(trader_bid.join_as = 2, trader_bid.pre_accept = "1", trader_bid.payment_status = "1") AND trader_bid.approve_status="1" and trader_bid.user_ID='.$this->session->userdata("userid").' ORDER BY `discussion_ID` DESC limit 10';

    $data['latestattendee']=$this->MainModel->runselect($latestattendee);

    $data['cards'] = $this->MainModel->fetchallrow('trader_user_card_details',array('user_ID'=>$this->session->userdata('userid'),'isDeleted'=>'0'));
  
    
    $this->load->view('front/common/header',$title);
    $this->load->view('front/my-account-dashboard',$data);
    $this->load->view('front/common/footer');
}   
}