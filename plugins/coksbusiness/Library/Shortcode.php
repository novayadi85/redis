<?php 
class Coksbusiness_Library_Shortcode extends Coksbusiness_Core_All{ 
	private $business_cat_posts = 0;
	private $business_max_pages = 0;
	private $current_paged = 1;
	private $businessPostsByCat = array();
	private $searchBusiness = array();
	private $renderingLiBusines = '';
	private $notitle = '';
	private $list_type = '';
	private $free_list_size = 7;
	public function __construct(){
		return '';
	}	
	public function getBusinessPosts($count,$order,$type = '')
	{
		$args = array(
			'posts_per_page' => $count,
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => 'business',
			'orderby' => 'menu_order',
			'order'   => $order,
						
		);
		if($type != ''){
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => $type,
						'compare' => 'LIKE',
					),
				);
		}else{
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => 'Premium',
						'compare' => 'NOT_LIKE',
					),
				);
		}
		$query = new WP_Query( $args );
		$onlyTitle = ($type == 'Premium') ? FALSE : TRUE;
		if ( $query->have_posts() ) {	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$theLast = ($i%4 == 0) ? ' last' : '';
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'medium');
				
				$getCustMetaBox = unserialize(get_post_meta( $query->post->ID, '__business_logo', true ));
				$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
				$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : plugins_url( 'Source/images/default-logo.jpg', dirname(__FILE__)  );
				$setListArgs = array(					
						'ID'=> $query->post->ID,
						'title'=> get_the_title(),
						'logo'=> $imgLogoSrc,
						'featureImg'=> $getFeatured[0],
						'excerpt'=> $query->post->post_excerpt,
						'link'=> get_permalink(),
						'last'=> $theLast,
						'only_title' => $onlyTitle
				);
				
				$list[] = $this->setRenderingLiBusiness($setListArgs);
				$i++;
			}
		}else{
			$list[] = "No business available.";
		}
		
		return $list;
	}	
	public function getRate($post_id){
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
	
	private function set_count_business_cat_posts($count){
		$this->business_cat_posts = $count;
	}
	public function count_business_cat_posts(){
		return $this->business_cat_posts;
	}
	private function set_max_business_cat_page($count){
		$this->business_max_pages = $count;
	}
	public function count_business_cat_pages(){
		return $this->business_max_pages;
	}
	public function getBusinessPostsTitle($count)
	{
		$args = array(
			'posts_per_page' => $count,
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => 'business',
			//'orderby' => 'ID menu_order',
			'orderby' => 'order',
			'order'   => $order,
			
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {	
			$i = 1;
			while ( $query->have_posts() ) {
				$query->the_post();
				$theLast = ($i%4 == 0) ? ' last' : '';
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->ID), 'full');
				$list[] = "<li class='grid-item".$theLast."'><div class='grid-thumb'><img src='".$getFeatured[0]. "' alt='".get_the_title()."' /></div><div class='grid-text only-title'><h4><a style=\"color:#fff;\" href=\"".get_permalink($query->ID)."\">".get_the_title().">></a></h4></div></li>";
				$i++;
			}
		}else{
			$list[] = "No business available.";
		}
		
		return $list;
	}
	public function render_business($order = 'DESC',$type = '',$post_per_page = 5) {
		ob_start();		
		$list_type = empty($type) ? 'list' : 'grid';		
		$getBusinessPosts = $this->getBusinessPosts($post_per_page,$order,$type) ;
		if(!empty($getBusinessPosts)){
			$html[] = '<div id="business-slide" class="business-flex">';
			$html[] = '<ul class="'.$list_type.'-slide">';
				$html[] = join($getBusinessPosts);	
			$html[] = '</ul>';
			$html[] = '</div>';
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		echo join($html);
		return ob_get_clean();
	}
	public function getBusinessPostsByCat() {
		ob_start();			
		//$getBusinessPosts = $this->setBusinessPostsByCat($array) ;
		$getBusinessPosts = $this->businessPostsByCat;
		if(!empty($getBusinessPosts)){
			$html[] = '<div class="business-flex" id="list-'.$this->list_type.'">';
				$html[] = '<ul class="'.$this->list_type.'-slide">';
					$html[] = join($getBusinessPosts);	
				$html[] = '</ul>';
			
			$html[] = '</div>';
			$html[] = $this->custom_pagination();
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		return join($html);
		return ob_get_clean();
	}
	public function setBusinessPostsByCat($array = array())
	{
		global $wp_query;
        wp_reset_query();
		$array = (object) $array;
		$busCatFilter = '';
		 $catType = 'category';
		 $this->set_count_business_cat_posts(0);
		if(!empty($array->term_id)){
				$busCatFilter = array(
					array(
						'taxonomy' => 'business-' . $catType,
						'field' => 'term_id',
						'terms' => array( $array->term_id)
					),
				);
		}
		$this->current_paged = !empty( $_GET['paged'] ) ? sanitize_text_field($_GET['paged']) : 1;
		$this->list_type = empty($array->type) ? 'list' : 'grid';
		$args = array(
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => 'business',
			'orderby' => 'menu_order',
			'caller_get_posts' => 1,
			'order'   => empty($array->order) ? "ASC" : $array->order,
			'tax_query' => $busCatFilter		
		);
		if($array->type == 'Premium'){
			$args['posts_per_page'] = empty($array->count) ? 99999 : $array->count;
			$args['paged'] = $this->current_paged;
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => $array->type,
						'compare' => 'LIKE',
					),
				);
		}else{
			$args['posts_per_page'] =  99999;
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => 'Premium',
						'compare' => 'NOT LIKE',
					),
				);
		}
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {	
			$i = 1;
			$this->set_count_business_cat_posts($query->found_posts);
			$this->set_max_business_cat_page($query->max_num_pages);
			while ( $query->have_posts() ) {
				$query->the_post();
				$theLast = ($i%3 == 0) ? ' last' : '';
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'medium');
				
				$getCustMetaBox = unserialize(get_post_meta( $query->post->ID, '__business_logo', true ));
				$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
				$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : plugins_url( 'Source/images/default-logo.jpg', dirname(__FILE__)  );
				$onlyTitle = ($array->type == 'Premium') ? FALSE : TRUE;
				$setListArgs = array(					
						'ID'=> $query->post->ID,
						'title'=> get_the_title(),
						'logo'=> $imgLogoSrc,
						'featureImg'=> $getFeatured[0],
						'excerpt'=> $query->post->post_excerpt,
						'link'=> get_permalink(),
						'last'=> $theLast,
						'only_title' => $onlyTitle,
						
				);
				
				if(empty($array->type)){
					if($k++%$this->free_list_size == 0){
						$list[] = '<li class="listed-item">';
					}
						$list[] = $this->setRenderingLiBusiness($setListArgs);
					if($k%$this->free_list_size == 0 || $k == $query->found_posts){
						$list[] = '</li>';
					}
					
				}else{
					$list[] = $this->setRenderingLiBusiness($setListArgs);
				}
				$i++;
			}
			
		}else{
			//$list[] = "No business available.";
			$list[] = "";
		}
		
		$this->businessPostsByCat = $list;
		//return $list;
	}
	public function setSearchBusiness($array = array())
	{
		
		 $this->set_count_business_cat_posts(0);
		$array = (object) $array;
		$busCatFilter = '';
		if(!empty($array->category) || !empty($array->location)){
				if(!empty($array->category)){
					$busCatFilter = array(
							array(
								'taxonomy' => 'business-category',
								'field' => 'name',
								'terms' =>  $array->category
							),
					);
				}
				if(!empty($array->location)){
					$busCatFilter = array(
							array(
								'taxonomy' => 'business-location',
								'field' => 'name',
								'terms' =>  $array->location
							),
					);
				}
				
		}

		if(!empty($array->category) && !empty($array->location)){
			$busCatFilter = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'business-category',
					'field' => 'name',
					'terms' =>  $array->category
				),
				array(
					'taxonomy' => 'business-location',
					'field' => 'name',
					'terms' => $array->location
				),
			);
		}
		$this->current_paged = !empty( $_GET['paged'] ) ? sanitize_text_field($_GET['paged']) : 1;
		$this->list_type = empty($array->type) ? 'list' : 'grid';
		$args = array(
			
			'nopaging' => false,
			'update_post_term_cache' => false, 
			'update_post_meta_cache' => false, 
			'post_type' => 'business',
			'orderby' => 'menu_order',
			'caller_get_posts' => 1,
			'order'   => empty($array->order) ? "ASC" : $array->order,
			's' => $array->keyname,
			'tax_query' => $busCatFilter
		);
		if($array->type == 'Premium'){
			$args['paged'] = $this->current_paged;
			$args['posts_per_page'] = empty($array->count) ? 99999 : $array->count;
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => $array->type,
						'compare' => 'LIKE',
					),
				);
		}else{
			$args['posts_per_page'] = 99999;
			$args['meta_query'] = array(
					array(
						'key'     => '__business_type',
						'value'   => 'Premium',
						'compare' => 'NOT LIKE',
					),
				);
		}
		$query = new WP_Query( $args );
		/*echo "<pre>";
		var_dump($query->request); die;*/
		/*echo "<pre>"; print_r($args); die;*/
		if ( $query->have_posts() ) {	
			$i = 1;
			$k = 0;
			$this->set_count_business_cat_posts($query->found_posts);
			$this->set_max_business_cat_page($query->max_num_pages);
			while ( $query->have_posts() ) {
				$query->the_post();
				$theLast = ($i%3 == 0) ? ' last' : '';
				$getFeatured = wp_get_attachment_image_src( get_post_thumbnail_id($query->post->ID), 'medium');
				
				$getCustMetaBox = unserialize(get_post_meta( $query->post->ID, '__business_logo', true ));
				$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
				$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : plugins_url( 'Source/images/default-logo.jpg', dirname(__FILE__)  );
				
				$onlyTitle = ($array->type == 'Premium') ? FALSE : TRUE;
				
				$setListArgs = array(					
						'ID'=> $query->post->ID,
						'title'=> get_the_title(),
						'logo'=> $imgLogoSrc,
						'featureImg'=> $getFeatured[0],
						'excerpt'=> $query->post->post_excerpt,
						'link'=> get_permalink(),
						'last'=> $theLast,
						'only_title' => $onlyTitle,
				);
				if(empty($array->type)){
					if($k++%$this->free_list_size == 0){
						$list[] = '<li class="listed-item">';
					}
						$list[] = $this->setRenderingLiBusiness($setListArgs);
					if($k%$this->free_list_size == 0 || $k == $query->found_posts){
						$list[] = '</li>';
					}
					
				}else{
					$list[] = $this->setRenderingLiBusiness($setListArgs);
				}
				$i++;
			}
			
		}else{
			//$list[] = "No business available.";
			$list[] = " ";
		}
		
		$this->searchBusiness = $list;
		//return $list;
	}
	public function getBusinessSearch() {
		ob_start();			
		//$getBusinessPosts = $this->setSearchBusiness($array) ;
		$getBusinessPosts = $this->searchBusiness;
		if(!empty($getBusinessPosts)){
			$html[] = '<div class="business-flex" id="list-'.$this->list_type.'">';
				$html[] = '<ul class="'.$this->list_type.'-slide">';
					$html[] = join($getBusinessPosts);	
				$html[] = '</ul>';
			
			$html[] = '</div>';
			$html[] = $this->custom_pagination();
		}else{
			$html[] = "";
		}		
		wp_reset_postdata();	
		return join($html);
		return ob_get_clean();
	}
	public function custom_pagination() {

	  if ($this->count_business_cat_pages() == '') {
		global $wp_query;
		$this->set_max_business_cat_page($wp_query->max_num_pages);
		if(!$this->count_business_cat_pages()) {
			$this->set_max_business_cat_page(1);
		}
	  }

	  $pagination_args = array(
		'base'            => '%_%',
		'format'          => '?paged=%#%',
		'total'           => $this->count_business_cat_pages(),
		'current'         => $this->current_paged,
		'show_all'        => false,
		'end_size'        => 1,
		'mid_size'        => 2,
		'prev_next'       => True,
		'prev_text'       => __('&laquo;'),
		'next_text'       => __('&raquo;'),
		'type'            => 'plain',
		'add_args'        => false,
		'add_fragment'    => ''
	  );

	  $paginate_links = paginate_links($pagination_args);
		$html = '';
	  if ($paginate_links) {
		$html .= "<nav class='custom-pagination'>";
		  $html .= "<span class='page-numbers page-num'>Page " . $this->current_paged . " of " . $this->count_business_cat_pages . "</span> ";
		  $html .= $paginate_links;
		$html .= "</nav>";
	  }
		return $html;
	}


	protected function setRenderingLiBusiness($array)
	{
		if(is_array($array)){
			$array = (object) $array;
			if($array->only_title){
				$pAttrCust = unserialize(get_post_meta( $array->ID, '__business_contact', true ));
				$html = "<div class='listed-item".$array->last."'><a href='".$array->link."' 
				class='a-displayblock pull-left'><b>".$array->title."</b><br /><span class='grey'>".$pAttrCust['_address']."</span></a><div class='pull-right'><a href='#' class='btn btn-default btn-xs' data-toggle='modal' data-target='#claimBusiness' data-whatever=" . get_the_title() . ">+ Claim business</a></div></div>";
			}else{
				$f_img = empty($array->featureImg) ? homeUrl('/assets/img/cover-list.jpg') : $array->featureImg;
				$html = "<li class='grid-item".$array->last."'><a href='".$array->link."' 
				class='a-displayblock'><div class='grid-thumb'><img src='". $f_img . "' alt='".$array->title."' /><div class='businessmark'><img src='" . $array->logo . "' /></div></div><div class='grid-text'><div class='rate-box'>" . $this->getRate($array->ID). "</div><h4>".$array->title."</h4>" . $array->excerpt . "</div><div class='grid-action'>More &raquo;</div></a></li>";
			}
			
		}else{
			$html = '';
		}

		return $html;
	}
}