<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'User_Main';
$route['login'] = "User_Master";
$route['logout'] = "User_Master/logout";
$route['register'] = "User_Main/signup";
$route['forgot-password'] = "User_Main/forgotpass";
$route['change-password'] = "User_Main/change_password"; 
$route['change-security'] = "User_Main/security_question";
$route['withdrawal'] = "User_Main/withdrawal_request";
$route['verifyemail/(:any)'] = "User_Main/verify_email/$1";
$route['my-profile'] = "User_Main/my_profile";
$route['Post-Discussion'] = "Discussion";
$route['category_data/(:any)'] = "Discussion/getsubcategory/$1";
$route['Discussion'] = "Discussion/discussionlist/$1";
$route['discussion-details/(:any)'] = "Discussion/discussion_details/$1";
$route['fileupload'] = "Discussion/discussionfileupload";
$route['discussionfiledelete'] = "Discussion/discussionfiledelete";
$route['my-created-discussion'] = "Discussion/mycreated_disc";
$route['my-attended-discussion'] = "Discussion/myattended_disc";
$route['view-discussion/(:any)'] = "User_Discussion/view_discussion/$1";
$route['view-discussion/(:any)'] = "Discussion/view_discussion/$1";
$route['edit-discussion/(:any)'] = "Discussion/edit_discussion/$1";
$route['notification-setting'] = "User_Main/noti_setting";
$route['billing-method'] = "User_Main/billing_method";
$route['notification'] = "User_Main/notification";
$route['my-payments'] = "User_Main/my_payments";
$route['my-account-dashboard'] = "User_Main/my_account_dashbord";


$route['Discussion/searchdiscussiondata'] = "Discussion/searchdiscussiondata";
$route['How-its-works'] = "Cms_Front/how_its_work";

$route['about-us'] = "Cms_Front/about_us";
$route['Privacy-Policy'] = "Cms_Front/privacy_policy";
$route['Terms-Condition'] = "Cms_Front/term_condition";
$route['faq'] = "Cms_Front/faq";
$route['contact-us'] = "Cms_Front/contact";
 
 //-admin panel
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin'] = "admin/Admin_Master/user_login_process";
$route['admin/logout'] = "admin/Admin_Master/logout";
$route['admin/skillemarketpoint'] = "admin/Admin_Master/skillpoint_emarketpoint";
$route['admin/dashboard'] = "admin/Main/dashboard";
$route['admin/discussions'] = "admin/Discussion_Master";
$route['admin/view-discussion/(:any)'] = "admin/Discussion_Master/view_discussion_admin/$1";
$route['admin/users'] = "admin/User_Master";
$route['admin/add-user'] = "admin/User_Master/add_user";
$route['admin/view-withdrow'] = "admin/User_Master/userwithdrow";
$route['admin/view-user/(:any)'] = "admin/User_Master/view/$1";
$route['admin/edit-user/(:any)'] = "admin/User_Master/edit/$1";
$route['admin/cms'] = "admin/Cms_Master";
$route['admin/category'] = "admin/Category_Master";
//$route['admin/edit-category/(:any)/(:any)'] = "admin/Category_Master/edit_category/$1/$1";
$route['admin/skills'] = "admin/Skill_Master";
$route['admin/edit-skill/(:any)'] = "admin/Skill_Master/edit/$1";
$route['admin/expert-fields'] = "admin/Expertfield_Master";
$route['admin/edit-field/(:any)'] = "admin/Expertfield_Master/edit/$1";
$route['admin/security-question'] = "admin/Security_Master";
$route['admin/edit-question/(:any)'] = "admin/Security_Master/edit/$1";
$route['admin/faqs'] = "admin/Faq_Master";
$route['admin/edit-faq/(:any)'] = "admin/Faq_Master/edit/$1";
$route['admin/subscriber'] = "admin/User_Master/subscriber_list";
$route['admin/notification'] = "admin/User_Master/notification";
$route['admin/pay-now/(:any)'] = "admin/Discussion_Master/discussion_paynow/$1";



