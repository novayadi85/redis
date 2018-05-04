<?php get_header();?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
		
		
			<div class="main-column">
				
				<?php if ( ! is_user_logged_in() ): ?>
				<h1>Log in:</h1>
				<p>Please Login to create ads!</p>
				<div class="row">
					<div class="col-md-6">
						<?php wp_login_form(
							array(
								'form_id' => 'loginform-custom',
								'label_log_in' => __( 'Log In' ),
								'remember' => true
							)
						); ?>
					</div>
				</div>
				<?php else : 
				if ( ! empty( $_POST ) ) {
					update_ads($_POST);
				}
				if ( ! empty( $_GET["id"] ) ) {
					$postId = $_GET["id"];
					$business = get_post($postId);
					$package = wp_get_post_terms($postId ,'packages', array("fields" => "all")); 
					$location = wp_get_post_terms($postId ,'business-location', array("fields" => "all")); 
					$category = wp_get_post_terms($postId ,'business-category', array("fields" => "all")); 
					$attributes = unserialize(get_post_meta( $postId, '__business_contact', true ));
					$getCustMetaBox = unserialize(get_post_meta( $postId, '__theme_custom_box', true ));
					$imgHeader = !empty($getCustMetaBox['__page_img_header']) ? $getCustMetaBox['__page_img_header'] : null;
					$imgHeaderSrc = !empty($imgHeader) ? wp_get_attachment_url( $imgHeader ) : '';
					$getCustMetaBox = unserialize(get_post_meta( $postId, '__business_logo', true ));
					$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
					$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : '';
					$pAttrCust = unserialize(get_post_meta($postId, '__business_contact', true ));	

				}
					
				?>
					<h2>Details</h2> 
					<?php if($business->post_type == 'business'): ?>
					<form class="form-listing" method="POST">
					<input name="post_id" value="<?=$postId;?>" type="hidden">
					<div class="step" data-step="2"> 
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="title">Business title</label>
									<input name="title" type="title" class="form-control" id="title" value="<?php echo (!empty($business->post_title))? $business->post_title : ""; ?>" placeholder="Your business title">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="title">Business Category</label>
									<?php wp_dropdown_categories( array( 'taxonomy' => "business-category", 'hide_empty' => 0, 'name' => "business-category[]", 'selected' => $category[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'class'=>'form-control' ) ); ?>
								</div>
							</div>
						
							<div class="col-md-3">
								<div class="form-group">
									<label for="title">Business Location</label>
									<?php wp_dropdown_categories( array( 'taxonomy' => "business-location", 'hide_empty' => 0, 'name' => "business-location[]", 'selected' => $location[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'class'=>'form-control') ); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="desc">Description</label>
									<textarea cols="70" rows="5" class="form-control editor" name="description"><?php echo (!empty($business->post_content))? $business->post_content : ""; ?></textarea>
								</div>
							</div>
						</div>
						<div style="visibility:hidden">
							<?php wp_dropdown_categories( array( 'taxonomy' => "packages", 'hide_empty' => 0, 'name' => "packages[]", 'selected' => $package[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'id' => 'business-package' ) ); ?>
						</div>
						
						
					</div>
					
					<div class="step" data-step="3">
						<div class="container-full slide" id="listing-details" style="display: block;">
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Contact email:</label>
										<input type="email" name="email" value="<?php echo (!empty($attributes["_email"]))? $attributes["_email"] : ""; ?>" class="form-control details" placeholder="Your business contact email">
									</div>

									<div class="form-group">
										<label>Phone number:</label>
										<input type="text" name="phone" value="<?php echo (!empty($attributes["_phone"]))? $attributes["_phone"] : ""; ?>" class="form-control details" placeholder="Your business contact number">
									</div>

									<div class="form-group">
										<label>Website URL:</label>
										<input type="text" name="web" value="<?php echo (!empty($attributes["_website_address"]))? $attributes["_website_address"] : ""; ?>" class="form-control details" placeholder="Your business website's address">
									</div>

									<div class="form-group">
										<label>Address:</label>
										<textarea  name="address" class="form-control details"><?php echo (!empty($attributes["_address"]))? $attributes["_address"] : ""; ?></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Facebook:</label>
										<input type="text" name="fb" value="<?php echo (!empty($attributes["_facebook"]))? $attributes["_facebook"] : ""; ?>" class="form-control details" placeholder="">
									</div>

									<div class="form-group">
										<label>Google +:</label>
										<input type="text" name="gplus" value="<?php echo (!empty($attributes["_gplus"]))? $attributes["_gplus"] : ""; ?>" class="form-control details" placeholder="">
									</div>

									<div class="form-group">
										<label>Twitter:</label>
										<input type="text" name="twitter" value="<?php echo (!empty($attributes["_twitter"]))? $attributes["_twitter"] : ""; ?>" class="form-control details" placeholder="">
									</div>

									

								</div>
								
							</div>
						</div>
					</div>
					
					<div class="step uploads" data-step="4">
						<label>Upload your business photo</label>
						
						
						<div class="row">
							<div class="col-md-4">
								<div class="business-cover">
									<img class="img-responsive" src="<?php echo $imgHeaderSrc; ?>" alt="<?php the_title(); ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="preview-business-logo">
									<img src="<?php echo $imgLogoSrc; ?>" alt="<?php the_title(); ?> Logo" /> 
								</div>
							</div>
						</div>
							
						<div class="row">
							<div class="col-md-4">
								<label>Upload your business cover</label>
								<input type="hidden" name="cover" id="cover-photo">
								<div class="dropzone dropzone-previews" id="upload-cover"></div>
							
							</div>
							<div class="col-md-4">
								<label>Upload your business logo</label>
								<input type="hidden" name="logo" id="logo-photo">
								<div class="dropzone dropzone-previews" id="upload-logo"></div>
							</div>
							<div class="col-md-4">
								<label>Upload your business thumbnail</label>
								<input type="hidden" name="thumbnail" id="thumbnail-photo">
								<div class="dropzone dropzone-previews" id="upload-thumbnail"></div>
							</div>
						</div>
						
						
						
						<div class="row">
							<div class="col-md-12" style="margin-top:25px">
								<div class="form-group text-right group-button">
									<button type="button" class="btn btn-default prev" >Back</button>
									<button type="submit" class="btn btn-primary" >Submit</button>
								</div>
							</div>
						</div>
					</div>
					
					</form>
					<?php else:?>	
						<?php echo addMessage("Sorry, you don't have authorized to edit this post.","warning"); ?>
						<p><a href="<?php echo homeUrl('members.php'); ?>" class='btn btn-default'>Back to My Account</a></p>
					<?php endif;?>	
				<?php endif;?>	
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>