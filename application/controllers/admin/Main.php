<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'Admin_Master.php';
class Main extends Admin_master {

	public function __construct(){
		parent::__construct();
	}
	public function index(){
		
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = "user";
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/dashbord',$page);
		$this->load->view('admin/common/footer');
		 
	}
	public function dashboard(){
		if($this->session->userdata['logged_in']['adminid'] == ""){
		redirect(base_url('admin'));
		}	
		$page['page_name'] = 'Trader Network:Dashboard';

		$data['dashdata']=$this->AdminModel->runselect('SELECT d.discussion_ID, d.discussion_title,d.base_price,d.category_ID,d.createdDate,d.status,c.name as category, (SELECT COUNT(*) FROM trader_discussion) AS totaldiscussion, (SELECT COUNT(*) FROM trader_discussion WHERE trader_discussion.status = 1 AND trader_discussion.closing_date >= CURDATE()  AND trader_discussion.isActive ="1" AND trader_discussion.isDelete="0") AS opendisccussion, (SELECT COUNT(*) FROM trader_user where isDelete = "0" AND  user_ID != 1) AS totaluser FROM trader_discussion as d LEFT JOIN trader_category as c ON d.category_ID = c.category_ID where d.isDelete = "0" ORDER BY d.discussion_ID DESC limit 10');

		$data['users'] = $this->AdminModel->runselect('SELECT u.*,CONCAT(c.name, ", ", ct.name) AS location FROM trader_user u LEFT JOIN trader_countries c ON u.country = c.country_ID LEFT JOIN trader_cities ct ON u.city = ct.city_ID WHERE u.user_ID != 1 AND u.isDelete = "0" AND u.isActive = "1"  ORDER BY total_skill_points DESC LIMIT 10');

		//print_r($data['users']); exit;

		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/dashboard/dashboard',$data);
		$this->load->view('admin/common/footer');
	}
	public function view_discussion($did){
		if($this->session->userdata['logged_in']['adminid'] == ""){
		redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Dashboard';

        //$userdata = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$id));


		$data['viewdisc']= $this->AdminModel->runselectrow('SELECT d.*,c.name as category,sc.name as subcategory,a.age_range as agerange, CONCAT(u.first_name, " ", u.last_name) AS username from trader_discussion as d LEFT JOIN trader_category AS c ON d.category_ID = c.category_ID LEFT JOIN trader_sub_category AS sc ON d.sub_category = sc.sub_category_ID LEFT JOIN trader_user AS u ON d.user_ID = u.user_ID LEFT JOIN trader_age_group AS a ON d.age_group = a.age_ID WHERE d.discussion_ID = "'.$did.'" ');

			if($data['viewdisc']->skill_required_discussion != ''){
			$skills = explode('|',$data['viewdisc']->skill_required_discussion);
			$implodskills = implode(',',$skills);  
			$skillin = '('.$implodskills.')';
			$data['skills'] = $this->AdminModel->runselect('SELECT name from trader_skills where skill_ID IN '.$skillin);
			}
		//print_r($data['skill']); exit;

		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/dashboard/view_discussion',$data);
		$this->load->view('admin/common/footer');
	}
	public function view_user($uid){
		if($this->session->userdata['logged_in']['adminid'] == ""){
		redirect(base_url('admin'));
		}
		$page['page_name'] = "View User";

        //$userdata = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=>$id));


		$data['viewuser'] = $this->AdminModel->runselectrow('SELECT u.*,CONCAT(c.name, ", ", ct.name) AS location,bc.name as billingcountry, bct.name as billingcity  FROM trader_user u
		LEFT JOIN trader_countries c ON u.country = c.country_ID
		LEFT JOIN trader_cities ct ON u.city = ct.city_ID
		LEFT JOIN trader_countries bc ON u.billing_country = bc.country_ID 
		LEFT JOIN trader_cities bct ON u.billing_city = bct.city_ID
		 WHERE user_ID = "'.$uid.'"');
 
		//print_r($data['viewuser']); exit;
		if($data['viewuser']->expert_field != ''){
		$fieldin = '('.$data['viewuser']->expert_field.')';
		$data['experts'] = $this->AdminModel->runselect('SELECT name from trader_expert_field where field_ID IN '.$fieldin);
		}


		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/dashboard/view_user',$data);
		$this->load->view('admin/common/footer');
	}
}