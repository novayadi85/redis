<?php 
session_start();
unset($_SESSION["membership"]);
wp_logout();
$homeurl = get_home_url();
wp_redirect($homeurl);
?>