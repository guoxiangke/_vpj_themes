<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
   <!--link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css"-->
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body id='VCenter'>
	<div class="top">
	   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
	
	</div>
<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
	<div class="VCenter">
		<div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>注册</p></div>
		<?php			
			print $content;
		?>	
		<div class='vp_register_right'>
			<div class='vp_register_info'>
					<a href="javascript:void(0)" class="login_link">已有微铺街帐号，可直接登录</a> 
			<div class='vp_register_info'>
				<li class="sina_open_login_links first last">
					<?php echo l('<img src="sites/all/themes/garland_sina/images/log_btn1.jpg">','sina_open/t_login',array('html'=>'TRUE'));?>
					
				</li>

			</div>
		</div>
	</div>
</div>
<div class="hidden" id="user_login_block_reg">
	<?php echo drupal_get_form('user_login_block');?>
</div>

<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>