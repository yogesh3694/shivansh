<script type="text/javascript">
    $(function(){
    $('.edituser_main_nav').addClass('active');
    $('.edituser_main_nav').addClass('sub_li_active');
    $('.edituser_nav').addClass('active');
});
</script>
<style type="text/css">
    th{ width: 20%; }
</style>
<div class="content-i view_user_page">
    <div class="content-box">
        <div class="element-wrapper">
            <div class="element-box table_continer">
                <h6 class="element-header">View Users</h6>
                <!-- <h5 class="form-header">
                </h5> -->
               <!--  <div class="form-desc">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a></div> -->
                <div class="table-responsive">
                <table class="table admin_table view_usr_table">
                    <tr>
                        <th>Profile :</th>
                        <td>
                            <?php 
                             if($viewuser->profile_photo != ''){

                                $image_path = base_url('upload/profile/' . $viewuser->profile_photo);
                                $thumb_path = preg_replace('~\.(?!.*\.)~', '-60x60.', $image_path);

                                ini_set('allow_url_fopen', true);

                                if (getimagesize($thumb_path)) {
                                    $image_path2 = $thumb_path;
                                }
                                
                                //echo $image_path;
                             ?>

                                <img src="<?php echo $image_path2; ?>">
                            <?php } 
                            else{ ?>
                                <img src="<?php echo base_url() ?>assets/admin/img/blank_usr_img.jpg">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>First Name :</th>
                        <td><?php echo $viewuser->first_name; ?></td>
                    </tr>
                    <tr>
                        <th>Last Name :</th>
                        <td><?php echo $viewuser->last_name; ?></td>
                    </tr>
                    <tr>
                        <th>Virtual Name :</th>
                        <td><?php echo ($viewuser->virtual_name !=''?$viewuser->virtual_name:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Email Address :</th>
                        <td><?php echo ($viewuser->email !='' ? $viewuser->email:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth :</th>
                        <td><?php echo ($viewuser->date_of_birth !='' ? $viewuser->date_of_birth:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Address :</th>
                        <td><?php echo ($viewuser->address_line1 !=''?$viewuser->address_line1:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Country :</th>
                        <td><?php echo ($country->name !=''?$country->name:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>City :</th>
                        <td><?php echo ($city->name !=''?$city->name:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Billing Address :</th>
                        <td><?php echo ($viewuser->billing_address_line1 !='' ?$viewuser->billing_address_line1 : '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Billing Country :</th>
                        <td><?php echo ($billingcountry->name !='' ?$billingcountry->name:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Billing City :</th>
                        <td><?php echo ($billingcity->name !=''?$billingcity->name:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Skype ID :</th>
                        <td><?php echo ($viewuser->skype_id !='' ?$viewuser->skype_id:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Facebook Link :</th>
                        <td><?php echo ($viewuser->fb_link !=''?$viewuser->fb_link:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Linkedin Link :</th>
                        <td><?php echo ($viewuser->linkedin_link !=''?$viewuser->linkedin_link:'-'); ?></td>
                    </tr>
                    <tr>
                        <th>Instagram Link :</th>
                        <td><?php echo ($viewuser->insta_link !='' ?$viewuser->insta_link : '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Created on :</th>
                        <td><?php echo ($viewuser->createdDate !='' ? $viewuser->createdDate : '-'); ?></td>
                    </tr>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>

 
 
