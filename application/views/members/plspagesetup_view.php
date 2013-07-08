<?php if (isset($status) && $status=="updatesuccess"){?>
			<div class="infomessage"><?php echo "Account updated successfully"?> </div>
<?php }else if (isset($status) && $status=="updatefailure"){?>
			<div class="infomessage"><?php echo "Opps ! Error in Account updated !!"?> </div>
<?php } ?>
                        <div id="page_main_content">
<?php $this->load->view('members/components/submenu'); ?>



<!-- promoteArea -->
<div class="promoteArea">
<form method="post" action="http://www.gogvo.com/subscribe.php">
<input type="hidden" name="CampaignCode" value="<?php echo $campaign_code; ?>" />
<input type="hidden" name="FormId" value="<?php echo $form_id; ?>" />
<input type="hidden" name="AffiliateName" value="<?php echo $affiliatename; ?>" />
<table align="center">
<tr>
<td>Email:</td><td><input type="text" name="Email" /></td>
</tr>
<tr>
<td align="center" colspan="2">
<input type="submit" class="btn" value="Submit" /></td>
</tr>
</table>
</form>	
 </div></div>
                        </div>
 