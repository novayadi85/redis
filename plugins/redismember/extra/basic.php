<?php get_header();

if ( ! empty( $_POST ) ) {
    create_ads($_POST);
}
$is_configured = false;
if(isset($_SESSION["package_choosed"]) && isset($_SESSION["price_choosed"])) {
	$is_configured = true;	
}

if ( ! is_user_logged_in() ){
	$is_configured = false;
}
	
	
if(isset($_GET["started"])){
	$is_configured = false;
}	
	
	
?>
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
			
				<?php /* if ( ! is_user_logged_in() ): ?>
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
				<?php else :   */?>
				<div class="after_login">
				<h1>Package prices:</h1>
				<p class="show_on_free">Start getting noticed online, add your business to Melbourne's fastest growing business directory, it's FREE!</p>
				<div class="row">
					<div class="col-md-12">
						<div class="well text-center" style="position:relative;opacity:0.6;padding:0px 0; height:400px;background-image:url('http://rediscovermelbourne.com.au/wp-content/uploads/2016/10/Re-Discover-Melbourne-.jpg')">
							<a style="display: inline;
    text-align: center;
    padding: 20px 25px;
    position: absolute;
    top: 45%;
    left: 40%;
    opacity: 100;" href="http://localhost.com/rediscover/add_listing.php?started=true" class="btn-add-business">Add Your Business for FREE</a>
						</div>
					<div>
				</div>
				
				
				<form class="form-listing" method="POST" enctype="multipart/form-data">
					<div class="step step1 row packages" data-step="1" <?php if($is_configured): echo "style=\"display:none;\""; endif;?>>
						<!--<div class="col-md-3" style="font-size:11.5px">
							<div class="well">
								<h2 class="muted">FREE</h2>
								<ul style="margin: 10px;">
									<li>Start getting noticed online</li>
									<li>Get started by listing the business essentials</li>
									<li>Add keywords to make your listing appear in searches more often</li>
									<li>Easily make changes to your listing</li>
								</ul>          
								
								<hr>
								<p><a data-package="57" class="btn btn-primary choose_pricing btn-primary" href="#"><i class="icon-ok"></i>FREE</a></p>
							</div>
						</div>-->
						<div class="col-md-4"  style="font-size:11.5px">
							<div class="well">
								<h2 class="muted">Advantage</h2>
								<ul style="margin: 10px;">
									<li>Better way to improve your listing's performance</li>
									<li>Our full-service solution to make you stand-out from the competition</li>
									<li>Add even more content to your listing</li>
									<li>Add photos to your photo gallery</li>
									<li>Get listed on the top section for your business category (above the free listings)</li>
									<li>Have your own page </li>
									<li>We promote your business on our social media channels</li>

								</ul>   
								<h5 class="choose_pricing btn btn-primary" data-package="77" data-value="6 Months" data-price="269">$269.00 / 6 months</h5>
								<h5 class="choose_pricing btn btn-primary" data-package="77" data-value="12 Months" data-price="489">$489.00 / 1 Year</h5>
								<h5 class="choose_pricing btn btn-primary" data-package="77" data-value="24 Months" data-price="895">$895.00 / 2 Years</h3>
								<hr>
								</div>
						</div>
						<div class="col-md-4"  style="font-size:11.5px">
							<div class="well">
								<h2 class="text-warning">FEATURED</h2>
								<ul style="margin: 10px;">
									<li>All the same features from the “Advantage” package PLUS</li>
									<li>Get “Featured” on the home page as well as your selected Business Category</li>
									<li>Multiple suitable Categories may be selected</li>
								</ul>          
								<h5 class="choose_pricing btn btn-primary" data-package="58" data-value="6 Months" data-price="399">$399.00 / 6 months</h5>
								<h5 class="choose_pricing btn btn-primary" data-package="58" data-value="12 Months" data-price="585">$585.00 / 1 Year</h5>
								<h5 class="choose_pricing btn btn-primary" data-package="58" data-value="24 Months" data-price="995">$995.00 / 2 Years</h3>
								<hr>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="well">
								<h2 class="text-info">CUSTOMIZED</h2>
								<ul style="margin: 10px;">
									<li>For a customised solution which includes Flash Banners and Larger Display Ad’s</li>
								</ul>      
								<p>please contact us: 
								info@rediscovermelbourne.com.au</p>
								<p>
								Email : info@rediscovermelbourne.com.au</p><hr>
								
								<hr>
							  <p><a data-package="78" class="btn btn-primary" href="<?php echo get_permalink(162);?>"><i class="icon-ok"></i>CONTACT US</a></p>
							</div>
						</div> 
						<?php //$packages = get_packages();?>
						<?php /* foreach($packages as $package):?>
						<div class="col-md-3">
							<div class="well">
								<h2 class="text-info"><?=$package->name;?></h2>
								
								
								
							  <p><a data-package="60" class="btn btn-large" href="#"><i class="icon-ok"></i> Select plan</a></p>
							</div>
						</div>
						
						<?php endforeach; */ ?>
					</div>
				
					<div class="step step2" data-step="2" <?php if(!$is_configured) { echo "style=\"display:none;\""; } else {  echo "style=\"display:block;\"" ; };?>>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="title">Business title</label>
									<input name="title" type="title" class="form-control required" id="title" placeholder="Your business title">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="title">Business Category</label>
									<?php wp_dropdown_categories( array( 'taxonomy' => "business-category", 'hide_empty' => 0, 'name' => "business-category[]", 'selected' => $term_obj[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'class'=>'form-control required' ) ); ?>
								</div>
							</div>
						
							<div class="col-md-3">
								<div class="form-group">
									<label for="title">Business Location</label>
									<?php wp_dropdown_categories( array( 'taxonomy' => "business-location", 'hide_empty' => 0, 'name' => "business-location[]", 'selected' => $term_obj[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'class'=>'form-control required') ); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="desc">Description</label>
									<textarea cols="70" rows="5" class="form-control editor" name="description"></textarea>
								</div>
							</div>
						</div>
						<div style="visibility:hidden">
							<?php wp_dropdown_categories( array( 'taxonomy' => "packages", 'hide_empty' => 0, 'name' => "packages[]", 'selected' => $_SESSION["package_choosed"], 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'id' => 'business-package' ) ); ?>
							<select name="duration" id="duration">
								<option value="6 Months">6 Months $269.00 AUD</option>
								<option value="12 Months">12 Months $489.00 AUD</option>
								<option value="24 Months">24 Months $895.00 AUD</option>
							</select>
						
						</div>
						<div class="form-group text-right group-button ">
							<button type="button" class="btn btn-default prev">Back to choose package</button>
							<button type="button" class="btn btn-primary next">Next</button>
						</div>
						
					</div>
					
					<div class="step step3" data-step="3" style="display:none;">
						<div class="container-full slide" id="listing-details" style="display: block;">
							<h2>Details</h2>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Contact email:</label>
										<input type="email" name="email" value="" class="form-control required details" placeholder="Your business contact email">
									</div>

									<div class="form-group">
										<label>Phone number:</label>
										<input type="text" name="phone" value="" class="form-control required details" placeholder="Your business contact number">
									</div>

									<div class="form-group">
										<label>Website URL:</label>
										<input type="text" name="web" value="" class="form-control details" placeholder="Your business website's address">
									</div>

									<div class="form-group">
										<label>Address:</label>
										<textarea  name="address" class="form-control details"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Facebook:</label>
										<input type="text" name="fb" value="" class="form-control details" placeholder="">
									</div>

									<div class="form-group">
										<label>Google +:</label>
										<input type="text" name="gplus" value="" class="form-control details" placeholder="">
									</div>

									<div class="form-group">
										<label>Twitter:</label>
										<input type="text" name="twitter" value="" class="form-control details" placeholder="">
									</div>

									

								</div>
								<div class="col-md-12 group-button">
									<div class="form-group text-right">
										<button type="button" class="btn btn-default prev" >Back</button>
										<button type="button" class="btn btn-primary next" >Next</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="step step4 uploads" data-step="4" style="display:none;">
						<div class="row">						
							<div class="col-md-4 cover-image">
								<div class="hide_on_free">
									<label>Upload your business cover</label>
									<input type="hidden" name="cover" id="cover-photo">
									<div class="dropzone dropzone-previews" id="upload-cover"></div>
								</div>
								<div class="show_on_free" style="display:none;">
									<label>Upload your business cover</label>
									<p style="color:red;border: 2px dotted #999;height: 150px;line-height: 200%; padding: 20px;">This Feature is available in Advantage and Featured package, <br>Please upgrade to unlock this feature...</p>
								</div>
							</div>
							
							<div class="col-md-4">
								<label>Upload your business logo</label>
								<input type="hidden" name="logo" id="logo-photo">
								<div class="dropzone dropzone-previews" id="upload-logo"></div>
							</div>
						<div class="col-md-4">
							<div class="hide_on_free">
								<label>Upload your business thumbnail</label>
								<input type="hidden" name="thumbnail" id="thumbnail-photo">
								<div class="dropzone dropzone-previews" id="upload-thumbnail"></div>
							</div>
							<div class="show_on_free" style="display:none;">
								<label>Upload your business thumbnail</label>
								<input type="hidden" name="thumbnail" id="thumbnail-photo">
								<p style="color:red;border: 2px dotted #999;height: 150px;line-height: 200%; padding: 20px;">This Feature is available in Advantage and Featured package, <br>Please upgrade to unlock this feature...</p>
							</div>
						</div>
						</div>
						
						<div class="row" style="margin-top:15px;">
							<div class="col-md-12">
								<div class="form-group text-right group-button">
									<button type="button" class="btn btn-default prev" >Back</button>
									<button type="submit" class="btn btn-primary" >Submit</button>
								</div>
							</div>
						</div>
						
						
						
					</div>
					
				</form>
				<?php //endif;?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>