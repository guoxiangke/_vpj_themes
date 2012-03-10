<?php
	/*
	 **/ if($uid=arg(1)){//其他人访问的买家页面 UCenter/0/3
		$account=user_load($uid);
		if($page_uid=$account->uid){
			//存在被访问用户
		}else{$account=$user;}
	}else 
	{$account=$user;}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
		<?php print $head
		?>
		<title><?php print $head_title
			?></title>
		<?php print $styles
		?>
		<?php print $scripts
		?>
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