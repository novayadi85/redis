<?php 
global $option , $package;
$opt = base64_decode($option); 



if($opt == "1"){
	$option_price = "6 Months";
}
else if($opt == "2"){
	$option_price = "12 Months";
}
else if($opt == "3"){
	$option_price = "24 Months";
}if ($_SERVER["REMOTE_ADDR"] == "182.253.152.116") {/* global $current_user;echo "<pre>";print_r($_SESSION);	print_r($current_user->display_name);echo "</pre>"; */	}
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		//jQuery("#formpaypal option[value='<?php echo $option_price; ?>']").prop('selected', true);
	});
	
	setTimeout(function(){
		document.getElementById('paypal_form').submit();
    }, 1000);
	
</script>

<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<div style="text-align:center">
					<h4>Waiting please...</h4>
					<p>You will be redirected to a payment page.</p>
				</div>
				<div style="visibility:hidden;">
				<?php /* if($package[0] == "58") : ?>
					
				<?php endif; ?>
				
				<?php if($package[0] == "77") : ?>
					
				<?php endif;  */?>				<form action="https://www.paypal.com/cgi-bin/webscr" method="POST" name="_xclick" id="paypal_form">					<input type="hidden" name="cmd" value="_xclick">					<input type="hidden" name="business" value="info@rediscovermelbourne.com.au">					<input type="hidden" name="item_name" value="<?php echo $_SESSION["package_title"] .  " - "  . $_SESSION["ad_id"];?>">					<input type="hidden" name="item_number" value="<?php echo $SESSION["price_choosed"]; ?>">					<input type="hidden" name="amount" value="<?php echo $_SESSION["price"];?>">					<input type="hidden" name="quantity" value="1">					<input type="hidden" name="currency_code" value="USD">					<input type="hidden" name="address_override" value="1">					<input type="hidden" name="first_name" value="<?php echo $current_user->display_name; ?>">					<input type="hidden" name="last_name" value="<?php echo $current_user->nice_name; ?>">					<input type="hidden" name="return" value="<?php echo site_url("success.php"); ?>" />					<input type="hidden" name="notify_url" value="<?php echo site_url("success.php"); ?>" />					<input type="hidden" name="cancel_return" value="<?php echo site_url("success.php?cancel=true"); ?>" />					<input type="image" name="submit"					src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"					alt="PayPal - The safer, easier way to pay online">				</form>								
				</div>
			</div>
		</div>
	</div>
</div>