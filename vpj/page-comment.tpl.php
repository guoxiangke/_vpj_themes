<?php
	/**
	 * //JQUERY18 = jQuery.noConflict();  
	 * 微博类型文章显示页面。js懒加载版本解决。
	 * //$jq 即为高版本的变量  
	 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <script type="text/javascript" src="/<?php echo drupal_get_path('module', 'sina_vp_imagetool') .'/js/jquery-1.7.1.js'?>"></script>
    <script src="/sites/all/modules/Vp/sina_vp_imagetool/js/jquery.lazyload.min.js?a" type="text/javascript"></script>
		<script type="text/javascript">			
			var $jq = jQuery.noConflict();  
			$jq(document).ready(function(){
				$jq("img.lazy").lazyload({
			    effect : "fadeIn",
			    threshold : 500
				});
			});
		</script>		
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
	<body>
		<div id="header-region" class="vp-clear-block">
			<?php include (path_to_theme() . '/vp_page-top.tpl.php');?>
		</div>
		<div class="vp-body">
		  <div class="vp-body-inner">
		    <div class="fbvp-body-min">
				<?php if ($show_messages && $messages): print $messages; endif; ?>			
				<?php print $content;?>
			</div>
	      </div>	
		</div>		
		<div id="footer" class="footer">
			<?php print $footer_message . $footer?>
		</div>
		<?php print $closure?>
	</body>
</html>