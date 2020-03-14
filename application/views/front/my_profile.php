<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script>
<script type="text/javascript">
$(function(){
 $.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]*$/);
});
$(document).on('change', '#drp', function() {
    $(this).valid();
});
$(document).on('change', '#date', function() {
    $(this).valid();
});

$('#myprofile').validate({
    ignore: [],
    rules: {
        user_type:"required",
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
        image:{
            extension: "jpg|png|jpeg"
        },
        virtual_name: {
          maxlength:20,           
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
        facebooklink:{url:true}, 
        linkedinink:{url:true}, 
        instagramlink:{url:true}, 
        // billing_country:"required",
        // billing_city:"required"
         
    },
    messages: {
        first_name:{required:"Please enter first name.", lettersonly:"Please enter valid first name."},
        last_name:{required:"Please enter last name.", lettersonly:"Please enter valid last name."},
        virtual_name:{required:"Please enter virtual name."},
        image:{ //extension:"Please select valid extension.",
                extension:"Please select valid image." },
        dob:{required:"Please select date of birth."},
        email:{
            required:"Please enter email.",
            email:"Please enter valid email."
        },
        //expert:{required:"Please select expert field."}
        skypeid:"Please enter skype id.",
        'expert[]':"Please select expert field.",
        address:"Please enter address.",
        // billing_address:"Please enter billing address.",
        country:{required:"Please select country."},
        city:"Please select city.",
        facebooklink:{url:"Please enter valid url."},
        linkedinink:{url:"Please enter valid url."},
        instagramlink:{url:"Please enter valid url."},
        // billing_country:{required:"Please select country."},
        // billing_city:"Please select city.",
    }, 
    errorPlacement: function(error, element) {
        if(element.attr('name') == "expert[]"){
            element.next().append(error);
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
function getcity(country){   
 
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
function getbillingcity(country){ //alert('ssas'+country);
 
    $.ajax({
        type:"POST",
        dataType:'json',
        url:"<?php echo base_url('admin/User_Master/billingcity_ajax'); ?>",
        data: {
            countryid : country,
        },
        success:function(data){ //alert('aa');
            $('#billing_city').html(data.citydata);
        },
    }); 
}

// String.prototype.filename=function(extension){
//     var s= this.replace(/\\/g, '/');
//     s= s.substring(s.lastIndexOf('/')+ 1);
//     return extension? s.replace(/[?#].+$/, ''): s.split('.')[0];
// }

function readURL(input) {  
    $('.closeimg').css('display','block');
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
   
     $(".closeimg").click(function (){  
        $(this).css('display','none');
        jQuery("#inputGroupFile03").val('');
        jQuery("#imghidden").val('');
        $(".profileimg").attr("src","<?php echo base_url(); ?>assets/admin/img/blank_usr_img.jpg");
        $(".profileimg").addClass("profilechange");
    });
});
</script>
<div class="main">
    <div class="bradcume-section">
        <div class="container">
            <h2>my profile</h2>
        </div>
    </div>
    <section class="myprofile-main-section"> 
        <div class="container">
            <?php 
            if($this->session->flashdata('success') != ""){
                  echo '<div class="alert-success alert alert-dismissible">'.$this->session->flashdata('success').'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>'; } 
            ?>
            <form id="myprofile" name="myprofile" enctype="multipart/form-data"  method="post">
                <div class="panel panel-default pd01">
                    <div class="panel-body">
                        <div class="form01">
                            <div class="row">
                                <div class="col-md-2 uploadphoto-area">
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
                                            
                                            //echo $image_path;
                                         ?>

                                            <img class="profileimg" id="profileimg" src="<?php echo $image_path; ?>">
                                            <i class="closeimg" aria-hidden="true">x</i>
                                            <input type="hidden" id="imghidden" name="imghidden" value="<?php echo $userdata->profile_photo; ?>">
                                        <?php } 
                                        else{ ?>
                                            <img class="profileimg" id="profileimg" src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                                            <i class="closeimg" aria-hidden="true" style="display: none;">x</i>
                                        <?php } ?>
                                        </div>
                                        <!-- <a href="#">upload photo</a> -->
                                        <div class="custom-file01">
                                            

                                            <label class="custom-file-label-buton  uploadphotocls">
                                                upload photo
                                                <input type="file" id="image"  name="image" onchange="readURL(this);" class="custom-file-input">
                                            </label>
                                            <?php if(isset($imgerr)){ echo $imgerr; } ?>    
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10 myprofile-detail">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="main-label-title">name</div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 txtbox-size">
                                            <div class="form-group">
                                                <label class="form-label">First name</label>
                                                <input type="text" name="first_name" class="form-controlcls" value="<?php echo ($userdata->first_name !='' ? $userdata->first_name:set_value('first_name')); ?>"><?php echo form_error('first_name');  ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 txtbox-size">
                                            <div class="form-group">
                                                <label class="form-label">Last name</label>
                                                <input type="text" name="last_name" class="form-controlcls" value="<?php echo ($userdata->last_name !=''?$userdata->last_name:set_value('last_name')); ?>"><?php echo form_error('last_name');  ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 txtbox1-size">
                                            <div class="form-group">
                                                <label class="form-label">virtual name</label>
                                                <input type="text" name="virtual_name" class="form-controlcls" value="<?php echo ($userdata->virtual_name !='' ?$userdata->virtual_name : $userdata->first_name.' '.$userdata->last_name ); ?>"><?php echo form_error('virtual_name');  ?>
                                                <div class="warning-msg">Name To Be Publish In Site</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row custom-row-padding">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">date of birth</label>
                                            <input type="text" name="dob" id="date" data-format="DD-MM-YYYY" data-template="D MMM YYYY"
                                                name="date" class="form-control" value="<?php if($userdata->date_of_birth !=''){ echo date('d-m-Y',strtotime($userdata->date_of_birth)); } ?>"><?php echo form_error('dob');  ?>  
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">email</label>
                                        <input type="email" name="email" class="form-controlcls"  value="<?php echo $userdata->email; ?>" readonly><?php echo form_error('email');  ?>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">skype ID</label>
                                        <input type="text" name="skypeid" class="form-controlcls"  value="<?php echo ($userdata->skype_id !=''?$userdata->skype_id:set_value('skypeid')); ?>"><?php echo form_error('skypeid');  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row multivalueselectbox">
                                <div class="col-md-12">
                                <?php $expertarr = explode(',',$userdata->expert_field); ?>
                                    <label class="form-label">Expert Field (Max. 5)</label>
                                    <select name="expert[]" class="form-control select02" multiple="multiple" id="drp">
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
                    </div>
                </div>
                 <div class="panel panel-default pd02">
                    <div class="panel-body">
                        <div class="form02">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <div class="main-label-title">Address</div>
                                        <label class="form-label">address line 1</label>
                                        <textarea name="address" class="form-control"><?php echo ($userdata->address_line1!=''?$userdata->address_line1:set_value('address')); ?></textarea><?php echo form_error('address');  ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">country</label>
                                                <select name="country" class="form-control" onChange="getcity(this.value)">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">city</label>
                                                <?php  
                                                    //print_r($city); ?>
                                                <select id="city" name="city" class="form-control">
                                                    <option value="">Select city</option>
                                                    <?php 
                                                    for($c=0;$c<count($city);$c++){ ?>
                                                          <option <?php if ($city[$c]->city_ID == $userdata->city){ echo "selected"; } ?> value="<?php echo $city[$c]->city_ID; ?>"><?php echo $city[$c]->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 row_margin">
                                    <div class="form-group">
                                        <div class="main-label-title">Biling Address<span>(Optional)</span></div>
                                        <label class="form-label">address line 1</label>
                                        <textarea name="billing_address" class="form-control"><?php echo ($userdata->billing_address_line1!=''?$userdata->billing_address_line1:set_value('billing_address')); ?></textarea><?php echo form_error('billing_address');  ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">country</label>
                                                <select name="billing_country" class="form-control" onChange="getbillingcity(this.value)">
                                                    <option value="">Select country</option>
                                                    <?php 
                                                    foreach ($cnt as $contry) { ?>
                                                    <!-- <option value="<?php echo $contry->country_ID; ?>"<?php if($contry->country_ID == $userdata->billing_country){ echo "selected"; } ?>><?php echo $contry->name ?></option>   -->
                                                    <option value="<?php echo $contry->country_ID; ?>"<?php echo set_select('billing_country',$contry->country_ID, ( !empty($userdata->billing_country) && $userdata->billing_country == $contry->country_ID ? TRUE : FALSE )); ?>><?php echo $contry->name ?></option> 
                                                    <?php 
                                                    }
                                                    ?>                            
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">city</label>
                                                <select id="billing_city" name="billing_city" class="form-control">
                                                    <option value="">Select city</option>
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
                    </div>
                </div>

            <div class="panel panel-default pd03">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-label-title">My Social Network <span>(optional)</span></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>
                                    <input type="text" name="facebooklink"   class="form-controlcls fb-social-icon"
                                        placeholder="Enter link to your profile" value="<?php echo $userdata->fb_link; ?>"><?php echo form_error('facebooklink');  ?> 
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>
                                    <input type="text" name="linkedinink" class="form-controlcls linkedin-social-icon"
                                        placeholder="Enter link to your profile" value="<?php echo $userdata->linkedin_link; ?>"><?php echo form_error('linkedinink');  ?> 
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>
                                    <input type="text" name="instagramlink" class="form-controlcls instagram-social-icon" placeholder="Enter link to your profile" value="<?php echo $userdata->insta_link; ?>"><?php echo form_error('instagramlink');  ?>  
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="blue-button">Update <i class="icon icon-icon-8"></i></button>
        </form>
        </div>
    </section>
</div>
    <script>
        $(document).ready(function () {
           

            $('#date').combodate({ customClass: 'form-control' });
            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
            
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
            $("#drp").select2({maximumSelectionLength: 5  });
        });
    </script>
   

</body>

</html>