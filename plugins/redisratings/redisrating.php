<?php
/*
 * Plugin Name: Redis Ratings
 * Description: This plugin Rating for business type
 * Author: Komang Novayadi
 * Version 11.0.0
 * License: GPLv2
 */
 
define('RATING_URL', plugins_url('', __FILE__));
define('RATING_PATH', dirname(__FILE__) . '/');
function redisratings(){
	
}
add_action( 'wp_enqueue_scripts', 'ratings_script');
function ratings_script() {
    //wp_enqueue_style( 'custom_wp_admin_css', REDIS_WP_MEMBERSHIP_URL . '/skin/backend/css/redismember.css' );
	wp_enqueue_script( 'rating_script', RATING_URL . '/js/ratings.js' );
}

function add_rating_modal(){
	if(is_user_logged_in() ){
		include RATING_PATH."/view/footer.php";
	}
	
	if(isset($_POST["rate_action"])){
		global $wpdb, $current_user;
		$table = $wpdb->prefix."ratings";
		$user_id = $current_user->ID;
		$post_id = $_POST["post_id"];
		$value = $_POST["rate"];
		$checking = $wpdb->get_results("SELECT * FROM {$table} WHERE post_id='{$post_id}' AND user_id='{$user_id}'");
		if(count($checking) <= 0 ){
			$query = ("INSERT INTO {$table} VALUES (NULL,{$post_id},{$value},{$user_id})");
			$wpdb->query( 
			$wpdb->prepare( 
					$query,null
				) 
			);
		}
		
	}
}