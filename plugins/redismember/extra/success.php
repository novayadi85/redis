<?php 
if(isset($_SESSION["ad_id"]) && $_SESSION["package_choosed"] == 57){	
	//wp_publish_post($_SESSION["ad_id"]);
	//mail_success( "info@rediscovermelbourne.com.au"  , "admin" , array("title" => $_SESSION["package_title"]));
	unset($_SESSION["ad_id"]);
}


if(isset($_SESSION["ad_id"]) && $_SESSION["package_choosed"] != 57 && isset($_POST["auth"])){	
	
} 

if($_SESSION["package_choosed"] != 57 && isset($_POST["payment_status"])){
	get_header();
}


?>
<div id="page-content">
	<div id="columns-page" class="one-column regular-page container">		
		<div class="section-web">
			<div class="main-column">
				<div style="text-align:center">
					<?php if(isset($_GET["cancel"])):?>
					<h4>Sorry..</h4>
					<p>You have cancelled this process!<br>
					Your business listing will not be reviewed / published until you made the payment. <br>
					Please contact us to arrange the payment or alternatively please choose our Free package as a trial. <br><br>
					<a class="btn btn-danger" href="<?php echo site_url("members.php");?>">Back</a>
					</p>
					<?php else :?>
					<h4>Success..</h4>
					<p>Thanks for adding your business.<br>
					We'll review your business and get back to you for approval. <br><br>
					<a class="btn btn-danger" href="<?php echo site_url("members.php");?>">Go to My Account</a>
					</p>
					
					<?php endif;?>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if(isset($_POST["payment_status"]) && $_POST["payment_status"]=="Completed"){

	global $current_user;
	global $wpdb;
	$table = $wpdb->prefix."payement";
	$query = ("INSERT INTO `{$table}` (id,post_id,payment_fee,payer_status,payer_email) VALUES (NULL,'".$_SESSION["ad_id"]."' , '".$_POST["payment_fee"]."' , '".$_POST["payer_status"]."' ,'".$_POST["payer_email"]."') ");
	$wpdb->query($query);
	
	mail_success( $current_user->user_email , "adv" , array("title" => $_POST["item_name"]));

	$post = array( 'ID' => $_SESSION["ad_id"], 'post_status' => "paid" );
	
	wp_update_post($post);
	add_post_meta($_SESSION["ad_id"], '__business_type', 'Premium' , true) or
	update_post_meta($_SESSION["ad_id"], '__business_type', 'Premium');

	unset($_SESSION["ad_id"]);
	unset($_SESSION["package_choosed"]);
	unset($_SESSION["price"]);

}

//mail_success( "info@rediscovermelbourne.com.au"  , "admin" , array("title" => $_SESSION["package_title"])); 

?>
