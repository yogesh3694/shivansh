<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script> 
<script type="text/javascript">
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profileimg')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
$(document).ready(function () {
	$('#admin_profile').validate({
        rules: {
        first_name:{
            required:true,
            maxlength:10,           
        },
        last_name: {
            required:true,
            maxlength:10,
        },
            profile:{ extension: "jpg|png|jpeg|svg" },
        },
        messages: {
            first_name:{required:"Please enter first name." },
        last_name:{required:"Please enter last name." },
            profile:{ extension : "Please select valid extension." },
        },
		errorPlacement: function(error, element) {
	        if(element.attr('name') == "profile"){
	            jQuery('.adminprofilecls').after(error);//.append(error);
	        } 
	        else {
	            error.insertAfter(element);
	        }
	    },  
        submitHandler: function(form) {
            form.submit();
        }
    });
    /*$(".close").click(function (){
    	var $el = $('#inputGroupFile03');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap();
        $(".profileimg").attr("src","<?php echo base_url(); ?>/assets/images/none-user.png");
        $(".profileimg").addClass("profilechange");
        $(".profileremove").hide();
        $("#profiletmp").val("");
    });*/
});
</script>
<?php 
	if($this->session->flashdata('success') != ''){
?>
	<div class="alert-success alert alert-dismissible">
		<?php echo $this->session->flashdata('success'); ?>
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	</div>
<?php
}
?>
<div class="content-i setting_master_page setting_user_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
            <h6 class="element-header">Manage Users</h6>
                <div class="table-responsive">
                	<form id="admin_profile" action="<?php echo base_url(); ?>admin/Setting_Master/edit/<?php echo $admindata->user_ID; ?>" method="post" enctype="multipart/form-data" class="light_font_form"> 
						<div class="row">
							<div class="col-sm-12">
			                    
			                </div>
							<div class="col-md-12">
			                    <div class="form_group"><label for=""> Profile</label>
			                    	<div class="form_group adminprofilecls"> 
				                    	<?php
			                    		if($admindata->profile_photo != ''){
		                    			?>
		                    				<img class="profileimg" id="profileimg" src="<?php echo base_url() ?>upload/profile/<?php echo $admindata->profile_photo; ?>">
		                    			<?php
			                    		}
			                    		else{
		                    			?>
		                    				<img class="profileimg" id="profileimg" src="<?php echo base_url() ?>assets/images/none-user.png">
				                   		 	<!-- <i class="close" aria-hidden="true">x</i> -->
		                    			<?php
			                    		}
				                    	?>
				                   		 
					                    <label class="input_file">
				                    		<input id="inputGroupFile03" name="profile" type="file" onchange="readURL(this);" class="">
				                    		<span class="icon icon-19"></span>
				                    	</label>
				                    </div>
			                    </div>
			                </div>
			                <div class="col-md-6">
			                    <div class="form_group"><label for=""> First Name</label>
			                    	<input class="input_text" placeholder="First Name" name="first_name" type="text" value="<?php echo $admindata->first_name; ?>">
			                    </div>
			                </div>
		                    <div class="col-md-6">
		                        <div class="form_group">
		                        	<label for="">Last Name</label>
		                        	<input class="input_text" name="last_name" placeholder="Last Name" type="text" value="<?php echo $admindata->last_name; ?>">
		                        </div>
		                	</div>
			            </div>
			            	<input type="submit" name="profilesubmit" value="Update" class="input_submit">
		        	</form>
				</div>
			</div>
		</div>
	</div>
</div>