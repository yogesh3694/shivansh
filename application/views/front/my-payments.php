 <div class="main">
        <div class="bradcume-section">
            <div class="container">
                <div class="row">
                    <h2>My Payments</h2>
                </div>
            </div>
 
        </div>
        <div class="container">
        <?php 
            if($this->session->flashdata('paymentsuccess') != ""){
                  echo '<div class="alert-success alert alert-dismissible">'.$this->session->flashdata('paymentsuccess').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'; } 
            
                  if($this->session->flashdata('paymentsfail') != ""){
                    echo '<div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('paymentsfail').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'; } 
              
            ?>
            <div class="trader-listing-detail-box payment-box">
               <div class="col-md-4 col-sm-4 payment-col1">
                    <div class="emarket-balance">
                        <span> <?php setlocale(LC_MONETARY, 'en_IN');  echo ($wallet_balance)?money_format('%!.0n',$wallet_balance):'0';?></span>
                        <p>Your E-Market Points Balance</p>
                    </div>
             </div>

                <div class="col-md-4 col-sm-4 payment-col2">
                    <input name="market_point" class="form-controlcls" type="number" id="market_point">
                </div>
                <div class="col-md-4 col-sm-4 payment-col3">
                    <button type="submit" class="blue-button" id="add_emarket_btn">Add E-Market Points</button>
                </div>
            </div>
        </div>
    <div class="attended-discssion-entrie-section account-payment-section">
            <div class="container">
               <div class="">
                    <table class="table wallet_table" id="table">
                        <thead>
                            <tr>
                                <th>title</th>
                                <th>withdrawal</th>
                                <th>deposit</th>
                                <th>status</th>
                                <th>date & time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="paymentdata_append"></tr>
                        </tbody>
                       </table>
                    
                </div>
                
            </div>
        </div>  

    </div>
      <!-- popup for payament -->
        <div class="modal fade paynow-popup" id="addmarketpoint_paymentpopop" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                            <h4 class="modal-title">Add <?php echo '$<span id="empoint"></span>'; ?></h4>
                                        </div>
                                            <form id="my_pay" class="bs-example" method="post" action="<?php echo base_url();?>User_Main/add_emarket_pointtowallet">
                                        <div class="modal-body">
                                            <div class="panel-group" id="pay_accordion">
                                               <input type="hidden" name="dollar_point" id="dollar_point" value="<?php echo $dollar_point;?>">
                                               <input type="hidden" name="emarket_point" id="emarket_point" value="">
                                               <input type="hidden" name="amount" value="" id="amount">
                                               
                                                 <div class="panel panel-default account-billing-section">
                                                    <div class="panel-heading">
                                                        <h4 class=panel-title>

                                                        <label for='r12' class="customradiobox">
                                                        <input type='radio' id='r12' name='payment_type' value='2'  checked/>Payment From Credit Card
                                                        <span class="customradiobox-inner"></span>
                                                        <a data-toggle="collapse" data-parent="#pay_accordion" href="#collapseTwo"></a>
                                                        
                                                        </label>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse collapse in">
                                                        <div class="panel-body">
                                                        <?php
                                                        if(empty($cards)){
                                                            ?>
                                                            <div class="billing_err">Please add billing method.</div>
                                                    <?php } ?>
                                                       
                                                        <ul class="btm_spcing">
                                                        <?php 
                                                        $btnstatusval=''; $k=0;
                                                        if($cards){ $i=0;
                                                        foreach ($cards as $card) { $k++;
                                                            $chk='';
                                                            if($i==0){
                                                                $chk="checked";
                                                            }
                                                        ?>
                                                            <li class="credit-card-section">
                                                                <label class="customradiobox">
                                                               
                                                                <input value="<?php echo $card->card_ID;?>" name="cardno" class="payradio" type="radio" data-cvv="<?php echo $card->cvc_number; ?>">
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
                                                            <?php $i++; }}else{ $btnstatusval="disabled='disabled'";?>
                                                                 
                                                            <?php } ?>
                                                          
                                                        </ul>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="blue-button" <?php echo $btnstatusval;?>>submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                 </div>
                                </div>
                                <!-- end popup for payament -->
 <script>
$('#add_emarket_btn').click(function(){
     $('.error').remove();
    var point=$('#market_point').val();
    if(point!=''){
        if(point > 0){
        $('#addmarketpoint_paymentpopop').modal('show');
        }else{
        $('#market_point').after('<label id="market_point-error" class="error" for="market_point">Please enter E-market point greater than 0.</label>');
        }
    }else{
        $('#market_point').after('<label id="market_point-error" class="error" for="market_point">Please enter E-market point.</label>');
    }
})
 $('#market_point').focusout(function() {
     
    $('.error').remove();
    var dollar_point=$('#dollar_point').val();
    var point=$('#market_point').val();
    var dollar_val=(point/dollar_point);


$('#amount').val(dollar_val);
$('#emarket_point').val(point);
$('#empoint').replaceWith('<span id="empoint">'+dollar_val+'</span>');
});
 jQuery(document).ready(function(){

    $("#market_point").keypress(function (e) { 
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $('#market_point-error').remove();
            $('#market_point').after('<label id="market_point-error" class="error" for="market_point">Please enter valid E-market point.</label>');
             
        }
   });
<?php if($totalmpoint == ''){ $totalmpoint2 = '0'; }else{ $totalmpoint2 = $totalmpoint; } ?>
var maxpoint = <?php echo $totalmpoint2 ?>;
$('#withdrow_form').validate({
    rules: {
        withdrow: {
          required:true,
          max:maxpoint
        }, 
    },
    messages: {
        withdrow: {
          required:"Please enter amount.",
          max:"Please enter no more then "+maxpoint+" points."
        },
    },      
}); 
/*----------------- payment popoup ------------------------------- */
    $('#my_pay').validate({
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
            remote:"Please enter valid cvv.",
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


});

jQuery(window).bind("load", function() {
    $('.loding').show();
    main_mypayment_dataload(1);

});

//-------------- load more data-----------
 jQuery(document).on("click",".loadpaymenddata",function(){
    //alert(1);
     $('.load_tr').remove();
     var trid = $(this).attr('data-id');
      var page = $(this).attr('id');
     var trclass=trid;
       if($('.load_tr').remove()){
        main_mypayment_dataload(2,trclass,page,'ASC');
       }
     
   })

function main_mypayment_dataload(loadval,loadmore,page,order){
   $('.load_tr').remove();
  if(loadval==1){
var ajx='defaultmy_paymentsloaddata';
  }else{
var ajx='ajaxmy_paymentsloaddata';
  }
    $.ajax({
        type:'POST',
        url:"<?php echo base_url().'User_Main/' ?>"+ajx,
        data:{ loadval:loadval,loadmore:loadmore,current_page:page,order:order},
        success:function(html){  
          
          if(loadval==1){

                $('.paymentdata_append').replaceWith(html);
                $('.loding').hide();

            }else{
            
              
             $('.load_tr').remove();
                $('.'+loadmore).after(html);
                $('.loding').hide();
                 
            }
     }
    });
 }

 
 </script>                              