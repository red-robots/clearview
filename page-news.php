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

});
</script>
<?php
get_footer();
