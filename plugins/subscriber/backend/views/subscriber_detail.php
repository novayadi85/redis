<?php 
global $wpdb;
$table = $wpdb->prefix."subscriber";
	if(!empty($_POST)){
		$query = ("UPDATE " . $table . " SET `status` = ".$_POST['changestat'].", `revision_date` = '". date("Y-m-d") ."' WHERE `subscriber_id` = '" . $_POST['code'] . "'");
		if(mysql_query($query)){
			$msg = "Update Success.";
		}
		unset($_POST);
		//echo 
		//UPDATE `af_subscriber` SET `subscriber_id`=[value-1],`name`=[value-2],`email`=[value-3],`company`=[value-4],`country`=[value-5],`state`=[value-6],`zipcode`=[value-7],`phone`=[value-8],`status`=[value-9],`created_date`=[value-10],`revision_date`=[value-11] WHERE 1
	}
$hasils = $wpdb->get_results("SELECT * FROM  $table WHERE subscriber_id =" . (int) $_GET['myId']);	
?>
	<?php if($msg): ?>
		<div id="setting-error-settings_updated" class="updated settings-error"> 
			<p><strong><?php echo $msg; ?></strong></p>
		</div>
	<?php endif; ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label>Contact name</label></th>
			<td><?php print $hasils[0]->name; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="name">Contact e-mail</label></th>
			<td><?php print $hasils[0]->email; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="phone">Contact phone</label></th>
			<td><?php print $hasils[0]->phone; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="company">Company</label></th>
			<td><?php print $hasils[0]->company; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="subject">Country</label></th>
			<td><?php print $hasils[0]->country; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="subject">State/Prov.</label></th>
			<td><?php print $hasils[0]->state; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="subject">Post Code</label></th>
			<td><?php print $hasils[0]->zipcode; ?></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="subject">Status</label></th>
			<td><?php print ($hasils[0]->status !=0) ? "Subscribe" : "Unsubscribe"?></td>
		</tr>
	</table>
	<form action="" method="POST">
		<p><button type="submit" class="button-primary"><?php print ($hasils[0]->status !=1 ) ? "Subscribe" : "Unsubscribe"?></button> <button type="button" class="button-primary" onclick="window.history.back(-1)">Back</button></p>
		<input type="hidden" name="changestat" value="<?php print ($hasils[0]->status !=1 ) ? 1 : 0 ?>" />
		<input type="hidden" name="code" value="<?php print $hasils[0]->subscriber_id; ?>" />
	</form>