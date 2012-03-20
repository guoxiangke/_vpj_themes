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
		<script type="text/javascript">
			$('.vp-favor-action').click(function(){
				var signo=$(this).find('a');
				$(this).parents().find('.dialogIn').fadeOut('fast');
				$(this).parents().find('.dialogIn').parent().find('.gc-pl-sanjiao').fadeOut('fast');
				var dialog_div=$(this).parent().parent().parent().next();
				dialog_div.fadeIn('fast',function(){
					signo.click();
				});
				dialog_div.addClass('dialogIn');
				dialog_div.find('.gcfudivtext').val("求点评^_^");
				//2012年3月19日 13:40:05 
				//2012年3月20日 16:50:48外部点击事件

				setTimeout(function(){
					var flag=dialog_div.hasClass('dialogIn');
					var word_flag=dialog_div.find('.gcfudivtext').val();
					var mouse_flag=dialog_div.attr('mouseIn');
					if(flag && mouse_flag=='out' && (word_flag=='求点评^_^' || word_flag=="评论已送出!!")){
						dialog_div.fadeOut('fast');
						dialog_div.removeClass('dialogIn');
					}
				},10000);
			})


		</script>
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
				    <div class="gcvp-nav" p-type="Show"><?php echo l('真人秀','plaza/Show');?></div>
						<div class="gcvp-subnav">
						  <p class="gcsubnav-color"><?php echo l('喜欢最多','plaza/Show/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Show/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Show/recently_active');?></p>
						</div>
						<div class="gcvp-nav" p-type="Activity"><?php echo l('活动','plaza/Activity');?></div>
						<div class="gcvp-subnav">
						  <p><?php echo l('喜欢最多','plaza/Activity/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Activity/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Activity/recently_active');?></p>
						</div>
						<div class="gcvp-nav" p-type="Special"><?php echo l('爆款','plaza/Special');?></div>
						<div class="gcvp-subnav">
						  <p><?php echo l('喜欢最多','plaza/Special/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Special/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Special/recently_active');?></p>
						</div>
						<div class="gcvp-nav" p-type="News"><?php echo l('新品','plaza/News');?></div>
						<div class="gcvp-subnav">
						  <p><?php echo l('喜欢最多','plaza/News/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/News/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/News/recently_active');?></p>
						</div>
						<div class="gcvp-nav" p-type="Sale"><?php echo l('折扣','plaza/Sale');?></div>
						<div class="gcvp-subnav">
						  <p><?php echo l('喜欢最多','plaza/Sale/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Sale/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Sale/recently_active');?></p>
						</div>
						<div class="gcvp-nav" p-type="Transfer"><?php echo l('转让','plaza/Transfer');?></div>
						<div class="gcvp-subnav">
						  <p><?php echo l('喜欢最多','plaza/Transfer/most_favor');?></p>
							<p><?php echo l('点评最多','plaza/Transfer/most_comments');?></p>
							<p><?php echo l('最新更新','plaza/Transfer/recently_active');?></p>
						</div>
					</div>
				</div>
        <div class="gcvp-body-right">
			    <?php print $content?>
				</div>
				<div class="clear"></div>
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