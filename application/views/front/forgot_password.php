<script type="text/javascript"> 
$(document).ready(function () {
       $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
    });
    $("#forgotform").validate({
        rules: {
        forgotemail: {
            required: true,
            email: true 
        },
    },
    messages: {
        forgotemail: {
          required: "Please enter email.",
          email: "Please enter valid email." 
        },
    },
    errorPlacement: function (error, element) {
            error.insertAfter(element); 
    },
    submitHandler: function (form) {
         form.submit();
    }
});
});
</script>
<div class="main">
    <div class="bradcume-section">
        <div class="container">
                <h2>forgot password</h2>
        </div>
    </div>
    <div class="login-form-section">
        <?php if($this->session->flashdata('forgoterror') != ""){ ?>
                <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('forgoterror'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
        <?php } ?>
        <div class="container">
                <div class="forgot-pass-box commen-section">
                    <form id="forgotform" method="post">
                        <p>Enter your Email Address below and we will send you indtruction for resetting it.</p>
                        <div class="form-group">
                            <label class="form-label">Email address</label>
                            <input type="email" name="forgotemail" class="form-controlcls" placeholder="Email">
                        </div>
                        <div class="button-prn">
                            <input type="submit" name="forgotsubmit" class="blue-button" value="next">
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $(".input-group-addon .fa-eye").click(function () {
        $(this).removeClass("fa-eye-custom");
        $(this).parent().parent().find(".form-controlcls-eye").prop("type", "text");
        $(this).addClass("fa-eye-custom");

    });
});
</script>

