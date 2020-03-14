<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('admin_email'))
{
    function admin_email()
    {
    	$ci=& get_instance();
	    $ci->load->database();
	    $ci->load->model('MainModel'); 
 
		$row = $ci->MainModel->get_singlerecord('trader_settings',array('setting_ID'=>'1'));
	      
        return $row->footer_email;

    }   
}