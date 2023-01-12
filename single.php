<?php
/**
 * The template for displaying all pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

$top_class = (has_post_thumbnail()) ? 'half':'full';
$taxonomy = 'category';
$terms = get_the_terms(get_the_ID(),$taxonomy);
$case_study = array();
if($terms) {
  foreach($terms as $t) {
    if($t->slug=='case-studies') {
      $case_study[] = $t->term_id;
    }
  }
}
get_header(); ?>

<div id="primary" class="content-area-full content-default single-default-template">
	<main id="main" class="site-main wrapper" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if( !get_post_type()=='post' ) { ?>
				<h1 class="page-title"><span><?php the_title(); ?></span></h1>
			<?php } ?>


      <?php if (get_post_type()=='post') { ?>
      <div class="single-top-area">
        <?php if ( has_post_thumbnail() ) { ?>
        <figure>
          <?php the_post_thumbnail(); ?>
          <?php if (get_author_name()) { ?>
          <p class="author">Written by <?php echo ucwords(get_author_name()) ?> | <?php echo get_the_date('m/d/Y'); ?></p>
          <?php } else { ?>
          <p class="author">Posted on <?php echo get_the_date('m/d/Y'); ?></p>
          <?php } ?>
        </figure>
        <?php } ?>
        <div class="more-articles">
          <h4>More Articles</h4>
          <div id="moreArticlesList" data-postid="<?php echo get_the_ID(); ?>"></div>
        </div>
      </div>
      <?php } ?>
      


			<div class="entry-content">
        <?php if( get_post_type()=='post' ) { ?>
          <h1 class="page-title"><span><?php the_title(); ?></span></h1>
        <?php } ?>
				<?php the_content(); ?>

        <?php if ($case_study) { ?>
          <?php if ( $bottomText = get_field('single_post_footer_text','option') ) { ?>
          <div class="single-post-bottom-text"><?php echo $bottomText ?></div>
          <?php } ?>
        <?php } ?>
			</div>

		<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->


<?php if( get_post_type()=='post' ) { ?>
<script>
jQuery(document).ready(function($){
  var showAtMost = 6;
  var actionURL = '<?php echo get_site_url() ?>/wp-json/wp/v2/more-articles?perpage='+showAtMost+'&taxonomy=<?php echo $taxonomy?>&pid=<?php echo get_the_ID()?>';
  $.get(actionURL + '&pg=1',function(response){
    if(response) {
      var posts = response['posts'];
      var found = response['total_records'];
      if(posts.length) {
        var item = "<ul>";
        item += getArticleList(posts);
        item += "</ul>";
        if(response['total_pages'] && found>showAtMost) {
          item += "<div class='loadmore'><a href='javascript:void(0)' data-reset='' data-records='"+response['total_records']+"' data-totalpages='"+response['total_pages']+"' data-next='1'>Load More</a></div>";
        }

      }
      $('#moreArticlesList').html(item);

      moreArticles();
      $(window).on('resize orientationchange',function(){
        moreArticles()
      });
    }
  });

  function moreArticles() {
    if( $('.more-articles').length ) {
      var titleHeight = $('.more-articles h4').height() + 35;
      var moreHeight = $('.more-articles').height() - titleHeight;
      $('#moreArticlesList').css('height', moreHeight+'px');
    }
  }

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
        if( typeof response.posts!='undefined') {
          var posts = response['posts'];
          var total_pages = response['total_pages'];
          if(total_pages==next) {
            $('.loadmore').hide();
          }
          if(posts.length) {
            var item = getArticleList(posts);
          }
          //$('#moreArticlesList').html(item);
          $('#moreArticlesList ul').append(item);
          $('.more-articles').addClass('expand');
          $('#moreArticlesList ul').animate({scrollTop: $('#moreArticlesList ul').prop("scrollHeight")}, 500);
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
        if(termName=="Uncategorized" || term.slug=="case-studies" ) {
          termName = "";
        }
        item += "<li class='animated fadeIn'>";
          item += "<div class='breadcrumb'>";
          if(termName) {
            item += "<div class='author'><a href='"+term.link+"'>"+termName+"</a> | " + v.postdate + "</div>";
          } else {
            item += "<div class='author'>" + v.postdate + "</div>";
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
