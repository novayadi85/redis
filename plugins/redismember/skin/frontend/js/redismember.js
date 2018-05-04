jQuery(document).ready(function() {
	tinymce.init({ 
		selector:'textarea.editor',
		menubar:false,
		statusbar: false, 
		themes: "modern"
	});
	
	jQuery('.account-nav-list .register').click(function(event){
		event.preventDefault();
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery("#top_user_access_sign_up .top_user_access_expand_wrapper").slideUp( "slow" );
			
		}
		else {
			jQuery('.account-nav-list .account').removeClass('active');
			jQuery(this).addClass('active');
			jQuery("#top_user_access_login .top_user_access_expand_wrapper").slideUp( "slow" );
			jQuery("#top_user_access_sign_up .top_user_access_expand_wrapper").slideDown( "slow" );
		}
	});
	
	jQuery('.account-nav-list .account').click(function(event){
		/* event.preventDefault();
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery("#top_user_access_login .top_user_access_expand_wrapper").slideUp( "slow" );
		}
		else {
			jQuery('.account-nav-list .register').removeClass('active');
			jQuery(this).addClass('active');
			jQuery("#top_user_access_sign_up .top_user_access_expand_wrapper").slideUp( "slow" );
			jQuery("#top_user_access_login .top_user_access_expand_wrapper").slideDown( "slow" );
		}	 */	
	});
	
	jQuery('.top_user_access_button.login').click(function(event){
		event.preventDefault();
		jQuery('#myModal').modal('show');
	});
	
	jQuery(".packages .btn-large").click(function(event){
		var val = jQuery(this).attr("data-package"); 
		event.preventDefault();
		jQuery("#business-package option[value='"+val+"']").prop('selected', true);
		jQuery(".packages").slideUp();
		jQuery(".step2").slideDown();
	});
	
	jQuery(".packages .choose_pricing").click(function(event){	
		var packages = jQuery(this).attr("data-package"); 
		var val = jQuery(this).attr("data-value"); 	
		var price = jQuery(this).attr("data-price"); 			
		jQuery.ajax({ 
			type      : 'POST', 
			url       : ajaxurl, 
			data      : {'action': 'required_ad' , 'price' : price, 'package_choosed' : packages , 'price_choosed' : val}, 
			dataType  : 'json',
			
			success: function (response) {
				if(response.error){
					jQuery(".login_form_ad").slideDown();
					jQuery(".after_login").slideUp();
				}
				else{
					jQuery(".login_form_ad").hide();
					jQuery(".after_login").show();		
					if(packages == "57" || packages ==57){			
						jQuery(".hide_on_free").hide();	
						jQuery(".show_on_free").show();	
						
					}		
					else {			
						jQuery(".hide_on_free").show();		
						jQuery(".show_on_free").hide();		
					}
					event.preventDefault();
					jQuery("#duration option[value='"+val+"']").prop('selected', true);
					jQuery("#business-package option[value='"+packages+"']").prop('selected', true);
					jQuery("#business-package option[value='"+packages+"']").addClass("test");
					jQuery(".packages").slideUp();
					jQuery(".step2").slideDown();	
				}
			}
		});
	
		
	});
	
	jQuery(".is_user").click(function(){
		if(jQuery(this).val() == 1){
			jQuery("#loginform-custom").hide();
			jQuery(".regForm").show();
		}
		else{
			
			
			jQuery("#loginform-custom").show();
			jQuery(".regForm").hide();
		}
	})
	
	jQuery(".step .btn.next").click(function(event){
		var elm = jQuery(this).closest(".step");
		var next = jQuery(this).next(".step");
		var step = jQuery(this).closest(".step").attr("data-step");
		
		jQuery(elm).find(".required").each(function(i){
			if(jQuery(this).val() == ""){
				jQuery(this).addClass("error");
				return false;
				event.stopPropagation();
			}
			else {
				jQuery(this).removeClass("error");
			}
			
		});
		
		if(jQuery(elm).find(".error").length <= 0){
			jQuery(elm).slideUp();
			jQuery.ajax({ 
				type      : 'POST', 
				url       : ajaxurl, 
				data      : {'step':step , 'action': 'set_step'}, 
				dataType  : 'json',
				
				success: function (response) {
					jQuery(elm).next(".step").slideDown();
				},
				complete:function(){
					return false;
				}
			});
			var packages = jQuery("#business-package").val(); 
			if(packages == "57" || packages ==57){			
				jQuery(".hide_on_free").hide();		
				jQuery(".show_on_free").show();	
			}		
			else {			
					
				jQuery(".hide_on_free").show();		
				jQuery(".show_on_free").hide();	
			}
		}
		
		
		
		
		
	});
	
	jQuery(".step .btn.prev").click(function(event){
		var elm = jQuery(this).closest(".step");
		console.log(elm);
		var prev = jQuery(this).prev(".step");
		var step = jQuery(this).closest(".step").attr("data-step");
		jQuery(elm).slideUp();
		jQuery(elm).prev(".step").slideDown();
	});
	
	
	
	/* Dropzone.options.myAwesomeDropzone = { 
		url: ajaxurl ,
		previewsContainer: ".dropzone-previews",
		uploadMultiple: true,
		parallelUploads: 100,
		maxFiles: 1,
		sending: function(file, xhr, formData){
			formData.append('action', 'upload_file');
			formData.append('multiple', false);
		},
		success: function(file, response){
			console.log(response);
		}
	}
	
	Dropzone.options.myAwesomeDropzone = { 
		url: ajaxurl ,
		previewsContainer: ".dropzone-previews",
		uploadMultiple: true,
		parallelUploads: 100,
		maxFiles: 1,
		sending: function(file, xhr, formData){
			formData.append('action', 'upload_file');
			formData.append('multiple', false);
		},
		success: function(file, response){
			console.log(response);
		}
	} */
if (jQuery('#upload-cover').length) {
	var myDropzoneTheFirst = new Dropzone(
        '#upload-cover', 
        {
            url: ajaxurl ,
			previewsContainer: "#upload-cover.dropzone-previews",
			uploadMultiple: true,
			parallelUploads: 100,
			maxFiles: 1,
			sending: function(file, xhr, formData){
				formData.append('action', 'upload_file');
				formData.append('multiple', false);
			},
			success: function(file, response){
				var obj = jQuery.parseJSON(response)
				jQuery('#cover-photo').val(obj.url);
				
				
			}
        }
    );
}
if (jQuery('#upload-logo').length) {
	var myDropzoneTheSecond = new Dropzone(
        '#upload-logo', 
        {
            url: ajaxurl ,
			previewsContainer: "#upload-logo.dropzone-previews",
			uploadMultiple: true,
			parallelUploads: 100,
			maxFiles: 1,
			sending: function(file, xhr, formData){
				formData.append('action', 'upload_file');
				formData.append('multiple', false);
			},
			success: function(file, response){
				var obj = jQuery.parseJSON(response)
				jQuery('#logo-photo').val(obj.url);
				//alert(response);
			}
        }
    );
}
if (jQuery('#upload-thumbnail').length) {
	
	var myDropzoneTheThird = new Dropzone(
        '#upload-thumbnail', 
        {
            url: ajaxurl ,
			previewsContainer: "#upload-thumbnail.dropzone-previews",
			uploadMultiple: true,
			parallelUploads: 100,
			maxFiles: 1,
			sending: function(file, xhr, formData){
				formData.append('action', 'upload_file');
				formData.append('multiple', false);
			},
			success: function(file, response){
				var obj = jQuery.parseJSON(response)
				jQuery('#thumbnail-photo').val(obj.url);
			}
        }
    );
}	
	
});


