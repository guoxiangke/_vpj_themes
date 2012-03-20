<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?> 
    <?php print $scripts ?>

    <script type="text/javascript" src="/<?php echo drupal_get_path('module', 'sina_vp_imagetool') .'/js/jquery-1.7.1.js'?>"></script>
    <script src="/sites/all/modules/Vp/sina_vp_imagetool/js/jquery.lazyload.min.js?a" type="text/javascript"></script>		
		<script type="text/javascript">			
			var $jq = jQuery.noConflict();  
			$jq(document).ready(function(){
				$jq("img.lazy").lazyload({
			    effect : "fadeIn",
			    threshold : 500
				});
				$('.dpright-content-top .nav-tabs li a').click(function(){
						if($(this).parent().attr('class')=='last-li' || $(this).parent().attr('class')=='active'){	
						}else{
							//实现toggleClass效果
							$(this).parent().parent().find('.active').removeClass('active');
							$(this).parent().addClass('active');
							var flag=$(this).attr('mylist');
							//实现切屏幕效果
							$('.vp_recommend_scroll').hide();
							$('.vp-rec-wrap').hide();
						//	alert('#'+flag);
							$('#'+flag).fadeIn('fast');
							$('#'+flag).children('.vp-rec-wrap:first').fadeIn('fast');
						}
					})
				//这里分离出的点击订阅全部效果
				/**
				*点击订阅，查找active的div 并且查找到内部所有订阅按钮 模拟点击
				console.log()
				*/
				$('.dpdybtn').click(function(){
					console.log($(this).parent().parent().next().find('.vp-rec-wrap:visible').find('.fasttoggle-status-user-focus-0').click());
				})
			});
		</script>
    <script type="text/javascript" src="/<?php echo drupal_get_path('module', 'sina_vp_theme') .'/plugins/bootstrap/js/bootstrap-tab.js'?>"></script>
    
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
					<div class="sfxzselectbu">5.成功注册</div>
					<div class="sfxzsltpic1"><img src="/<?php echo path_to_theme()?>/images/logo.gif" alt="" /></div>
					<div class="sfxzselectbu">6.推荐卖家</div>
					<div class="sfxzsltpic1"><img src="/<?php echo path_to_theme()?>/images/logo.gif" alt="" /></div>
					<div class="sfxzselectbu">7.推荐买家</div>
					
					<div class="sfxzselectbu2">8.进入首页</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="tjselectsf">
			    <div class="tjbody-right-content">
				    <div class="dpright-content-top">
				    	<ul class="nav nav-tabs">
							  <li class="active"><a href="javascript:void(0)" mylist="vp_recommend_focus" data-toggle="tab">关注最多</a></li>
							  <li><a href="javascript:void(0)" mylist="vp_recommend_new" data-toggle="tab">最新加入</a></li>
							  <li><a href="javascript:void(0)" mylist="vp_recommend_active" data-toggle="tab">最活跃的</a></li>
							  <li class="last-li"></li>
							</ul>
						  
							<div class="dpright-content-right">
								<input type="button" class="dpdybtn"/>
								<div class="clear"></div>
							</div>
						<div class="clear"></div>
					</div>
						
						<div class="tab-content">
					
						  <div class="tab-pane active home vp_recommend_scroll" id="vp_recommend_focus">
						  <?php	//6X3 被关注最多 订阅最多
						  		$sql='SELECT `requestee_id` uid FROM `user_relationships` where `rtid`=2  group by `requestee_id` order by count(1) desc limit 0,18';
									$results = db_query($sql);
					  			echo sina_vp_recommend($results,$account);
							?>
						  </div>
								  
							<div class="tab-pane profile vp_recommend_scroll" id="vp_recommend_new">
								<?php	//6X3
									$sql='select u.uid uid from users u  INNER JOIN users_roles users_roles ON u.uid = users_roles.uid
	 								WHERE (users_roles.rid = 3) AND (u.status <> 0) order by created desc';//最新加入
									$results = db_query($sql);
					  			echo sina_vp_recommend($results,$account);
							?>
					  	<div class="clear"></div>
					  	</div>
						  <div class="tab-pane messages vp_recommend_scroll" id="vp_recommend_active">
						  <?php	//6X3 最近更新 最活跃的
					  			$sql='select n.uid uid from node n  INNER JOIN users_roles users_roles ON n.uid = users_roles.uid
 WHERE (users_roles.rid = 3)  group by n.uid order by count(1) desc';
									$results = db_query($sql);
					  			echo sina_vp_recommend($results,$account);
							?>
							<div class="clear"></div>		
							</div>
						</div>	
				</div>
				<div class="clear"></div>		
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