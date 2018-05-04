<?php 
class Cokslider_Library_Metaboxes extends Cokslider_Core_All{ 
	public function __construct(){
		add_action( 'add_meta_boxes', array( &$this, 'section_meta' ) );
		add_action( 'save_post', array( &$this, 'save_section_meta' ) );		
	}
	
	public function section_meta( $post_type ) {
		$post_types = array('slider');     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			
			add_meta_box(
				'add_linked'
				,__( 'Add link', 'section_attr' )
				,array( $this, 'render_form_addlink' )
				,$post_type
				,'normal'
				,'default'
			);
         }
		 if (  $post_type == 'page') {
			
			add_meta_box(
				'add_relation'
				,__( 'Add Slider', 'section_attr_rel' )
				,array( $this, 'render_form_addrel' )
				,$post_type
				,'side'
				,'default'
			);
         }
	}
	
	
	public function render_form_addlink( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = get_post_meta( $post->ID, '__page_extlink', true );
		$pAttrCust2 = get_post_meta( $post->ID, '__page_intlink', true );
		$pageExtLink = empty($pAttrCust) ? '' : $pAttrCust;
		$pageIntLink = empty($pAttrCust2) ? '' : $pAttrCust2;
				
		echo "<p><strong>External link</strong><br />";
		echo "<input type='text' name='pgatr[ext_link]'  id='ext_link' value='" . esc_attr(stripslashes($pageExtLink )) . "' /><br />
		<i><small>Fill with external link</small></i></p>";		
		echo "<p><strong>Internal link</strong><br />";
		echo "<select name='pgatr[int_link]'  id='int_link'>
				<option value='0'>Choose</option>";
		echo $this->getPages($pageIntLink);
		echo "</select><br />";
		echo "<i><small>Choose internal link</small></i></p>";
	}
	
	public function render_form_addrel( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = get_post_meta( $post->ID, '__slider_rel', true );
		$pageRel = empty($pAttrCust) ? '' : $pAttrCust;
				
		echo "<p><strong>Relation with slider link</strong><br />";
		echo "<select name='pgatr[int_relation_slider]' id='int_relation_slider'>
				<option value='0'>Choose</option>";
		echo $this->getSliderPost($pageRel);
		echo "</select><br />";
		echo "<i><small>Choose slider</small></i></p>";
	}
	
	
	public function save_section_meta( $post_id ) {
	
		if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['myplugin_inner_custom_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		if ( 'page' == $_POST['post_type'] || 'slider' == $_POST['post_type']  ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} elseif('post' == $_POST['post_type']){

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		
		if('slider' == $_POST['post_type']) {
			$getParams = $_POST['pgatr'];
			$extLink = empty($getParams['ext_link']) ? null : addslashes(trim($getParams['ext_link']));			
			$intLink = empty($getParams['int_link']) ? null : addslashes(trim($getParams['int_link']));			
			
			add_post_meta($post_id, '__page_extlink', $extLink , true) or
				update_post_meta($post_id, '__page_extlink', $extLink);
				
			add_post_meta($post_id, '__page_intlink', $intLink , true) or
				update_post_meta($post_id, '__page_intlink', $intLink);
		}	
		if('page' == $_POST['post_type']) {
			$setparams = $_POST['pgatr'];
			$extLink = empty($setparams['int_relation_slider']) ? null : addslashes(trim($setparams['int_relation_slider']));			
			
			add_post_meta($post_id, '__slider_rel', $extLink , true) or
				update_post_meta($post_id, '__slider_rel', $extLink);
		}	
		
		
	}
	private function getPages($curr)
	{
		$args = array(
			'posts_per_page' => -1,
			'nopaging' => true,
			'post_type' => 'page',
			'orderby' => 'post_title ID',
			'order'   => 'ASC'
			
		);
		
		$lastposts = get_posts( $args );
		 
		if ( $lastposts ) {
			foreach ( $lastposts as $query ) :
				setup_postdata( $query );
				$selected = ($curr == $query->ID) ? " SELECTED='SELECTED'" : "";
				$html[] = '<option value="' . $query->ID . '"'.$selected.'>';
				$html[] = $query->post_title;
				$html[] = '</option>';
			endforeach; 
			wp_reset_postdata();
		}
		
		return join($html);
	}
	private function getSliderPost($curr)
	{
		$args = array(
			'posts_per_page' => -1,
			'post_parent' => 0,
			'post_type' => 'slider',
			'orderby' => 'post_title ID',
			'order'   => 'ASC',
			'nopaging' => true
		);
		$lastposts = get_posts( $args );
		 
		if ( $lastposts ) {
			foreach ( $lastposts as $query ) :
				setup_postdata( $query );
				$selected = ($curr == $query->ID) ? " SELECTED='SELECTED'" : "";
				$html[] = '<option value="' . $query->ID . '"'.$selected.'>';
				$html[] = $query->post_title;
				$html[] = '</option>';
			endforeach; 
			wp_reset_postdata();
		}	
		
		return join($html);
	}
}