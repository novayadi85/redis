<?php $pAttrCust = unserialize(get_post_meta( $post->ID, '__business_contact', true )); ?>
<?php $email = empty($pAttrCust['_email']) ? '' : $pAttrCust['_email']; ?>
<div class="block block-right">
	<div class="block-title">
		<?php echo __('Contact ') . get_the_title(); ?>
	</div>
	<div class="block-content">
		<div class="">
		<form action="<?=home_url('contact-busines');?>" class="form" method="POST" id="contact-form-business">
			<div class="message"></div>
			<input type="text" name="name" class="form-control required back-grey" value="" placeholder="Name" required /><br />
			<input type="email" name="email" class="form-control required email back-grey" value="" placeholder="Email" required="email" /><br />
			<input type="text" name="phone" class="form-control required back-grey" value="" placeholder="Phone" required /><br />
			<p><textarea name="message" class="form-control required contact-business back-grey" placeholder="Enquiry" ></textarea></p>
			<p><input type="submit" class="btn btn-warning" value="Submit" /></p>
			<p style="display:none;"><input type="text" name="hashinput" value="" /></p>
			<input type="hidden" name="post_id" value="<?=$post->ID; ?>"/>
			<input type="hidden" name="b_to" value="<?=$email; ?>"/>
			<div class='form-loading'>&nbsp;</div>
		</form>
		</div>
	</div>
</div>

<div class="block block-right">
	<div class="block-title">
		<?php echo __('Company Profile'); ?>
	</div>
	<div class="block-content">
		<?php 
			$getCustMetaBox = unserialize(get_post_meta( get_the_ID(), '__business_logo', true ));
			$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
			$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : homeUrl('/assets/img/logo-default.jpg');
		?>
		<p><img class="logo-mini f-left" src="<?php echo $imgLogoSrc; ?>" /><?php echo get_the_excerpt(); ?></p>
	</div>
</div>
<div class="block block-right">
	<div class="block-title">
		<?php echo __('Keyword'); ?>
	</div>
	<div class="block-content">
		<?php if(!empty($pAttrCust['_keywords']) ): ?>
			<?php $keywords = explode(',', $pAttrCust['_keywords']); ?>
			<?php foreach ($keywords as $_key) {
				echo '<a href="' . homeUrl('searchbusiness?keyname=' . trim($_key)) . '" class="btn btn-keywords">'. ucfirst(trim($_key)) .'</a> ';
			}
			?>
		<?php else: ?>
			<a href="<?php echo homeUrl('searchbusiness?keyname=Business'); ?>" class="btn btn-keywords">Business</a> <a href="<?php echo homeUrl('searchbusiness?keyname=Profile'); ?>" class="btn btn-keywords">Profile</a> 
		<?php endif; ?>
	</div>
</div>

<script>
			( function( $ ) {
				$('#contact-form-business').submit(function(event) {
				$this = this;
				$required = $($this).find('.required');
				
				$getField = $($this).find('input');
				$($this).children(".message").hide();
				$(this).children(".form-loading").show();
				var formData = new FormData($(this)[0]);
				
				$.ajax({
					type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url         : $($this).attr("action"), // the url where we want to POST
					data        : formData, //$($this).serialize(), // our data object
					contentType	: false,
					cache		: false,
					processData	: false,
					dataType    : 'json', // what type of data do we expect back from the server
					encode 		: true
				})
				
					.done(function(data) {
					$($this).children(".form-loading").hide();
					$required.each(function(){
						if($(this).val() == ''){
							$(this).addClass('redBorder');
						}else{
							$(this).removeClass('redBorder');
						}
					});					
					if(data.error){
						$($this).children(".message").show();
						$($this).children(".message").removeClass("success");
						$($this).children(".message").addClass("error");
						$($this).children(".message").html(data.message);				
					}else{
						$($this).children(".message").show();
						$($this).children(".message").addClass("success");
						$($this).children(".message").removeClass("error");
						$($this).children(".message").html(data.message);
						$($this)[0].reset();
					}
					}).fail(function( jqXHR, textStatus ) {
						$($this).children(".form-loading").hide();
						alert( "Request failed: " + textStatus );
					});
					//console.log(data);
				event.preventDefault();
				});
			} )( jQuery );
		</script>