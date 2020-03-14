<script type="text/javascript"> 
$(document).ready(function () {
	   $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]*$/);
    });
	$("#signupform").validate({
    	ignore: [],
    	rules: {
      	first_name: {
          required:true,
          lettersonly:true,
          maxlength:15,
        },
      	last_name: {
          required:true,
          lettersonly:true,
          maxlength:15,
        },
      	password: {
          required: true,
          minlength:6
        }, 
      	email: {
        	required: true,
        	email: true,
          remote: {
                    url: "<?php echo base_url(); ?>User_Main/getajaxemail",
                    type: "post"
                }
      	},
    },
  	messages: {
        first_name: {
          required:"Please enter first name.",
          lettersonly:"Please enter valid first name."
        },
        last_name: {
          required:"Please enter last name.",
          lettersonly:"Please enter valid last name."
        },
        email: {
          required: "Please enter email address.",
          email: "Please enter valid email address.",
          remote: "Email already registered. Please login with your credentials."
        },
        password: {
          required:'Please enter password.',
          minlength:'Password must contain six characters.'
        },
    },
  	errorPlacement: function (error, element) {
    	    error.insertAfter(element); 
  	},
  	submitHandler: function (form) {
  	     form.submit();
  	}
});
 
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
<div class="main">
	<section class="bradcume-section">
		<div class="container">
				<h2>register</h2>
		</div>
	</section>
	<section class="register-form-section">
		<div class="container">
				<div class="register-box commen-section">
					<form action="<?php echo base_url(); ?>register" method="post" id="signupform">
  					<div class="row">	
              <div class="form-group col-md-6 col-sm-6">
  								<label class="form-label">first name</label>
  								<input type="text" class="form-controlcls form-controlcls01" name="first_name" id="first_name">
  						</div>
  						<div class="form-group col-md-6 col-sm-6">
  								<label class="form-label">last name</label>
  								<input type="text" class="form-controlcls form-controlcls02" name="last_name" id="last_name">
  						</div>
            </div>
						<div class="clear"></div>
						<div class="form-group">
							<label class="form-label">Email address</label>
							<input type="email" class="form-controlcls" name="email" id="email" >
						</div>
						<div class="form-group">
              <label class="form-label">Password</label>
							<div class="input-group">
								
								<input type="password" class="form-controlcls form-controlcls-eye" name="password" id="pass">
								<div class="input-group-addon"><i class="hideshowpassword fa fa-eye-slash" aria-hidden="true"></i></div>
							</div>
						</div>
						<div class="button-prn">
							<!-- <a href="#" class="blue-button">create account</a> -->
							<input type="submit" name="signupsubmit1" class="blue-button" value="next">
						</div>
						<div class="new-account-cls">
							<span class="create-account-cls create-account-cls01"><a href="<?php echo base_url(); ?>login">Already have an account? Login Here!</a></span>
						</div>
					</form>
				</div>
			
		</div>
	</section>
</div>
