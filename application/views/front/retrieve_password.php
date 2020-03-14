<?php //print_r($forgotemail);  ?>
<script type="text/javascript"> 
$(document).ready(function () {
$("#retriveform").validate({
    rules: {
        txtanswer:{ required: true }
    },
    messages: {
        txtanswer: "Please enter your answer." 
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
                <h2>security question</h2>
        </div>
    </div>
    <div class="login-form-section">
        <?php if($this->session->flashdata('retriverror') != ""){ ?>
            <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('retriverror'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
        <?php } ?>
        <div class="container">
            <div class="retrieve-pass-box commen-section">
                    <form method="post" id="retriveform" action="<?php echo base_url() ?>User_Main/updatepassword">
                        <input type="hidden" name="forgotemail" value="<?php echo $forgotemail['email']; ?>">
                        <input type="hidden" name="answer" value="<?php echo $forgotemail['answer']; ?>">
                        <p><?php echo ucwords($forgotemail['question']); ?></p>
                        <div class="form-group">
                            <input type="text" name="txtanswer" class="form-controlcls" placeholder="">
                        </div>
                        <div class="button-prn">
                            <input type="submit" name="retrivesubmit" class="blue-button" value="Retrieve Password"> 
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

