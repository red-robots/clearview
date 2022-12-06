<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

$top_class = (has_post_thumbnail()) ? 'half':'full';

get_header(); ?>

<div id="primary" class="content-area-full content-default single-default-template">
	<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if( !get_post_type()=='post' ) { ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
			<?php } ?>


      <?php if (get_post_type()=='post') { ?>
      <div class="single-top-area">
        <?php if ( has_post_thumbnail() ) { ?>
        <figure>
          <?php the_post_thumbnail(); ?>
          <p class="author">Written by <?php the_author() ?> | <?php echo get_the_date('m/d/Y'); ?></p>
        </figure>
        <?php } ?>
        <div class="more-articles">
          <h4>More Articles</h4>
          <div id="moreArticlesList"></div>
        </div>
      </div>
      <?php } ?>
      


			<div class="entry-content">
				<?php the_content(); ?>
			</div>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->


<?php if( get_post_type()=='post' ) { ?>
<script>
jQuery(document).ready(function($){

  var actionURL = '<?php echo get_site_url() ?>/wp-json/wp/v2/more-articles?perpage=6&pg=1';
  $.get(actionURL,function(response){
    
    if(response) {
      var posts = response['posts'];
      if(posts.length) {
        var item = "<ul>";

        $(posts).each(function(k,v){
          var term = v.term;
          var termName = (term) ? term.name : '';
          var termDate = (term) ? '<?php echo get_the_date('m/d/Y') ?>' : '';
          if(termName=="Uncategorized") {
            termName = "";
          }
          item += "<li>";
            item += "<div class='breadcrumb'>";
            if(termName) {
              item += "<div class='author'>"+termName+"' | '" + termDate + "</div>";
            } else {
              item += "<div class='author'>" + termDate + "</div>";
            }
            
            item += "</div>";
            item += "<div class='itemLink'><a href='"+v.permalink+"' class='posttitle'>"+v.post_title+"</a></div>";
          item += "</li>";
        });

        
        if(response['total_pages']) {
          item += "<div class='loadmore'><a href='javascript:void(0)'>Load More</a></div>";
        }
      }

      item += "</ul>";

      $('#moreArticlesList').html(item);
    }
  });


});
</script>
<?php } ?>

<?php
get_footer();
