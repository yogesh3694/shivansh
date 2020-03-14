<?php //echo "<pre>"; print_r($descdata); ?>
<!-- <script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js" type="text/javascript"></script> -->
<link rel="stylesheet" href="http://192.168.1.200/Trader-Network/assets/front/css/bootstrap.min.css" />
<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js"></script>

<?php
//$this->view_discussion2('11','22');
 ?> 
<script src="<?php echo  base_url();?>assets/front/js/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).on('click','.card-header',function (e) {
    // alert($(e.target).parent('div.accorion_inner').attr("class"));
    if ($(this).parent("div").hasClass('content_opend')) {
        $(this).parent("div").removeClass('content_opend');
        $(this).siblings('.accordion_inner').slideUp();
    } else if ($(this).parent("div").siblings("div").hasClass('content_opend')) {
        $(this).parent("div").siblings("div").removeClass('content_opend');
        $(this).parent("div").siblings("div").children('.accordion_inner').slideUp();
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    } else {
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    }
    // $('.card-header').click(function(){  
    //     var currentId = $(this).attr('id');
    //     setTimeout(function() {
    //         $('html, body').animate({
    //             scrollTop: $('#'+currentId).offset().top - 150
    //         }, 1000);
    //     }, 300);
    // });  
});
jQuery(document).ready(function($) { 
 
    jQuery(".manage_disc_main").addClass('active');
    //jQuery(".manage_disc_main").children('.sub-menu-w').show();
    jQuery(".manage_disc_main").find('.has-sub-menu').addClass('active');
 
});
</script>
<script type="text/javascript">
jQuery(window).bind("load", function() { 
    var ID = $(this).attr('data-id');
    var prcount = $('#totalpre').val();
    var dis = '<?php echo $discid; ?>';
   maindiscussionfunctiondefault(ID,dis,3);
}); 
function tabdata(){
  var $accordionTabs = $('.accordion-tabs');
            $accordionTabs.accordionTabs({ mediaQuery: '(min-width: 40em)' }, 
            {header: 'h1', heightStyle: 'content'}, 
            { show: {effect: 'fade'}
        });  
    <?php if(isset($scroll)){ ?>
            $('#ui-id-4').trigger('click');
            $('html, body').animate({
                            scrollTop: $("#main_admin_dsc").offset().top
                        }, 1500);
    <?php } ?>
}
jQuery(document).ready(function(){

    $(document).on('click','.show_more_pre',function(){
        var ID = $(this).attr('data-id');
        var prcount = $('#totalpre').val();
        var dis = '<?php echo $discid; ?>';
        $('.show_more').hide();
        $('.loding').show();
        maindiscussionfunction(ID,dis,2);
    });
    $(document).on('click','.show_more_att',function(){
        var ID = $(this).attr('data-id');
        var prcount = $('#totalpre').val();
        var dis = '<?php echo $discid; ?>';  
        $('.show_more').hide();
        $('.loding').show();
      maindiscussionfunction(ID,dis,1);
    }); 
    $(document).on('click','.show_more_pay',function(){
        var ID = $(this).attr('data-id');
        var prcount = $('#totalpre').val();
        var dis = '<?php echo $discid; ?>';  
        $('.show_more').hide();
        $('.lodingpay').show();

        $.ajax({
            type:'POST',
            url:"<?php echo base_url().'admin/Discussion_Master/view_payment_ajax' ?>",
            data:{ bid:ID,discussion:dis },
            success:function(html){  
                $('.new-load-morepay').remove();
                $('.paymenttab').append(html);
            }
        }); 
    }); 
});
 function maindiscussionfunction(ID,dis,joinas){
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'admin/Discussion_Master/view_discussion' ?>",
        data:{ bid:ID,discussion:dis,joinas:joinas },
        success:function(html){  
        	if(joinas==3){

                $('.maindiscussion_default_div').replaceWith(html);
                $('.loding').hide();

            }else{
                if(joinas == 2){
                    $('.new-load-morepre').remove();
                    $('.pre_loadmoreappend').append(html);
                }else{
                    $('.new-load-moreatt').remove();
                    $('.att_loadmoreappend').append(html);
                }
                $('.loding').hide();
            }
     }
    });
 }
 function maindiscussionfunctiondefault(ID,dis,joinas){
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'admin/Discussion_Master/view_defaultdiscussion' ?>",
        data:{ bid:ID,discussion:dis,joinas:joinas },
        success:function(html){  
        	$('.maindiscussion_default_div').replaceWith(html);
            $('.loding').hide();
			
			tabdata(); 
     }
    });
 }
</script>  
 
<div class="content-i discussion_paynow_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box">
                <h6 class="element-header"><?php echo $descdata->discussion_title; ?>
                 <?php if($descdata->status == '3'){
                            echo '<span class="green_button-status">Completed</span>';
                        } 
                        elseif($descdata->status == '4'){
                            echo '<span class="green_button-status">Cancelled</span>';
                        }
                        elseif ($descdata->status == '1') {
                            echo '<span class="green_button-status">Open</span>';
                        }
                        elseif ($descdata->status == '2') {
                            echo '<span class="green_button-status">Close</span>';
                        }
                        else{
                            echo '<span class="green_button-status">Close</span>';   
                        }
                    ?>
                </h6>
                 
                <div class="element-content">                    
                    <div class="paynow_cust_col_left">
                        <div class="row">
                            <div class="dashboard_box">
                                <a class="element-box el-tablo totaldisc_cls" href="javascript:void(0)">
                                    <div class="label">Budget Of This Discussion</div>
                                    <div class="value trending-down-basic"><?php echo '$'.$descdata->base_price; ?></div>
                                </a>
                            </div>
                            <div class="dashboard_box">
                                <a class="element-box el-tablo opendisc_cls" href="javascript:void(0)">
                                    <div class="label">Payable Amount</div>
                                    <div class="value trending-up-basic"><?php echo ($descdata->final_price!= "" ?"$".$descdata->final_price:''); ?></div>
                                    <a href="javascript:void(0)" data-toggle="modal" class="view_box_link" data-target="#viewmorepaymentpopop"><i class="fa fa-eye"></i>(View More)</a>

                                <?php if($descdata->status == '3'){ ?>
                                        <a href="<?php echo base_url().'admin/pay-now/'.$descdata->discussion_ID; ?>" class="paynow_btn">pay now</a>
                                <?php } ?>
                                </a>
                            </div>
                        </div>
                        <div class="trader-listing-detail-box">
                            <div class="discussionid-div">
                                <h3>Discussion Id : #<?php echo str_pad($descdata->discussion_ID,6,"0",STR_PAD_LEFT); ?></h3>
                            </div>
                            <div class="latest-discussion-box">
                                <div class="latest-discussion-box-bg">
                                    <div class="trader-listing-detail-box1">
                                        <div class="presents-attendes-area">
                                            <h3>Required Position:</h3>

                              <?php if($descdata->presenter == $descdata->require_presenter){
                                        $prcls = 'presenter-attende-green-button';
                                    }else{
                                        $prcls = 'presenter-attende-yellow-button';
                                    }
                                 ?>
                                            <div class="presents-area-commen-cls">
                                                <span class="presents-circle-area <?php echo $prcls; ?>"><?php echo $descdata->presenter.'/'.$descdata->require_presenter; ?></span>
                                                <span class="inner-txt">presenters</span>
                                            </div>
                              <?php if($descdata->attendee == $descdata->require_attendee){
                                    $atcls = 'presenter-attende-green-button';
                                }else{
                                    $atcls = 'presenter-attende-blue-button';
                                }
                                 ?>
                                            <div class="presents-area-commen-cls attendes-area-cls">
                                                <span class="presents-circle-area <?php echo $atcls; ?>">
                                                    <?php echo $descdata->attendee.'/'.$descdata->require_attendee; ?>
                                                </span>
                                                <span class="inner-txt">attendees</span>
                                            </div>
                                        </div>
                                        <div class="coordinator-description">
                                            <div class="date-time-txt">
                                                <div class="commen-box-cls">
                                                    <h3 class="commen-tabelcell-box"><i class="icon icon-27" aria-hidden="true"></i> Date &amp; Time</h3>
                                                    <span class="commen-tabelcell-box"><?php echo ($descdata->discussion_start_datetime !=''?date('d F, Y | h:i a',strtotime($descdata->discussion_start_datetime)):''); ?></span>
                                                </div>
                                            </div>
                                            <div class="age-group-txt">
                                                <div class="commen-box-cls">
                                                    <h3 class="commen-tabelcell-box"><i class="icon icon-28"></i>Age group</h3>
                                                    <span class="commen-tabelcell-box"><?php echo $descdata->agerange.' Year'; ?></span>
                                                </div>
                                            </div>
                                            <div class="inner-txt-title">
                                                <div class="commen-box-cls">
                                                    <h3 class="commen-tabelcell-box"><i class="icon icon-29" aria-hidden="true"></i> Category</h3>
                                                    <ul class="commen-tabelcell-box">
                                                        <li>
                                                            <div class="tooltip_div">
                                                            <?php 
                                                                echo mb_strimwidth($descdata->category, 0, 22,"..");
                                                                if(strlen($descdata->category) > 22 ){
                                                                ?> <span class="tooltiptext"><?php echo $descdata->category; ?></span> 
                                                                <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </li>
                                                        <li><i class="icon icon-arrow" aria-hidden="true"></i> 
                                                            <div class="tooltip_div">
                                                            <?php
                                                                echo mb_strimwidth($descdata->subcategory, 0, 22,"..");
                                                                if(strlen($descdata->subcategory) > 22 ){
                                                                ?> <span class="tooltiptext"><?php echo $descdata->subcategory; ?></span> 
                                                                <?php
                                                                }
                                                            ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="closing-date">
                                                <div class="commen-box-cls">
                                                    <h3 class="commen-tabelcell-box"><i class="icon icon-27" aria-hidden="true"></i> Closing Date</h3>
                                                    <span class="commen-tabelcell-box"><?php echo date('d F, Y',strtotime($descdata->closing_date)); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="paynow_cust_col_right">
                        <div class="pay_now_box">
                            <div class="discussionid-div">
                                <h3>Discussion Created Profile</h3>
                            </div>
                            <div class="paynow_details_content grey_content">
                                <div class="paynow_profile_img">
                                    <?php if($descdata->profile_photo != ''){

                                        $image_path_pr = base_url('upload/profile/' . $descdata->profile_photo);
                                        $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-46x46.', $image_path_pr);

                                        ini_set('allow_url_fopen', true);

                                        if (getimagesize($thumb_path_pr)) {
                                            $userimg = $thumb_path_pr;
                                        }
                                     ?>
                                        <img src="<?php echo $userimg; ?>" />
                                    <?php }
                                    else{
                                        ?>
                                        <img src="<?php echo base_url() ?>assets/images/none-user-46x46.jpg" />
                                    <?php }  ?>
                                </div>
                                <div class="paynow_usr_title">
                                    <h4><?php echo $descdata->virtual_name; ?></h4>
                                    <?php
                                        setlocale(LC_MONETARY, 'en_IN');  
                                        $skillpoint = money_format('%!.0n',$descdata->total_skill_points);
                                        $markerpoint = money_format('%!.0n',$descdata->market_point);
                                     ?>
                                    <label><i class="icon icon-26"></i> <?php echo $descdata->location; ?></label>
                                    <label><i class="icon icon-30"></i> Skill Points: <?php echo $skillpoint; ?></label>
                                    <label><i class="icon icon-31"></i> E-Market Points : <?php echo $markerpoint; ?></label>
                                </div>                                
                            </div>
                            <div class="paynow_details_content">
                                <ul>
                                    <li><?php echo $created_pre; ?> Dicussions as Presenter</li>
                                    <li><?php echo $created_att; ?> Dicussions as Attendee</li>
                                    <li><?php echo $created; ?> Created Dicussions</li>
                                </ul>
                                <a href="<?php echo base_url('admin/User_Master/view/'.$descdata->user_ID) ?>" class="view_profile_btn">view profile</a>
                            </div>
                        </div>
                    </div>
                    <div id="main_admin_dsc" class="dis_details_tab_content">
                        <section  class="trader-listing-detail-tabs create-attendee-complete-tabs maindiscussion_default_div">
                        </section>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

<div class="modal fade paynow-popup view_more_popup" id="viewmorepaymentpopop" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <?php   $payamadminfess=(($descdata->final_price*10)/100);
                            $payampercentmainprice=$descdata->final_price-$payamadminfess;
                            ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Pay $<?php echo $payampercentmainprice;?></h4>
            </div>
                <form class="bs-example" method="post" action="<?php //echo base_url();?>Discussion/paymentforowner_discussion/<?php //echo $descdata->discussion_ID;?>">
                <input type="hidden" name="amount" value="<?php //echo $payam;?>">
                <input type="hidden" name="discussion_ID" value="<?php //echo $descdata->discussion_ID;?>">
                
            <div class="modal-body">
                <div class="panel-group" id="pay_accordion">
                    <div class="panel panel-default account-billing-section">
                        
                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="panel-body">
                           
                            <ul class="btm_spcing">
                            
                                <div class="payble_amt">
                                <span>Total Price </span><label>:  $<?php echo $descdata->final_price;?></label>
                                </div>
                                <div class="payble_amt">
                                <span>Minus Admin Fees (10%)</span><label>: $<?php echo str_pad($payamadminfess, 2, '0', STR_PAD_LEFT);?></label>
                                </div>
                                <div class="payble_amt">
                                <span>Presenter Payable Price </span><label>: $<?php echo $payampercentmainprice;?></label>
                                </div>
                            <!-- <label class="customradiobox">
                            </label> -->
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
           
            </form>
        </div>
    </div>

</div>


