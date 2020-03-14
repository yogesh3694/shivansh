<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_master extends CI_Controller {

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
		$page['page_name'] = 'Trader Network:Category';

		$data['categories'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name ");

		$data['catoption'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, c.name as cat from trader_category c WHERE c.isDelete = '0' order by c.name  ");

			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/category/category_main',$data);
			$this->load->view('admin/common/footer');
	}

	public function categorylist_ajax(){
	error_reporting(!E_NOTICE);

		$selquerycount =$this->AdminModel->runselect("SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name");

 		 $selquery ="SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name  LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'];

        $disdata1 = $this->AdminModel->runselect($selquery);

        
      
         	$i=$_REQUEST['start'];
            foreach($disdata1 as $cat){ $i++;

            		if($cat->subcat_id == '' ){ 
                                            $statusid = $cat->cat_id; 
                                        }
                                        else{
                                            $statusid = ''; 
                                        }
                                        if($cat->status == '' && $cat->cstatus == '1'){
                                            $ctstaus ="<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' data-id='".$cat->subcat_id."'>Active</a><input type='hidden' class='cathidden' name='cathidden' value=".$statusid.">"; 
                                        }
                                        else if ($cat->status == '' && $cat->cstatus == '0') {
                                            $ctstaus = "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' data-id='".$cat->subcat_id."'>Deactive</a><input type='hidden' class='cathidden' name='cathidden' value=".$statusid.">";
                                        }
                                        else if($cat->status == '1'){ 
                                            $ctstaus = "<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' data-id='".$cat->subcat_id."'>Active</a><input type='hidden' class='cathidden' name='cathidden' value=".$statusid.">"; 
                                        }
                                        else{
                                            $ctstaus = "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' data-id='".$cat->subcat_id."'>Deactive</a><input type='hidden' class='cathidden' name='cathidden' value=".$statusid.">";
                                        }
	            $action = '<a href="'.base_url().'admin/Category_Master/edit_category/'.$cat->cat_id.'/'.$cat->subcat_id.'" title="Edit"><i class="icon icon-19"></i></a><a href="'.base_url().'admin/Category_Master/delete_category/'.$cat->cat_id.'/'.$cat->subcat_id.'" onclick="return confirm(\'Are you sure you want to delete this category?\')" title="Remove"><i class="icon icon-18"></i></a>';


	            $data[] = array( $i,
	            				 character_limiter($cat->cat,130),
	            				 $cat->subcat !='' ? $cat->subcat : '-',
	            				 $ctstaus ,
	            				 $action); 
	            				  
            }

            if(empty($data)){$data = 0;}
        $dataCount = count($selquerycount);

			
			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

		echo json_encode($json_data);

         
	}
	//---new category ajax
	public function categorylist_ajaxnew(){
	error_reporting(!E_NOTICE);

		$conds = array(
		"1"=>'1'
		);
		$category = $this->MainModel->fetchallrow('trader_category',$conds);


		// $selquerycount =$this->AdminModel->runselect("SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name");


 	// 	 $selquery ="SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name  LIMIT ".$_REQUEST['start'].', '.$_REQUEST['length'];

  //       $disdata1 = $this->AdminModel->runselect($selquery);

        
      		$subarray=array();
         	$i=$_REQUEST['start'];
            foreach($category as $cats){ $i++;

            		
                                            $statusid = $cats->cat_id; 
                                        if($cats->isActive == '1'){
                                            $ctstaus ="<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' data-id='".$cats->category_ID."'>Active</a><input type='hidden' class='cathidden' name='cathidden' value=".$cats->category_ID.">"; 
                                        }
                                        else if ($cats->isActive == '0') {
                                            $ctstaus = "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' data-id='".$cats->category_ID."'>Deactive</a><input type='hidden' class='cathidden' name='cathidden' value=".$cats->category_ID.">";
                                        }

	            $action = '<a href="'.base_url().'admin/Category_Master/edit_category/'.$cats->category_ID.'" title="Edit"><i class="icon icon-19"></i></a><a href="'.base_url().'admin/Category_Master/delete_category/'.$cats->category_ID.'" onclick="return confirm(\'Are you sure you want to delete this category?\')" title="Remove"><i class="icon icon-18"></i></a>';


	            $data[] = array( $i,
	            				 character_limiter($cats->name,130),
	            				 '-',
	            				 $ctstaus ,
	            				 $action); 

	            $conds1 = array(
            	"category_ID"=>$cats->category_ID);
		$subcategory = $this->MainModel->fetchallrow('trader_sub_category',$conds1);
		array_push($subarray, count($subcategory));
	            	  foreach($subcategory as $cat){ $i++;

            		if($cat->subcat_id == '' ){ 
                                            $statusid = $cat->cat_id; 
                                        }
                                        else{
                                            $statusid = ''; 
                                        }
                                        if($cat->isActive == '1'){
                                            $ctstaus ="<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' subdata-id='".$cat->sub_category_ID."'  maindata-id='".$cat->category_ID."'>Active</a><input type='hidden' class='cathidden' name='cathidden' value=".$cat->sub_category_ID." >"; 
                                        }
                                        else if ($cat->isActive == '0') {
                                            $ctstaus = "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' subdata-id='".$cat->sub_category_ID."' maindata-id='".$cat->category_ID."'>Deactive</a><input type='hidden' class='cathidden' name='cathidden' value=".$cat->sub_category_ID.">";
                                        }

	            $action = '<a href="'.base_url().'admin/Category_Master/edit_category/'.$cats->category_ID.'/'.$cat->sub_category_ID.'" title="Edit"><i class="icon icon-19"></i></a><a href="'.base_url().'admin/Category_Master/delete_category/'.$cats->category_ID.'/'.$cat->sub_category_ID.'" onclick="return confirm(\'Are you sure you want to delete this category?\')" title="Remove"><i class="icon icon-18"></i></a>';


	            $data[] = array( $i,
	            				 character_limiter($cats->name,130),
	            				 $cat->name !='' ? $cat->name : '-',
	            				 $ctstaus ,
	            				 $action); 

	            				 }			  
            }

            if(empty($data)){$data = 0;}
            $count1=count($category);
             $count2=array_sum($subarray);
        $dataCount = $count1+$count2;

			
			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );

            

		echo json_encode($json_data);

         
	}
	public function add_category()
	{   //print_r($_POST); exit;
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}

		$page['page_name'] = 'Trader Network:Add Categories';

   		$this->form_validation->set_rules('category', 'Please Enter Category', 'required');
   		//$this->form_validation->set_rules('subcategory', 'Please Enter Sub Category', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data['categories'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name ");
			$data['catoption'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, c.name as cat from trader_category c WHERE c.isDelete = '0' order by c.name  ");
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/category/category_main',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{
			$cat = $this->AdminModel->get_singlerecord('trader_category',array('category_ID'=>$this->input->post('category') ));
			if(!empty($cat)){
				if($this->input->post('subcategory') != ''){
					$data = array(
						'category_ID' => $this->input->post('category'),
						'name' => $this->input->post('subcategory'),
						'createdDate'=> date("Y-m-d H:i:s"),
						'updatedDate'=> date("Y-m-d H:i:s"),
						'isActive'=> '1',
						'isDelete'=> '0'
					);
					$up = $this->AdminModel->insertdata("trader_sub_category",$data);
					$this->session->set_flashdata('success','Category Successfully Added..');
					redirect(base_url('admin/category'));
				}
				else{
					redirect(base_url('admin/category'));	
				}
			}
			else{
				$data = array(
					'name' => $this->input->post('category'),
					'createdDate'=> date("Y-m-d H:i:s"),
					'updatedDate'=> date("Y-m-d H:i:s"),
					'isActive'=> '1',
					'isDelete'=> '0'
				);
				$lastcatid = $this->AdminModel->insertdata("trader_category",$data);

				if($this->input->post('subcategory') !='' && $lastcatid != ''){

					$subdata = array(
						'category_ID' => $lastcatid,
						'name' => $this->input->post('subcategory'),
						'createdDate'=> date("Y-m-d H:i:s"),
						'updatedDate'=> date("Y-m-d H:i:s"),
						'isActive'=> '1',
						'isDelete'=> '0'
					);
					$insert = $this->AdminModel->insertdata("trader_sub_category",$subdata);
				
				} 
				$this->session->set_flashdata('success','Category Successfully Added..');
				redirect(base_url('admin/category'));
			}
 
		}
	}
	public function edit_category($cat = "",$subcat = "")
	{ 
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$page['page_name'] = 'Trader Network:Edit Category';

   		$this->form_validation->set_rules('category', 'Please Enter Category', 'required');
		if ($this->form_validation->run() == FALSE) { 

			$data['categories'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, s.sub_category_ID as subcat_id, c.name as cat,s.name as subcat , c.isActive as cstatus ,s.isActive as status  from trader_category c LEFT JOIN trader_sub_category as s ON c.category_ID = s.category_ID WHERE c.isDelete = '0' order by c.name");
			$data['catoption'] = $this->AdminModel->runselect("SELECT c.category_ID as cat_id, c.name as cat from trader_category c WHERE c.isDelete = '0' order by c.name  ");

			$data['catrow'] = $this->AdminModel->get_singlerecord('trader_category',array('category_ID'=>$cat));
			$data['subcatrow'] = $this->AdminModel->get_singlerecord('trader_sub_category',array('sub_category_ID'=>$subcat));
 
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/category/edit_category',$data);
			$this->load->view('admin/common/footer');
		}
		else
		{
			$catrw = $this->AdminModel->get_singlerecord('trader_category',array('category_ID'=>$this->input->post('category') ));

			if(!empty($catrw)){ 

				if($this->input->post('subcategory') != ''){   

						$data = array(
							'category_ID' => $this->input->post('category'),
							'name' => $this->input->post('subcategory'),
							'updatedDate'=> date("Y-m-d H:i:s"),
						);
						$this->AdminModel->updatedata("trader_sub_category",'sub_category_ID',$subcat,$data);

						$this->session->set_flashdata('success','Category Successfully Updated.');
						redirect(base_url('admin/category'));
				}
				else{ 

					redirect(base_url('admin/category'));	
						// $this->AdminModel->removedata("trader_sub_category",'sub_category_ID',$subcat);
						// $this->session->set_flashdata('success','Category Successfully Deleted..');
						// redirect(base_url('admin/category'));
				}
			}
			else{  

				$data = array(
					'name' => $this->input->post('category'),
					'updatedDate'=> date("Y-m-d H:i:s"),
				);
				$this->AdminModel->updatedata("trader_category",'category_ID',$cat,$data);

				if($this->input->post('subcategory') != '' ){

					if($subcat == ''){

							$indata2 = array(
								'category_ID' => $cat,
								'name' => $this->input->post('subcategory'),
								'createdDate'=> date("Y-m-d H:i:s"),
								'updatedDate'=> date("Y-m-d H:i:s"),
								'isActive'=> '1',
								'isDelete'=> '0'
						);
						$this->AdminModel->insertdata("trader_sub_category", $indata2);	
					}
					else{	
						$subdata = array(
							'name' => $this->input->post('subcategory'),
							'updatedDate'=> date("Y-m-d H:i:s"),
						);
						$this->AdminModel->updatedata("trader_sub_category",'sub_category_ID',$subcat,$subdata);
					}
				
				}   
				 
				$this->session->set_flashdata('success','Category Successfully Updated.');
				redirect(base_url('admin/category'));
			} 
		}
	}
	public function delete_category($cat = "",$subcat = "")
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}

			if($cat != '' && $subcat != ''){  
				$this->AdminModel->removedata('trader_sub_category',"sub_category_ID",$subcat);
				$this->session->set_flashdata('success','Category Successfullly Deleted..');	
				redirect(base_url('admin/category'));
			}
			else{
				$this->AdminModel->removedata('trader_category',"category_ID",$cat);
				$this->session->set_flashdata('success','Category Successfullly Deleted..');	
				redirect(base_url('admin/category'));	
			}
	}
	public function statusajax()
	{  
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		} 
		//$category=explode('/', string)
		//catid
		if($this->input->post('subcatid')!=''){

			$scid = $this->input->post('subcatid');
			$subcat = $this->AdminModel->get_singlerecord('trader_sub_category',array('sub_category_ID'=>$scid));

			if($subcat->isActive == '1'){
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
				$up = $this->AdminModel->updatedata('trader_sub_category','sub_category_ID',$scid ,$data);			
				if($up){
					echo json_encode(array('status'=>$status,'subcat'=>1));
				}
		}
		else{
			$cid = $this->input->post('catid');
			$subcat = $this->AdminModel->get_singlerecord('trader_category',array('category_ID'=>$cid));

			if($subcat->isActive == '1'){
				$data = array(
						'updatedDate' => date("Y-m-d H:i:s"),
						'isActive'=> '0',
				);
				$status = 'catdeactived';
				$up1 = $this->AdminModel->updatedata('trader_sub_category','category_ID',$cid ,$data);	
			}
			else{
				$data = array(
						'updatedDate' => date("Y-m-d H:i:s"),
						'isActive'=> '1',
				);
				$status = 'catactived';
			}
				$up = $this->AdminModel->updatedata('trader_category','category_ID',$cid ,$data);	

				if($up){
					echo json_encode(array('catstatus'=>$status,'subcat'=>0));
				}

		}

	}
}
