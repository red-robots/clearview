<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

function shortenText2($text, $max = 50, $append = '…') {
  if (strlen($text) <= $max) return $text;
  $return = substr($text, 0, $max);
  if (strpos($text, ' ') === false) return $return . $append;
  return preg_replace('/\w+$/', '', $return) . $append;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function get_social_media() {
    $options = get_field("social_media","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['link']) && $opt['link'] ) {
                $url = $opt['link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fa fa-facebook',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fa fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'     => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
/* Options page under custom post type */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_sub_page(array(
//         'page_title'    => 'People Options',
//         'menu_title'    => 'People Options',
//         'parent_slug'   => 'edit.php?post_type=people'
//     ));
// }
// function be_acf_options_page() {
//     if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
//     $acf_option_tabs = array(
//         array( 
//             'title'      => 'Today Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Menu Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Global Options',
//             'capability' => 'manage_options',
//         )
//     );

//     foreach($acf_option_tabs as $options) {
//         acf_add_options_page($options);
//     }
// }
// add_action( 'acf/init', 'be_acf_options_page' );


function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}


/* ACF CUSTOM VALUES */
$gravityFormsSelections = array('gravityForm','global_the_form');
function acf_load_gravity_form_choices( $field ) {
    // reset choices
    $field['choices'] = array();
    $choices = getGravityFormList();
    if( $choices && is_array($choices) ) {       
        foreach( $choices as $choice ) {
            $post_id = $choice->id;
            $post_title = $choice->title;
            $field['choices'][ $post_id ] = $post_title;
        }
    }
    return $field;
}
foreach($gravityFormsSelections as $fieldname) {
  add_filter('acf/load_field/name='.$fieldname, 'acf_load_gravity_form_choices');
}

function getGravityFormList() {
    global $wpdb;
    $query = "SELECT id, title FROM ".$wpdb->prefix."gf_form WHERE is_active=1 AND is_trash=0 ORDER BY title ASC";
    $result = $wpdb->get_results($query);
    return ($result) ? $result : '';
}


function custom_excerpt_more( $excerpt ) {
    return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

//change the number for the length you want
function custom_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function get_excerpt($text,$limit=100) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]>', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

    /* This gets rid of all empty p tags, even if they contain spaces or &nbps; inside. */
    $text = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $text); 

    /* Get rid of <img> tag */
    $text = preg_replace("/<img[^>]+\>/i", "", $text); 
    $text = strip_tags($text,"<p><a>");
    $excerpt_length = $limit;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '...');
            $text = implode(' ', $words);
            $text = force_balance_tags( $text );
    }
 
    return $text;
}   


add_shortcode( 'team_list', 'team_list_shortcode_func' );
function team_list_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  //include( locate_template('parts/team_feeds.php') );
  get_template_part('parts/team_feeds',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'newsfeed', 'newsfeed_shortcode_func' );
function newsfeed_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'only_category'=>'',
    'exclude_category'=>'',
    'exclude_post'=>'',
    'show_author'=>'yes',
    'show_meta'=>'yes',
  ), $atts );
  $output = '';
  ob_start();
  include( locate_template('parts/news_feed.php') );
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'contact_info', 'contact_info_shortcode_func' );
function contact_info_shortcode_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>3
  // ), $atts );

  $info['address'] = array('icon'=>'fa fa-map-marker','val'=>get_field('address','option'));
  $info['phone'] = array('icon'=>'fa fa-phone','val'=>get_field('phone','option'));
  $info['email'] = array('icon'=>'fa fa-envelope','val'=>get_field('email','option'));
  $output = '';
  $items = '';
  foreach($info as $k=>$i) {
    if( $i['val'] ) {
      $icon = ($i['icon']) ? '<i class="'.$i['icon'].'" aria-hidden="true"></i> ':'';
      if($k=='email') {
        $items .= '<li>'.$icon.'<a href="mailto:'.antispambot($i['val'],1).'">'.antispambot($i['val']).'</a></li>';
      } 
      else if($k=='phone') {
        $items .= '<li>'.$icon.'<a href="tel:'.format_phone_number($i['val']).'">'.$i['val'].'</a></li>';
      } 
      else {
        $items .= '<li>'.$icon.$i['val'].'</li>';
      }

      
      
    }
  }
  if($items) {
    $output = '<ul class="contact-data">'.$items.'</ul>';
  }
  return $output;
}


/* Disabling Gutenberg on certain templates */

function ea_disable_editor( $id = false ) {

  $excluded_templates = array(
    'template-flexible-content.php',
    'page-clientlogin.php',
    'page-contact.php'
  );

  $excluded_ids = array(
    // get_option( 'page_on_front' )
  );

  if( empty( $id ) )
    return false;

  $id = intval( $id );
  $template = get_page_template_slug( $id );

  return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg by template
 *
 */
function ea_disable_gutenberg( $can_edit, $post_type ) {

  if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
    return $can_edit;

  if( ea_disable_editor( $_GET['post'] ) )
    $can_edit = false;

  if( get_post_type($_GET['post'])=='team' )
    $can_edit = false;

  return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

/**
 * Disable Classic Editor by template
 *
 */
// function ea_disable_classic_editor() {

//   $screen = get_current_screen();
//   if( 'page' !== $screen->id || ! isset( $_GET['post']) )
//     return;

//   if( ea_disable_editor( $_GET['post'] ) ) {
//     remove_post_type_support( 'page', 'editor' );
//   }

// }
// add_action( 'admin_head', 'ea_disable_classic_editor' );


add_shortcode( 'display_carousel', 'display_carousel_func' );
function display_carousel_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>6
  // ), $atts );
  // $numcol = ($a['numcol']) ? $a['numcol'] : 6;
  $output = '';
  ob_start();
  $icon = get_field('sm_icon');
  $link = get_field('sm_handle');
  $smTitle = (isset($link['title']) && $link['title']) ? $link['title'] : '';
  $smLink = (isset($link['url']) && $link['url']) ? $link['url'] : ''; 
  if($smLink=='#') {
    $smLink = 'javascript:void(0)';
  }

  if( $carousel = get_field('carousel') ) { ?>
  <div class="home-carousel">
    <?php if ($smTitle && $smLink) { ?>
    <div class="carousel-title">
      <a href="<?php echo $smLink ?>" target="_blank" class="social-handle-link"><?php if ($icon) { ?><img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['title'] ?>"><?php } ?><span><?php echo $smTitle ?></span></a>
    </div> 
    <?php } ?>
    <div class="owl-carousel owl-theme">  
      <?php foreach($carousel as $c) { 
        $website_url = get_field('website_url',$c['ID']);
        $pageLink = ($website_url) ? $website_url : 'javascript:void(0)';
        $target = ($website_url) ? '_blank':'_self';
        $image = ($c['sizes']['large']) ? $c['sizes']['large'] : '';
        $imageStyle = ($image) ? 'style="background-image:url('.$image.')"':'';
        if($pageLink=='#') {
          $pageLink = 'javascript:void(0)';
          $target = '_self';
        }
        ?>
        <div class="item"><a href="<?php echo $pageLink ?>" target="<?php echo $target ?>" <?php echo $imageStyle ?>><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" alt="" class="helper"></a></div>
      <?php } ?>
    </div>
  </div>
  <?php }
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'sign_ups', 'sign_ups_func' );
function sign_ups_func($atts) {
  $output = '';
  $sign_up = get_field('signup_button','option');
  ob_start();
  if ($sign_up) { 
    $title = $sign_up['title'];
    $link = $sign_up['url'];
    $target = (isset($sign_up['target']) && $sign_up['target']) ? '_blank':'_self';
    if($link && $title) { ?>
    <div class="sign-up-info">
     <a href="<?php echo $link ?>" target="<?php echo $target ?>" class="signupBtn"><?php echo $title ?></a>
    </div>
    <?php } 
  } 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'social_media', 'get_social_media_html' );
function get_social_media_html($atts) {
  $output = '';
  ob_start();
  $social_media = get_social_media();
  if ($social_media) { ?>
  <div class="social-media">
    <?php foreach ($social_media as $m) { ?>
      <a href="<?php echo $m['url'] ?>" target="_blank" aria-label="<?php echo $m['type'] ?>"><i class="<?php echo $m['icon'] ?>"></i></a>
    <?php } ?>
  </div>
  <?php } 
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}



add_shortcode( 'circular_elements', 'circular_elements_func' );
function circular_elements_func( $atts ) {
  $a = shortcode_atts( array(
    'columns'=>4
  ), $atts );
  $numcol = ($a['columns']) ? $a['columns'] : 4;
  $output = '';
  $elements = get_field('circular_elements');
  if($elements) {
    ob_start(); ?>
    <div class="circle-elements columns-<?php echo $numcol ?>">
    <?php foreach ($elements as $e) { $text = $e['text']; $percent = $e['percentage']; ?>
    <div class="card"><div class="percent"><?php if ($text) { ?><div class="text"><?php echo $text ?></div> <?php } ?><svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" data-value="<?php echo $percent ?>"> <circle r="45" cx="50" cy="50" /> <path class="meter" d="M5,50a45,45 0 1,0 90,0a45,45 0 1,0 -90,0" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="282.78302001953125" stroke-dasharray="282.78302001953125" /> <text x="50" y="50" text-anchor="middle" dominant-baseline="central" font-size="15"></text> </svg></div></div>
    <?php } ?>
    </div>
    <?php $output = ob_get_contents();
    ob_end_clean();
  }
  return $output;
}


add_shortcode( 'display_team', 'display_team_func' );
function display_team_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>6
  // ), $atts );
  // $numcol = ($a['numcol']) ? $a['numcol'] : 6;
  $output = '';
  $args = array(
    'posts_per_page'   => -1,
    'post_type'        => 'team',
    'post_status'      => 'publish'
  );
  $teams = new WP_Query($args);
  ob_start();
  if ( $teams->have_posts() ) {  ?>
  <div class="team-wrapper">
    <?php while ( $teams->have_posts() ) : $teams->the_post(); 
      $photo = get_field('photo');
      $job_title = get_field('job_title');
      $accordion = get_field('accordion');
      $has_columns = ($photo) ? 'half':'full';
    ?>
    <div class="team <?php echo $has_columns ?>">
      <?php if ($photo) { ?>
      <div class="infocol photo"><figure style="background-image:url('<?php echo $photo['url'] ?>')"><img src="<?php echo $photo['url'] ?>" alt="<?php echo $photo['title'] ?>"></figure></div>  
      <?php } ?>
      <div class="infocol details">
        <div class="titlediv">
          <h2 class="name"><?php the_title(); ?></h2>
          <?php if ($job_title) { ?><div class="jobtitle"><?php echo $job_title ?></div><?php } ?>
        </div>
        <?php if ( get_the_content() ) { ?>
        <div class="description"><?php the_content(); ?></div>
        <?php } ?>

        <?php if ($accordion) { ?>
        <div class="accordion">
          <?php foreach ($accordion as $acc) { ?>
            <?php if ($acc['heading']) { ?>
            <div class="a-panel">
              <div class="a-title"><span class="plus"></span><?php echo $acc['heading'] ?></div>
              <?php if ($acc['content']) { ?>
              <div class="a-text"><?php echo $acc['content'] ?></div> 
              <?php } ?>
            </div>
            <?php } ?> 
          <?php } ?>
        </div>
        <?php } ?>
      </div>  
    </div>
    <?php endwhile;  ?>
  </div>

  <?php } 
  $output = ob_get_contents();
  ob_end_clean();
  return  $output;
}

/* REST API 
 * URL=> https://clearview.test/wp-json/wp/v2/more-articles?perpage=10
*/
add_action( 'rest_api_init', function () {
  // register a new endpoint
  register_rest_route( 'wp/v2', '/more-articles/', array(
    'methods' => 'GET',
    'callback' => 'more_articles_func', // that calls this function
  ) );
});

function more_articles_func( WP_REST_Request $request ) {
  $perpage = ($request->get_param( 'perpage' )) ? $request->get_param( 'perpage' ) : 4;
  $post_type = ($request->get_param( 'posttype' )) ? $request->get_param( 'posttype' ) : 'post';
  $paged = ($request->get_param( 'pg' )) ? $request->get_param( 'pg' ) : 4;
  $taxonomy = ($request->get_param( 'taxonomy' )) ? $request->get_param( 'taxonomy' ) : 'category';
  $current_post_id = ($request->get_param( 'pid' )) ? $request->get_param( 'pid' ) : '';
  $args = array(
    'post__not_in' => array($current_post_id),
    'posts_per_page'=> $perpage,
    'post_type'   => $post_type,
    'post_status' => 'publish',
    'orderby'   => 'date',
    'order'     => 'DESC',
    'paged'     => $paged,
  );

  $exclude_slug = 'case-studies';
  $case_study = array();
  if($current_post_id) {
    $terms = get_the_terms($current_post_id,$taxonomy);
    if($terms) {
      foreach($terms as $t) {
        if($t->slug==$exclude_slug) {
          $case_study[] = $t->term_id;
        }
      }
    }
  }

  if($case_study) {
    $args['tax_query'] = array(
        array(
          'taxonomy' => $taxonomy,
          'field' => 'term_id',
          'terms' => $case_study,
          'operator' => 'IN',
        )
    );
  } else {
    $args['tax_query'] = array(
        array(
          'taxonomy' => $taxonomy,
          'field' => 'slug',
          'terms' => $exclude_slug,
          'operator' => 'NOT IN',
        )
    );
  }

  $respond = array();
  $entries = new WP_Query($args);

  if( $entries->have_posts() ) {
    $totalpost = $entries->found_posts;
    $total_pages = $entries->max_num_pages;

    while ( $entries->have_posts() ) { $entries->the_post(); 
      $id = get_the_ID();
      $term = get_the_terms($id,'category');
      $termID = (isset($term) && $term[0] ) ? $term[0]->term_id:'';
      $termName = (isset($term) && $term[0] ) ? $term[0]->name:'';
      $termSlug = (isset($term) && $term[0] ) ? $term[0]->slug:'';
      $termLink = ($term) ? get_term_link($term[0],'category') : '';

      $post_date = get_the_date('n/j/y',$id); /* one-digit day */
      //$post_date = get_the_date('m/d/y',$id); /* two-digit day */
      $arg['ID'] = $id;
      $arg['post_title'] = get_the_title();
      $arg['permalink'] = get_permalink($id);
      $arg['postdate'] = $post_date;
      if($term) {
        $arg['term']['term_id'] = $termID;
        $arg['term']['slug'] = $termSlug;
        $arg['term']['name'] = $termName;
        $arg['term']['link'] = $termLink;
      } else {
        $arg['term'] = null;
      }
      $list[] = $arg;
    }

    $respond['total_records'] = $totalpost;
    $respond['total_pages'] = $total_pages;
    $respond['posts'] = $list;
  }

  return $respond;
}


function mytheme_custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );




