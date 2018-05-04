<?php
/*
Plugin Name: Redicover Membership
Version: 1.0.0
Plugin URI: http://rediscover.com.au
Author: Komang Novayadi
Author URI: http://novayadi.com
Description: Membership plugin for offering free and premium.
*/

if (!defined('ABSPATH')){
    exit("Do not access this file directly.");
}
define('REDIS_WP_MEMBERSHIP_VER', '1.0.0');
define('REDIS_WP_MEMBERSHIP_PATH', dirname(__FILE__) . '/');
define('REDIS_WP_MEMBERSHIP_URL', plugins_url('', __FILE__));
define('REDIS_WP_MEMBERSHIP_DIRNAME', dirname(plugin_basename(__FILE__)));
include_once('libs/core/install.php');
include_once('libs/core/function.php');
$member_install = new Core_Install();
$member_install->installer();

if(!is_admin()){
	include_once('libs/class/Membership.Class.php');
	$membership = new Membership();
}


