<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<html>    
    <body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#ffffff;  font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
  <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tbody>
      <tr>
        <td style="padding:20px 0 20px 0" align="center" valign="top">
          <table style="border:1px solid #E0E0E0;"  cellpadding="10" cellspacing="0" width="650">
            <tbody>
              <tr>
                <td align="center" style="border:1px solid #E0E0E0;" bgcolor="#ffffff" valign="top"><a href="<?php echo base_url(); ?>"><img src="<?php echo $logo; ?>" style="margin-bottom:5px;"  border="0" /></a>
              </td>
              </tr>
            <tr>
                <td style="text-align: center;border-top:1px solid #E0E0E0;border-bottom:1px solid #E0E0E0;border-left:1px solid #E0E0E0;border-right:1px solid #E0E0E0;background:#F3F3F3;"><span style="font-size: 26px; color:#333333;">Forgot Password</span></td>
              </tr>
            <tr>
         <td bgcolor="#ffffff" style="font-size:13px;line-height: 10px; color:#000;border-left:1px solid #E0E0E0;border-right:1px solid #E0E0E0;">
          <strong>Dear <?php echo ucfirst($mailed_data->first_name); ?>,</strong>
        	<p style="margin: 5px 5px;text-align: justify;line-height: 25px;">We got a request for forgot password. Use the below new password for login.</p>
          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;"><strong>New Password: </strong><?php echo $pass; ?></p>
          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;">Click <a target="_blank" href="<?php echo base_url('login'); ?>">Here</a> to login.</p>

         </td></tr>
            <tr><td align="center" bgcolor="#002664" style="border:1px solid #E0E0E0; font-size:12px; color:#ffffff; font-family:Verdana, Geneva, sans-serif;">Thank You,<b> Trader Network</b></td></tr>
            <tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
</div> 
</body>
</html>
 