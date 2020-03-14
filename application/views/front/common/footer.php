
<footer>
  <?php $setting = $this->MainModel->get_singlerecord('trader_settings',array('setting_ID'=> 1)); ?>
    <section class="footer-section" id="footerpart">
      <div class="container">
        <div class="row">
          <div class="col-md-4 foot-quick-link-section">
            <div class="fotitle">
              <h2>quick links</h2>
            </div>
            <ul>
              <li><a href="<?php echo base_url();?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> home</a></li>
              <li><a href="<?php echo base_url();?>faq"><i class="fa fa-angle-double-right" aria-hidden="true"></i> fAQs</a></li>
              <li><a href="<?php echo base_url();?>Discussion"><i class="fa fa-angle-double-right" aria-hidden="true"></i> discussions</a></li>
              <li><a href="<?php echo base_url() ?>contact-us"><i class="fa fa-angle-double-right" aria-hidden="true"></i> contact us</a></li>
              <li><a href="<?php echo base_url();?>about-us"><i class="fa fa-angle-double-right" aria-hidden="true"></i> about us</a></li>
              <li><a href="<?php echo base_url().'Privacy-Policy'; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> privacy policy</a></li>
              <li><a href="<?php echo base_url().'How-its-works'; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> how it works</a></li>
              <li><a href="<?php echo base_url().'Terms-Condition'; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> terms & conditions</a></li>
            </ul>
          </div>
          <div class="col-md-4 foot-keep-in-touch-main">
            <div class="fotitle">
              <h2>let's keep in touch</h2>
            </div>
            <ul class="foot-network-link">
              <li><a target="_blank" href="mailto:<?php echo $setting->footer_email; ?>"><i class="zmdi zmdi-email"></i> <?php echo $setting->footer_email; ?></a></li>
              <li><a target="_blank" href="skype:<?php echo $setting->footer_skype; ?>"><i class="fa fa-skype" aria-hidden="true"></i> <?php echo $setting->footer_skype; ?></a></li>
            </ul>
            <ul class="foot-social-icon">
              <li><a  href="<?php echo $setting->fb_link; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a  href="<?php echo $setting->linkedin_link; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
              <li><a  href="<?php echo $setting->insta_link; ?>"><i class="icon icon-insta" aria-hidden="true"></i></a></li>
              <li><a target="_blank" href="<?php echo $setting->skype_link; ?>"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
            </ul>
          </div>
          <div class="col-md-4 foot-newsletter-section">

            <div class="fotitle">
              <h2>email newsletter</h2>
            </div>
            <p>Subscribe to us and we will automatically provide you daily update.</p>
            
              <div class="email-txt">
                <form id="subscribeform" method="post" action="<?php echo base_url() ?>User_Master/subscribe_mailchimp"> 
                <!-- <form method="post" action="<?php echo base_url(); ?>User_Master/subscribe_mailchimp">  -->
                <input type="text" name="subscribe_mail" placeholder="Enter your email here">
                <button type="submit" class="blue-button" name="subbtn">subscribe</button>
                </form>
                <?php if($this->session->flashdata('err_msg') != ""){
                    echo '<label class="subscribeerr_cls error">'.$this->session->flashdata('err_msg').'</label>';
                   }
                   if($this->session->flashdata('suc_msg') != ""){
                    echo '<div class="subscribesuc_cls">'.$this->session->flashdata('suc_msg').'</div>';
                   }
                    ?>
              </div>
             

          </div>
        </div>
      </div>
    </section>
    <section class="copyright-section">
      <p>Copyright © 2018 Trader Network.<span> All Rights Reserved.</span></p><button class="footertop_cls" onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
    </section>
  </footer>
<script type="text/javascript"> 
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
} 
function topFunction() {
    $('html, body').animate({
        scrollTop: 0 }, 800);
}

$(document).ready(function () {

     $(".responsive-menu-icon").click(function () {
        $(".headerinnercontainer").toggleClass('openn');
        $(this).toggleClass('openn');
        $('body').toggleClass('toggle_overlay');
      });

  $('#subscribeform').validate({
        rules: {
            subscribe_mail:{ required:true, email:true },
        },
        messages: {
            subscribe_mail:{ required:"Please enter email address.", email:"Please enter valid email address." },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

      

      var dateFormat = "mm/dd/yy",
        from = $("#datepicker-form")
          .datepicker({
            //defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1

          })
          .on("change", function () {
            to.datepicker("option", "minDate", getDate(this));
           
           $('#datepicker-to').rules('add', {
        required: true,

        messages:{
        required:"Please select todate.",

        }
        });
            
          }),
        to = $("#datepicker-to").datepicker({
          //defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
          .on("change", function () {
            from.datepicker("option", "maxDate", getDate(this));
            $('#datepicker-form').rules('add', {
        required: true,

        messages:{
        required:"Please select from date.",

        }
        });

          })

      function getDate(element) {
        var date;
        try {
          date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
          date = null;
        }

        return date;
      }
    });
  </script>
  <script>
   jQuery(window).bind( "resize ready load", function(e) { comon_mincontentheight();    }); 
    function comon_mincontentheight() {
      var wheight01 = jQuery(window).height();
      var fotheight01 = jQuery('footer').outerHeight();
      var cphert1 = wheight01 - fotheight01;
      if (jQuery('.main').length > 0) {
        jQuery('.main').css({ "min-height": cphert1 });
      }

    }
  </script>
</body>

</html>