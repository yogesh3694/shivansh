<script type="text/javascript">
$(function(){
    $('#changepwdform').validate({
        rules: {
            //user_type:"required",
            currentpass:{
                required: true,
                minlength:6,
                remote: {
                    url: "User_Main/checkoldpwd",
                    type: "post",
                    data: {
                      oldpwd: function() {
                        return $( "#currentpass" ).val();
                      }
                    }
                }
            },
            newpass: {
                required: true,
                minlength:6
            },
            confirmpass: {
                required: true,
                equalTo: "#newpass",
                minlength:6
            }  
        },
        messages: {
            currentpass:{
                            required:"Please enter current password.",
                            remote:"Please enter valid current password.",
                            minlength:'Password must contain six characters.'
                        },
            newpass:{required:"Please enter new password.",minlength:'Password must contain six characters.'},
            confirmpass:{
                            required:"Please enter confirm password.",
                            equalTo:"Confirm password must be same as new password.",
                            minlength:'Password must contain six characters.'
                        },
        }, 
        errorPlacement: function(error, element) {
                error.insertAfter(element);
        },     
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#securityform').validate({
        rules: {
            sec_question: { required: true },
            answer: { required: true },
        },
        messages: {
            sec_question:{ required:"Please select security question." },
            answer:{required:"Please enter answer."},
        }, 
    }); 
}); 
</script>
<div class="main">
    <div class="bradcume-section">
        <div class="container">
                <h2 class="passtitle">Setting <i class="fa fa-angle-double-right" aria-hidden="true"></i> Password & Security</h2>
        </div>
    </div>
    <section class="myprofile-main-section changepass01"> 
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="sidelist-menu">
                            <ul class="tab">
                                <li><a href="<?php echo base_url('billing-method'); ?>" class="tablinks" onclick="openCity(event, 'tab1')" id="defaultOpen"><i class="icon icon-icon-12"></i>Billing Methods</a></li>
                                <li><a href="<?php echo base_url('change-password') ?>" class="active tablinks" onclick="openCity(event, 'tab3')"><i class="icon icon-icon-13"></i>Password & Security</a></li>
                                <li><a href="<?php echo base_url('notification-setting') ?>" class="tablinks" onclick="openCity(event, 'tab4')"><i class="icon icon-icon-9"></i>Notification Setting</a></li>
                                <li><a href="<?php echo base_url('withdrawal'); ?>" class="tablinks" ><i class="fa fa-money"></i>Withdrawal Setting</a></li>
                            </ul>  
                        </div>
                </div>
                <div class="col-md-9 col-sm-9 tabcontent">
                <?php 
                if($this->session->flashdata('statusMsg') != ""){
                      echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('statusMsg').'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                ?>
                <div class="panel panel-default pd01">
                <form name="changepwdform" action="<?php echo base_url(); ?>change-password" id="changepwdform" method="post">
                    <div class="panel-body">
                        <div class="form01">
                            
                             <div class="main-label-title">Change Password</div>
                            
                                <div class="row">
                                <div class="col-sm-6 ps1">
                                    <div class="form-group">
                                        <label class="form-label">Current Password</label>
                                            <input type="password" name="currentpass" id="currentpass" class="form-controlcls">
                                                <?php echo form_error('currentpass'); ?> 
                                    </div>
                                </div>
                                <div class="col-sm-6 ps1">
                                    <div class="form-group">
                                        <label class="form-label">New Password</label>
                                            <input type="password" name="newpass" id="newpass" class="form-controlcls">
                                                <?php echo form_error('newpass'); ?> 
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-6 ps1">
                                    <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                            <input type="password" name="confirmpass" class="form-controlcls">
                                                <?php echo form_error('confirmpass'); ?> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                         <input type="submit" name="changepwd" class="blue-button" value="change password">
                                    </div>
                                </div>
                                </div>
                            
                        </div>
                    </div>
                </form>
                </div>
                <div class="panel panel-default securitycls">
                <form name="securityform" action="<?php echo base_url(); ?>change-security" id="securityform" method="post">
                <div class="panel-body">
                        <div class="main-label-title">Set your security question to reset your password.</div>
                        <div class="row">
                            <div class="col-sm-5 sq1">
                                <div class="form-group">
                                    <label class="form-label">Security question</label> 
                                    <?php //print_r($sec_detail); exit; ?>
                                    <?php if(!empty($sec_detail)){ $userque_id = $sec_detail->que_ID; } ?>
                                    <select name="sec_question" class="form-control valid sq1">
                                        <option value="">-Select Question</option>
                                        <?php
                                            foreach ($questions as $que) { 
                                            ?>
                                                <option value="<?php echo $que->que_ID; ?>"<?php if($que->que_ID == $userque_id){ echo 'selected'; } ?>><?php echo $que->question; ?></option>
                                            <?php
                                            }
                                         ?>
                                    </select>
                                    <?php echo form_error('sec_question'); ?>
                                </div>
                            </div>
                            <div class="col-sm-5 sq2">
                                <div class="form-group">
                                         <label class="form-label"></label> 
                                        <input type="text" name="answer" id="answer" class="form-controlcls" value="<?php echo $sec_detail->sq_answer; ?>" >
                                        <?php echo form_error('answer'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                     <input type="submit" name="changepwd" class="blue-button" value="save">
                                </div>
                            </div>
                        </div>
                   
                </div>
            </form>
            </div>
        </div>
       </div>
        </div>
    </section>
</div>
     