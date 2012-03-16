<?php
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
<body id='VCenter'>
	<div id="header-region" class="vp-clear-block">
	   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
	</div>
<div class="vp_content">
	<?php
	if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
	<div class="vp-body" id="user_info">
		<div class="vp-body-inner">		 
		<?php			
			print $content;
		?>
	  </div>
	</div>
<div class="hidden" id="user_login_block_reg">
	<?php //echo drupal_get_form('user_login_block');?>
</div>

<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>


<script type="text/javascript">
	$(document).ready(function(){
		$('#vp-upload-userinfo').click(function(){
			$('#edit-picture-upload').click();
		});
		
		$('#edit-picture-upload').change(function(){
			$('.picture').hide();
			$(this).fadeIn('slow');
		});
	});
</script>
</body>
</html>