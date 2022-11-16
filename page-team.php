<?php
/**
 * Template Name: Our Team
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
        
      <section class="entry-content"><?php the_content(); ?></section>
		<?php endwhile; ?>	

    <?php //get_template_part('parts/team_blocks'); ?>
	</main>
</div>
<?php
get_footer();
