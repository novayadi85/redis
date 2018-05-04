<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage Cokadi
 * @since Cokadi 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' |'; } ?> <?php bloginfo('name'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicon.png">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php add_after_body_code(); ?>
<div id="page" class="">
	<div id="wrapper" class="">
		<div id="header">
			<div class="header-top">
				<div class="container">
					<div class="socmedtop">
						<div class="socmed-right">
							<div class="account-nav">
								<?php // echo add_membership_box(); ?>
								<ul class="account-nav-list">
	<?php  
	if (is_user_logged_in() ){
		$loginText = "My account"; 
	}
	else {
		$loginText = "Sign in"; 
	}
	?>
	<li><a href="<?php echo site_url("members.php");?>" class="account"><?=$loginText?></a></li>
	<?php 
	if (is_user_logged_in() ){
		echo "<li class=\"last\"><a href=\"".wp_logout_url( home_url() )."\" class=\"logout\">Logout</a></li>";
	} else { 
	?><li><a href="<?php echo get_permalink(51); //site_url("add_listing.php");?>" class="account">Register</a></li> <?php 
	}
	?>
</ul>
							</div>
							<?php echo add_socmedia(); ?>
						</div>
						<div class="contact-header">
							<div class="phonemail"><?php /* <span>For More info,</span>  */ ?><span>Email us at <a href="mailto:<?php echo get_option('company_email'); ?>"><?php echo get_option('company_email'); ?></a></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-menu-container">
				<div class="container">
					
				</div>
			</div>
			<?php
				$defaults = array(
					'menu'              => 'Menu',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse',
					'container_id'      => 'bs-example-navbar-collapse-1',
					'menu_class'        => 'nav navbar-nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker())
				;
			?>

			<nav id="mainNav" class="navbar navbar-blue">
				<div class="container">
					<div class="navbar-header">
						
						<a class="navbar-brand" href="<?php echo homeUrl(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php echo get_option('blogname'); ?>" class="img-responsive img-logo" /></a>						
					</div>
					<form method="GET" action="<?php echo homeUrl('searchbusiness'); ?>">
						<div class="header-feature">
							<?php $homeclass = is_set_front() ? " home" : ''; ?>
							<?php $keyname = empty( $_GET['keyname'] ) ? '' : sanitize_text_field( $_GET['keyname'] ); ?>
							<?php //$locations = empty( $_GET['locations'] ) ? '' : sanitize_text_field( $_GET['locations'] ); ?>
							<?php $cateogries = empty( $_GET['keycategory'] ) ? '' : sanitize_text_field( $_GET['keycategory'] ); ?>
							<div class="search-box-listing<?php echo $homeclass; ?>" id="search-type-filter">
								<input type="text" name="keyname" placeholder="Search Business" class="txt-grey" value="<?php echo $keyname; ?>" />
								<input type="text" name="keycategory" placeholder="Search by Business Category" class="txt-grey typeahead" value="<?php echo $cateogries; ?>" />
								<input value="" class="f-right s-button" type="submit" >
							</div>
							<div class="add-business">
								<a href="<?php echo site_url("add_listing.php?started=true"); ?>" class="btn-add-business"><?php echo __('Add Your Business for FREE'); ?></a>
							</div>
						</div>
					</form><div class="clear"></div>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php echo wp_nav_menu($defaults) ?>
					
				</div>
			</nav>
		</div>
		
			
		