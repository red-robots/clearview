<?php
/**
 * Template Name: Contact
 */
get_header(); 
$banner = get_field('header_image');
?>
<div id="primary" class="content-area default-template contact-page has-sidebar-graphic">
	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
      <header class="entry-title <?php echo ($banner) ? 'has-banner':'no-banner';?>">
        <?php if ( $banner ) { ?>
        <div class="header-image" style="background-image:url('<?php echo $banner['url'] ?>')"></div>
        <?php } ?>
        <div class="title-inner">
          <div class="wrapper">
            <h1 class="page-title"><?php the_title(); ?></h1>
          </div>
        </div>
      </header>
        
      <section class="entry-content">
        <div class="wrapper">
          <div class="flexwrap twoCols">
            <div class="left-col"><?php the_content(); ?></div>

            <?php if ( $map = get_field('googlemap','option') ) { ?>
            <div class="right-col">
              <div class="map">
                <?php echo $map; ?>
                <img src="<?php echo THEMEURI ?>/assets/images/rectangle.png" alt="" aria-hidden="true">
              </div>
            </div>
            <?php } ?>
            
          </div>  
        </div>
      </section>
		<?php endwhile; ?>	

    <?php //get_template_part('parts/team_blocks'); ?>
	</main>
</div>
<?php
get_footer();
