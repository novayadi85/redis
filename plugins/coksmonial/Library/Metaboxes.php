<?php 
class Coksmonial_Library_Metaboxes extends Coksmonial_Core_All{ 
	public function __construct(){
		add_action( 'add_meta_boxes', array( &$this, 'section_meta' ) );
		add_action( 'save_post', array( &$this, 'save_section_meta' ) );		
	}
	
	public function section_meta( $post_type ) {
		$post_types = array('testimonial');     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			
			add_meta_box(
				'add_testimonial_componen'
				,__( 'General Information', 'section_attr' )
				,array( $this, 'render_form_component' )
				,$post_type
				,'normal'
				,'default'
			);
         }
	}
	
	
	public function render_form_component( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = unserialize(get_post_meta( $post->ID, '__testimonial_attr', true ));
		$company = empty($pAttrCust['_company']) ? '' : $pAttrCust['_company'];
		$staff_position = empty($pAttrCust['_staff_position']) ? '' : $pAttrCust['_staff_position'];
				
		echo "<p><strong>Company</strong><br />";
		echo "<input type='text' name='pgatr[company]'  id='company' value='" . esc_attr(stripslashes($company )) . "' /><br />
		<i><small>Company name</small></i></p>";	
		echo "<p><strong>Position</strong><br />";
		echo "<input type='text' name='pgatr[staff_position]'  id='staff_position' value='" . esc_attr(stripslashes($staff_position )) . "' /><br />
		<i><small>Company name</small></i></p>";		
		
	}
	
	
	public function save_section_meta( $post_id ) {
	
		if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['myplugin_inner_custom_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		if ( 'page' == $_POST['post_type'] || 'testimonial' == $_POST['post_type']  ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} elseif('post' == $_POST['post_type']){

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		
		if('testimonial' == $_POST['post_type']) {
			$getParams = $_POST['pgatr'];
			$company = empty($getParams['company']) ? null : addslashes(trim($getParams['company']));			
			$position = empty($getParams['staff_position']) ? null : addslashes(trim($getParams['staff_position']));
			$convertdatas = array('_company' => $company, '_staff_position' => $position);
			$setData = serialize($convertdatas);
			
			add_post_meta($post_id, '__testimonial_attr', $setData , true) or
				update_post_meta($post_id, '__testimonial_attr', $setData);
		}	
		
		
	}
}