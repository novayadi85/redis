/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('#logo_images').on( 'click', '#meta-image-button', function( e ) {
		var upButton = this;
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
			
            // Sends the attachment URL to our custom image input field.
            $('#meta-image-id').val(media_attachment.id);
            $('#meta-image').attr("src",media_attachment.url);
            $('#meta-image').parent('p').show();
			$('#meta-image-button-remove').show();
			$(upButton).hide();
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
   $('#logo_images').on( 'click', '#meta-image-button-remove', function(e){
 
        // Prevents the default action from occuring.
        e.preventDefault();
		$('#meta-image-id').val('');		
		 $('#meta-image').parent('p').hide();
		$('#meta-image').attr("src",'');
		$('#meta-image-button').show();
		$(this).hide();
    });
	
	$('#header_image').on( 'click', '#meta-image-button-h', function(e){
		var meta_image_frame;
		var upButton = this;
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
			console.log(media_attachment);
            // Sends the attachment URL to our custom image input field.
            $('#meta-image-id-h').val(media_attachment.id);
            $('#meta-image-h').attr("src",media_attachment.url);
            $('#meta-image-h').parent('p').show();
			$('#meta-image-button-remove-h').show();
			$(upButton).hide();
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
    $('#header_image').on( 'click', '#meta-image-button-remove-h', function(e){
 
        // Prevents the default action from occuring.
        e.preventDefault();
		$('#meta-image-id-h').val('');		
		 $('#meta-image-h').parent('p').hide();
		$('#meta-image-h').attr("src",'');
		$('#meta-image-button-h').show();
		$(this).hide();
    });
});