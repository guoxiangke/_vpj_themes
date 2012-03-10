<?php
	/*发布页
	 **/
	{$account=$user;}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
		<link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body id="page_ur">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>
<div class="vp_content_ucenter UCenter">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
<div class="buy_left">
<div class="fl_nav">
	<?php
		if(arg(2)){			
			if(arg(1)=='1'){
				$title='Ta的关注';
			}elseif(arg(1)=='2'){
				$title='Ta的订阅';
			}else{
				$title='Ta的粉丝';
			}
		}else{
			if(arg(1)=='1'){
				$title='我的关注';
			}elseif(arg(1)=='2'){
				$title='我的订阅';
			}else{
				$title='我的粉丝';
			}
		}
		
	?>
	<a class="nav tag_dq" href="<?php echo url('UCenter/0/'.$page_uid)?>"><?php echo $title;?></a>    
</div>
<?php
	print $content;
	drupal_add_css(drupal_get_path('module', 'sina_vp') .'/css/scroll.css');
	drupal_add_js(drupal_get_path('module', 'sina_vp') .'/js/scroll.js');

?>
 		<script src="<?php echo drupal_get_path('module', 'sina_vp')?>/js/gotop.js" type="text/javascript"></script>
	  <link href="<?php echo drupal_get_path('module', 'sina_vp')?>/css/gotop.css" type="text/css" rel="stylesheet">
		<a id="go-top" href="#top">
		<span class="top-btn"><span class="sj">♦</span><span class="fk">▐</span>返回顶部</span>
		</a>
</div>

<div class="buy_right"> 
	<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
</div>

<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>