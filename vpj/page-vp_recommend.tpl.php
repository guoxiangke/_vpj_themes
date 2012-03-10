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
	<body>
		<div id="header-region" class="vp-clear-block">
			<?php
			include (path_to_theme() . '/vp_page-top.tpl.php');
			
			
			?>
		</div>
		<div class="vp-body">
		 <div class="tjvp-body-inner">
		 	<?php if ($show_messages && $messages): print $messages; endif; ?>
		    <div class="tjvp-body-min">
		    <div class="tjbody-inner-head">
				<div class="sfxzselecthead">
					<div class="sfxzselectbu">1.身份确认</div>
					<div class="sfxzsltpic1"><img src="/<?php echo path_to_theme()?>/images/logo.gif" alt="" /></div>
					<div class="sfxzselectbu">2.完善信息</div>
					<div class="sfxzsltpic2"><img src="/<?php echo path_to_theme()?>/images/logo.gif" alt="" /></div>
					<div class="sfxzselectbu">3.等待确认</div>
					<div class="sfxzsltpic3"><img src="/<?php echo path_to_theme()?>/images/logo.gif" alt="" /></div>
					<div class="sfxzselectbu2">4.成功注册</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="tjselectsf">
			    <div class="tjbody-right-content">
				    <div class="dpright-content-top">
				    	<ul class="nav nav-tabs">
							  <li class="active"><a href="#home" data-toggle="tab">关注最多</a></li>
							  <li><a href="#profile" data-toggle="tab">最新加入</a></li>
							  <li><a href="#messages" data-toggle="tab">最活跃的</a></li>
							  <li><a href="#settings" data-toggle="tab">Settings</a></li>
							</ul>
						  
							<div class="dpright-content-right">
							    <input type="checkbox" class="dpfxk" />
								<p>全选</p>
								<input type="button" class="dpdybtn"/>
								<div class="clear"></div>
							</div>
						<div class="clear"></div>
					</div>
					<div class="dpright-content-inner">	
						<div class="tab-content">
						  <div class="tab-pane active" id="home">	<?php print $content;?> </div>
						  <div class="tab-pane" id="profile">...</div>
						  <div class="tab-pane" id="messages">...</div>
						  <div class="tab-pane" id="settings">...</div>
						</div>									
						<script>
						 	$(function () {
						    $('.tabs a:last').tab('show')
						  })
						</script>
					    <div class="clear"></div>
						<div class="dpvp-more">更多>></div>
					</div>
				</div>
				<div class="tjvp-xyb">下一步</div>
			</div>
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