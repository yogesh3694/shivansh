<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js" type="text/javascript"></script>

<?php
//$this->view_discussion2('11','22');
 ?>
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

}
jQuery(document).ready(function(){
   


//payment popoup   
/*----------------- payment popoup ------------------------------- */
    $('#owner_pay').validate({
            rules: {
                cardno: {
                  required:true,
                }, 
            },
            messages: {
                cardno: {
                  required:"Please select card.",
                },
            },
            errorPlacement: function(error, element) {
            if(element.attr("name") == 'cardno'){
                error.insertBefore('.btm_spcing');
            }
            else{
                error.insertAfter(element);
            }
        },
    }); 
    //invitation popoup   
/*----------------- payment popoup ------------------------------- */
    $('#sendinvitationfrm').validate({
            rules: {
                intuser: {
                  required:true,
                }, 
                 user_Type: {
                  required:true,
                }, 
            },
            messages: {
                intuser: {
                  required:"Please select user.",
                },
                user_Type: {
                  required:"Please select user type.",
                },
            },      
    }); 

$('.payradio').on('click', function(){ 

    $('.payradio').each(function(i, obj) {
        var id2 = $(this).parent().next().next().children().attr('id');
        $('#'+id2).rules('remove', 'required');
        $('#'+id2).rules('remove', 'remote');
        $('#'+id2).val('');
    });

    var id = $(this).parent().next().next().children().attr('id'),
    cvvno = $(this).attr('data-cvv'),
    cardid = $(this).val();
    
    jQuery('#'+id).rules("add",{
        required: true,
        remote: {
                url: "<?php echo base_url(); ?>Discussion/cvv_check",
                type: "post",
                data: { cardid: cardid,cvv: cvvno },
                },
        messages: {
            required:"Please enter your cvv.",
            remote:"Please enter valid cvv",
        }
    });

            
});
$('#r11').on('click', function(){
    
    if($('#collapseTwo').hasClass('in')){
        $('#r12').parent().find('a').trigger('click')
    }
    $('.payradio').each(function(i, obj) {
        var id2 = $(this).parent().next().next().children().attr('id');

        $(this).prop("checked", false);
        $('#'+id2).rules('remove', 'required');
        $('#'+id2).rules('remove', 'remote');
        $('#'+id2).next('label').remove();
    });
})

$('#r12').on('click', function(){
    $(this).parent().find('a').trigger('click')
})
/*-----------------end payment popoup -------------------------- */
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
           
});
 function maindiscussionfunction(ID,dis,joinas){
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'User_Discussion/view_discussion' ?>",
        data:{ bid:ID,discussion:dis,joinas:joinas },
        success:function(html){  
        	if(joinas==3){

                $('. maindiscussion_default_div').replaceWith(html);
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
    $('.loader').css('display','block');
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'User_Discussion/view_defaultdiscussion' ?>",
        data:{ bid:ID,discussion:dis,joinas:joinas },
        success:function(html){  
        	$('.loader').css('display','none');
            $('.maindiscussion_default_div').replaceWith(html);
            $('.loding').hide();
			tabdata();
     }
    });
 }
</script>
<?php //print_r($descdata); exit; ?>

<div class="main">
<section class="custom-breadcrumbs-section">
    <div class="container">
        <div class="custom-breadcrumbs-content">
            <div class="custom-breadcrumbs-title">
                <h2><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="icon icon-icon-2"></i> </a> <?php echo $descdata->discussion_title; ?></h2>
            </div>
            <div class="custom-breadcrumbs-right-content">

                    <?php
                    if($descdata->status == '1'){
                        if($descdata->status == '1' && $descdata->closing_date >= date('Y-m-d')){
                           echo $status = '<a href="javascript:void(0)" class="green-button">Open</a>';
                        }else{
                            echo $status = '<a href="javascript:void(0)" class="green-button">Close</a>';
                        }
                    }
                    else if($descdata->status == '2'){
                        echo '<a href="javascript:void(0)" class="green-button">Close</a>';
                    }
                    else if($descdata->status == '3'){
                        echo '<a href="javascript:void(0)" class="green-button">Completed</a>';
                    }
                    else{
                        echo '<a href="javascript:void(0)" class="green-button">Cancelled</a>';
                    }
                    ?> 
                <h2><span>Budget </span><?php echo '$'.$descdata->base_price;   ?></h2>
            </div>
        </div>
    </div>
</section> 
<section class="trader-listing-detail-description view_created_page">
    <div class="container">
            <?php 
            if($this->session->flashdata('paymentsuccess') != ""){
            echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('paymentsuccess').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 

            if($this->session->flashdata('paymentfail') != ""){
            echo '<div><div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('paymentfail').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 

            ?>
        <?php if($this->session->flashdata('success')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('success'); ?><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
        <?php } ?>
        <?php 
     //print_r($descdata->status);
        if(!empty($selfpre)){ ?>
                <div class='join_yellow_cls'>You have bid in this discussion as Created.</div> 
        <?php } ?>
       
        <div class="trader-listing-detail-box attendee-complete create-attendee-complete view-detail-create-pending">

            <div class="discussionid-div">
                <h3>Discussion Id : #<?php echo str_pad($descdata->discussion_ID,6,"0",STR_PAD_LEFT); ?></h3>
                <?php  
                //owner and current user same and discussion date are < to current time
                // viewmorepaymentpopop <?php echo date('d F Y',strtotime($descdata->closing_date)); 
                if($this->session->userdata('userid') == $descdata->user_ID && $descdata->discussion_start_datetime > date("Y-m-d H:i:s")){   
                  ?>
                        <a href="<?php echo base_url(); ?>edit-discussion/<?php echo $descdata->discussion_ID; ?>" class="edit-btn"><i class="zmdi zmdi-edit"></i> edit</a>
                 <?php  if($descdata->closing_date >= date("Y-m-d") && $descdata->status==1){?>
                     <a href="javascript:void(0)" data-toggle="modal" data-target="#sendinvitationpopop" class="edit-btn"><i class="fa fa-envelope" aria-hidden="true"></i> Send Invitaion</a>
                 <?php } ?>
                <?php } ?>   
            </div>
            <!-- <div class="discussionid-div">
                <h3>Discussion Id : #<?php echo $descdata->discussion_ID; ?></h3>
                <a href="<?php echo base_url(); ?>edit-discussion/<?php echo $descdata->discussion_ID; ?>" class="edit-btn"><i class="zmdi zmdi-edit"></i> edit</a>
            </div> -->
            <div class="latest-discussion-box">
                <div class="latest-discussion-box-bg">
                    <div class="trader-listing-detail-box1">
                        <div class="presents-attendes-area">
                            <h3>Required Position:</h3>
                            <div class="presents-area-commen-cls">
                                <?php if($descdata->presenter == $descdata->require_presenter){
                                    $prcls = 'presenter-attende-green-button';
                                }else{
                                    $prcls = 'presents-area';
                                }
                                 ?>
                                <span class="<?php echo $prcls; ?> presents-circle-area">
                                <?php echo $descdata->presenter.'/'.$descdata->require_presenter; ?>
                                </span>
                                <span class="inner-txt">presenters</span>
                            </div>
                            <div class="presents-area-commen-cls attendes-area-cls">
                                <?php if($descdata->attendee == $descdata->require_attendee){
                                    $atcls = 'presenter-attende-green-button';
                                }else{
                                    $atcls = 'attendes-area';
                                }
                                 ?>
                                <span class="<?php echo $atcls;  ?>  presents-circle-area">
                                <?php echo $descdata->attendee.'/'.$descdata->require_attendee; ?>
                                </span>
                                <span class="inner-txt">attendees</span>
                            </div>
                        </div>
                        <div class="coordinator-description">
                            <div class="date-time-txt">
                                <div class="commen-box-cls">
                                    <h3 class="commen-tabelcell-box"><i class="fa fa-calendar" aria-hidden="true"></i> Date & Time</h3>
                                    <span class="commen-tabelcell-box"><?php echo ($descdata->discussion_start_datetime !=''?date('d F, Y | h:i a',strtotime($descdata->discussion_start_datetime)):''); ?></span>
                                </div>
                            </div>
                            <div class="inner-txt-title">
                                <div class="commen-box-cls">
                                    <h3 class="commen-tabelcell-box"><i class="fa fa-tag" aria-hidden="true"></i> Category</h3>
                                    <ul class="commen-tabelcell-box">
                                        <!-- <li><?php echo $descdata->category; ?></li>
                                        <?php if($descdata->subcategory !=''){ ?>
                                        <li><i class="fa fa-arrow-right" aria-hidden="true"></i> <?php echo $descdata->subcategory; ?></li>
                                        <?php } ?> -->
                                        <li>
                                            <div class="tooltip_div">
                                                <?php 
                                                    echo mb_strimwidth($descdata->category, 0, 9,"..");
                                                    if(strlen($descdata->category) > 9 ){
                                                    ?> <span class="tooltiptext"><?php echo $descdata->category; ?></span> 
                                                    <?php
                                                    }
                                                ?>
                                            </div>
                                        </li>
                                        <?php if($descdata->subcategory !=''){ ?>
                                        <li><i class="fa fa-arrow-right" aria-hidden="true"></i> 
                                            <div class="tooltip_div">
                                            <?php
                                                    echo mb_strimwidth($descdata->subcategory, 0, 9,"..");
                                                    if(strlen($descdata->subcategory) > 9 ){
                                                    ?> <span class="tooltiptext"><?php echo $descdata->subcategory; ?></span> 
                                                    <?php
                                                }
                                              ?>
                                            </div>
                                        </li>
                                         <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="age-group-txt">
                                <div class="commen-box-cls">
                                    <h3 class="commen-tabelcell-box"><i class="icon icon-icon-7"></i>Age group</h3>
                                    <span class="commen-tabelcell-box"><?php echo $descdata->agerange.' Year'; ?></span>
                                </div>
                            </div>
                            <div class="closing-date">
                                <div class="commen-box-cls">
                                    <h3 class="commen-tabelcell-box"><i class="fa fa-calendar" aria-hidden="true"></i> Closing Date</h3>
                                    <span class="commen-tabelcell-box"><?php echo date('d F Y',strtotime($descdata->closing_date)); ?></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="trader-listing-detail-box2">
                   
                    <div class="cancel_dis_cls owner_pay_nowdiv">
                    <?php
                    if($descdata->status ==1){
                        //if($descdata->attendee == $descdata->require_attendee && $selfpre->payment_status!=1){  
                       if($descdata->attendee == $descdata->require_attendee && $selfpre->payment_status!=1 && empty($paymentcheck)){  
                         $payam=($descdata->final_price)-($descdata->attendee_payamount);
                          
                         $payampercent=($payam*100)/$descdata->final_price;
                          ?>
                    <div class="payble_amt">
                        <span>Your Payable amount is </span><label> <?php echo round($payampercent).'%';?> ($<?php echo $payam;?>)</label>
	                </div>
                    <div class="view_more_pop">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#viewmorepaymentpopop"><i class="fa fa-eye"></i>View More</a>
	                </div>   
                        <?php if($payam > 0 ){ ?>  
                        <a href="javascript:void(0)" class="btn-bule-outline pay_now_blue" data-toggle="modal" data-target="#ownerpaymentpopop">Paynow</a>
                                
                        <?php } }
                        //if($selfpre->payment_status==1){  
                        //print_r($paymentcheck);
                        if((!empty($paymentcheck || $payam == 0) && $descdata->discussion_start_datetime < date("Y-m-d H:i:s") )){ 
                        ?>
                                <a href="<?php echo base_url(); ?>/Discussion/discussion_complete/<?php echo $descdata->discussion_ID; ?>" class="btn-bule-outline">Click Here to Complete Discussion</a>
                    <?php }
                        else{ ?>
                          <a href="#" class="btn-bule-outline approve-btn cancle_btn" data-toggle="modal" data-target="#cancl_dsc">cancel</a>
                            <div class="approve_popup cancle_ok_pop custom_popup">
                            <div class="dialog_custom_cls">
                            <div class="modal fade" id="cancl_dsc" role="dialog">
                              <div class="modal-dialog">
                                <div class="popup_middile">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Are you sure you want to cancel this discussion?</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="popup_btn_content">
                                        <a href="<?php echo base_url(); ?>Discussion/discussion_cancel/<?php echo $descdata->discussion_ID; ?>" class="btn-bule-outline pop_confirm_btn">ok</a>
                                        <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                            </div>
                    <?php } ?>
                        </div>
                        <?php }else if($descdata->status ==2){?>
                        <a href="javascript:void(0)" class="btn-bule-outline" >Close</a>

                        <?php }else if($descdata->status ==3){?>
                        <a href="javascript:void(0)" class="btn-bule-outline complete_own" >Completed</a>

                        <?php }else if($descdata->status ==4){?>
                        <a href="javascript:void(0)" class="btn-bule-outline" >Cancelled</a>

                        <?php } ?>

                        
                    </div>
                </div>
            </div>
        </div>
            <section class="trader-listing-detail-description">
            <?php if($this->session->userdata('userid') != $descdata->user_ID){ ?>
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
                            <?php  
                            if(!empty($skills)){ ?>
                                    <div class="col-sm-6">
                                        <h2>Skill Required</h2>
                                        <ul class="skill-require">
                                        <?php foreach ($skills as $skill) {
                                                echo "<li>".$skill->name."</li>";
                                            } ?>
                                        </ul>
                                    </div> 
                            <?php }  
                                 
                                if($descdata->attachement != null){ ?>
                                    <div class="col-sm-6">
                                        <h2>Documents</h2>
                                        <ul class="document-section">
                                            <?php
                                            $attachment = explode('|',$descdata->attachement);
                                            //print_r($attachment);
                                            foreach ($attachment as $att) {
                                               //$ext = pathinfo($filename, PATHINFO_EXTENSION); 
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
                </section>
        </div>
</section>  
 
<section class="trader-listing-detail-tabs create-attendee-complete-tabs maindiscussion_default_div">
    <div class="loader" style="display: none;"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div>
</section>
</div>

<script>

//-------------- load more data-----------
// $(window).on('load',function(){
//         $('#viewmorepaymentpopop').modal('show');
//     });
//$('#viewmorepaymentpopop').modal('show');
 jQuery(document).on("click",".loadpaymenddata",function(){

    //alert(1);
     $('.load_tr').remove();
     var trid = $(this).attr('data-id');
      var page = $(this).attr('id');
     var trclass=trid;
       if($('.load_tr').remove()){
        main_mypayment_dataload(2,trclass,page);
       }
     
   })
   
 

   
   </script>
<!-- ************** popop *********************-->  

<!-- popup for payament -->
      <div class="modal fade paynow-popup" id="ownerpaymentpopop" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                            <h4 class="modal-title">Pay <?php echo '$'.$payam; ?></h4>
                                        </div>
                                            <form id="owner_pay" class="bs-example" method="post" action="<?php echo base_url();?>Discussion/paymentforowner_discussion/<?php echo $descdata->discussion_ID;?>">
                                            <input type="hidden" name="amount" value="<?php echo $payam;?>">
                                            <input type="hidden" name="discussion_ID" value="<?php echo $descdata->discussion_ID;?>">
                                            
                                        <div class="modal-body">
                                            <div class="panel-group" id="pay_accordion">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                        <label for='r11' class="customradiobox">
                                                        <input type='radio' id='r11' name='payment_type' value='1'  checked/> Payment From Your <span><?php echo $wallet_ballance;?></span> E-market Points 
                                                        <input type="hidden" name="emarket_point" value="<?php echo $wallet_ballance; ?>">
                                                        <span class="customradiobox-inner"></span>
                                                        <a data-toggle="collapse" data-parent="#pay_accordion" href="#collapseOne"></a>
                                                        </label>
                                                        </h4>
                                                    </div>
                                                    
                                                </div>
                                                <div class="panel panel-default account-billing-section">
                                                    <div class="panel-heading">
                                                        <h4 class=panel-title>
                                                        <label for='r12' class="customradiobox">
                                                        <input type='radio' id='r12' name='payment_type' value='2'  />Payment From Credit Card
                                                        <span class="customradiobox-inner"></span>
                                                        <a data-toggle="collapse" data-parent="#pay_accordion" href="#collapseTwo"></a>
                                                        </label>
                                                        </h4>
                                                         
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                       
                                                        <ul class="btm_spcing">
                                                            <?php
                                                        if(empty($cards)){
                                                            ?>
                                                            <div class="billing_err">Please add billing method.</div>
                                                    <?php } ?>
                                                        <?php  $i=0;$chk=''; $k=0;
                                                        if(!empty($cards)){ 
                                                        foreach ($cards as $card) {  $k++;
                                                            $chk='';
                                                            
                                                        ?>
                                                            <li class="credit-card-section">
                                                                <label class="customradiobox">
                                                               
                                                                <input value="<?php echo $card->card_ID;?>" name="cardno" class="cardradio payradio" type="radio" data-cvv="<?php echo $card->cvc_number; ?>">
                                                                <span class="customradiobox-inner"></span>
                                                                xxxx xxxx xxxx <?php echo $card->card_last_degits; ?>
                                                                </label>
                                                                <?php if($card->card_name=='visa'){ ?>
                                                                <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png"></div>
                                                                    <?php }else if($card->card_name=='Mastercard'){ ?>
                                                                        <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img2.png"></div>
                                                                    <?php }else{ ?>
                                                                        <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png"></div>
                                                                    <?php } ?>
                                                                    <div class="form-group">
                                                                        <input type="text" id="cvvtxt<?php echo $k; ?>" name="cvvtxt<?php echo $card->card_ID; ?>" class="cvvtxt_cls input_text form-controlcls" placeholder="Enter Your CVV">
                                                                    </div>
                                                                </li>
                                                            <?php $i++;}}
                                                             ?>
                                                          
                                                        </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="blue-button">submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
<!-- end popup for payament -->


<!-- view more -->
<div class="modal fade paynow-popup view_more_popup" id="viewmorepaymentpopop" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Pay <?php echo '$'.$payam; ?></h4>
            </div>
                <form class="bs-example" method="post" action="<?php echo base_url();?>Discussion/paymentforowner_discussion/<?php echo $descdata->discussion_ID;?>">
                <input type="hidden" name="amount" value="<?php echo $payam;?>">
                <input type="hidden" name="discussion_ID" value="<?php echo $descdata->discussion_ID;?>">
                
            <div class="modal-body">
                <div class="panel-group" id="pay_accordion">
                    <div class="panel panel-default account-billing-section">
                        
                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="panel-body">
                           
                            <ul class="btm_spcing">
                            <?php  $payam=($descdata->final_price)-($descdata->attendee_payamount);
                            $payampercent=($payam*100)/$descdata->final_price;
                            ?>
                                <div class="payble_amt">
                                <span>Presenter Payble Price </span><label>:  $<?php echo $descdata->final_price;?></label>
                                </div>
                                <div class="payble_amt">
                                <span>Attendee Paid Price </span><label>: $<?php echo round($descdata->attendee_payamount);?></label>
                                </div>
                                <div class="payble_amt">
                                <span>Your Payable amount is </span><label>: $<?php echo round($payam);?></label>
                                </div>
                            <label class="customradiobox">
                            </label>
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

<!-- send invitation -->
<div class="modal fade paynow-popup view_more_popup" id="sendinvitationpopop" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Send Invitation</h4>
            </div>
                <form class="bs-example" method="post" action="<?php echo base_url();?>Discussion/sendinvitation" id="sendinvitationfrm">
                <input type="hidden" name="did" value="<?php echo $descdata->discussion_ID;?>">
                <input type="hidden" name="discussion_title" value="<?php echo $descdata->discussion_title;?>">
                
            <div class="modal-body">
                <div class="panel-group" id="pay_accordion">
                    <div class="panel panel-default account-billing-section">
                        
                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="panel-body">
                           
                            <ul class="btm_spcing">
                           <div class="payble_amt">
                                <span>User <b>:</b></span><label>  <select name="intuser" class="form-control">
                                    <option value="">Select User</option>
                                <?php foreach ($getALLuser as $keyvalue) {?>
                                    <option value="<?php echo $keyvalue->user_ID;?>"><?php echo $keyvalue->first_name;?>  <?php echo $keyvalue->last_name;?></option>
                                <?php } ?>
                                </select></label>
                                </div>
                                <div class="payble_amt">
                                <span>Invitation As <b>:</b></span><label><select name="user_Type" class="form-control">  
                                     <option value="">Select User Type</option>
                                    <option value="1">Presenter</option>
                                    <option value="2">Attendee</option>
                                </select>   </label>
                                </div>
                            </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="blue-button" name="sendinvitation">Send</button>
                        </div>
                    </div>

                </div>
               
            </div>
           
            </form>
        </div>
    </div>
</div>