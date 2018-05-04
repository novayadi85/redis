<?php 
$user = get_user_by( 'id', $_SESSION["membership"]["user_id"] ); 
						
if( $user ) {
	wp_set_current_user( $_SESSION["membership"]["user_id"], $user->user_login );
	wp_set_auth_cookie( $_SESSION["membership"]["user_id"] );
	do_action( 'wp_login', $user->user_login );
	$redirect_to = admin_url('index.php');
    wp_safe_redirect($redirect_to);
}
?>