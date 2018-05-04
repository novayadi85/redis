<?php 
class Coksbusiness_Library_Metaboxes extends Coksbusiness_Core_All{
	private $postType = 'business';
	
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( &$this, 'section_meta' ) );
		add_action( 'save_post', array( &$this, 'save_section_meta' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'datepicker_script_inject' ));
	}
	
	public function datepicker_script_inject() {
		wp_enqueue_style( 'timepickicss', plugins_url('Source/dist/timepicki.css', dirname(__FILE__)));
		wp_enqueue_script( 'timepickijs', plugins_url('Source/dist/timepicki.js', dirname(__FILE__)));
	}
	
	
	public function section_meta( $post_type ) {
		$post_types = array($this->postType);     //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			if ( current_user_can( 'manage_options' ) ){
				add_meta_box(
					'business_member_type'
					,__( 'Member Type', 'section_attr' )
					,array( $this, 'reder_member_type' )
					,$post_type
					,'side'
					,'default'
				);
			}
			add_meta_box(
				'business_contact'
				,__( 'General Information', 'section_attr' )
				,array( $this, 'render_form_component' )
				,$post_type
				,'normal'
				,'default'
			);
			add_meta_box(
				'business_address'
				,__( 'Adress and Maps', 'section_attr' )
				,array( $this, 'render_form_adress_map' )
				,$post_type
				,'normal'
				,'default'
			);
			add_meta_box(
				'business_hours'
				,__( 'Opening Hour', 'section_attr' )
				,array( $this, 'render_form_hours' )
				,$post_type
				,'normal'
				,'default'
			);
         }
	}
	
	
	public function render_form_component( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = unserialize(get_post_meta( $post->ID, '__business_contact', true ));				
		?>
		
		<p><b><?php echo __('Phone'); ?></b><br />
		<input type="text" name="bsnatr[phone]"  id="phone" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_phone']) ? '' : $pAttrCust['_phone'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Your Company Phone Number'); ?></small></i></p>
		
		<p><b><?php echo __('Email'); ?></b><br />
		<input type="text" name="bsnatr[email]"  id="email" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_email']) ? '' : $pAttrCust['_email'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Your Company Email'); ?></small></i></p>
		
		<p><b><?php echo __('Keywords'); ?></b><br />
		<input type="text" name="bsnatr[keywords]"  id="keywords" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_keywords']) ? '' : $pAttrCust['_keywords'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Separate with comma (,)'); ?></small></i></p>
		
		<p><b><?php echo __('Web'); ?></b><br />
		<input type="text" name="bsnatr[web]"  id="web" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_website_address']) ? '' : $pAttrCust['_website_address'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Link to your company website'); ?></small></i></p>
		
		<p><b><?php echo __('Facebook'); ?></b><br />
		<input type="text" name="bsnatr[fb]"  id="fb" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_facebook']) ? '' : $pAttrCust['_facebook'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Link to facebook'); ?></small></i></p>
		
		<p><b><?php echo __('Google+'); ?></b><br />
		<input type="text" name="bsnatr[gplus]"  id="gplus" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_gplus']) ? '' : $pAttrCust['_gplus'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Link to google plus'); ?></small></i></p>
		
		<p><b><?php echo __('Twitter'); ?></b><br />
		<input type="text" name="bsnatr[twitter]"  id="twitter" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_twitter']) ? '' : $pAttrCust['_twitter'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Link to twitter'); ?></small></i></p>
	
	<?php 		
		
	}
	public function render_form_adress_map( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = unserialize(get_post_meta( $post->ID, '__business_contact', true ));				
		$postMaps = get_post_meta( $post->ID, '__post_maps', true );				
		?>
		
		<p><b><?php echo __('Address'); ?></b><br />
		<input type="text" name="bsnatr[address]"  id="address" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_address']) ? '' : $pAttrCust['_address'] )); ?>" class="regular-text ltr" /><br />
		<i><small><?php echo __('Your Company Address'); ?></small></i></p>
		
		<p><b><?php echo __('Maps code'); ?></b><br />
		<textarea id="bsnatr[maps_code]" name="bsnatr[maps_code]" rows="5" cols="40" style="width:100%">
            <?php echo esc_attr(stripslashes(empty($postMaps) ? '' : $postMaps )); ?></textarea>
		<br />
		<i><small><?php echo __("Add maps code snipet. If you don't know, please ask to fucking google dude!"); ?></small></i></p>
	
	<?php 		
	}
	
	public function render_form_hours( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = unserialize(get_post_meta( $post->ID, '_business_hours', true ));
		
		$_countday = 7;
		?>
		
		<?php for($i=1;$i<=$_countday; $i++): ?>
		<div class="b_shecdule">
			<?php $day = $this->convert_day($i); ?>
			<?php $lowerDay = strtolower($day); ?>
			<input type="checkbox" name="bsnatr[is_open_on_<?php echo $lowerDay; ?>]" value="yes" class="is_day_open" <?php echo ($pAttrCust['_is_open_on_' . $lowerDay] == 'yes') ? 'checked="checked"' : ''; ?> /><strong><?php echo __($day); ?></strong>&nbsp;&nbsp;&nbsp;<br />
			<div class="b_hours" style="<?php echo ($pAttrCust['_is_open_on_' . $lowerDay] == 'yes') ? 'display:block;' : 'display:none;'; ?>">
				Open : <input type="text" id="time-open-<?php echo $lowerDay; ?>" name="bsnatr[oph_<?php echo $lowerDay; ?>]" class="time_element" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_oph_' . $lowerDay]) ? '09:00' : $pAttrCust['_oph_' . $lowerDay] )); ?>" /><br />
				Close : <input type="text" id="time-close-<?php echo $lowerDay; ?>" name="bsnatr[cph_<?php echo $lowerDay; ?>]" class="time_element" value="<?php echo esc_attr(stripslashes(empty($pAttrCust['_cph_' . $lowerDay]) ? '17:00' : $pAttrCust['_cph_' . $lowerDay] )); ?>" />				
			</div>
		</div>
		<br />
		<?php endfor; ?>
		<script>
			jQuery(function($) {				
				$('.is_day_open').click(function() {
					var b_hours = $(this).parent('.b_shecdule').find('.b_hours');
					if($(this).prop("checked")){						
						$(b_hours).css('display','block');
					}else{
						$(b_hours).css('display','none');
					}
				});
				var timepickiOpt = {
					max_hour_value:24,
					show_meridian:false
				};
				$(".time_element").timepicki(timepickiOpt);
			});
			
		</script>
	<?php 		
		
	}
	
	public function reder_member_type( $post ) {
		wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
		$pAttrCust = get_post_meta( $post->ID, '__business_type', true );
		
		$member_types = array( '' => 'Free', 'Premium' => 'Premium' );
		
		
		?>
		
		<div class="row">
			<select name="bsnatr[by_member_type]" class="form-control">
			<?php foreach($member_types as $member_type => $val): ?>
				<?php $selected = ($pAttrCust == $member_type) ? ' SELECTED' : ''; ?>
				<option value="<?=$member_type;?>"<?=$selected;?>><?=$val;?></option>
			<?php endforeach; ?>
			</select>
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
		
		if($this->postType == $_POST['post_type']) {
			$getParams = $_POST['bsnatr'];
			$data['_phone'] = empty($getParams['phone']) ? null : addslashes(trim($getParams['phone']));			
			$data['_email'] = empty($getParams['email']) ? null : addslashes(trim($getParams['email']));			
			$data['_website_address'] = empty($getParams['web']) ? null : addslashes(trim($getParams['web']));			
			$data['_facebook'] = empty($getParams['fb']) ? null : addslashes(trim($getParams['fb']));			
			$data['_gplus'] = empty($getParams['gplus']) ? null : addslashes(trim($getParams['gplus']));			
			$data['_twitter'] = empty($getParams['twitter']) ? null : addslashes(trim($getParams['twitter']));	
			$data['_address'] = empty($getParams['address']) ? null : addslashes(trim($getParams['address']));	
			$data['_keywords'] = empty($getParams['keywords']) ? null : addslashes(trim($getParams['keywords']));	
			$_map_snipet = empty($getParams['maps_code']) ? null : addslashes(trim($getParams['maps_code']));	
			
			$business_type = empty($getParams['by_member_type']) ? 'free' : addslashes(trim($getParams['by_member_type']));		
			
			
			$setData = serialize($data);
			$business_work_day = serialize($this->add_office_hours($getParams ));
			
			add_post_meta($post_id, '__business_contact', $setData , true) or
				update_post_meta($post_id, '__business_contact', $setData);
			
			add_post_meta($post_id, '__post_maps', $_map_snipet , true) or
				update_post_meta($post_id, '__post_maps', $_map_snipet);
				
			add_post_meta($post_id, '_business_hours', $business_work_day , true) or
				update_post_meta($post_id, '_business_hours', $business_work_day);
				
			add_post_meta($post_id, '__business_type', $business_type , true) or
				update_post_meta($post_id, '__business_type', $business_type);
		}
	}
	
	private function add_office_hours($request)
	{
		for($i=1;$i<=7; $i++){
			$day = strtolower($this->convert_day($i)); 
			$data['_is_open_on_' . $day] = empty($request['is_open_on_' . $day]) ? 'no' : $request['is_open_on_' . $day];
			$data['_oph_' . $day] = empty($request['oph_' . $day]) ? '00 : 00' : $request['oph_' . $day];
			$data['_cph_' . $day] = empty($request['cph_' . $day]) ? '00 : 00' : $request['cph_' . $day];
		}
		return $data;
	}
}