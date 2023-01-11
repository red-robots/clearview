<?php
/**
 * Template Name: New & Insights
 *
 */
get_header(); ?>
<div id="primary" class="content-area news-page">
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
