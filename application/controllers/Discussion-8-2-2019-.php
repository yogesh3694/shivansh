<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
include_once("User_Discussion.php");
//include_once $_SERVER['DOCUMENT_ROOT']."/Trader-Network/application/third_party/stripe/init.php";
include_once APPPATH."third_party/stripe/init.php";
class Discussion extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('MainModel');
		$this->load->library('pagination');
		$this->form_validation->set_error_delimiters('<label class="error">', '</lable>'); 
		$this->load->helper('admin_email');
	}

	public function index()
	{	
		if(!$this->session->userdata('userid')) {
                redirect(base_url().'/login');
        }
        $header['page_title'] = 'Trader Network :: Post Discussion';
        
		if($this->input->post()){
		 $data=$this->input->post();
		 	$this->form_validation->set_rules('discussion_title', 'Discussion Title', 'required');
			$this->form_validation->set_rules('category_ID', 'Category', 'required');
			$this->form_validation->set_rules('sub_category', 'Sub Category', 'required');
			$this->form_validation->set_rules('base_price', 'Base Price', 'required');
			$this->form_validation->set_rules('age_group', 'Age Group', 'required');
			$this->form_validation->set_rules('discussion_start_datetime', 'Discussion Start Datetime', 'required');
			$this->form_validation->set_rules('closing_date', 'Closing Date', 'required');
			$this->form_validation->set_rules('require_presenter', 'Require Presenter', 'required');
			$this->form_validation->set_rules('require_attendee', 'Require Attendee', 'required');
			$this->form_validation->set_rules('requirment_detail', 'Requirment Detail', 'required');
			if($this->form_validation->run() === FALSE){
				$cond = array(
				"isActive"=>'1',
				"isDelete"=>'0'
				);
			   
				$data['category'] = $this->MainModel->fetchallrow('trader_category',$cond);

				$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
				$data['trader_skill'] = $this->MainModel->fetchallrow('trader_skills',$cond);
				$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
				$footer['cms_links'] = $this->MainModel->fetchrowsall('trader_cms');


				$this->load->view("front/common/header",$header);
				$this->load->view('front/post_discussion',$data);
				$this->load->view("front/common/footer",$footer);	
			}else{
				
		   	$stardate=date('Y-m-d H:i:s',strtotime($this->input->post('discussion_start_datetime')));
        	$closing_date=date('Y-m-d',strtotime($this->input->post('closing_date')));

        	$skill_required_discussion=implode('|', $this->input->post('skill_required_discussion'));
        	$attachment_discussion=implode('|', $this->input->post('attachment'));
        	if($this->input->post('isPresenter')!=''){
				$final_price=$this->input->post('bid');
			}else{
				$final_price='0';
			}
        	$user_ID=$this->session->userdata('userid');
        	$data = array(
        			"user_ID"=>$user_ID,
					"discussion_title"=>$this->input->post('discussion_title'),
					"category_ID"=>$this->input->post('category_ID'),
					"sub_category"=>$this->input->post('sub_category'),
					"base_price"=>$this->input->post('base_price'),
					"final_price"=>$final_price,
					"age_group"=>$this->input->post('age_group'),
					"discussion_start_datetime"=>$stardate,
					"closing_date"=>$closing_date,
					"require_presenter"=>$this->input->post('require_presenter'),
					"require_attendee"=>$this->input->post('require_attendee'),
					"skill_required_discussion"=>$skill_required_discussion,
					"requirment_detail"=>$this->input->post('requirment_detail'),
					"attachement"=>$attachment_discussion,
					"isPresenter"=>$this->input->post('isPresenter'),
					"createdBy"=>$user_ID,
					"updatedBy	"=>$user_ID,
					"createdDate"=>date("Y-m-d H:i:s"),
					"updatedDate"=>date("Y-m-d H:i:s")
				);
				if($this->MainModel->insertrow('trader_discussion',$data)){
					$this->session->set_flashdata('success','Your discussion is posted successfully.');
					$insert_id = $this->db->insert_id();
		        }else{
		          $this->session->set_flashdata('Fail','Something error..Try Again.');
		        }

		        if($this->input->post('isPresenter')!='' && $insert_id!=''){
					
		        	$data1 = array(
		        	"dscussion_ID"=>$insert_id,
        			"user_ID"=>$user_ID,
					"join_as"=>'2',
					"bid_type"=>'2',
					"bid"=>$this->input->post('bid'),
					"payable_amount"=>$this->input->post('bid'),
					"approve_status"=>1,
					"pre_accept"=>1,
					"createdDate"=>date("Y-m-d H:i:s"),
					"updatedDate"=>date("Y-m-d H:i:s")
				);
		        	$this->MainModel->insertrow('trader_bid',$data1);
		        }
		        redirect("Post-Discussion","refresh");
			}
		}else{
		$cond = array(
		    "isActive"=>'1',
		    "isDelete"=>'0'
	    );
	      $idcond3 = array(
            "status"=>'1'
        );
        

		$data['category'] = $this->MainModel->fetchallrow('trader_category',$cond);

		$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
		$data['trader_skill'] = $this->MainModel->fetchallrow('trader_skills',$cond);
		$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
		
	
		$this->load->view("front/common/header",$header);
		$this->load->view('front/post_discussion',$data);
		$this->load->view("front/common/footer");
		}	
	}

//-------get user emarket point-----
public function get_emarketpoint(){
	$userwalletbalcurrent = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
	return $userwalletbalcurrent->market_point;
}
 function discussionfileupload(){

 	 $uploadPath = 'upload/discussion/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|doc|docx|pdf|ppt|pptx|xlsx|csv';
                
                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                // Upload file to server
                if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    echo $uploadData['file_name'] = $fileData['file_name'];
                }
	}
	function discussionfiledelete(){

	$path = $_SERVER['DOCUMENT_ROOT'].'/Trader-Network/upload/discussion/';
		if(file_exists($path.$_POST['file'])){
			unlink($path.$_POST['file']);
		}
		
	}
	function getsubcategory(){

	$cat_id=$this->input->post('id');
	$cond = array(
			"category_ID"=>$cat_id,
		    "isActive"=>'1',
		    "isDelete"=>'0'
	    );
			$catdataarr = $this->MainModel->fetchallrow('trader_sub_category',$cond);
			$result='<option value="">Select Sub Category</option>';
			foreach ($catdataarr as $catdataarrvalue) {
				$result.="<option value='".$catdataarrvalue->sub_category_ID."'>".$catdataarrvalue->name."</option>";
			}
			echo $result;
	}

	function searchdiscussiontitle(){

	$searchTerm=$this->input->get('term');
	//$searchTerm = $_GET['term'];
	$cond = array(
			"isActive"=>'1',
		    "isDelete"=>'0'
	    );
	//closing_date >= CURDATE()

	 $select="SELECT * FROM trader_discussion WHERE discussion_title LIKE '%".$searchTerm."%' AND closing_date >= CURDATE() AND isActive = '1' AND isDelete='0' ORDER BY discussion_title DESC";
	$rows = $this->MainModel->runselect($select);
			
	$skillData = array();

			foreach ($rows as $row) {
				$data['id'] = $row->discussion_ID;
				$data['value'] = $row->discussion_title;
				array_push($skillData, $data);
			}
			echo json_encode($skillData);
			
	}

	function discussionlist(){

	$cond = array(
		    "isActive"=>'1',
		    "isDelete"=>'0'
	    );
	$cond1 = array(
		    "status"=>'1'
	    );
		$data['fetchmaxamountmax'] = $this->MainModel->fetchmaxamount('trader_discussion',$idcond1);
	    $header['page_title'] = 'Trader Network :: Discussions';
		$data['category'] = $this->MainModel->fetchallrow('trader_category',$cond);
		$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
		$this->load->view("front/common/header",$header);
		$this->load->view('front/discussion',$data);
		$this->load->view("front/common/footer");
	}
//-----search discussion data function---------	
function searchdiscussiondata(){
		
			$result=''; 
			$selectvalue1='';
			$selectvalue2='';
			$selectvalue3='';
			$selectvalue4='';
			$sort_by='';

			
			if($this->input->post('sort_by')!='' && $this->input->post('sort_by')!='0'){ 
					
					if($this->input->post('sort_by')==2){
						$sort_by='order by discussion_ID ASC';
						$selectvalue2="selected=selected";
						
					}else if($this->input->post('sort_by')==3){
						$sort_by='order by base_price ASC';
						$selectvalue3="selected=selected";
						
					}else if($this->input->post('sort_by')==4){
						$sort_by='order by base_price DESC';
						$selectvalue4="selected=selected";
						
					}else if($this->input->post('sort_by')==1){
						$sort_by='order by discussion_ID DESC';
						$selectvalue1="selected=selected";
						
					}else{
						$sort_by='order by discussion_ID DESC';
						//$selectvalue1="selected=selected";
						
					}

			       }else{
			       	$sort_by='order by discussion_ID DESC';
			       	//$selectvalue1="selected=selected";
			       }
		//---for category----------------------------
			      if($_POST['category']!=''){
			      	$cate=implode(',',$_POST['category']);
			      	$category='AND `td`.`category_ID` IN ('.$cate.')';
			      }else{
			      	$category='';
			      }
		//---for date----------------------------------
			      if($this->input->post('fromdate')!='' && $this->input->post('todate')!=''){ 
			      		$fromdate= date('Y-m-d',strtotime($this->input->post('fromdate')));
			      		$todate= date('Y-m-d',strtotime($this->input->post('todate'))); 

			      		$datequery=" AND discussion_start_datetime between '".$fromdate."' AND '".$todate."'";
			      		//$datequery=" AND discussion_start_datetime >='".$fromdate."' AND discussion_start_datetime <='".$todate."'";
			      }
			      	//---for amount----------------------------------
			      if($this->input->post('amount')!=''){ 
			      	
			      		$amount= $this->input->post('amount');
			      		$amount=explode('-', $amount);
			      		
			      		$amountquery=" AND base_price between '".$amount[0]."' AND '".$amount[1]."'";
			      }
			      	//---for amount----------------------------------
			      if($this->input->post('agegroup')!=''){ 
			      	
			      		$agegroup= $this->input->post('agegroup');
			      		$agegroupquery=" AND age_group=".$agegroup;
			      }

			     // $datequery=" AND discussion_start_datetime between '".$fromdate."' AND '".$todate."'";
		   $select = "SELECT `td`.*,`tc`.`name` as cat_name,`ts`.`name` as sub_cat,(select count(dscussion_ID) from trader_bid where dscussion_ID= td.discussion_ID and approve_status='1' and join_as='1' and payment_status='1' AND isActive='1' AND isDelete='0')as attendee,
			(select count(dscussion_ID) from trader_bid where dscussion_ID= td.discussion_ID and approve_status='1' and join_as='2' AND pre_accept='1' AND isActive='1' AND isDelete='0')as presenter
			FROM `trader_discussion` td LEFT JOIN `trader_category` AS tc ON `td`.`category_ID` = `tc`.`category_ID` LEFT JOIN `trader_sub_category` AS ts ON `td`.`sub_category` = `ts`.`sub_category_ID`
			where td.status='1' AND td.isActive ='1'  AND td.closing_date >= CURDATE() AND td.isDelete='0' $category $agegroupquery $amountquery $datequery $sort_by";

				

	  		 	$page = ($_POST['pagenumber']) ? $_POST['pagenumber']-1 : 0;
    		 	$limit_per_page = 10;
			
				$totalrows = count($this->MainModel->runselect($select));
				$datasnew = $this->MainModel->runselect($select." LIMIT ".$page*$limit_per_page.", ".$limit_per_page);

				$total_pages = ceil($totalrows / $limit_per_page);
				if($totalrows > 0) { 
				$result.='<div class="ajax_main_div_load_discussion"><div class="col-md-9 col-sm-8 right-discussionbox-row">
                        <div class="discussion-result-sort">
							<h3>'.$totalrows.' discussion(s) found.</h3>
							<div class="sortby-main-box">
								<select class="select-bg-cls sort_by" id="sortby" name="sort_by">
									<option value="0">Sort by</option>
									<option value="1" '.$selectvalue1.'>Latest-Oldest</option>
									<option value="2" '.$selectvalue2.'>Oldest-Latest</option>
									<option value="3" '.$selectvalue3.'>Amount Low-High</option>
									<option value="4" '.$selectvalue4.'>Amount High-Low</option>
									
								</select>
							</div>
						</div>
                        <div class="latest-discussion-main-box">';

                        foreach($datasnew as $keyvalue) {
                        	
							$stardate=date('d F,Y',strtotime($keyvalue->discussion_start_datetime));
                        	$closingdate=date('d F Y',strtotime($keyvalue->closing_date));
                        	$starttime=date('h:i A',strtotime($keyvalue->discussion_start_datetime));
							if($keyvalue->base_price >99999){
							 $Amount = "<span>$</span>".($keyvalue->base_price / 1000).'<span>K</span>';
							}else{
							 $Amount = "<span>$</span>".$keyvalue->base_price;
							}

							if($keyvalue->presenter==$keyvalue->require_presenter){
								$prcl = 'presents-circle-area presenter-attende-green-button';
							}else{
								$prcl = 'presents-area presents-circle-area';
							}
							if($keyvalue->attendee==$keyvalue->require_attendee){
								$atcl = 'presents-circle-area presenter-attende-green-button';
							}else{
								$atcl = 'attendes-area presents-circle-area';
							}
                            $result.='<div class="col-md-6 col-sm-12 latest-discussion-box" >
                            	<a href="'.base_url().'discussion-details/'.$keyvalue->discussion_ID.'">
                                <div class="col-xs-12 latest-discussion-box-bg" >
                                    <div class="present-seo-title-main"> 
                                    <div class="tooltip_div">
                                        <h3 class="present-seo-title present-seo-title-commen-cls ">'.mb_strimwidth($keyvalue->discussion_title, 0, 35,"...").'</h3>';
                                        if(strlen($keyvalue->discussion_title) >35 ){
                                         $result.='<span class="tooltiptext">'.$keyvalue->discussion_title.'</span>';
                                        }
                                        $result.='</div>
                                        <div class="right-box">'.$Amount.'</div>
                                    </div>
                                    <div class="coordinator-description">
                                        <div class="inner-txt-title">
                                            <ul>
                                                <li><i class="fa fa-tag" aria-hidden="true"></i>'.$keyvalue->cat_name.'</li>';
                                                if($keyvalue->sub_cat!=''){
                                                $result.='<li><i class="fa fa-arrow-right" aria-hidden="true"></i> '.$keyvalue->sub_cat.'</li>';
                                            		}
                                            $result.='</ul>
                                        </div>
                                        <div class="date-time-txt">
                                            <span><i class="fa fa-calendar" aria-hidden="true"></i>'.$stardate.' |<span>'.$starttime.'</span></span>
                                        </div>
                                        <div class="closing-date">
                                            <p>Bid Closing Date: '.$closingdate.'</p>
                                        </div>
                                        <div class="presents-attendes-area">
                                            <div class="presents-area-commen-cls">
                                                <span class="'.$prcl.'">'.$keyvalue->presenter.'/'.$keyvalue->require_presenter.'</span>
                                                <span class="inner-txt">presenters</span>
                                            </div>
                                            <div class="presents-area-commen-cls attendes-area-cls">
                                                <span class="'.$atcl.'">'.$keyvalue->attendee.'/'.$keyvalue->require_attendee.'</span>
                                                <span class="inner-txt">attendees</span>
                                            </div>
                                        </div>
                                    </div>
                                </div></a>
                            </div>';
                            	}

					        $result.='<div class="clear"></div>
	                        </div>';
	                        $result.='<div class="clear"></div>';
	                        $current_page = $_POST['pagenumber'];
							if($current_page) {$current_page=$current_page; }else{ $current_page=1; }
							if($totalrows > 10){
							$result.='<input type="hidden" name="pagination" id="current_page_123" ><input type="hidden" name="pagination_values" id="current_page" value="'.$current_page.'"><div class="custom-pagination">
			                            <nav aria-label="Page navigation example"> <ul class="pagination">';
							
							if($current_page >= 2){
							$result.=' <li class="page-item"><a href="javascript:void(0)" class="page-link pagination_my page-numbers prev" data-info="prev" aria-label="Previous" ><span> <i class="fa fa-angle-left" aria-hidden="true"></i> Prev</span></a></li>';	
							}
							
					        for($start=1;$start<=$total_pages;$start++)
							{
								if($current_page == $start)
								{
									$class="page_active current";
								}else{
									$class="";
								}
								$result.='<li class="page-item '.$class.'"><a href="javascript:void(0)" class="pagination_my page-link  page-numbers '.$class.'" data-info= "'.$start.'" >'.$start.'</a></li>';
								
							}
							if($total_pages > 1 && $current_page < $total_pages){
							$result.='<li class="page-item"><a href="javascript:void(0)" class="page-link pagination_my next page-numbers" data-info="next" > <span>Next <i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>';
							}
				        $result.='</ul><div class="clear"></div>';
				    }
                    $result.='</div></div>'; 
                }else{
                	$result.='<div class="ajax_main_div_load_discussion"><div class="col-md-9 col-sm-8 right-discussionbox-row"> <div class="discussion-result-sort">
							<h3>'.$totalrows.' discussion(s) found.</h3>
							</div><div class="discu_notfound">Discussion Not Found.</div><div class="clear"></div>
                    </div></div>';
                }
	echo $result;
				
	}
/*------------------------------------- kishan code ----------------------------------------*/

public function mycreated_disc(){

	if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
	$header['page_title'] = 'Trader Network :: Created Discussions';
	$data['category'] = $this->MainModel->getalldata('trader_category');
	$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);

	$this->load->view("front/common/header",$header);
	$this->load->view('front/mycreated_discussions',$data);
	$this->load->view("front/common/footer");
}
public function mycreated_discajax(){  //print_r($_REQUEST);
	    
		if($_REQUEST['order'][0]['column'] == '4'){
			$order='order by td.discussion_start_datetime '.$_REQUEST['order'][0]['dir'];
		}
		else if($_REQUEST['order'][0]['column'] == '5'){
			$order='order by td.require_presenter '.$_REQUEST['order'][0]['dir'];
		}
		else if($_REQUEST['order'][0]['column'] == '6'){
			$order='order by td.status '.$_REQUEST['order'][0]['dir'];
		}
		else{
			$order='order by td.discussion_ID DESC';
		}
	 
 		$where = '';
 		if($_REQUEST['keyword'] != ''){
			$where .= "AND td.discussion_title LIKE '%".$_REQUEST['keyword']."%' ";
		}
		if($_REQUEST['category'] != ''){
			$where .= "AND td.category_ID = '".$_REQUEST['category']."' ";
		}
		if($_REQUEST['from'] != ''){

			if($_REQUEST['from'] != '' && $_REQUEST['to']){
				$where .= "AND td.discussion_start_datetime BETWEEN '".date('Y-m-d',strtotime($_REQUEST['from']))."' AND '".date('Y-m-d',strtotime($_REQUEST['to']))."' "; 
			}
			else{
				$where .= "AND td.discussion_start_datetime >= '".date('Y-m-d',strtotime($_REQUEST['from']))."' ";
			}
		}
		if($_REQUEST['status'] != ''){
			if($_REQUEST['status'] == '1' ){
				//$where .= "AND td.status = '".$_REQUEST['status']."'  ";
				$where .= "AND td.status = '".$_REQUEST['status']."' AND td.closing_date >= '".date('Y-m-d')."' ";
			}
			else if($_REQUEST['status'] == '2' ){
				//$where .= "AND td.status = '".$_REQUEST['status']."'  ";
				$where .= "AND td.status != '3' AND td.status != '4' AND td.closing_date < '".date('Y-m-d')."' ";
			}
			else{
				$where .= "AND td.status = '".$_REQUEST['status']."' ";
			}
		}
		  
   		$qry = "SELECT td.*,tc.name as cat from trader_discussion as td left join trader_category as tc on td.category_ID = tc.category_ID WHERE td.user_ID = '".$this->session->userdata('userid')."' ".$where; 
	 //echo $qry;
       $querycount = $this->MainModel->runselect($qry);

$disdata = $this->MainModel->runselect('SELECT td.*,tc.name as cat,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" and pre_accept="1" AND isActive="1" AND isDelete="0")as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee  from trader_discussion as td left join trader_category as tc on td.category_ID = tc.category_ID WHERE td.user_ID = '.$this->session->userdata('userid').' '.$where.' '.$order.' LIMIT '.$_REQUEST["start"].', '.$_REQUEST['length']);

		 
         	$i=$_REQUEST['start'];
            foreach($disdata as $disc){ $i++;
 
	            $action = '<a title="Edit" href="'.base_url().'edit-discussion/'.$disc->discussion_ID.'" class="t_edit_icon"><i class="zmdi zmdi-edit"></i></i></a><a title="View" href="'.base_url().'view-discussion/'.$disc->discussion_ID.'" class="t_delet_icon"><i class="fa fa-eye" aria-hidden="true"></i></a>';

	            if($disc->status == '1'){
	            	 if($disc->status == '1' && $disc->closing_date >= date('Y-m-d')){
	            		$status = '<div class="green-button">Open</div>';
	            	 }else{
	            	 	$status = '<div class="gray-button">Close</div>';
	            	 }
	            }
	            else if($disc->status == '2'){
	            	$status = '<div class="gray-button">Close</div>';
	            }
	            else if($disc->status == '4'){
	            	$status = '<div class="red-button">Cancelled</div>';
	            }
	            else{
	            	$status = '<div class="blue-button">Completed</div>';
	            }
  
	            $data[] = array( $i.'.',
	            				 $disc->discussion_title,
	            				 '$'.$disc->base_price,
	            				 $disc->cat,
	            				 date('d F, Y h:i A',strtotime($disc->discussion_start_datetime)),
	            				 $disc->presenter.'/'.$disc->require_presenter.' Presenter<br/>'.$disc->attendee.'/'.$disc->require_attendee.' Attendee',
	            				 $status,
	            				 $action
	            				); 
	        	}
	        	if(empty($data)){ $data = 0; $_REQUEST['draw'] = ''; $dataCount = ''; }
             
            	$dataCount = count($querycount);
             	 	
 					
			$json_data = array(
                "draw"            =>  intval( $_REQUEST['draw']),
                "recordsTotal"    =>  intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);
}
public function myattended_disc(){

	if($this->session->userdata('userid') == ""){
        redirect(base_url('login'));
    }
	$header['page_title'] = 'Trader Network :: Attended Discussions';
	$data['category'] = $this->MainModel->getalldata('trader_category');
	$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);

	$this->load->view("front/common/header",$header);
	$this->load->view('front/myattended_discussions',$data);
	$this->load->view("front/common/footer");
}
public function myattended_discajax(){  //print_r($_REQUEST);
	    
		if($_REQUEST['order'][0]['column'] == '4'){
			$order='order by td.discussion_start_datetime '.$_REQUEST['order'][0]['dir'];
		}
		else if($_REQUEST['order'][0]['column'] == '5'){
			$order='order by tb.join_as '.$_REQUEST['order'][0]['dir'];
		}
		else if($_REQUEST['order'][0]['column'] == '6'){
			$order='order by td.status '.$_REQUEST['order'][0]['dir'];
		}
		else{
			$order='order by td.discussion_ID DESC';
		}
	 
 		$where = '';
 		if($_REQUEST['keyword'] != ''){
			$where .= "AND td.discussion_title LIKE '%".$_REQUEST['keyword']."%' ";
		}
		if($_REQUEST['category'] != ''){
			$where .= "AND td.category_ID = '".$_REQUEST['category']."' ";
		}
		if($_REQUEST['from'] != ''){

			if($_REQUEST['from'] != '' && $_REQUEST['to']){
				$where .= "AND td.discussion_start_datetime BETWEEN '".date('Y-m-d',strtotime($_REQUEST['from']))."' AND '".date('Y-m-d',strtotime($_REQUEST['to']))."' "; 
			}
			else{
				$where .= "AND td.discussion_start_datetime >= '".date('Y-m-d',strtotime($_REQUEST['from']))."' ";
			}
		}
		if($_REQUEST['join'] != ''){
			 
				$where .= "AND tb.join_as = '".$_REQUEST['join']."'";
		}
		if($_REQUEST['status'] != ''){
			if($_REQUEST['status'] == '1' ){
				//$where .= "AND td.status = '".$_REQUEST['status']."'  ";
				$where .= "AND td.status = '".$_REQUEST['status']."' AND td.closing_date >= '".date('Y-m-d')."' ";
			}
			else if($_REQUEST['status'] == '2' ){
				//$where .= "AND td.status = '".$_REQUEST['status']."'  ";
				$where .= "AND td.status != '3' AND td.status != '4' AND td.closing_date < '".date('Y-m-d')."' ";
			}
			else{
				$where .= "AND td.status = '".$_REQUEST['status']."' ";
			}
		}
		  
	$qry = 'SELECT tb.join_as as joinas,tb.bid,tb.dscussion_ID as tbdiscussionid,td.*, tc.name as cat, (select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" and pre_accept="1" AND isActive="1" AND isDelete="0")as presenter, (select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee FROM trader_bid as tb LEFT JOIN trader_discussion as td ON tb.dscussion_ID = td.discussion_ID LEFT JOIN trader_category as tc on td.category_ID = tc.category_ID WHERE tb.approve_status = "1" AND tb.user_ID = '.$this->session->userdata('userid').' '.$where; 

    $querycount = $this->MainModel->runselect($qry);

$disdata = $this->MainModel->runselect('SELECT tb.join_as as joinas,tb.bid,tb.dscussion_ID as tbdiscussionid,td.*, tc.name as cat, (select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" and pre_accept="1" AND isActive="1" AND isDelete="0" )as presenter, (select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee FROM trader_bid as tb LEFT JOIN trader_discussion as td ON tb.dscussion_ID = td.discussion_ID LEFT JOIN trader_category as tc on td.category_ID = tc.category_ID WHERE tb.approve_status = "1" AND tb.user_ID = '.$this->session->userdata('userid').' '.$where.' '.$order.' LIMIT '.$_REQUEST["start"].', '.$_REQUEST['length']);

		 
         	$i=$_REQUEST['start'];
            foreach($disdata as $disc){ $i++;
 
	            $action = '<a title="View" href="'.base_url().'discussion-details/'.$disc->discussion_ID.'" class="t_delet_icon"><i class="fa fa-eye" aria-hidden="true"></i></a>';

	            if($disc->status == '1'){
	            	 if($disc->status == '1' && $disc->closing_date >= date('Y-m-d')){
	            		$status = '<div class="green-button">Open</div>';
	            	 }else{
	            	 	$status = '<div class="gray-button">Close</div>';
	            	 }
	            }
	            else if($disc->status == '2'){
	            	$status = '<div class="gray-button">Close</div>';
	            }
	            else if($disc->status == '4'){
	            	$status = '<div class="red-button">Cancelled</div>';
	            }
	            else{
	            	$status = '<div class="blue-button">Completed</div>';
	            }

	            if($disc->joinas == '1'){
	            	$join = '<div class="attjoin_cls">Attendee</div>';
	            	$bid = $disc->bid.'%';
	            }
	            else{
	            	$join = '<div class="prejoin_cls">Presenter</div>';	
	            	$bid = '$'.$disc->bid;
	            }
	            if($disc->discussion_title!=''){ $dstitle = $disc->discussion_title; }else{$dstitle='-';}
	            $data[] = array( $i.'.',
	            				 $dstitle,
	            				 '$'.$disc->base_price,
	            				 $disc->cat,
	            				 date('d F, Y h:i A',strtotime($disc->discussion_start_datetime)),
	            				 $join,					 
	            				 $bid,
	            				 $status,
	            				 $action
	            				); 
	        	}
	        	if(empty($data)){ $data = 0; $_REQUEST['draw'] = ''; $dataCount = ''; }
             
            	$dataCount = count($querycount);
             	 	
 					
			$json_data = array(
                "draw"            =>  intval( $_REQUEST['draw']),
                "recordsTotal"    =>  intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);
}
public function edit_discussion($did){  

	if($this->session->userdata('userid') == ""){
	        redirect(base_url('login'));
	}
	$header['page_title'] = 'Trader Network :: Edit Discussion';

			$data=$this->input->post();
		 	$this->form_validation->set_rules('discussion_title', 'Discussion Title', 'required');
			$this->form_validation->set_rules('category_ID', 'Category', 'required');
			$this->form_validation->set_rules('sub_category', 'Sub Category', 'required');
			$this->form_validation->set_rules('base_price', 'Base Price', 'required');
			$this->form_validation->set_rules('age_group', 'Age Group', 'required');
			$this->form_validation->set_rules('discussion_start_datetime', 'Discussion Start Datetime', 'required');
			$this->form_validation->set_rules('closing_date', 'Closing Date', 'required');
			$this->form_validation->set_rules('require_presenter', 'Require Presenter', 'required');
			$this->form_validation->set_rules('require_attendee', 'Require Attendee', 'required');
			$this->form_validation->set_rules('requirment_detail', 'Requirment Detail', 'required');

			if($this->form_validation->run() === FALSE){

				$cond = array(
					"isActive"=>'1',
					"isDelete"=>'0'
				);
			   
				$data['category'] = $this->MainModel->fetchallrow('trader_category',$cond);
				

				$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
				$data['trader_skill'] = $this->MainModel->fetchallrow('trader_skills',$cond);
				$data['trader_age_group'] = $this->MainModel->fetchallrow('trader_age_group',$cond);
				$footer['cms_links'] = $this->MainModel->fetchrowsall('trader_cms');

				$data['disdata'] = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID' => $did));
 				$data['subcat'] = $this->MainModel->fetchallrow('trader_sub_category',array('category_ID' => $data['disdata']->category_ID));

 				$bidcon = array('user_ID'=>$this->session->userdata('userid'),'dscussion_ID'=>$did,'approve_status'=>'1');
	        	$bidcheck = $this->MainModel->get_singlerecord('trader_bid',$bidcon);
	        	//print_r($bidcheck); exit;
	        	if(!empty($bidcheck)){
					$data['userbid'] = $bidcheck->bid; 		        		
	        	}

				$this->load->view("front/common/header",$header);
				$this->load->view('front/edit_discussion',$data);
				$this->load->view("front/common/footer",$footer);	

			}else{

		   		$stardate=date('Y-m-d H:i:s',strtotime($this->input->post('discussion_start_datetime')));
				$con = array('discussion_ID'=>$did);
				$disdate = $this->MainModel->get_singlerecord('trader_discussion',$con);
				//echo $disdate->discussion_start_datetime.'--'.$stardate; 
				if($disdate->discussion_start_datetime != $stardate){
					//send notification to all users
					$usercon = array('dscussion_ID'=>$did);
					$bid_userdata = $this->MainModel->fetchallrow('trader_bid',$usercon);
					if(!empty($bid_userdata)){
					//echo "<pre>"; print_r($bid_userdata); exit;

						foreach ($bid_userdata as $biduser) {

							if($biduser->user_ID != $this->session->userdata('userid')){

								if($biduser->join_as == '2'){
								
									$accept_con = array('user_ID'=>$biduser->user_ID,'dscussion_ID'=>$did,'approve_status'=>'1','pre_accept'=>'1');
		        					$accepted_pre = $this->MainModel->get_singlerecord('trader_bid',$accept_con);

		        					$up_accepted_pre = $this->MainModel->updaterecord('trader_bid','bid_ID',$accepted_pre->bid_ID,array('pre_accept'=>''));
  								}
								$usrcon = array('user_ID'=>$biduser->user_ID);
								$newusr = $this->MainModel->get_singlerecord('trader_user',$usrcon);
								//send notification
								$notidata = array(
									'post_discu_ID'=>$did,
									'fromuser_ID'=>$this->session->userdata('userid'),
									'touser_ID'=>$biduser->user_ID,
									'type'=>'11',
									"createdDate"=>date("Y-m-d H:i:s")
								);
								$this->MainModel->insertrow('trader_notifications',$notidata);	
	  
								$usersubject = "Discussion Date has been Changed | ".date('d F Y H:i a',strtotime($this->input->post('discussion_start_datetime')));
								$maildata['mailed_data'] = array(
								                    "username"=>$newusr->virtual_name,
								                    //'bid'     => $bid->bid,
								                    'discussion'  => $disdate->discussion_title,
								                    'joinas'  => $biduser->join_as,
								                    'discussion_dt'=> $this->input->post('discussion_start_datetime'),
								                    'discussion_id'=> $disdate->discussion_ID,
								                    'logo'    => base_url().'assets/images/trader-logo.png'
								                );
									$change_mail = $this->load->view("templates/date_change",$maildata,true);
								 //echo '<br/>'.$change_mail.$disdate->join_as;
									if($newusr->notification_email != ''){
										$notiemail = $newusr->notification_email;
									}
									else{
										$notiemail = $newusr->email;
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
							        $this->email->message($change_mail);
							        $this->email->set_mailtype("html");
							        $this->email->send();
							}						        
						} 
					}
				} 
				
        	$closing_date=date('Y-m-d',strtotime($this->input->post('closing_date')));

        	$skill_required_discussion=implode('|', $this->input->post('skill_required_discussion'));
        	$attachment_discussion=implode('|', $this->input->post('attachment'));
        	
        	$user_ID=$this->session->userdata('userid');

			$existsbid = $this->MainModel->runselectrow('SELECT SUM(`payable_amount`)as exist_pre_sum from trader_bid where dscussion_ID = "'.$did.'" AND approve_status="1" AND join_as="2" AND pre_accept="1" AND isActive="1" AND isDelete="0" ');

			$exiscon = array('dscussion_ID'=>$did,'approve_status'=>'1','join_as'=>'2','pre_accept'=>'1');
			$userarr = $this->MainModel->fetchallrow('trader_bid',$exiscon);

			foreach ($userarr as $usr) {
				$exists_user_id[] = $usr->user_ID; 
			}

        	if($this->input->post('isPresenter')!=''){

	       		if(in_array($user_ID,$exists_user_id)){

					$currentuserbid = $this->MainModel->runselectrow('SELECT bid from trader_bid where dscussion_ID = "'.$did.'" AND approve_status="1" AND join_as="2" AND pre_accept="1" AND user_ID="'.$user_ID.'" ');

					if($currentuserbid->bid != $this->input->post('bid')){     
 
        				$final_price1 = $existsbid->exist_pre_sum-$currentuserbid->bid;
						$final_price = $final_price1 + $this->input->post('bid');

						/*echo $currentuserbid->bid.'---'.$this->input->post('bid');
						echo '<br/>'.$final_price1.'---'.$final_price;

						exit;*/

					}
					else{
						$final_price=$existsbid->exist_pre_sum;
					}

   				}
   				else{
   					$final_price = $existsbid->exist_pre_sum + $this->input->post('bid');	
   				}

			}else{
				$final_price=$existsbid->exist_pre_sum;
			}

        	if($this->input->post('attachment') != ''){

        		$data = array(
        			"user_ID"=>$user_ID,
					"discussion_title"=>$this->input->post('discussion_title'),
					"category_ID"=>$this->input->post('category_ID'),
					"sub_category"=>$this->input->post('sub_category'),
					"base_price"=>$this->input->post('base_price'),
					"final_price"=>$final_price,
					"age_group"=>$this->input->post('age_group'),
					"discussion_start_datetime"=>$stardate,
					"closing_date"=>$closing_date,
					"require_presenter"=>$this->input->post('require_presenter'),
					"require_attendee"=>$this->input->post('require_attendee'),
					"skill_required_discussion"=>$skill_required_discussion,
					"requirment_detail"=>$this->input->post('requirment_detail'),
					"attachement"=>$attachment_discussion,
					"isPresenter"=>$this->input->post('isPresenter'),
					"createdBy"=>$user_ID,
					"updatedBy	"=>$user_ID,
					"updatedDate"=>date("Y-m-d H:i:s")
				);
        	}
        	else{
        		$data = array(
        			"user_ID"=>$user_ID,
					"discussion_title"=>$this->input->post('discussion_title'),
					"category_ID"=>$this->input->post('category_ID'),
					"sub_category"=>$this->input->post('sub_category'),
					"base_price"=>$this->input->post('base_price'),
					"final_price"=>$final_price,
					"age_group"=>$this->input->post('age_group'),
					"discussion_start_datetime"=>$stardate,
					"closing_date"=>$closing_date,
					"require_presenter"=>$this->input->post('require_presenter'),
					"require_attendee"=>$this->input->post('require_attendee'),
					"skill_required_discussion"=>$skill_required_discussion,
					"requirment_detail"=>$this->input->post('requirment_detail'),
					"isPresenter"=>$this->input->post('isPresenter'),
					"createdBy"=>$user_ID,
					"updatedBy	"=>$user_ID,
					"updatedDate"=>date("Y-m-d H:i:s")
				);	
        	}
				$up = $this->MainModel->updaterecord('trader_discussion','discussion_ID',$did,$data);
					$this->session->set_flashdata('success','Discussion has been successfully updated.');
			 
	        	$bidcon = array('user_ID'=>$user_ID,'dscussion_ID'=>$did,'approve_status'=>'1');
	        	$bidcheck = $this->MainModel->get_singlerecord('trader_bid',$bidcon);
		        if($this->input->post('isPresenter')!='' && $up!=''){

		        	if(empty($bidcheck)){

			        	$data1 = array(
				        	"dscussion_ID"=>$did,
		        			"user_ID"=>$user_ID,
							"join_as"=>'2',
							"bid_type"=>'2',
							"bid"=>$this->input->post('bid'),
							"payable_amount"=>$this->input->post('bid'),
							"approve_status"=>1,
							"pre_accept"=>'1',
							"createdDate"=>date("Y-m-d H:i:s"),
							"updatedDate"=>date("Y-m-d H:i:s")
						);
				        $this->MainModel->insertrow('trader_bid',$data1);
		        	}
		        	else{

		        		$data1 = array(
							"bid"=>$this->input->post('bid'),
							"payable_amount"=>$this->input->post('bid'),
							"updatedDate"=>date("Y-m-d H:i:s")
						);
				        $this->MainModel->updaterecord('trader_bid','bid_ID',$bidcheck->bid_ID,$data1);	
		        	}
		        }
		        else{
		        	if(!empty($bidcheck)){
		        		$dltbid = $this->MainModel->removedata('trader_bid','bid_ID',$bidcheck->bid_ID);
		        	}
		        }
		        //redirect("my-created-discussion","refresh");
				redirect($_SERVER['HTTP_REFERER']);
			}
		 
}
public function view_discussion($did){ //view discussion for my created/attendeed 

	if($this->session->userdata('userid') == ""){
	        redirect(base_url('login'));
	}
	$header['page_title'] = 'Trader Network :: View Discussions';

	if($this->input->get('n') != ''){
		$nid = $this->input->get('n');
		$this->MainModel->updaterecord("trader_notifications","notification_ID",$nid,array("status" =>'1'));
	}

	$data['discid'] = $did;

	$commndata = $this->view_discussion_common($did);

	$data['descdata'] = $commndata['main'];
	
	$data['skills'] = $commndata['skill'];  
	$data['cards'] = $this->MainModel->fetchallrow('trader_user_card_details',array('user_ID'=>$this->session->userdata('userid'),'isDeleted'=>'0'));
	
	$bidcon = array('user_ID'=>$this->session->userdata('userid'),'dscussion_ID'=>$did,'approve_status'=>'1');
	$data['selfpre'] = $this->MainModel->get_singlerecord('trader_bid',$bidcon);

	$pymcon = array('user_ID'=>$this->session->userdata('userid'),'debit_credit'=>'1','disussion_ID'=>$did);
	$data['paymentcheck'] = $this->MainModel->get_singlerecord('trader_transaction',$pymcon);

	$data['wallet_ballance']=$this->get_emarketpoint();

	$this->load->view("front/common/header",$header);
	$this->load->view('front/view_mycreated_discussion',$data);
	$this->load->view("front/common/footer");
}
public function discussion_details($did){ //discussion details

	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	$header['page_title'] = 'Trader Network :: Discussions Details';

	if($this->input->get('n') != ''){
		$nid = $this->input->get('n');
		$this->MainModel->updaterecord("trader_notifications","notification_ID",$nid,array("status" =>'1'));
	}

	$data['discid'] = $did;
 
	$cond = array(
			"user_ID"=>$this->session->userdata('userid'),
			"dscussion_ID"=>$did,
		);
	$joinuser = $this->MainModel->get_singlerecord('trader_bid',$cond);
	if(!empty($joinuser)){
		$data['userjoin'] = $joinuser;		
	}
	 
	$commndata = $this->view_discussion_common($did);

	$data['descdata'] = $commndata['main'];

	$data['skills'] = $commndata['skill']; 
	$usermarket_point = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
	
	$data['market_point'] = ($usermarket_point->market_point)? $usermarket_point->market_point : '0'; 
	
	$data['cards'] = $this->MainModel->fetchallrow('trader_user_card_details',array('user_ID'=>$this->session->userdata('userid'),'isDeleted'=>'0'));

	$data['pre_feedback'] = $this->MainModel->runselect("SELECT tb.*,tu.user_ID,tu.virtual_name,tu.profile_photo from trader_bid as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID WHERE tb.dscussion_ID = '".$did."' AND tb.join_as = '2' AND tb.approve_status = '1' AND tb.pre_accept = '1'");

	$fedcond = array('discussion_ID' => $did,'attendee' => $this->session->userdata('userid'));
	$data['attfeedback'] = $this->MainModel->fetchallrow('trader_feedback',$fedcond);
 
	//give feedback mail to attendee
	/*if( $data['descdata']->status == '3' && $data['descdata']->discussion_start_datetime < date("Y-m-d H:i:s") && empty($data['attfeedback'])){
 
		$allatt = $this->MainModel->joinwithorderby('trader_bid','trader_user','user_ID','user_ID',array('dscussion_ID'=>$did,'approve_status'=>'1','payment_status'=>'1'));
		//print_r($allatt);
		foreach ($allatt as $at) {
			$usersubject = "Give feedback to Presenter.";
						$maildata['mailed_data'] = array(
						                    "username"=>$at->virtual_name,
						                    'discussion'  => $data['descdata']->discussion_title,
						                    'discussion_id' => $data['descdata']->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
				$feed_template = $this->load->view("templates/give_feedback",$maildata,true);
				print_r($feed_template); exit;
				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user2->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($newuser);
			        $this->email->set_mailtype("html");
		$this->session->set_flashdata('success','Bid Approved Successfully.');
		//redirect(base_url().'view-discussion/'.$bid->dscussion_ID);	 
		}*/
	//} 
	$this->load->view("front/common/header",$header);
	$this->load->view('front/discussion_details',$data);
	$this->load->view("front/common/footer");
	
}
public function view_discussion_common($did){ //common discussion function

	$data['main'] =  $this->MainModel->runselectrow('SELECT td.*,c.name as category, sc.name as subcategory, age.age_range as agerange,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" and pre_accept="1" AND isActive="1" AND isDelete="0" AND pre_accept="1" )as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee ,(select SUM(`payable_amount`) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" AND isActive="1" AND isDelete="0" AND payment_status="1" )as attendee_payamount from trader_discussion as td 
		LEFT JOIN trader_category as c ON td.category_ID = c.category_ID 
		LEFT JOIN trader_sub_category as sc ON td.sub_category = sc.sub_category_ID
		LEFT JOIN trader_age_group as age on td.age_group = age.age_ID
		WHERE discussion_ID = "'.$did.'"
	');

	$inskill = str_replace('|','","',$data['main']->skill_required_discussion);

	$data['skill'] = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');

		return $data;
}
public function discussion_cancel($did){ //common cancel discussion function
 
 	if($did != ''){
 
 		$data = array("status"=>'4',"updatedDate"=>date("Y-m-d H:i:s"));
 		
 		$upbid = $this->MainModel->updaterecord('trader_discussion','discussion_ID',$did,$data);

		if($upbid){

	 		$usercond = array('dscussion_ID'=>$did,'approve_status'=>'1');
			$approveuser = $this->MainModel->fetchallrow('trader_bid',$usercond);

			$dsccond = array('discussion_ID'=>$did);
			$canceldsc = $this->MainModel->get_singlerecord('trader_discussion',$dsccond);

			//all approve user cancell notification
			if(!empty($approveuser)){
				foreach ($approveuser as $user) {
					$notidata = array(
							'post_discu_ID'=>$did,
							'fromuser_ID'=>$this->session->userdata('userid'),
							'touser_ID'=>$user->user_ID,
							'type'=>'9',
							"createdDate"=>date("Y-m-d H:i:s")
						);
					$cancelnoti = $this->MainModel->insertrow('trader_notifications',$notidata);
 
 					if($cancelnoti){
						$usrcon = array('user_ID'=>$user->user_ID);
						$newusr2 = $this->MainModel->get_singlerecord('trader_user',$usrcon);

						$usersubject = ucwords($canceldsc->discussion_title)." Discussion has been Cancelled";
						
						$maildata['mailed_data'] = array(
						                    "username"=>$newusr2->virtual_name,
						                    'discussion'  => $canceldsc->discussion_title,
						                    'discussion_id'=> $canceldsc->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
							$cncl_mail = $this->load->view("templates/cancel_discussion",$maildata,true);

							if($newusr2->notification_email != ''){
								$notiemail = $newusr2->notification_email;
							}
							else{
								$notiemail = $newusr2->email;
							}
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

			                    $this->email->from(admin_email(),'Trader Network');
						        $this->email->to($notiemail);
						        $this->email->subject($usersubject);
						        $this->email->message($cncl_mail);
						        $this->email->set_mailtype("html");
						        $this->email->send();
					}
				}
			} 
			$this->session->set_flashdata('success','Discussion cancelled successfully.');
		    redirect(base_url().'view-discussion/'.$did);
		}
 	}
}
public function discussion_complete($did){  
 
	if($did != ''){

		$data = array("status"=>'3',"updatedDate"=>date("Y-m-d H:i:s"));
		
		$upbid = $this->MainModel->updaterecord('trader_discussion','discussion_ID',$did,$data);
		$get_discussion = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
		$get_owner_bidid = $this->MainModel->get_singlerecord('trader_bid',array('dscussion_ID'=>$did,'user_ID'=>$get_discussion->user_ID));
	
	   if($upbid){
	
		   // $usercond = array('dscussion_ID'=>$did,'approve_status'=>'1');
		   // $approveuser = $this->MainModel->fetchallrow('trader_bid',$usercond);
		    $select="SELECT trader_bid.*, trader_user.virtual_name,trader_user.email,trader_user.notification_email,trader_user.total_skill_points FROM trader_bid INNER JOIN trader_user ON trader_bid.user_ID=trader_user.user_ID 
			WHERE  dscussion_ID=$did AND  approve_status=1";
			
		   $approveuser = $this->MainModel->runselect($select);
		   $usercond = array('dscussion_ID'=>$did,'approve_status'=>'1');
		   $trader_emarket_skiil_points_settings = $this->MainModel->getdescdatalimit('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>'Desc'),array('1'=>'0'));
		
		   $point_exp=explode(',',$trader_emarket_skiil_points_settings[0]->skill_points);
		  //echo "<pre>"; print_r($approveuser); exit;
		   if(!empty($approveuser)){
			   foreach ($approveuser as $user) {
				$point=0;
				
						if($user->join_as==1){
							 $point=$point_exp[1];
							
							
						}else if($user->join_as==2){
							$point=$point_exp[2];
							
						}
						
						if ($get_discussion->user_ID == $user->user_ID) {
							
							 $point=$point+$point_exp[0];

						}
						
						$point=$user->total_skill_points+$point;
						
						$data1 = array("total_skill_points"=>$point,"updatedDate"=>date("Y-m-d H:i:s"));
						$upbid = $this->MainModel->updaterecord('trader_user','user_ID',$user->user_ID,$data1);
				   $notidata = array(
						   'post_discu_ID'=>$did,
						   'fromuser_ID'=>$this->session->userdata('userid'),
						   'touser_ID'=>$user->user_ID,
						   'type'=>'10',
						   "createdDate"=>date("Y-m-d H:i:s")
					   );
				    $completenoti = $this->MainModel->insertrow('trader_notifications',$notidata);
				    //if($completenoti){
 
						$usersubject = ucwords($get_discussion->discussion_title)." Discussion has been Completed";
						
						$maildata['mailed_data'] = array(
						                    "username"=>$user->virtual_name,
						                    //'bid'     => $bid->bid,
						                    'discussion'  => $get_discussion->discussion_title,
						                    'discussion_id'=> $get_discussion->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
							$complete_mail = $this->load->view("templates/complete_discussion",$maildata,true);
 
							if($user->notification_email != ''){
								$notiemail = $user->notification_email;
							}
							else{
								$notiemail = $user->email;
							}
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

			                    $this->email->from(admin_email(),'Trader Network');
						        $this->email->to($notiemail);
						        $this->email->subject($usersubject);
						        $this->email->message($complete_mail);
						        $this->email->set_mailtype("html");
						        $this->email->send();
				    //}

			   }
			   	//-----as owner add skill-point
			   	if(empty($get_owner_bidid)){

				   	$get_owner_point = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$get_discussion->user_ID));
		   			$pointowner=$get_owner_point->total_skill_points+$point_exp[1];
					$data2 = array("total_skill_points"=>$pointowner,"updatedDate"=>date("Y-m-d H:i:s"));
					$upbid2 = $this->MainModel->updaterecord('trader_user','user_ID',$this->session->userdata('userid'),$data2);


					/*owner complete mail if not a self presenter*/
					$usersubject_ownr = 'Your '.ucwords($get_discussion->discussion_title)." Discussion has been Completed";
						
						$maildata['mailed_data'] = array(
						                    "username"=>$get_owner_point->virtual_name,
						                    //'bid'     => $bid->bid,
						                    'discussion'  => $get_discussion->discussion_title,
						                    'discussion_id'=> $get_discussion->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
							$complete_mail_ownr = $this->load->view("templates/complete_owner_discussion",$maildata,true);

					//echo $complete_mail_ownr; exit;
 
							if($get_owner_point->notification_email != ''){
								$notiemail_ownr = $get_owner_point->notification_email;
							}
							else{
								$notiemail_ownr = $get_owner_point->email;
							}
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

			                    $this->email->from(admin_email(),'Trader Network');
						        $this->email->to($notiemail_ownr);
						        $this->email->subject($usersubject_ownr);
						        $this->email->message($complete_mail_ownr);
						        $this->email->set_mailtype("html");
						        $this->email->send();

				}

		   } 
		   $notidataadmin = array(
			'post_discu_ID'=>$did,
			'fromuser_ID'=>$this->session->userdata('userid'),
			'touser_ID'=>1,
			'type'=>'10',
			"createdDate"=>date("Y-m-d H:i:s")
		);
	$this->MainModel->insertrow('trader_notifications',$notidataadmin);
		    $this->session->set_flashdata('success','Discussion completed successfully.');
			redirect(base_url().'view-discussion/'.$did);
	   }
	}
}

public function approve_bid($bid,$uid){
	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	if($bid != '' && $uid != '' ){ 

		$data = array(
					"pre_accept"=>'',
					"approve_status"=>'1',
					"updatedDate"=>date("Y-m-d H:i:s")
				);
		$upbid = $this->MainModel->updaterecord('trader_bid','bid_ID',$bid,$data);

		if($upbid){

			$user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
			$bid = $this->MainModel->get_singlerecord('trader_bid',array('bid_ID'=>$bid));
			$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$bid->dscussion_ID));

			//send notification 
			$notidata = array(
					'post_discu_ID'=>$disc->discussion_ID,
					'fromuser_ID'=>$this->session->userdata('userid'),
					'touser_ID'=>$uid,
					'type'=>'3',
					"createdDate"=>date("Y-m-d H:i:s")
				);
			$noti = $this->MainModel->insertrow('trader_notifications',$notidata);

			//send email notification 
			$usersubject = "Congratulation Your Bid has been approved";
						$maildata['mailed_data'] = array(
						                    "username"=>$user->virtual_name,
						                    'bid'     => $bid->bid,
						                    'discussion'  => $disc->discussion_title,
						                    'discussion_id'  => $disc->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
				$newuser = $this->load->view("templates/approve_bid",$maildata,true);
				//print_r($maildata['mailed_data']);
				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($newuser);
			        $this->email->set_mailtype("html");
			        $this->email->send();
		$this->session->set_flashdata('success','Bid approved successfully.');
			redirect(base_url().'view-discussion/'.$bid->dscussion_ID);
		}
   	}
}
public function decrease_bid($bid,$uid){
	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	if($bid != '' && $uid != '' ){ 
		//echo $uid; exit;
 
			$user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
			$bid = $this->MainModel->get_singlerecord('trader_bid',array('bid_ID'=>$bid));
			$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$bid->dscussion_ID));

			//send notification 
			$notidata = array(
					'post_discu_ID'=>$disc->discussion_ID,
					'fromuser_ID'=>$this->session->userdata('userid'),
					'touser_ID'=>$uid,
					'type'=>'4',
					"createdDate"=>date("Y-m-d H:i:s")
				);
			$noti = $this->MainModel->insertrow('trader_notifications',$notidata);

			//send email notification 
			$usersubject = "Decrease Your Bid";
			$maildata['mailed_data'] = array(
			                    "username"=>$user->virtual_name,
			                    'bid'     => $bid->bid,
			                    'discussion'  => $disc->discussion_title,
			                    'discussion_id'  => $disc->discussion_ID,
			                    'logo'    => base_url().'assets/images/trader-logo.png'
			                );
				$bidsubject = $this->load->view("templates/descreased_bid",$maildata,true);

				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($bidsubject);
			        $this->email->set_mailtype("html");
			        $this->email->send();
			        
		$this->session->set_flashdata('success','Message sent successfully.');
		redirect(base_url().'view-discussion/'.$bid->dscussion_ID);
 
   	}
}
public function increase_bid($bid,$uid){
	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	if($bid != '' && $uid != '' ){ 
 
			$user2 = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$uid));
			$bid = $this->MainModel->get_singlerecord('trader_bid',array('bid_ID'=>$bid));
			$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$bid->dscussion_ID));

				//send notification 
				$notidata = array(
						'post_discu_ID'=>$disc->discussion_ID,
						'fromuser_ID'=>$this->session->userdata('userid'),
						'touser_ID'=>$uid,
						'type'=>'5',
						"createdDate"=>date("Y-m-d H:i:s")
					);
				$noti = $this->MainModel->insertrow('trader_notifications',$notidata);

				//send email notification 
			 	$usersubject2 = "Increase Your Bid";
						$maildata['mailed_data'] = array(
						                    "username"=>$user2->virtual_name,
						                    'bid'     => $bid->bid,
						                    'discussion'  => $disc->discussion_title,
						                    'discussion_id'  => $disc->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
				$bidsubject = $this->load->view("templates/increased_bid",$maildata,true);
				if($user2->notification_email != ''){
					$notiemail = $user2->notification_email;
				}
				else{
					$notiemail = $user2->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject2);
			        $this->email->message($bidsubject);
			        $this->email->set_mailtype("html");
			        $this->email->send();
		$this->session->set_flashdata('success','Message sent successfully.');
		redirect(base_url().'view-discussion/'.$bid->dscussion_ID);
 
   	}
}
public function bid($did){
	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	
	$this->form_validation->set_rules('bidamount', 'Amount', 'required');
	if($this->form_validation->run() === FALSE){
		redirect(base_url().'discussion-details/'.$did);
	}
	else
	{
		$desc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));  
		$rebiduser = $this->MainModel->get_singlerecord('trader_bid',array('dscussion_ID'=>$did,'user_ID'=>$this->session->userdata('userid'))); 
		 
		if(!empty($rebiduser)){
		 	
		 	if($this->input->post('bidtype') == '1'){
		 		$bidamount = ($desc->final_price / 100) * $this->input->post('bidamount');
		 	}
		 	else{
		 		$bidamount = $this->input->post('bidamount');
		 	}
		 	$data = array(
					"bid"=>$this->input->post('bidamount'),
					"payable_amount"=>$bidamount,
					"updatedDate"=>date("Y-m-d H:i:s")
				);	
		 	
		 	$upcond = array('user_ID'=>$this->session->userdata('userid'),'dscussion_ID'=>$did);
			
			$upbid = $this->MainModel->updaterecords('trader_bid',$upcond,$data);
			
			if($upbid){
				//rebid email notification
				$user2 = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
				$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
				$dis_user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$disc->user_ID));

				$bidsub = ucwords($user2->virtual_name)." has Rebid on ".ucwords($disc->discussion_title)." Discussion";
						$maildata['mailed_data'] = array(
						                    'username'=>$user2->virtual_name,
						                    'disc_username'=>$dis_user->virtual_name,
						                    'bid'     => $this->input->post('bidamount'),
						                    'joinas'   => $this->input->post('joinas'),
						                    'discussion'  => $disc->discussion_title,
						                    'discussion_id'  => $disc->discussion_ID,
						                    'base_price'  => $disc->base_price,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
				$bidsubject = $this->load->view("templates/rebid",$maildata,true);
				//print_r($bidsubject); exit;
				if($dis_user->notification_email != ''){
					$notiemail = $dis_user->notification_email;
				}
				else{
					$notiemail = $dis_user->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($bidsub);
			        $this->email->message($bidsubject);
			        $this->email->set_mailtype("html");
			        $this->email->send();
 
				//rebid notification
				$notidata = array(
						'post_discu_ID'=>$did,
						'fromuser_ID'=>$this->session->userdata('userid'),
						'touser_ID'=>$desc->user_ID,
						'type'=>'6',
						"createdDate"=>date("Y-m-d H:i:s")
					);
				$noti = $this->MainModel->insertrow('trader_notifications',$notidata);

			 	if($this->input->post('bidtype') == '1'){
					$this->session->set_flashdata('bidsuccess','Your rebid as attendee has been added successfully.');
				}else{
					$this->session->set_flashdata('bidsuccess','Your rebid as presenter has been added successfully.');
				}
			}
		}
		else{

			if($this->input->post('bidtype') == '1'){ 
		 		$bidamount = ($desc->final_price / 100) * $this->input->post('bidamount');
		 	}
		 	else{  
		 		$bidamount = $this->input->post('bidamount');
		 	}
  			$data = array(
        			"dscussion_ID"=>$did,
					"user_ID"=>$this->session->userdata('userid'),
					"join_as"=>$this->input->post('joinas'),
					"bid_type"=>$this->input->post('bidtype'),
					"bid"=>$this->input->post('bidamount'),
					"payable_amount"=>$bidamount,
					"approve_status"=>'2',
					"createdDate"=>date("Y-m-d H:i:s"),
					"updatedDate"=>date("Y-m-d H:i:s"),
					"isActive"=>'1', 
					"isDelete"=>'0'
				);	
			$insertbid = $this->MainModel->insertrow('trader_bid',$data);
			
			if($insertbid){

				//bid email notification
				$user2 = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
				$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
				$dis_user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$disc->user_ID));

				$bidsub = ucwords($user2->virtual_name)." has Bid on ".ucwords($disc->discussion_title)." Discussion";
						$maildata['mailed_data'] = array(
						                    'username'=>$user2->virtual_name,
						                    'disc_username'=>$dis_user->virtual_name,
						                    'bid'     => $this->input->post('bidamount'),
						                    'joinas'   => $this->input->post('joinas'),
						                    'discussion'  => $disc->discussion_title,
						                    'discussion_id'  => $disc->discussion_ID,
						                    'base_price'  => $disc->base_price,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
				$bidsubject = $this->load->view("templates/bid",$maildata,true);
				//print_r($bidsubject); exit;
				if($dis_user->notification_email != ''){
					$notiemail = $dis_user->notification_email;
				}
				else{
					$notiemail = $dis_user->email;
				}
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

                    $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($bidsub);
			        $this->email->message($bidsubject);
			        $this->email->set_mailtype("html");
			        $this->email->send();

			    //bid notification    
				$notidata = array(
						'post_discu_ID'=>$did,
						'fromuser_ID'=>$this->session->userdata('userid'),
						'touser_ID'=>$desc->user_ID,
						'type'=>'2',
						"createdDate"=>date("Y-m-d H:i:s")
					);
				
				$noti = $this->MainModel->insertrow('trader_notifications',$notidata);
				if($this->input->post('bidtype') == '1'){
					$this->session->set_flashdata('bidsuccess','Your bid as attendee has been added successfully.');
				}else{
					$this->session->set_flashdata('bidsuccess','Your bid as presenter has been added successfully.');
				}
			}
		}
		redirect(base_url().'discussion-details/'.$did);
	}

}
public function pre_accept($did){ 
  
	//if($_POST['presenter'] !=  $_POST['requirement']){
		
		$did = $_POST['did'];

		$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
		$prcount = $this->MainModel->getcount('trader_bid',array('dscussion_ID'=>$did,'approve_status'=>'1','pre_accept'=>'1','join_as'=>'2'));
		

		if($prcount != $disc->require_presenter){

		$upcond = array('user_ID'=>$this->session->userdata('userid'),'dscussion_ID'=>$did);
		
		$data = array(
				"pre_accept"=>'1',
				"updatedDate"=>date("Y-m-d H:i:s")
			);	
		$up = $this->MainModel->updaterecords('trader_bid',$upcond,$data);
		if($up){
			
			$datacond = array(
				"user_ID"=>$this->session->userdata('userid'),
				"dscussion_ID"=>$did
			);
			
			$user2 = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$disc->user_ID));
			$bidprice = $this->MainModel->get_singlerecord('trader_bid',$datacond);
			$preuser = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
			$finalprice=$disc->final_price+$bidprice->bid;
			$data1 = array(
				"final_price"=>$finalprice,
				"updatedDate"=>date("Y-m-d H:i:s")
			);	
			$upcond1 = array('discussion_ID'=>$did);
			$up2 = $this->MainModel->updaterecords('trader_discussion',$upcond1,$data1);
		
			$notidata = array(
							'post_discu_ID'=>$disc->discussion_ID,
							'fromuser_ID'=>$this->session->userdata('userid'),
							'touser_ID'=>$user2->user_ID,
							'type'=>'7',
							"createdDate"=>date("Y-m-d H:i:s")
						);
			$noti =	$this->MainModel->insertrow('trader_notifications',$notidata);

			$usersubject = "Congratulations ".ucwords($preuser->virtual_name)." has Accept the Request for ".$disc->discussion_title." Discussion";

			$maildata['mailed_data'] = array(
			                    "username"=>$user2->virtual_name,
			                    "pre_name"=>$preuser->virtual_name,
			                    'discussion'=>$disc->discussion_title,
			                    'discussion_id'=>$disc->discussion_ID,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$subject = $this->load->view("templates/pre_accept",$maildata,true);
				if($user2->notification_email != ''){
					$notiemail = $user2->notification_email;
				}
				else{
					$notiemail = $user2->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($subject);
			        $this->email->set_mailtype("html");
			        $this->email->send();
			$this->session->set_flashdata('bidsuccess','Discussion accepted successfully.');

		$response='yes';
		}
	}
	else{
		$response='no';
	}
	$url = base_url().'discussion-details/'.$did;
	echo json_encode(array('res'=>$response,'url'=>$url));
}
public function pre_decline($did){ 
	if($this->session->userdata('userid') == ""){
	    redirect(base_url('login'));
	}
	if($did != ''){
		$upcond = array('user_ID'=>$this->session->userdata('userid'),'dscussion_ID'=>$did);
		
		$data = array(
				"pre_accept"=>'2',
				"approve_status"=>'2',
				"updatedDate"=>date("Y-m-d H:i:s")
			);	
		$up = $this->MainModel->updaterecords('trader_bid',$upcond,$data);
		if($up){

			/*$datacond = array(
				"user_ID"=>$this->session->userdata('userid'),
				"dscussion_ID"=>$did
			);*/
			//$bidprice = $this->MainModel->get_singlerecord('trader_bid',$datacond);

			$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
			$user2 = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$disc->user_ID));
			$preuser = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
			//$finalprice=$disc->final_price-$bidprice->bid;

			/*$data1 = array(
				"final_price"=>$finalprice,
				"updatedDate"=>date("Y-m-d H:i:s")
			);	
			$upcond1 = array('discussion_ID'=>$did);
			$up2 = $this->MainModel->updaterecords('trader_discussion',$upcond1,$data1); */

			$notidata = array(
							'post_discu_ID'=>$disc->discussion_ID,
							'fromuser_ID'=>$this->session->userdata('userid'),
							'touser_ID'=>$user2->user_ID,
							'type'=>'8',
							"createdDate"=>date("Y-m-d H:i:s")
						);
			$noti =	$this->MainModel->insertrow('trader_notifications',$notidata);
			$usersubject = ucwords($preuser->virtual_name)." has Declined the Request for ".$disc->discussion_title." Discussion";

			$maildata['mailed_data'] = array(
			                    "username"=>$user2->virtual_name,
			                    "pre_name"=>$preuser->virtual_name,
			                    'discussion'=>$disc->discussion_title,
			                    'discussion_id'=>$disc->discussion_ID,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$subject = $this->load->view("templates/pre_decline",$maildata,true);
				if($user2->notification_email != ''){
					$notiemail = $user2->notification_email;
				}
				else{
					$notiemail = $user2->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($subject);
			        $this->email->set_mailtype("html");
			        $this->email->send();
			$this->session->set_flashdata('bidsuccess','Discussion declined successfully.');
			redirect(base_url().'discussion-details/'.$did);
		}
	}
}
public function feedback_submit(){  
	if(!$this->session->userdata('userid')) {
		redirect(base_url());
	}
  	  	$prearr = $this->input->post('presenter');
  	  	foreach ( $prearr as $pre) {
  	  		$rating = 'rating_'.$pre;
  	  		$feedback = 'feedback_'.$pre;
  	  		if($this->input->post($feedback_) != ''){
			//echo "<br/>".$this->input->post($feedback);
  	  				$data = array(
						"discussion_ID"=>$this->input->post('discid'),
						"presenter"=>$pre,
						"attendee"=>$this->session->userdata('userid'),
						"rating"=>$this->input->post($rating),
						"feedback"=>$this->input->post($feedback),
						"createdDate"=>date("Y-m-d H:i:s"),
					);	
					$in = $this->MainModel->insertdata('trader_feedback',$data);
  	  		}
  	  	}
  	  	$this->session->set_flashdata('bidsuccess','Feedback send successfully.');
		redirect(base_url().'discussion-details/'.$this->input->post('discid'));
  	   
}

 
public function popop($did){
	$this->load->view("front/common/header",$header);
	$this->load->view('front/popop');
	$this->load->view("front/common/footer");
}



public function getcustomerstripeID($cardno){
	
	$custid = $this->MainModel->get_singlerecord('trader_user_card_details',array('card_ID'=>$cardno));
	
	return $custid->stripe_customer_id;
}
public function paymentforbid($did){

	if(!$this->session->userdata('userid')) {
		redirect(base_url());
	}
 $customerID = $this->getcustomerstripeID($this->input->post('cardno'));

if($this->input->post('payment_type') == 1){
			//print_r($_POST); exit;
			$useramount = $this->MainModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));
			
			$payableamount=$this->input->post('amount')*$useramount->em_point;
			$userwalletbalcurrent = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));

			if($this->input->post('emarket_point') >= $payableamount){
				$userwalletbal=($userwalletbalcurrent->market_point)-($payableamount);


				//---update trader bitd data
				$databid = array('payment_status'=>'1');
				$condbid = array('dscussion_ID'=>$did,'user_ID'=>$this->session->userdata('userid'));
			    
				$updatebid = $this->MainModel->updaterecords('trader_bid',$condbid,$databid);
				
				//---------update user wallet balance------------
				$dataval = array('market_point'=>$userwalletbal);
				$condval = array('user_ID'=>$this->session->userdata('userid'));
			    
				$updateuserwallet = $this->MainModel->updaterecords('trader_user',$condval,$dataval);
				//------------------end---------------------------
				$data = array(
					'user_ID'=>$this->session->userdata('userid'),
					'transaction_number'=>$charge->id,
					'disussion_ID'=>$did,
					'debit_credit'=>1,
					'amount'=>$this->input->post("amount"),
					'description'=>'Payment as Attendee for bid',
					"createdDate" => date("Y-m-d H:i:s"),
					"updatedDate" => date("Y-m-d H:i:s")
			   );
	   			$inserts = $this->MainModel->insertdata('trader_transaction',$data); 
			
			}else{
				$this->session->set_flashdata('paymentfail','Not enough balance in your wallet.');
				redirect(base_url().'discussion-details/'.$did);
			}


		}else{

			if($this->input->post('card_count') == ''){
				$this->session->set_flashdata('paymentfail','Please add billing method.');
				redirect(base_url().'discussion-details/'.$did);
			}
 		\Stripe\Stripe::setApiKey("sk_test_b3lLzyTbVwjJyaBLOe3s0rRS");
		
		 $cents =  (int) ( ( (string) ( $this->input->post('amount') * 100 ) ) );

		 
		try {
			$charge = \Stripe\Charge::create(array(
				"amount" => $cents, 
				"currency" => "usd",
				"customer" => $customerID)
			 );
			$success = 1;

			//echo $charge->id; exit;
			
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
			$this->session->set_flashdata('paymentfail',$error1);
			redirect(base_url().'discussion-details/'.$did);
		}

		if($charge->id!=''){
			$databid = array('payment_status'=>'1');
			$condbid = array('dscussion_ID'=>$did,'user_ID'=>$this->session->userdata('userid'));
			
			$updatebid = $this->MainModel->updaterecords('trader_bid',$condbid,$databid);
			for($d=2;0<$d;--$d){
				if($d==2){
					$discussion_id=0;	
				}else{
					$discussion_id=$did;
				}
			$data = array(
				'user_ID'=>$this->session->userdata('userid'),
				'transaction_number'=>$charge->id,
				'disussion_ID'=>$discussion_id,
				'debit_credit'=>$d,
				'amount'=>$this->input->post("amount"),
				'description'=>'Payment as Attendee for bid',
				"createdDate" => date("Y-m-d H:i:s"),
				"updatedDate" => date("Y-m-d H:i:s")
		   );
		   $insert = $this->MainModel->insertdata('trader_transaction',$data); 
			}
  
		}
	}
	
	 
		
	$this->session->set_flashdata('bidsuccess','Your payment is completed.');

	redirect(base_url().'discussion-details/'.$did);
	
}

//-----payment for owner--------------------
public function paymentforowner_discussion($did){
	if(!$this->session->userdata('userid')) { redirect(base_url()); }

$did=$this->input->post("discussion_ID");

 $customerID = $this->getcustomerstripeID($this->input->post('cardno'));
 		 if($this->input->post('payment_type') == 1){
			
			$useramount = $this->MainModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));
			
			$payableamount=$this->input->post('amount')*$useramount->em_point;
			$userwalletbalcurrent = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$this->session->userdata('userid')));
 
			if($this->input->post('emarket_point') >= $payableamount){
				$userwalletbal=($userwalletbalcurrent->market_point)-($payableamount);


				//---update trader bid data
				$databid = array('payment_status'=>'1');
				$condbid = array('dscussion_ID'=>$did,'user_ID'=>$this->session->userdata('userid'));
			    
				$updatebid = $this->MainModel->updaterecords('trader_bid',$condbid,$databid);
				//---------update user wallet balance------------
				$dataval = array('market_point'=>$userwalletbal);
				$condval = array('user_ID'=>$this->session->userdata('userid'));
			    
				$updateuserwallet = $this->MainModel->updaterecords('trader_user',$condval,$dataval);
				//------------------------------------------------
				$data = array(
					'user_ID'=>$this->session->userdata('userid'),
					'transaction_number'=>$charge->id,
					'disussion_ID'=>$did,
					'debit_credit'=>1,
					'amount'=>$this->input->post("amount"),
					'description'=>'Payment as Owner for discussion',
					"createdDate" => date("Y-m-d H:i:s"),
					"updatedDate" => date("Y-m-d H:i:s")
			   );
	   			$inserts = $this->MainModel->insertdata('trader_transaction',$data); 
			
			}else{
				
				$this->session->set_flashdata('paymentfail','Not enough balance in your wallet.');
				redirect(base_url().'view-discussion/'.$did);
			}


		}else{
			
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
		$this->session->set_flashdata('paymentfail',$error1);
		redirect(base_url().'view-discussion/'.$did);
		}

		if($charge->id!=''){
			$databid = array('payment_status'=>'1');
			$condbid = array('dscussion_ID'=>$did,'user_ID'=>$this->session->userdata('userid'));
			
			$updatebid = $this->MainModel->updaterecords('trader_bid',$condbid,$databid);
			for($d=2;0<$d;--$d){
				if($d==2){
					$discussion_id=0;	
				}else{
					$discussion_id=$did;
				}
			$data = array(
				'user_ID'=>$this->session->userdata('userid'),
				'transaction_number'=>$charge->id,
				'disussion_ID'=>$discussion_id,
				'debit_credit'=>$d,
				'amount'=>$this->input->post("amount"),
				'description'=>'Payment as Attendee for bid',
				"createdDate" => date("Y-m-d H:i:s"),
				"updatedDate" => date("Y-m-d H:i:s")
		   );
		   $insert = $this->MainModel->insertdata('trader_transaction',$data); 
			}
  
		}
	}

	$this->session->set_flashdata('paymentsuccess','Your payment is successed.');

redirect(base_url().'view-discussion/'.$did);
	
}

public function feedback_mail(){

	$selectforcompleted="SELECT td.*,tu.*,datediff(CURDATE(),td.discussion_start_datetime) as datediff,(td.require_presenter+td.require_attendee) as candidate,(select count(bid) from trader_bid where   approve_status = '1' AND dscussion_ID=td.discussion_ID)as bidcount FROM trader_discussion as td LEFT JOIN trader_user as tu on td.user_ID = tu.user_ID WHERE td.status='1' AND td.discussion_start_datetime < CURDATE() HAVING datediff<=3 AND bidcount=candidate";
  // $select1="SELECT td.*,tu.*,datediff(CURDATE(),td.discussion_start_datetime) as datediff FROM trader_discussion as td LEFT JOIN trader_user as tu on td.user_ID = tu.user_ID WHERE td.status != '4' AND td.status != '3' AND td.discussion_start_datetime < CURDATE() HAVING datediff<=3";


  $select2="SELECT td.*,tu.*,tb.user_ID as biduser,datediff(CURDATE(),td.discussion_start_datetime) as datediff FROM trader_discussion as td RIGHT JOIN trader_bid as tb on td.discussion_ID = tb.dscussion_ID LEFT JOIN trader_user as tu on tb.user_ID = tu.user_ID  WHERE tb.join_as = '1' AND tb.payment_status = '1' AND tb.approve_status = '1' AND td.status = '3'  AND td.status != '4'  AND td.discussion_start_datetime < CURDATE()";
	 $alldsc = $this->MainModel->runselect($select1);
 	$allusers = $this->MainModel->runselect($select2) ;


//all discussion owner mail for complete discussion
foreach ($alldsc as $user) {
	
	
		$notidata = array(
					'post_discu_ID'=>$user->discussion_ID,
					'fromuser_ID'=>'1',
					'touser_ID'=>$user->user_ID,
					'type'=> '13',
					//'feedback_noti'=>'2',
					"createdDate"=>date('Y-m-d H:i:s')
				);
				$this->MainModel->insertrow('trader_notifications',$notidata);	

			$usersubject = "Please Complete Your Discussion";

			$maildata['mailed_data'] = array(
			                    "username"=>$user->virtual_name,
			                    "discussion_id"=>$user->discussion_ID,
			                    'discussion'=>$user->discussion_title,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$ownercomplete = $this->load->view("templates/owner_complete",$maildata,true);

				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($ownercomplete);
			        $this->email->set_mailtype("html");
			        $this->email->send();
	
}
 
//all attendees mail for give feedback
foreach ($allusers as $user) {

	if($user->datediff <= 3){
		
		$notidata = array(
					'post_discu_ID'=>$user->discussion_ID,
					'fromuser_ID'=>'1',
					'touser_ID'=>$user->user_ID,
					'type'=> '12',
					//'feedback_noti'=>'2',
					"createdDate"=>date('Y-m-d H:i:s')
				);
		$this->MainModel->insertrow('trader_notifications',$notidata);	

		$usersubject = "Please Give Your Feedback";

			$maildata['mailed_data'] = array(
			                    'username'=>$user->virtual_name,
			                    'discussion_id'=>$user->discussion_ID,
			                    'discussion'=>$user->discussion_title,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$attfeedback = $this->load->view("templates/give_feedback",$maildata,true);

				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($attfeedback);
			        $this->email->set_mailtype("html");
			        $this->email->send();	 
	}
}

 
}

public function discussion_statuschkcron(){
//--completed discussion id
 		$opendiscussiontocomplete="SELECT td.*,tu.*,tt.disussion_ID,tt.user_ID,tt.transaction_ID,datediff(CURDATE(),td.discussion_start_datetime) as datediff,(td.require_presenter+td.require_attendee) as candidate,(select count(bid) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=1 and payment_status=1)as bidattendee ,(select sum(payable_amount) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=1 and payment_status=1)as attendeepayamount ,(select count(bid) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=2 and pre_accept=1)as bidpresent FROM trader_discussion as td LEFT JOIN trader_user as tu on td.user_ID = tu.user_ID LEFT JOIN trader_transaction as tt on tt.user_ID = td.user_ID and tt.disussion_ID=td.discussion_ID WHERE td.status='1' AND td.discussion_start_datetime < CURDATE() HAVING datediff<=3  and candidate=(bidattendee+bidpresent)";

	$selectforcompletedattendee="SELECT td.*,tb.*,tu.virtual_name,tu.notification_email,tu.email,tb.user_ID AS tbuser,datediff(CURDATE(),td.updatedDate) as datediff,(select count(DISTINCT attendee) from trader_feedback WHERE attendee=tb.user_ID and discussion_ID=td.discussion_ID) as feedbackresult  FROM trader_discussion as td RIGHT JOIN trader_bid as tb on td.discussion_ID = tb.dscussion_ID and tb.approve_status=1 and tb.join_as=1 and tb.payment_status=1 LEFT JOIN trader_user as tu on tb.user_ID = tu.user_ID   WHERE td.status='3' AND td.updatedDate < CURDATE() HAVING datediff<=3";

//--automatic complete discussion after 3 days

	$opendiscussiontocompletedauto="SELECT td.*,tu.*,tt.disussion_ID,tt.user_ID,tt.transaction_ID,datediff(CURDATE(),td.discussion_start_datetime) as datediff,(td.require_presenter+td.require_attendee) as candidate,(select count(bid) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=1 and payment_status=1)as bidattendee ,(select sum(payable_amount) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=1 and payment_status=1)as attendeepayamount ,(select count(bid) from trader_bid where approve_status = '1' AND dscussion_ID=td.discussion_ID and join_as=2 and pre_accept=1)as bidpresent FROM trader_discussion as td LEFT JOIN trader_user as tu on td.user_ID = tu.user_ID LEFT JOIN trader_transaction as tt on tt.user_ID = td.user_ID and tt.disussion_ID=td.discussion_ID WHERE td.status='1' AND td.discussion_start_datetime < CURDATE() HAVING datediff >=4 and candidate=(bidattendee+bidpresent)";
	
//------------completed discussion
  $allcompleteddiscussion = $this->MainModel->runselect($opendiscussiontocomplete);
 //-----discussion completed automatic query---
  $autocompleteddiscussion = $this->MainModel->runselect($opendiscussiontocompletedauto);	
 //------for completed attendee
 $allcoompletedattendee = $this->MainModel->runselect($selectforcompletedattendee);	
//send notification for complete discussion
 if($allcompleteddiscussion){
foreach ($allcompleteddiscussion as $user) {
	if( ($user->transaction_ID=='' && $user->attendeepayamount==$user->final_price) || ($user->transaction_ID!='')){

		$notidata = array(
					'post_discu_ID'=>$user->discussion_ID,
					'fromuser_ID'=>'1',
					'touser_ID'=>$user->user_ID,
					'type'=> '13',
					//'feedback_noti'=>'2',
					"createdDate"=>date('Y-m-d H:i:s')
				);
				$this->MainModel->insertrow('trader_notifications',$notidata);	

			$usersubject = "Please Complete Your Discussion";

			$maildata['mailed_data'] = array(
			                    "username"=>$user->virtual_name,
			                    "discussion_id"=>$user->discussion_ID,
			                    'discussion'=>$user->discussion_title,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$ownercomplete = $this->load->view("templates/owner_complete",$maildata,true);

				if($user->notification_email != ''){
					$notiemail = $user->notification_email;
				}
				else{
					$notiemail = $user->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($ownercomplete);
			        $this->email->set_mailtype("html");
			        $this->email->send();
		}
	
	}
 }
//-----complete discussion automatic-----------
if($autocompleteddiscussion){
	foreach ($autocompleteddiscussion as $autodiscussion) {
		if( ($user->transaction_ID=='' && $user->attendeepayamount==$user->final_price) || ($user->transaction_ID!='')){

		$this->discussion_complete($autodiscussion->discussion_ID);
		}
	}
}
//all attendees mail for give feedback
if($allcoompletedattendee){
foreach ($allcoompletedattendee as $attendee) {

if($attendee->feedbackresult==0){
		
		$notidata = array(
					'post_discu_ID'=>$attendee->discussion_ID,
					'fromuser_ID'=>'1',
					'touser_ID'=>$attendee->tbuser,
					'type'=> '12',
					//'feedback_noti'=>'2',
					"createdDate"=>date('Y-m-d H:i:s')
				);
		$this->MainModel->insertrow('trader_notifications',$notidata);	

		$usersubject = "Please Give Your Feedback";

			$maildata['mailed_data'] = array(
			                    'username'=>$attendee->virtual_name,
			                    'discussion_id'=>$attendee->discussion_ID,
			                    'discussion'=>$attendee->discussion_title,
			                    'logo' => base_url().'assets/images/trader-logo.png'
			                );
				$attfeedback = $this->load->view("templates/give_feedback",$maildata,true);

				if($user->notification_email != ''){
					$notiemail = $attendee->notification_email;
				}
				else{
					$notiemail = $attendee->email;
				}
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

	                $this->email->from(admin_email(),'Trader Network');
			        $this->email->to($notiemail);
			        $this->email->subject($usersubject);
			        $this->email->message($attfeedback);
			        $this->email->set_mailtype("html");
			        $this->email->send();

				}	 
		
			}
		}
 
	}

public function attendee_count_check()
{
	if($_POST['did'] != ''){

	$did = $_POST['did'];
	$disc = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));
	$atcount = $this->MainModel->getcount('trader_bid',array('dscussion_ID'=>$did,'approve_status'=>'1','payment_status'=>'1','join_as'=>'1'));

		//echo $disc->require_attendee.'    '.$atcount; exit;

		if($disc->require_attendee != $atcount){
			$response='yes';
		}
		else{
			$response='no';
		}

		echo json_encode(array('res'=>$response));
	}
 
}
public function cvv_check()
{
	  
	$cid = $_POST['cardid'];
	$name = 'cvvtxt'.$cid;
	
	if($_POST[$name] != '' && $_POST['cvv'] !='' ){

 		if($_POST[$name] == $_POST['cvv']){
 			echo 'true';
 		}
 		else{
 			echo 'false';
 		}
	}
 
}

}
