<div class="main">
    <div class="bradcume-section">
        <div class="container">
            <h2>login</h2>
        </div>
    </div>
    <div class="login-form-section">
        <?php
            if($this->session->flashdata('verification_msg') != ""){
                  echo '<div class="alert-success alert alert-dismissible">'.$this->session->flashdata('verification_msg').'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'; } 
            if($this->session->flashdata('loginfailed') != ""){  
                echo '<div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('loginfailed').'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>';  } 
            if($this->session->flashdata('forgotsuccess') != ""){  
                    echo '<div class="alert-success alert alert-dismissible">'.$this->session->flashdata('forgotsuccess').'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'; } ?>
        <div class="container">
           
                <div class="login-box commen-section">
                    <form name="frmlogin" id="frmlogin" method="post">
                        <div class="form-group">
                            <label class="form-label">Email address</label>
                            <input type="text" name="user_email" class="form-controlcls" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="input-group hideshowpassprn">
                                <input type="password" name="password" class="form-controlcls form-controlcls-eye" placeholder="Password"
                                    id="myInput">
                                <div class="input-group-addon"><i class="fa fa-eye-slash hideshowpassword"
                                        aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="button-prn">
                            <button type="submit" class="blue-button">log in</button>
                        </div>
                        <div class="new-account-cls">
                            <span class="forgot-pass-cls"><a href="<?php echo base_url(); ?>forgot-password">Forgot Password?</a></span>
                            <span class="create-account-cls"><a href="<?php echo base_url(); ?>register">Create New Account</a></span>
                        </div>
                    </form>
                </div>
            
        </div>
    </div>
</div> 
<script type="text/javascript">
    $(function(){
      $('#frmlogin').validate({
            rules: {
              user_email:{
                required:true,
                email:true
              },
              password:"required",
            },
            messages: {
              user_email:{
                  required:"Please enter email address.",
                  email:"Your entered email is not valid."
              },
              password:"Please enter password.",
            },
            
            submitHandler: function(form) {
              form.submit();
            }
        
        });
});
 
$(document).ready(function () {
   

    
$(".hideshowpassword").on('click', function () {

        var elementpass = $('input.form-controlcls-eye');
        var elementtype = $(elementpass).attr("type");

        if (elementtype == 'password') {
            $(elementpass).attr("type", "text");
        }
        else {
            $(elementpass).attr("type", "password");
        }
        $(this).toggleClass('fa-eye-slash fa-eye');
    });





});
</script>

