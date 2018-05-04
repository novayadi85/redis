<?php

function add_new_option(){
	//add_options_page( 'Template Options', 'Template Options', 'manage_options', 'template-options', 'temp_options');
	add_submenu_page( 'themes.php', 'Template Options', 'Template Options', 'manage_options', 'template-options', 'temp_options' ); 
}

function temp_options(){
	if(is_admin() && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(empty($_POST)){
			return;
		}else{
			$company_addrers = 'company_addrers' ;
			$company_telp = 'company_telp' ;
			$site_socmedia = 'site_socmedia' ;
			$site_copyright = 'site_copyright' ;
			$max_gallery = 'max_gallery' ;
			$site_emergency = 'site_emergency' ;
			$design_by = 'design_by' ;
			
			$post = $_POST['shmfield']; 
			
			foreach($_POST['shmfield'] as $fld_name => $fld_val)
			{
				$fld_val = stripslashes( esc_textarea( wp_filter_post_kses($fld_val)));
				if ( get_option( $fld_name ) !== false ) {
					update_option( $fld_name, $fld_val );
				} else {
					$deprecated = null;
					add_option( $fld_name, $fld_val );
				}
			}
			
			
		}
	}
?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h2><?php _e('Template configuration'); ?></h2>
		<form method="post" action="">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="company_addrers"><?php _e('Address'); ?></label></th>
						<td><textarea name="shmfield[company_addrers]" id="company_addrers" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'company_addrers', '' )); ?></textarea>
						<p class="description"><?php _e('Add your company address.'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="company_telp"><?php _e('Telephone'); ?></label></th>
						<td><input name="shmfield[company_telp]" type="text" id="company_telp" value="<?php echo stripslashes(get_option( 'company_telp', '' )); ?>" class="regular-text">
						<p class="description"><?php _e('Add your company telp. number.'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="company_email"><?php _e('Email'); ?></label></th>
						<td><input name="shmfield[company_email]" type="text" id="company_email" value="<?php echo stripslashes(get_option( 'company_email', '' )); ?>" class="regular-text">
						<p class="description"><?php _e('Add your company email address.'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="site_socmedia"><?php _e('Social Media'); ?></label></th>
						<td><textarea name="shmfield[site_socmedia]" id="site_socmedia" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'site_socmedia', '' )); ?></textarea>
						<p class="description"><?php _e('Social media type name | Link to social media. And add line break to add more social media'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="site_copyright"><?php _e('Copyright'); ?></label></th>
						<td><input name="shmfield[site_copyright]" type="text" id="site_copyright" value="<?php echo stripslashes(htmlspecialchars(get_option( 'site_copyright', '' ))); ?>" class="regular-text">
						<p class="description"><?php _e('Add your site copyright here'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="design_by"><?php _e('Designed by'); ?></label></th>
						<td><input name="shmfield[design_by]" type="text" id="design_by" value="<?php echo stripslashes(get_option( 'design_by', '' )); ?>" class="regular-text">
						<p class="description"><?php _e('Designer|Link to Designer Website'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="site_whyus"><?php _e('Add why us text (side)'); ?></label></th>
						<td><textarea name="shmfield[site_whyus]" id="site_whyus" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'site_whyus', '' )); ?></textarea>
						<p class="description"><?php _e('Add why us text detail'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="defaul_testimonial"><?php _e('Add Default Testimonial'); ?></label></th>
						<td><textarea name="shmfield[defaul_testimonial]" id="defaul_testimonial" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'defaul_testimonial', '' )); ?></textarea>
						<p class="description">&nbsp;</p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="site_termservices"><?php _e('Add Term Service'); ?></label></th>
						<td><textarea name="shmfield[site_termservices]" id="site_termservices" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'site_termservices', '' )); ?></textarea>
						<p class="description">&nbsp;</p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="site_socmedia_footer"><?php _e('Social Media Footer'); ?></label></th>
						<td><textarea name="shmfield[site_socmedia_footer]" id="site_socmedia_footer" rows="10" cols="50" class="large-text code"><?php echo stripslashes(get_option( 'site_socmedia_footer', '' )); ?></textarea>
						<p class="description"><?php _e('Social media type name | Link to social media. And add line break to add more social media'); ?></p></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="_carousel_scroll"><?php _e('Slide To Scroll'); ?></label></th>
						<td><input type="text" name="shmfield[_carousel_scroll]" id="_carousel_scroll" class="regular-text" value="<?php echo stripslashes(get_option( '_carousel_scroll', '' )); ?>" />
						<p class="description"><?php _e('Add total scroll on carousel'); ?></p></td>
					</tr>
					
				</tbody>
			</table>

			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes'); ?>"></p>
		</form>
	</div>
<?php
	
}
if ( is_admin() ){ // admin actions
	add_action('admin_menu', 'add_new_option');
}