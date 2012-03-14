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
	</head>
	<body>
		<div id="header-region" class="vp-clear-block">
			<?php
			include (path_to_theme() . '/vp_page-top.tpl.php');
			?>
		</div>
		<div class="vp-body">
				<div class="vp-body-inner">					 
			    <div class="dpvp-body-min">
			    <?php if ($show_messages && $messages): print $messages; endif; ?>
			    <div class="dpvp-body-left">
				    <div class="gcvp-sidebar" id="VCenter-nav">
				    <?php
				    	switch (arg(1)) {
								case 'Sub_most':
									$class1 = 'gcvp-nav-active';
									break;
								case 'New':
									$class2 = 'gcvp-nav-active';
									break;
								case 'Active':
									$class3 = 'gcvp-nav-active';
									break;
								default:
									
									break;
							}
				    	
				    ?>
					  <div class="vcenter-nav <?php echo $class1?>"><?php echo l('订阅最多','VCenter/Sub_most');?></div>
						<div class="vcenter-nav <?php echo $class2?>"><?php echo l('最新加入','VCenter/New');?></div>
						<div class="vcenter-nav <?php echo $class3?>"><?php echo l('最新更新','VCenter/Active');?></div>
					</div>
				</div>
		        <div class="dpvp-body-right">
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