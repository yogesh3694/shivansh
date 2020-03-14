<div class="main">
  <div class="bradcume-section">
      <div class="container">
          <div class="row">
              <h2>Notifications</h2>
          </div>
      </div>
  </div>
  <div class="notification_page">
    <div class="container noti_main">
      <?php
      //`echo "<pre>"; print_r($noti);  
if(!empty($noti)){ 
      foreach ($noti as $not) {
       if($not->joinas = '1'){ $joinas='as attendee'; }else{ $joinas='as presenter'; }
       if($not->status == '0'){ $ncls='new_noti'; }else{ $ncls = ''; } ?>
        <div class="notification_main_content <?php echo $ncls; ?>">
            <a href="javascript:void(0)" class="noti_close" data-id="<?php echo $not->notification_ID; ?>"></a>
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
              if($not->type == '13' || $not->type == '2' || $not->type == '6'){
              ?>
                  <a href="<?php echo base_url(); ?>view-discussion/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
              <?php
              }
              elseif($not->type == '16'){ ?>
                <a href="<?php echo base_url();?>my-account-dashboard">
                <?php
              }
              else{
              ?>
                  <a href="<?php echo base_url(); ?>discussion-details/<?php echo $not->post_discu_ID.'?n='.$not->notification_ID; ?>">
              <?php
              }
            ?>
          
            <div class="noti_text">
               <div class="noti_title">
                   <h3>
                      <?php
                          if($not->as_Type == '1'){
                            $astype = 'presenter';
                          }
                          else{
                            $astype = 'attendee'; 
                          }
                        if($not->type == '1'){
                          echo ucwords($not->virtual_name).' has invited you for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion as '.$astype; 
                        }
                        elseif($not->type == '2'){
                          ?>
                          <?php
                          echo ucwords($not->virtual_name).' has bid on <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '3'){
                          echo ucwords($not->virtual_name).' has approve your bid for the <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '4'){
                          echo ucwords($not->virtual_name).' sent request to decrease your bid in <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '5'){
                          echo ucwords($not->virtual_name).' sent request to increase your bid in <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;  
                        }
                        elseif($not->type == '6'){
                          echo ucwords($not->virtual_name).' has rebid on <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '7'){
                          echo ucwords($not->virtual_name).' has accept the presenter request for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '8'){
                          echo ucwords($not->virtual_name).' has decline the presenter request for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion '.$joinas;
                        }
                        elseif($not->type == '9'){
                          echo ucwords($not->virtual_name).' has Cancelled <span class="bold_text">'.ucwords($not->discussion_title). '</span> Discussion';
                        }
                        elseif($not->type == '10'){
                          echo '<span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion is completed';
                        }
                        elseif($not->type == '11'){
                          echo 'Discussion Date is changed for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '12'){
                          echo 'Please Give Your Feedback to Presenter for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '13'){
                          echo 'Please Complete Your '.ucwords($not->discussion_title).' Discussion';
                        }
                        elseif($not->type == '14'){
                          echo 'Congratulation You are earning for <span class="bold_text">'.ucwords($not->discussion_title).'</span> Discussion';
                        }
                        elseif($not->type == '16'){
                          echo 'Admin has approve your withdraw request <span class="bold_text">'.ucwords($not->discussion_title).'</span>';
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
                                 <li><?php echo date('d F Y',strtotime($not->createdDate)); ?></li>
                                 <li><?php echo date('h:i A',strtotime($not->createdDate)); ?></li>
                             </ul>
                         </div>
                        <?php           
                    }
                    else{
                        
                        if($interval->format("%H") == '0')
                        {
                            ?>
                            <div class="noti_hours">
                                <span><?php echo $interval->format("%I").' min ago'; ?></span>
                           </div>
                            <?php
                        }
                        else
                        {
                           ?>
                            <div class="noti_hours">
                              <span><?php echo $interval->format("%h").' hour ago'; ?></span>
                            </div>
                            <?php
                        }  
                    }
                ?>
            </div>
          </a>
        </div>
<?php 
    }
}
else { ?><div class="discu_notfound">Notification Not Found.</div> <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">

  $(document).ready(function(){
      setTimeout(function() {
         jQuery('.loader').show();
        $.ajax({
        type:'POST',
        datatype:'json',
        url:"<?php echo base_url().'User_Main/notificationdefault' ?>",
        data:{ nid:'notification' },
        success:function(html){  
        //alert(1);
         // var res = jQuery.parseJSON(html);
         $( "div.notification_page" ).replaceWith(html);
            jQuery('.loader').hide();
        }
    });
      }, 6000);

      clearTimeout ( );
  });

//$(document).ready(function(){
  //$('.noti_close').click(function(){ alert('as');
    jQuery(document).on("click",".noti_close",function(){
      var notid = $(this).attr('data-id'), close = $(this).parent('.notification_main_content');

       $.ajax({
          type:'POST',
          datatype:'json',
          url:"<?php echo base_url().'User_Main/close_notification' ?>",
          data:{ nid:notid },
          success:function(html){   
            var res = jQuery.parseJSON(html);
            if(res.remove == 'yes'){
              if(res.count2 == '0'){
                $('.n_count').remove();
                $('.noti_main').append('<div class="discu_notfound">Notification Not Found.</div>');
              }
              else{
                $('.n_count').text(res.count);
              }
              close.fadeOut(350, function() {
                 close.remove();
              });
            }
          }
      });
  }); 
//}); 
 
</script>