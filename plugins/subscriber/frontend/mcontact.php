<?php
	if(!empty($_POST)){
		require('mcontact-proses.php');
	}
?>
<?php if(!empty($msg)){ ?><p ="ctmsg"><strong><?php echo $msg; ?></strong></p><?php } ?>
<?php //echo date('Y-m-d'); ?>
<div class="m-ctus">
	<p class="ctitle">CONTACT</p>
	<form method="post" action="<?php the_permalink(); ?>">
		<div class="ctleft">
			<p><input type="text" name="fname" placeholder="Full Name" value=""/></p>
			<p><input type="text" name="email" placeholder="Email" value=""/></p>
			<p><input type="text" name="phone" placeholder="Phone" value=""/></p>
		</div>
		<div class="ctleft">
			<p><textarea name="message" placeholder="Message"></textarea></p>
			<input type="text" name="dontfill" style="display:none;" value="" />
			<p style="text-align: right;"><button type="submit" name="submit" class="btn-mini">Submit</button></p>
		</div>
	</form>
</div>


