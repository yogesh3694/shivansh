<!DOCTYPE html>
<html>
<!-- Mirrored from light.pinsupreme.com/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Apr 2018 13:39:13 GMT -->

<head>
    <title>Trader-Network::Admin Login</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="<?php echo base_url(); ?>assets/images/favicon.png" rel="shortcut icon">
<link href="<?php echo base_url();?>assets/admin/css/maince5a.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/admin/css/custom_style.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.validate.js" type="text/javascript"></script>
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
                  required:"Please enter email.",
                  email:"Your entered email is not valid."
              },
              password:"Please enter password.",
            },
            
            submitHandler: function(form) {
              form.submit();
            }
        
        });
});
    </script>
</head>

<body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
        <div class="auth-box-w">
            <div class="login_logo">
                <a href="<?php echo base_url() ?>admin"><img src="<?php echo  base_url();?>assets/images/admin_logo.png" hieght="150px" widht="150px"></a>
            </div>            
            <form name="frmlogin" id="frmlogin" method="post">
                <?php if($this->session->flashdata('errmsg') != ''){ ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('errmsg'); ?>
                    </div>
                <?php } ?>
                <div class="form-group form_group">
                    <label for="">Email</label>
                    <input class="input_text" placeholder="Enter your username" type="text" name="user_email">
                    <div class="pre-icon os-icon os-icon-user-male-circle"></div>
                </div>
                <div class="form-group form_group">
                    <label for="">Password</label>
                    <input class="input_text" placeholder="Enter your password" type="password" name="password">
                    <div class="pre-icon os-icon os-icon-fingerprint"></div>
                </div>
                <div class="buttons-w">
                    <!-- <button class="btn btn-primary">Log me in</button> -->
                    <div class="custom_checkbox">
                        <label>
                            <input class="form-check-input" type="checkbox">
                            <span>Remember Me</span>
                        </label>
                    </div>
                    <input type="submit" class="input_submit" name="" value="Log me in">
                </div>
            </form>
        </div>
    </div>
</body>
<!-- Mirrored from light.pinsupreme.com/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Apr 2018 13:39:13 GMT -->

</html>