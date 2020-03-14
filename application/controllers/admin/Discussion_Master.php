<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Discussion_master extends CI_Controller {

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
		$page['page_name'] = "Trader Network:Discussion";

		$data['disdata'] = 	$this->AdminModel->runselect('SELECT d.*,c.name as category FROM trader_discussion as d LEFT JOIN trader_category as c ON d.category_ID = c.category_ID WHERE d.isDelete = "0" order by d.discussion_ID DESC ');
 
			$this->load->view('admin/common/nav',$page);
			$this->load->view('admin/common/header');
			$this->load->view('admin/discussion/discussion_main',$data);
			$this->load->view('admin/common/footer');
	} 
	public function disc_ajax(){  

	error_reporting(!E_NOTICE);
        $disdata = 	$this->AdminModel->runselect('SELECT d.*,c.name as category FROM trader_discussion as d LEFT JOIN trader_category as c ON d.category_ID = c.category_ID WHERE d.isDelete = "0" order by d.discussion_ID DESC ');
		
		if($_REQUEST['order'][0]['dir']!=''){
			$order='order by d.discussion_start_datetime '.$_REQUEST['order'][0]['dir'];
		}else{
			$order='order by d.discussion_ID DESC';
		}

 		$selquery = 'SELECT d.*,c.name as category FROM trader_discussion as d LEFT JOIN trader_category as c ON d.category_ID = c.category_ID WHERE d.isDelete = "0"   '.$order.' LIMIT '.$_REQUEST['start'].', '.$_REQUEST['length'];

        $disdata1 = 	$this->AdminModel->runselect($selquery);

        $sLimit = "";
      
         	$i=$_REQUEST['start'];
            foreach($disdata1 as $discus){ $i++;

	            if($discus->status == '1'){
	            	if($discus->status == '1' && $discus->discussion_start_datetime < date("Y-m-d H:i:s")){
	                	$sta = "<a href='javascript:void(0)' class='badge badge-close-inverted catstatus' id=".$discus->discussion_ID.">close</a><input type='hidden' name='custatus".$discus->discussion_ID."' id='custatus_".$discus->discussion_ID."' value='2'>";
	            	}
	            	else{
	                $sta = "<a href='javascript:void(0)' class='badge badge-success-inverted catstatus' id=".$discus->discussion_ID.">Open</a><input type='hidden' name='custatus".$discus->discussion_ID."' id='custatus_".$discus->discussion_ID."' value='1'>"; 
	            	}
	            }else if($discus->status == '2'){
	                $sta = "<a href='javascript:void(0)' class='badge badge-close-inverted catstatus' id=".$discus->discussion_ID.">close</a><input type='hidden' name='custatus".$discus->discussion_ID."' id='custatus_".$discus->discussion_ID."' value='2'>";
	            }else if($discus->status == '3'){
	                $sta = "<a href='javascript:void(0)' class='badge badge-complete-inverted catstatus' id=".$discus->discussion_ID.">Completed</a><input type='hidden' name='custatus".$discus->discussion_ID."' id='custatus_".$discus->discussion_ID."' value='3'>"; 
	            }else{
	                $sta = "<a href='javascript:void(0)' class='badge badge-danger-inverted catstatus' id=".$discus->discussion_ID.">cancelled</a><input type='hidden' name='custatus".$discus->discussion_ID."' id='custatus_".$discus->discussion_ID."' value='4'>"; 
	            }

	            $sta.="<input type='hidden' name='discussion_ID".$discus->discussion_ID."' id='discu_".$discus->discussion_ID."' value=".$discus->discussion_ID.">";
	            $action = '<a href="'.base_url().'admin/view-discussion/'.$discus->discussion_ID.'" title="View" ><i class="icon icon-20"></i></a>
                    <a href="'.base_url().'admin/Discussion_Master/delete_discussion/'.$discus->discussion_ID.'" title="Remove" onclick="return confirm(\'Are you sure you want to delete this discussion?\')"><i class="icon icon-18"></i></a>';



	            $data[] = array( $i,
	            				 character_limiter($discus->discussion_title,30),
	            				 '$'.$discus->base_price,
	            				 character_limiter($discus->category,15),
	            				 date('d F, Y h:i A',strtotime($discus->discussion_start_datetime)),
	            				 $sta,
	            				 $action); 
	            				  
            }
            if(empty($data)){ $data = 0; }

        $dataCount = count($disdata);

			
			$json_data = array(
                "draw"            => intval( $_REQUEST['draw']),
                "recordsTotal"    => intval( $dataCount ),
                "recordsFiltered" => intval( $dataCount ),
                "data"            => $data
            );
echo json_encode($json_data);

         
	}

 
	public function delete_discussion($id)
	{
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}
		$data['isDelete'] = "1";
		$del = $this->AdminModel->deleterecord('trader_discussion',array("discussion_ID"=>$id),$data);
		if($del){
			$this->session->set_flashdata('success','Discussion Successfully Deleted..');	
			redirect(base_url('admin/Discussion_Master'));
		}
	}
	public function view_discussion_admin($did)
	{   
		if($this->session->userdata['logged_in']['adminid'] == ""){
			redirect(base_url('admin'));
		}

	$page['page_name'] = "Trader Network : View Discussion";	

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

	$createcon = array('user_ID' =>$commndata['main']->user_ID);
	$data['created'] = $this->MainModel->getcount("trader_discussion",$createcon);

	$createprecon = array('user_ID' =>$commndata['main']->user_ID,'join_as'=>'2','approve_status'=>'1','pre_accept'=>'1');
	$data['created_pre'] = $this->MainModel->getcount("trader_bid",$createprecon);

	$createattcon = array('user_ID' =>$commndata['main']->user_ID,'join_as'=>'1','approve_status'=>'1','payment_status'=>'1');
	$data['created_att'] = $this->MainModel->getcount("trader_bid",$createattcon);

	$data['skills'] = $commndata['skill']; 

	if($this->input->post('review')!= ''){
		$data['scroll'] = 'yes';		
	}

		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/discussion/view_disc',$data);
		$this->load->view('admin/common/footer');
 
	}
	public function view_discussion_common($did){ //common discussion function

	$data['main'] =  $this->MainModel->runselectrow('SELECT td.*,tu.*,CONCAT(tc.name,", ",tct.name) as location,c.name as category, sc.name as subcategory, age.age_range as agerange,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" AND isActive="1" AND isDelete="0" AND pre_accept="1" )as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee from trader_discussion as td 
		LEFT JOIN trader_category as c ON td.category_ID = c.category_ID 
		LEFT JOIN trader_user as tu ON td.user_ID = tu.user_ID
		LEFT JOIN trader_countries as tc ON tu.country = tc.country_ID
		LEFT JOIN trader_cities as tct ON tu.city = tct.city_ID
		LEFT JOIN trader_sub_category as sc ON td.sub_category = sc.sub_category_ID
		LEFT JOIN trader_age_group as age on td.age_group = age.age_ID
		WHERE discussion_ID = "'.$did.'"
	');
 
	$inskill = str_replace('|','","',$data['main']->skill_required_discussion);

	$data['skill'] = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');

		return $data;
}
	public function discussion_paynow($did)
	{
		$page['page_name'] = "Trader Network : Pay Now";	

		$commndata = $this->view_discussion_common($did);
		$data['descdata'] = $commndata['main'];

		$presenter=$this->MainModel->runselectrow("SELECT GROUP_CONCAT(user_ID) as userid FROM trader_bid where dscussion_ID=".$did." AND join_as=2 AND approve_status = '1' AND pre_accept = '1'");
	 	
	 	if($presenter->userid != ''){
	  	 	$preseselects="SELECT tu.user_ID,tu.virtual_name,tu.profile_photo,tt.user_ID as ttuser,tt.amount,CONCAT(tc.name,', ',tct.name) as location FROM trader_user as tu 
					LEFT JOIN trader_countries as tc ON tu.country = tc.country_ID
					LEFT JOIN trader_cities as tct ON tu.city = tct.city_ID
					LEFT JOIN trader_transaction as tt ON tt.disussion_ID= '".$did."' and tt.debit_credit  =2 and  tt.user_ID=tu.user_ID	where tu.user_ID IN(".$presenter->userid.")";
				 
			$data['pre_payment'] = $this->MainModel->runselect($preseselects);	

	 	$data['presenterpaidamount']=$this->MainModel->runselect("select sum(amount) as amount from trader_transaction where disussion_ID=".$did." AND user_ID in(".$presenter->userid.")");
	 	}

		$this->load->view('admin/common/nav',$page);
		$this->load->view('admin/common/header');
		$this->load->view('admin/discussion/view_pay_now',$data);
		$this->load->view('admin/common/footer');
	 
	}
  
	public function view_defaultdiscussion(){  
	//echo "asas"; exit;

    $did = $this->input->post('discussion');
    $descdata =  $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));

    if(!empty($descdata)){
	   $inskill = str_replace('|','","',$descdata->skill_required_discussion);
	   $skills = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');
 	
    $showlimit = 1;
    $select = "SELECT tb.join_as,tb.pre_accept,tb.payment_status,des.requirment_detail as description, des.require_presenter as req_pre, des.require_attendee as req_att,des.base_price as price, (select count(dscussion_ID) from trader_bid where dscussion_ID = des.discussion_ID and approve_status='1' and pre_accept='1' and join_as='2' AND isActive='1' AND isDelete='0')as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = des.discussion_ID and approve_status='1' and payment_status='1' and join_as='1' AND isActive='1' AND isDelete='0')as attendee,tb.bid_ID,(select count(bid_ID) from trader_bid as ctbp where ctbp.dscussion_ID = $did and ctbp.join_as = '2') as totalpre,(select count(bid_ID) from trader_bid as ctbp where ctbp.dscussion_ID = $did and ctbp.join_as = '1') as totalatt, tb.user_ID as biduserid,tb.bid as bidprice,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID ) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID "; 

    //feedback code start
    $preids = $this->MainModel->runselect("select tb.user_ID from trader_bid as tb WHERE tb.dscussion_ID = '".$did."' and tb.join_as = '2' AND tb.approve_status = '1' AND tb.pre_accept = '1'");
	$pr_ids = array();
	foreach ($preids as $pr) {
		 array_push($pr_ids, $pr->user_ID);
	}
	$pr_id_implod = implode(",",$pr_ids);
 	
 	if($pr_id_implod != ''){

		$prefeedback = $this->MainModel->runselect("SELECT tf.*,tu.virtual_name,tu.profile_photo FROM trader_feedback as tf LEFT JOIN trader_user as tu on tf.presenter = tu.user_ID where tf.presenter IN($pr_id_implod) AND discussion_ID = '".$did."' GROUP by tf.presenter");
 	}
    //end feedback
 
    $aspresenter = $this->MainModel->runselect("$select WHERE tb.join_as = '2' AND tb.dscussion_ID = '".$did."' ORDER BY tb.bid_ID DESC limit $showlimit "); 
    //print_r($aspresenter);    
    $asattendee = $this->MainModel->runselect("$select WHERE  tb.join_as = '1' AND tb.dscussion_ID = '".$did."' ORDER BY tb.bid_ID DESC limit $showlimit "); 

    $payment = $this->MainModel->runselect("SELECT tb.join_as,tb.dscussion_ID as discid, (select count(dscussion_ID) from trader_bid as tbb where IF(tbb.join_as = '2', tbb.pre_accept = '1', tbb.payment_status = '1')  AND tbb.approve_status = '1' AND tbb.dscussion_ID = $did) as countpayment,tb.bid as bidprice,tb.updatedDate as biddate,tb.pre_accept,tb.payment_status,des.requirment_detail as description, des.require_presenter as req_pre, des.require_attendee as req_att,des.base_price as price,tb.bid_ID,tb.approve_status as status,tu.user_ID as userid,tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE IF(tb.join_as = '2', tb.pre_accept = '1', tb.payment_status = '1') AND tb.approve_status = '1' AND tb.dscussion_ID = ".$did." ORDER BY tb.bid_ID DESC limit $showlimit"); 
 
    $totalpre = (!empty($aspresenter) ?$aspresenter[0]->totalpre:'0'); 
    $totalatt = (!empty($asattendee)?$asattendee[0]->totalatt:'0');
    $totalpreRow = $totalpre;
    $totalattRow = (!empty($asattendee)?$asattendee[0]->totalatt:'0');

    $totalpayment = (!empty($payment)?$payment[0]->countpayment:'0');
 
 
?>
    <section class="trader-listing-detail-tabs create-attendee-complete-tabs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion-tabs "> 
                    <ul class="accordion-tab-headings">
                        <li><a href="#section-1">Bid as a Presenter <?php echo ($totalpre != '0'?'('.$totalpre.')':''); ?></a>
                        </li>
                        <li><a href="#section-2">Bid as a Attendee <?php echo ($totalatt != '0'?'('.$totalatt.')':''); ?></a>
                        </li>
                        <?php  
                        if($this->session->userdata['logged_in']['adminid'] == '1'){ ?>
                                <li><a href="#section-3">Discussion Details</a></li>
                                <li><a href="#section-4">Review</a></li>
                                <li><a href="#section-5">Payment Details</a></li>
                        <?php } ?>
                    </ul>
                    <div class="accordion-tab-content">
                    <div id="section-1">
                        <h1 class="accordion-tab-title">Bid as a Presenter <?php echo ($totalpre != '0'?'('.$totalpre.')':''); ?></h1>  
                        <div class="accordion-tab-contentinner pre_loadmoreappend">
                        <?php
                        $i=0; $j=0;
                        if($aspresenter){
                        foreach ($aspresenter as $aspre) { $i++;
                            if($aspre->status == '1'){
                             $prcls = ''; 
                            }
                            else{
                                if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){
                                    $prcls = 'approve_hover_cls'; 
                                }else{ 
                                    $prcls = '';                                     
                                }
                            }
                        ?>
                            <div class="trader-listing-detail-tabs-box <?php echo $prcls; ?>">
                                <div class="Presenter-detail">
                                    <div class="Presenter-detail-inner-detail">
                                        <div class="presenter-img">
                                            <?php if($aspre->profile!=''){
                                            	$image_path_pr = base_url('upload/profile/' . $aspre->profile);
				                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-96x96.', $image_path_pr);

				                                ini_set('allow_url_fopen', true);

				                                if (getimagesize($thumb_path_pr)) {
				                                    $image_path2 = $thumb_path_pr;
				                                }
                                             ?>
                                            <img src="<?php echo $image_path2; ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="presenter-address">
                                            <h3><?php echo $aspre->name; ?></h3>
                                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                                            <ul>
                                                <li><i class="icon icon-30" aria-hidden="true"></i> Skill Points : <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$aspre->skillpoints);
                                                $markerpoint = money_format('%!.0n',$aspre->markerpoints);
                                                echo ($skillpoint !='' ? $skillpoint : ''); ?></li>
                                                <li><i class="icon icon-31" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li><?php if($aspre->location != ''){
                                                    ?>
                                                        <i class="icon icon-26" aria-hidden="true"></i> <?php echo $aspre->location;  
                                                    } ?>
                                                </li>
                                            </ul>
                                            <div class="Presenter-count">
	                                            <span><?php echo '$'.$aspre->bidprice; ?></span>
	                                            <div class="Presenter-date"><i class="icon icon-27" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php  
                                if($aspre->skillpoints <= 1000 ){
                                    echo '<div class="yellow-icon commen-icon-cls"></div>';
                                }
                                elseif ($aspre->skillpoints <= 10000) {
                                    echo '<div class="green-icon commen-icon-cls"></div>';
                                }
                                elseif ($aspre->skillpoints <= 100000) {
                                    echo '<div class="blue-icon commen-icon-cls"></div>';
                                }
                                else{
                                    echo '<div class="red-icon commen-icon-cls"></div>';
                                }
                                ?>
                                <?php //echo ($aspre->status == '1' ? '<div class="approve-line"><h3>Approved</div></h3>' : '');
                                    if($aspre->status == '1'){
                                        if($aspre->join_as == '2' ){
                                                echo ($aspre->pre_accept == '1' ?'<div class="approve-line"><h3>Approved</div></h3>':'');
                                        }
                                        else
                                        {
                                            echo '<div class="approve-line"><h3>Approved</div></h3>';
                                        }
                                    }
                                 ?> 
                            </div>
                        <?php
                        	$bidid = $aspre->bid_ID;
                    	}
                    }
                    else{
                        echo "<div class='notfound'>Bid Not Found.</div>";
                    } ?>
                    </div>
                       <?php if($totalpreRow > $showlimit){ ?>
                        <div class="load-more-btn new-load-morepre">
                            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_pre">load more</a>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                        </div>
                        <?php } ?>
                    </div>
                    <!-- </div> -->
                    <div id="section-2">
                        <h1 class="accordion-tab-title"> Bid as a Attendee <?php echo ($totalatt != '0'?'('.$totalatt.')':''); ?> </h1> 
                        <div class="accordion-tab-contentinner att_loadmoreappend"> 
                        <?php
                        if($asattendee){
                         foreach ($asattendee as $asatt) { $j++;
                            if($asatt->status == '1'){
                                $atcls = ''; 
                            }
                            else{
                                if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){
                                    $atcls = 'approve_hover_cls'; 
                                }else{ 
                                    $atcls = '';                                     
                                }
                            }
                            ?>
                            <div class="trader-listing-detail-tabs-box <?php echo $atcls; ?>">
                                <div class="Presenter-detail">
                                    <div class="Presenter-detail-inner-detail">
                                        <div class="presenter-img">
                                            <?php if($asatt->profile!=''){

                                            	$image_path_pr = base_url('upload/profile/' . $asatt->profile);
				                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-96x96.', $image_path_pr);

				                                ini_set('allow_url_fopen', true);

				                                if (getimagesize($thumb_path_pr)) {
				                                    $image_path3 = $thumb_path_pr;
				                                }
                                             ?>
                                            <img src="<?php echo $image_path3 ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="presenter-address">
                                            <h3><?php echo $asatt->name; ?></h3>
                                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                                            <ul>
                                                <li><i class="icon icon-30" aria-hidden="true"></i> Skill Points: <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$asatt->skillpoints);
                                                $markerpoint = money_format('%!.0n',$asatt->markerpoints);
                                                echo ($skillpoint !='' ?$skillpoint :''); ?></li>
                                                <li><i class="icon icon-31" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li>
                                                    <?php if($asatt->location != ''){ ?>
                                                    <i class="icon icon-26" aria-hidden="true"></i> <?php echo $asatt->location; 
                                                } ?>
                                                </li>
                                            </ul>
                                            <div class="Presenter-count">
	                                            <span><?php echo $asatt->bidprice.'%'; ?></span>
	                                            <div class="Presenter-date"><i class="icon icon-27" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($asatt->biddate)); ?></div>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                                
                               <?php 
                                if($asatt->skillpoints <= 1000 ){
                                    echo '<div class="yellow-icon commen-icon-cls"></div>';
                                }
                                elseif ($asatt->skillpoints <= 10000) {
                                    echo '<div class="green-icon commen-icon-cls"></div>';
                                }
                                elseif ($asatt->skillpoints <= 100000) {
                                    echo '<div class="blue-icon commen-icon-cls"></div>';
                                }
                                else{
                                    echo '<div class="red-icon commen-icon-cls"></div>';
                                }
                                ?>
                                <?php //echo ($asatt->status == '1' ? '<div class="approve-line"><h3>Approved</div></h3>' : ''); 
                                    if($asatt->status == '1'){
                                        if($asatt->join_as == '2' ){
                                                echo ($asatt->pre_accept == '1' ?'<div class="approve-line"><h3>Approved</div></h3>':'');
                                        }
                                        else
                                        {
                                        	echo ($asatt->payment_status == '1' ?'<div class="approve-line"><h3>Approved</div></h3>':'');
                                            //echo '<div class="approve-line"><h3>Approved</div></h3>';
                                        }
                                    }
                                ?> 
                            </div>
                        <?php
                     	   $bidid = $asatt->bid_ID;   
                        }
                    ?>
                    <!-- </div> -->
					<?php
                    }
                    else{
                        echo "<div class='notfound'>Bid Not Found.</div>";  
                    } ?>
                    </div>
                    <?php if($totalattRow > $showlimit){ ?>
                        <div class="load-more-btn new-load-moreatt">
                            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_att">load more</a>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                        </div>
                    <?php }   ?>
                	</div>
                <!-- </div> -->
                <?php if($this->session->userdata['logged_in']['adminid'] == '1'){ ?>
                    <div id="section-3">
                        <h1 class="accordion-tab-title"> Discussion Details</h1>  
                    <?php if($descdata->requirment_detail != ''){ ?>
                        <div class="trader-content-description">
                            <p><?php echo $descdata->requirment_detail; ?></p>
                        </div>
                    <?php } ?>
                       <div class="skill-documents-section">
                            <div class="container">
                                <div class="row">
                            <?php if(!empty($skills)){ 
                                    if($descdata->attachement == ''){ $colcls = 'col-sm-12'; }else{ $colcls = 'col-sm-6'; }
                            ?>
                                    <div class="<?php echo $colcls; ?>">
                                        <h2>Skill Required</h2>
                                        <ul class="skill-require">
                                        <?php foreach ($skills as $skill) {
                                                echo "<li>".$skill->name."</li>";
                                            } ?>
                                        </ul>
                                    </div>
                            <?php } ?>
                                    <?php  
                                    $attachment = explode('|',$descdata->attachement); 
                                    if($descdata->attachement != ''){
                                        if(empty($skills)){ $colcls2 = 'col-sm-12'; }else{ $colcls2 = 'col-sm-6'; }
                                    ?>
                                    <div class="<?php echo $colcls2; ?>">
                                        <h2>Documents</h2>
                                        <ul class="document-section">
                                            <?php 
                                            foreach ($attachment as $att) {
                                             $ext = substr(strrchr($att,'.'),1);
                                             if($ext == 'jpeg' || $ext =='jpg' || $ext =='png'|| $ext == 'svg'){
                                               $extimg = '<img src="'.base_url().'assets/images/doc-img2.png">'; 
                                             }
                                             else if ($ext =='pdf') {
                                                $extimg = '<img src="'.base_url().'assets/images/doc-img3.png">';    
                                             }
                                             else if ($ext =='docx' || $ext =='doc' || $ext =='docb' || $ext =='dotx' || $ext == 'dotm' || $ext == 'odt' ) {
                                                $extimg = '<img src="'.base_url().'assets/images/doc-img1.png">';    
                                             }
                                             else if ($ext =='xlsx' || $ext =='xlsm' || $ext =='xltx' || $ext =='xltm' ) {
                                                $extimg = '<img src="'.base_url().'assets/images/doc-img4.png">';    
                                             }
                                             if($att != ''){
                                            ?>
                                                <li>    
                                                <?php echo $extimg; ?>            
                                                <a target="_blank" href="<?php echo base_url() ?>upload/discussion/<?php echo $att; ?>"><?php echo $att; ?></a>      
                                                </li>
                                            <?php }
                                            }
                                             ?>
                                           
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <?php } ?>
                    <div id="section-4">
                        <div class="review_accordion">
                        	<div class="table-responsive accordion_content">
                        		<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                        		<?php 	
                    			//echo  "<pre>"; print_r($prefeedback); exit;
                    			if(!empty($prefeedback)){
                    			$a=0;
								foreach ($prefeedback as $prefeed ) {
									?>
									<div class="card">
									    <!-- Card header -->
									    <div class="card-header accordion" role="tab" id="headingTwo1">
									      <a class="" href="javascript:void(0)">
									      	<div class="tab_review_content">
										      	<div class="presenter-img">
										      		<?php if($prefeed->profile_photo != ''){
										      				$image_path_pr = base_url('upload/profile/' . $prefeed->profile_photo);
							                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-76x76.', $image_path_pr);

							                                ini_set('allow_url_fopen', true);

							                                if (getimagesize($thumb_path_pr)) {
							                                    $image_path_fd = $thumb_path_pr;
							                                }
										      			?>
										      				<img src="<?php echo $image_path_fd; ?>" />
										      			<?php
										      		}
										      		else{
										      			?>
										      				<img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg" />
										      			<?php
										      		} ?>
										      	</div>
										      	<div class="presenter-address">
	 									        	<h5 class="mb-0"><?php echo $prefeed->virtual_name; ?> (Presenter)</h5>
	 									        	<?php
	 									        	$pr_avg = $this->MainModel->runselectrow("SELECT ROUND(AVG(tf.rating)) as average from trader_feedback as tf where tf.presenter = '".$prefeed->presenter."' AND tf.discussion_ID = '".$did."' ");
	 									        	$pr_avg = $pr_avg->average;
	 									        	?>
	 									        	<div class="rating_star">
	 									        		<start class="rating-score">
															<i class="icon icon-32 <?php echo ($pr_avg >= '1' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '2' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '3' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '4' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '5' ?'active':'') ?>" aria-hidden="true"></i>
														</start>
	 									        	</div>
										      	</div>
										    </div>
									      </a>
									    </div>
									    <div class="accordion_inner" style="display: none;">
									      <div class="card-body">
									<?php  
									$attfeed = $this->MainModel->runselect("SELECT tf.*,tu.virtual_name,tu.profile_photo FROM trader_feedback as tf LEFT JOIN trader_user as tu on tf.attendee = tu.user_ID where tf.presenter = '".$prefeed->presenter."' AND discussion_ID = '".$did."'");

										foreach ($attfeed as $attfd) { $a++; 
									 	?> 
									    <!-- Card body -->
									        <div class="body_review_content">
									        	<div class="review_img">
									        		
									        	<?php if($attfd->profile_photo != ''){

									        			$image_path_at = base_url('upload/profile/' . $attfd->profile_photo);
							                                $thumb_path_at = preg_replace('~\.(?!.*\.)~', '-76x76.', $image_path_at);

							                                ini_set('allow_url_fopen', true);

							                                if (getimagesize($thumb_path_at)) {
							                                    $image_path_fd2 = $thumb_path_at;
							                                }
									        			?>
									        			<img src="<?php echo $image_path_fd2; ?>" />
									        			<?php
									        		}
									        		else{
									        			?>
									        			<img src="<?php echo base_url() ?>assets/images/none-user-47x39.jpg" />
									        			<?php
									        		}
									        		?>
									        	</div>
									        	<div class="review_title_time">
									        		<h4><?php echo $attfd->virtual_name; ?></h4>
									        		<span><!-- 29 Nov 2018 --><?php echo date('d M Y',strtotime($attfd->createdDate)); ?></span>
									        		<div class="rating_star">
	 									        		<start class="rating-score">
															<i class="icon icon-32 <?php if($attfd->rating >= '1'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '2'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '3'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '4'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '5'){ echo "active"; } ?>" aria-hidden="true"></i>
														</start>
	 									        	</div>
									        	</div>
									        	<div class="review_text">
									        		<p><?php echo $attfd->feedback; ?></p>
									        	</div>
									        </div>
								  <?php } ?>
									      </div>
									    </div>
									</div>
						  <?php }
							}
							else{
								?>
								<div class="notfound">Feedback Not Found.</div>
							<?php } ?>
                        		</div>
                        	</div>
                        </div> <!-- close accordian main -->


                    </div><!-- close section-4 -->
                    <div id="section-5">
                        <h1 class="accordion-tab-title">Payment</h1>  
                        <div class="accordion-tab-contentinner pre_loadmoreappend paymenttab">
                        <?php
                        $i=0; $j=0;
                        if($payment){
                        foreach ($payment as $pay) { $i++;
                            
                        ?>
                            <div class="trader-listing-detail-tabs-box <?php echo $prcls; ?>">
                                <div class="Presenter-detail">
                                    <div class="Presenter-detail-inner-detail">
                                        <div class="presenter-img">
                                            <?php if($pay->profile!=''){
                                            	$image_path_pr = base_url('upload/profile/' . $pay->profile);
				                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-96x96.', $image_path_pr);

				                                ini_set('allow_url_fopen', true);

				                                if (getimagesize($thumb_path_pr)) {
				                                    $image_path2 = $thumb_path_pr;
				                                }
                                             ?>
                                            <img src="<?php echo $image_path2; ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="presenter-address">
                                            <h3><?php echo $pay->name; ?></h3> 
                                            <?php 
                                            // if($pay->join_as == '2'){
                                            // 	echo '<h3>Join as Presenter</h3>'; 	
                                            // }
                                            // else{
                                            // 	echo '<h3>Join as Attendee</h3>'; 	
                                            // }
                                            ?>
                                            	<ul>
	                                                <li><i class="user_icon" aria-hidden="true"></i>
		                                                 Join as : <?php 
		                                                 if($pay->join_as == '2'){
		                                            	echo 'Presenter'; 	
			                                            }
			                                            else{
			                                            	echo 'Attendee'; 	
			                                            }?>
		                                        	</li>
	                                        	</ul>
                                            <?php

                                            /* 
                                            <ul>
                                                <li><i class="icon icon-30" aria-hidden="true"></i> Skill Points : <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$pay->skillpoints);
                                                $markerpoint = money_format('%!.0n',$pay->markerpoints);
                                                echo ($skillpoint !='' ? $skillpoint : ''); ?></li>
                                                <li><i class="icon icon-31" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li><?php if($pay->location != ''){
                                                    ?>
                                                        <i class="icon icon-26" aria-hidden="true"></i> <?php echo $pay->location;  
                                                    } ?>
                                                </li>
                                            </ul>
                                            <?php */ 
                                            ?>  
                                            <div class="Presenter-count">
	                                           	<?php
	                                           	if($pay->join_as == '2'){
	                                           		if($pay->pre_accept == '1' && $pay->payment_status == '1'){

	                                           			$cond = array(
																"user_ID"=>$pay->userid,
																"dscussion_ID"=>$pay->discid,
																"debit_credit"=>'2'
															);
														$adminpay = $this->MainModel->get_singlerecord('trader_transaction',$cond);	

	                                           			echo '<span>$'.$adminpay->amount.'</span>';	
	                                           		}
	                                           		else{
	                                           			echo '<span>$'.$pay->bidprice.'</span>';		
	                                           		}
	                                           	}
	                                           	else{
													echo '<span>'.$pay->bidprice.'%</span>';		                                           		
	                                           	}
                                            	?>
	                                            <div class="Presenter-date"><i class="icon icon-27" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($pay->biddate)); ?></div>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php  
                                if($pay->skillpoints <= 1000 ){
                                    echo '<div class="yellow-icon commen-icon-cls"></div>';
                                }
                                elseif ($pay->skillpoints <= 10000) {
                                    echo '<div class="green-icon commen-icon-cls"></div>';
                                }
                                elseif ($pay->skillpoints <= 100000) {
                                    echo '<div class="blue-icon commen-icon-cls"></div>';
                                }
                                else{
                                    echo '<div class="red-icon commen-icon-cls"></div>';
                                }
                                ?>
                                <?php //echo ($pay->status == '1' ? '<div class="approve-line"><h3>Approved</div></h3>' : '');
                                    if($pay->join_as == '1'){
										echo '<div class="approve-line"><h3>Received</h3></div>';
                                    }
                                    else{
                                    	if($pay->pre_accept == '1' && $pay->payment_status == '1'){
                                    		echo '<div class="approve-line"><h3>Paid</h3></div>';
                                    	}
                                    	else{
                                    		//echo '<div class="approve-line"><h3>Unpaid</h3></div>';	
                                    		echo '';	
                                    	}
                                    }
  
                                 ?> 
                            </div>
                        <?php
                        	$bidid = $pay->bid_ID;
                    	}
                    }
                    else{
                        echo "<div class='notfound'>Payment Details Not Found.</div>";
                    } ?>
                    </div>
                       <?php
                        if($totalpayment > $showlimit){ ?>
                        <div class="load-more-btn new-load-morepay">
                            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_pay">load more</a>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                        </div>
                        <?php } ?>
                    </div><!-- close section-5 -->
                </div>
            	</div>
                </div>              
            </div>
        </div>
</section>
<?php
}
}
//----------end default function----------------------------

public function view_payment_ajax(){


	$did = $_POST['discussion'];

	$paymentcount = $this->MainModel->runselect("select * from trader_bid as tb WHERE IF(tb.join_as = '2', tb.pre_accept = '1', tb.payment_status = '1')  AND tb.approve_status = '1' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ");  


	$totalRowCount = count($paymentcount);
	//echo $totalRowCount; exit;
	$showlimit = 1; 

    $payment = $this->MainModel->runselect("SELECT tb.join_as,(select count(dscussion_ID) from trader_bid where IF(tb.join_as = '2', tb.pre_accept = '1', tb.payment_status = '1')  AND tb.approve_status = '1' AND tb.dscussion_ID = $did) as countpayment,tb.bid as bidprice,tb.updatedDate as biddate,tb.dscussion_ID as discid,tb.pre_accept,tb.payment_status,des.requirment_detail as description, des.require_presenter as req_pre, des.require_attendee as req_att,des.base_price as price,tb.bid_ID,tb.approve_status as status,tu.user_ID as userid,tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE IF(tb.join_as = '2', tb.pre_accept = '1', tb.payment_status = '1') AND tb.approve_status = '1' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ORDER BY tb.bid_ID DESC limit $showlimit"); 

	 
      
                        $i=0; $j=0;
                        if($payment){
                        foreach ($payment as $pay) { $i++;
                            
                        ?>
                            <div class="trader-listing-detail-tabs-box">
                                <div class="Presenter-detail">
                                    <div class="Presenter-detail-inner-detail">
                                        <div class="presenter-img">
                                            <?php if($pay->profile!=''){
                                            	$image_path_pr = base_url('upload/profile/' . $pay->profile);
				                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-96x96.', $image_path_pr);

				                                ini_set('allow_url_fopen', true);

				                                if (getimagesize($thumb_path_pr)) {
				                                    $image_path2 = $thumb_path_pr;
				                                }
                                             ?>
                                            <img src="<?php echo $image_path2; ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="presenter-address">
                                            <h3><?php echo $pay->name; ?></h3> 
                                            <?php 
                                            /*if($pay->join_as == '2'){
                                            	echo '<h3>Join as Presenter</h3>'; 	
                                            }
                                            else{
                                            	echo '<h3>Join as Attendee</h3>'; 	
                                            }*/

                                            ?>
                                            	<ul>
	                                                <li><i class="user_icon" aria-hidden="true"></i>
		                                                 Join as : <?php 
		                                                 if($pay->join_as == '2'){
		                                            	echo 'Presenter'; 	
			                                            }
			                                            else{
			                                            	echo 'Attendee'; 	
			                                            }?>
		                                        	</li>
	                                        	</ul>
	                                            <?php


                                            /* 
                                            <ul>
                                                <li><i class="icon icon-30" aria-hidden="true"></i> Skill Points : <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$pay->skillpoints);
                                                $markerpoint = money_format('%!.0n',$pay->markerpoints);
                                                echo ($skillpoint !='' ? $skillpoint : ''); ?></li>
                                                <li><i class="icon icon-31" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li><?php if($pay->location != ''){
                                                    ?>
                                                        <i class="icon icon-26" aria-hidden="true"></i> <?php echo $pay->location;  
                                                    } ?>
                                                </li>
                                            </ul>
                                            <?php */ 
                                            ?>  
                                            <div class="Presenter-count">
	                                           	<?php //echo $pay->dscussion_ID;
	                                           	if($pay->join_as == '2'){
	                                           		if($pay->pre_accept == '1' && $pay->payment_status == '1'){

	                                           			$cond = array(
																"user_ID"=>$pay->userid,
																"disussion_ID"=>$pay->discid,
																"debit_credit"=>'2'
															);
														$adminpay2 = $this->MainModel->get_singlerecord('trader_transaction',$cond);	

	                                           			echo '<span>$'.$adminpay2->amount.'</span>';	
	                                           		}
	                                           		else{
	                                           			echo '<span>$'.$pay->bidprice.'</span>';		
	                                           		}
	                                           	}
	                                           	else{
													echo '<span>'.$pay->bidprice.'%</span>';		                                           		
	                                           	}
                                            	?>
	                                            <div class="Presenter-date"><i class="icon icon-27" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($pay->biddate)); ?></div>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php  
                                if($pay->skillpoints <= 1000 ){
                                    echo '<div class="yellow-icon commen-icon-cls"></div>';
                                }
                                elseif ($pay->skillpoints <= 10000) {
                                    echo '<div class="green-icon commen-icon-cls"></div>';
                                }
                                elseif ($pay->skillpoints <= 100000) {
                                    echo '<div class="blue-icon commen-icon-cls"></div>';
                                }
                                else{
                                    echo '<div class="red-icon commen-icon-cls"></div>';
                                }
                                ?>
                                <?php //echo ($pay->status == '1' ? '<div class="approve-line"><h3>Approved</div></h3>' : '');
                                    if($pay->join_as == '1'){
										echo '<div class="approve-line"><h3>Received</h3></div>';
                                    }
                                    else{
                                    	if($pay->pre_accept == '1' && $pay->payment_status == '1'){
                                    		echo '<div class="approve-line"><h3>Paid</h3></div>';
                                    	}
                                    	else{
                                    		echo '';	
                                    	}
                                    }
                                 ?> 
                            </div>
                        <?php
                        	$bidid = $pay->bid_ID;
                    	}


		if($totalRowCount > $showlimit){ 
		       ?>
		        <div class="load-more-btn new-load-morepay">
		            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_pay">load more</a>
		            <span class="loading lodingpay" style="display: none;"><span class="loding_txt">Loading...</span></span>
		        </div>
    <?php }   


} }
public function view_discussion(){  
        /*if($this->session->userdata('userid') == '') {
            redirect(base_url('login'));
        }*/

		$descdata =  $this->MainModel->runselectrow('SELECT td.*,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" and pre_accept="1" AND isActive="1" AND isDelete="0")as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" and payment_status="1" AND isActive="1" AND isDelete="0")as attendee from trader_discussion as td WHERE discussion_ID = "'.$this->input->post("discussion").'" ');

		$inskill = str_replace('|','","',$descdata->skill_required_discussion);

		$skills = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');

		$countpre = $this->MainModel->runselect("SELECT tb.bid_ID, tb.user_ID as biduserid,tb.bid,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE tb.join_as = '".$_POST['joinas']."' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ORDER BY tb.bid_ID DESC");

		$totalRowCount = count($countpre);
		$showlimit = 2; 

		$aspresenter = $this->MainModel->runselect("SELECT tb.join_as,tb.pre_accept,tb.payment_status,tb.bid_ID, tb.user_ID as biduserid,tb.bid,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE tb.join_as = '".$_POST['joinas']."' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ORDER BY tb.bid_ID DESC limit $showlimit ");

         $i=0; $j=0;
        foreach ($aspresenter as $aspre) { $i++;

            if($aspre->status == '1'){
                $ajaxcls = ''; 
            }
            else{
                if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){
                    $ajaxcls = 'approve_hover_cls'; 
                }else{ 
                    $ajaxcls = '';                                     
                }
            }
        ?>
            <div class="trader-listing-detail-tabs-box <?php echo $ajaxcls; ?>">
                <div class="Presenter-detail">
                    <div class="Presenter-detail-inner-detail">
                        <div class="presenter-img">
                            <?php if($aspre->profile!=''){
                            	$image_path_pr = base_url('upload/profile/' . $aspre->profile);
	                            $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-96x96.', $image_path_pr);

	                            ini_set('allow_url_fopen', true);

	                            if (getimagesize($thumb_path_pr)) {
	                                $image_path3 = $thumb_path_pr;
	                            }
                             ?>
                            <img src="<?php echo $image_path3; ?>">
                             <?php   
                            }else{
                             ?>
                            <img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg">
                             <?php   
                            } ?>
                        </div>
                        <div class="presenter-address">
                            <h3><?php echo $aspre->name; ?></h3>
                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                            <ul>
                                <li><i class="icon icon-30" aria-hidden="true"></i> Skill Points : <?php 
                                setlocale(LC_MONETARY, 'en_IN');  
                                $skillpoint = money_format('%!.0n',$aspre->skillpoints);
                                $markerpoint = money_format('%!.0n',$aspre->markerpoints);
                                echo ($skillpoint !='' ?$skillpoint :''); ?></li>
                                <li><i class="icon icon-31" aria-hidden="true"></i> E-Market Points: <?php echo ($markerpoint !='' ? $markerpoint :''); ?></li>
                                <li><i class="icon icon-26" aria-hidden="true"></i> <?php echo $aspre->location; ?></li>
                            </ul>
                            <div class="Presenter-count">
	                            <span><?php echo ($_POST['joinas'] == '2'?'$'.$aspre->bid:$aspre->bid.'%'); ?></span>
	                            <div class="Presenter-date"><i class="icon icon-27" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                        	</div>
                        </div>
                    </div>
                </div>
               <?php 
               if($aspre->skillpoints <= 1000 ){
                    echo '<div class="yellow-icon commen-icon-cls"></div>';
                }
                elseif ($aspre->skillpoints <= 10000) {
                    echo '<div class="green-icon commen-icon-cls"></div>';
                }
                elseif ($aspre->skillpoints <= 100000) {
                    echo '<div class="blue-icon commen-icon-cls"></div>';
                }
                else{
                    echo '<div class="red-icon commen-icon-cls"></div>';
                }

                //echo ($aspre->status == '1' && $aspre->status == '1' ? 
                    if($aspre->status == '1'){
                        if($aspre->join_as == '2' ){
                            echo ($aspre->pre_accept == '1' ?'<div class="approve-line"><h3>Approved</div></h3>':'');
                        }
                        else
                        {
                        	 echo ($aspre->payment_status == '1' ?'<div class="approve-line"><h3>Approved</div></h3>':'');
                           
                            //echo '<div class="approve-line"><h3>Approved</div></h3>';
                        }
                    }
                    ?>
            </div>
        <?php $bidid = $aspre->bid_ID;
        }
        ?>

       <?php 
       if($totalRowCount > $showlimit){ 
	        if($this->input->post('joinas') == '2'){
	             $clickcls = 'show_more_pre';
	             $removecls = 'new-load-morepre'; 
	        }
	         else{
	            $clickcls = 'show_more_att'; 
	            $removecls = 'new-load-moreatt'; 
	        }
	        ?>
	        <div class="load-more-btn <?php echo $removecls; ?>">
	            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline <?php echo $clickcls; ?>">load more</a>
	            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
	        </div>
    <?php }  

    }

public function go_to_paynow(){
	
$did = $_POST['discussion'];
$preids = $this->AdminModel->runselectrow("select GROUP_CONCAT(tb.user_ID) as users from trader_bid as tb WHERE tb.dscussion_ID = '".$did."' and tb.join_as = '2' AND tb.approve_status = '1' AND tb.pre_accept = '1'");
  
   
if(!empty($preids->users)){

	$prefeedback = $this->MainModel->runselect("SELECT tf.*,tu.virtual_name,tu.profile_photo FROM trader_feedback as tf LEFT JOIN trader_user as tu on tf.presenter = tu.user_ID where tf.presenter IN($preids->users) AND discussion_ID = '".$did."' GROUP by tf.presenter");
}
?>
   <div class="review_accordion">
                        	<div class="table-responsive accordion_content">
                        		<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

                        		<?php 	
                    			//echo  "<pre>"; print_r($prefeedback); exit;
                    			if(!empty($prefeedback)){
                    			$a=0;
								foreach ($prefeedback as $prefeed ) {
									?>
									<div class="card">
									    <!-- Card header -->
									    <div class="card-header accordion" role="tab" id="headingTwo1">
									      <a class="" href="javascript:void(0)">
									      	<div class="tab_review_content">
										      	<div class="presenter-img">
										      		<?php if($prefeed->profile_photo != ''){
										      				$image_path_pr = base_url('upload/profile/' . $prefeed->profile_photo);
							                                $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-76x76.', $image_path_pr);

							                                ini_set('allow_url_fopen', true);

							                                if (getimagesize($thumb_path_pr)) {
							                                    $image_path_fd = $thumb_path_pr;
							                                }
										      			?>
										      				<img src="<?php echo $image_path_fd; ?>" />
										      			<?php
										      		}
										      		else{
										      			?>
										      				<img src="<?php echo base_url() ?>assets/images/none-user-96x96.jpg" />
										      			<?php
										      		} ?>
										      	</div>
										      	<div class="presenter-address">
	 									        	<h5 class="mb-0"><?php echo $prefeed->virtual_name; ?> (Presenter)</h5>
	 									        	<?php
	 									        	$pr_avg = $this->MainModel->runselectrow("SELECT ROUND(AVG(tf.rating)) as average from trader_feedback as tf where tf.presenter = '".$prefeed->presenter."' AND tf.discussion_ID = '".$did."' ");
	 									        	$pr_avg = $pr_avg->average;
	 									        	?>
	 									        	<div class="rating_star">
	 									        		<start class="rating-score">
															<i class="icon icon-32 <?php echo ($pr_avg >= '1' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '2' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '3' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '4' ?'active':'') ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php echo ($pr_avg >= '5' ?'active':'') ?>" aria-hidden="true"></i>
														</start>
	 									        	</div>
										      	</div>
										    </div>
									      </a>
									    </div>
									    <div class="accordion_inner" style="display: none;">
									      <div class="card-body">
									<?php  
									$attfeed = $this->MainModel->runselect("SELECT tf.*,tu.virtual_name,tu.profile_photo FROM trader_feedback as tf LEFT JOIN trader_user as tu on tf.attendee = tu.user_ID where tf.presenter = '".$prefeed->presenter."' AND discussion_ID = '".$did."'");

										foreach ($attfeed as $attfd) { $a++; 
									 	?> 
									    <!-- Card body -->
									        <div class="body_review_content">
									        	<div class="review_img">
									        		
									        	<?php if($attfd->profile_photo != ''){

									        			$image_path_at = base_url('upload/profile/' . $attfd->profile_photo);
							                                $thumb_path_at = preg_replace('~\.(?!.*\.)~', '-76x76.', $image_path_at);

							                                ini_set('allow_url_fopen', true);

							                                if (getimagesize($thumb_path_at)) {
							                                    $image_path_fd2 = $thumb_path_at;
							                                }
									        			?>
									        			<img src="<?php echo $image_path_fd2; ?>" />
									        			<?php
									        		}
									        		else{
									        			?>
									        			<img src="<?php echo base_url() ?>assets/images/none-user-47x39.jpg" />
									        			<?php
									        		}
									        		?>
									        	</div>
									        	<div class="review_title_time">
									        		<h4><?php echo $attfd->virtual_name; ?></h4>
									        		<span><!-- 29 Nov 2018 --><?php echo date('d M Y',strtotime($attfd->createdDate)); ?></span>
									        		<div class="rating_star">
	 									        		<start class="rating-score">
															<i class="icon icon-32 <?php if($attfd->rating >= '1'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '2'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '3'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '4'){ echo "active"; } ?>" aria-hidden="true"></i>
															<i class="icon icon-32 <?php if($attfd->rating >= '5'){ echo "active"; } ?>" aria-hidden="true"></i>
														</start>
	 									        	</div>
									        	</div>
									        	<div class="review_text">
									        		<p><?php echo $attfd->feedback; ?></p>
									        	</div>
									        </div>
								  <?php } ?>
									      </div>
									    </div>
									</div>
						  <?php }
							}
							else{
								?>
								<div class="notfound">Review Not Found.</div>
							<?php } ?>
                        		</div>
                        	</div>
                        </div>
<?php
}

    //------paynow admin manual entry-------------

    public function discussion_admin_paynow()
	{
		$userID=$this->input->post("user_id");
			if($this->input->post("txtpay".$userID)!=''){
				
				$discussion_id=$this->input->post("discussion_".$userID);
				$data = array(
				        	"disussion_ID"=>$discussion_id,
		        			"user_ID"=>$userID,
							"debit_credit"=>'2',
							"amount"=>$this->input->post("txtpay".$userID),
							"description"=>'Admin pay discussion amount to presenter',
							"createdDate"=>date("Y-m-d H:i:s"),
							"updatedDate"=>date("Y-m-d H:i:s")
						);
				        $this->MainModel->insertrow('trader_transaction',$data);
 
				        //---for presenter bid payment status update

						$dataval = array(
						"payment_status"=>'1',
						"updatedDate"=>date("Y-m-d H:i:s")
						);
 
						$condval = array("dscussion_ID"=>$discussion_id,"user_ID"=>$userID);

						$updatepresenterbidstaus = $this->AdminModel->updaterecord('trader_bid',$condval,$dataval);

						$marketrow = $this->MainModel->get_singlerecord('trader_emarket_skiil_points_settings',array('emskill_point_ID'=>1));

						$userrow = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=>$userID));
						$marketpoints = $marketrow->em_point;
						$marketpoint = $marketpoints*$this->input->post("txtpay".$userID);
						$finalpoint = $userrow->market_point+$marketpoint;
  
						$this->AdminModel->updaterecord('trader_user',array('user_ID'=>$userID),array('market_point'=>$finalpoint));														

						if($updatepresenterbidstaus){
							$descrow = $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$discussion_id));

							$notidata = array(
								'post_discu_ID'=>$descrow->discussion_ID,
								'fromuser_ID'=>$this->session->userdata['logged_in']['adminid'],
								'touser_ID'=>$userrow->user_ID,
								'type'=>'14',
								"createdDate"=>date("Y-m-d H:i:s")
							);
							$innot = $this->MainModel->insertrow('trader_notifications',$notidata);	
							$usersubject = "Congratulation You are earning $".$this->input->post("txtpay".$userID)." for ".ucwords($descrow->discussion_title);
						$maildata['mailed_data'] = array(
						                    "username"=>$userrow->virtual_name,
						                    //'bid'     => $bid->bid,
						                    'discussion'  => $descrow->discussion_title,
						                    'discussion_dt'=> $this->input->post('discussion_start_datetime'),
						                    'amount' => $this->input->post("txtpay".$userID),
						                    'discussion_id'=> $descrow->discussion_ID,
						                    'logo'    => base_url().'assets/images/trader-logo.png'
						                );
							$pay_mail = $this->load->view("templates/get_payment",$maildata,true);
							
							if($userrow->notification_email != ''){
								$notiemail = $userrow->notification_email;
							}
							else{
								$notiemail = $userrow->email;
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

			                    $this->email->from('support@trader-network.com','Trader Network');
						        $this->email->to($notiemail);
						        $this->email->subject($usersubject);
						        $this->email->message($pay_mail);
						        $this->email->set_mailtype("html");
						        $this->email->send();


							$this->session->set_flashdata('success','Your payment is completed..');
						}
						redirect(base_url('admin/pay-now/'.$discussion_id));
			}
    }
    
    public function discussion_admin_paynow_ajax()
	{
       	$preselect="SELECT GROUP_CONCAT(user_ID)as userid FROM trader_bid where dscussion_ID=".$this->input->post('discussion_ID')." AND join_as=2 AND approve_status = '1' AND pre_accept = '1' ";


			 $presenter = $this->MainModel->runselectrow($preselect);	
			
         $trans_select="select tb.*,tt.*,(select sum(amount) from trader_transaction where disussion_ID=".$this->input->post('discussion_ID')." AND user_ID in(".$presenter->userid."))as totalamount from trader_bid as tb left join trader_transaction AS tt on tb.user_ID=tt.user_ID AND tt.disussion_ID=".$this->input->post('discussion_ID')."  WHERE tb.dscussion_ID = ".$this->input->post('discussion_ID')." and tb.join_as = '2' AND tb.approve_status = '1' AND tb.pre_accept = '1'";

        $chktrnsaction = $this->MainModel->runselect($trans_select);
	
		$cond = array(
			"user_ID"=>$this->input->post('user_id'),
			"disussion_ID"=>$this->input->post('discussion_ID'),
		);
	
		$chkuserchk = $this->MainModel->get_singlerecord('trader_transaction',$cond);
         
				if($chkuserchk){
					echo "2";
					exit();
				}

         		if($chktrnsaction){

         			$totalamount=$chktrnsaction[0]->totalamount+$this->input->post("txtpay");

         				if($totalamount > $this->input->post("payableamount")){

         					echo '1';
         				}
         		}else{
         				if($this->input->post("txtpay") > $this->input->post("payableamount")){

         					echo '1';
         				}

         		}
      
	exit;
	
	 
	}
	public function admin_dicsussion_status(){
		$disstatus= $this->input->post("status");

		$id = $this->input->post('discussion_ID');
		 
		 $this->MainModel->updaterecord("trader_discussion","discussion_ID",$id,array("status" =>$disstatus));

		 $this->session->set_flashdata('success','Discussion status changed Successfully.');
	}  

}
