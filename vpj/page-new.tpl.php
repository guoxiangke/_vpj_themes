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
		<style type="text/css">
			.hide{
				display:none;
			}

		</style>
		<script type="text/javascript">
			$().ready(function(){
				
				$('#lead_').change(function(){	
					var topic=$(this).val();
					var selectBar=document.getElementById('edit-taxonomy-2');
					for(var i=0;i<selectBar.options.length;i++){
						if(selectBar.options[i].text==topic){
							selectBar.options[i].selected = true;
						}
					}
				})

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
		  <div class="fbvp-body-min">
			  <?php if ($show_messages && $messages): print $messages; endif; ?>
				<div class="fbissue-title">
					<div class="fbbtitle">
					<select id="lead_">

						<?php
						if(in_array('Seller', $user->roles)){
						?>
						<option value="-新品">新品</option>
						<option value="-活动">活动</option>
						<option value="-爆款">爆款</option>
						<option value="-特卖">特卖</option>
						<?php
						}elseif(in_array('Buyer', $user->roles)){
						?>
						<option value="-转让">转让</option>
						<option value="-真人秀">真人秀</option>
						<?}?>
					</select>
					
					</div>
					<div class="fbstitle">请你确认上传的图片是<span class="fbvp-username">@七格格</span> 针织袖</div>
			  </div> 
				<div class="fbuserimg"><img src="/<?php echo path_to_theme()?>/images/6.jpg" alt="" width="220" height="220" /></div>		
				<div class="fbuploadimg">
					<p>上传一张图片</p>
					<p class="fbuploadsize">+ 上传图片</p>
					<div class="clear"></div>
			  </div>
				<?php print $content ?>
				<div style="margin-top:32px;"></div>
			</div>
		</div>   
		</div>
		
		<div id="footer" class="footer">
			<?php print $footer_message . $footer
			?>
		</div>
		<?php print $closure
		?>

<script type="text/javascript">
	$().ready(function(){
			$('.fbuploadsize').click(function(){
				console.log(123);
				$('.form-file').click();
			})
	})
</script>
	</body>
</html>