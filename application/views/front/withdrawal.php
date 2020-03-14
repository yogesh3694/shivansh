<script src="<?php echo base_url('assets/front/js/additional-methods.min.js'); ?>" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js"></script>
<script type="text/javascript">
$(function(){

var $accordionTabs = $('.accordion-tabs');
            $accordionTabs.accordionTabs({ mediaQuery: '(min-width: 40em)' }, 
            {header: 'h1', heightStyle: 'content'}, 
            { show: {effect: 'fade'}
        }); 
 
//$( "#tabs" ).tabs();
<?php if($totalmpoint == ''){ $totalmpoint2 = '0'; }else{ $totalmpoint2 = $totalmpoint; } ?>
var maxpoint = <?php echo $totalmpoint2 ?>;
 $('#withdrow_form').validate({
    rules: {
        withdrow: {
          required:true,
          max:maxpoint
        }, 
        method: { required:true }, 
    },
    messages: {
        withdrow: {
          required:"Please enter amount.",
          max:"Please enter no more then "+maxpoint+" points."
        },
        method:"Please select payment method."
    },   

}); 
  

$('#paypal_form').validate({
    rules: {
        paypalemail: { required: true,email:true  },
    },
    messages: {
        paypalemail:{ required:"Please enter a paypal email." },
    }, 
     submitHandler: function(form) {

        form.submit();
        }
});
jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Only alphabetical characters"); 
$('#bank_form').validate({
    rules: {
        accountname: { required: true,lettersonly: true },
        accountnumber: { required: true,maxlength:18 },
        bankname: { required: true },
    },
    messages: {
        accountname:{ required:"Please enter name of account.",lettersonly:"Please enter valid name of account." },
        accountnumber:{ required:"Please enter account number or IBAN." },
        bankname:{ required:"Please enter bank name." },
    }, 
});
 
$(document).on('change', '#method', function() { 
 $('#error_paypal').remove();   
    var paypal = $('#paypalemail').val(),
    accountname = $('#accountname').val(),
    accountnumber = $('#accountnumber').val(),
    bankname = $('#bankname').val();
    if($(this).val() == '1'){

        if(paypal == ''){
            
            $('#withdrowsubmit').prop('disabled', true);
            //$('#method-error').remove();
            $('#method').after('<label id="error_paypal" class="error_paypal" for="method" style="color: #f00 !important;font-size: 14px !important;font-family:OpenSans;font-weight: normal;">Please add your Paypal email.</label>');
        }else{
            $('#error_paypal').remove();
            $('#withdrowsubmit').prop('disabled', false);
        }
         
    }
    else if($(this).val() == '2'){
         
        if(accountnumber == ''){
            $('#withdrowsubmit').prop('disabled', true);
            //$('#method-error').remove();
            $('#method').after('<label id="error_paypal" class="error_bank" for="method" style="color: #f00 !important;font-size: 14px !important;font-family:OpenSans;font-weight: normal;">Please add your bank details.</label>');
        }else{
            $('#error_paypal').remove();
            $('#withdrowsubmit').prop('disabled', false);
        }
         
            
    }
})
});
</script>
<div class="main">
    <div class="bradcume-section">
        <div class="container">
            <div class="row">
                <h2>Withdrawal Setting</h2>
            </div>
        </div>
    </div>
   <div class="attended-discssion-entrie-section password-security-section account-setting-section account-billing-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="sidelist-menu">
                            <ul class="tab">
                                <li><a href="<?php echo base_url('billing-method'); ?>" class="tablinks "  id="defaultOpen"><i class="icon icon-icon-12"></i>Billing Methods</a></li>
                                <li><a href="<?php echo base_url('change-password'); ?>" class="tablinks" onclick="openCity(event, 'tab3')"><i class="icon icon-icon-13"></i>Password & Security</a></li>
                                <li><a href="<?php echo base_url('notification-setting'); ?>" class="tablinks" onclick="openCity(event, 'tab4')"><i class="icon icon-icon-9"></i>Notification Setting</a></li>
                                <li><a href="<?php echo base_url('withdrawal'); ?>" class="tablinks active" ><i class="fa fa-money"></i>Withdrawal Setting</a></li>
                            </ul>  
                        </div>
                    </div>
                     <div class="col-md-9 col-sm-9 tabcontent" id="tab1">
                        <?php 
                        if($this->session->flashdata('paypalmsg') != ""){
                              echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('paypalmsg').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                        
                              if($this->session->flashdata('bidfail') != ""){
                                echo '<div><div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('bidfail').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                          
                        ?>
<!--                         <div id="tabs">
  <ul>
    <li><a href="#tabs-1">Withdraw</a></li>
    <li><a href="#tabs-2">PayPal</a></li>
    <li><a href="#tabs-3">Bank account</a></li>
  </ul>
  <div id="tabs-1">
    <?php  
     if($totalmpoint < 50){
        echo "<div>You can withdrow minimum 50 Points</div>";
        }
        else{
        ?>
            <form action="<?php echo base_url() ?>User_Main/withdrawal_request" id="withdrow_form" method="post">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="withdrow" autocomplete="off" placeholder="Enter the amout you would like to withdraw.">
                </div>
                <div class="form-group">
                    <label>Select Method</label>
                    <select id="method" name="method">
                        <option value="">Please select</option>
                        <option value="1">Paypal</option>
                        <option value="2">Bank Account</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Note</label>
                    <p>(Add a memo or any special instruction to facility your withdrawal.)</p>
                    <textarea name='note'></textarea>
                </div>
                    <input type="submit" id="withdrowsubmit" class="blue-button" name="withdrowsubmit" value="SEND REQUEST">
            </form>
        <?php 
        }
        ?>
  </div>
  <div id="tabs-2">
    <form action="<?php echo base_url() ?>User_Main/paypalform" id="paypal_form" method="post">
    <div class="form-group">
        <label>PayPal Email</label>
        <input type="text" id="paypalemail"  name="paypalemail" autocomplete="off" placeholder="PayPal Email" value="<?php echo $userrow->paypal_email; ?>">
        <?php echo form_error('paypalemail');?>
    </div>
    <input type="submit" class="blue-button" name="paypalsubmit" value="save">
    </form>
  </div>
  <div id="tabs-3">
    <h4>Setup your bank account</h4> 
    <form action="<?php echo base_url() ?>User_Main/bankform" id="bank_form" method="post">
    <div class="form-group">
        <label>Name on account</label>
        <input type="text" id="accountname" name="accountname" autocomplete="off" placeholder="Name on account"  value="<?php echo $userrow->account_name; ?>">
        <?php echo form_error('accountname');?>
    </div>
    <div class="form-group">
        <label>Account number or IBAN</label>
        <input type="number" id="accountnumber" name="accountnumber" autocomplete="off" placeholder="Account number or IBAN"  value="<?php echo $userrow->account_number; ?>">
        <?php echo form_error('accountnumber');?>
    </div>
    <div class="form-group">
        <label>Bank name</label>
        <input type="text" name="bankname" id="bankname" autocomplete="off" placeholder="Bank name"  value="<?php echo $userrow->bank_name; ?>">
        <?php echo form_error('bankname');?>
    </div>
    <input type="submit" class="blue-button" name="withdrowsubmit" value="save">
    </form>
  </div>
</div> -->
                       
<div class="trader-listing-detail-tabs">
    <div class="panel panel-default">
        <div class="accordion-tabs "> 
            <ul class="accordion-tab-headings">
                <li><a href="#section-1">Withdraw</a>
                </li>
                <li><a href="#section-2">PayPal </a>
                </li>
                <li><a href="#section-3">Bank account</a></li>
            </ul>
            <div class="accordion-tab-content">
                <div id="section-1">
                    <h1 class="accordion-tab-title">Withdraw</h1>
                    <form action="<?php echo base_url() ?>User_Main/withdrawal_request" id="withdrow_form" method="post">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-controlcls" name="withdrow" autocomplete="off" placeholder="Enter the amout you would like to withdraw.">
                        </div>
                        <div class="form-group">
                            <label>Select Method</label>
                            <div class="custom_select_dropdwn">
                                <i class="fa fa-angle-down"></i>
                                <select id="method" name="method" class="form-controlcls">
                                    <option value="">Please select</option>
                                    <option value="1">Paypal</option>
                                    <option value="2">Bank Account</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                            <small>(Add a memo or any special instruction to facility your withdrawal.)</small>
                            <textarea name='note' class="form-controlcls"></textarea>
                        </div>
                            <input type="submit" id="withdrowsubmit" class="blue-button" name="withdrowsubmit" value="SEND REQUEST">
                    </form>
                </div> 
                <div id="section-2">
                     <h1 class="accordion-tab-title"> PayPal </h1>
                     <form action="<?php echo base_url() ?>User_Main/paypalform" id="paypal_form" method="post">
                        <div class="form-group">
                            <label>PayPal Email</label>
                            <input type="text" id="paypalemail" class="form-controlcls" name="paypalemail" autocomplete="off" placeholder="PayPal Email" value="<?php echo $userrow->paypal_email; ?>">
                            <?php echo form_error('paypalemail');?>
                        </div>
                        <input type="submit" class="blue-button" name="paypalsubmit" value="save">
                    </form>
                </div>
                <div id="section-3">
                    <h1 class="accordion-tab-title">Bank Account</h1>
                    <div class="main-label-title">Setup your bank account</div>
                    <form action="<?php echo base_url() ?>User_Main/bankform" id="bank_form" method="post">
                        <div class="form-group">
                            <label>Name on account</label>
                            <input type="text" id="accountname" class="form-controlcls" name="accountname" autocomplete="off" placeholder="Name on account"  value="<?php echo $userrow->account_name; ?>">
                            <?php echo form_error('accountname');?>
                        </div>
                        <div class="form-group">
                            <label>Account number or IBAN</label>
                            <input type="number" id="accountnumber" class="form-controlcls" name="accountnumber" autocomplete="off" placeholder="Account number or IBAN"  value="<?php echo $userrow->account_number; ?>">
                            <?php echo form_error('accountnumber');?>
                        </div>
                        <div class="form-group">
                            <label>Bank name</label>
                            <input type="text" name="bankname" class="form-controlcls" id="bankname" autocomplete="off" placeholder="Bank name"  value="<?php echo $userrow->bank_name; ?>">
                            <?php echo form_error('bankname');?>
                        </div>
                        <input type="submit" class="blue-button" name="withdrowsubmit" value="save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

                    </div>
          
                  
                </div>
                </div>
                
            </div>
        </div>

    </div>
    