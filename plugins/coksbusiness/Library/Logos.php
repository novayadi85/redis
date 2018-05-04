<?php 
class Coksbusiness_Library_Logos extends Coksbusiness_Core_All
{ 
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( &$this, 'section_meta' ) );
		add_action( 'save_post', array( &$this, 'save_section_meta' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'prfx_image_enqueue') );
	}
	
	public function section_meta( $post_type )
	{
		$post_types = array('business');     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			
			add_meta_box(
				'logo_images'
				,__( 'Business Logo', 'logo_header_section' )
				,array( $this, 'render_business_logo' )
				,$post_type
				,'side'
				,'low' 
			);
			add_meta_box(
				'header_image'
				,__( 'Cover image', 'cover_header_section' )
				,array( $this, 'render_image_header' )
				,$post_type
				,'normal'
				,'high' 
			);
         }
	}
	
	public function render_business_logo( $post )
	{
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );		
		$getCustMetaBox = unserialize(get_post_meta( $post->ID, '__business_logo', true ));
		$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
		$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : '';
		$hideme = isset($imgLogo) ? '' : " style='display:none;'";
		?>
			
			<p<?php echo $hideme; ?>><img src="<?php echo $imgLogoSrc; ?>" id="meta-image" width="240"/></p>
			<a href="#" id="meta-image-button"<?php echo isset($imgLogo) ? " style='display:none;'" : ""; ?>><?php _e( 'Choose or Upload an Image')?></a>
			<a href="#" id="meta-image-button-remove"<?php echo isset($imgLogo) ? "" : " style='display:none;'"; ?>><?php _e( 'Remove Selected Image')?></a>
			<input type="hidden" name="themebox[meta_logo_image]" id="meta-image-id" value="<?php echo $imgLogo; ?>" />
		<?php 
	}
	public function render_image_header( $post )
	{
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );		
		$getCustMetaBox = unserialize(get_post_meta( $post->ID, '__theme_custom_box', true ));
		$imgHeader = !empty($getCustMetaBox['__page_img_header']) ? $getCustMetaBox['__page_img_header'] : null;
		$imgHeaderSrc = !empty($imgHeader) ? wp_get_attachment_url( $imgHeader ) : '';
		$hideme = isset($imgHeader) ? '' : " style='display:none;'";
		?>
			<p<?php echo $hideme; ?>><img src="<?php echo $imgHeaderSrc; ?>" id="meta-image-h" width="240"/></p>
			<a href="#" id="meta-image-button-h"<?php echo isset($imgHeader) ? " style='display:none;'" : ""; ?>><?php _e( 'Choose or Upload an Image')?></a>
			<a href="#" id="meta-image-button-remove-h"<?php echo isset($imgHeader) ? "" : " style='display:none;'"; ?>><?php _e( 'Remove Selected Image')?></a>
			<input type="hidden" name="themebox[meta_header_image]" id="meta-image-id-h" value="<?php echo $imgHeader; ?>" />
			
		<?php 
	}
	
	/**
	 * Loads the image management javascript
	 */
	public function prfx_image_enqueue() {
		global $typenow;
			wp_enqueue_media();
			wp_register_script( 'business-logo', plugins_url( 'Source/js/business-logo.js', dirname(__FILE__) ) , array( 'jquery' ) );
			wp_localize_script( 'business-logo', 'meta_image',
				array(
					'title' => __( 'Business media gallery' ),
					'button' => __( 'Use this image' ),
				)
			);
			wp_enqueue_script( 'business-logo' );
	}
	
	public function save_section_meta( $post_id ) {
 
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
	 
		// Checks for input and sanitizes/saves if needed
		if( isset( $_POST[ 'themebox' ] ) ) {
			$getParams = $_POST['themebox'];
			
			$imgId = empty($getParams['meta_logo_image']) ? '' : sanitize_text_field(trim($getParams['meta_logo_image']));
			$datas = array('__business_img_logo' => $imgId );
			
			$data = serialize($datas);

	
			$imgIdNew = empty($getParams['meta_header_image']) ? '' : sanitize_text_field(trim($getParams['meta_header_image']));
			$dataImg = array('__page_img_header' => $imgIdNew );
			
			$dataNu = serialize($dataImg);				
		
			add_post_meta($post_id, '__business_logo', $data , true) or
				update_post_meta($post_id, '__business_logo', $data);
			
		
			add_post_meta($post_id, '__theme_custom_box', $dataNu , true) or
				update_post_meta($post_id, '__theme_custom_box', $dataNu);
		}
	 
	}

}