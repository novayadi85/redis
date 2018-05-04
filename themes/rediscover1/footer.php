<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Cokadi
 * @since Cokadi 1.0
 */
      
?>
    <div class="testimonial-slide">
      <div class="container">
        <div class="testimonial-canvas">
          <h2 class="f-gold"><?php print __('The ideal place for business in Melbourne'); ?></h2>
          <div class="wrapper-carousel">
            <?php $carousel = new Cokslider_Library_Sliderfunction; ?> 
            <p>Find, connect, share and support Melbourne businesses like never before.</p>
            <p class="p-upsize">THINK LOCAL - SHOP LOCAL. Use our business directory to find Melbourne businesses, events and things to do in Melbourne. <a href="http://www.rediscovermelbourne.com.au" style="color:#fff">www.rediscovermelbourne.com.au</a></p>
            <?php //echo $carousel->testimonial_slider(); ?>
          </div>
        </div>  
        <div class="testimonial-map f-right">          
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.973711292972!2d144.96089131510996!3d-37.81408474183432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDQ4JzUwLjciUyAxNDTCsDU3JzQ3LjEiRQ!5e0!3m2!1sen!2sid!4v1478610175892" width="430" height="254" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
    <div class="latest-news-home">
      <div class="container">
        <h4><?php echo __('Latest Instagram Posts') ?></h4>
        <?php 
		$imgs = array();
		$images = latest_insta();
        $i = 0;
        $countImgs = count($images);
        foreach($images as $image){
          if($i++%2 == 0 ){
            $imgs[] = "<ul class='news-list-items'>";
          }
          $isLast = ($i%2 == 0) ? ' last' : '';
          $imgs[] = "<li class='list-item".$isLast."'><div class='thumb-section'><img src='". $image["imagepath"]."' alt='".$image["imagelink"]."' class='img98scale' /></div><div class='text-section'><p class='description-section'>" .$image["description"] . "</p><p class='news-date-release'>Date: ".date("Y-M-d",$image["timecreated"])."</p></div></li>";
          
          if($i%2 == 0 || $i == $countImgs){
            $imgs[] = "</ul>";
          }
        }
        echo join($imgs);?>
      </div>
    </div>
    <?php add_rating_modal(); ?>
    <?php add_membership_modal(); ?>
  </div> <!-- #wrapper -->
  <footer id="footer">
    <div class="footer-content container">
      <div class="f-part">
        <div class="rellink-footer">
          <h4>RELATED LINKS</h4>
          <?php 
            $menu_footer = array(
              'menu'            => 'Menu Footer',
              'menu_class'      => 'menu-footer',
              'fallback_cb'     => 'wp_page_menu',
              'items_wrap'      => '<ul class="rel-link nav-footer">%3$s</ul>'
            ); 
          ?>
          <?php echo wp_nav_menu($menu_footer) ?>          
        </div>
      </div>      
      <div class="f-part push-right last">
        <div class="connect-wth-us">
          <h4 class="f-white"><?php echo _('CONNECT WITH US'); ?></h4>
          <?php echo add_socmedia('bottom'); ?>
          <div class="clear">&nbsp;</div>
          <p>
            <?php echo _('Subscribe to our updated News and Offers'); ?>
          </p>
          <form action="<?php echo plugin_dir_url('').'subscriber/actions/index.php'; ?>" method="post" id="formSbscribe">
          <div class="subscribe-action"><input type="text" name="email" class="subscribe-txt" placeholder="Email*"/><button type="submit" class="btn-newsletter">Go</button></div>          
          <div class='form-loading'>&nbsp;</div>
          <div class="subscriber-msg"></div>
          </form>
        </div>
      </div>
      <div class="f-part push-right">
        <div class="contact-footer">
          <h4><?php echo _('FOR SALES ENQUIRIES'); ?></h4>
          <p>
            Email: <a href="mailto:<?php echo get_option('company_email'); ?>" class="whitelink"><?php echo get_option('company_email'); ?></a>
          </p>
        </div>
      </div>
    </div>    
  </footer>  
  <div id="address-footer">
    <div class="container">
      <?php $explode = explode("|", get_option('design_by')) ?>
      <div class="copyright"><span><?php echo get_option('site_copyright'); ?></span></div>
      <div class="designed">designed by <a href="<?php echo trim($explode[1]); ?>"><?php echo trim($explode[0]); ?></a></div>
    </div>
  </div>
</div> <!-- #page -->
<script>
  (function($) {
    $(window).scroll(function() {
      if ($(this).scrollTop() > 32){  
        $('#header').addClass("sticky");
        $('.search-box-holder').addClass("hideme");
      }
      else{
        $('#header').removeClass("sticky");
        $('.search-box-holder').removeClass("hideme");
      }
    });
    $(".subscriber-msg").hide();
    $('#formSbscribe').submit(function(event) {
      $this = this;
      $getChild = $(this).children('.subscriber-onfooter');
      $required = $($this).find('.required');
      $(".subscriber-msg").hide();
      $(".form-loading").show();
      
      var formData = new FormData($(this)[0]);
      
      $.ajax({
        type        : $($this).attr("method"), // define the type of HTTP verb we want to use (POST for our form)
        url         : $($this).attr("action"), // the url where we want to POST
        data        : formData, //$($this).serialize(), // our data object
        contentType  : false,
        cache    : false,
        processData  : false,
        dataType    : 'json', // what type of data do we expect back from the server
        encode     : true
      })
      .done(function(data) {
        $(".form-loading").hide();
        $required.each(function(){
          if($(this).val() == ''){
            $(this).addClass('redBorder');
          }else{
            $(this).removeClass('redBorder');
          }
        });          
        if(data.error){
          $(".subscriber-msg").show();
          $(".subscriber-msg").removeClass("success");
          $(".subscriber-msg").addClass("error");
          $(".subscriber-msg").html(data.message);        
        }else{
          $(".subscriber-msg").show();
          $(".subscriber-msg").addClass("success");
          $(".subscriber-msg").removeClass("error");
          $(".subscriber-msg").html(data.message);
          $($this)[0].reset();
        }
      }).fail(function( jqXHR, textStatus ) {
        $(".form-loading").hide();
        alert( "Request failed: " + textStatus );
      });
      event.preventDefault();
    });
     $('[data-toggle="tooltip"]').tooltip();
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); 
      var recipient = button.data('whatever') ;
      var modal = $(this)
      modal.find('.modal-title').text('New message to ' + recipient)
      modal.find('.modal-body input').val(recipient)
    });
    
    $('.loc-colapse').click(function(e){
      e.preventDefault();
      var getChildren = $(this).parent('li').find('.children');
      var getCurentABlock = $(this).parent('li').find('.loc-title');
      $('.loc-title').removeClass('f-bold');

      if($(getChildren).hasClass('open')){
        $(getChildren).removeClass('open');
        $(getChildren).addClass('close');
        $(this).html("<i class='fa fa-plus'> </i>");
      }else{
        $(getChildren).addClass('open');
        $(getChildren).removeClass('close');
        $(getCurentABlock).addClass('f-bold');
        $(this).html("<i class='fa fa-minus'> </i>");
      }

      if($('.term-lists-bc li .chhildren') != $(getChildren)){        
        $('.term-lists-bc li .chhildren').removeClass('open');
      }
    });

    $('.btn-share').click(function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      window.open(href,'targetWindow', 'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=450, height=500');  
              return false;
    })
    $(window).load(function() {
     
      $('#list-list').unslider({
        nav: false,
        autoplay: false,
        infinite: true,
      });
    });
  })(jQuery);
</script>

<?php wp_footer(); ?>

</body>
</html>
