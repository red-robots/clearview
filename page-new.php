<?php
/**
 * Template Name: New & Insights
 *
 */
get_header(); ?>
<div id="primary" class="content-area default-template">
	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
      <header class="entry-title">
        <div class="wrapper">
          <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
      </header>
      <?php if( get_the_content() ) { ?>
      <section class="entry-content"><?php the_content(); ?></section>
      <?php } ?>
		<?php endwhile; ?>	
	

    <?php  
      $posts_per_page = 8;
      $post_type = 'post';
      $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
      $args = array(
        'posts_per_page'=> $posts_per_page,
        'post_type'   => 'post',
        'post_status' => 'publish',
        'paged'     => $paged
      );
      $blogs = new WP_Query($args);
      if ( $blogs->have_posts() ) {  $totalpost = $blogs->found_posts; ?> 
      <section class="blogs-section news-feeds clear" data-total-posts="<?php echo $totalpost ?>">
        <div class="wrapper">
          <div class="grid">
            <?php while ( $blogs->have_posts() ) : $blogs->the_post(); 
                $id = get_the_ID();
                $content = get_the_content();
                $content = ($content) ? strip_tags($content) : '';
                $excerpt = ($content) ? shortenText($content,100,' ','&hellip;') : '';
                $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
                $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
                $stylebg = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
                $term = get_the_terms($id,'category');
                $termName = (isset($term) && $term[0] ) ? $term[0]->name:'';
                $post_date = get_the_date('n/j/y');
                //$post_date = get_the_date('m/d/y');
                $termLink = ($term) ? get_term_link($term[0],'category') : '';

                ?>
                <article id="post-id-<?php echo $id ?>" class="post-item <?php echo ($featImage) ? 'has-image':'no-image' ?>">
                  <div class="inside">
                      <figure class="imagecol"<?php echo $stylebg ?>>
                          <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rectangle.png" alt="" aria-hidden="true" />
                      </figure>
                      <div class="textcol">
                        <div class="metadata">
                          <?php if ($term) { ?>
                          <span><a href="<?php echo $termLink ?>"><?php echo $termName ?></a> </span> 
                          <?php } ?>
                          <span><?php echo $post_date ?></span>
                        </div>
                        <div class="pad">
                            <h3 class="title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="text"><?php echo $excerpt ?></div>
                            <div class="button">
                              <a href="<?php echo get_permalink(); ?>" class="more">Read more</a>
                            </div>
                        </div>
                      </div>
                  </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        </div>

        <div class="wrapper" style="display:none;">
          <?php
            $total_pages = $blogs->max_num_pages;
            $totalpost = $blogs->found_posts; 

            if ($total_pages > 1){ ?>
              <div class="moreposts">
                <span class="lastposts hide">No more posts to load.</span>
                <a href="#" id="morepageBtn" data-posttype="post" data-total="<?php echo $totalpost ?>" data-pg="1">More Posts</a>
              </div>
              <div id="pagination" class="pagination clear">
                  <?php
                      $pagination = array(
                          'base' => @add_query_arg('pg','%#%'),
                          'format' => '?paged=%#%',
                          'current' => $paged,
                          'total' => $total_pages,
                          'prev_text' => __( '&laquo;', 'red_partners' ),
                          'next_text' => __( '&raquo;', 'red_partners' ),
                          'type' => 'plain'
                      );
                      echo paginate_links($pagination);
                  ?>
              </div>
              <?php
            } ?>
        </div>
        
      </section>
      <?php } ?>

  </main>
</div>
<?php
get_footer();
