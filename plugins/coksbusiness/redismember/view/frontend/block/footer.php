<script type='text/javascript'>
jQuery(document).ready(function() {
	jcf.replaceAll();
	jQuery('#login_action').click(function(event){
		var params = jQuery('#loginForm').serializeArray();
		jQuery.ajax({
			'type': 'POST',
			'url': '<?php echo admin_url( 'admin-ajax.php' );?>',
			'data': {'params':params , 'action': 'login_member'}, 
			'timeout': 8000,
			'dataType': 'json' , 
			'success': function(response) {
				if(response.redirect){
					window.location.href = '<?php echo get_home_url();?>';
					jQuery('#myModal .response').html("");
				}
				else{
					jQuery('#myModal .response').html(response.message);
				}
			},
			'error': function(request, status, error) {
				
			}
		});
	});
});
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Log In</h4>
      </div>
      <div class="modal-body">
		<div class="response"></div>
		<?php wp_login_form(
			array(
				'form_id' => 'loginform-custom',
				'label_log_in' => __( 'Log In' ),
				'remember' => true
			)
		); ?>
      </div>
      <?php 
	  /* <div class="modal-footer">
           <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>
		   <button class="btn btn-primary" id="login_action" name="login_action">Log in</button>
      </div> */
	  ?>
    </div>
  </div>
</div>