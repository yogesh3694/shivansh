<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
$(function(){
  $.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z]*$/);
    });
    $('#contactus').validate({
        ignore: ".ignore",
        rules: {
            firstname: {
              required:true,
              lettersonly:true
            },
            lastname: {
              required:true,
              lettersonly:true
            },
            email: 
                { required:true,
                  email:true 
                },
            subject:"required",
            message:"required" ,
            hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            }

        },
        messages: {
            firstname: {
              required:"Please enter first name.",
              lettersonly:"Please enter valid first name."
            },
            lastname: {
              required:"Please enter last name.",
              lettersonly:"Please enter valid last name."
            },
            email:{ required:"Please enter email address.",email:"Please enter valid email address.", },
            subject:"Please enter subject.",
            message:"Please enter message.",
            hiddenRecaptcha:{ required:"Please validate captcha." },  

            //subcategory:"Please enter sub category",
        },
        errorPlacement: function(error, element) {
          if(element.attr('name') == "hiddenRecaptcha"){
              jQuery('.captchacls').after(error);//.append(error);
          }
          else {
              error.insertAfter(element);
          }
        },
    }); 
}); 
</script>
 <div class="main">
        <div class="bradcume-section">
            <div class="container">
                    <h2>contact us</h2>
            </div>
        </div>
        <section class="contact-us-area">
             <div class="container">
          <?php if($this->session->flashdata('contacterror') != ""){ ?>
              <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('contacterror'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
          <?php } ?>
          <?php if($this->session->flashdata('contactsuccess') != ""){ ?>
              <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('contactsuccess'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
          <?php } ?> 
                 <div class="row">
                     <div class="col-md-8 contact01">
                        <h2>get in touch</h2>
                        <p>If you have any questions about our services please do not hesitate to contact us.</p>
                         <form name="contactus" action="<?php echo base_url(); ?>Cms_Front/contactmail" id="contactus" method="post">
                            <div class="row">
                            <div class="form-group col-md-6 col-sm-6 form-controlcls01">
                                
                                    <label class="form-label">first name</label>
                                    <input type="text" name="firstname" class="form-controlcls">
                                                <?php echo form_error('firstname'); ?> 
                                
                            </div>
                            <div class="form-group col-md-6 col-sm-6 form-controlcls02">
                                
                                    <label class="form-label">subject</label>
                                    <input type="text" name="subject" class="form-controlcls">
                                                <?php echo form_error('subject'); ?> 
                                
                            </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6 col-sm-6 form-controlcls01">
                                
                                    <label class="form-label">last name</label>
                                    <input type="text" name="lastname" class="form-controlcls">
                                                <?php echo form_error('lastname'); ?> 
                               
                                   <div class="form-group form-controlcls01 customgroup">
                                
                                    <label class="form-label">Email address</label>
                                    <input type="text" name="email" class="form-controlcls">
                                                <?php echo form_error('email'); ?> 
                                
                                     </div>

                                
                            </div>
                            <div class="form-group col-md-6 col-sm-6 form-controlcls02">
                                
                                    <label class="form-label">message</label>
                                    <textarea name="message" class="form-controlcls custom-msg"></textarea>
                                            <?php echo form_error('message'); ?> 
                                
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group captchacls">
                                    <!-- <div class="g-recaptcha" data-sitekey="6Ldmh30UAAAAAF2DCKpNg5aej1OuBojpBHfVWjfO"></div> -->
                                    
                          <div class="g-recaptcha" data-sitekey="6Ldmh30UAAAAAF2DCKpNg5aej1OuBojpBHfVWjfO"></div>
      <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">

                                </div>
                                  <!-- <label class="error" name='captcha' id="recaptcha-error" style="display: none;"></label>    -->
                            </div>
                            </div>
                            <div class="clear"></div>
                            <div class="button-prn">
                                <input type="submit" class="blue-button" name="contactsubmit" value="send message">
                            </div>
                           
                        </form>
                     </div>
                     <div class="col-md-4">
                         <div class="contact-info">
                             <h2>Contact Information</h2>
                             <p><i class="icon icon-icon-17"></i> 55 Petaling Street, Kuala Lumpur, Malaysia</p>
                             <p><a href="mailto:<?php echo $details->footer_email; ?>"><?php echo $details->footer_email; ?><i class="icon icon-icon-18"></i></a></p>
                             <p><a href="skype:<?php echo $details->footer_skype; ?>"><?php echo $details->footer_skype; ?><i class="fa fa-skype" aria-hidden="true"></i></a></p>

                        <ul class="foot-social-icon">
                        <?php if($details->fb_link == '#'){$fbtarget =''; }else{ $fbtarget= 'target="_blank"'; } ?>
                        <?php if($details->linkedin_link == '#'){$litarget =''; }else{ $litarget= 'target="_blank"'; } ?>
                        <?php if($details->insta_link == '#'){$instatarget =''; }else{ $instatarget = 'target="_blank"'; } ?>

                            <li><a <?php echo $fbtarget; ?> href="<?php echo $details->fb_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a <?php echo $litarget; ?> href="<?php echo $details->linkedin_link; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a <?php echo $instatarget; ?> href="<?php echo $details->insta_link; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="<?php echo $details->skype_link; ?>"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                        </ul>
                         </div>
                     </div>
                 </div>
             </div> 
        </section>
   </div> 