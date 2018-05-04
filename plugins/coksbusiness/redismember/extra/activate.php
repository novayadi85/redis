<?php 
if ( is_user_logged_in() )  wp_redirect( site_url("members.php"));
get_header();
//activate_user

?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				
				<div class="row">
					<div class="col-md-6">
<?php if(isset($_POST["encrypt_data"])){
	activate_user();
}
?>
						<form method="post">
							<div class="form-group">
							  <label for="pwd">Password:</label>
							  <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
							</div>
							<input type="hidden" name="encrypt_data" value="<?php echo $_GET["user"];?>">
							<button type="submit" class="btn btn-default">Submit</button>
						  </form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>


<?php get_footer();?>