<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/fonts/importfont.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icon/css/material-design-iconic-font.min.css" /> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/style.css" /> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/select2.css" /> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icon/css/font-awesome.min.css" />  -->

<script src="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/combodate.js"></script>

<!-- below script is theme hover menu -->


        <!-- <div class="bradcume-section">
            <div class="container">
                <div class="row">
                    <h2>my profile</h2>
                </div>
            </div>
        </div> -->
<script type="text/javascript">
$(function(){ 
    $(document).on('change', '#drp', function() {
        $(this).valid();
    });
    $(document).on('change', '#date', function() {
        $(this).valid();
    });
     $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]*$/);
    });

    $('#adduser').validate({
        ignore: [],
        rules: {
            first_name:{
                required:true,
                lettersonly:true,
                maxlength:10,
            },
            last_name: {
                required:true,
                lettersonly:true,
                maxlength:10,
            },
            virtual_name: {
                maxlength: 20 
            },
            image:{
                //required:true,
                extension: "jpg|png|jpeg",
            },
            dob:{
                required:true,
            },
            email:{
                required:true,
                email:true,
                remote: {
                    url: "<?php echo base_url(); ?>User_Main/getajaxemail",
                    type: "post"
                }
            },
            skypeid:"required",
            'expert[]':"required",
            address:"required",
            // billing_address:"required",
            country:"required",
            city:"required",
            // billing_country:"required",
            // billing_city:"required"
             
        },
        messages: {
            first_name:{required:"Please enter first name.", lettersonly:"Please enter valid first name"},
            last_name:{required:"Please enter last name.", lettersonly:"Please enter valid last name"},
            //virtual_name:{required:"Please enter virtual name."},
            dob:{required:"Please select date of birth."},
            image:{ //extension:"Please select valid extension.",
                extension:"Please select valid image."
                },
            email:{
                required:"Please enter email.",
                email:"Please enter valid email.",
                remote: "Email already exists! please try again."
            },
            skypeid:"Please enter skype id.",
            'expert[]':"Please select expert field.",
            address:"Please enter address.",
            // billing_address:"Please enter billing address.",
            country:{required:"Please select country."},
            city:{required:"Please select city."},
            // billing_country:{required:"Please select country."},
            // billing_city:{required:"Please select City."},
        }, 
        errorPlacement: function(error, element) {
            if(element.attr('name') == "expert[]"){
                jQuery('.select2-container').after(error);//.append(error);

            }
            else if(element.attr('name') == "image"){
                jQuery('.uploadimg-main-section').after(error);//.append(error);
            }
            else if(element.attr('name') == "dob"){
                jQuery('.combodate').after(error);//.append(error);
            }
            else {
                error.insertAfter(element);
            }
        },     
        submitHandler: function(form) {
            form.submit();
        }
    });
});
function getcity(country){ //alert(country); exit;
 
	$.ajax({
	    type:"POST",
	    dataType:'json',
	    url:"<?php echo base_url('admin/User_Master/city_ajax'); ?>",
	    data: {
	        countryid : country,
	    },
	    success:function(data){  
	        $('#city').html(data.citydata);
	    },
	}); 
}
function getbillingcity(country){ //alert(country); exit;
 
	$.ajax({
	    type:"POST",
	    dataType:'json',
	    url:"<?php echo base_url('admin/User_Master/billingcity_ajax'); ?>",
	    data: {
	        countryid : country,
	    },
	    success:function(data){
	        $('#billing_city').html(data.citydata);
	    },
	}); 
}
 function readURL(input) {
    $('.close').css('display','block');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profileimg').attr('src', e.target.result)
            $('#profileimg').width(60);
            $('#profileimg').height(60);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function () {
// $(document).on("click",".profilechange",function (){
//         $("#txtprofile").trigger("click");
//     });
    $(".close").click(function (){
        $(this).css('display','none');
        jQuery("#inputGroupFile03").val('');
        $(".profileimg").attr("src","<?php echo base_url(); ?>/assets/admin/img/blank_usr_img.jpg");
        $(".profileimg").addClass("profilechange");
    });
});
</script>
<div class="content-i">
    <div class="content-box add_user_page">
        <div class="element-wrapper">
            <div class="element-box table_container">
                <h6 class="element-header">Add New User</h6>
                <div class="">
        <!-- <div class="main">
        <section class="myprofile-main-section"> -->
                <form name="adduser" enctype="multipart/form-data" id="adduser" class="light_font_form" action="<?php echo base_url() ?>admin/User_Master/add_user" method="post">
                    <div class="form_container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="main-label-title">Photo</div>
                                <div class="uploadimg-main-section">
                                    <div class="uploadimg">
                                    	<img class="profileimg" id="profileimg" src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                                        <i class="close" aria-hidden="true" style="display: none;">x</i>
                                    </div>
                                    <!-- <a href="#">upload photo</a> -->
                                    <div class="custom-file01">
                                       	
                                        <label class="custom-file-label-buton uploadphotocls" >upload
                                            photo
                                            <input name="image" id="inputGroupFile03" type="file" onchange="readURL(this);" class="custom-file-input">
                                        </label>
                                        <?php if(isset($imgerr)){ echo $imgerr; } ?>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 custom_col_width">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="main-label-title">name</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label>First name</label>
                                            <input type="text" name="first_name" class="input_text" value="<?php echo set_value('first_name'); ?>"><?php echo form_error('first_name');  ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label>Last name</label>
                                            <input type="text" name="last_name" class="input_text" value="<?php echo set_value('last_name'); ?>"><?php echo form_error('last_name');  ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="form_group">
                                            <label>virtual name</label>
                                            <input type="text" name="virtual_name" class="input_text" value="<?php echo set_value('virtual_name'); ?>"><?php echo form_error('virtual_name');  ?>
                                            <div class="warning-msg">Name To Be Publish In Site</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dob_custom_width">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label>date of birth</label>
                                        <div class="">
                                            <input type="text" value="<?php echo set_value('dob'); ?>" name="dob" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY" name="date" value="28-02-2016" class="input_text"><?php echo form_error('dob');  ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label>email</label>
                                        <input type="text" name="email" class="input_text" value="<?php echo set_value('email'); ?>"><?php echo form_error('email');  ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form_group">
                                        <label>skype ID</label>
                                        <input type="text" name="skypeid" class="input_text" value="<?php echo set_value('skypeid'); ?>"><?php echo form_error('skypeid');  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Expert Field (Max. 5)</label>
                                    <select name="expert[]" class="select02" multiple="multiple" id="drp">
                                        <?php
                                            foreach ($expertfield as $expert) {
                                            ?>
                                            <option value="<?php echo $expert->field_ID; ?>"><?php echo $expert->name; ?></option>    
                                            <?php
                                            }
                                         ?>
                                    </select>
                              </div>
                        </div>
                    </div>
                    <div class="form_container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="main-label-title">Address</div>
                                    <label>address line 1</label>
                                    <textarea name="address" class="input_textarea"><?php echo set_value('skypeid'); ?></textarea><?php echo form_error('address');  ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form_group custom_select">
                                            <label>country</label>
                                            <div class="select_arrow">
                                                <select name="country" class="" onChange="getcity(this.value)">
                                                    <option value="">Select Country</option>
                                                    <?php 
                                                    foreach ($cnt as $contry) {
                                                        echo '<option value="'.$contry->country_ID.'" set_select("country",'.$contry->country_ID.');>'.$contry->name.'</option>';
                                                    }
                                                    ?>                                                 
                                                </select><?php echo form_error('country');  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form_group custom_select">
                                            <label>city</label>
                                            <div class="select_arrow">
                                                <select id="city" name="city" class="">
                                                    <option value="">Select City</option>
                                                </select><?php echo form_error('city');  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mobile_margin_top">
                                <div class="form_group">
                                    <div class="main-label-title">Biling Address<span>(Optional)</span></div>
                                    <label>address line 1</label>
                                    <textarea name="billing_address" class="input_textarea"><?php echo set_value('skypeid'); ?></textarea><?php echo form_error('billing_address');  ?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form_group custom_select">
                                            <label>country</label>
                                            <div class="select_arrow">
                                                <select name="billing_country" class="" onChange="getbillingcity(this.value)">
                                                    <option value="">Select Country</option>
                                                    <?php 
                                                    foreach ($cnt as $contry) {
                                                        echo '<option value="'.$contry->country_ID.'">'.$contry->name.'</option>';
                                                    }
                                                    ?>
                                                </select><?php echo form_error('billing_country');  ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form_group custom_select">
                                            <label>city</label>
                                            <div class="select_arrow">
                                                <select id="billing_city" name="billing_city" class="">
                                                    <option value="">Select City</option>
                                                </select><?php echo form_error('billing_city');  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-label-title">My Social Network <span>(optional)</span></div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group social_input">
                                        <input type="text" name="facebooklink" value="<?php echo set_value('facebooklink'); ?>" class="input_text fb-social-icon"
                                            placeholder="Enter link to your profile">
                                        <i class="icon icon-15"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group social_input">
                                        <input type="text" name="linkedinink" value="<?php echo set_value('linkedinink'); ?>" class="input_text linkedin-social-icon"
                                            placeholder="Enter link to your profile">
                                        <i class="icon icon-16"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group social_input">
                                        <input type="text" name="instagramlink" class="input_text instagram-social-icon" placeholder="Enter link to your profile" value="<?php echo set_value('instagramlink'); ?>">
                                        <i class="icon icon-17"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Submit" class="input_submit">
                </form>
        <!-- </section> 
    </div>  -->
</div>
</div>
</div>
</div>
</div>
    <script>
            $('#date').combodate({ customClass: 'form-control' });
            $('.select02').select2({
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                }
            });
        $(document).ready(function () {
            $(".responsive-menu-icon").click(function () {
                $(".headerinnercontainer").toggleClass('openn');
                $(this).toggleClass('openn');
            });

            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
            $("#drp").select2({maximumSelectionLength: 5  });
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            comon_mincontentheight();
        });
        jQuery(window).resize(function (e) {
            comon_mincontentheight();
        });

        function comon_mincontentheight() {
            var wheight01 = jQuery(window).height();
            var fotheight01 = jQuery('footer').outerHeight();
            var cphert1 = wheight01 - fotheight01;
            if (jQuery('.main').length > 0) {
                jQuery('.main').css({ "min-height": cphert1 });
            }

        }
    </script>
 