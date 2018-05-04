<?php 
if ( is_user_logged_in() )  wp_redirect( site_url("members.php"));
get_header();
function forgot_pass(){
	return "Test";
}

 ?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<?php if ( ! is_user_logged_in() ): ?>
				<div class="wp_login_error">
					<?php if( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) { ?>
						<p>The password you entered is incorrect, Please try again.</p>
					<?php } 
					else if( isset( $_GET['login'] ) && $_GET['login'] == 'empty' ) { ?>
						<p>Please enter both username and password.</p>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-6">
						<p>Don't have an account? Click <a href="<?php echo site_url("welcome-to-member-section");?>">here</a> to register now.</p>
						<?php 
						
						apply_filters( 'login_form_bottom', 'forgot_pass');
						wp_login_form(
							array(
								'form_id' => 'loginform-custom',
								'label_log_in' => __( 'Log In' ),
								'remember' => true
							)
						); ?>
						<p><br>Forgot Password? Click <a href="<?php echo site_url("forgot_pass.php");?>">here</a> to recover your password.</p>
						
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>