	</div><!-- #content -->
	
  <?php 
  $foot = get_field("footer_content","option");
  $col1_logo = ( isset($foot['footer_logo']['url']) && $foot['footer_logo']['url'] ) ? $foot['footer_logo']['url'] : '';
  $col1_text = ( isset($foot['footer_col1_text']) && $foot['footer_col1_text'] ) ? $foot['footer_col1_text'] : '';
  ?>
  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="wrapper wide">
      <div class="flexwrap">
        <?php if ($col1_logo || $col1_text) { ?>
        <div class="fcol fcol1">
          <?php if ($col1_logo) { ?>
          <div class="footlogo"><img src="<?php echo $col1_logo ?>" alt="<?php echo $foot['footer_logo']['title'] ?>" /></div>
          <?php } ?>
          <?php if ($col1_text) { ?>
            <div class="text"><?php echo $col1_text ?></div>
          <?php } ?>
        </div>
        <?php } ?>

        <?php for( $i=2; $i<=4; $i++ ) { 
          $title = ( isset($foot['footer_col'.$i.'_title']) && $foot['footer_col'.$i.'_title'] ) ? $foot['footer_col'.$i.'_title'] : '';
          $text = ( isset($foot['footer_col'.$i.'_text']) && $foot['footer_col'.$i.'_text'] ) ? $foot['footer_col'.$i.'_text'] : '';
          if($text) { ?>
          <div class="fcol links fcol<?php echo $i?>">
            <?php if ($title) { ?>
            <div class="ftitle"><?php echo $title ?></div> 
            <?php } ?>
            <div class="ftext"><?php echo $text ?></div> 
          </div> 
          <?php } ?>
        <?php } ?>

        <?php 
        $footer_logos = ( isset($foot['footer_logos']) && $foot['footer_logos'] ) ? $foot['footer_logos'] : ''; 
        $footer_col5_text = ( isset($foot['footer_col5_text']) && $foot['footer_col5_text'] ) ? $foot['footer_col5_text'] : ''; 
        if($footer_logos || $footer_col5_text) { ?>
        <div class="fcol fcol5">
          <?php if ($footer_logos) { ?>
          <div class="footer-logos">
            <div class="inner">
            <?php foreach ($footer_logos as $foot) { ?>
            <img src="<?php echo $foot['url'] ?>" alt="<?php echo $foot['title'] ?>">  
            <?php } ?>
            </div>
          </div>
          <?php } ?>

          <?php if ($footer_col5_text) { ?>
          <div class="footer-logos-text">
            <?php echo $footer_col5_text ?>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
    </div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
