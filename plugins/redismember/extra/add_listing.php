<?php get_header();?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
		
		
			<div class="main-column">
				<div class="login_form_ad" style="display:none;">
					<h1>Log in:</h1>
					<p>Please Login to create ads!</p>
					<div class="row">
						<div class="col-md-6">
							<p style="font-size:18px;">Don't have an account? Click <a style="font-weight:bold;" href="<?php echo site_url("welcome-to-member-section");?>">here</a> to register now.</p>
						
							<?php wp_login_form(
								array(
									'form_id' => 'loginform-custom',
									'label_log_in' => __( 'Log In' ),
									'remember' => true
								)
							); ?>
							<p><br>Forgot Password? Click <a href="<?php echo site_url("forgot_pass.php");?>">here</a> to recover your password.</p>
						
						</div>
					</div>
				</div>

				<div class="after_login">
				<h1>Package prices:</h1>
				<div class="row">
					<div class="col-md-12">
						<p class="show_on_free">Start getting noticed online, add your business to Melbourne's fastest growing business directory, it's FREE!</p>
				
						<div class="well text-center" style="position:relative;opacity:0.6;padding:0px 0; height:400px;background-image:url('http://rediscovermelbourne.com.au/wp-content/uploads/2016/10/Re-Discover-Melbourne-.jpg')">
							<a style="display: inline;
								text-align: center;
								padding: 20px 25px;
								position: absolute;
								top: 45%;
								left: 40%;
								opacity: 100;" href="http://localhost.com/rediscover/started.php?started=true" class="btn-add-business">Add Your Business for FREE</a>
						</div>

				<?php //endif;?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
				<p style="line-height:22px;">If your budget allows why not try our range of customised advertising solutions to ensure you can connect with customers in a way that's right for your business. Our full-service solution will make you stand-out from the competition. <br>Click the button below for pricing</p>
				<a class="btn btn-primary">ADVERTISE WITH US</a>
				<br>
		</div>
		</div>
		<div class="row">
					<div class="col-md-12">
						&nbsp;
					</div>
		</div>
		</div>
	</div>
</div>
</div>
</div>
<?php get_footer();?>