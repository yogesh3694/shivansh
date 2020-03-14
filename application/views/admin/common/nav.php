<!DOCTYPE html>
<html>
<!-- Mirrored from light.pinsupreme.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 18 Apr 2018 13:36:38 GMT -->

<head>
    <title><?php echo $page_name; ?></title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="<?php echo base_url(); ?>assets/images/favicon.png" rel="shortcut icon">
    <link href="<?php echo base_url(); ?>assets/images/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="<?php echo base_url(); ?>assets/admin/../fast.fonts.net/cssapi/487b73f1-c2d1-43db-8526-db577e4c822b.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/maince5a.css?version=4.4.1" rel="stylesheet">
    
    <link href="<?php echo base_url(); ?>assets/admin/css/custom_style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/responsive.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/maince5a.js?version=4.4.1"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/js/dist/modal.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/admin/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

</head>

<body class="menu-position-side menu-side-left full-screen with-content-panel">
<?php $admin = $this->AdminModel->get_singlerecord('trader_user',array('user_ID'=> $this->session->userdata['logged_in']['adminid'] )); ?>  
<script type="text/javascript">
$(document).ready(function () {

    $('.menu-w ul.main-menu>li>a').click(function(){
 
        $(this).next().slideToggle('');

    });
 
    var current =window.location.href;
    current=current.split("?");
    current=current[0];
   
    jQuery("li a[href='"+current+"']").parent(".has-sub-menu").addClass("active");
    jQuery("li a[href='"+current+"']").parent(".has-sub-menu").closest('.sub-menu-w').parent().addClass("active");
    jQuery("li a[href='"+current+"']").parent(".has-sub-menu").closest('.sub-menu-w').show();
 
    /*$("li.has-sub-menu").each(function(){
        if($(this).hasClass('active')){
            $(this).find(".sub-menu-w").children('.sub-menu-i').children('ul').slideToggle('fast');
            // $(this).find("i").toggleClass("fa-angle-down");
            // $(this).find("i").toggleClass("fa-angle-up");
        }
    }); */

});
    
</script>  

        <div class="layout-w"> 
            <div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
                <div class="adminlogo_cls">
                  <a href="<?php echo base_url() ?>admin"><img src="<?php echo  base_url();?>assets/images/admin_logo.png" hieght="150px" widht="150px"></a>
                  <i class="icon icon-14 close_slidebar"></i>
                </div>
               <h1 class="menu-page-header">Page Header</h1>
                <ul class="main-menu">
                    <li class="selected has-sub-menu">
                        <a href="<?php echo base_url(); ?>admin/dashboard">
                            <div class="icon-w">
                                <div class="icon icon-3"></div>
                            </div><span>Dashboard</span></a>
                    </li>
                    <li class="has-sub-menu manage_disc_main">
                        <a href="javascript:void(0)">
                            <div class="icon-w">
                                <div class="icon icon-8"></div>
                            </div><span>Manage Discussions</span></a>
                        <div class="sub-menu-w">
                            <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li class="has-sub-menu"><a href="<?php echo base_url(); ?>admin/discussions">All Discussions</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="has-sub-menu edituser_main_nav">
                        <a href="javascript:void(0)">
                            <div class="icon-w">
                                <div class="icon icon-9"></div>
                            </div><span>Manage Users</span></a>
                        <div class="sub-menu-w">
                            <!-- <div class="sub-menu-header">Manage Users</div> -->
                            <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                            <div class="sub-menu-i">
                                <ul class="sub-menu">
                                    <li class="has-sub-menu"><a href="<?php echo base_url(); ?>admin/add-user">Add Users</a></li>
                                    <li class="has-sub-menu edituser_nav"><a href="<?php echo base_url(); ?>admin/users">All Users</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="has-sub-menu">
                        <a href="<?php echo base_url(); ?>admin/cms">
                            <div class="icon-w">
                                <div class="icon icon-10"></div>
                            </div><span>Manage CMS</span></a>
                    </li>
                    <li class="has-sub-menu category_nav">
                        <a href="<?php echo base_url(); ?>admin/category">
                            <div class="icon-w">
                                <div class="icon icon-7"></div>
                            </div><span>Category Management</span></a>
                    </li>
                    <li class="has-sub-menu skill_nav">
                        <a href="<?php echo base_url(); ?>admin/skills">
                            <div class="icon-w">
                                <div class="icon icon-5"></div>
                            </div><span>Skill Management</span></a>
                    </li>
                    <li class="has-sub-menu field_nav">
                        <a href="<?php echo base_url(); ?>admin/expert-fields">
                            <div class="icon-w">
                                <div class="icon icon-expert"></div>
                            </div><span>Expert Field Management</span></a>
                    </li>
                    <li class="has-sub-menu editfaq_nav">
                        <a href="<?php echo base_url(); ?>admin/faqs">
                            <div class="icon-w">
                                <div class="icon icon-11"></div>
                            </div><span>FAQs Management</span></a>
                         
                            <!-- <div class="sub-menu-header">Manage FAQ</div> -->
                             
                    </li>
                    <li class="has-sub-menu">
                        <a href="<?php echo base_url(); ?>admin/view-withdrow">
                             <div class="icon-w">
                                <div class="icon icon-31"></div>
                            </div><span>Manage Withdrawal Requests</span></a>
                    </li>
                    <li class="has-sub-menu ">
                        <a href="<?php echo base_url(); ?>admin/subscriber">
                            <div class="icon-w">
                                <div class="icon icon-12"></div>
                            </div><span>Subscription Management</span></a>
                    </li>
                    <li class="has-sub-menu sec_que_nav">
                        <a href="<?php echo base_url(); ?>admin/security-question">
                            <div class="icon-w">
                                <div class="icon icon-4"></div>
                            </div><span>Security Questions</span></a>
                    </li>
                    
                  
                </ul>
                
            </div>
 