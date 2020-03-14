<script src="<?php echo base_url(); ?>assets/front/js/jquery.responsive-accordion-tabs.min.js"></script>


<a href="#" data-toggle="modal" data-target="#aprv_popup">approve popup</a>
<br>
<a href="#" data-toggle="modal" data-target="#rbid_disc_popup">Rebid For Discussion</a>
<br>
<a href="#" data-toggle="modal" data-target="#paymentpopop">Payment popup</a>
<br> 
<a href="#" data-toggle="modal" data-target="#feedbackpopop">Give Feedback</a>
<br> 
<div class="approve_popup custom_popup">
  <div class="modal fade" id="aprv_popup" role="dialog">
    <div class="modal-dialog">
      <div class="popup_middile">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"></button>
            <h4 class="modal-title">Are you sure you want to approve this bid?</h4>
          </div>
          <div class="modal-body">
            <div class="popup_text">
              <p>Total payable amount for this discussion is <b>$450</b>. User as attendee has bid 10% for this discussion. </p>
            </div>
            <div class="popup_btn_content">
              <button type="button" class="btn-bule-outline pop_confirm_btn" data-dismiss="modal">confirm</button>
              <button type="button" class="btn-bule-outline" data-dismiss="modal">cancle</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="rebid_disc_popup custom_popup">
  <div class="modal fade" id="rbid_disc_popup" role="dialog">
    <div class="modal-dialog">
      <div class="popup_middile">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Rebid For Discussion</h4>
          </div>
          <div class="modal-body">
            <div class="popup_text">
              <p>Total payable amount for this discussion is <b>$450</b>. Now if you are interest in this discussion then you can contribute in percentage of total amount for this discussion as attendee.</p>
              <span>Your Last Bid is 10%.</span>
            </div>
            <div class="popup_form">
              <form>
                <div class="form_group">
                  <label>Your Bid (%)</label>
                  <input type="text" class="input_text" value="" name="" />
                  <input type="submit" class="input_submit" value="submit">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="feedback_popup custom_popup">
  <div class="modal fade" id="feedbackpopop" role="dialog">
    <div class="modal-dialog">
      <div class="popup_middile">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"></button>
            <h4 class="modal-title">Give Feedback</h4>
          </div>
          <div class="modal-body">
            <div class="feedback_text_msg">
              Your feedback is important to us. The rating will relate to the amount pay to the presenter. Please do it wisely. Thank for yozur support.
            </div>
            <div id="pop_accordion" class="uia-feedback">
                 <div class="ui-accordion-header">
                    <div class="circle-img-main-div">
                      <img src="<?php echo base_url(); ?>assets/front/images/circle-img1.png">
                    </div>
                    <div class="feedback-user-title">Jeremy Remark</div>
                </div>
                 <div class="ui-accordion-content">
                  <div class="form_group">
                      <div class="rating-title">rating</div>
                      <div class="starrating-div">
                          <div class="rating-div"><i class="zmdi zmdi-star"></i></div>
                          <div class="rating-div"><i class="zmdi zmdi-star"></i></div>
                          <div class="rating-div"><i class="zmdi zmdi-star"></i></div>
                          <div class="rating-div"><i class="zmdi zmdi-star"></i></div>
                          <div class="rating-div"><i class="zmdi zmdi-star"></i></div>
                      </div>
                    </div>
                  <div class="form_group">
                      <div class="rating-title">Your Review</div>
                      <textarea class="input_textarea"></textarea>
                  </div>
                </div>
                 <div class="ui-accordion-header">
                 <div class="circle-img-main-div">
                      <img src="<?php echo base_url(); ?>assets/front/images/circle-img1.png">
                    </div>
                    <div class="feedback-user-title">Maria Lehman</div>
                </div>
                 <div class="ui-accordion-content">
                    <div class="popup_text">
                      <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
                    </div>
                 </div>
              </div>
              <div class="popup_btn_content">
                  <button type="button" class="btn-bule-outline" data-dismiss="modal">submit</button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade paynow-popup" id="paymentpopop" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h4 class="modal-title">Pay $450</h4>
         </div>
         <div class="modal-body">
            <form class="bs-example" action="">
               <div class="panel-group" id="pay_accordion">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">
                           <label for='r11' class="customradiobox">
                           <input type='radio' id='r11' name='occupation' value='Working' required /> Payment From Your <span>1549</span> E-market Points
                           <span class="customradiobox-inner"></span>
                           <a data-toggle="collapse" data-parent="#pay_accordion" href="#collapseOne"></a>
                           </label>
                        </h4>
                     </div>
                     <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                           <ul class="btm_spcing">
                              <li>
                                 <label class="customradiobox">
                                 <input value="" name="agegroup03" type="radio" id="#r12">
                                 <span class="customradiobox-inner"></span>
                                 xxxx xxxx xxxx 9589
                                 </label>
                              </li>
                              <li>
                                 <label class="customradiobox">
                                 <input value="" name="agegroup03" type="radio">
                                 <span class="customradiobox-inner"></span>
                                 xxxx xxxx xxxx 1456
                                 </label>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="panel panel-default account-billing-section">
                     <div class="panel-heading">
                        <h4 class=panel-title>
                           <label for='r12' class="customradiobox">
                           <input type='radio' id='r12' name='occupation' value='Not-Working' required />  Payment From Credit Card
                           <span class="customradiobox-inner"></span>
                           <a data-toggle="collapse" data-parent="#pay_accordion" href="#collapseTwo"></a>
                           </label>
                        </h4>
                     </div>
                     <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                           <ul class="btm_spcing">
                              <li class="credit-card-section">
                                 <label class="customradiobox">
                                 <input value="" name="agegroup02" type="radio">
                                 <span class="customradiobox-inner"></span>
                                 xxxx xxxx xxxx 9589
                                 </label>
                                 <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png"></div>
                              </li>
                              <li class="credit-card-section">
                                 <label class="customradiobox">
                                 <input value="" name="agegroup02" type="radio">
                                 <span class="customradiobox-inner"></span>
                                 xxxx xxxx xxxx 1456
                                 </label>
                                 <div class="pay-img"><img src="<?php echo base_url(); ?>assets/front/images/credit-card-img2.png"></div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default blue-button" data-dismiss="modal">submit</button>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      
      $(".responsive-menu-icon").click(function(){
              $(".headerinnercontainer").toggleClass('openn');
              $(this).toggleClass('openn');
            });
            $( "#tabs" ).tabs({ collapsible: true});
            

             var $accordionTabs = $('.accordion-tabs');
                $accordionTabs.accordionTabs({ mediaQuery: '(min-width: 40em)' }, 
                                         {header: 'h1', heightStyle: 'content'}, 
                                         { show: {effect: 'fade'}
            });

             comon_mincontentheight();
             $( "#pop_accordion" ).accordion({
                   heightStyle: "content",
                 });

               function alignModal(){

        var modalDialog = $(this).find(".modal-dialog");

        /* Applying the top margin on modal dialog to align it vertically center */

        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));

    }

    // Align modal when it is displayed

    $(".modal").on("shown.bs.modal", alignModal);

    

    // Align modal when user resize the window

    $(window).on("resize", function(){

        $(".modal:visible").each(alignModal);

    });   
      });
  
        
        jQuery(window).resize(function(e) {
                  comon_mincontentheight();
        });
            
        function comon_mincontentheight (){
                var wheight01 = jQuery(window).height();                        
                var fotheight01 = jQuery('footer').outerHeight();   
                var cphert1 = wheight01 - fotheight01;            
                if(jQuery('.main').length > 0)
                  {
                      jQuery('.main').css({"min-height":cphert1});
                  }
                
        }
   
       
    </script>




  <script type="text/javascript">
    $(document).ready(function(){
      $(".responsive-menu-icon").click(function(){
              $(".headerinnercontainer").toggleClass('openn');
              $(this).toggleClass('openn');
            });
            $( "#tabs" ).tabs({ collapsible: true});
            

             var $accordionTabs = $('.accordion-tabs');
                $accordionTabs.accordionTabs({ mediaQuery: '(min-width: 45em)' }, 
                                         {header: 'h1', heightStyle: 'content'}, 
                                         { show: {effect: 'fade'}
            });

             comon_mincontentheight();

             // $( "#accordion" ).accordion({
             //       heightStyle: "content",
             //     });

              function alignModal(){

        var modalDialog = $(this).find(".modal-dialog");

        /* Applying the top margin on modal dialog to align it vertically center */

        modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));

    }

    // Align modal when it is displayed

    $(".modal").on("shown.bs.modal", alignModal);

    

    // Align modal when user resize the window

    $(window).on("resize", function(){

        $(".modal:visible").each(alignModal);

    });   

      });
  
        
        jQuery(window).resize(function(e) {
                  comon_mincontentheight();
        });
            
        function comon_mincontentheight (){
                var wheight01 = jQuery(window).height();                        
                var fotheight01 = jQuery('footer').outerHeight();   
                var cphert1 = wheight01 - fotheight01;            
                if(jQuery('.main').length > 0)
                  {
                      jQuery('.main').css({"min-height":cphert1});
                  }
                
        }
        $('#r11').on('click', function(){
              $(this).parent().find('a').trigger('click')
            })

        $('#r12').on('click', function(){
          $(this).parent().find('a').trigger('click')
        })
       
    </script>