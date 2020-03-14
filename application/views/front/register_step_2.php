<script type="text/javascript"> 
$(document).ready(function () {
	   $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    });
	$("#signupform2").validate({
    	ignore: [],
    	rules: {
      	sec_question: {
          required:true
        },
      	sec_answer: {
          required:true
        },
    },
  	messages: {
        sec_question: {
          required:"Please select security question."
        },
        sec_answer: {
          required:"Please enter security answer."
        },
    },
  	errorPlacement: function (error, element) {
    	    error.insertAfter(element); 
  	},
  	submitHandler: function (form) {
  	     form.submit();
  	}
});});
</script>
<div class="main">
	<section class="bradcume-section">
		<div class="container">
			<h2>Security Question</h2>
		</div>
	</section>
	<section class="register-form-section">
		<div class="container">
			<div class="row">
				<div class="register-box commen-section">
					<form id="signupform2" action="<?php echo base_url('User_Main/adduser'); ?>" method="post">
						<div class="set_your_security">Set your security question to reset your password.</div>
						<input type="hidden" name="first_name" value="<?php echo $postdata['first_name']; ?>">
		                <input type="hidden" name="last_name" value="<?php echo $postdata['last_name']; ?>">
		                <input type="hidden" name="email" value="<?php echo $postdata['email']; ?>">
		                <input type="hidden" name="password" value="<?php echo $postdata['password']; ?>">
						<div class="form-group">
							<label class="form-label">Question</label>
							<select name="sec_question" class="form-control customselectcls">
								<option value="">Select Your Question</option>
							<?php foreach ($question as $que) {
								?>
									<option value="<?php echo $que->que_ID; ?>"><?php echo $que->question; ?>
									</option>
								<?php
								} ?>
							</select> 
						</div>
						<div class="form-group">
							<label class="form-label">Answer</label>
							<input type="text" class="form-controlcls" name="sec_answer">
						</div>
						 
						<div class="button-prn">
							<input type="submit" name="signupsubmit2" class="blue-button" value="Register"> 
						</div>
						<!-- <div class="new-account-cls">
							<span class="create-account-cls create-account-cls01"><a href="<?php echo base_url(); ?>login">Already have an account? Login Here!</a></span>
						</div> -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
