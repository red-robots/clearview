<?php
/**
 * Template Name: Client Login
 */
get_header(); 
$banner = get_field('header_image');
?>
<div id="primary" class="content-area default-template">
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
        
      <?php if ( get_the_content() ) { ?>
      <section class="entry-content">
        <div class="wrapper">
          <?php the_content(); ?>  
        </div>
      </section>
      <?php } ?>

      <?php $blocks = get_field("image_and_link");?>
      <?php if ($blocks) { ?>
      <section class="styled-blocks">
        <div class="wrapper">
          <div class="flexwrap">
            <?php foreach ($blocks as $b) { 
              $linkTitle = $b['title'];
              $pagelink = $b['link'];
              $img = $b['image'];
              //$bgcolor = ($b['bgcolor']) ? ' style="background-color:'.$b['bgcolor'].'"':'#dfdfe0';
              $style  = ($img) ? ' style="background-image:url('.$img['url'].')"' : '';
              if($linkTitle && $pagelink && $img) { ?>
              <div class="block">
                <a href="<?php echo $pagelink ?>" target="_blank">
                  <span class="image">
                    <span class="bg"<?php echo $style ?>></span>
                    <img src="<?php echo THEMEURI ?>/assets/images/rectangle.png" alt="" aria-hidden="true">
                  </span>
                  <?php if ($linkTitle) { ?>
                  <span class="title"><span><b><?php echo $linkTitle ?></b></span></span>
                  <?php } ?>
                </a>
              </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </section> 
      <?php } ?>
		<?php endwhile; ?>	

    <?php //get_template_part('parts/team_blocks'); ?>
	</main>
</div>
<?php
get_footer();
