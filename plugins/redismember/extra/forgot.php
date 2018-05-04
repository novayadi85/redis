<?php 
if ( is_user_logged_in() )  wp_redirect( site_url("members.php"));
get_header();




?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
<div class="row">
					<div class="col-md-6">

<?php 
if(isset($_POST['user_login']) && !isset($_GET["action"])){
	$user_login = sanitize_text_field( $_POST['user_login'] );
	echo retrieve_password_x($user_login);
}

if(isset($_GET["key"]) && $_GET["action"] == "cp"){
	echo changePassword($_POST['user_login']);
}
?>
<?php 
if(isset($_GET['login']) && isset($_GET["key"]) && $_GET["action"] == "rp"){
	
	?>
	<form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url("forgot_pass.php?action=cp&key=".$_GET["key"]);?>" method="post">
		<p>
			<label>New password</label>
			<input type="text" name="password" id="password" class="input" value="" size="15" tabindex="10">  </p>
			<input type="hidden" name="user_login" value="<?php echo $_GET['login'];?>">
			<p class="submit">
			<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="Set Password" tabindex="100"></p>
	</form>
	<?php 
	
}
else {
	?>
	<form name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url("forgot_pass.php");?>" method="post">
		<p>
			<label>Username or E-mail:</label>
			<input type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10">    </p>
		<input type="hidden" name="redirect_to" value="<?php echo site_url("forgot_pass.php");?>">
		<p class="submit">
	<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="Get New Password" tabindex="100"></p>
	</form>
	<?php 
}
?>

</div>
		</div>
	</div>
</div></div>
</div>


<?php get_footer();?>