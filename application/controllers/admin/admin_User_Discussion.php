<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Discussion extends CI_Controller {

public function __construct(){

	parent::__construct();
	$this->load->helper(array('url','form','text'));
	$this->load->library(array('session'));
	$this->load->model('MainModel');
}
public function index(){  
	if($this->session->userdata('userid') == '') {
        redirect(base_url('login'));
    }
}

//----------default discussion load data-----------
public function view_defaultdiscussion(){  
	

    $did = $this->input->post('discussion');
    $descdata =  $this->MainModel->get_singlerecord('trader_discussion',array('discussion_ID'=>$did));

    if(!empty($descdata)){
	   $inskill = str_replace('|','","',$descdata->skill_required_discussion);
	   $skills = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');
 	
    $showlimit = 1;
    $select = "SELECT tb.join_as,tb.pre_accept,des.requirment_detail as description, des.require_presenter as req_pre, des.require_attendee as req_att,des.base_price as price, (select count(dscussion_ID) from trader_bid where dscussion_ID = des.discussion_ID and approve_status='1' and join_as='2' AND isActive='1' AND isDelete='0')as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = des.discussion_ID and approve_status='1' and join_as='1' AND isActive='1' AND isDelete='0')as attendee,tb.bid_ID,(select count(bid_ID) from trader_bid as ctbp where ctbp.dscussion_ID = $did and ctbp.join_as = '2') as totalpre,(select count(bid_ID) from trader_bid as ctbp where ctbp.dscussion_ID = $did and ctbp.join_as = '1') as totalatt, tb.user_ID as biduserid,tb.bid as bidprice,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID ) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID ";


    $aspresenter = $this->MainModel->runselect("$select WHERE tb.join_as = '2' AND tb.dscussion_ID = '".$did."' ORDER BY tb.bid_ID DESC limit $showlimit "); 
    $asattendee = $this->MainModel->runselect("$select WHERE  tb.join_as = '1' AND tb.dscussion_ID = '".$did."' ORDER BY tb.bid_ID DESC limit $showlimit "); 
 
    $totalpre = (!empty($aspresenter) ?$aspresenter[0]->totalpre:'0'); 
    $totalatt = (!empty($asattendee)?$asattendee[0]->totalatt:'0');
    $totalpreRow = $totalpre;
    $totalattRow = $totalatt;
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
                        <?php if($this->session->userdata('userid') == $descdata->user_ID){ ?>
                                <li><a href="#section-3">Discussion Details</a></li>
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
                                        <div class="Presenter-img">
                                            <?php if($aspre->profile!=''){
                                             ?>
                                            <img src="<?php echo base_url() ?>upload/profile/<?php echo $aspre->profile; ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user.png">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="Presenter-address">
                                            <h3><?php echo $aspre->name; ?></h3>
                                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                                            <ul>
                                                <li><i class="icon icon-icon-6" aria-hidden="true"></i> Skill Points : <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$aspre->skillpoints);
                                                $markerpoint = money_format('%!.0n',$aspre->markerpoints);
                                                echo ($skillpoint !='' ? $skillpoint : ''); ?></li>
                                                <li><i class="icon icon-icon-23" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li><?php if($aspre->location != ''){
                                                    ?>
                                                        <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $aspre->location;  
                                                    } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if($aspre->status == '1'){
                                 ?>
                                <div class="Presenter-description">
                                    <div class="Presenter-detail-inner-description">
                                        <div class="Presenter-title">
                                            <ul>
                                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($aspre->presentercount !=''?$aspre->presentercount:'0'); ?> Dicussions as Presenter </li>
                                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($aspre->attendeecount !=''?$aspre->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                                <li class="title3"><i class="icon icon-icon-22"></i> <?php echo ($aspre->discount !=''?$aspre->discount:'0'); ?> Created Dicussions</li>
                                            </ul>
                                        </div>
                                        <div class="Presenter-count">
                                            <span><?php echo '$'.$aspre->bidprice; ?></span>
                                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                }else{
                                ?>
                                <div class="Presenter-description">
                                    <div class="Presenter-detail-inner-description">
                                        <div class="Presenter-title">
                                            <ul>
                                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($aspre->presentercount !=''?$aspre->presentercount:'0'); ?> Dicussions as Presenter </li>
                                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($aspre->attendeecount !=''?$aspre->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                                <li class="title3 "><i class="icon icon-icon-22"></i> <?php echo ($aspre->discount !=''?$aspre->discount:'0'); ?> Created Dicussions</li>
                                            </ul>
                                        </div>
                                        <div class="Presenter-count">
                                            <span><?php echo '$'.$aspre->bidprice; ?></span>
                                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){ ?>
                                <div class="approve_popup custom_popup">
                                    <div class="modal fade" id="aprv_popup<?php echo $i; ?>" role="dialog">
                                        <div class="modal-dialog">
                                          <div class="popup_middile">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Are you sure you want to approve this bid?</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="popup_text">
                                                <?php
                                                if($aspre->presenter == $aspre->req_pre){
                                                ?>
                                                  <p>You have to approved all presenter for this discussion.</p>  
                                                <?php
                                                } 
                                                else{ ?>
                                                    <p>Total payable amount for this discussion is <b><?php echo '$'.$aspre->price; ?></b>. User as presenter has bid <?php echo '$'.$aspre->bidprice; ?> for this discussion. </p>
                                                </div>
                                                <div class="popup_btn_content">
                                                  <a href="<?php echo base_url() ?>Discussion/approve_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline pop_confirm_btn">confirm</a>
                                                  <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                                </div>
                                                <?php    
                                                }
                                                ?>    

                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div> 
                                   <div class="Presenter-description create-pending-tabs">
                                    <a href="<?php echo base_url() ?>Discussion/decrease_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline">DECREASE BID</a>
                                    <a href="#" class="btn-bule-outline approve-btn" data-toggle="modal" data-target="#aprv_popup<?php echo $i; ?>">approve</a>
                                    <a href="#" class="btn-bule-outline">view details</a>
                                    </div>
                                <?php 
                                    }
                                } 
                                ?>
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
                        ?>
                       <?php if($totalpreRow > $showlimit){ ?>
                        <div class="load-more-btn new-load-morepre">
                            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_pre">load more</a>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                        </div>
                        <?php } 
                    }else{
                        echo "No Presenter Found..";
                    } ?>
                    </div>
                    </div>
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
                                        <div class="Presenter-img">
                                            <?php if($asatt->profile!=''){
                                             ?>
                                            <img src="<?php echo base_url() ?>upload/profile/<?php echo $asatt->profile; ?>">
                                             <?php   
                                            }else{
                                             ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user.png">
                                             <?php   
                                            } ?>
                                        </div>
                                        <div class="Presenter-address">
                                            <h3><?php echo $asatt->name; ?></h3>
                                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                                            <ul>
                                                <li><i class="icon icon-icon-6" aria-hidden="true"></i> Skill Points: <?php 
                                                setlocale(LC_MONETARY, 'en_IN');  
                                                $skillpoint = money_format('%!.0n',$asatt->skillpoints);
                                                $markerpoint = money_format('%!.0n',$asatt->markerpoints);
                                                echo ($skillpoint !='' ?$skillpoint :''); ?></li>
                                                <li><i class="icon icon-icon-6" aria-hidden="true"></i> E-Market Points : <?php echo ($markerpoint !='' ? $markerpoint:''); ?></li>
                                                <li>
                                                    <?php if($asatt->location != ''){ ?>
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $asatt->location; 
                                                } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if($asatt->status == '1'){
                                 ?>
                                <div class="Presenter-description">
                                    <div class="Presenter-detail-inner-description">
                                        <div class="Presenter-title">
                                            <ul>
                                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($asatt->presentercount !=''?$asatt->presentercount:'0'); ?> Dicussions as Presenter </li>
                                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($asatt->attendeecount !=''?$asatt->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                                <li class="title3"><i class="icon icon-icon-22"></i> <?php echo ($asatt->discount !=''?$asatt->discount:'0'); ?> Created Dicussions</li>
                                            </ul>
                                        </div>
                                        <div class="Presenter-count">
                                            <span><?php echo $asatt->bidprice.'%'; ?></span>
                                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($asatt->biddate)); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }else{
                                ?>
                                <div class="Presenter-description">
                                    <div class="Presenter-detail-inner-description">
                                        <div class="Presenter-title">
                                            <ul>
                                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($asatt->presentercount !=''?$asatt->presentercount:'0'); ?> Dicussions as Presenter </li>
                                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($asatt->attendeecount !=''?$asatt->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                                <li class="title3"><i class="icon icon-icon-22"></i> <?php echo ($asatt->discount !=''?$asatt->discount:'0'); ?> Created Dicussions</li>
                                            </ul>
                                        </div>
                                        <div class="Presenter-count">
                                            <span><?php echo $asatt->bidprice.'%'; ?></span>
                                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($asatt->biddate)); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){ ?>
                                <div class="approve_popup custom_popup">
                                    <div class="modal fade" id="aprv_popup_at<?php echo $j; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="popup_middile">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Are you sure you want to approve this bid?</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="popup_text">
                                                <?php  
                                                if($asatt->attendee == $asatt->req_att){
                                                ?>
                                                  <p>You have to approved all attendee for this discussion.</p>  
                                                <?php
                                                } 
                                                else{ 
                                                ?>
                                                  <p>Total payable amount for this discussion is <b><?php echo '$'.$asatt->price; ?></b>. User as attendee has bid <?php echo $asatt->bidprice.'%'; ?> for this discussion. </p>

                                                </div>
                                                <div class="popup_btn_content">
                                                  <a href="<?php echo base_url() ?>Discussion/approve_bid/<?php echo $asatt->bid_ID.'/'.$asatt->biduserid; ?>" class="btn-bule-outline pop_confirm_btn">confirm</a>
                                                  <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                                </div>
                                            <?php } ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="Presenter-description create-pending-tabs">
                                       <a href="<?php echo base_url() ?>Discussion/increase_bid/<?php echo $asatt->bid_ID.'/'.$asatt->biduserid; ?>" class="btn-bule-outline">INCREASE BID</a>
                                       <a href="#" class="btn-bule-outline approve-btn" data-toggle="modal" data-target="#aprv_popup_at<?php echo $j; ?>">approve</a>
                                       <a href="#" class="btn-bule-outline">view details</a> 
                                    </div>
                                <?php 
                                    }
                                }
                                 ?>
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
                                            echo '<div class="approve-line"><h3>Approved</div></h3>';
                                        }
                                    }
                                ?> 
                            </div>
                        <?php
                        $bidid = $asatt->bid_ID;   
                        }
                        ?>

                    </div>

                    <?php if($totalattRow > $showlimit){ ?>
                        <div class="load-more-btn new-load-moreatt">
                            <a href="javascript:void(0)" data-id="<?php echo $bidid; ?>" class="btn-bule-outline show_more_att">load more</a>
                            <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                        </div>
                    <?php }   
                    }
                    else{
                        echo "No attendee Found..";  
                    } ?>
                    </div>
                </div>
                <?php if($this->session->userdata('userid') == $descdata->user_ID){ ?>
                    <div id="section-3">
                        <h1 class="accordion-tab-title"> Discussion Details</h1>
                    <?php if($descdata->requirment_detail != ''){ ?>
                        <div class="trader-content-description">
                            <?php echo $descdata->requirment_detail; ?>
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
    public function view_discussion(){  
        if($this->session->userdata('userid') == '') {
            redirect(base_url('login'));
        }

        $descdata =  $this->MainModel->runselectrow('SELECT td.*,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="2" AND isActive="1" AND isDelete="0")as presenter,(select count(dscussion_ID) from trader_bid where dscussion_ID = td.discussion_ID and approve_status="1" and join_as="1" AND isActive="1" AND isDelete="0")as attendee from trader_discussion as td WHERE discussion_ID = "'.$this->input->post("discussion").'" ');

        $inskill = str_replace('|','","',$descdata->skill_required_discussion);

        $skills = $this->MainModel->runselect('select * from trader_skills where skill_ID in("'.$inskill.'") ');

        $countpre = $this->MainModel->runselect("SELECT tb.bid_ID, tb.user_ID as biduserid,tb.bid,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE tb.join_as = '".$_POST['joinas']."' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ORDER BY tb.bid_ID DESC");
 
    $totalRowCount = count($countpre);
    $showlimit = 2; 
   
$aspresenter = $this->MainModel->runselect("SELECT tb.join_as,tb.pre_accept,tb.bid_ID, tb.user_ID as biduserid,tb.bid,tb.createdDate as biddate,tb.approve_status as status, tu.virtual_name as name, tu.profile_photo as profile, tu.total_skill_points as skillpoints, tu.market_point as markerpoints, CONCAT((select name from trader_countries where country_ID = (SELECT country FROM trader_user WHERE user_ID = tb.user_ID)),', ' ,(select name from trader_cities where city_ID = (SELECT city FROM trader_user WHERE user_ID = tb.user_ID))) as location, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '2' AND countpr.user_ID = tb.user_ID) as presentercount, (select count(bid_ID) FROM trader_bid as countpr where countpr.join_as = '1' AND countpr.user_ID = tb.user_ID) as attendeecount,(select COUNT(discussion_ID) FROM trader_discussion WHERE trader_discussion.user_ID =  tb.user_ID) as discount FROM `trader_bid` as tb LEFT JOIN trader_user as tu ON tb.user_ID = tu.user_ID left JOIN trader_discussion as des ON tb.dscussion_ID = des.discussion_ID WHERE tb.join_as = '".$_POST['joinas']."' AND tb.dscussion_ID = '".$_POST['discussion']."' AND tb.bid_ID < '".$_POST['bid']."' ORDER BY tb.bid_ID DESC limit $showlimit ");

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
                        <div class="Presenter-img">
                            <?php if($aspre->profile!=''){
                             ?>
                            <img src="<?php echo base_url() ?>upload/profile/<?php echo $aspre->profile; ?>">
                             <?php   
                            }else{
                             ?>
                            <img src="<?php echo base_url() ?>assets/images/none-user.png">
                             <?php   
                            } ?>
                        </div>
                        <div class="Presenter-address">
                            <h3><?php echo $aspre->name; ?></h3>
                            <!-- <div class="star-section">(4.9) 104 Reviews</div> -->
                            <ul>
                                <li><i class="icon icon-icon-6" aria-hidden="true"></i> Skill Points : <?php 
                                setlocale(LC_MONETARY, 'en_IN');  
                                $skillpoint = money_format('%!.0n',$aspre->skillpoints);
                                $markerpoint = money_format('%!.0n',$aspre->markerpoints);
                                echo ($skillpoint !='' ?$skillpoint :''); ?></li>
                                <li><i class="icon icon-icon-23" aria-hidden="true"></i> E-Market Points: <?php echo ($markerpoint !='' ? $markerpoint :''); ?></li>
                                <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $aspre->location; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if($aspre->status == '1'){
                 ?>
                <div class="Presenter-description">
                    <div class="Presenter-detail-inner-description">
                        <div class="Presenter-title">
                            <ul>
                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($aspre->presentercount !=''?$aspre->presentercount:'0'); ?> Dicussions as Presenter </li>
                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($aspre->attendeecount !=''?$aspre->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                <li class="title3"><i class="icon icon-icon-22"></i> <?php echo ($aspre->discount !=''?$aspre->discount:'0'); ?> Created Dicussions</li>
                            </ul>
                        </div>
                        <div class="Presenter-count">
                            <span><?php echo ($_POST['joinas'] == '2'?'$'.$aspre->bid:$aspre->bid.'%'); ?></span>
                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                        </div>
                    </div>
                </div>
                <?php 
                }else{
                ?>
                <div class="Presenter-description">
                    <div class="Presenter-detail-inner-description">
                        <div class="Presenter-title">
                            <ul>
                                <li class="title1"><i class="icon icon-icon-3"></i> <?php echo ($aspre->presentercount !=''?$aspre->presentercount:'0'); ?> Dicussions as Presenter </li>
                                <li class="title2"><i class="icon icon-icon-4"></i> <?php echo ($aspre->attendeecount !=''?$aspre->attendeecount:'0'); ?> Dicussions as Attendee</li>
                                <li class="title3 "><i class="icon icon-icon-22"></i> <?php echo ($aspre->discount !=''?$aspre->discount:'0'); ?> Created Dicussions</li>
                            </ul>
                        </div>
                        <div class="Presenter-count">
                            <span><?php echo ($_POST['joinas'] == '2'?'$'.$aspre->bid:$aspre->bid.'%'); ?></span>
                            <div class="Presenter-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d F, Y',strtotime($aspre->biddate)); ?></div>
                        </div>
                    </div>
                </div>
            <?php if($descdata->user_ID == $this->session->userdata('userid') && $descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){ ?>
                <div class="approve_popup custom_popup">
                <div class="modal fade" id="aprv_popup_new<?php echo $i; ?>" role="dialog">
                <div class="modal-dialog">
                  <div class="popup_middile">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Are you sure you want to approve this bid?</h4>
                      </div>
                      <div class="modal-body">
                        <?php 
                        if($this->input->post("joinas") == '2'){
                            if($descdata->presenter == $descdata->require_presenter){
                            ?>
                            <div class="popup_text">
                              <p>You have to approved all presenter for this discussion.</p>  
                            </div>
                            <?php
                            } 
                            else{ ?>
                                <div class="popup_text">
                                    <p>Total payable amount for this discussion is <b><?php echo '$'.$descdata->base_price; ?></b>. User as presenter has bid <?php echo '$'.$aspre->bid; ?> for this discussion. </p>
                                </div>
                                <div class="popup_btn_content">
                                    <a href="<?php echo base_url() ?>Discussion/approve_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline pop_confirm_btn">confirm</a> 
                                    <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                </div>
                            <?php    
                            }
                        }
                        else{
                            if($descdata->attendee == $descdata->require_attendee){
                            ?>
                                <div class="popup_text">
                                    <p>You have to approved all attendee for this discussion.</p>  
                                </div>
                               <!--  <div class="popup_btn_content">
                                    <a href="<?php echo base_url() ?>Discussion/approve_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline pop_confirm_btn">confirm</a> 
                                    <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                </div> -->
                            <?php
                            } 
                            else{   ?>
                                <div class="popup_text">
                                    <p>Total payable amount for this discussion is <b><?php echo '$'.$descdata->base_price; ?></b>. User as attendee has bid <?php echo $aspre->bid.'%'; ?> for this discussion. </p>
                                </div>
                                <div class="popup_btn_content">
                                    <a href="<?php echo base_url() ?>Discussion/approve_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline pop_confirm_btn">confirm</a> 
                                    <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                </div>
                            <?php    
                            }   
                        }
                        ?>    
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                </div> 
                    <div class="Presenter-description create-pending-tabs">
                        <a href="<?php echo base_url() ?>Discussion/decrease_bid/<?php echo $aspre->bid_ID.'/'.$aspre->biduserid; ?>" class="btn-bule-outline">DECREASE BID</a>
                        <a href="#" class="btn-bule-outline approve-btn" data-toggle="modal" data-target="#aprv_popup_new<?php echo $i; ?>">approve</a>
                        <a href="#" class="btn-bule-outline">view details</a>
                    </div>
                <?php
                    } 
                }
                
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
                            echo '<div class="approve-line"><h3>Approved</div></h3>';
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
	 

}