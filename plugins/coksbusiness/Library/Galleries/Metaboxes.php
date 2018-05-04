<?php 
class Coksbusiness_Library_Galleries_Metaboxes extends Coksbusiness_Core_All{
	private $postType = 'business';
	
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( &$this, 'section_meta' ) );
		add_action( 'save_post', array( &$this, 'save_section_meta' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'multi_selction_script_inject' ));
	}
	public function multi_selction_script_inject() 
	{
		global $typenow;
		wp_enqueue_media();
		wp_enqueue_style( 'cokde_galleries_style', plugins_url( 'Source/css/cokde_galleries_style.css', dirname(dirname(__FILE__) ))  );
		wp_register_script( 'cokde_galleries', plugins_url( 'Source/js/cokde_galleries.js', dirname(dirname(__FILE__) )) , array( 'jquery' ) );
		wp_enqueue_script( 'cokde_galleries' );
	}
	
	
	public function section_meta( $post_type ) 
	{
		$post_types = array($this->postType);     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			
			add_meta_box(
				'business_galerries'
				,__( 'Galleries', 'section_attr' )
				,array( $this, 'render_galleries_form' )
				,$post_type
				,'normal'
				,'default'
			);
         }
	}
	
	
	public function render_galleries_form( $post ) 
	{
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );		
		$get_gallery = get_post_meta( $post->ID, '__galerries_post', true );
		$set_galleries = !empty($get_gallery) ? explode(',',$get_gallery) : array();
		
		?>
		<div id="add_galleries" style="overflow: hidden; float: none; clear: both;">
		<?php 
		if(count($set_galleries) > 0):
			foreach($set_galleries as $galery_id){				
				$img_url =  wp_get_attachment_image_src( $galery_id, 'thumbnail');
				if(empty($img_url)){
					$img_url = array();
				}				
		?>
			<div class="img-thumb-gallery" style="" >
				<img src="<?php echo $img_url[0]; ?>" />
				<input type="hidden" name="id_galleries[]" value="<?=$galery_id;?>">
				<a href="javascript:void(0)" class="ckd_remove_me">Remove</a>
			</div>
			
		<?php }
		else: ?>

		<?php endif; ?>
			
		</div>
		<div id="add_galleries_action" style="margin-top: 10px; ">
			<a href="#" id="ckd-multiple-img"><?php _e( 'Choose or Upload an Images')?></a>
		</div>
		<?php  
	}
	
		
	public function save_section_meta( $post_id ) {
		if ( ! isset( $_POST['myplugin_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['myplugin_inner_custom_box_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
		if ( 'page' == $_POST['post_type'] || $this->postType == $_POST['post_type']  ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} elseif('post' == $_POST['post_type']){

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
	 
		// Checks for input and sanitizes/saves if needed
		if($this->postType == $_POST['post_type']) {
			$getParams = $_POST['id_galleries'];
			if(!empty($getParams)){
				$setData = implode(',', $getParams);
				add_post_meta($post_id, '__galerries_post', $setData , true) or
				update_post_meta($post_id, '__galerries_post', $setData);
			}
					
			
		}
	}	
}