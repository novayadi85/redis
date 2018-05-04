<?php if(isset($_SESSION["ad_id"]) && $_SESSION["package_choosed"] == 57){	wp_publish_post($_SESSION["ad_id"]);	unset($_SESSION["ad_id"]);}if(isset($_SESSION["ad_id"]) && $_SESSION["package_choosed"] != 57 && isset($_GET["auth"])){	wp_publish_post($_SESSION["ad_id"]);	unset($_SESSION["ad_id"]);} ?><div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<div style="text-align:center">
					<h4>Success..</h4>
					<p>Thanks for adding your business.<br>
					We'll review your business and get back to you for approval.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$to = get_option('admin_email');
$subject = 'ubject';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );

// For attachment 

$attachments = array( WP_CONTENT_DIR . '/uploads/file_to_attach.zip' );
$headers = 'From: My Name <myname@example.com>' . "\r\n";

wp_mail( 'test@example.org', 'subject', 'message', $headers, $attachments );