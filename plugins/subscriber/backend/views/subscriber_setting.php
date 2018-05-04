<?php if (empty($_GET['ctc'])){ ?>
	<h1>Setting Contact Us</h1>
	<?php global $wpdb;?>

				<?php $table = $wpdb->prefix."bvactc_metadata";?>
	<?php 
		if ($_GET['action'] == 'savechange'){ 
			$cerror = NULL;
			$msg = NULL;
			if(empty($_POST['name'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(empty($_POST['email'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(empty($_POST['subject'])){
				$cerror = 1;
				$msg 	= "Please filled out the require field!";
			}
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$cerror = 1;
				$msg 	= "Please input valid email address!";
			}
			if(empty($cerror)){
				$msg = "Update Success!"; 
				$wpdb->update( 	$table, array( 'value' => $_POST['email'],	), 
				array( 'name' => 'recipient_email' ));
				$wpdb->update( 	$table, array( 'value' => $_POST['name'],	), 
				array( 'name' => 'recipient_name' ));
				$wpdb->update( 	$table, array( 'value' => $_POST['subject'],	), 
				array( 'name' => 'email_subject' ));
			}
			//print_r ($_POST); 
		}

			$hasils = $wpdb->get_results("SELECT `value` FROM  $table ORDER BY `bva_metadata_id` ASC");
	?>
	<p><strong style="color:red"><?php if(!empty($msg)){ echo $msg; } ?></strong></p>
	<form method="post" action="admin.php?page=bvactc&action=savechange" >
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="email">Email Recipient</label></th>
				<td><input name="email" type="text" id="email" value="<?php print $hasils[0]->value; ?>" class="regular-text" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="name">Name Recipient</label></th>
				<td><input name="name" type="text" id="name" value="<?php print $hasils[1]->value; ?>" class="regular-text" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="subject">Subject</label></th>
				<td><input name="subject" type="text" id="subject" value="<?php print $hasils[2]->value; ?>" class="regular-text" /></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
	</form>
<?php }else{ 
	require('bvactc_list.php');
	}
?>