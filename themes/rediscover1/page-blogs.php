<?php 
/**
 * Template Name: Blogs Template
 * Description: A Page Template that showcases Sticky Posts, Asides, and Blog Posts
 *
 */

get_header(); ?>
<div id="page-content">  
  <div id="columns-page" class="two-colums blog-paged container">
    <div class="section-web">
      <div class="main-column">
        <div class="page-title"><h2>RE DISCOVER MELBOURNE BLOG</h2></div>
        
        <ul class="blog-list">
        <?php 
        $paged = (!empty($_GET['page'])) ? $_GET['page'] : 1; 
        $args = array(
          'posts_per_page' => 10,
          'nopaging' => false, 
          'post_type' => 'post',
          'orderby' => 'date',
          'order'   => 'DESC',
          'paged' => $paged,
        );
        $query = new WP_Query( $args );
        $totalPost = $query->max_num_pages;
        if ( $query->have_posts() ) {  
          $i = 1;
          while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <li class="item">
              <div class="blog-present">
                <div class="thumb-blog">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php $thumb_id = get_post_thumbnail_id(); ?>
                    <?php $thum_src = wp_get_attachment_image_src( $thumb_id, 'blog-thumb'); ?>
                    <a href="<?=get_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $thum_src[0] ?>" class="img-responsive" alt="<?php the_title(); ?>" /></a>
                  <?php endif; ?>
                </div>
                <div class="content-blog">
                  <h3 class="blog-list-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <p><?php echo $post->post_excerpt; ?></p>
                </div>
              </div>
              <div class="blog-board">
                <div class="flat-blog-board">
                  <div class="post-date"><?php echo get_the_date(); ?></div>
                  <div class="divider"></div>
                  <div class="post-comment-count">
                    <?php $comments_count = wp_count_comments(get_the_ID()); ?>
                    <?php echo $comments_count->approved ?> comment
                  </div>
                </div>
              </div>
            </li> 
            <?php
          }
        } ?>
        </ul>        
        <div class="blog-pagination">
        <?php
          $pagination_args = array(
          'base'            => '%_%',
          'format'          => '?page=%#%',
          'total'           => $totalPost,
          'current'         => $paged,
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
            //$html .= "<nav class='custom-pagination'>";
            //$html .= "<span class='page-numbers page-num'>Page " . 2 . " of " . $this->count_business_cat_pages . "</span> ";
             echo $paginate_links;
            //$html .= "</nav>";
          }
          wp_reset_postdata();
        ?>
        </div>
      </div>    
      <div class="right-column">
        <?php echo get_sidebar('ads'); ?>
      </div>
    </div>  
    <div class="clear">&nbsp;</div>
  </div>
</div>
<?php get_footer(); ?>