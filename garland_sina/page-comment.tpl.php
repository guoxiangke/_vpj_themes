<?php
	{$account=$user;}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body>
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>
<div class="vp_content UCenter">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
<div class="buy_left">
<div class="fl_nav">
	<a class="nav" href="<?php echo url('UCenter/0/'.$page_uid)?>">全部</a>    
	<a class="nav" href="<?php echo url('UCenter/1/'.$page_uid)?>">新品</a>    
	<a class="nav" href="<?php echo url('UCenter/3/'.$page_uid)?>">爆款</a>    
	<a class="nav" href="<?php echo url('UCenter/4/'.$page_uid)?>">特卖</a>    
	<a class="nav" href="<?php echo url('UCenter/2/'.$page_uid)?>">活动</a>    
	<a class="nav" href="<?php echo url('UCenter/6/'.$page_uid)?>">真人秀</a>    
	<a class="nav" href="<?php echo url('UCenter/5/'.$page_uid)?>">转让潮</a></div>
<?php
	print $content;
?>
</div>

<div class="buy_right"> 
	<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
</div>
<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>