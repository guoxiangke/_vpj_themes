<?php
if ($uid) {
	drupal_goto('UCenter');
}


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
		<link rel="stylesheet" type="text/css" href="<?php echo path_to_theme()?>/style-add.css">
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
			  <div class="mjvp-body-center">
					<?php if( $messages ) :
					?>
					<div class="messages status">
						<?php print $messages;?>
					</div>
					<?php endif;?>
					<?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul>'; endif; ?>
					<?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
					<div class="clear-block">
						<?php print $content ?>
					</div>
				</div>
		  </div>  
		</div>
		
		<div id="footer" class="footer">
			<?php print $footer_message . $footer?>
		</div>
		<?php print $closure?>
	</body>
</html>