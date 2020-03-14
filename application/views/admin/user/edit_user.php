<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/fonts/importfont.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icon/css/material-design-iconic-font.min.css" />
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/style.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/select2.css" /> -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icon/css/font-awesome.min.css" />  -->
 
<script src="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/combodate.js"></script>
        <!-- <div class="bradcume-section">
            <div class="container">
                <div class="row">
                    <h2>my profile</h2>
                </div>
            </div>
        </div> -->
<?php //print_r($userdata->first_name); exit; ?>
<script type="text/javascript">
$(function(){

    $(document).on('change', '#drp', function() {
        $(this).valid();
    });
    $(document).on('change', '#date', function() {
        $(this).valid();
    });
    
    $('.edituser_main_nav').addClass('active');
    $('.edituser_main_nav').addClass('sub_li_active');
    $('.edituser_nav').addClass('active');


$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]*$/);
});

    $('#edituser').validate({
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
                extension: "jpg|png|jpeg"
            },
            dob:{
                required:true,
            },
            email:{
                required:true,
                email:true
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
            image:{ extension:"Please select valid extension." },
            dob:{required:"Please select date of birth."},
            email:{
                required:"Please enter email.",
                email:"Please enter valid email.",
            },
            skypeid:"Please enter skype id.",
            'expert[]':"Please select expert field.",
            address:"Please enter address.",
            // billing_address:"Please enter billing address.",
            country:{required:"Please select country."},
            city:"Please select city.",
            // billing_country:{required:"Please select country."},
            // billing_city:"Please select city.",
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
            /*else if(element.attr('name') == "expert"){
                jQuery('.select2-container').after(error);//.append(error);
            }*/
            
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
        $('#profileimg').attr('src', e.target.result);
        $('#profileimg').width(60);
        $('#profileimg').height(60);
    };

    reader.readAsDataURL(input.files[0]);
}
        }
$(document).ready(function () {
    $(".close").click(function (){
        $(this).css('display','none');
        jQuery("#inputGroupFile03").val('');
        jQuery("#imghidden").val('');
        $(".profileimg").attr("src","<?php echo base_url(); ?>/assets/admin/img/blank_usr_img.jpg");
        $(".profileimg").addClass("profilechange");
    });
});
</script>
<div class="content-i">
    <div class="content-box add_user_page edit_user">
        <div class="element-wrapper">
            <div class="element-box table_container">
            <h6 class="element-header">Edit User</h6>
        <!-- <section class="myprofile-main-section">
            <div class="container"> -->
                <form name="edituser" enctype="multipart/form-data"  class="light_font_form" id="edituser" action="<?php echo base_url() ?>admin/User_Master/edit/<?php echo $userdata->user_ID; ?>" method="post">
                    <div class="form_container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="main-label-title">Photo</div>
                                <div class="uploadimg-main-section">
                                    <div class="uploadimg">
                                    <?php 
                                    if($userdata->profile_photo != ''){
                                        $image_path = base_url('upload/profile/' . $userdata->profile_photo);
                                        $thumb_path = preg_replace('~\.(?!.*\.)~', '-60x60.', $image_path);

                                        ini_set('allow_url_fopen', true);

                                        if (getimagesize($thumb_path)) {
                                            $image_path = $thumb_path;
                                        }
                                     ?>
                                        <img class="profileimg" id="profileimg" src="<?php echo $image_path; ?>">
                                        <i class="close" aria-hidden="true">x</i>
                                        <input type="hidden" id="imghidden"  name="imghidden" value="<?php echo $userdata->profile_photo ?>">
                                    <?php } 
                                    else{ ?>
                                    	<img class="profileimg" id="profileimg" src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                                        <i class="close" aria-hidden="true" style="display: none;">x</i>
                                    <?php } ?>
                                    </div>
                                    <!-- <a href="#">upload photo</a> -->
                                    <div class="custom-file01">
                                       	<input type="file" id="inputGroupFile03" name="image" onchange="readURL(this);" class="custom-file-input">

                                        <label class="custom-file-label-buton  uploadphotocls" for="inputGroupFile03">upload
                                            photo</label>
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
                                            <input type="text" name="first_name" class="input_text" value="<?php echo ($userdata->first_name !='' ? $userdata->first_name:set_value('first_name')); ?>"><?php echo form_error('first_name');  ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label>Last name</label>
                                            <input type="text" name="last_name" class="input_text" value="<?php echo ($userdata->last_name !=''?$userdata->last_name:set_value('last_name')); ?>"><?php echo form_error('last_name');  ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form_group">
                                            <label>virtual name</label>
                                            <input type="text" name="virtual_name" class="input_text" value="<?php echo ($userdata->virtual_name !='' ?$userdata->virtual_name :$userdata->first_name.' '.$userdata->last_name); ?>"><?php echo form_error('virtual_name');  ?>
                                            <div class="warning-msg">Name To Be Publish In Site</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label>date of birth</label>
                                    <div class="">
                                        <input type="text" name="dob" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY"
                                            name="date" class="form-control" value="<?php echo ($userdata->date_of_birth !='' ? date('d-m-Y',strtotime($userdata->date_of_birth)) : set_value('dob')); ?>"><?php echo form_error('dob');  ?>  
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form_group">
                                    <label>email</label>
                                    <input type="email" name="email" class="input_text"  value="<?php echo $userdata->email; ?>" readonly><?php echo form_error('email');  ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form_group">
                                    <label>skype ID</label>
                                    <input type="text" name="skypeid" class="input_text"  value="<?php echo ($userdata->skype_id !=''?$userdata->skype_id:set_value('skypeid')); ?>" ><?php echo form_error('skypeid');  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <?php $expertarr = explode(',',$userdata->expert_field); ?>
                                <label>Expert Field (Max. 5)</label>
                                <select name="expert[]" class="select02" multiple="multiple" id="drp">
                                    <?php
                                        foreach ($expertfield as $expert) {
                                        ?>
                                        <option value="<?php echo $expert->field_ID; ?>" <?php if(in_array($expert->field_ID, $expertarr)){ echo 'selected';} ?>><?php echo $expert->name; ?></option>    
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
                                    <textarea name="address" class="input_textarea"><?php echo $userdata->address_line1; ?></textarea><?php echo form_error('address');  ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form_group">
                                    <div class="main-label-title">Biling Address<span>(Optional)</span></div>
                                    <label>address line 1</label>
                                    <textarea name="billing_address" class="input_textarea"><?php echo ($userdata->billing_address_line1!=''?$userdata->billing_address_line1:set_value('billing_address')); ?></textarea><?php echo form_error('billing_address');  ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-3 col-sm-6">
                                <div class="form_group">
                                    <label>country</label>
                                    <div class="select_arrow">
                                        <select name="country" id="country" onChange="getcity(this.value)">
                                            <option value="">Select Country</option>
                                        	<?php 
                                        	foreach ($cnt as $contry) { ?>
                                        	<!-- <option value="<?php echo $contry->country_ID; ?>"<?php if($contry->country_ID == $userdata->country){ echo "selected"; } ?>><?php echo $contry->name ?></option>   -->
                                            <option value="<?php echo $contry->country_ID; ?>"<?php echo set_select('country',$contry->country_ID, ( !empty($userdata->country) && $userdata->country == $contry->country_ID ? TRUE : FALSE )); ?>><?php echo $contry->name ?></option>  
                                            <?php 
                                        	}
                                        	?>                                                 
                                        </select>
                                    </div>
                                </div>
                            </div>
                         
                            <div class="col-md-3 col-sm-6">
                                <div class="form_group">
                                    <div class="form_group custom_select">
                                        <label>city</label>
                                        <?php  
                                            //print_r($city); ?>
                                        <div class="select_arrow">
                                            <select id="city" name="city">
                                                <option value="">Select City</option>
                                                <?php 
                                                for($c=0;$c<count($city);$c++){ ?>
                                                      <option <?php if ($city[$c]->city_ID == $userdata->city){ echo "selected"; } ?> value="<?php echo $city[$c]->city_ID; ?>"><?php echo $city[$c]->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form_group">
                                    <div class="form_group custom_select">
                                        <label>country</label>
                                        <div class="select_arrow">
                                            <select name="billing_country" onChange="getbillingcity(this.value)">
                                                <option value="">Select Country</option>
                                                <?php 
                                                foreach ($cnt as $contry) { ?>
                                              <!--   <option value="<?php echo $contry->country_ID; ?>"<?php if($contry->country_ID == $userdata->billing_country){ echo "selected"; } ?>><?php echo $contry->name ?></option>  --> 
                                              <option value="<?php echo $contry->country_ID; ?>"<?php echo set_select('billing_country',$contry->country_ID, ( !empty($userdata->billing_country) && $userdata->billing_country == $contry->country_ID ? TRUE : FALSE )); ?>><?php echo $contry->name ?></option> 
                                                <?php 
                                                }
                                                ?>                            
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form_group">
                                    <div class="form_group custom_select">
                                        <label>city</label>
                                        <div class="select_arrow">
                                            <select id="billing_city" name="billing_city">
                                                <option value="">Select City</option>
                                                <?php 
                                                for($bc=0;$bc<count($billingcity);$bc++){ ?>
                                                      <option <?php if ($billingcity[$bc]->city_ID == $userdata->billing_city){ echo "selected"; } ?> value="<?php echo $billingcity[$bc]->city_ID; ?>"><?php echo $billingcity[$bc]->name; ?></option>
                                                <?php } ?>
                                            </select>
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
                                    <input type="text" name="facebooklink"   class="input_text fb-social-icon"
                                        placeholder="Enter link to your profile" value="<?php echo $userdata->fb_link; ?>"><?php echo form_error('facebooklink');  ?> 
                                    <i class="icon icon-15"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group social_input">
                                    <input type="text" name="linkedinink" class="input_text linkedin-social-icon"
                                        placeholder="Enter link to your profile" value="<?php echo $userdata->linkedin_link; ?>"><?php echo form_error('linkedinink');  ?> 
                                    <i class="icon icon-16"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_group social_input">
                                    <input type="text" name="instagramlink" class="input_text instagram-social-icon" placeholder="Enter link to your profile" value="<?php echo $userdata->insta_link; ?>"><?php echo form_error('instagramlink');  ?>  
                                    <i class="icon icon-17"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form_group custom_select">
                            <label>User Status</label>
                            <div class="select_arrow">
                                <select name="userstatus" class=""> 
                                    <option value="">Status</option>
                                    <option value="1" <?php if($userdata->isActive == '1'){echo 'selected'; } ?>>Active</option>
                                    <option value="0" <?php if($userdata->isActive == '0'){echo 'selected'; } ?>>Deactive</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="submit" class="blue-button">Update <i class="icon icon-icon-8"></i></button> -->
                    <input type="submit" value="Submit" class="input_submit">
                </form>

            <!-- </div>
        </section> --> 
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
 