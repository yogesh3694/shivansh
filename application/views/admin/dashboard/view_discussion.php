<style type="text/css">
    th{ width: 22%; }
</style>
<?php //print_r($viewdisc); ?>
<div class="content-i">
    <div class="content-box">
        <div class="element-wrapper">
            <h6 class="element-header">View Discussion</h6>
            <div class="element-box">
                <!-- <h5 class="form-header">
                </h5> -->
               <!--  <div class="form-desc">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a></div> -->
                <div class="table-responsive">
                <table class="table table-striped table-lightfont">
                    <tr>
                        <th>Username :</th>
                        <td><?php echo ucwords($viewdisc->username); ?></td> 
                    </tr>
                    <tr>
                        <th>Discussion Title :</th>
                        <td><?php echo $viewdisc->discussion_title; ?></td>
                    </tr>
                    <tr>
                        <th>Category :</th>
                        <td><?php echo $viewdisc->category; ?></td>
                    </tr>
                    <tr>
                        <th>Sub Category :</th>
                        <td><?php echo $viewdisc->subcategory; ?></td>
                    </tr>
                    <tr>
                        <th>Final Price :</th>
                        <td><?php echo $viewdisc->final_price; ?></td>
                    </tr>
                    <tr>
                        <th>Base Price :</th>
                        <td><?php echo $viewdisc->base_price; ?></td>
                    </tr>
                    <tr>
                        <th>Age Range :</th>
                        <td><?php echo $viewdisc->agerange; ?></td>
                    </tr>
                    <tr>
                        <th>Start time :</th>
                        <td><?php echo $viewdisc->discussion_start_datetime; ?></td>
                    </tr>
                    <tr>
                        <th>Closing Date :</th>
                        <td><?php echo $viewdisc->closing_date; ?></td>
                    </tr>
                    <tr>
                        <th>Required Presenter :</th>
                        <td><?php echo $viewdisc->require_presenter; ?></td>
                    </tr>
                    <tr>
                        <th>Require Attendee :</th>
                        <td><?php echo $viewdisc->require_attendee; ?></td>
                    </tr>
                    <tr>
                        <th>Requirement Detail :</th>
                        <td><?php echo $viewdisc->requirment_detail; ?></td>
                    </tr>
                    <tr>
                        <th>Attachement :</th>
                        <td>
                        <?php
                            $att = explode('|',$viewdisc->attachement);
                            foreach ($att as $at) { ?>
                               <img src="<?php echo base_url(); ?>upload/discussion/<?php echo $at; ?>" height="50" width="auto">  
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>User As Presenter :</th>
                        <td><?php if($viewdisc->isPresenter == 1){ echo "Yes"; }else { echo "No"; } ?></td>
                    </tr>
                    <tr>
                        <th>Skill Required :</th>
                        <td>
                            <ol>
                            <?php foreach ($skills as $skill) {  
                                    echo "<li>".$skill->name."</li>";
                            } ?>
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <th>Created on :</th>
                        <td><?php echo date('d M Y  h:i A',strtotime($viewdisc->createdDate)); ?></td>
                    </tr>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
 