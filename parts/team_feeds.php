<?php  
  $numcol = ( isset($args['numcol']) && $args['numcol'] ) ? $args['numcol'] : '';
  $arrs = array(
    'posts_per_page'   => -1,
    'post_type'        => 'team',
    'post_status'      => 'publish'
  );
  $teams = new WP_Query($arrs);
  if ( $teams->have_posts() ) { ?>
  <section class="team-feeds">
    <div class="blocks-wrapper columns-<?php echo $numcol ?>">
      <?php while ( $teams->have_posts() ) : $teams->the_post(); 
        $placeholder = THEMEURI . 'assets/images/profile.png';
        $photo = get_field('photo');
        $jobtitle = get_field('jobtitle');
        $has_photo = ($photo) ? 'has-photo':'no-photo';
        $photoURL = '';
        if($photo) {
          $photoURL = ( isset($photo['sizes']['medium_large']) && $photo['sizes']['medium_large'] ) ? $photo['sizes']['medium_large'] : '';
        }
        ?>
        <div class="block <?php echo $has_photo ?>">
          <div class="inner">
            <div class="photo">
              <?php if ($photoURL) { ?>
              <div class="image" style="background-image:url('<?php echo $photoURL ?>')"></div>
              <?php } ?>
              <img src="<?php echo $placeholder ?>" alt="" aria-hidden="true">
            </div>
            <div class="info">
              <h4 class="name"><?php the_title(); ?></h4>
              <?php if ($jobtitle) { ?>
              <div class="jobtitle"><?php echo $jobtitle ?></div>
              <?php } ?>
              <div class="bio-link">
                <a href="<?php echo get_permalink() ?>">See bio <span>&gt;</span></a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile;  ?>
    </div>
  </section>
  <?php } ?>