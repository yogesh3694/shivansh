<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<pre>";
//print_r($name);exit;
?>

<html>    
    <body style="background:#074578; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
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
                <td style="text-align: center;border-top:1px solid #E0E0E0;border-bottom:1px solid #E0E0E0;border-left:1px solid #E0E0E0;border-right:1px solid #E0E0E0;background:#F3F3F3;"><span style="font-size: 26px; color:#333333;">User Contact</span></td>
              </tr>
            <tr>
         <td bgcolor="#ffffff" style="font-size:15px;line-height: 1.5;border-left:1px solid #E0E0E0;border-right:1px solid #E0E0E0;">
          <p style="font-size:18px;line-height: 1.5; padding-left: 8px;">Contact Us Request</p>
          <table cellpadding="5" cellspacing="5">
            <tr>
              <td style="width: 85px;"><strong>First Name</strong></td><td>:</td>
              <td><?php echo $firstname; ?></td>
            </tr>
            <tr>
              <td style="width: 85px;"><strong>Last Name</strong></td><td>:</td>
              <td><?php echo $lastname; ?></td>
            </tr>
            <tr>
              <td style="width: 85px;"><strong>E-Mail</strong></td><td>:</td>
              <td><?php echo $email; ?></td>
            </tr>
            <tr>
              <td style="width: 85px;"><strong>Subject</strong></td><td>:</td>
              <td><?php echo $subject; ?></td>
            </tr>
            <tr>
              <td style="width: 85px;"><strong>Message</strong></td><td>:</td>
              <td><?php echo $message; ?></td>
            </tr>
          </table>
         </td>
       </tr>
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
 