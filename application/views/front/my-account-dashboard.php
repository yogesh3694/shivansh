<script src="<?php echo base_url('assets/front/js/payform.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/front/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    payform.cardNumberInput(document.getElementById('card_no'));
    payform.expiryInput(document.getElementById('valid_thrugh'));
    payform.cvcInput(document.getElementById('cvv_no'));
    $('#billingform2').validate({
        rules: {
            card_no: { required: true,creditcard:true  },
            valid_thrugh: { required: true, },
            cvv_no: { required: true,number:true,maxlength:4 } 
        },
        messages: {
            card_no:{ required:"Please enter card number." },
            valid_thrugh:{ required:"Please enter card expiry date."}, 
            cvv_no:{ required:"Please enter cvv number."}, 
        }, 
    });
});
</script>
<div class="bradcume-section">
    <div class="container">
        <h2>Dashboard</h2>
    </div>
</div>
<section class="profile_info_page">
    <div class="container">
    	<?php if($this->session->flashdata('success')){ ?>
            <div class="alert-success alert alert-dismissible"><?php echo $this->session->flashdata('success'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
            <?php } ?>
            <?php if($this->session->flashdata('fail')){ ?>
            <div class="alert-danger alert alert-dismissible"><?php echo $this->session->flashdata('fail'); ?><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>
            <?php } ?>
        <div class="sec_space pro_info_row">
                    <?php
                    if($this->session->flashdata('billing_msg') != ""){
                              echo '<div><div class="alert-success alert alert-dismissible">'.$this->session->flashdata('billing_msg').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                    if($this->session->flashdata('bidfail') != ""){
                                echo '<div><div class="alert-danger alert alert-dismissible">'.$this->session->flashdata('bidfail').'<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a></div></div>'; } 
                    ?>
            <div class="row">
                <div class="col-sm-9">
                    <h2 class="frnt_page_title">Profile Information</h2>
                    <div class="dash_profile_content">
                        <div class="pro_usr_part">
                            <div class="pro_usr_img">
                                <?php  
                                if($user_Details[0]->total_skill_points <= 1000 ){
                                    echo '<label class="pro_usr_lbl yellow_icon"><i class="icon icon-icon-6"></i></label>';
                                }
                                elseif ($user_Details[0]->total_skill_points <= 10000) {
                                    echo '<label class="pro_usr_lbl green_icon"><i class="icon icon-icon-6"></i></label>';
                                }
                                elseif ($user_Details[0]->total_skill_points <= 100000) {
                                    echo '<label class="pro_usr_lbl blue_icon"><i class="icon icon-icon-6"></i></label>';
                                }
                                else{
                                    echo '<label class="pro_usr_lbl red_icon"><i class="icon icon-icon-6"></i></label>';
                                }
                                ?>
                                <?php if($user_Details[0]->profile_photo!=''){

                                            $image_path = base_url('upload/profile/' . $user_Details[0]->profile_photo);
                                            $thumb_path = preg_replace('~\.(?!.*\.)~', '-158x158.', $image_path);

                                            ini_set('allow_url_fopen', true);

                                            if (getimagesize($thumb_path)) {
                                                $image_path = $thumb_path;
                                            }
                                    ?>
                                <img src="<?php echo  $image_path;?> ">
                                <?php }else{ ?>
                                    <img src="<?php echo  base_url();?>assets/images/none-user-96x96.jpg">
                                
                                <?php } ?>
                            </div>
                            
                            <h4><?php echo $user_Details[0]->virtual_name; ?></h4>
                            <?php if($user_Details[0]->city_name != '' || $user_Details[0]->country_name != ''): ?>
                                <ul>
                                    <li><i class="fa fa-map-marker"></i><?php echo $user_Details[0]->city_name;?>, <?php echo $user_Details[0]->country_name;?></li>
                                </ul>
                            <?php endif; ?>
                            <a href="<?php echo base_url('my-profile'); ?>" class="edit_pro_lnk">EDIT PROFILE</a>
                        </div>
                        <div class="pro_info_part">
                            <h3>General Info</h3>
                            <ul class="general_info">
                                <?php if($user_Details[0]->date_of_birth != ''): ?>
                                        <li><i class="icon icon-icon-25"></i><?php echo date('F d,Y', strtotime($user_Details[0]->date_of_birth));?></li>
                                <?php endif; ?>
                                <li><i class="fa fa-envelope"></i><a href="mailto:<?php echo $user_Details[0]->email;?>"><?php echo $user_Details[0]->email;?></a></li>
                                <?php if($user_Details[0]->skype_id != ''){ ?>
                                <li><i class="fa fa-skype"></i><a href="skype:<?php echo $user_Details[0]->skype_id;?>"><?php echo $user_Details[0]->skype_id;?></a></li>
                                <?php } ?>
                                    
                            </ul>
                            <h3>My Social Network</h3>
                            <ul class="my_social_net">
                                <li>
                                	<i class="fa fa-facebook"></i><a target="_blank" href="<?php echo ($user_Details[0]->fb_link)?$user_Details[0]->fb_link:'javascript:void(0)';?>"><?php echo ($user_Details[0]->fb_link != '' ?$user_Details[0]->fb_link:''); ?></a>
                                </li>
                                <li>
                                	<i class="fa fa-linkedin"></i><a target="_blank" href="<?php echo ($user_Details[0]->linkedin_link != ''?$user_Details[0]->linkedin_link:'javascript:void(0)');?>"><?php echo ($user_Details[0]->linkedin_link != ''?$user_Details[0]->linkedin_link:''); ?></a>
                                </li>
                                <li>
                                	<i class="fa fa-instagram"></i><a target="_blank" href="<?php echo $user_Details[0]->insta_link;?>"><?php echo ($user_Details[0]->insta_link !=''?$user_Details[0]->insta_link:''); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <h2 class="frnt_page_title">Total Points</h2>
                    <div class="color_label">
                        <h5>Market Points</h5>
                        <label class="steel_clr"><?php
                        setlocale(LC_MONETARY, 'en_IN');  
                        $markerpoint = money_format('%!.0n',$user_Details[0]->market_point);
                        echo ($markerpoint != ''?$markerpoint:'0');?></label>
                    </div>
                    <div class="color_label">
                        <h5>Skill Points</h5>
                        <label class="blue_clr"><?php 
                        $skillpoint = money_format('%!.0n',$user_Details[0]->total_skill_points);
                        echo ($skillpoint != ''?$skillpoint:'0');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec_space tot_discusion_row">
            <div class="row">
                <div class="col-sm-9">
                    <h2 class="frnt_page_title">Total Discussions</h2>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="tot_disc_box">
                                <i class="icon icon-icon-3"></i>
                                <h5>As Presenter</h5>
                                <label><?php echo $Aspresenter;?></label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="tot_disc_box">
                                <i class="icon icon-icon-4"></i>
                                <h5>As Attendee</h5>
                                <label><?php echo number_format($Asattendee);?></label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="tot_disc_box">
                                <i class="icon icon-icon-22"></i>
                                <h5>Created</h5>
                                <label><?php echo number_format($Ascreated);?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <h2 class="frnt_page_title">Saved Card</h2>
                    <a href="#" class="add_new_crd" data-toggle="modal" data-target="#addcard">+ Add New</a>
                     <div class="modal fade paynow-popup add_card_popup" id="addcard" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">x</button>
                                            <h4 class="modal-title">Add Card</h4>
                                        </div>                                             
                                        <form id="billingform2" action="<?php echo base_url('billing-method'); ?>" method="post"> 
                                            <input type="hidden" name="cardpopoup" value="yes">
                                            <div class="modal-body">
                                                <div class="panel panel-default">
                                                    <h4 class="credit_title">Add New Card</h4>
                                                    <div class="card-no-div">
                                                        <div class="form-group">
                                                            <label class="form-label">card number</label>
                                                            <input type="text" name="card_no" class="form-controlcls" id="card_no" inputmode="numeric" autocomplete="cc-number" placeholder="XXXX  XXXX  XXXX  XXXX">
                                                            <?php echo form_error('card_no'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="valid-div">
                                                        <div class="form-group">
                                                            <label class="form-label">Valid Through</label>
                                                            <input name="valid_thrugh" id="valid_thrugh" class="form-controlcls" type="text" placeholder="MM/YY">
                                                            <?php echo form_error('valid_thrugh'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="cvc-no-div">
                                                        <div class="form-group">
                                                            <label class="form-label">CVV Number</label>
                                                            <input name="cvv_no" id="cvv_no" class="form-controlcls" type="text"  placeholder="Enter CVV">
                                                            <?php echo form_error('cvv_no'); ?>
                                                        </div>
                                                    </div>                                                        
                                                    <div class="add-new-card-btn">
                                                        <input type="submit" name="billing_submit" class="blue-button" value="add" placeholder="Enter CVC">
                                                    </div>
                                                </div>
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                                </div>
                    <div class="tot_disc_box sav_card_box">
                        <ul>
                        <?php  $i=0;
                            if(!empty($cards)){
                                foreach ($cards as $card) { $i++;
                                ?>
                                    <li>xxxx xxxx xxxx <?php echo $card->card_last_degits; ?> <?php if($card->card_name=='visa'){ ?>
                                        <img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png">
                                        <?php }else if($card->card_name=='Mastercard'){ ?>
                                        <img src="<?php echo base_url(); ?>assets/front/images/credit-card-img2.png">
                                        <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>assets/front/images/credit-card-img1.png">
                                        <?php } ?></li>
                                <?php }
                            }
                            else{
                                echo "Cards Not Found";
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec_space col_table_row">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="frnt_page_title">10 Latest Attended Discussions</h2>
                    <div class="latest_tbl_content">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!empty($latestattendee)){
                                foreach($latestattendee as $keyvalue){ ?>
                                    <tr>
                                        <td><a href="<?php echo base_url();?>discussion-details/<?php echo $keyvalue->discussion_ID;?>"><?php echo $keyvalue->discussion_title;?></a></td>
                                        <td>$ <?php echo $keyvalue->base_price;?></td>
                                    </tr>
                                <?php
                                }
                            }
                            else{
                                echo "<tr><td colspan='2'>Attended Discussions Not Found</td></tr>";
                            } ?>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h2 class="frnt_page_title">10 Latest Created Discussions</h2>
                    <div class="latest_tbl_content">
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 

                            if(!empty($createdlist)){
                                foreach($createdlist as $keyvalue){ ?>
                                    <tr>
                                        <td><a href="<?php echo base_url();?>discussion-details/<?php echo $keyvalue->discussion_ID;?>"><?php echo $keyvalue->discussion_title;?></a></td>
                                        <td>$ 500</td>
                                    </tr>
                                <?php } 
                            }
                            else{
                                echo "<tr><td colspan='2'>Created Discussions Not Found</td></tr>";
                            } ?>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>