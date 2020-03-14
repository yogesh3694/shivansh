<!DOCTYPE html>
<html lang="en-US">

<head>

  <title><?php echo $page_title;?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo  base_url();?>assets/front/images/favicon.png" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/fonts/importfont.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/icon/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/icon/css/material-design-iconic-font.min.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/select2.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/jquery-ui-timepicker-addon.css" />
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/jquery.fileupload-ui.css">
    <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/style.css" />


   <!--  <script src="<?php echo  base_url();?>assets/front/js/jquery-3.3.1.min.js"></script> -->
    <script src="<?php echo  base_url();?>assets/front/js/jquery.min-3-2-1.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/bootstrap.min.js"></script>
     <script src="<?php echo  base_url();?>assets/front/js/jquery-ui.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/jquery-ui-timepicker-addon.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/moment.min.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/select2.js"></script>
   
    <script src="<?php echo  base_url();?>assets/front/js/combodate.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/jquery.fileupload.js"></script>
    <script src="<?php echo  base_url();?>assets/front/js/jquery.fileupload-ui.js"></script>
    <script src="<?php echo base_url();?>assets/admin/js/jquery.validate.js" type="text/javascript"></script>

    
     <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/animate.css"/>
     <script src="//cdnjs.cloudflare.com/ajax/libs/wow/0.1.12/wow.min.js"></script>
     <!-- <script type="javascript" src="<?php echo  base_url();?>assets/front/js/wow.min.js"></script>  -->
</head>

<!-- BODY SECTION START -->

<body>
<script type="text/javascript">
  
    // wow = new WOW(
    // {
    // boxClass:     'wow', 
    // animateClass: 'animated',
    // offset:       100
    // }
    // );
    // wow.init(); 
    new WOW().init();  
    
    jQuery(window).bind("load", function() {
       
     /*$.ajax({
        type:'POST',
        url:"<?php echo base_url().'Discussion/feedback_mail' ?>",
        //data:{ bid:ID,discussion:dis,joinas:joinas },
        success:function(html){}
    });*/

  }); 
  jQuery(window).on('load', function(){
    jQuery('#cover').fadeOut(700);
  });
</script>
  <div class="loader" id="cover"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div>
  
  <header>
    <?php $setting = $this->MainModel->get_singlerecord('trader_settings',array('setting_ID'=> 1));
          $noticount = $this->MainModel->get_notificationcount($this->session->userdata('userid'));
          $noticountsmall = $this->MainModel->get_notification($this->session->userdata('userid'),5);
     ?>
    <section class="main-header-section">
      <div class="container">
        <div class="row">
          <div class="responsive-menu-icon">
            <i class="fa fa-bars" aria-hidden="true"></i>
          </div>
          <div class="headerinnercontainer">
            <div class="logo-img-area"><a class="logo_svg" href="<?php echo  base_url(); ?>"><img src="<?php echo  base_url();?>upload/logo/<?php echo $setting->logo; ?>"></a></div>
            <div class="hd-right">
              <div class="logo-img-area mobile"><a class="logo_svg" href="<?php echo  base_url(); ?>"><img src="<?php echo  base_url();?>upload/logo/<?php echo $setting->logo; ?>"></a></div>
            <div class="header-right-area">
              <ul class="register-login-btn-area">
                <li class="libtn"><a href="<?php echo base_url();?>Post-Discussion" class="btn-bule-outline">+ post discussion</a></li>
                <?php 
                if($this->session->userdata('userid')  != '') {
                  $user = $this->MainModel->get_singlerecord('trader_user',array('user_ID'=> $this->session->userdata('userid') ));
                ?>
                     <!--  <li class="dropdown notification">
                      <a href="<?php echo base_url(); ?>notification" ><i class="icon icon-icon-9"></i>
                        <?php if($noticount != '0'){ echo "<span class='n_count'>".$noticount."</span>"; } ?>
                      </a>
                      </li> -->
                      <li class="dropdown notification setting notidiv">
                          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-icon-9"></i><span class="n_count">
                            <?php if($noticount != '0'){  echo $noticount; }else{  echo '0'; }?></span></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton05">
                             <?php
    // echo "<pre>"; print_r($noticountsmall);  
if(!empty($noticountsmall)){ 
      foreach ($noticountsmall as $not) {
        if($not->joinas = '1'){ $joinas='as attendee'; }else{ $joinas='as presenter'; }
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; }
        ?><li class="dropdown-item">
          <div class="notification_main_content <?php echo $ncls; ?>">
            <a href="javascript:void(0)" class="noti_close noti_closesmall" data-id="<?php echo $not->notification_ID;?>">x</a>

            <div class="noti_img">
              <?php 
                    if($not->profile_photo != ''){
                      $image_path = base_url('upload/profile/' . $not->profile_photo);
                      $thumb_path = preg_replace('~\.(?!.*\.)~', '-70x70.', $image_path);

                      ini_set('allow_url_fopen', true);

                      if (getimagesize($thumb_path)) {
                          $image_path2 = $thumb_path;
                      }
                      if($image_path2 != ''){
                      ?>
                          <img src="<?php echo $image_path2; ?>" />    
                      <?php
                      }
                      else{
                      ?> 
                        <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                  <?php }  
                    }
                else{
                 ?>
                    <img src="<?php echo base_url() ?>assets/images/none-user-70x70.jpg" />  
                 <?php
                } ?>
            </div>
        <?php if($not->type == '13' || $not->type == '2' || $not->type == '6'){ ?>
                  <a href="<?php echo base_url();?>view-discussion/<?php echo $not->post_discu_ID;?>?n2=<?php echo $not->notification_ID;?>">
             <?php
              }
              elseif($not->type == '16'){ ?>
                <a href="<?php echo base_url();?>my-account-dashboard">
                <?php
              }
              else{
                  ?>
                  <a href="<?php echo  base_url();?>discussion-details/<?php echo $not->post_discu_ID;?>?n1=<?php echo $not->notification_ID;?>">
            <?php } ?>
        
          <div class="noti_text">
            <div class="noti_title">
            <h3><?php 
                          
                          ?>
                          <?php
                          if($not->type == '1'){
                           
                              if($not->as_Type == '1'){
                                $astype = 'presenter';
                              }
                              else{
                                $astype = 'attendee'; 
                              }
                           echo ucwords($not->virtual_name).' has invited you for <b>'.ucwords($not->discussion_title).'</b> Discussion as '.$astype; 
                        }
                        elseif($not->type == '2'){
                          echo ucwords($not->virtual_name).' has bid on <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '3'){
                          echo ucwords($not->virtual_name).' has approve your bid for the <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '4'){
                          echo ucwords($not->virtual_name).' sent request to decrease your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '5'){
                          echo ucwords($not->virtual_name).' sent request to increase your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;  
                        }
                        elseif($not->type == '6'){
                          echo ucwords($not->virtual_name).' has rebid on <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '7'){
                          echo ucwords($not->virtual_name).' has accept the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '8'){
                          echo ucwords($not->virtual_name).' has decline the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion '.$joinas;
                        }
                        elseif($not->type == '9'){
                          echo ucwords($not->virtual_name).' has Cancelled <b>'.ucwords($not->discussion_title). '</b> Discussion';
                        }
                        elseif($not->type == '10'){
                          echo '<b>'.ucwords($not->discussion_title).'</b> Discussion is completed';
                        }
                        elseif($not->type == '11'){
                          echo 'Discussion Date is changed for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '12'){
                          echo 'Please Give Your Feedback to Presenter for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '13'){
                          echo 'Please Complete Your <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '14'){
                          echo 'Congratulation You are earning for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '16'){
                          echo 'Admin has approve your withdraw request <b>'.ucwords($not->discussion_title).'</b>';
                        }
                    ?>
                  </h3>
                  </div>
                
                    <?php
                    $datetime1 = new DateTime("now");
                    $datetime2 = new DateTime($not->createdDate);
                    $interval = $datetime1->diff($datetime2);
                     
                    if(strtotime($not->createdDate) < strtotime('-1 days')) {
                        
                         ?>
                          <div class="noti_time">
                             <ul>
                                 <li><?php echo  date('d F Y',strtotime($not->createdDate));?></li>
                                 <li><?php echo date('h:i A',strtotime($not->createdDate));?></li>
                             </ul>
                           </div>
                             <?php
                                  
                    }
                    else{
                        
                        if($interval->format("%H") == '0')
                        {
                           echo '<div class="noti_hours"><p>'.$interval->format("%I").'min ago.</p></div>';
                            
                        }
                        else
                        {
                           
                            echo "<div class='noti_hours'><p>".$interval->format("%h").' hour ago'."</p></div>";
                            
                        }  
                    }
                  ?>
                </div>
                  </a>
                </div>
              </li>
            <?php } ?>
          <li class="dropdown-item">
            <div class="see_all_noti"> 
              <a href="<?php echo base_url(); ?>notification" >See all notifications</a>
            </div>
          </li>
      <?php } 
      else{ 
        ?>
        <li class="dropdown-item"><div class="no_noti_found">Notifications not found.</div></li>
      <?php } ?>
    </ul>
                    </li>
                   <li class="dropdown setting">
                      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton03"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-icon-10"></i></a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton03">
                          <li class="dropdown-item"><a href="<?php echo base_url('billing-method'); ?>"><i class="icon icon-icon-12"></i>Billing Method </a></li>
                          <li class="dropdown-item"><a href="<?php echo base_url() ?>change-password"><i class="icon icon-icon-13"></i>Password & Security</a></li>
                          <li class="dropdown-item"><a href="<?php echo base_url('notification-setting'); ?>"><i class="icon icon-icon-9"></i>Notification Setting </a></li>
                          <li class="dropdown-item"><a href="<?php echo base_url('withdrawal'); ?>"><i class="fa fa-money"></i>Withdrawal Setting</a></li>
                      </ul>
                  </li>
                  <li class="note-pade"><a href="<?php echo base_url(); ?>my-payments"><i class="icon icon-icon-11"></i></a></li>
                  <li class="dropdown liuser-profile">
                    <?php
                      if($user->profile_photo != ''){
                          $image_path = base_url('upload/profile/' . $user->profile_photo);
                          $thumb_path = preg_replace('~\.(?!.*\.)~', '-47x39.', $image_path);

                          ini_set('allow_url_fopen', true);

                          if (getimagesize($thumb_path)) {
                              $image_path = $thumb_path;
                          }
                      ?>
                        <img src="<?php echo $image_path; ?>">
                      <?php
                      }
                      else{
                      ?>
                        <img src="<?php echo base_url(); ?>assets/admin/img/blank_usr_img.jpg" with='47px' height="39px">
                      <?php 
                      }
                     ?>
                      <a href="javascript:void(0)" class="dropdown-toggle"
                          data-toggle="dropdown" id="dropdownMenuButton" aria-haspopup="true"
                          aria-expanded="false">
                          <?php

                           echo ($user->virtual_name !='' ? $user->virtual_name : $user->first_name.' '.$user->last_name);
                            ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li class="dropdown-item"><a href="<?php echo base_url(); ?>my-account-dashboard"><i class="fa fa-user" aria-hidden="true"></i> My Profile</a></li>
                          <li class="dropdown-item"><a href="<?php echo base_url().'logout'; ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                      </ul>
                      <script> jQuery(function () { jQuery('html').addClass('user_login'); });  </script>
                  </li>
                  <?php                    
                  }
                  else{
                  ?>
                  <li class="lilogin"><a href="<?php echo base_url().'login'; ?>"><i class="icon icon-icon-19"></i> login</a></li>
                  <li class="liregister"><a href="<?php echo base_url().'register'; ?>"><i class="zmdi zmdi-edit"></i> register</a></li> 
                  <?php  
                  }
                ?>
              </ul>
            </div>
            <ul class="header-menu-area">
               <?php 
                if($this->session->userdata('userid')  != '') {
                ?>
                  <li><a href="<?php echo base_url();?>Discussion">discussions</a></li>
                  <li class="dropdown">
                      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton02"
                          aria-haspopup="true" aria-expanded="false">my discussions <i class="fa fa-angle-down"
                              aria-hidden="true"></i></a>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton02">
                          <li class="dropdown-item"><a href="<?php echo base_url(); ?>my-created-discussion">Created Discussions</a></li>
                          <li class="dropdown-item"><a href="<?php echo base_url(); ?>my-attended-discussion"">Attended Discussions</a></li>
                      </ul>
                  </li>  
                <?php
                }
                else{
                ?>
                  <li><a href="<?php echo base_url();?>">home</a></li>
                  <li><a href="<?php echo base_url();?>Discussion">discussions</a></li>
                  <li><a href="<?php echo base_url().'about-us'; ?>">about us</a></li>
                  <li><a href="<?php echo base_url().'How-its-works'; ?>">how it works</a></li>
                <?php
                }
                ?>
            </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
      <?php if($this->session->userdata('userid')) { ?>
    $(document).ready(function(){
        setInterval(function() {
           jQuery('.loader').show();
            $(".notidiv").load("<?php echo base_url();?>User_Main/notification_ajax");
             jQuery('.loader').hide();
        }, 3000);
    });
  <?php } ?>
 jQuery(document).on("click",".noti_closesmall",function(){
  jQuery('.loader').show();
    var notid = $(this).attr('data-id'), close = $(this).parent('.notification_main_content');
    
       $.ajax({
          type:'POST',
          datatype:'json',
          url:"<?php echo base_url().'User_Main/close_notification' ?>",
          data:{ nid:notid },
          success:function(html){  
            var res = jQuery.parseJSON(html);
            
            $('.notidiv').addClass('open');
            $(".notidiv").load("<?php echo base_url();?>User_Main/notification_ajax");
            jQuery('.loader').hide();
            // close.fadeOut(350, function() {
            //      close.remove();
            //   });
          }
      });
  });
</script>
  </header>