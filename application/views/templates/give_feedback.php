<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo "<pre>";
// print_r($mailed_data);     
// echo "</pre>";
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
                <td align="center" style="border:1px solid #E0E0E0;" bgcolor="#ffffff" valign="top"><a href="<?php echo base_url(); ?>"><img src="<?php echo $mailed_data['logo']; ?>" style="margin-bottom:5px;"  border="0" /></a>
              </td>
              </tr>
            <tr>
                <td style="text-align: center;border-top:1px solid #E0E0E0;border-bottom:1px solid #E0E0E0;     border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; background:#F3F3F3;"><span style="font-size: 26px; color:#333333;">Give Feedback</span></td>
              </tr>
            <tr>
         <td bgcolor="#ffffff" style="font-size:13px;line-height: 10px;border-left: 1px solid #e0e0e0;border-right: 1px solid #e0e0e0;">
          <p><strong>Dear <?php echo ucfirst($mailed_data['username']); ?>,</strong></p>
           
        	<p style="margin: 5px 5px;text-align: justify;line-height: 25px;">Thanks for attending <strong style="color:#002664">"<?php echo $mailed_data['discussion']; ?>"</strong> discussion. </p>

          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;">Your feedback is important to us. the rating will relate to the amount pay to the presenter.</p>

          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;">Please do it wisely. thank for your support.</p>
          
          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;"><a href="<?php echo base_url() ?>discussion-details/<?php echo $mailed_data['discussion_id'] ?>">Click here</a> to give your feedback to presenters.</p>
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
 