<?php 
/*
 * Custom Post Types 
 * DASH ICONS = https://developer.wordpress.org/resource/dashicons/
 * Example: 'menu_icon' => 'dashicons-admin-users'
*/

add_action('init', 'js_custom_init', 1);
function js_custom_init() {
    $post_types = array(
      array(
        'post_type' => 'team',
        'menu_name' => 'Team',
        'plural'    => 'Team',
        'single'    => 'Team',
        'menu_icon' => 'dashicons-groups',
        'supports'  => array('title','editor')
      ),
      // array(
      //   'post_type' => 'wins',
      //   'menu_name' => 'Wins',
      //   'plural'    => 'Wins',
      //   'single'    => 'Win',
      //   'menu_icon' => 'dashicons-awards',
      //   'supports'  => array('title','editor')
      // ),
      // array(
      //   'post_type' => 'insights',
      //   'menu_name' => 'Insights',
      //   'plural'    => 'Insights',
      //   'single'    => 'Insight',
      //   'menu_icon' => 'dashicons-info',
      //   'supports'  => array('title','editor')
      // ),
    );
    
    if($post_types) {
        foreach ($post_types as $p) {
            $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
            $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
            $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
            $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural']; 
            $menu_icon = ( isset($p['menu_icon']) && $p['menu_icon'] ) ? $p['menu_icon'] : "dashicons-admin-post"; 
            $supports = ( isset($p['supports']) && $p['supports'] ) ? $p['supports'] : array('title','editor','custom-fields','thumbnail'); 
            $taxonomies = ( isset($p['taxonomies']) && $p['taxonomies'] ) ? $p['taxonomies'] : array(); 
            $parent_item_colon = ( isset($p['parent_item_colon']) && $p['parent_item_colon'] ) ? $p['parent_item_colon'] : ""; 
            $menu_position = ( isset($p['menu_position']) && $p['menu_position'] ) ? $p['menu_position'] : 20; 
            
            if($p_type) {
                
                $labels = array(
                    'name' => _x($plural_name, 'post type general name'),
                    'singular_name' => _x($single_name, 'post type singular name'),
                    'add_new' => _x('Add New', $single_name),
                    'add_new_item' => __('Add New ' . $single_name),
                    'edit_item' => __('Edit ' . $single_name),
                    'new_item' => __('New ' . $single_name),
                    'view_item' => __('View ' . $single_name),
                    'search_items' => __('Search ' . $plural_name),
                    'not_found' =>  __('No ' . $plural_name . ' found'),
                    'not_found_in_trash' => __('No ' . $plural_name . ' found in Trash'), 
                    'parent_item_colon' => $parent_item_colon,
                    'menu_name' => $menu_name
                );
            
            
                $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true, 
                    'show_in_menu' => true, 
                    'show_in_rest' => true,
                    'query_var' => true,
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'has_archive' => false, 
                    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
                    'menu_position' => $menu_position,
                    'menu_icon'=> $menu_icon,
                    'supports' => $supports
                ); 
                
                register_post_type($p_type,$args); // name used in query
                
            }
            
        }
    }
}



/* ##########################################################
 * Add new taxonomy, make it hierarchical (like categories)
 * Custom Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 ); 
function build_taxonomies() {
  $post_types  = array();
  // $post_types = array(
  //   array(
  //     'post_type' => array('team','careers'),
  //     'menu_name' => 'Divisions Taxonomy',
  //     'plural'    => 'Divisions',
  //     'single'    => 'Division',
  //     'taxonomy'  => 'divisions'
  //   ),
  // );


  if($post_types) {
    foreach($post_types as $p) {
      $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
      $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
      $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
      $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural'];
      $taxonomy = ( isset($p['taxonomy']) && $p['taxonomy'] ) ? $p['taxonomy'] : "";
      $rewrite = ( isset($p['rewrite']) && $p['rewrite'] ) ? $p['rewrite'] : $taxonomy;
      $query_var = ( isset($p['query_var']) && $p['query_var'] ) ? $p['query_var'] : true;
      $show_admin_column = ( isset($p['show_admin_column']) ) ? $p['show_admin_column'] : true;

      $labels = array(
        'name' => _x( $menu_name, 'taxonomy general name' ),
        'singular_name' => _x( $single_name, 'taxonomy singular name' ),
        'search_items' =>  __( 'Search ' . $plural_name ),
        'popular_items' => __( 'Popular ' . $plural_name ),
        'all_items' => __( 'All ' . $plural_name ),
        'parent_item' => __( 'Parent ' .  $single_name),
        'parent_item_colon' => __( 'Parent ' . $single_name . ':' ),
        'edit_item' => __( 'Edit ' . $single_name ),
        'update_item' => __( 'Update ' . $single_name ),
        'add_new_item' => __( 'Add New ' . $single_name ),
        'new_item_name' => __( 'New ' . $single_name ),
      );

      register_taxonomy($taxonomy, $p_type, array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_admin_column' => $show_admin_column,
        'query_var' => $query_var,
        'show_ui' => true,
        'show_in_rest' => true,
        'public' => true,
        '_builtin' => true,
        'rewrite' => array( 'slug' => $rewrite ),
      ));

    }
  }

}


// Add the custom columns to the position post type:
add_filter( 'manage_posts_columns', 'set_custom_cpt_columns' );
function set_custom_cpt_columns($columns) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='project') {
      unset($columns['date']);
      $columns['title'] = __( 'Name', 'bellaworks' );
      $columns['project_image'] = __( 'Image', 'bellaworks' );
      $columns['date'] = __( 'Date', 'bellaworks' );
    }

    else if($post_type=='team') {
      unset($columns['date']);
      $columns['title'] = __( 'Name', 'bellaworks' );
      $columns['photo'] = __( 'Photo', 'bellaworks' );
      $columns['date'] = __( 'Date', 'bellaworks' );
    }
    
    return $columns;
}

//Add the data to the custom columns for the book post type:
add_action( 'manage_posts_custom_column' , 'custom_post_column', 10, 2 );
function custom_post_column( $column, $post_id ) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='project') {
        switch ( $column ) {

            case 'project_image' :
                $img = get_field('main_photo',$post_id);
                $img_src = ($img) ? $img['sizes']['medium'] : '';
                $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;border:1px solid #CCC;overflow:hidden;">';
                if($img_src) {
                   $the_photo .= '<span style="display:block;width:100%;height:100%;background:url('.$img_src.') top center no-repeat;background-size:cover;transform:scale(1.2)"></span>';
                } else {
                    $the_photo .= '<i class="dashicons dashicons-format-image" style="font-size:25px;position:relative;top:13px;left: -3px;opacity:0.3;"></i>';
                }
                $the_photo .= '</span>';
                echo $the_photo;
                break;
        }
    }

    else if($post_type=='team') {
        switch ( $column ) {

            case 'photo' :
                $img = get_field('photo',$post_id);
                $img_src = ($img) ? $img['sizes']['medium'] : '';
                $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;border:1px solid #CCC;overflow:hidden;">';
                if($img_src) {
                   $the_photo .= '<span style="display:block;width:100%;height:100%;background:url('.$img_src.') top center no-repeat;background-size:cover;transform:scale(1.2)"></span>';
                } else {
                    $the_photo .= '<i class="dashicons dashicons-admin-users" style="font-size:25px;position:relative;top:13px;left: -3px;opacity:0.3;"></i>';
                }
                $the_photo .= '</span>';
                echo $the_photo;
                break;
        }
    }
    
}



//* Show the taxonomy ID
add_filter( "manage_edit-category_columns",          'my_add_col' );
add_filter( "manage_edit-category_sortable_columns", 'my_add_col' );
add_filter( "manage_category_custom_column",         'my_tax_id', 10, 3 );


function my_add_col( $new_columns ) {
    $new_columns = array(
      'cb' => '<input type="checkbox" />',
      'name'   => __('Name'),
      'slug'   => __('Slug'),
      'tax_id' => __('ID'),
      'posts'  => __('Posts')
    );

    return $new_columns;
}
function my_tax_id( $value, $name, $id ) {    
    return 'tax_id' === $name ? $id : $value;
}



