<style type="text/css">
    th{ width: 22%; }
</style>
<?php //print_r($viewuser); ?>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <h6 class="element-header">View User</h6>
            <div class="element-box">
                <!-- <h5 class="form-header">
                </h5> -->
               <!--  <div class="form-desc">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a></div> -->
                <div class="table-responsive">
                <table class="table table-striped table-lightfont">
                    <tr>
                        <th>Name :</th>
                        <td><?php echo ucwords($viewuser->first_name).' '.ucwords($viewuser->last_name); ?></td> 
                    </tr>
                    <tr>
                        <th>Location :</th>
                        <td><?php echo $viewuser->location; ?></td>
                    </tr>
                    <tr>
                        <th>Skill Points :</th>
                        <td><?php echo $viewuser->total_skill_points; ?></td>
                    </tr>
                    <tr>
                        <th>E-market Points :</th>
                        <td><?php echo $viewuser->market_point; ?></td>
                    </tr>
                    <tr>
                        <th>Billing Country :</th>
                        <td><?php echo $viewuser->billingcountry; ?></td>
                    </tr>
                    <tr>
                        <th>Billing city :</th>
                        <td><?php echo $viewuser->billingcity; ?></td>
                    </tr>
                    <tr>
                        <th>Address :</th>
                        <td><?php echo $viewuser->address_line1; ?></td>
                    </tr>
                    <tr>
                        <th>Billing Address :</th>
                        <td><?php echo $viewuser->billing_address_line1; ?></td>
                    </tr>
                    <tr>
                        <th>Expert Field :</th>
                        <td>
                            <ol>
                            <?php foreach ($experts as $expert) {  
                                    echo "<li>".$expert->name."</li>";
                            } ?>
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <th>Facebook Link :</th>
                        <td><?php echo '<a target="_blank" href="'.$viewuser->fb_link.'">'.$viewuser->fb_link.'</a>'; ?></td>
                    </tr>
                    <tr>
                        <th>LinkedIn Link :</th>
                        <td><?php echo '<a target="_blank" href="'.$viewuser->linkedin_link.'">'.$viewuser->linkedin_link.'</a>'; ?></td>
                    </tr>
                    <tr>
                        <th>Instagram Link :</th>
                        <td><?php echo '<a target="_blank" href="'.$viewuser->insta_link.'">'.$viewuser->insta_link.'</a>'; ?></td>
                    </tr>
                    <tr>
                        <th>Created on :</th>
                        <td><?php echo date('d M Y  h:i A',strtotime($viewuser->createdDate)); ?></td>
                    </tr>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
 