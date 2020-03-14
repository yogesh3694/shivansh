<script>
<?php if($this->session->userdata['logged_in']['adminid']) { ?>

$(document).ready(function(){
    setInterval(function() { 
        $(".notidiv").load("<?php echo base_url();?>admin/User_Master/notification_ajax");
    }, 1500);
});
<?php } ?>
 jQuery(document).on("click",".noti_closesmall",function(){
  jQuery('.loader').show();
    var notid = $(this).attr('data-id'), close = $(this).parent('.notification_main_content');
    
       $.ajax({
          type:'POST',
          datatype:'json',
          url:"<?php echo base_url().'admin/User_Master/close_notification' ?>",
          data:{ nid:notid },
          success:function(html){  
            var res = jQuery.parseJSON(html);
            
            $('.notidiv').addClass('open');
            $(".notidiv").load("<?php echo base_url();?>admin/User_Master/notification_ajax");
             jQuery('.loader').hide();
          }
      });
  });
</script>
  <!-- <link rel="stylesheet" href="<?php echo  base_url();?>assets/front/css/bootstrap.min.css" />    -->
  
<?php $admin = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=> $this->session->userdata['logged_in']['adminid'] )); 
    $noticount = $this->AdminModel->get_notificationcount($this->session->userdata['logged_in']['adminid']);
    $noticountsmall = $this->AdminModel->get_notification($this->session->userdata['logged_in']['adminid'],5);?>
 <div class="content-w">
<!-- <div class="loader" id="cover"><img src="<?php echo base_url();?>assets/front/images/loader.svg"></div> -->
 
    <div class="top-bar color-scheme-transparent">
 
        <div class="toggle_icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="top-menu-controls">
            <div class="comments_link notification notidiv">
                <a href="<?php echo base_url('admin/notification'); ?>" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-24"></i>
                <?php $noticount = $this->AdminModel->get_notificationcount($this->session->userdata['logged_in']['adminid']); ?>
                <?php if($noticount != '0'){ echo "<span class='n_count_admin'>".$noticount."</span>"; } ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton05">
                             <?php
    // echo "<pre>"; print_r($noticountsmall);  
if(!empty($noticountsmall)){ 
      foreach ($noticountsmall as $not) {
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; }
        ?><li class="dropdown-item <?php echo $ncls;?>">
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
            <?php
            if($not->type == '15'){
              ?>
                <a href="<?php echo base_url() ?>admin/view-withdrow/">
              <?php
              }
              else{
              ?>
                <a href="<?php echo base_url() ?>admin/view-discussion/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
              <?php
              }
            ?>
                  <a href="<?php echo  base_url();?>admin/view-discussion/<?php echo $not->post_discu_ID;?>?n=<?php echo $not->notification_ID;?>">
            <div class="noti_text">
               <div class="noti_title">
           <h3><?php 
                        if($not->type == '1'){
                          echo ucwords($not->virtual_name).' has bid on <b>'.ucwords($not->discussion_title).'</b> Discussion'; 
                        }
                        elseif($not->type == '2'){
                          echo ucwords($not->virtual_name).' has bid on <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '3'){
                          echo ucwords($not->virtual_name).' has approve your bid for the <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '4'){
                          echo ucwords($not->virtual_name).' sent request to decrease your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '5'){
                          echo ucwords($not->virtual_name).' sent request to increase your bid in <b>'.ucwords($not->discussion_title).'</b> Discussion';  
                        }
                        elseif($not->type == '6'){
                          echo ucwords($not->virtual_name).' has rebid on <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '7'){
                          echo ucwords($not->virtual_name).' has accept the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '8'){
                          echo ucwords($not->virtual_name).' has decline the presenter request for <b>'.ucwords($not->discussion_title).'</b> Discussion';
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
                        elseif($not->type == '14'){
                          echo 'Congratulation You are earning for <b>'.ucwords($not->discussion_title).'</b> Discussion';
                        }
                        elseif($not->type == '15'){
                        echo 'New Withdralal request from '.ucwords($not->virtual_name);
                      }

                          
                    ?></h3>
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
                <a href="<?php echo base_url(); ?>admin/notification" >See all notifications</a>
                </div>
              </li>
      <?php }else{ ?>
        <li class="dropdown-item"><div class="no_noti_found">Notifications not found.</div></li>
      <?php } ?></ul>
            </div>
<ul class="register-login-btn-area">
<!-- <li class="dropdown notification setting notidiv">
                          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton05"
                          aria-haspopup="true" aria-expanded="false"><i class="icon icon-icon-9"></i><span class="n_count"><?php if($noticount != '0'){  echo $noticount; }else{  echo '0'; }?></span></a>

                    </li> -->
</ul>

            <div class="settings_link">
                <a href="<?php echo base_url() ?>admin/Setting_Master/edit_setting"><i class="icon icon-1"></i></a>
            </div>
            <div class="logged-user-w">
                <div class="logged-user-i">
                    <div class="avatar-w">
                        <?php
                             if($admin->profile_photo != ''){

                                $image_path = base_url('upload/profile/' . $admin->profile_photo);
                                $thumb_path = preg_replace('~\.(?!.*\.)~', '-40x40.', $image_path);

                                ini_set('allow_url_fopen', true);

                                if (getimagesize($thumb_path)) {
                                    $image_path2 = $thumb_path;
                                }
                            ?>
                            <img alt="" src="<?php echo $image_path2; ?>">
                            <?php
                            }
                           else{ ?>
                                <img src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                            <?php } ?>
                    </div>
                        <!-- <div class="adminname_cls"><?php echo ucwords($this->session->userdata['logged_in']['first_name']).' '.ucwords($this->session->userdata['logged_in']['last_name']); ?></div> -->
                    <div class="logged-user-menu color-style-bright">
                        <div class="logged-user-avatar-info">
                            <div class="avatar-w">
                                 <?php
                             if($admin->profile_photo != ''){

                                $image_path = base_url('upload/profile/' . $admin->profile_photo);
                                $thumb_path = preg_replace('~\.(?!.*\.)~', '-40x40.', $image_path);

                                ini_set('allow_url_fopen', true);

                                if (getimagesize($thumb_path)) {
                                    $image_path2 = $thumb_path;
                                }
                            ?>
                            <img alt="" src="<?php echo $image_path2; ?>">
                            <?php
                            }
                           else{ ?>
                                <img src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                            <?php } ?>
                            </div>
                            <div class="logged-user-info-w">
                                <div class="logged-user-name"><?php echo ucwords($this->session->userdata['logged_in']['first_name']).' '.ucwords($this->session->userdata['logged_in']['last_name']); ?></div>
                                <div class="logged-user-role">Administrator</div>
                            </div>
                        </div>
                        <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                        <ul>
                            <li><a href="<?php echo base_url() ?>admin/Setting_Master"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile</span></a></li>
                            <li><a href="<?php echo base_url(); ?>admin/logout/"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

   