<?php //echo "<pre>"; print_r($dashdata); exit; echo "</pre>"; ?>

                <!-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a></li>
                </ul>  -->
                <div class="content-panel-toggler"><i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span></div>
                <div class="content-i dashboard_page">
                    <div class="content-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="element-wrapper">
                                    <!-- <h6 class="element-header">Dashboard</h6> -->
                                    <div class="element-content">
                                        <div class="row">
                                            <div class="dashboard_box">
                                                <a class="element-box el-tablo totaldisc_cls" href="javascript:void(0)">
                                                    <div class="label">Total Discussions</div>
                                                    <div class="value trending-down-basic">
                                                        <?php echo $dashdata[0]->totaldiscussion; ?>
                                                    </div>
                                                    <!-- <div class="trending trending-up-basic"><span>12%</span><i class="os-icon os-icon-arrow-up2"></i></div> -->
                                                </a>
                                            </div>
                                            <div class="dashboard_box">
                                                <a class="element-box el-tablo opendisc_cls" href="javascript:void(0)">
                                                    <div class="label">Open Discussions</div>
                                                    <div class="value trending-up-basic">
                                                        <?php echo $dashdata[0]->opendisccussion; ?>
                                                    </div>
                                                    <!-- <div class="trending trending-down-basic"><span>12%</span><i class="os-icon os-icon-arrow-down"></i></div> -->
                                                </a>
                                            </div>
                                            <div class="dashboard_box">
                                                <a class="element-box el-tablo totaluser_cls" href="javascript:void(0)">
                                                    <div class="label">Total Users in Website</div>
                                                    <div class="value" style="color: #0362c6; ">
                                                        <?php echo $dashdata[0]->totaluser; ?>
                                                    </div>
                                                    <!-- <div class="trending trending-down-basic"><span>9%</span><i class="os-icon os-icon-arrow-down"></i></div> -->
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="element-wrapper">
                                    <div class="element-box table_container">
                                        <h6 class="element-header">Latest 10 Open Discussions</h6>
                                        <div class="table-responsive">
                                            <table class="admin_table open_descussion_table table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>No</th> -->
                                                        <th>Title</th>
                                                        <th>Budget</th>
                                                        <!-- <th>Category</th>
                                                        <th>Date & Time</th>
                                                        <th>Status</th>
                                                        <th class="text-center">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i=0;
                                                foreach ($dashdata as $dashboard) { $i++; ?>
                                                    <tr>
                                                        <!-- <td class="nowrap">
                                                            <?php echo $i; ?>
                                                        </td> -->
                                                        <td class="t_title">
                                                            <?php //echo character_limiter($dashboard->discussion_title,1);
                                                            $title = (strlen($dashboard->discussion_title) > 30) ? substr($dashboard->discussion_title,0,30).'..' : $dashboard->discussion_title;
                                                            echo $title;
                                                             ?>
                                                        </td>
                                                        <td class="t_budget">
                                                            <?php echo ($dashboard->base_price !='' ? '$'.$dashboard->base_price:'-'); ?>
                                                        </td>
                                                        <!-- <td class="nowrap">
                                                            <?php echo $dashboard->category; ?>
                                                        </td>
                                                        <td class="nowrap">
                                                            <?php echo date('d M,Y  h:i A',strtotime($dashboard->createdDate)); ?>
                                                        </td>
                                                        <td class="nowrap">
                                                            <?php if($dashboard->status == 1){
                                                                     echo "<div class='badge badge-success-inverted'>Open</div>";
                                                                    } 
                                                                    elseif ($dashboard->status == 2) {
                                                                      echo "<div class='badge badge-warning-inverted'>Close</div>";   
                                                                    }
                                                                    elseif ($dashboard->status == 3) {
                                                                      echo "<div class='badge badge-primary-inverted'>Complete</div>";   
                                                                    }
                                                                    else{
                                                                        echo "<div class='badge badge-danger-inverted'>Cancelled</div>";
                                                                    } 
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?php echo base_url(); ?>admin/Main/view_discussion/<?php echo $dashboard->discussion_ID; ?>" class="view_icon">View</a>
                                                        </td> -->
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="element-wrapper">
                                    <div class="element-box table_container">
                                        <h6 class="element-header">Top 10 Users</h6>
                                        <div class="table-responsive">
                                            <table class="admin_table top_user_table table table-lightborder">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>No</th> -->
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Skill Points</th>
                                                        <!-- <th>E-market Points</th>
                                                        <th class="text-center">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i=0;
                                                foreach ($users as $user) { $i++; ?>
                                                    <tr>
                                                        <!-- <td class="nowrap">
                                                            <?php echo $i; ?>
                                                        </td> -->
                                                        <td class="t_name">
                                                            <?php echo $user->first_name.' '.$user->last_name; ?>
                                                        </td>
                                                        <td class="t_location">
                                                            <?php echo ($user->location !='' ? $user->location:'-'); ?>
                                                        </td>
                                                        <td class="t_skill">
                                                            <?php echo ($user->total_skill_points !='' ? $user->total_skill_points:'-'); ?>
                                                        </td>
                                                        <!-- <td class="nowrap">
                                                            <?php echo $user->market_point; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?php echo base_url(); ?>admin/Main/view_user/<?php echo $user->user_ID; ?>" class="view_icon">view</a>
                                                        </td> -->
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
        <div class="display-type"></div>
    </div>             