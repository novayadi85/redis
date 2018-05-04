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
}

?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#formpaypal option[value='<?php echo $option_price; ?>']").prop('selected', true);
	});
	
	setTimeout(function(){
		document.getElementById('formpaypal').submit();
    }, 1000);
	
</script>

<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<div style="text-align:center">
					<h4>Waiting please...</h4>
					<p>You will redirect to payment page.</p>
				</div>
				<div style="visibility:hidden;">
				<?php if($package[0] == "58") : ?>
					<form id="formpaypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="8HEHV3UV4Z9AA">
						<table>
							<tr>
								<td>
									<input type="hidden" name="on0" value="FEATURED OPTIONS">FEATURED OPTIONS
								</td>
							</tr>
							<tr>
								<td>
									<select name="os0" id="select-month">
										<option value="6 Months">6 Months $399.00 AUD</option>
										<option value="12 Months">12 Months $585.00 AUD</option>
										<option value="24 Months">24 Months $995.00 AUD</option>
									</select> 
								</td>
							</tr>
						</table>
						<input type="hidden" name="currency_code" value="AUD">
						<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
					</form>
				<?php endif; ?>
				
				<?php if($package[0] == "77") : ?>
					<form id="formpaypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="5A5N7397R7GAE">
						<table>
							<tr>
								<td>
									<input type="hidden" name="on0" value="ADVANTAGE OPTIONS">ADVANTAGE OPTIONS
								</td>
							</tr>
							<tr>
								<td>
									<select name="os0" id="select-month">
										<option value="6 Months">6 Months $269.00 AUD</option>
										<option value="12 Months">12 Months $489.00 AUD</option>
										<option value="24 Months">24 Months $895.00 AUD</option>
									</select> 
								</td>
							</tr>
						</table>
						<input type="hidden" name="currency_code" value="AUD">
						<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
					</form>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>