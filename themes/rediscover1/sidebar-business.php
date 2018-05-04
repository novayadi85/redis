<div class="block block-right">
	<div class="block-title">
		<?php echo __('Opening Hours'); ?>
	</div>
	<div class="block-content">
		<?php $days = array(1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday" ); ?>
		<?php $pAttrCust = unserialize(get_post_meta( $post->ID, '_business_hours', true ));; ?>
		<div class="block_days today">
			<ul class="the_day_list">
				<?php 
				if(!empty($pAttrCust['_is_open_on_' . strtolower(date('l'))]) && $pAttrCust['_is_open_on_' . strtolower(date('l'))]== 'yes'){
					$ophToday = (empty($pAttrCust['_oph_' . strtolower(date('l'))])) ? 'NA' : $pAttrCust['_oph_' . strtolower(date('l'))] ;
					$cphToday = (empty($pAttrCust['_cph_' . strtolower(date('l'))])) ? 'NA' : $pAttrCust['_cph_' . strtolower(date('l'))];
					$openToday = $ophToday . ' to ' . $cphToday;
				}else{
					$openToday = "Closed";
				}?>
				
				<?php 
				
				if(!empty($pAttrCust['_is_open_on_' . strtolower(date('l',strtotime("+1 day")))]) && $pAttrCust['_is_open_on_' . strtolower(date('l',strtotime("+1 day")))]== 'yes'){
					$ophTomorrow = (empty($pAttrCust['_oph_' . strtolower(date('l',strtotime("+1 day")))])) ? 'NA' : $pAttrCust['_oph_' . strtolower(date('l',strtotime("+1 day")))] ;
					$cphTomorrow = (empty($pAttrCust['_cph_' . strtolower(date('l',strtotime("+1 day")))])) ? 'NA' : $pAttrCust['_cph_' . strtolower(date('l',strtotime("+1 day")))];
					$openTomorrow = $ophTomorrow . ' to ' . $cphTomorrow;
				}else{
					$openTomorrow = "Closed";
				}?>
				
				<li><div class="day_name"><?php echo __('Today'); ?></div><div class="open_time"><?php echo $openToday ?></div></li>
				<li><div class="day_name"><?php echo __('Tomorrow'); ?></div><div class="open_time"><?php echo $openTomorrow; ?></div></li>
			</ul>
		</div>
		<div class="block_days">
			<ul class="the_day_list">
			<?php foreach($days as $day): ?>
				<?php 
					if(!empty($pAttrCust['_is_open_on_' . strtolower($day)]) && $pAttrCust['_is_open_on_' . strtolower($day)]== 'yes'){
						$ophToday = (empty($pAttrCust['_oph_' . strtolower($day)])) ? 'NA' : $pAttrCust['_oph_' . strtolower($day)];
						$cphToday = (empty($pAttrCust['_cph_' . strtolower($day)])) ? 'NA' : $pAttrCust['_cph_' . strtolower($day)];
						$openToday = $ophToday . ' to ' . $cphToday;
					}else{
						$openToday = "Closed";
					}
				?>
				<li><div class="day_name"><?php echo $day; ?></div><div class="open_time"><?php echo $openToday; ?></div></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<div class="block block-right">
	<div class="block-title">
		<?php echo __('Company Profile'); ?>
	</div>
	<div class="block-content">
		<?php 
			$getCustMetaBox = unserialize(get_post_meta( get_the_ID(), '__business_logo', true ));
			$imgLogo = !empty($getCustMetaBox['__business_img_logo']) ? $getCustMetaBox['__business_img_logo'] : null;
			$imgLogoSrc = !empty($imgLogo) ? wp_get_attachment_url( $imgLogo ) : '';
		?>
		<p><img class="logo-mini f-left" src="<?php echo $imgLogoSrc; ?>" /><?php echo get_the_excerpt(); ?></p>
	</div>
</div>
<div class="block block-right">
	<div class="block-title">
		<?php echo __('Keyword'); ?>
	</div>
	<div class="block-content">
		<?php $pAttrCust = unserialize(get_post_meta( $post->ID, '__business_contact', true )); ?>
		<?php if(!empty($pAttrCust['_keywords']) ): ?>
			<?php $keywords = explode(',', $pAttrCust['_keywords']); ?>
			<?php foreach ($keywords as $_key) {
				echo '<a href="' . homeUrl('searchbusiness?keyname=' . trim($_key)) . '" class="btn btn-keywords">'. ucfirst(trim($_key)) .'</a> ';
			}
			?>
		<?php else: ?>
			<a href="<?php echo homeUrl('searchbusiness?keyname=Business'); ?>" class="btn btn-keywords">Business</a> <a href="<?php echo homeUrl('searchbusiness?keyname=Profile'); ?>" class="btn btn-keywords">Profile</a> 
		<?php endif; ?>
	</div>
</div>