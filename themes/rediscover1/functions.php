<?php

/**
 * @package WordPress
 * @subpackage Cokadi
 * @since Cokadi 1.0
 */

define('DISALLOW_FILE_EDIT', true);
add_theme_support( 'post-thumbnails' ); 
add_post_type_support( 'page', 'excerpt' );

function excerpt_read_more_link($output) {
	return $output . '<a href="'. get_permalink() . '"> Read More...</a>';
}

function addingJquery() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'addingJquery');

function add_cat_to_page() {  
	// Add category metabox to page
	register_taxonomy_for_object_type('category', 'page');  
}
//add_action( 'admin_init',  'add_cat_to_page' );

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'=> 'Footer Information',
		'id' => 'footer_copy',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	));	
}

function setCaption($e, $id){
	$get_caption = get_post_custom_values($e, $id);
	return $get_caption[0];
} 
function homeUrl($url = null){
	return esc_url( home_url( '/'.$url ) );
}
function themeUrl(){
	return bloginfo( 'template_url' );
}
add_shortcode('home_uri', 'homeUrl');
add_shortcode('hlink', 'homeUrl');

function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_url').'/images/logo_03.gif) !important; width: 55px !important; height: 49px !important; background-size: 55px 49px !important;
		background-color:rgba(255, 255, 255, 0) !important;}
    </style>';
}
add_action('login_head', 'my_custom_login_logo');

function put_my_url(){
    return homeUrl();
}
add_filter('login_headerurl', 'put_my_url');

function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('appearance');
	$wp_admin_bar->remove_menu('updates');  
	$wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('get-shortlink');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

add_action('init', 'my_custom_init');
function my_custom_init() {
	add_post_type_support( 'post', 'page-attributes' );
}

function add_first_and_last($items) {
  $items[1]->classes[] = 'first-menu-item';
  $items[count($items)]->classes[] = 'last-menu-item';
  return $items;
}

add_filter('wp_nav_menu_objects', 'add_first_and_last');


function addonmy_scripts() {
	/* // Add Genericons, used in the main stylesheet. */
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );
	/* Load Bootstraps */
	wp_enqueue_style( 'bootstrapcss', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '2.0' );
	wp_enqueue_style( 'unslider-style', get_template_directory_uri() . '/css/unslider.css', array(), '2.0' );

	/* // Load our main stylesheet. */
	wp_enqueue_style( 'redis-style', get_stylesheet_uri() );
	wp_enqueue_style( 'konexto-font-awesome', get_template_directory_uri() . '/font-aws/css/font-awesome.min.css', array(), '2.0' );
	wp_enqueue_style( 'konexto-overide-gallery', get_template_directory_uri() . '/css/overide-gallery.css', array(), '2.0' );
	wp_enqueue_style( 'cokde-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '2.0' );
	wp_enqueue_style( 'cokde-effects', get_template_directory_uri() . '/css/effects.css', array(), '2.0' );
	wp_enqueue_style( 'unite-gallery', get_template_directory_uri() . '/css/unite-gallery.css', array(), '1.3.0' );
	
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'bootstrap-js-min', get_template_directory_uri() . '/js/bootstrap.min.js', array(), 	'3', false );
	wp_enqueue_script( 'cokde-riple', get_template_directory_uri() . '/js/cokdiripple.js', array(), 	'3', false );
	wp_enqueue_script( 'type-js-bundling', get_template_directory_uri() . '/js/typeahead.bundle.js', array(), 	'3', false );
	wp_enqueue_script( 'tpejs_set', get_template_directory_uri() . '/js/typejs_setting.js', array(), 	'3', true );
	wp_enqueue_script( 'unite_galerry_js', get_template_directory_uri() . '/js/unitegallery.min.js', array(), 	'1.3.0', false );
	wp_enqueue_script( 'unite_theme-compact', get_template_directory_uri() . '/js/ug-theme-compact.js', array(), 	'1.3.0', false );
	wp_enqueue_script( 'unslider-js', get_template_directory_uri() . '/js/unslider.js', array(), 	'1.3.0', true );
}
add_action( 'wp_enqueue_scripts', 'addonmy_scripts' );

function add_socmedia($position = "top")
{
	ob_start();
		$socmeds = stripslashes(get_option( 'site_socmedia', '' ));
		$exSocMed = explode(PHP_EOL,$socmeds);
		foreach($exSocMed as $soclist)
		{
			$exList = explode('|',$soclist);
			$className = strtolower(trim($exList[0]));
			$urlSocmed = strtolower(trim($exList[1]));
			$list[] = "<li><a href='{$urlSocmed}' target='_blank' title='{$exList[0]}' class='{$className}'>{$exList[0]}</a></li>";
		}
		$html[] = "<div class='social-media'>";
			$html[] = "<ul class='social-media-item " . $position . "'>";
			$html[] = join($list);
			$html[] = "</ul>";
		$html[] = "</div>";
		echo join($html);
	return ob_get_clean();
}
function add_socmedia_footer()
{
	ob_start();
		$socmeds = stripslashes(get_option( 'site_socmedia_footer', '' ));
		$exSocMed = explode(PHP_EOL,$socmeds);
		foreach($exSocMed as $soclist)
		{
			$exList = explode('|',$soclist);
			$className = strtolower(trim($exList[0]));
			$urlSocmed = strtolower(trim($exList[1]));
			$list[] = "<li><a href='{$urlSocmed}' target='_blank' title='{$exList[0]}' class='{$className}'>{$exList[0]}</a></li>";
		}
		$html[] = "<div class='social-media'>";
			$html[] = "<ul class='social-media-item bottom'>";
			$html[] = join($list);
			$html[] = "</ul>";
		$html[] = "</div>";
		echo join($html);
	return ob_get_clean();
}
function add_whyus()
{
	ob_start();
		$blocks = stripslashes(get_option( 'site_whyus', '' ));
		$exBlocks = explode(PHP_EOL,$blocks);
		foreach($exBlocks as $block)
		{
			$list[] = "<li>{$block}</li>";
		}
		$html[] = "<ul class='check-list'>";
		$html[] = join($list);
		$html[] = "</ul>";
		echo join($html);
	return ob_get_clean();
}
function add_og_meta()
{
	
	#ob_start();
	global $post;
	if(!empty($post)){
		$thumb_id = get_post_thumbnail_id($post->ID);
		$thumb_url = wp_get_attachment_url( $thumb_id );
		$htm[] = '<meta property="og:url" content="'. get_permalink($post->ID) . '" />
		';
		$htm[] = '<meta property="og:type" content="website" />
		';
		$htm[] = '<meta property="og:title" content="'. $post->post_title . '" />
		';
		$htm[] = '<meta property="og:description" content="" />
		';
		$htm[] = '<meta property="og:image" content="'. $thumb_url . '" />
		';
		
		print join($htm);
	}else{
		print '';
	}
	#return ob_get_clean();
}
add_action('wp_head', 'add_og_meta');

function add_after_body_code()
{
	echo stripslashes(get_option( '__facebook_plugincode', '' ));
}
function the_share_this()
{
	global $post;
	$html[] = '<div class="share-this">';
	$html[] = '<p>';
	//$html[] = '<div class="fb-like" data-href="'. get_permalink($post->ID) . '" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>';
	$html[] = '<a href="https://www.facebook.com/sharer/sharer.php?u='. get_permalink($post->ID) . '" class="btn btn-sm btn-primary btn-share" title="Share on Facebook"><i class="fa fa-facebook"> </i></a> ';
	//$html[] = '<div class="twitter-share-button"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'. get_permalink($post->ID) . '">Tweet</a></div>';
	$html[] = '<a href="https://twitter.com/home?status='. urlencode(get_the_title()) .'%20%7C%20'. get_permalink($post->ID) . '" class="btn btn-sm btn-info btn-share" title="Share on Twitter"><i class="fa fa-twitter"> </i></a> ';
	$html[] = '<a href="https://plus.google.com/share?url='. get_permalink($post->ID) . '" class="btn btn-sm btn-danger btn-share" title="Share on Google+"><i class="fa fa-google-plus"> </i></a> ';
	$html[] = '<a href="https://www.linkedin.com/shareArticle?mini=true&url='. get_permalink($post->ID) . '&title='. urlencode(get_the_title()) .'&summary=&source=" class="btn btn-sm btn-primary btn-share" title="Share on LinkedIn"><i class="fa fa-linkedin"> </i></a> ';
	//$html[] = "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
	$html[] =  '</p>';
	$html[] =  '</div>';
	
	print join($html);
}

function get_post_header_img()
{
	
	$frontpage_ID = get_option('page_on_front');	
	$getFrontMeta = unserialize(get_post_meta( $frontpage_ID, '__theme_custom_box', true ));
		
	global $post;
	if(!empty($post)){
		$getCustMetaBox = unserialize(get_post_meta( $post->ID, '__theme_custom_box', true ));
		$imgHeader = !empty($getCustMetaBox['__page_img_header']) ? $getCustMetaBox['__page_img_header'] : $getFrontMeta['__page_img_header'];
		$imgHeaderSrc = !empty($imgHeader) ? wp_get_attachment_url( $imgHeader ) : '';
	}else{
		$imgHeaderSrc = !empty($getFrontMeta) ? wp_get_attachment_url( $getFrontMeta['__page_img_header'] ) : '';
	}
	
	
	return $imgHeaderSrc;
}

function SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', array('post','news'));
	}
	return $query;
}
if(!empty($_GET['s']) && is_front_page())
add_filter('pre_get_posts','SearchFilter');

function is_set_front()
{
	global $post;
	
	$frontpage_ID = get_option('page_on_front');
	$post_id = (empty($post)) ? 1 : $post->ID;
	return ($post_id == $frontpage_ID) ? TRUE : FALSE;
}

function list_right_column()
{
	$return = array('partners', 'friends' );
	return $return;
}

function add_right_column() {
	ob_start();
	?>
	<div class="right-column">
		<?php foreach(list_right_column() as $list_side): ?>     
			<?php get_sidebar($list_side); ?>
		<?php endforeach; ?>  
	</div>
	<?php
	return ob_get_clean(); 
}
function new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


function konexto_responsive_class($content) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="$2 img-responsive img-shadow"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'konexto_responsive_class');
function note_message(){
	if(!empty($_SESSION['_msg_'])){
		$msg = $_SESSION['_msg_'];
		unset($_SESSION['_msg_']);
		return "<div class='notify {$msg['type']}'><span>{$msg['message']}</span></div>";
	}
}
function set_message($msg = "Sorry, we got problem", $type="error"){
	$_SESSION['_msg_']["message"] = $msg;
	$_SESSION['_msg_']["type"] = $type;
}


require_once('library/add.theme.header.image.php');
require_once('library/add.search.rewrite.php');

include('library/add.theme.option.php');
include('library/add.cat.selection.php');
include('library/navwalker.php');

function latest_insta(){
	require_once('library/class.instagram.php');
	$user = array(array("id" => "3589038654","username" => "rediscovermelbourne"));
	$clientId = "db57791093c14cdc850401190fae0efd";
	$clientSecret ="b1bceaf8951342309b5bd83046c94b9d";
	$accesstoken ="3589038654.db57791.78888e0837a04be1b58a988ba5a27d99";
	$instagram = new instagram($clientId,$clientSecret,$accesstoken);
	$images = $instagram->getImagesByUser($user[0]["id"], array("count"=>4));

	return $images;
}

function getRate($post_id){
	global $wpdb, $current_user;
	$table = $wpdb->prefix."ratings";
	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE post_id='{$post_id}'");
	$checkings = $wpdb->get_results("SELECT SUM(value) as total FROM {$table} WHERE post_id='{$post_id}'");
	
	$checkings = empty($checkings) ? 5 : $checkings[0]->total;
	$rowcount = empty($rowcount) ? 1 : $rowcount;
	
	$total = ceil($checkings / $rowcount);
	
	if($total <= 0){
		return "";
	}
	
	$rate[] = "<ul class='star-rate'>";
	for($i=0;$i<$total;$i++){
		$rate[] = "<li>&nbsp;</li>";
	}
	$rate[] = "</ul>";
	$star = ($total == 1)  ? "a star" : $total ." stars";
	$rate[] = "<div class='rate-text'><small>{$star} by {$rowcount} rating</small></div>";
	
	
	
	return join($rate);
	
}

function get_business_rating( $atts ){
	global $post;
	return getRate($post->ID);
}

add_shortcode( 'rating', 'get_business_rating' );


function set_visitor_post(){
	global $wpdb, $post;
	$table = $wpdb->prefix."visitors";
	$post_id = $post->ID;
	$date = date("Y-m-d");
	$ip_address = $_SERVER["REMOTE_ADDR"];
	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE post_id='{$post_id}'");
	if(!$rowcount){
		//echo $sql = "INSERT INTO `{$table}` (`post_id`,`visitors`,`ip` , `date`) VALUES ( '{$post_id}' , 1 , '{$ip}' , '{$date}')";
		$wpdb->query( 
			"INSERT INTO `{$table}` (`post_id`,`visitors`,`ip` , `date`) VALUES ( '{$post_id}' , 1 , '{$ip_address}' , '{$date}')"
		);
	}
	else{
		$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE post_id='{$post_id}' AND ip = '{$ip_address}' AND date = '{$date}'");
		if(!$rowcount){
			$wpdb->query( 
			"INSERT INTO `{$table}` (`post_id`,`visitors`,`ip` , `date`) VALUES ( '{$post_id}' , 1 , '{$ip_address}' , '{$date}')" 
			);
		}
	}
	
}

function get_visitors(){
	global $wpdb, $post;
	$table = $wpdb->prefix."visitors";
	$post_id = $post->ID;
	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE post_id='{$post_id}'");
	return $rowcount;
}