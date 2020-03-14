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
                <td align="center" style="border:1px solid #E0E0E0;" bgcolor="#ffffff" valign="top"><a href="<?php echo base_url(); ?>"><img src="<?php echo $mailed_data['logo']; ?>" style="margin-bottom:5px;"  border="0" /></a>
              </td>
              </tr>
            <tr>
                <td style="text-align: center;border-top:1px solid #E0E0E0;border-bottom:1px solid #E0E0E0;     border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; background:#F3F3F3;"><span style="font-size: 26px; color:#333333;">New Withdrawal Request</span></td>
              </tr>
            <tr>
         <td bgcolor="#ffffff" style="font-size:13px;line-height: 10px;border-left: 1px solid #e0e0e0;border-right: 1px solid #e0e0e0;">
          <p><strong>Hello administrator,</strong></p>
          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;"> Has a new withdrawal request in Trader Network and here are the detail of this request:</p>

<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Amount: <?php echo '$'.$mailed_data['amount']; ?></p>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Method: <?php if($mailed_data['method'] == '1'){ echo 'paypal email'; }else{ echo 'bank account'; }  ?></p>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Notes: <?php echo $mailed_data['note']; ?></p>

<p style="margin: 5px 5px;text-align: justify;line-height: 25px;">Details:</p>

<?php if($mailed_data['method'] == '2'){
?>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Acount Name: <?php echo $mailed_data['accountname']; ?></p>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Account Number: <?php echo $mailed_data['accountnumber']; ?></p>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">Bank Name: <?php echo $mailed_data['bankname']; ?></p>
<?php 
}
else{
?>
<p style="margin: 5px 5px;text-align: justify;line-height: 15px;">PayPal Email: <?php echo $mailed_data['paypalemail']; ?></p>
<?php
} ?>


        	<!-- <p style="margin: 5px 5px;text-align: justify;line-height: 25px;"><?php echo ucwords($mailed_data['username']); ?> has requested to withdrawal amount of <strong style="color:#002664"><?php echo '$'.$mailed_data['amount']; ?></strong>.</p> -->

          <p style="margin: 5px 5px;text-align: justify;line-height: 25px;"><a target="_blank" href="<?php echo base_url(); ?>admin/view-withdrow">Click here</a> to approve withdrawal request.</p>
            
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
 