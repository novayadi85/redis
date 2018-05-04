/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

    var meta_image_frame;
    $('#add_galleries_action').on( 'click', '#ckd-multiple-img', function( e ) {
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
            library: { type: 'image' },
            multiple: true
        });
 
        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection') /*.first().toJSON()*/;
            
             //ar selection = custom_uploader.state().get('selection');
             var i = 0;
            media_attachment.map( function( attachment ) {
                ++i;
                console.log(attachment);
                attachment = attachment.toJSON();                
                $( "#add_galleries" ).append( '<div class="img-thumb-gallery" style="" ><img src="'+attachment.url+'" style=""/><input type="hidden" name="id_galleries[]" value="'+ attachment.id+'"><a href="javascript:void(0)" class="ckd_remove_me" style="">Remove</a></div>' );

            });
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
    $(document).on( 'click', '.ckd_remove_me', function( e ) {
    
        // Prevents the default action from occuring.
        e.preventDefault();
        $(this).parent('.img-thumb-gallery').remove();
    });
});