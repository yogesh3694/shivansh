<?php //echo "<pre>"; print_r($descdata); ?>
<!-- <script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js" type="text/javascript"></script> -->
<style type="text/css">
fieldset, label { margin: 0; padding: 0; }
/*body{ margin: 20px; }*/
h1 { font-size: 1.5em; margin: 10px; display:block; }

/****** Style Star Rating Widget *****/

.rating { 
border: none;
float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
margin: 5px;
font-size: 1.25em;
font-family: FontAwesome;
display: inline-block;
content: "\f005";
}

.rating > .half:before { 
content: "\f089";
position: absolute;
}

.rating > label { 
color: #ddd; 
float: right; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } 
/*        hover previous stars in list */

.rating > input:checked + label:hover,
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, 
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  }
</style>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js"></script>
 
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

    $('#att_payform').validate({
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

/*----------------- feedback popoup -------------------------- */
    jQuery('#feedback_form').validate({
        ignore: [],
        errorPlacement: function(error, element) {
            if(element.attr('type') == "radio"){
                 
                element.parent().parent().after(error);
                //jQuery('.input_submit').after(error);;
            }
            else {
                error.insertAfter(element);
            } 
        },
    });
    jQuery('.input_textarea').each(function() {
    jQuery(this).rules("add",{
            required: true,
            messages: {
                required: "Please enter your review.",
            }
        });
    });
 /*----------------- end feedback popoup -------------------------- */

/*----------------- payment popoup ------------------------------- */
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

$('#pr_accept').on('click', function(){ 
    $('.loding').show();
    var pre = $(this).attr('data-pre'),req = $(this).attr('data-req'),didid = $('#did_hidden').val();
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'Discussion/pre_accept' ?>",
        data:{ presenter:pre,requirement:req,did:didid },
        success:function(html){  
            $('.loding').hide();
            data = jQuery.parseJSON(html);
            if(data.res == 'yes'){
                window.location = data.url;
            }
            else{
                $("#acceptclick").trigger('click');
            }
        }
      
    });
});
$('#paymentclick').on('click', function(){ 
    $('.loding').show();
    var didid2 = <?php echo $descdata->discussion_ID; ?>;
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'Discussion/attendee_count_check' ?>",
        data:{did:didid2 },
        success:function(html){  
            $('.loding').hide();
            data = jQuery.parseJSON(html);
            if(data.res == 'yes'){
                 
                $("#paymentclickopen").trigger('click');
            }
            else{
                $("#acceptclickat").trigger('click');
            }
        }
      
    });
});


//feedback popoup accordian
$( "#pop_accordion" ).accordion({
                   heightStyle: "content",
                 });
//feedback star
      
 $('.bidform').validate({
    rules: {
        bidamount:{
            required:true,
            number:true,
            max:<?php echo $descdata->base_price; ?> 
        },
    },
    messages: {
        bidamount:{
            required:"Please enter bid amount.",
            max:"Please enter a value less than or equal to $<?php echo $descdata->base_price; ?>"

            },
    },
     errorPlacement: function(error, element) {
        if(element.attr('name') == "bidamount"){
            //element.next().append(error);
            jQuery('.input_submit').after(error);//.append(error);
        }
        else {
            error.insertAfter(element);
        }
    }, 
 });
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
     
     //remove max rules from attendee bid.
    $('#attpopoup').on('show.bs.modal', function (event) {
       $( ".attbidtxt" ).rules( "remove", "max" );
       $( ".attbidtxt" ).rules( "add", {
          max: 100,
           messages: {
            max: "Please enter a value less than or equal to 100%"
          }
        });
    });
     
});
 function maindiscussionfunction(ID,dis,joinas){
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'User_Discussion/view_discussion' ?>",
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
 
<div class="main">
<section class="custom-breadcrumbs-section">
    <div class="container">
        <div class="custom-breadcrumbs-content">
            <div class="custom-breadcrumbs-title">
                <h2><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="icon icon-icon-2"></i></a> <?php echo $descdata->discussion_title; ?></h2>
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
    <?php if($userjoin->join_as != '' && $userjoin->join_as == '1'){ ?>
                <div class='join_yellow_cls'>You have bid in this discussion as Attendee.</div> 
    <?php } ?>
        <?php if($this->session->flashdata('bidsuccess')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('bidsuccess'); ?><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
        <?php } 
         if($this->session->flashdata('paymentfail')){ ?>
            <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('paymentfail'); ?><a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
        <?php } ?>


        
        <div class="trader-listing-detail-box attendee-complete create-attendee-complete view-detail-create-pending">

            <?php
                if(!empty($userjoin)){
                ?>
                    <div class="discussionid-div">
                        <h3>Discussion Id : #<?php echo str_pad($descdata->discussion_ID,6,"0",STR_PAD_LEFT); ?></h3>
                        <?php  
                            if($this->session->userdata('userid') == $descdata->user_ID){ ?>
                                <a href="<?php echo base_url(); ?>edit-discussion/<?php echo $descdata->discussion_ID; ?>" class="edit-btn"><i class="zmdi zmdi-edit"></i> edit</a>
                        <?php } ?>   
                    </div>
                <?php
                }
             ?>
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
                                <span class="presents-circle-area <?php echo $prcls; ?>">
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
                                <span class="presents-circle-area <?php echo $atcls; ?>">
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
                                    <span class="commen-tabelcell-box"><?php echo date('d F, Y',strtotime($descdata->closing_date)); ?></span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="trader-listing-detail-box2">
                    <?php  
                    if(!empty($userjoin) && $userjoin->approve_status == '2')
                    {
                            if($userjoin->join_as == '1')
                            { 
                                $doller = ($descdata->final_price / 100) * $userjoin->bid;
                                ?>
                                <div class="rebid_cls">                                   
                                    <div class="mybid-percentage"><p>My Bid <span><?php echo $userjoin->bid ?>% ($<?php echo $doller; ?>)</span></p></div>
                                    <a href="#" class="blue-button sky-blue-button" data-toggle="modal" data-target="#attpopoup">rebid for discussion</a>
                                </div>
                                <?php 
                            }
                            else
                            {   ?>
                                <div class="rebid_cls">
                                    <div class="mybid-percentage "><p>My Bid <span>$<?php echo $userjoin->bid ?></span></p></div>
                                    <a href="#" class="blue-button orangr-button" data-toggle="modal" data-target="#prepopoup">rebid for discussion</a>
                                </div>
                                <?php 
                            } 
                    }
                    else
                    { 
                        if(!empty($userjoin) && $userjoin->approve_status == '1')
                        {
                            if($userjoin->join_as == '2')
                            {
                                if($userjoin->pre_accept == '1')//accept
                                {     
                                    ?>
                                    <div class="pre_thanks">
	                                    <div class="message-success">
	                                        <span><i class="fa fa-check" aria-hidden="true"></i></span>
                                            <?php
                                            if($descdata->discussion_start_datetime < date("Y-m-d H:i:s")){
                                                ?>Thanks! Your Discussion is Completed.<?php
                                            }
                                            else{
                                                ?>Thanks! Your bid is Complete.<?php
                                            }
                                            ?>
	                                    </div>
	                                    <div class="rebid_cls">
	                                    <div class="mybid-percentage"><p>My Bid <span>$<?php echo $userjoin->bid; ?></span></p></div> 
	                                    </div>
                                	</div>
                                    <?php
                                }
                                elseif($userjoin->pre_accept == '2')//decline 
                                {
                                    ?>
                                    <div class="rebid_cls">
                                        <div class="mybid-percentage "><p>My Bid <span>$<?php echo $userjoin->bid ?></span></p></div>
                                        <a href="#" class="blue-button orangr-button" data-toggle="modal" data-target="#prepopoup">rebid for discussion</a>
                                    </div>
                                    <?php
                                }
                                else //null
                                {   
                                    ?>
                                   <div class="pre_congo_msg_cls">
                                        <div class="message-success">
                                            <span><i class="fa fa-check" aria-hidden="true"></i></span>Congratulations! Your bid is approved.
                                        </div>
                                        <div class="mybid-percentage"><p>My Bid <span>$<?php echo $userjoin->bid; ?></span></p></div> 
                                        <!-- <?php echo base_url(); ?>Discussion/pre_accept/<?php echo $descdata->discussion_ID; ?> -->
                                        <input type="hidden" name="did_hidden" id="did_hidden" value="<?php echo $descdata->discussion_ID; ?>">
                                        <a href="javascript:void(0)" id="pr_accept" data-pre="<?php echo $descdata->presenter; ?>" data-req="<?php echo $descdata->require_presenter; ?>" class="btn-green-outline">Accept</a> 
                                         
                                        <!-- <a href="<?php echo base_url(); ?>Discussion/pre_decline/<?php echo $descdata->discussion_ID; ?>" class="btn-red-outline" onclick="return confirm('Are you sure you want to decline this bid approve request?')">Decline</a> -->
                                        <a href="#" class="btn-red-outline" data-toggle="modal" data-target="#pre_dsclin">Decline</a>
                                         
                                          <a href="javascript:void(0)" id="acceptclick" data-toggle="modal" data-target="#acceptpopup"></a>
                                        <div class="approve_popup custom_popup">
                                            <div class="dialog_custom_cls">
                                              <div class="modal fade" id="acceptpopup" role="dialog">
                                                <div class="modal-dialog">
                                                  <div class="popup_middile">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Accept Request</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                            <div class="popup_text">
                                                                <p>Sorry.. all presenters are approved for this discussion.</p>  
                                                            </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="approve_popup cancle_ok_pop custom_popup">
                                          <div class="dialog_custom_cls">
                                            <div class="modal fade" id="pre_dsclin" role="dialog">
                                              <div class="modal-dialog">
                                                <div class="popup_middile">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Are you sure you want to decline this bid approve request?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                      <div class="popup_btn_content">
                                                        <a href="<?php echo base_url(); ?>Discussion/pre_decline/<?php echo $descdata->discussion_ID; ?>" class="btn-bule-outline pop_confirm_btn">Confirm</a>
                                                        <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    <?php
                                }
                                ?>
                            <?php
                            }
                            else
                            { 
                                $doller3 = ($descdata->final_price / 100) * $userjoin->bid; ?>

                                <?php 
                                if($userjoin->payment_status == '1'){
                                    if($descdata->status == '3' && $descdata->discussion_start_datetime < date("Y-m-d H:i:s") && empty($attfeedback))
                                    { 
                                    ?>
                                        <div class="message-success">
                                            <span><i class="fa fa-check" aria-hidden="true"></i></span>Thanks! Your Discussion is Completed.
                                        </div>
                                        <div class="rebid_cls">
                                        <div class="mybid-percentage"><p>My Bid <span><?php echo $userjoin->bid; ?>% (<?php echo '$'.$doller3; ?>)</span></p></div>
                                            <a href="javascript:void(0)" class="blue-button" data-toggle="modal" data-target="#feedbackpopop">Give Feedback</a>
                                            <div class="feedback_popup custom_popup">
                                              <div class="modal fade" id="feedbackpopop" role="dialog">
                                                <div class="modal-dialog">
                                                  <div class="popup_middile">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"></button>
                                                        <h4 class="modal-title">Give Feedback</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <div class="feedback_text_msg">
                                                          Your feedback is important to us. The rating will relate to the amount pay to the presenter. Please do it wisely. Thanks for your support.
                                                        </div>
                                                        <form id="feedback_form" action="<?php echo base_url() ?>Discussion/feedback_submit" method="post">
                                                        <input type="hidden" name="discid" value="<?php echo $descdata->discussion_ID; ?>">   
                                                        <div id="pop_accordion" class="uia-feedback">
                                                        <?php 
                                                        //$i= 0;
                                                        foreach ($pre_feedback as $pre) { //$i++;
                                                            $i = $pre->user_ID;
                                                        ?>
                                                            <div class="ui-accordion-header">
                                                        <script type="text/javascript">
                                                            $(function(){
                                                                $("input[id*=star5_<?php echo $i; ?>]").rules("add", {
                                                                        required: true,
                                                                        messages: {
                                                                           required: "Please select rating.",
                                                                        },
                                                                        /*errorPlacement: function(error, element) {
                                                                                jQuery('.rating').after(element);
                                                                        } */
                                                                    });
                                                             
                                                            });
                                                        </script>
                                                            <div class="circle-img-main-div">
                                                            <?php 
                                                                if($pre->profile_photo != ''){
                                                                    $image_path_pr = base_url('upload/profile/' . $pre->profile_photo);
                                                                    $thumb_path_pr = preg_replace('~\.(?!.*\.)~', '-46x46.', $image_path_pr);
                                                                    ini_set('allow_url_fopen', true);
                                                                    if (getimagesize($thumb_path_pr)) { $userimg = $thumb_path_pr; }
                                                                ?>
                                                                    <img src="<?php echo $userimg; ?>">
                                                                <?php
                                                                }
                                                                else{
                                                                ?>
                                                                    <img src="<?php echo base_url() ?>assets/images/none-user-46x46.jpg" />
                                                                <?php
                                                                }
                                                             ?>
                                                            </div>
                                                            <div class="feedback-user-title"><?php echo $pre->virtual_name; ?></div>
                                                            <input type="hidden" name="presenter[]" value="<?php echo $pre->user_ID; ?>">  
                                                            </div>
                                                            <div class="ui-accordion-content">
                                                              <div class="form_group">
                                                                <div class="rating-title">rating</div>
                                                                    
                                                            <fieldset class="rating">
                                                                <input type="radio" id="star5_<?php echo $i; ?>" name="rating_<?php echo $i; ?>" value="5" /><label class = "full" for="star5_<?php echo $i; ?>" title="Awesome - 5 stars"></label>
                                                             
                                                                <input type="radio" id="star4_<?php echo $i; ?>" name="rating_<?php echo $i; ?>" value="4" /><label class = "full" for="star4_<?php echo $i; ?>" title="Pretty good - 4 stars"></label>

                                                                
                                                                <input type="radio" id="star3_<?php echo $i; ?>" name="rating_<?php echo $i; ?>" value="3" /><label class = "full" for="star3_<?php echo $i; ?>" title="Meh - 3 stars"></label>

                                                               
                                                                <input type="radio" id="star2_<?php echo $i; ?>" name="rating_<?php echo $i; ?>" value="2" /><label class = "full" for="star2_<?php echo $i; ?>" title="Kinda bad - 2 stars"></label>

                                                              
                                                                <input type="radio" id="star1_<?php echo $i; ?>" name="rating_<?php echo $i; ?>" value="1" /><label class = "full" for="star1_<?php echo $i; ?>" title="Sucks big time - 1 star"></label>
                                                            </fieldset>
															 </div>
															<div class="form_group">
															    <div class="rating-title">Your Review</div>
															    <textarea  name="feedback_<?php echo $i; ?>" class="input_textarea"></textarea>
															</div>
															</div>
                                                        <?php } ?>   
                                                        </div>
                                                          <div class="popup_btn_content">
                                                              <button type="submit" name="feedback_submit" class="btn-bule-outline">submit</button>
                                                          </div>
                                                    </form>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="pre_thanks">
                                            <div class="message-success">
                                                <span><i class="fa fa-check" aria-hidden="true"></i></span>
                                            <?php if(!empty($attfeedback)){
                                                    ?>
                                                        Thanks! Your Discussion is Completed.
                                                    <?php
                                                    }
                                                    else{
                                                    ?>
                                                        Thanks! Your bid is Complete.
                                                    <?php
                                                    }
                                            ?>   
                                            </div>
                                            <div class="rebid_cls">
                                            <div class="mybid-percentage"><p>My Bid <span><?php echo $userjoin->bid; ?>% (<?php echo '$'.$doller3; ?>)</span></p></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                        <div class="message-success">
                                            <span><i class="fa fa-check" aria-hidden="true"></i></span>Congratulations! Your bid is approved.
                                        </div>
                                        <div class="rebid_cls">
                                        <div class="mybid-percentage"><p>My Bid <span><?php echo $userjoin->bid; ?>% (<?php echo '$'.$doller3; ?>)</span></p></div>
                                        <?php if($descdata->status != '4'){
                                            ?>
                                                <a href="javascript:void(0)" class="blue-button sky-blue-button" id="paymentclick" >Payment for Bid</a>
                                                
                                                <a href="javascript:void(0)" id="paymentclickopen" data-toggle="modal" data-target="#paymentpopop"></a>
                                                <a href="javascript:void(0)" id="acceptclickat" data-toggle="modal" data-target="#acceptpopupat"></a>
                                        <div class="approve_popup custom_popup">
                                            <div class="dialog_custom_cls">
                                              <div class="modal fade" id="acceptpopupat" role="dialog">
                                                <div class="modal-dialog">
                                                  <div class="popup_middile">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Payment For Bid</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                            <div class="popup_text">
                                                                <p>Sorry.. all attendees are approved for this discussion.</p>  
                                                            </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                            <?php
                                        } ?>    

                                    	</div>
                                    <?php
                                }
                                ?>

                              <!-- popup for payament -->
                              <div class="pay_pop_main">
                                <div class="modal fade paynow-popup" id="paymentpopop" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                            <h4 class="modal-title">Pay <?php echo '$'.$doller3; ?></h4>
                                        </div>
                                        <script type="text/javascript">
                                            
                                        </script>
                                             <form id="att_payform" class="bs-example" method="post" action="<?php echo base_url();?>Discussion/paymentforbid/<?php echo $descdata->discussion_ID;?>">  
                                            <!-- <form id="att_payform" class="bs-example" method="post" action="<?php echo base_url();?>"> -->
                                        <div class="modal-body">
                                            <div class="panel-group" id="pay_accordion">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                        <label for='r11' class="customradiobox">
                                                        <input type='radio' id='r11' name='payment_type' value='1'  checked/> Payment From Your <span><?php echo $market_point;?></span> E-market Points
                                                        <input type="hidden" name="emarket_point" value="<?php echo $market_point; ?>">
                                                        <input type="hidden" name="amount" value="<?php echo $doller3;?>">
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
                                                        <?php
                                                        if(empty($cards)){ 
                                                            ?>
                                                            <div class="billing_err">Please add billing method.</div>
                                                    <?php } ?>
                                                         
                                                        <ul class="btm_spcing">
                                                        <?php  $i=0;$chk=''; $k=0;  
                                                        if(!empty($cards)){ 
                                                        foreach ($cards as $card) {  $k++;
                                                            $chk='';
                                                            if($i==0){
                                                                $chk="checked";
                                                            }
                                                        ?>
                                                        <input type="hidden" name="card_count" id="card_count" value="yes">
                                                            <li class="credit-card-section">
                                                                <label class="customradiobox">
                                                                <input type="hidden" name="amount" value="<?php echo $doller3;?>">
                                                                <input name="cardno" type="radio" class="payradio" value="<?php echo $card->card_ID;?>" data-cvv="<?php echo $card->cvc_number; ?>" >
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
                                                            <?php $i++; }
                                                            }
                                                             ?>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="pay_submit" class="btn btn-default blue-button">submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                </div>
                                <!-- end popup for payament -->
                                <?php
                            }
                        }
                        else
                        { 
                        	/*if($this->session->userdata('userid') == $descdata->user_ID){ 
                        		?>
                        		<div class="cancel_dis_cls">
			                        <a href="<?php echo base_url(); ?>/Discussion/discussion_cancel/<?php echo $descdata->discussion_ID; ?>" class="btn-bule-outline" onclick="return confirm('Are you sure cancel Discussion?')">cancel</a>
			                    </div>
                        		<?php
                        	}
                        	else
                        	{*/
                        	 	?>
	                            <div class="bid_pre_attnd_btn">
	                                <a href="#" class="blue-button orangr-button" data-toggle="modal" data-target="#prepopoup">BID AS PRESENTER</a>
	                                <a href="#" class="blue-button sky-blue-button" data-toggle="modal" data-target="#attpopoup">BID AS ATTENDEE</a>
	                            </div>
	                        	<?php 
                        	//}
                        }  
                    }  
                    ?>
                        <div class="rebid_disc_popup custom_popup">
                          <div class="modal fade" id="prepopoup" role="dialog">
                            <div class="modal-dialog">
                              <div class="popup_middile">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">
                                        <?php
                                            if(!empty($userjoin) && $userjoin->approve_status != '1'){
                                                echo "Rebid For Discussion";
                                            }else{
                                                echo "Bid As Presenter";
                                            } 
                                         ?> 
                                    </h4>
                                  </div>
                                  <div class="modal-body">
                                    <?php
                                    if($descdata->user_ID == $this->session->userdata('userid')):
                                        ?>
                                        <div class="popup_text">
                                            <p>Discussion owner can place bid on edit discussion page.</p>  
                                        </div>
                                        <?php
                                    else:
                                                                               
                                    if($descdata->presenter == $descdata->require_presenter){
                                        ?>
                                        <div class="popup_text">
                                            <p>All Presenter are approved for this discussion.</p>  
                                        </div>
                                        <?php
                                    } 
                                    else
                                    {
                                        if($descdata->status=='1' && $descdata->closing_date >= date('Y-m-d') )
                                        {
                                        ?>
                                        <div class="popup_text">
                                            <p>Total payable amount for this discussion is <b>$<?php echo $descdata->base_price; ?></b>. Now if you are interest in this discussion then you can bid for this discussion as presenter.</p>
                                         
                                            <?php
                                            if(!empty($userjoin) && $userjoin->approve_status == '2'){ ?>
                                                    <span>Your Last Bid is $<?php echo $userjoin->bid; ?>.</span>
                                         
                                            <?php } ?>
                                        </div>
                                        <div class="popup_form">
                                        <form id="bidform" class="bidform" action="<?php echo base_url(); ?>Discussion/bid/<?php echo $descdata->discussion_ID; ?>" method="post">
                                            <div class="form_group">
                                              <label>Your Bid ($)</label>
                                              <input name="bidamount" class="input_text" value="" type="number" id="prbid"  onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
                                              <?php echo form_error('bidamount');?>
                                              <input type="hidden" name="bidtype" class="input_text" value="2" />
                                              <input type="hidden" name="joinas" class="input_text" value="2" />
                                              <input type="submit" class="input_submit" value="submit">
                                            </div>
                                        </form>
                                        </div>
                                        <?php
                                        }
                                        elseif($descdata->status=='4'){
                                            ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is canclled.</p>
                                            </div>
                                            <?php   
                                        }
                                        elseif($descdata->status=='3'){
                                            ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is completed.</p>
                                            </div>
                                            <?php   
                                        }
                                        else{ ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is closed.</p>
                                            </div>
                                            <?php
                                        }
                                    }
                                    endif; 
                                    ?>    
                                    </div>
                                  </div>
                               </div>
                             </div>
                          </div>
                        </div>
                        <div class="approve_popup custom_popup">
                            <div class="modal fade" id="attpopoup" role="dialog">
                                <div class="modal-dialog">
                                  <div class="popup_middile">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">
                                        <?php
                                            if(!empty($userjoin) && $userjoin->approve_status != '1'){
                                                echo "Rebid For Discussion";
                                            }else{
                                                echo "Bid As Attendee";
                                            } 
                                        ?> 
                                        </h4>
                                       </div>
                                      <div class="modal-body">
                                        <?php
                                        if($descdata->user_ID == $this->session->userdata('userid')):
                                        ?>
                                        <div class="popup_text">
                                            <p>Discussion owner can not place bid as attendee on his own discussion.</p>  
                                        </div>
                                        <?php
                                        else:
                                        if($descdata->status=='1' && $descdata->closing_date >= date('Y-m-d') )
                                        {
                                            if($descdata->attendee == $descdata->require_attendee)
                                            {   ?>
                                                <div class="popup_text">
                                                  <p>All Attendee are approved for this discussion.</p>  
                                                </div>
                                                <?php
                                            } 
                                            elseif ($descdata->presenter != $descdata->require_presenter)
                                            {   ?>
                                                <div class="popup_text">
                                                  <p>You are not able to bid in this discussion till finalize the presenters.</p>  
                                                </div>
                                                <?php
                                            }
                                            else
                                            {   ?>
                                                <div class="popup_text">
                                                    <p>Total payable amount for this discussion is <b>$<?php echo $descdata->final_price; ?></b>. Now if you are interest in this discussion then you can contribute in percentage of total amount for this discussion as attendee.</p>
                                                    <?php  
                                                        if(!empty($userjoin) && $userjoin->approve_status == '2'){ 
                                                            $dlr = ($descdata->final_price / 100) * $userjoin->bid;
                                                        ?>
                                                        <span>Your Last Bid is <?php echo $userjoin->bid; ?>% (<?php echo '$'.$dlr; ?>).</span>
                                                    <?php } ?>
                                                </div>
                                                <div class="popup_form">
                                                    <form class="bidform" action="<?php echo base_url(); ?>Discussion/bid/<?php echo $descdata->discussion_ID; ?>" method="post">
                                                        <div class="form_group">
                                                          <label>Your Bid (%)</label>
                                                          <input name="bidamount" class="input_text attbidtxt" value="" type="number" id="atbid"  onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57">
                                                          <?php echo form_error('bidamount');?>
                                                          <input type="hidden" name="bidtype" class="input_text" value="1" />
                                                          <input type="hidden" name="joinas" class="input_text" value="1" />
                                                          <input type="submit" class="input_submit" value="submit">
                                                        </div>
                                                    </form>
                                                </div>       
                                                <?php 
                                            }
                                        }
                                        elseif($descdata->status=='4'){
                                            ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is Canclled.</p>
                                            </div>
                                            <?php   
                                        }
                                        elseif($descdata->status=='3'){
                                            ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is Completed.</p>
                                            </div>
                                            <?php   
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="popup_text">
                                                <p>Sorry.. this Discussion is Close.</p>
                                            </div>
                                            <?php
                                        }
                                    endif;
                                        ?>    
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- close box2 -->
                </div>
            </div>
        </div>
           
<div class="loding loader" style="display: none;"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div>
<?php if($this->session->userdata('userid') != $descdata->user_ID){ ?>
<section class="trader-listing-detail-description">
            <div id="section-3">
                <h1 class="accordion-tab-title"> Discussion Details</h1>
            <?php if($descdata->requirment_detail != ''){ ?>
                <div class="trader-content-description">
                    <p>
                        <?php echo $descdata->requirment_detail; ?>
                    </p>
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
        </section>
            <?php } ?>
        </div>
</section>  
<section class="trader-listing-detail-tabs create-attendee-complete-tabs maindiscussion_default_div">
    <div class="loader" style="display: none;"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div>
</section>
</div>

<!-- ************** popop *********************-->  
