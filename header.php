<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.1.0/swiper-bundle.css">
<?php if ( is_singular(array('post')) ) { 
global $post;
$post_id = $post->ID;
$thumbId = get_post_thumbnail_id($post_id); 
$featImg = wp_get_attachment_image_src($thumbId,'full'); ?>
<!-- SOCIAL MEDIA META TAGS -->
<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<meta property="og:url"		content="<?php echo get_permalink(); ?>" />
<meta property="og:type"	content="article" />
<meta property="og:title"	content="<?php echo get_the_title(); ?>" />
<meta property="og:description"	content="<?php echo (get_the_excerpt()) ? strip_tags(get_the_excerpt()):''; ?>" />
<?php if ($featImg) { ?>
<meta property="og:image"	content="<?php echo $featImg[0] ?>" />
<?php } ?>
<!-- end of SOCIAL MEDIA META TAGS -->
<?php } ?>
<script>
var siteURL = '<?php echo get_site_url();?>';
var currentURL = '<?php echo get_permalink();?>';
var params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v});
</script>
<?php wp_head(); ?>
</head>
<?php 
$extraClass = '';
$headerButton = get_field('header_cta_button','option');
$hBtnLink = (isset($headerButton['url']) && $headerButton['url']) ? $headerButton['url'] : '';
$hBtnTitle = (isset($headerButton['title']) && $headerButton['title']) ? $headerButton['title'] : '';
$hBtnTarget = (isset($headerButton['target']) && $headerButton['target']) ? $headerButton['target'] : '_self';
?>
<body <?php body_class($extraClass);?>>
<div id="page" class="site cf">
	<div id="overlay"></div>
	<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrapper wide">
      <div class="flexwrap">
  			<div id="site-logo">
          <?php if( get_custom_logo() ) { ?>
            <?php the_custom_logo(); ?>
          <?php } else { ?>
            <h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
          <?php } ?>
  			</div>

        <?php if ( has_nav_menu( 'primary' ) ||  $topNavs ) { ?>
        <div id="site-navigation">

          <?php if ( has_nav_menu( 'primary' ) ) { ?>
    			<nav id="navigation" class="main-navigation animated fadeIn" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container'=>false, 'menu_id' => 'primary-menu','link_before'=>'<span>','link_after'=>'</span><i>Arrow Down</i>') ); ?>
          
            <?php if ($hBtnTitle && $hBtnLink) { ?>
            <a href="<?php echo $hBtnLink ?>" target="<?php echo $hBtnTarget ?>" class="head-cta-button"><?php echo $hBtnTitle ?></a>   
            <?php } ?>
          </nav>
          <?php } ?>

          <span id="closeMobileNav"></span>
        </div>
        <?php } ?>
        
        <span class="mobile-menu" id="menutoggle"><span class="bar"></span><i>Menu</i></span>

  		</div>
    </div>	
	</header>

	<?php get_template_part('parts/hero'); ?>

	<div id="content" class="site-content">
