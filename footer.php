	</div><!-- #content -->
	
  <?php 
  $footer_logo = get_field("footer_logo","option");
  ?>
  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="wrapper wide">
      <div class="flexwrap">
        <?php if ($footer_logo) { ?>
        <div class="footer-widget foot-logo">
         <img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>" class="footlogo"> 
        </div>
        <?php } ?>

        <?php if( have_rows('footerwidgets','option') ) { ?>
          <?php while( have_rows('footerwidgets','option') ) {  the_row(); 

          ?>
          <div class="footer-widget fwidget">
            <?php if( $widget_title = get_sub_field('title') ) { ?>
              <h4 class="widgettitle"><?php echo $widget_title ?></h4>
            <?php } ?>
            <?php if( $widget_text = get_sub_field('description') ) { ?>
              <div class="widgettext"><?php echo $widget_text ?></div>
            <?php } ?>
          </div>
          <?php } ?>
      <?php } ?>
      </div>
    </div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
