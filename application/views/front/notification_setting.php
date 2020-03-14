<script type="text/javascript">
$(function(){
$('#notiform').validate({
    rules: {
        noti_email: { required: true,email:true }
    },
    messages: {
        noti_email:{ required:"Please enter email.",email:"Please enter valid email." },
    }, 
});
});
</script>
<div class="main">
<div class="bradcume-section">
    <div class="container">
            <h2>Setting »  Notification Setting</h2>
    </div>
</div>
<div class="attended-discssion-entrie-section account-setting-section notification-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="sidelist-menu">
                    <ul>
                        <li><a href="<?php echo base_url('billing-method'); ?>"><i class="icon icon-icon-12"></i>Billing Methods</a></li>
                        <li><a href="<?php echo base_url('change-password'); ?>"><i class="icon icon-icon-13"></i>Password & Security</a></li>
                        <li><a href="<?php echo base_url('notification-setting'); ?>" class="active"><i class="icon icon-icon-9"></i>Notification</a></li>
                        <li><a href="<?php echo base_url('withdrawal'); ?>" class="tablinks" ><i class="fa fa-money"></i>Withdrawal Setting</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
             <?php 
                if($this->session->flashdata('noti_msg') != ""){
                      echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('noti_msg').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                ?>
                <div class="panel panel-default">
                    <p>Set email address where you want to get notification.</p>
                    <form id="notiform" action="<?php echo base_url('notification-setting'); ?>" method="post"> 
                        <div class="form-group">
                            <label class="form-label">email</label>
                                <input name="noti_email" class="form-controlcls" type="text" value="<?php echo $not_email->notification_email; ?>">
                                <?php echo form_error('noti_email'); ?> 
                        </div>
                            <input type="submit" name="noti_submit" class="blue-button" value="save">
                    </form>
                </div>
               
            </div>
        </div>
        </div>
        
    </div>
</div>

