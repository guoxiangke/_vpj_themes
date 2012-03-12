<?php
/* 
 * <div class="top">
 * 	<?php include(path_to_theme().'/vp_page-top.tpl.php');?>
 * </div>
 */
?>
  <div class="logo">
  	<a href="<?php echo url('UCenter');?>" title="首页"><img src="<?php echo check_url($logo)?>" width="93" height="92" /></a>
  </div>
  <div class="ad_talk"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/ad_talk.jpg" width="92" height="31" /></div>
  <div class="top_line"></div>
  	<?php if (isset($primary_links)&&!drupal_is_front_page()) : ?>
    <div class="navigation primary_links">      <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
    </div>
    	<?php 
    	if(arg(0)!='new'){
    		?>
    		<a id="go-top" href="#top">
				<span class="top-btn"><span class="sj">♦</span><span class="fk">▐</span>返回顶部</span>
				</a>
				
    	<?php
    	}
    	?>
    	
    <?php include(path_to_theme().'/vp_page-suggest-float.tpl.php');?>
    <?php endif; ?>

<?php if (isset($secondary_links)) : ?>
  <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
<?php endif;
?>

