<?php
/**
 * Template Name: About
 */
get_header(); ?>
<div id="primary" class="content-area about-content">
	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
      <header class="entry-title">
        <div class="wrapper">
          <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
      </header>
      <section class="entry-content fullwidth"><?php the_content(); ?></section>
		<?php endwhile; ?>	
	</main>
</div>
<?php
get_footer();
