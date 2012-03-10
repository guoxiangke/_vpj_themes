<?php
if ($uid = arg(2)) {//其他人访问的买家页面 UCenter/0/3
	$account = user_load($uid);
	if ($page_uid = $account -> uid) {
		//存在被访问用户
	} else {$account = $user;
	}
} else {$account = $user;
}

if (in_array('Seller', $account -> roles)) {//对于卖家
	include "page-UCenter-Seller.tpl.php";
	return;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
		<?php print $head
		?>
		<title><?php print $head_title
			?></title>
		<?php print $styles?>
		<script type="text/javascript" src="/<?php echo drupal_get_path('module', 'sina_vp_imagetool') .'/js/jquery-1.7.1.js'?>">JQUERY18 = jQuery.noConflict();</script>
		<script type="text/javascript">    var $jq = jQuery.noConflict();  //$jq 即为高版本的变量  </script>
		
		<?php print $scripts?>
		<!--[if lt IE 7]>
		<?php print phptemplate_get_ie_styles(); ?>
		<![endif]-->
		<script type="text/javascript" src="/<?php echo path_to_theme()?>/gotop_vp.js"></script>
	</head>
	<body>
		<div id="header-region" class="vp-clear-block">
			<?php
			include (path_to_theme() . '/vp_page-top.tpl.php');
			?>
		</div>
		<div class="vp-body">
			<div class="vp-body-inner">
	      <div class="mjvp-body-center">			  
					<?php if( $messages ) :
					?>
					<div class="messages status">
						<?php print $messages;?>
					</div>
					<?php endif;?>
					<div class="mjvp-body-left">
						<div class="mjvp-user-nav">
						<?php
							if(arg(0)=="UCenter" && 
								(count(arg())==1)||(count(arg())==2)){
									//UCenter
									//UCenter/0-6
								?>
								<li class="mjnav-user"><?php echo l('全部','UCenter');?></li>
								<li class="mjnav-user"><?php echo l('新品','UCenter/1');?></li>				
								<li class="mjnav-user"><?php echo l('活动','UCenter/2');?></li>
								<li class="mjnav-user"><?php echo l('爆款','UCenter/3');?></li>
								<li class="mjnav-user"><?php echo l('特卖','UCenter/4');?></li>
								<li class="mjnav-user"><?php echo l('真人秀','UCenter/6');?></li>
								<li class="mjnav-user"><?php echo l('转让潮','UCenter/5');?></li>		
								<?	
							}else{
								//UCenter/0-6/uid
								?>						
								<li class="mjnav-user"><?php echo l('全部','UCenter/0/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('新品','UCenter/1/'.$account->uid);?></li>				
								<li class="mjnav-user"><?php echo l('活动','UCenter/2/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('爆款','UCenter/3/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('特卖','UCenter/4/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('真人秀','UCenter/6/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('转让潮','UCenter/5/'.$account->uid);?></li>		
								<?
							}
						?>			
						</div>
						<div class="mjvp-contents">
						<?php print $content;	?>
						</div>
					</div>
					<div class="mjvp-body-right">
						<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		
		<div id="footer" class="footer">
			<?php print $footer_message . $footer
			?>
		</div>
		<?php print $closure
		?>
	</body>
</html>