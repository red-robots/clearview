<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri(), array(), '1.12' );

	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, '3.5.1', false);
		wp_enqueue_script('jquery');

	  wp_enqueue_script( 
			'jquery-migrate','https://code.jquery.com/jquery-migrate-1.4.1.min.js', 
			array(), '20200713', 
			false 
		);


  wp_enqueue_script( 
    'bellaworks-blocks', 
    get_template_directory_uri() . '/assets/js/plugins.min.js', 
    array(), '10092021', 
    true 
  );

  wp_enqueue_script( 
  	'vimeo-player', 
  	'https://player.vimeo.com/api/player.js', 
  	array(), '2.12.2', 
  	true 
  );

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	// wp_enqueue_script( 
 //    'swiper-scripts', 
 //    get_template_directory_uri() . '/assets/js/vendor/swiper-bundle.min.js', 
 //    array(), '20220412', 
 //    true 
 //  );

  wp_enqueue_script( 
    'fancybox','https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js', 
    array(), '4.0', 
    true 
  );

  wp_enqueue_script( 
    'bellaworks-custom', 
    get_template_directory_uri() . '/assets/js/custom.min.js?v=1.1', 
    array(), '20200713', 
    true 
  );

	wp_enqueue_script( 
		'font-awesome', 
		'https://use.fontawesome.com/8f931eabc1.js', 
		array(), '20180424', 
		true 
	);



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );


function dr_admin_footer_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('[data-name="frame_type"][data-type="radio"] .acf-radio-list li').each(function(){
    var optionVal = $(this).find('input[type="radio"]').val();
    $(this).addClass(optionVal);
  });
});
</script>
<?php }
add_action( 'admin_footer', 'dr_admin_footer_scripts' ); 

function dr_admin_head_scripts() { ?>
<style type="text/css">
[data-name="frame_type"][data-type="radio"] ul.acf-radio-list {
  margin-bottom: 0;
}
[data-name="frame_type"][data-type="radio"] ul.acf-radio-list li {
  width: 60px;
  height: 60px;
  margin-right: 15px!important;
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
}
[data-name="frame_type"][data-type="radio"] li label {
  color: transparent;
  position: relative;
  z-index: 15;
}
[data-name="frame_type"][data-type="radio"] li label input {
  position: absolute;
  top: -6px;
  left: -4px;
  margin: 0 0;
}
/*[data-name="frame_type"][data-type="radio"] li:before {
  content: "";
  display: block;
  width: 60px;
  height: 60px;
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
  position:  absolute;
  top: 0;
  left: 0;
}*/

/*.acf-field.acf-field-image.acf-field-6177a5520e7e2 .acf-label {
  display: none!important;
}*/
<?php for($i=1;$i<=5;$i++) { ?>
[data-name="frame_type"][data-type="radio"] li.frame<?php echo $i ?> {
  background-image: url('<?php echo get_images_dir('frames/frame'.$i.'.png') ?>');
}
<?php } ?>
</style>
<?php }
add_action( 'admin_head', 'dr_admin_head_scripts' ); 


