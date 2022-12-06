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
                $termLink = ($term) ? get_term_link($term[0],'category') : '';
                $post_date = get_the_date('n/j/y');

                ?>
                <article id="post-id-<?php echo $id ?>" class="post-item animated fadeIn <?php echo ($featImage) ? 'has-image':'no-image' ?>">
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

          <?php
          $total_pages = $blogs->max_num_pages;
          if ($total_pages > 1){ ?>
            <div class="moreposts">
              <a href="javascript:void(0)" id="load-more" data-totalpages="<?php echo $total_pages ?>" data-total="<?php echo $totalpost ?>" data-pg="1" class="blue-button">Load More Articles</a>
            </div>
            <?php
          } ?>
        </div>
      </section>
      <?php } ?>
  </main>
</div>

<script>
jQuery(document).ready(function($){
  $(document).on('click','#load-more',function(e){
    e.preventDefault();
    var total_pages = $(this).attr('data-totalpages');
    var currentpage = $(this).attr('data-pg');
    var next = parseInt($(this).attr('data-pg')) + 1;
    $('.news-feeds').load('<?php echo get_permalink() ?>?pg='+next+" .news-feeds .wrapper",function(){
      $('#load-more').attr('data-pg',next);
      if(next==total_pages) {
        $('#load-more').remove();
        $('.moreposts').html('<b>No more post to load</b>');
      }
    });
  });
});
</script>
<?php
get_footer();
