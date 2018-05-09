<?php get_header();?>

<style>
input[type="text"], input[type="password"], input[type="email"] {
    padding: 5px;
    text-indent: 5px;
    height: 22px;
    box-shadow: none;
}
.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
    line-height: 22px;
}
</style>
<?php
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
else{
	$choosed = $_SESSION["package_choosed"];
	if(empty($_SESSION["package_choosed"])){
		$choosed = "free";
	}
}

?>
<div class="container">
<div class="row">
	<div class="col-md-5">
		<h2 class="small-header m-t-10">Advantage Package</h2>
		<ul class="list-group" style="margin-left:0px;margin-right:0px;">
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Better way to improve your listing's performance</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Our full-service solution to make you stand-out from the competition</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Add even more content to your listing</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Add photos to your photo gallery</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Get listed on the top section for your business category (above the free listings)</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Have your own page </li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> We promote your business on our social media channels</li>

			<!--
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Start getting noticed online</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Get started by listing the business essentials</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Add keywords to make your listing appear in searches more often</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-check"></span> Easily make changes to your listing</li>
			-->
		</ul>
		<div class="list-images">
			<img width=100% src="http://rediscovermelbourne.com.au/wp-content/uploads/2016/10/Re-Discover-Melbourne-.jpg">
		</div>
		<br>
		<div class="co-coupon active" style="margin-bottom: 20px;">
			<h3 class="co-subsection-title" style="margin-bottom: 5px;"><input type="checkbox">Have a coupon code?</h3>
			<div class="form-block">
				<form id="co-coupon-form">
					<div class="row">
						<div class="col-md-7">
							<input class="form-control" id="coupon-code" name="coupon_code" type="text" placeholder="COUPON CODE">
								
						</div>
						<div class="col-md-5">
							<div class="btn-group">
								<button type="submit" id="coupon-btn" class="btn btn-default button coupon-btn postfix">Apply</button>
								<div id="coupon-remove-btn" class="btn btn-danger button coupon-remove-btn postfix">Remove</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<ul class="list-group" style="margin-left:0px;margin-right:0px;">
			<li class="list-group-item"><strong>Payment Method</strong></li>
			<li class="list-group-item"><input checked type="radio"> Paypal</li>
		</ul>
	
		<ul class="list-group" style="margin-left:0px;margin-right:0px;">
			<li class="list-group-item"><strong>Your total bill</strong></li>
			<li class="list-group-item">$ 269.00;</li>
		</ul>
		
	</div>
	<div class="col-md-7">
		<h2 class="small-header m-t-10">Create you business in 10 minutes or Less</h2>
		<div class="form">
			<form>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="title">Business title</label>
							<input name="title" type="title" class="form-control required" id="title" placeholder="Your business title">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Business Category</label>
							<?php wp_dropdown_categories( array( 'taxonomy' => "business-category", 'hide_empty' => 0, 'name' => "business-category[]", 'selected' => $term_obj[0]->term_id, 'orderby' => 'name', 'hierarchical' => 0, 'show_option_none' => '&mdash;' ,'class'=>'form-control required' ) ); ?>
						</div>
					</div>
				
					<div class="col-md-6">
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
					<div class="col-md-12">
						<div class="form-group">
							<label>Address:</label>
							<textarea cols="60" rows="6" name="address" class="form-control details editor"></textarea>
						</div>
					</div>
					
				</div>
				
				<div class="step step4 uploads" data-step="4">
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
								<button type="submit" class="btn btn-primary" >Place Business</button>
							</div>
							<p class="agreements text-right">By placing your order, you agree to the <a href="#terms-1" data-reveal-id="terms-1">Terms &amp; Conditions</a>.</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<?php get_footer();?>