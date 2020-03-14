<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script>

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
});
jQuery(window).bind("load", function() {

    var ID = $(this).attr('data-id');
    var prcount = $('#totalpre').val();
    var dis = '<?php echo $descdata->discussion_ID; ?>';
    review_ajax(dis);

}); 
function review_ajax(dis){
    //$('.loader').css('display','block');
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'admin/Discussion_Master/go_to_paynow' ?>",
        data:{ discussion:dis },
        success:function(html){  
            //$('.review_popup').replaceWith(html);
            $('.review_popup').html(html)
            //$('.loding').hide();
     }
    });
 }
jQuery(document).ready(function($) {
jQuery(".manage_disc_main").addClass('active');
//jQuery(".manage_disc_main").children('.sub-menu-w').show();
jQuery(".manage_disc_main").find('.has-sub-menu').addClass('active');
$('#chk_rvw').on('click', function(){    
 
        $.ajax({
            type:'POST',
            url:"<?php echo base_url().'admin/Discussion_Master/chk_rvw_ajax' ?>",
            success:function(html){  
                $(body).css('display','none');
               var res = jQuery.parseJSON(html);
                
                $('html, body').animate({
                        scrollTop: $("#main_admin_dsc").offset().top
                }, 2000);
         }
        });
    });  
});

</script>
<?php //print_r($pre_payment);  ?>
<div class="content-i discussion_paynow_page">
    <div class="content-box">
          <?php if($this->session->flashdata('success')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('success'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
            <?php } ?>
            <input type="hidden" name="dis_status" id="dis_status" value="<?php echo $descdata->status; ?>">
        <div class="element-wrapper">
            <div class="element-box">
                <h6 class="element-header"><?php echo $descdata->discussion_title; ?></h6>
                <div class="element-content">                    
                    <div class="paynow_cust_col_left">
                        <div class="row">
                            <div class="dashboard_box">
                                <a class="element-box el-tablo totaldisc_cls" href="javascript:void(0)">
                                    <div class="label">Budget Of This Discussion</div>
                                    <div class="value trending-down-basic"><?php echo '$'.$descdata->base_price; ?></div>
                                </a>
                            </div>
                            <?php
                                $payvle_amountpre=($descdata->final_price)-(($descdata->final_price*10)/100);
                                
                            ?>
                            <div class="dashboard_box">
                                <a class="element-box el-tablo opendisc_cls" href="javascript:void(0)">
                                    <div class="label">Payable Amount</div>
                                    <div class="value trending-up-basic"><?php echo ($descdata->final_price!= "" ?"$".$descdata->final_price:'$0'); ?></div>
                                     <a href="javascript:void(0)" data-toggle="modal" class="view_box_link" data-target="#viewmorepaymentpopop"><i class="fa fa-eye"></i>(View More)</a>
                                    <input type="hidden" name="payble_amount_final" id="payble_amount_final" value="<?php echo $payvle_amountpre;?>">
                                    <?php
                                     if(!empty($presenterpaidamount)){   
                                     ?>
                                    <input type="hidden" name="paid_amount_final" id="paid_amount_final" value="<?php echo ($presenterpaidamount[0]->amount != ''?$presenterpaidamount[0]->amount:'');?>">
                                    <?php } ?>
                                    <!-- <a href="#" class="paynow_btn">pay now</a> -->
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
                                                    <h3 class="commen-tabelcell-box"><i class="icon icon-26" aria-hidden="true"></i> Closing Date</h3>
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
                                <h3>pay now
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#check_review">Check Review</a></h3>
                                <div class="approve_popup custom_popup">
                                    <div class="modal fade" id="check_review" role="dialog">
                                        <div class="modal-dialog">
                                          <div class="popup_middile">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Check Review</h4>
                                               </div>
                                                  <div class="modal-body">
                                                        <div class="review_popup"></div>
                                                  </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $i=0;
                            if(!empty($pre_payment)){
                                $userarr=array();
                            foreach ($pre_payment as $user) {

                               
                            ?>
                            <div class="paynow_details_content">
                                <div class="paynow_profile_img">
                                    <?php if($user->profile_photo != ''){ $i++;

                                        $image_path_pr = base_url('upload/profile/' . $user->profile_photo);
                                        $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-46x46.', $image_path_pr);
                                        ini_set('allow_url_fopen', true);
                                        if (getimagesize($thumb_path_pr)) { $userimg = $thumb_path_pr; }
                                     ?> <img src="<?php echo $userimg; ?>" />
                                    <?php }
                                          else{ ?>
                                            <img src="<?php echo base_url() ?>assets/images/none-user-46x46.jpg" />   <?php  
                                         } ?>
                                </div>
                                <div class="paynow_usr_title">
                                    <h4><?php echo $user->virtual_name; ?></h4>
                                    <?php if($user->location != ''): ?>
                                    <label><i class="icon icon-26"></i> <?php echo $user->location; ?></label>
                                <?php endif; ?>
                                </div>
                                <div class="paynow_money_frm">
                                    <form id="paynowform<?php echo $user->user_ID; ?>" action="<?php echo base_url();?>/admin/Discussion_Master/discussion_admin_paynow" class="paynowform<?php echo $i; ?>" method="post">
                                        <div class="form_group paydiv<?php echo $i; ?>">
                                            <label>Money($) <?php if($user->amount!=''){?><span class="green_err">$<?php echo $user->amount;?>  paid</span><?php } ?></label> 
                                            <input type="hidden" name="discussion_<?php echo $user->user_ID; ?>" value="<?php echo $descdata->discussion_ID;?>" >
                                            <input type="hidden" name="user_id" value="<?php echo $user->user_ID; ?>" >
                                            <input type="text" data-id="<?php echo $user->user_ID; ?>" name="txtpay<?php echo $user->user_ID; ?>" id="txtpay<?php echo $user->user_ID; ?>" value="" class="input_text" onfocusout="checkpresenterpayment('<?php echo $user->user_ID; ?>','<?php echo $descdata->discussion_ID;?>')"/>
                                            <input type="submit" name="paynow_<?php echo $user->user_ID; ?>" id="paynow_<?php echo $user->user_ID; ?>" value="pay now" class="input_submit" />
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                              jQuery(".paynow_common").remove();
                                            jQuery('#paynowform<?php echo $user->user_ID; ?>').validate({
                                                rules: {
                                                    txtpay<?php echo $user->user_ID; ?>:{
                                                        required:true,
                                                        number:true,    
                                                      },
                                                    },
                                                messages: {
                                                    txtpay<?php echo $user->user_ID; ?>:{required:"Please enter amount.",}, 
                                                },
                                                errorPlacement: function(error, element) {
                                                    if(element.attr('name') == "txtpay<?php echo $user->user_ID; ?>"){
                                                         element.next('.input_submit').after(error);
                                                    }    
                                                }
                                            }); 
                                        });
                                    </script>
                                </div>
                            </div>
                     <?php }} ?>
                        </div>
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
<script type="text/javascript">
    

function checkpresenterpayment(t,did){

     jQuery(".pay_error"+t).remove();
var txtpayval=jQuery('#txtpay'+t).val();
var discussion_staus=jQuery('#dis_status').val();
var payableamount=jQuery('#payble_amount_final').val();
var paid_amount_final=jQuery('#paid_amount_final').val();
var mainamount=payableamount-paid_amount_final;
    if(txtpayval==''){

    }else if(discussion_staus!=3){
         jQuery('#txtpay'+t).next().after('<span class="paynow_common pay_error'+t+'">This discussion not completed.</span>');
            jQuery('#paynow_'+t).attr('disabled','disabled');
            return false;
    }else{
         jQuery('#paynow_'+t).removeAttr('disabled','disabled');
    }

    jQuery(".pay_error"+t).remove();
    jQuery.ajax({
    type: "POST",
    url: "<?php echo base_url();?>/admin/Discussion_Master/discussion_admin_paynow_ajax",
    data: {discussion_ID:did,user_id:t,txtpay:txtpayval,payableamount:payableamount,paid_amount_final:paid_amount_final},
    }).done(function( msg ) {
        if(msg==1){
             jQuery('#txtpay'+t).next().after('<span class="paynow_common pay_error'+t+'">Please enter amount less than '+mainamount+'</span>');
            jQuery('#paynow_'+t).attr('disabled','disabled');
        }else if(msg==2 && txtpayval!=''){

              jQuery('#txtpay'+t).next().after('<span class="paynow_common pay_error'+t+'">This presenter payment already paid.</span>');
             jQuery('#paynow_'+t).attr('disabled','disabled');
        }else{
             jQuery(".pay_error").remove();
            jQuery('#paynow_'+t).removeAttr('disabled','disabled');
        }
    
    });
}
</script>
<link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">