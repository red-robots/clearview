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
  var showAtMost = 5;
  var actionURL = '<?php echo get_site_url() ?>/wp-json/wp/v2/more-articles?perpage='+showAtMost;
  $.get(actionURL + '&pg=1',function(response){
    if(response) {
      var posts = response['posts'];
      if(posts.length) {
        var item = "<ul>";
        item += getArticleList(posts);
        item += "</ul>";
        if(response['total_pages']) {
          item += "<div class='loadmore'><a href='javascript:void(0)' data-reset='' data-records='"+response['total_records']+"' data-totalpages='"+response['total_pages']+"' data-next='1'>Load More</a></div>";
        }

      }
      $('#moreArticlesList').html(item);
    }
  });

  $(document).on('click','.loadmore a',function(){
    var target = $(this);
    var nextpage = $(this).attr('data-next');
    var reset = $(this).attr('data-reset');
    var total_pages = target.attr('data-totalpages');
    var next = parseInt(nextpage) + 1;
    if(reset) {
      next = 1;
    } 
    var params = {
      'posttype':'post',
      'perpage':showAtMost,
      'pg':next
    };
    console.log(next);
    $.ajax({
      type: "GET",
      url: actionURL,
      dataType:"json",
      data: params,
      beforeSend:function(){
        // var listHeight = $('#moreArticlesList ul').height() + 30;
        // $('#moreArticlesList ul').css('height',listHeight+'px');
      },
      success: function(response){
        target.attr('data-next',next);
        if(response) {
          var posts = response['posts'];
          var total_pages = response['total_pages'];
          if(posts.length) {
            var item = '<ul>';
            item += getArticleList(posts);
            item += '</ul>';
            if(next<total_pages) {
              item += "<div class='loadmore'><a href='javascript:void(0)' data-reset='' data-records='"+response['total_records']+"' data-totalpages='"+response['total_pages']+"' data-next='"+next+"'>Load More</a></div>";
            } else {
              // item += "<div class='loadmore'><a href='javascript:void(0)' data-reset='1' data-records='"+response['total_records']+"' data-totalpages='"+response['total_pages']+"' data-next='1'>Reset</a></div>";
            }
          }
          $('#moreArticlesList').html(item);
          //$('#moreArticlesList ul').append(item);
        }
      }
    });
        
  });

  function getArticleList(posts) {
    var item = '';
    if(posts.length) {
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
            item += "<div class='author'><a href='"+term.link+"'>"+termName+"</a> | " + termDate + "</div>";
          } else {
            item += "<div class='author'>" + termDate + "</div>";
          }
          
          item += "</div>";
          item += "<div class='itemLink'><a href='"+v.permalink+"' class='posttitle'>"+v.post_title+"</a></div>";
        item += "</li>";
      });
    }
    return item;
  }


});
</script>
<?php } ?>

<?php
get_footer();
