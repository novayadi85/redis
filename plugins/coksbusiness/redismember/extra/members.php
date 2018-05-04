<?php 
if ( ! is_user_logged_in() ){
	wp_redirect( site_url("member-login.php")); 
	exit();
}
get_header();
?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<?php if(!isset($_GET["act"])):?>
				<div class="row">
					<div class="col-md-4">
						<div class="well">
							<a href="<?php echo site_url("members.php?act=list-ads");?>" class="">LIST ADS</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="well">
							<a href="<?php echo site_url("members.php?act=myaccount");?>" class="">PERSONAL INFO</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="well">
							<a href="<?php print wp_logout_url( home_url() );?>" class="">LOGOUT</a>
						</div>
					</div>
				</div>
				<?php else :?>
					<div class="row">
						<div class="col-md-3" id="sidebar-account">
							<h3>Menu</h3>
							
							<ul>
								<li><a href="<?php echo site_url("members.php?act=list-ads");?>" class="<?php if($_GET["act"]=="list-ads") echo " active";?>">LIST ADS</a></li>
								<li><a href="<?php echo site_url("members.php?act=myaccount");?>" class="<?php if($_GET["act"]=="myaccount") echo " active";?>">PERSONAL INFO</a></li>
								<li><a href="<?php print wp_logout_url( home_url() );?>" class="">LOGOUT</a></li>
							</ul>
						</div>
						<div class="col-md-8">
						<?php if($_GET["act"] == "list-ads"):?>
							<table class="table">
								<thead>
								  <tr>
									<th>Title</th>
									<th>Package</th>
									<th>Location</th>
									<th>Status</th>
									<th></th>
								  </tr>
								</thead>
								<tbody>
								<?php 
								global $current_user;
								$args = array(
									'author'        =>  $current_user->ID,
									'orderby'       =>  'post_date',
									'order'         =>  'ASC',
									'post_type' => "business",
									'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')
								);
								
								$my_ads = get_posts( $args ); 
								
								if(sizeof($my_ads) >= 1){
								foreach($my_ads as $ad) :
								$terms = wp_get_post_terms( $ad->ID ,'packages', array("fields" => "all")); 
								$locations = wp_get_post_terms( $ad->ID ,'business-location', array("fields" => "all")); 
								if(sizeof($terms)){
									list($terms) = $terms;
								}
								$loc = array();
								if(sizeof($locations)){
									foreach($locations as $location){
										$loc[] =  $location->name;
									}
									$_location= implode(",",$loc);
								}
								else {
									$_location= "--";
								}
								?>
								  <tr>
									<td><?=$ad->post_title;?></td>
									<td><?=$terms->name;?></td>
									<td><?=$_location;?></td>
									<td><?=$ad->post_status;?></td>
									<td>
										<a class="btn btn-success" href="<?php echo site_url("edit_business.php?id=".$ad->ID);?>">Edit</a>
										<a class="btn btn-default" href="<?php echo get_permalink($ad->ID);?>">View</a>
									</td>
								  </tr>
								<?php 
								endforeach;
								}
								else {
									print "<tr><td colspan=\"4\">No data found .</td></tr>";
								}
								?>
								</tbody>
							  </table>
						<?php endif;?>
						
						
						<?php if($_GET["act"] == "myaccount"):?>
							<?php
								global $current_user, $wp_roles;
								update_member();
							?>
							<form method="post" id="adduser" action="<?php the_permalink(); ?>">
								<p class="form-username">
									<label for="first-name"><?php _e('First Name', 'profile'); ?></label>
									<input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
								</p><!-- .form-username -->
								<p class="form-username">
									<label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
									<input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
								</p><!-- .form-username -->
								<p class="form-email">
									<label for="email"><?php _e('E-mail *', 'profile'); ?></label>
									<input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
								</p><!-- .form-email -->
								<p class="form-url">
									<label for="url"><?php _e('Website', 'profile'); ?></label>
									<input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
								</p><!-- .form-url -->
								<p class="form-password">
									<label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
									<input class="text-input" name="pass1" type="password" id="pass1" />
								</p><!-- .form-password -->
								<p class="form-password">
									<label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
									<input class="text-input" name="pass2" type="password" id="pass2" />
								</p><!-- .form-password -->
								<p class="form-textarea">
									<label for="description"><?php _e('Biographical Information', 'profile') ?></label>
									<textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
								</p><!-- .form-textarea -->

								<?php 
									//action hook for plugin and extra fields
									do_action('edit_user_profile',$current_user); 
								?>
								<p class="form-submit">
									<?php echo $referer; ?>
									<input name="updateuser" type="submit" id="updateuser" class="submit button btn btn-success" value="<?php _e('Update', 'profile'); ?>" />
									<?php wp_nonce_field( 'update-user' ) ?>
									<input name="action" type="hidden" id="action" value="update-user" />
								</p>
							</form>
						<?php endif; ?>
						
						</div>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?

get_footer();
?>