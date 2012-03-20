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
				//顶部选择
				$('#lead_').change(function(){	
					var topic=$(this).val();
					var selectBar=document.getElementById('edit-taxonomy-2');
					for(var i=0;i<selectBar.options.length;i++){
						if(selectBar.options[i].text==topic){
							selectBar.options[i].selected = true;
						}
					}
				})
				$('.fbuploadsize').click(function(){
					$('.form-file').click();
				})
				//2012年3月19日 上传缩略图更改显示位置
				/**
				*上传的图片显示（onLoad）的同时，截取src赋值到顶部图片显示区域
				2012年3月20日 p.m.
				*/
				//console.log($('.imagefield-preview img').attr('src'));
				//console.log($('.widget-edit').find('#edit-field-weibo-image-0-filefield-upload').prev().val());
				//$('form').submit(function(){return false;})
				$('.imagefield-preview img').load(function(){
					console.log('loaded');
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
			  <?php 
				if(!$term = taxonomy_get_term(arg(1))){
					drupal_set_message('链接请求错误～！','error');//微博分类不正确
					$donext=FALSE;
				}elseif($nid=arg(2)){
					if(!node_load($nid)){
			  	drupal_set_message('链接请求错误～！','error');//不存在该微博
					$donext=FALSE;}
				}
			  if ($show_messages && $messages): print $messages; endif; ?>
				<div class="fbissue-title">
					<?php
					if(!(arg(1)==5||arg(1)==6)&&arg(0)!='forward'){
						//发布真人秀和转让潮的时候不让用户选择
					?>
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
					<?php }
						else{ $z_node = node_load(arg(2));
								$taxonomys = $z_node->taxonomy;
								if($taxonomys)
								foreach($taxonomys as $key=>$obj){
									if($obj->vid==2){
										$taxonomy_name=$obj->name;
										$taxonomy_id = 		$obj->tid;	
									}
								}
							?>
					<div class="fbstitle">请确认您<?php 
						$temp = arg(1)==5?'转让':'秀';
						if(arg(0)=='forward'){
							$temp = '分享'	;
						}echo $temp;
						?>的是<span class="fbvp-username"><?php echo l("@$z_node->name","UCenter/0/$z_node->uid")?></span> <?php echo $taxonomy_name;?></div>
					<?}?>
			  </div> 
			  <?php if(arg(0)=='forward'){}else{
			  	?>
				<div class="fbuserimg"><img src="/<?php echo path_to_theme()?>/images/6.jpg" alt="" width="220" height="220" /></div>		
				<div class="fbuploadimg">
					<p>上传一张图片</p>
					<p class="fbuploadsize">+ 上传图片</p>
					<div class="clear"></div>
			  </div>
			  <?}?>
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





	</body>
</html>