<script>
    setTimeout(function(){
		document.getElementById('formpaypal').submit();
	  // $("#formpaypal").submit();    
	  //$("#formpaypal").hide();
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
				<form style="display:none;" id="formpaypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="C6XQZMF27EJNL">
					<table>
					<tr><td>
					<input type="hidden" name="on0" value="Packages">Packages</td></tr><tr><td>
					<select name="os0">
						<option value="Bronze">Bronze : $25.00 USD - monthly</option>
						<option value="Silver">Silver : $50.00 USD - monthly</option>
						<option value="Gold">Gold : $100.00 USD - monthly</option>
					</select> </td></tr>
					</table>
					<input type="hidden" name="currency_code" value="USD">
					<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				
			</div>
		</div>
	</div>
</div>

