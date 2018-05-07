<?php 
add_action('admin_menu', 'redis_plugin_menu');

add_action( 'init', 'member_init_external' );
function member_init_external()
{
	load_wp_headjscss();
    add_rewrite_rule( 'members.php$', 'index.php?members_page=1', 'top' );
	add_rewrite_rule( 'members/logout.php$', 'index.php?members_page=2', 'top' );
	add_rewrite_rule( 'add_listing.php$', 'index.php?members_page=3', 'top' );
	add_rewrite_rule( 'member-login.php$', 'index.php?members_page=4', 'top' );
	add_rewrite_rule( 'edit_business.php$', 'index.php?members_page=5', 'top' );
	add_rewrite_rule( 'payment.php$', 'index.php?members_page=6', 'top' );
	add_rewrite_rule( 'conform.php$', 'index.php?members_page=7', 'top' );
	add_rewrite_rule( 'forgot_pass.php$', 'index.php?members_page=8', 'top' );
	add_rewrite_rule( 'success.php$', 'index.php?members_page=9', 'top' );
	add_rewrite_rule( 'started.php$', 'index.php?members_page=10', 'top' );

	my_custom_post_status();
}

add_filter( 'query_vars', 'member_query_vars' );
function member_query_vars( $query_vars )
{
    $query_vars[] = 'members_page';
    return $query_vars;
}

add_action( 'parse_request', 'member_parse_request' );
function member_parse_request( &$wp )
{
	if ( array_key_exists( 'members_page', $wp->query_vars ) ) {
		switch($wp->query_vars["members_page"]){
			case "1";
			include REDIS_WP_MEMBERSHIP_PATH."extra/members.php";
			break;
			case "2";
			include REDIS_WP_MEMBERSHIP_PATH."extra/logout.php";
			break;
			case "3";
			include REDIS_WP_MEMBERSHIP_PATH."extra/add_listing.php";
			break;
			case "4";
			include REDIS_WP_MEMBERSHIP_PATH."extra/member_login.php";
			break;
			case "5";
			include REDIS_WP_MEMBERSHIP_PATH."extra/edit_business.php";
			break;
			case "6";
			include REDIS_WP_MEMBERSHIP_PATH."extra/paypal.php";
			break;
			case "7";
			include REDIS_WP_MEMBERSHIP_PATH."extra/activate.php";
			break;
			case "8";
			include REDIS_WP_MEMBERSHIP_PATH."extra/forgot.php";
			break;
			case "9";
			include REDIS_WP_MEMBERSHIP_PATH."extra/success.php";
			break;
			case "10";
			include REDIS_WP_MEMBERSHIP_PATH."extra/started.php";
			break;
		}
       
        exit();
    }
    return;
}


function load_custom_wp_admin_style($hook) {
   /*  if($hook != 'toplevel_page_mypluginname') {
        return;
    } */
    wp_enqueue_style( 'custom_wp_admin_css', REDIS_WP_MEMBERSHIP_URL . '/skin/backend/css/redismember.css' );
	wp_enqueue_script( 'my_custom_script', REDIS_WP_MEMBERSHIP_URL . '/skin/backend/js/redismember.js' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

function load_wp_headjscss(){
	//wp_enqueue_style( 'custom_wp_front_css', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/css/redismember.css' );
	//wp_enqueue_script( 'my_custom_script', REDIS_WP_MEMBERSHIP_URL . '/skin/frontend/js/redismember.js' );

}


function redis_plugin_menu() {
	add_menu_page('Membership Settings', 'Member Settings', 'administrator', 'redis-plugin-settings', 'redis_plugin_settings_page', 'dashicons-admin-generic');
	add_submenu_page('redis-plugin-settings', 'Members', 'Members', 'manage_options', 'member-list', 'redis_plugin_members_page');
	add_submenu_page('redis-plugin-settings', 'Add Member', 'Add Member', 'manage_options', 'member-add', 'redis_plugin_members_add_page');
}

function redis_plugin_settings_page() {
  // 
  echo "Test";
}

function redis_plugin_members_page(){
	require REDIS_WP_MEMBERSHIP_PATH."view/backend/member_list.php";
}

function redis_plugin_members_add_page(){
	if(isset($_REQUEST["member_id"])){
		global $wpdb;
		$table = $wpdb->prefix."redis_members_tbl";
		$results = $wpdb->get_results("SELECT * FROM  $table WHERE member_id = ". $_REQUEST["member_id"]);
		if(count($results) >= 1){
			list($member) = $results;
		}
		require_once REDIS_WP_MEMBERSHIP_PATH."view/backend/member_edit.php";
		
	}
	else {
		require_once REDIS_WP_MEMBERSHIP_PATH."view/backend/member_add.php";
	}
	
}


add_action( 'wp_ajax_required_ad', 'prefix_ajax_required_ad' );
add_action( 'wp_ajax_nopriv_required_ad', 'prefix_ajax_required_ad' );


function prefix_ajax_required_ad(){
	session_start();
	$_SESSION["package_choosed"] = $_POST["package_choosed"];
	if($_POST["package_choosed"] == 57){
		$_SESSION["price_choosed"] = "free";
	}
	else {
		$_SESSION["price_choosed"] = $_POST["price_choosed"];
		$_SESSION["price"] = $_POST["price"];
	}
	

	if ( ! is_user_logged_in() ){
		echo json_encode(array("error" => true));
	}
	else {
		echo json_encode(array("error" => false));
	}
	
	exit();
}

add_action( 'wp_ajax_save_member', 'prefix_ajax_save_member' );
add_action( 'wp_ajax_nopriv_save_member', 'prefix_ajax_save_member' );

add_action( 'wp_ajax_login_member', 'prefix_ajax_login_member' );
add_action( 'wp_ajax_nopriv_login_member', 'prefix_ajax_login_member' );

function prefix_ajax_login_member() {
	$data['error'] = TRUE;
	$data["redirect"] = false;
	foreach($_POST['params'] as $variable){
		$params[$variable["name"]] = $variable["value"];
	}
	
	global $wpdb;
	$table = $wpdb->prefix."redis_members_tbl";
	$results = $wpdb->get_results("SELECT * FROM  $table WHERE user_name = ". $params["username"]);
	if(count($results) >= 1){
		session_start();
		$membership = array(
			"member_username" => $params["username"],
			"member_email" => "",
			"is_member_logged_in" => 200
		);
		$_SESSION["membership"] = $membership;
		if($_SESSION["membership"]["is_member_logged_in"]){
			$data["redirect"] = true;
			$data["error"] = false;		
		} 
	}
	else {
		$data['message'] = "Your account not found!";	
	}
	
	$data['error'] = TRUE;
	
	if($data['error']){
		$format = '
		<div class="error">
			<p><strong>ERROR</strong>: %s</p>	
		</div>';
	}
	echo json_encode($data);
	wp_die();
	exit();
}

function prefix_ajax_save_member() {
		$data['error'] = TRUE;
		foreach($_POST['params'] as $variable){
			$params[$variable["name"]] = $variable["value"];
		}
		
		
		if(!empty($params)){
			if(!empty($params['email'])){
				if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)){
					$data['error'] = TRUE;
					$data['message'] = 'Please input valid email';
				}else{
					$email = sanitize_text_field($params['email']);
					global $wpdb;
					$table = $wpdb->prefix."redis_members_tbl";
					$hasils = $wpdb->get_results("SELECT * FROM  $table WHERE `email` ='" .$params['email']."'");
					if(count($hasils) > 0 ){
						$data['error'] = TRUE; 
						$data['message'] = "Sorry, you already registered.";
					}else{
						//$query = ("INSERT INTO `{$table}` (`name`, `email`,`status`, `created_date`) VALUES ('Anynamous','{$email}',1,'". date("Y-m-d") ."')");
						$username = $params['user_login'];
						$first_name = $params['first_name']; 
						$last_name = $params['last_name']; 
						$password = $params['password']; 
						$level = $params['level'];
						$more_membership_levels = $params['more_membership_levels'] = 1;
						
						$email = $params['email'];
						$phone = $params['phone']; 
						$address_street = $params['address_street']; 
						$address_city = $params['address_city'];
						$address_state = $params['address_state']; 
						$address_zipcode = $params['address_zipcode']; 
						$url = $params['url']; 
						
						$query = ("INSERT INTO `{$table}` 
						(`member_id`, 
						`user_name`, 
						`first_name`, 
						`last_name`, 
						`password`, 
						`member_since`, 
						`membership_level`, 
						`more_membership_levels`, 
						`account_state`, 
						`last_accessed`, 
						`last_accessed_from_ip`, 
						`email`, 
						`phone`, 
						`address_street`, 
						`address_city`, 
						`address_state`, 
						`address_zipcode`, 
						`home_page`, 
						`country`, 
						`gender`, 
						`referrer`, 
						`extra_info`, 
						`reg_code`, 
						`subscription_starts`, 
						`initial_membership_level`, 
						`txn_id`, 
						`subscr_id`, 
						`company_name`, 
						`notes`, 
						`flags`, 
						`profile_image`) 
						VALUES 
						(NULL, 
						'{$username}', 
						'{$first_name}', 
						'{$last_name}', 
						'{$password}', 
						'0000-00-00', 
						'{$level}', 
						'{$more_membership_levels}', 
						'pending', 
						'0000-00-00 00:00:00.000000', 
						'', 
						'{$email}',
						'{$phone}', 
						'{$address_street}', 
						'{$address_city}',
						'{$address_state}', 
						'{$address_zipcode}', 
						'{$url}', 
						NULL, 
						'not specified', 
						NULL, 
						NULL, 
						NULL, 
						NULL, 
						NULL, 
						'', 
						'', 
						'', 
						NULL, 
						'0', 
						''
						)");
						
						$fields = array('Anynamous',
							$email,
							1,
							date('Y-m-d')
						);
						if($wpdb->query( 
							$wpdb->prepare( 
									$query
								) 
							)
						){
							$data['error'] = FALSE;
							$data['message'] = "Thank you for your intereset..";
						}else{
							$data['error'] = TRUE; 
							$data['message'] = "Sorry, unable to submit your request. Please try again later. " . mysql_error();
						}
						
					}
				}
				
								
			}else{
				$data['error'] = TRUE;
				$data['message'] = "Please fill out required field!";
			}
			unset($_POST);	
			
			if($data['error']){
				$format = '
				<div class="error">
					<p><strong>ERROR</strong>: %s</p>	
				</div>';
			}
			else {
				$format = '
				<div class="notice notice-success">
					<p>%s</p>	
				</div>';
			}
			$data['message'] = sprintf($format,$data['message']);
			
			echo json_encode($data);
		}else{
			wp_redirect('index.php');
		} 
	
	exit();
	
}

function add_member($params){
	if(!empty($params)){
		if(!empty($params['email'])){
			if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)){
				$data['error'] = TRUE;
				$data['message'] = 'Please input valid email';
			}
			else{
				$email = sanitize_text_field($params['email']);
				global $wpdb;
				$table = $wpdb->prefix."redis_members_tbl";
				$hasils = $wpdb->get_results("SELECT * FROM  $table WHERE `email` ='" .$params['email']."'");
				if(count($hasils) > 0 ){
					$data['error'] = TRUE; 
					$data['message'] = "Sorry you already registered. Please sign in as an existing user or click here for forgot password.";
				}else{
					$username = $params['username'];
					$first_name = $params['first_name']; 
					$last_name = $params['last_name']; 
					$password = $params['password']; 
					$level = $params['level'];
					$more_membership_levels = $params['more_membership_levels'] = 1;
					
					$email = $params['email'];
					$phone = $params['phone']; 
					$address_street = $params['address_street']; 
					$address_city = $params['address_city'];
					$address_state = $params['address_state']; 
					$address_zipcode = $params['address_zipcode']; 
					$url = $params['url']; 
					
					$query = ("INSERT INTO `{$table}` 
					(`member_id`, 
					`user_name`, 
					`first_name`, 
					`last_name`, 
					`password`, 
					`member_since`, 
					`membership_level`, 
					`more_membership_levels`, 
					`account_state`, 
					`last_accessed`, 
					`last_accessed_from_ip`, 
					`email`, 
					`phone`, 
					`address_street`, 
					`address_city`, 
					`address_state`, 
					`address_zipcode`, 
					`home_page`
					) 
					VALUES 
					(NULL, 
					'{$username}', 
					'{$first_name}', 
					'{$last_name}', 
					'{$password}', 
					'0000-00-00', 
					'{$level}', 
					'{$more_membership_levels}', 
					'pending', 
					'0000-00-00 00:00:00.000000', 
					'', 
					'{$email}',
					'{$phone}', 
					'{$address_street}', 
					'{$address_city}',
					'{$address_state}', 
					'{$address_zipcode}', 
					'{$url}' 
					)");
					
					

					if($wpdb->query( 
						$wpdb->prepare( 
								$query,null
							) 
						)
					){
						$data['error'] = FALSE;
						
						$data['message'] = "Thank you for registering with Re Discover Melbourne. Please check your e-mail to complete the registration process";
						
						$userdata = array(
							'user_login'  =>  $username,
							'user_url'    =>  $url,
							'user_pass'   =>  $password ,
							'first_name' => $first_name,
							'last_name' => $last_name,
							"user_email" => $email,
							'role' => "member"
						);

						
						/* $user_id = wp_insert_user( $userdata ) ;
						$data["user_id"] = $user_id;
						$user = get_user_by( 'id', $user_id ); 
						if( $user ) {
							set_logged($username,$email,$user_id);
						} */
						
						mail_success( $email , "register" );
						
					}else{
						$data['error'] = TRUE; 
						$data['message'] = "Sorry, unable to submit your request. Please try again later. " . mysql_error();
					}
				}
			}				
		}
		else{
			$data['error'] = TRUE;
			$data['message'] = "Please fill out required field!";
		}
	}
	
	return $data;
}


function activate_user(){
	
	if(!isset($_POST['encrypt_data'])){
		echo addMessage("Sorry, There are something wrong. <br> Please try again later..","danger");
		return false;
	}
	
	$email = sanitize_text_field(base64_decode($_POST['encrypt_data']));
	
	global $wpdb;
	$table = $wpdb->prefix."redis_members_tbl";
	$hasils = $wpdb->get_results("SELECT user_name,home_page,password,first_name,last_name,email FROM  $table WHERE `email` ='" .$email."'");
	
	if($hasils){
		list($hasils) = $hasils;
		if($_POST["password"] != $hasils->password){
			echo addMessage("Sorry, your password is not matching...","danger");
			return false;
		}

		$userdata = array(
			'user_login'  =>  $hasils->user_name,
			'user_url'    =>  $hasils->home_page,
			'user_pass'   =>  $hasils->password ,
			'first_name' => $hasils->first_name,
			'last_name' => $hasils->last_name,
			"user_email" => $hasils->email,
			'role' => "member"
		);
		
		
				
		$user_id = wp_insert_user( $userdata ) ;
		$data["user_id"] = $user_id;
		$user = get_user_by( 'id', $user_id ); 
		if( $user ) {
			set_logged($username,$email,$user_id);
			echo addMessage("Success, your account has been activated","success");
			
		}
	}
	else{
		echo addMessage("Sorry, There are something wrong. <br> Please try again later..","danger");
	}
}

function is_member_logged_in(){
	if($_SESSION["membership"]["member_username"]){
		return true	;
	}
	return false;
}

function set_logged($username=false,$email=false){
	session_start();
	$membership = array(
		"member_username" => $username,
		"member_email" => $email,
		"is_member_logged_in" => 200
	);
	$_SESSION["membership"] = $membership;
}

function member_status($level = null){
	switch($level){
		case "1" :
		return "Basic";
		break;
		
		case "2" :
		return "Bronze";
		break;
		
		case "3" :
		return "Silver";
		break;
		
		case "4" :
		return "Gold";
		break;
		
		default:
		return "Basic";
		break;
	}
}

function add_membership_box(){
	include REDIS_WP_MEMBERSHIP_PATH."view/frontend/block/header.php";
}

function add_membership_modal(){
	include REDIS_WP_MEMBERSHIP_PATH."view/frontend/block/footer.php";
}


function all_members(){
	global $wpdb;
	$table = $wpdb->prefix."redis_members_tbl";
	$results = $wpdb->get_results("SELECT * FROM  $table");
	return $results;
}

add_shortcode( 'member_sign_up', 'member_sign_up' );

function member_sign_up(){
	ob_start();
	//print_r($_SESSION);
	if(isset($_POST["submit"])){
		$_POST["level"] = 1;
		$result = add_member($_POST);
		if($result["error"]){
			$format =  "<div class=\"alert alert-warning\">
				  <strong>Warning!</strong> %s
				</div>";
			echo sprintf($format,$result["message"]);
			if($_SESSION["membership"]["member_username"]){
				wp_redirect('index.php');
				exit;	
			}
		}
		else {
			$format =  "<div class=\"alert alert-success\">
				  <strong>Success!</strong> %s
				</div>";
			echo sprintf($format,$result["message"]);
		}
		
		
		
	}
	
	$html ='<div class="form-group " style="margin-bottom:0px;">
		<input type="radio" checked name="new_user" class="is_user" id="rad1" value="1"  />
		<label for="rad1" title="Im a new user">I am a new user</label>
	</div>
	
	<div class="form-group">
		<input type="radio" name="new_user" class="is_user" id="rad2" value="0" />
		<label for="rad1" title="Im a new user">I am an existing user</label>
	</div>';

	$html .= '<form style="display:none;" name="loginform-custom" id="loginform-custom" action="'.site_url("wp-login.php").'" method="post">
			
			<p class="login-username">
				<label for="user_login">Username or Email</label>
				<input name="log" id="user_login" class="input" value="" size="20" type="text">
			</p>
			<p class="login-password">
				<label for="user_pass">Password</label>
				<input name="pwd" id="user_pass" class="input" value="" size="20" type="password">
			</p>
			
			<p class="login-remember"><label><span class="jcf-checkbox jcf-unchecked"><span></span><input name="rememberme" id="rememberme" value="forever" style="position: absolute; height: 100%; width: 100%; opacity: 0; margin: 0px;" type="checkbox"></span> Remember Me</label></p>
			<p class="login-submit">
				<input name="wp-submit" id="wp-submit" class="button-primary" value="Log In" type="submit">
				<input name="redirect_to" value="'.site_url("member.php").'" type="hidden">
			</p>
			
			<p><br>Forgot Password? Click <a href="'.site_url("forgot_pass.php").'">here</a> to recover your password.</p>
						
			
		</form>';
	$html .= '<div class="regForm">
	<form class="form-customize" method="POST">
	
	
			
	
  <div class="form-group  holder-icon icon-mail">
    <label for="email">Email address</label>
    <input name="email" type="email" class="form-control  holder-icon icon-mail" id="email" placeholder="Enter email"><span class="icon"></span>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input name="username" type="text" class="form-control" id="username" placeholder="Enter Username">
  </div>
  <div class="form-group  holder-icon icon-user">
    <label for="first_name">First Name</label>
    <input name="first_name" type="text" class="form-control holder-icon icon-user" id="first_name" placeholder="Enter First Name"><span class="icon"></span>
  </div>
  <div class="form-group  holder-icon icon-user">
    <label for="first_name">Last Name</label>
    <input name="last_name" type="text" class="form-control  holder-icon icon-firm" id="last_name " placeholder="Enter Last Name"><span class="icon"></span>
  </div>
  <div class="form-group  holder-icon icon-phone">
    <label for="first_name">Phone</label>
    <input name="phone" type="text" class="form-control  holder-icon icon-phone" id="phone" placeholder="Enter Phone"><span class="icon"></span>
  </div>
  
  <div class="form-group">
	<input type="radio" name="as" id="as_company" value="1"  />
	<label for="rad1">Company</label>
	&nbsp;
	<input type="radio" name="as" id="as_individual" value="2"  />
	<label for="rad1">Individual</label>
  </div>
  
  <div class="form-group holder-icon icon-firm">
    <label for="first_name">Company</label>
    <input name="company" type="text" class="form-control  holder-icon icon-firm " id="company" placeholder="Enter Company"><span class="icon"></span>
  </div>
  <div class="form-group holder-icon icon-web">
    <label for="first_name">Website</label>
    <input name="url" type="text" class="form-control  holder-icon icon-web " id="website" placeholder="Enter Website"><span class="icon"></span>
  </div>
  <div class="form-group">
    <label for="first_name">I am signing up to Re Discover Melbourne as the:</label>
    <select name="role_user" class="form-control ">
		<option value="1">Business owner</option>
		<option value="2">Marketing Manager</option>
		<option value="3">Other</option>
	</select>
	</div>
	
   <div class="form-group">
		<input type="checkbox" checked="checked" id="agreement" />
		<label for="first_name">I have read and agree to Rediscover <a href='.site_url("terms-conditions").'>Terms of service </a> and <a href='.site_url("privacy-policy").'>privacy policy</a>  </label>
   </div>
   
  <div class="form-group">
  <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT">
   </div>
</form></div>';
echo $html;
return ob_get_clean();

}

function Generate_Featured_Image( $file, $post_id, $desc = ""){
    preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
    if ( ! $matches ) {
         return new WP_Error( 'image_sideload_failed', __( 'Invalid image URL' ) );
    }

    $file_array = array();
    $file_array['name'] = basename( $matches[0] );

    $file_array['tmp_name'] = download_url( $file );

    if ( is_wp_error( $file_array['tmp_name'] ) ) {
        return $file_array['tmp_name'];
    }

    $id = media_handle_sideload( $file_array, $post_id, $desc );

    if ( is_wp_error( $id ) ) {
        @unlink( $file_array['tmp_name'] );
        return $id;
    }
    return set_post_thumbnail( $post_id, $id );

}

function create_ads($getParams){
	$title     = $getParams['title'];
	$_SESSION["package_title"] = $title;
	$content   = $getParams['description'];
	$post_type = 'business';

	if(isset($_SESSION["package_choosed"])) {
		$getParams["packages"][0] = $_SESSION["package_choosed"];
		
	}
	
	if(isset($_SESSION["price_choosed"])) {
		$getParams["duration"] = $_SESSION["price_choosed"];
	}	

	$new_post = array(
	'post_title'    => $title,
	'post_content'  => $content,
	'post_status'   => 'pending',          
	'post_type'     => $post_type ,
	'tax_input' => array( 
		'business-category' => 
			$getParams["business-category"]
		,
		'business-location' => 
			$getParams["business-location"]
		,
		'packages' => 
			$getParams["packages"]
		),
	);

	
	$pid = wp_insert_post($new_post);

	
	
	
	$imgId = empty($getParams['logo']) ? '' : sanitize_text_field(trim($getParams['logo']));
	$datas = array('__business_img_logo' => $imgId );
	
	$datax = serialize($datas);
	

	$imgIdNew = empty($getParams['cover']) ? '' : sanitize_text_field(trim($getParams['cover']));
	$dataImg = array('__page_img_header' => $imgIdNew );
	
	$dataNu = serialize($dataImg);				
	if(!empty($getParams['cover'])){
		Generate_Featured_Image( $getParams["cover"],   $pid );
		add_post_meta($pid, '__theme_custom_box', $dataNu , true);
	}
	
	if(!empty($getParams['logo'])){
		add_post_meta($pid, '__business_logo', $datax , true);
	}

	$data['_phone'] = empty($getParams['phone']) ? null : addslashes(trim($getParams['phone']));			
	$data['_email'] = empty($getParams['email']) ? null : addslashes(trim($getParams['email']));			
	$data['_website_address'] = empty($getParams['web']) ? null : addslashes(trim($getParams['web']));			
	$data['_facebook'] = empty($getParams['fb']) ? null : addslashes(trim($getParams['fb']));			
	$data['_gplus'] = empty($getParams['gplus']) ? null : addslashes(trim($getParams['gplus']));			
	$data['_twitter'] = empty($getParams['twitter']) ? null : addslashes(trim($getParams['twitter']));	
	$data['_address'] = empty($getParams['address']) ? null : addslashes(trim($getParams['address']));	
	$setData = serialize($data);
	update_post_meta($pid, '__business_contact', $setData);
	
	
	$_SESSION["ad_id"] = $pid;

	
	$_packages = array(
		"57" => "Free",
		"77" => "Advantage",
		"58" => "“eatured"
	
	);
	
	
	
	
	$addons = array(
		"title" => $_SESSION["package_title"] ,
		"package" => $_packages[$_SESSION["package_choosed"]] . "( " . $getParams["duration"] ." )"
	);
	
	
	mail_success( "info@rediscovermelbourne.com.au"  , "admin" , $addons); 
	mail_success( "novayadi85@gmail.com"  , "admin" , $addons); 
	mail_success( "a.fazlic@fazgraphicdesigns.com.au"  , "admin" , $addons); 
	
	
	
	
	if($getParams["packages"][0] > 1 && $getParams["packages"][0] != "57"){
		global $option;
		global $package;
		global $getParams;

		$package = $getParams["packages"];
		
		if($getParams["duration"] == "6 Months"){
			$option = (base64_encode(1));
			
		}
		else if($getParams["duration"] == "12 Months"){
			$option = (base64_encode(2));
		}
		else if($getParams["duration"] == "24 Months"){
			$option = (base64_encode(3));
		}
		
		
		include REDIS_WP_MEMBERSHIP_PATH."extra/paypal.php";
		exit();
	}
	
	
	if($getParams["packages"][0] == "57"){
		mail_success($data['_email'] , "free" , array("business_name" => $title));
		include REDIS_WP_MEMBERSHIP_PATH."extra/success.php";
		exit();
	}
	
	
	/* add_post_meta($pid, 'meta_key', $custom_field_1, true);
	add_post_meta($pid, 'meta_key', $custom_field_2, true); */

}

function update_ads($getParams){
	
	
	$title     = $getParams['title'];
	$content   = $getParams['description'];
	$post_type = 'business';

	$new_post = array(
	'ID'			=> $getParams["post_id"],
	'post_title'    => $title,
	'post_content'  => $content,
	'post_status'   => 'pending',          
	'post_type'     => $post_type ,
	'tax_input' => array( 
		'business-category' => 
			$getParams["business-category"]
		,
		'business-location' => 
			$getParams["business-location"]
		,
		'packages' => 
			$getParams["packages"]
		),
	);
	
	$post_id = wp_update_post( $new_post );
	
	
	
	
	$imgId = empty($getParams['logo']) ? '' : sanitize_text_field(trim($getParams['logo']));
	$datas = array('__business_img_logo' => $imgId );
	
	$datax = serialize($datas);
	

	$imgIdNew = empty($getParams['cover']) ? '' : sanitize_text_field(trim($getParams['cover']));
	$dataImg = array('__page_img_header' => $imgIdNew );
	
	$dataNu = serialize($dataImg);				
	if(!empty($getParams['cover'])){
		Generate_Featured_Image( $getParams["cover"],   $post_id );
		add_post_meta($post_id, '__theme_custom_box', $dataNu , true);
	}
	
	if(!empty($getParams['logo'])){
		add_post_meta($post_id, '__business_logo', $datax , true);
	}
	
	$data['_phone'] = empty($getParams['phone']) ? null : addslashes(trim($getParams['phone']));			
	$data['_email'] = empty($getParams['email']) ? null : addslashes(trim($getParams['email']));			
	$data['_website_address'] = empty($getParams['web']) ? null : addslashes(trim($getParams['web']));			
	$data['_facebook'] = empty($getParams['fb']) ? null : addslashes(trim($getParams['fb']));			
	$data['_gplus'] = empty($getParams['gplus']) ? null : addslashes(trim($getParams['gplus']));			
	$data['_twitter'] = empty($getParams['twitter']) ? null : addslashes(trim($getParams['twitter']));	
	$data['_address'] = empty($getParams['address']) ? null : addslashes(trim($getParams['address']));	
	$setData = serialize($data);
	update_post_meta($getParams["post_id"], '__business_contact', $setData);
	if (is_wp_error($post_id)) {
		$errors = $post_id->get_error_messages();
		foreach ($errors as $error) {
			echo addMessage($error,"warning");
		}
	}
	else{
		echo addMessage("Data updated!","success");
	}
}


add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_action( 'wp_ajax_save_business', 'prefix_ajax_save_business' );
add_action( 'wp_ajax_nopriv_save_business', 'prefix_ajax_save_business' );

function prefix_ajax_save_business(){
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	
	//print_r( $_FILES);
	
	$uploadedfile = $_FILES['file'];

	$upload_overrides = array( 'test_form' => false );

	//$movefile = wp_handle_upload( $_FILES["file"], $upload_overrides );
	$daFile = $_FILES['file'];
    foreach ($_FILES['file'] as $key => $value) {

        $daFile[$key] = $value[0]; 

    }

    $upload = wp_handle_upload($daFile , array('test_form' => FALSE));
	
	if ( $upload && ! isset( $upload['error'] ) ) {
		echo json_encode( $upload );
	} else {
		echo json_encode($upload['error']);
	}
	
	
	wp_die();
	exit();
}


add_action( 'wp_ajax_upload_file', 'prefix_ajax_upload_ajax' );
add_action( 'wp_ajax_nopriv_upload_file', 'prefix_ajax_upload_ajax' );

function prefix_ajax_upload_ajax(){
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	$uploadedfile = $_FILES['file'];
	$multiple = $_POST["multiple"];
	
	if($multiple){
		$daFile = $_FILES['file'];
		foreach ($_FILES['file'] as $key => $value) {

			$daFile[$key] = $value[0]; 

		}
	}
	else{
		$daFile = $_FILES;
	}

    $upload = wp_handle_upload($daFile , array('test_form' => FALSE));
	
	
	
	if ( $upload && ! isset( $upload['error'] ) ) {
		echo json_encode( $upload );
	} else {
		echo json_encode($upload['error']);
	}
	
	
	wp_die();
	exit();
}


function insert_attachment($file_handler) {

  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, 0 );
}


add_action( 'wp_ajax_set_step', 'prefix_ajax_set_step' );
add_action( 'wp_ajax_nopriv_set_step', 'prefix_ajax_set_step' );




function set_step(){
	session_start();
	$_SESSION["step"] = $_REQUEST["step"];
	wp_die();
	exit();
}

add_action( 'wp_login_failed', 'front_end_login_fail' );
function front_end_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER'];    
	if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
		wp_redirect( site_url("member-login.php?login=failed")); 
		exit;
	}
}

add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {

$referrer = $_SERVER['HTTP_REFERER'];

if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) { 
    if( $username == "" || $password == "" ){
        wp_redirect( site_url("member-login.php?login=empty")); 
        exit;
    }
}

}

add_action('pre_get_posts', 'filter_posts_list');
function filter_posts_list($query)
{
    global $pagenow;
 
    global $current_user;
    get_currentuserinfo();
     
    if(!current_user_can('administrator') && current_user_can('edit_posts') && ('edit.php' == $pagenow))
    {
        $query->set('author', $current_user->ID); 
    }
}

function addMessage($msg,$type="info"){
	
	$return = false;
	
	if($type=="success"){
		$return = "<div class=\"alert alert-success\">
		  <strong>Success!</strong> ".$msg."
		</div>";
	}
	if($type=="info"){
		$return = "<div class=\"alert alert-info\">
		  <strong>Info!</strong> ".$msg."
		</div>";
	}
	
	if($type=="warning"){
		$return = "<div class=\"alert alert-warning\">
		  <strong>Warning!</strong> ".$msg."
		</div>";
	}
	
	if($type=="danger"){
		$return = "<div class=\"alert alert-danger\">
		  <strong>Warning!</strong> ".$msg."
		</div>";
	}
	
	return $return;
	
}

function update_member(){
	global $current_user, $wp_roles;
	$error = array();    
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
		if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
			if ( $_POST['pass1'] == $_POST['pass2'] )
				wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
			else
				$error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
		}

		if ( !empty( $_POST['url'] ) )
			wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
		if ( !empty( $_POST['email'] ) ){
			if (!is_email(esc_attr( $_POST['email'] )))
				$error[] = __('The Email you entered is not valid.  please try again.', 'profile');
			elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
				$error[] = __('This email is already used by another user.  try a different one.', 'profile');
			else{
				wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
			}
		}

		if ( !empty( $_POST['first-name'] ) )
			update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
		if ( !empty( $_POST['last-name'] ) )
			update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
		if ( !empty( $_POST['description'] ) )
			update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

		if ( count($error) == 0 ) {
			do_action('edit_user_profile_update', $current_user->ID);
			echo addMessage("Your Profile updated","success");
		}
		else {
			foreach($error as $err){
				echo addMessage($err,"warning");
			}
		}
	}
}


function wpdocs_set_html_mail_content_type() {
    return 'text/html';
}





function wpb_sender_email( $original_email_address ) {
    return 'noreply@rediscovermelbourne.com.au';
}


function wpb_sender_name( $original_email_from ) {
	return 'Re Discover Melbourne';
}


add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

function mail_success($to , $type = "admin" , $addOn = false){
	add_filter( 'wp_mail_from', 'wpb_sender_email' );
	add_filter( 'wp_mail_from_name', 'wpb_sender_name' );
	
	$current_user = wp_get_current_user(); 
	$subject = "Registering in Re Discover Melbourne";
	if($addOn && is_array($addOn)){
		$title = $addOn["title"];
		$package = $addOn["package"];
	}
	else {
		$title = "";
	}

	
	if($type =="admin"){
		$body = "Hi Admin,

		<p>You have a new business added under ".$current_user->display_name." account to the Re Discover Melbourne website.</p>

		<p>Please review the following information:<br>
		<ol>
			<li>- Business Name: ".$title."</li>
			<li>- Package type: ".$package."</li>

		<p>As for Advantage and Featured, please check the Paypal account before giving approval.</p>;
	
		<p>Sincerely yours,<br>

		The Re Discover Melbourne Team<br>
		www.rediscovermelbourne.com.au</p>";
	}
	else if($type=="register"){
		$links = "<a href='" .site_url("conform.php?user=".base64_encode($to))."'>".site_url("conform.php?user=".base64_encode($to))."</a>";
		$name  = $current_user->display_name;
		$body = "Hi {$name} <br>

		<p>Thanks for registering with Re Discover Melbourne.
		Please verify your account by clicking the following link:</p>

		<p>Verify your account link<br>{$links}</p>

		<p>To add your business, simply enter your password and click ADD YOUR BUSINESS BUTTON on the website.</p>

		<p>Sincerely yours,<br>

		The Re Discover Melbourne Team<br>
		www.rediscovermelbourne.com.au</p>";
	}
	
	else if($type=="free"){
		$name  = $current_user->display_name;
		$body = "Hi {$name} <br>

		<p>We will review the data you have submitted for {$title}. Once approved, you'll be able to manage your business listing from My Account feature on the Re Discover Melbourne website.</p>
		<p>Improve your listing performance by upgrading your services to Advantage / Featured service.</p>
		<p>If you have any questions, please don't hesitate to contact us</p>
		
		<p>Sincerely yours,<br>

		The Re Discover Melbourne Team<br>
		www.rediscovermelbourne.com.au</p>";
	}
	
	else if($type=="adv"){
		$name  = $current_user->display_name;
		$body = "Hi {$name} <br>

		<p>We will review the data you have submitted for {$title} and we will check your payment status. Once approved, you'll be able to manage your business listing from My Account feature on the Re Discover Melbourne website.</p>
		<p>If you have any questions, please don't hesitate to contact us</p>
		
		<p>Sincerely yours,<br>

		The Re Discover Melbourne Team<br>
		www.rediscovermelbourne.com.au</p>";
	}
	
	
	add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

	wp_mail( $to, $subject, $body );
	 
	remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
	 
}

function changePassword($user_login){
	global $wpdb, $current_site;
	if(isset($_POST["password"])){
		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		$login = trim($user_login);
		$password = trim($_POST["password"]);
        $user_data = get_user_by('login', $login);

		if(!wp_set_password(wp_slash($password),  $user_data->ID)){
			$user_id = wp_update_user( array( 'ID' => $user_data->ID, 'password' => $password) );
			if($user_id){
				return addMessage(__('Your password changed.') ,"success");
			}
			else {
				 return addMessage(__('Your password not change yet.') . "<br />\n" . __('Possible reason: your mail not registered'),"danger");
		
			}
		}	
	}
}




function retrieve_password_x($user_login) {
    global $wpdb, $current_site;

    if ( empty( $user_login) ) {
        return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your mail not registered'),"danger");;
    } else if ( strpos( $user_login, '@' ) ) {
        $user_data = get_user_by( 'email', trim( $user_login ) );
        if ( empty( $user_data ) )
           return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your mail not registered'),"danger");
    } else {
        $login = trim($user_login);
        $user_data = get_user_by('login', $login);
    }

    do_action('lostpassword_post');


    if ( !$user_data ) {
		return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your mail not registered'),"danger");
	}

    // redefining user_login ensures we return the right case in the email
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

    do_action('retreive_password', $user_login);  // Misspelled and deprecated
    do_action('retrieve_password', $user_login);

    $allow = apply_filters('allow_password_reset', true, $user_data->ID);

    if ( ! $allow )
        return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: you are not allowed to change password'),"danger");
    else if ( is_wp_error($allow) )
        return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: you are not allowed to change password'),"danger");

    $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
    if ( empty($key) ) {
        $key = wp_generate_password(20, false);
        do_action('retrieve_password_key', $user_login, $key);
        $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
    }
	$message .= __("Password reset request for Re Discover Melbourne") .  "\r\n\r\n";
    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= network_site_url("forgot_pass.php?action=rp&key=$key&login=".rawurlencode($user_login), 'login'). "\r\n\r\n";
	$message .= "Sincerely yours". "\r\n\r\n";
	$message .= "The Re Discover Melbourne Team" . "\r\n\r\n";
	$message .= "www.rediscovermelbourne.com.au" . "\r\n\r\n";

    if ( is_multisite() )
        $blogname = $GLOBALS['current_site']->site_name;
    else
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Password Reset'), $blogname );

    $title = apply_filters('retrieve_password_title', $title);
    $message = apply_filters('retrieve_password_message', $message, $key);
echo $message;
    if ( $message && !wp_mail($user_email, $title, $message) ){
		return addMessage(__('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...'),"danger");
	}
	else{
		return addMessage(__('Thank you! We\'ve sent an email to your email address. Click the link in the email to reset your password.'),"success");
	}
    //    wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );

}


function my_custom_post_status(){
	register_post_status( 'paid', array(
		'label'       => _x( 'paid', 'post status' ),
		'public'      => true,
		'_builtin'    => true, /* internal use only. */
		'label_count' => _n_noop( 'paid <span class="count">(%s)</span>', 'Paid <span class="count">(%s)</span>' ),
	) );

}
