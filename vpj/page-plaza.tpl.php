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
	    <div class="gcvp-body-min">
			  <?php if ($show_messages && $messages): print $messages; endif; ?>
		    <div class="gcvp-body-left">
			    <div class="gcvp-sidebar">
				    <div class="gcvp-nav gcvp-nav-active"><?php echo l('真人秀','plaza/Show');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Show/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Show/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Show/recently_active');?></p>
						</div>
						<div class="gcvp-nav"><?php echo l('活动','plaza/Activity');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Activity/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Activity/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Activity/recently_active');?></p>
						</div>
						<div class="gcvp-nav"><?php echo l('爆款','plaza/Special');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Special/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Special/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Special/recently_active');?></p>
						</div>
						<div class="gcvp-nav"><?php echo l('新品','plaza/News');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/News/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/News/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/News/recently_active');?></p>
						</div>
						<div class="gcvp-nav"><?php echo l('折扣','plaza/Sale');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Sale/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Sale/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Sale/recently_active');?></p>
						</div>
						<div class="gcvp-nav"><?php echo l('转让','plaza/Transfer');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Transfer/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Transfer/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Transfer/recently_active');?></p>
						</div>
					</div>
				</div>
	        <div class="gcvp-body-right">
				    <?php print $content?>
					
						</div>
				</div>
			</div>
			<div class="clear"></div>
			</div>
		</div>
		<div id="footer" class="footer">
			<?php print $footer_message . $footer ?>
		</div>
		<?php print $closure?>
	</body>
</html>