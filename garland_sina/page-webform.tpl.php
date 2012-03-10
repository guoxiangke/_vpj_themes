<?php
 if($uid=arg(2)){//其他人访问的买家页面 UCenter/0/3
		$account=user_load($uid);
		if($page_uid=$account->uid){
			//存在被访问用户
		}else{$account=$user;}
	}else{$account=$user;}
	
	if(in_array('Seller',$account->roles)){	//对于卖家
		 include "page-UCenter-Seller.tpl.php";
			return;
	}
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
<body>
<div class="top UCenter_buyer">
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
	<a class="nav tag_dq" href="<?php echo url('UCenter/0/'.$page_uid)?>">您的建议</a></div>
	     
          <?php print $breadcrumb; ?>
          <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php //if ($title): print '<h2'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h2>'; endif; ?>
          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $help; ?>
          <div class="clear-block">
            <?php print $content ?>
          </div>
				
</div>

<div class="buy_right"> 
	<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
</div>
<div class="clear"></div>
	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>