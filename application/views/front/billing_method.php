<script src="<?php echo base_url('assets/front/js/payform.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/front/js/additional-methods.min.js'); ?>" type="text/javascript"></script> 
<script type="text/javascript">
$(function(){
payform.cardNumberInput(document.getElementById('card_no'));
payform.expiryInput(document.getElementById('valid_thrugh'));
payform.cvcInput(document.getElementById('cvv_no'));
$('#billingform').validate({
    rules: {
        card_no: { required: true,creditcard:true  },
        valid_thrugh: { required: true, },
        cvv_no: { required: true,number:true,maxlength:4 } 
    },
    messages: {
        card_no:{ required:"Please enter card number." },
        valid_thrugh:{ required:"Please enter card expiry date."}, 
        cvv_no:{ required:"Please enter cvv number."}, 
    }, 
});
});
</script>
<div class="main">
    <div class="bradcume-section">
        <div class="container">
            <div class="row">
                <h2>My Created Discussions</h2>
            </div>
        </div>
    </div>
   <div class="attended-discssion-entrie-section password-security-section account-setting-section account-billing-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="sidelist-menu">
                            <ul class="tab">
                                <li><a href="<?php echo base_url('billing-method'); ?>" class="tablinks active"  id="defaultOpen"><i class="icon icon-icon-12"></i>Billing Methods</a></li>
                                <li><a href="<?php echo base_url('change-password'); ?>" class="tablinks" onclick="openCity(event, 'tab3')"><i class="icon icon-icon-13"></i>Password & Security</a></li>
                                <li><a href="<?php echo base_url('notification-setting'); ?>" class="tablinks" onclick="openCity(event, 'tab4')"><i class="icon icon-icon-9"></i>Notification Setting</a></li>
                                <li><a href="<?php echo base_url('withdrawal'); ?>" class="tablinks" ><i class="fa fa-money"></i>Withdrawal Setting</a></li>
                            </ul>  
                        </div>
                    </div>
                     <div class="col-md-9 col-sm-9 tabcontent" id="tab1">
                        <?php 
                        if($this->session->flashdata('billing_msg') != ""){
                              echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('billing_msg').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                        
                              if($this->session->flashdata('bidfail') != ""){
                                echo '<div><div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('bidfail').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                          
                        ?>
                        <?php
                        if(!empty($cards))
                        { ?>
                            <div class="panel panel-default">
                                <h4 class="credit_title">Saved Credit Card</h4>
                                <?php  $i=0;
                                foreach ($cards as $card) { $i++;
                                ?>
                                    <div class="credit-card-section creditcard-border">
                                        <span>xxxx xxxx xxxx <?php echo $card->card_last_degits; ?></span>
                                        <div class="pay-img">
                                       
                                        <?php if($card->card_name=='visa'){ ?>
                                                    <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png"></div>
                                                    <?php 
                                                }else if($card->card_name=='Mastercard'){
                                                 ?>
                                                        <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img2.png"></div>
                                                    <?php 
                                                }
                                                else{ ?>
                                                        <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png"></div>
                                                <?php } ?>
                                         </div>
                                        <a href="<?php echo base_url().'User_Main/remove_card/'.$card->card_ID; ?>" onclick="return confirm('Are you sure you want to remove this card ?')">remove card</a>
                                    </div>
                                <?php
                                }
                                 ?>
                            </div>
                        <?php } ?>
                        <div class="panel panel-default">
                            <h4 class="credit_title">Add New Card</h4>
                            <form id="billingform" action="<?php echo base_url('billing-method'); ?>" method="post"> 
                                <div class="card-no-div">
                                    <div class="form-group">
                                        <label class="form-label">card number</label>
                                        <input type="text" name="card_no" class="form-controlcls" id="card_no" inputmode="numeric" autocomplete="cc-number" placeholder="XXXX  XXXX  XXXX  XXXX">
                                        <!-- <input type="text" name="card_no" class="form-controlcls" id="card_no" inputmode="numeric" maxlength="16" placeholder="XXXX  XXXX  XXXX  XXXX"> -->
                                        <?php echo form_error('card_no'); ?>
                                    </div>
                                </div>
                                <div class="valid-div">
                                    <div class="form-group">
                                        <label class="form-label">Valid Through</label>
                                        <input name="valid_thrugh" id="valid_thrugh" class="form-controlcls" type="text" placeholder="MM/YY">
                                        <?php echo form_error('valid_thrugh'); ?>
                                    </div>
                                </div>
                                <div class="cvc-no-div">
                                    <div class="form-group">
                                        <label class="form-label">CVV Number</label>
                                        <input name="cvv_no" id="cvv_no" class="form-controlcls" type="text"  placeholder="Enter CVV">
                                        <?php echo form_error('cvv_no'); ?>
                                    </div>
                                </div>
                                <div class="add-new-card-btn">
                                <div class="label-title">&nbsp;</div>
                                <input type="submit" name="billing_submit" class="blue-button" value="add" placeholder="Enter CVC">
                                 </div>
                                <div class="clear"></div>
                            </form> 
                        </div>
                       
                    </div>
          
                  
                </div>
                </div>
                
            </div>
        </div>

    </div>
    