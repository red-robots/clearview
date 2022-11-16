<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); ?>

<div id="primary" class="content-area-full content-default single-team has-sidebar-graphic">
	<main id="main" class="site-main has-left-line" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

      <?php  
      $photo = get_field("photo");
      $job_title = get_field("jobtitle");
      $topClass = ($photo && $job_title) ? 'half':'full';
      $contact_info = get_field('contact_info');
      $certifications = get_field('certifications');
      ?>

      <div class="page-content wrapper">
        <div class="breadcrumb">
          <a href="<?php echo get_site_url() ?>/our-team/"><i class="arrow"><span></span></i> Back to Our Team</a>
        </div>
            
        <div class="flexwrap <?php echo $topClass ?>">
          <div class="leftcol">
            <header class="entry-header">
              <h1 class="page-title"><?php the_title(); ?></h1>
              <?php if ($job_title) { ?>
              <div class="jobtitle"><?php echo $job_title ?></div> 
              <?php } ?>
            </header>
            <div class="entry-content">

              <?php if ($contact_info || $certifications) { ?>
              <div class="top-group">
                <?php if ($contact_info) { ?>
                <div class="contact-info">
                  <?php foreach ($contact_info as $c) { 
                    $siteURL = get_site_url();
                    $title = $c['title'];
                    $link = $c['link'];
                    $target = '_self';
                    $siteParts = parse_url($siteURL);
                    $host = ( isset($siteParts['host']) && $siteParts['host'] ) ? $siteParts['host'] : '';
                    if($link) {
                      $parse = parse_url($link);
                      if( isset($parse['host']) && $parse['host'] ) {
                        if (strpos($link, $host) !== false) {
                          $target = '_self';
                        } else {
                          $target = '_blank';
                        }
                      }
                    }
                  ?>
                  <div class="info">
                    <?php if ($link) { ?>
                      <?php if(filter_var($title, FILTER_VALIDATE_EMAIL)) { ?>
                        <a href="mailto:<?php echo antispambot($title,1) ?>" target="<?php echo $target ?>"><?php echo antispambot($title) ?></a>
                      <?php } else { ?>
                        <a href="<?php echo $link ?>" target="<?php echo $target ?>"><?php echo $title ?></a>
                      <?php } ?>
                    <?php } else { ?>
                    <?php echo $title ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>

                <?php if ($certifications) { ?>
                <div class="certifications">
                  <?php foreach ($certifications as $cert) { 
                    $cert_title = $cert['heading'];
                    $cert_info = $cert['info'];
                    if( $cert_title || $cert_info ) { ?>
                    <div class="cert-info">
                      <?php if ($cert_title) { ?>
                      <h5><?php echo $cert_title ?></h5>
                      <?php } ?>
                      <?php if ($cert_info) { ?>
                      <div class="cert"><?php echo $cert_info ?></div>
                      <?php } ?>
                    </div>
                    <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
              <?php } ?>

              <?php if ( get_the_content() ) { ?>
              <div class="bio"><?php the_content(); ?></div> 
              <?php } ?>
            </div>
          </div>

          <?php if ($photo) { ?>
          <div class="rightcol">
            <figure class="image">
              <img src="<?php echo $photo['url'] ?>" alt="<?php echo $photo['title'] ?>">
            </figure>
          </div>
          <?php } ?>

        </div>
      </div>

		<?php endwhile; ?>

    <?php 
      $show_logo = true;
      $global_Opt = get_field("global_form_opt",54);
      include( locate_template('parts/global-form-options.php') ); 
    ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php 
  $show_logo = true;
  include( locate_template('parts/contact-form.php') ); 
?>

<?php
get_footer();
