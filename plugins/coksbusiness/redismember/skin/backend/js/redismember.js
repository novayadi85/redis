jQuery(document).ready(function() {
	jQuery('button#create_member_add').click(function(){
		var url = ajaxurl ;
		var params = jQuery('#create_member').serializeArray();
		jQuery.ajax({ 
			type      : 'POST', 
			url       : url, 
			data      : {'params':params , 'action': 'save_member'}, 
			dataType  : 'json',
			
			success: function (response) {
				jQuery('#ajax-response').html(response.message);
				
			},
			complete:function(){
				window.setTimeout( function(){
					 window.location = "http://173.254.63.28/~redisco7/rediscover";
				}, 100 );
				return false;
			}
		});
	});
	
});