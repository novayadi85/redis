<?php
	if(!empty($_POST)){
		require('fcontact-proses.php');
	}
?>
<?php if(!empty($msg)){ ?><p ="ctmsg"><strong><?php echo $msg; ?></strong></p><?php } ?>
<?php //echo date('Y-m-d'); ?>
<?php $_POST = !empty($_POST) ? $_POST : ''; ?>
<div class="f-ctus">
	<form method="post" action="<?php the_permalink(); ?>">
		<table>
			<tr><td>
				<table class="form-table">
						<tr valign="center">
							<th scope="row" width="220"><label for="fname">Full Name*</label></th>
							<td><input type="text" name="fname" value=""/></td>
						</tr>
						<tr valign="center">
							<th scope="row"><label for="email">Email Address*</label></th>
							<td><input type="text" name="email" value=""/></td>
						</tr>
						<tr valign="center">
							<th scope="row"><label for="phone">Phone Number</label></th>
							<td><input type="text" name="phone" value=""/></td>
						</tr>
				</table>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>			
			<table class="form-table wedding">
					<tr valign="center">
						<th scope="row"  width="220"><label for="wdate">Wedding Dates</label></th>
						<td><input type="text" name="wdate" value=""/></td>
					</tr>
					<tr valign="center">
						<th scope="row"><label for="cplan">Ceremony/Events</label></th>
						<td><input type="text" name="cplan" value=""/></td>
					</tr>
					<tr valign="center">
						<th scope="row"><label for="nguess">Number of Guests</label></th>
						<td><input type="text" name="nguess" value=""/></td>
					</tr>
					<tr valign="center">
						<th scope="row"><label for="location">Accommodation/Location</label></th>
						<td><input type="text" name="location" value=""/></td>
					</tr>
					<tr valign="center">
						<th scope="row"><label for="budget">Budget</label></th>
						<td><input type="text" name="budget" value=""/></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="message">Message*</label></th>
						<td><textarea name="message"></textarea></td>
					</tr>
					<tr valign="top">
						<th scope="row">&nbsp;</th>
						<td style="text-align: right;"><span style="float:left">*required</span><button type="submit" name="submit" class="btn-mini">Submit</button></td>
					</tr>
			</table>
				<input type="text" name="dontfill" style="display:none;" value="" />
			</td></tr>
		</table>	
	</form>
</div>


