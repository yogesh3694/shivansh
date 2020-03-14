<script src="<?php echo base_url(); ?>assets/front/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/front/js/additional-methods.min.js"></script>
<?php error_reporting(0);?>
<script type="text/javascript"> 
$(document).ready(function () {
    $('#adminlogoform').validate({  
      rules: {
            sitelogo:{ required:true, extension: "jpg|jpeg|png|svg" },
        },
        messages: {
            sitelogo:{ required:"Please select logo.", extension: "Please select JPG, JPEG, SVG or PNG image." },
        },
    });
    $('#adminsetting').validate({ // initialize the plugin
        rules: {
            adminemail:{  required:true , email:true },
            adminskype:{  required:true , email:true },
            fblink:{  required:true , url:true },
            linkedinlink:{  required:true , url:true },
            instalink:{  required:true , url:true },
            skypelink:{  required:true },
        },
        messages: {
            adminemail:{ required:"Please enter email address.", email:"Please enter valid email address."  },
            adminskype:{ required:"Please enter skype address.", email:"Please enter valid skype address."  },
            fblink:{ required:"Please enter facebook link." },
            linkedinlink:{ required:"Please enter linkedin link." },
            instalink:{ required:"Please enter instagram link."},
            skypelink:{ required:"Please enter skype link." },
        },
    });
});
</script>
<script type="text/javascript"> 
$(document).ready(function () {
    $('#adminemarket').validate({  
      rules: {
            usd_dollar:{ required:true,number:true},
             emarket_point:{ required:true,number:true},
        },
        messages: {
            usd_dollar:{ required:"Please enter USD.",number:"Please enter valid USD." },
            emarket_point:{ required:"Please enter emarket point.",number:"Please enter valid emarket point."  },
        },
    });
    $('#adminskillpoint').validate({ // initialize the plugin
        rules: {
            user_point  :{  required:true , number:true },
            attendee_point:{  required:true , number:true },
            presenter_point:{  required:true , number:true },
           
        },
        messages: {
            user_point:{ required:"Please enter user point.", number:"Please enter valid user point."  },
            attendee_point:{ required:"Please enter attendee point.", number:"Please enter valid attendee point."  },
            presenter_point:{ required:"Please enter presenter point.", number:"Please enter valid presenter point." },
          },
    });
});
</script>
<div class="content-i setting_master_page manage_cms_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_container">
              <h6 class="element-header">Settings</h6>
                <div class="table-responsive accordion_content">
 
                    <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                      <?php 
                        if($this->session->flashdata('success') != ''){
                        ?>
                        <div class="alert-success alert alert-dismissible">
                            <?php echo $this->session->flashdata('success'); ?>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        <?php
                        }
                        if(!empty($imgerr)){
                        ?>
                        <div class="alert alert-success alert alert-dismissible">
                            <?php echo $imgerr; ?>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        <?php  
                        }
                          //print_r($setting); exit;
                      ?>
                      <div class="card">
                        <!-- Card header -->
                        <div class="card-header accordion" role="tab" id="headingTwo1">
                          <a class="" href="javascript:void(0)">
                            <h5 class="mb-0">
                              Logo <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                          </a>
                        </div>

                        <!-- Card body -->
                        <div class="accordion_inner" style="display: none;">
                          <div class="card-body">
                            <form class="cmsform" class="settingform cmsform light_font_form" id="adminlogoform" method="post" enctype="multipart/form-data">
                              <div class="col-sm-12">
                                <div class="form_group">
                                  <label>Change Site Logo</label>
                                    <input type="file" name="sitelogo" class="input_text">
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form_group">
                                   <input type="submit" name="logosubmit" class="input_submit" value="Update">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- Accordion card -->
                      <div class="card">
                     
                        <div class="card-header accordion" role="tab" id="headingThree31">
                          <a class="" href="javascript:void(0)">
                            <h5 class="mb-0">
                              Lets Keep In Touch <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                          </a>
                        </div>
                        <!-- Card body -->
                        <div class="accordion_inner" style="display: none;">
                          <div class="card-body">
                            <form  id="adminsetting"  method="post">
                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Admin Email</label>
                                      <input type="text" name="adminemail" class="input_text" value="<?php echo $setting->footer_email; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Admin Skype</label>
                                      <input type="text" name="adminskype" class="input_text" value="<?php echo $setting->footer_skype; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Facebook Link</label>
                                      <input type="text" name="fblink" class="input_text" value="<?php echo $setting->fb_link; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Linkedin Link</label>
                                      <input type="text" name="linkedinlink" class="input_text" value="<?php echo $setting->linkedin_link; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Instagram Link</label>
                                      <input type="text" name="instalink" class="input_text" value="<?php echo $setting->insta_link; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Skype Link</label>
                                      <input type="text" name="skypelink" class="input_text" value="<?php echo $setting->skype_link; ?>">
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <input type="submit" name="keepinsubmit" class="input_submit" value="Update">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                      </div>


                    <!-- Accordion card -->
                        <?php
                        if(!empty($imgerr)){
                        ?>
                        <div class="alert alert-success alert alert-dismissible">
                            <?php echo $imgerr; ?>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>
                        <?php  
                        }
                          //print_r($setting); exit;
                      ?>
                      <div class="card">
                        <!-- Card header -->
                        <div class="card-header accordion" role="tab" id="headingTwo1">
                          <a class="" href="javascript:void(0)">
                            <h5 class="mb-0">
                              Emarket Points <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                          </a>
                        </div>

                        <!-- Card body -->
                        <div class="accordion_inner" style="display: none;">
                          <div class="card-body">
                            <form class="cmsform" class="settingform cmsform light_font_form"  method="post" enctype="multipart/form-data" action="<?php echo base_url();?>/admin/Setting_Master/skillpoint_emarketpointaction" id="adminemarket">
                              <input type="hidden" name="point_type" value="1">
                              <input type="hidden" name="emskill_point_ID" value="<?php echo $skillpoint->emskill_point_ID;?>">
                              <div class="col-sm-12">
                                <div class="form_group">
                                <label>USD</label>
                                <input type="text" name="usd_dollar" class="input_text" value="<?php echo $skillpoint->em_usd;?>">
                                  <?php echo form_error('usd_dollar');?>
                                </div>
                                 <div class="form_group">
                                  <label>Emarket Point</label>  
                                    <input type="text" name="emarket_point" class="input_text" value="<?php echo $skillpoint->em_point;?>">
                                      <?php echo form_error('emarket_point');?>
                                </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form_group">
                                   <input type="submit" name="updateemarketpoint" class="input_submit" value="Update">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- Accordion card -->
                      <div class="card">
                     
                        <div class="card-header accordion" role="tab" id="headingThree31">
                          <a class="" href="javascript:void(0)">
                            <h5 class="mb-0">
                              Skill Points <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                          </a>
                        </div>
                        <!-- Card body -->
                        <?php $skillpointexp=explode(',',$skillpoint->skill_points);?>
                        <div class="accordion_inner" style="display: none;">
                          <div class="card-body">
                            <form  method="post" id="adminskillpoint" action="<?php echo base_url();?>/admin/Setting_Master/skillpoint_emarketpointaction">
                              <input type="hidden" name="point_type" value="2">
                               <input type="hidden" name="emskill_point_ID" value="<?php echo $skillpoint->emskill_point_ID;?>">
                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>User</label>
                                      <input type="text" name="user_point" class="input_text" value="<?php echo $skillpointexp[0]; ?>">
                                        <?php echo form_error('user_point');?>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Attendee</label>
                                      <input type="text" name="attendee_point" class="input_text" value="<?php echo $skillpointexp[1]; ?>">
                                        <?php echo form_error('attendee_point');?>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="form_group">
                                    <label>Presenter</label>
                                      <input type="text" name="presenter_point" class="input_text" value="<?php echo $skillpointexp[2]; ?>">
                                        <?php echo form_error('presenter_point');?>
                                  </div>
                                </div>
                                <div class="col-sm-12">
                                  <input type="submit" name="skillsubmit" class="input_submit" value="Update">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    
                    </div>
                </div>
            </div>
        </div>
      </div>

<!-- Accordion wrapper -->
<style>
.accordion {
   
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

.active, {
    background-color: #cccccc;
}

.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}
.content_opend .panel {
  max-height: initial;
}
</style>


<script>
// var acc = document.getElementsByClassName("accordion");
// var i;

// for (i = 0; i < acc.length; i++) {
//   acc[i].addEventListener("click", function() {
//     this.classList.toggle("active");
//     var panel = this.nextElementSibling;
//     if (panel.style.maxHeight){
//       panel.style.maxHeight = null;
//     } else {
//       panel.style.maxHeight = panel.scrollHeight + "px";
//     } 
//   });
// }
$(document).on('click','.card-header',function (e) {
    // alert($(e.target).parent('div.accorion_inner').attr("class"));
    if ($(this).parent("div").hasClass('content_opend')) {
        $(this).parent("div").removeClass('content_opend');
        $(this).siblings('.accordion_inner').slideUp();
    } else if ($(this).parent("div").siblings("div").hasClass('content_opend')) {
        $(this).parent("div").siblings("div").removeClass('content_opend');
        $(this).parent("div").siblings("div").children('.accordion_inner').slideUp();
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    } else {
        $(this).parent("div").addClass('content_opend');
        $(this).siblings('.accordion_inner').slideDown();
    }
});
</script>

