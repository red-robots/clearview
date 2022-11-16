<?php
/**
 * Template Name: Flexible Content
 */
get_header(); 
$flexible_content = get_field('flexible_content');
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

      <?php if( have_rows('flexible_content') ) { ?>
      <div class="flexible-content-section">
        
        <?php $n=1; while ( have_rows('flexible_content') ) : the_row(); ?>

          <?php if( get_row_layout() == 'two_columns' ) {  

            $text = get_sub_field('text'); 
            $image = get_sub_field('image'); 
            $image_position = get_sub_field('image_position'); 
            $position = ($image_position) ? ' image-'.$image_position : ' image-left';
            $class = ($text && $image) ? 'half':'full';
            ?>
            <?php if ($text || $image) { ?>
            <section class="two-columns-style1 <?php echo $class.$position ?>">
              <div class="wrapper">
                <div class="flexwrap">
                  <?php if ($text) { ?>
                  <div class="column text">
                    <?php echo $text ?>
                  </div>
                  <?php } ?>
                  <?php if ($image) { ?>
                  <div class="column image">
                    <figure>
                      <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
                    </figure>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </section>  
            <?php } ?>

          <?php } else if( get_row_layout() == 'columns_3' ) {  
            $heading = get_sub_field('heading'); 
            $columns = get_sub_field('columns'); 
            $bottom_text = get_sub_field('bottom_text'); 
            $column_count = ($columns) ? count($columns) : 0;
            ?>
            <section class="three-columns">
              <div class="wrapper">
                <?php if ($heading) { ?>
                <h2 class="text-center heading"><?php echo $heading ?></h2>
                <?php } ?>
                <?php if ($columns) { ?>
                <div class="columns count<?php echo $column_count?>">
                  <div class="flexwrap">
                    <?php foreach ($columns as $c) { 
                      $col_image = $c['image'];
                      $col_text = $c['text'];
                      $col_class = ($col_text && $col_image) ? 'half':'full';
                      ?>
                     <div class="block">
                      <div class="inner">
                       <?php if ($col_image) { ?>
                        <div class="col-image" style="background-image:url('<?php echo $col_image['url'] ?>')">
                          <figure>
                            <img src="<?php echo THEMEURI ?>/assets/images/rectangle-narrow.png" class="resizer" alt="" />
                          </figure>
                        </div> 
                       <?php } ?>

                       <?php if ($col_text) { ?>
                        <div class="col-text">
                          <?php echo $col_text ?>
                        </div> 
                       <?php } ?>
                       </div>
                     </div> 
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
                <?php if ($bottom_text) { ?>
                <div class="bottom-text"><?php echo $bottom_text ?></div>
                <?php } ?>
              </div>
            </section>
          
          <?php } else if( get_row_layout() == 'columns2_style2' ) { 
              $text = get_sub_field('text'); 
              $image = get_sub_field('image'); 
              $class = ($text && $image) ? 'half':'full';
              ?>
              <?php if ($text || $image) { ?>
              <section class="two-columns-style2 <?php echo $class ?>">
                <div class="wrapper">
                  <div class="flexwrap reverse">
                    <?php if ($text) { ?>
                    <div class="column text">
                      <?php echo $text ?>
                    </div>
                    <?php } ?>
                    <?php if ($image) { ?>
                    <div class="column image">
                      <figure>
                        <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>">
                      </figure>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </section>  
              <?php } ?>
          <?php } ?>

        <?php endwhile; ?>

      </div> 
      <?php } ?>
		<?php endwhile; ?>	
	</main>
</div>
<?php
get_footer();
