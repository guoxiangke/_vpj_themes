<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	<head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?> 
    <!--link href="/sites/all/modules/Vp/sina_vp_theme/plugins/bootstrap/css/bootstrap.css" media="all" rel="stylesheet" type="text/css"--> 
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
			});
		</script>	
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
					  			
					  			$sql='select u.uid uid from users u  INNER JOIN users_roles users_roles ON u.uid = users_roles.uid
	 			WHERE (users_roles.rid = 3) AND (u.status <> 0) order by created desc';//最新
	 			//$sql='SELECT `requestee_id` FROM `user_relationships` where `rtid`=2  group by `requestee_id` order by count(1) desc limit 0,18';
									$results = db_query($sql);
					  			$warp_begin ='<div class="vp-rec-wrap">';
									$warp_end ='<div class="clear"></div>
																<div class="dpvp-more"><a href="javascript:void(0)">换一批>></a></div>
																<div class="tjvp-xyb">下一步</div>	
															</div>';
									$count =0;
									while($row = db_fetch_array($results)){
										$account = user_load($row['uid']);		
										if($account->picture==''){$account->picture=variable_get(user_picture_default, '/sites/default/files/users/0.gif');}
										$output.='<div class="dpdianpu-content odd">
														<div class="dpdianpu-pic">'.
														l(theme('imagecache', '65x65', $account->picture, $account->name, $account->name, array('class'=>'vp-user-picture')),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')))
														.'</div>
														<div class="dpdianpu-xx">
															<p class="dpdpname">'.l($account->name,"UCenter/0/$account->uid").'</p>
															<p class="dpdpgg">'.($account->signature?$account->signature:'暂无介绍').'</p>
														</div>
														<div class="dpdianpu-dy">
															<p>'.user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE)).'</p>
															';
														 $my_follows =	user_relationships_load( array("between" => array($account->uid, $user->uid)),array("include_user_info" => TRUE));//获取当前用户与该卖家的关系
														 $follow_status=0;
															if(count($my_follows)){
																$follow_status=1; //已关注	
															}
														 $options = sina_vp_follow_toggle_options($option='focus');
										         if($account->uid<>$user->uid && !in_array('Seller',$user->roles)){		//卖家查看卖家/自己，不可进行粉丝操作。 			
															$output.='<span class="focus-action focus-status focus-action-do">';
															foreach (array_keys($options) as $key) {
														    $output.= fasttoggle2($options[$key][$follow_status], 'follow_toggle/'. $account->uid .'/'. $options[$key]['0'] , TRUE, $key .'_'. $user->uid, 'fasttoggle-status-user-'. $key .'-'. $follow_status,$account->uid);
														 	} 
															$output.='</span>';
														}					
									$output.='</div>						
													</div>';
									$count++;
									if($count%6==0){
										$output1 .= $warp_begin.$output.$warp_end;
										$output ='';
									}
								}
								while($count>18){
						  		$output_temp .='<div class="dpdianpu-content odd">
										<div class="dpdianpu-pic"><a class="Buyer-user-link" href="/?q=UCenter/0/3"><img width="65" height="65" class="vp-user-picture" title="卷毛小博士" alt="卷毛小博士" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/65x65/users/picture-3.jpg"></a></div>
										<div class="dpdianpu-xx">
											<p class="dpdpname"><a href="/?q=UCenter/0/3">卷毛小博士</a></p>
											<p class="dpdpgg">我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，我的个性签名呢，就是卖家介绍，买家签名，大于140字可以，</p>
										</div>
										<div class="dpdianpu-dy">
											<p>4</p>
												<span class="focus-action focus-status focus-action-do"><a title="" class="fasttoggle fasttoggle-status-user-focus-0" href="/?q=follow_toggle/3/focus&amp;destination=VCenter&amp;token=5a4ff73d86d13d34578358aa3cc11fdc">+订阅</a></span>
										</div>						
								</div>';
								if($count%6){
										$output_2 .= $warp_begin.$output_temp.$warp_end;
										$output ='';
									}
									$count++;
								}
								$output=$output1.$output_2;
								echo $output;
							?>
						  </div>
								  
							<div class="tab-pane profile vp_recommend_scroll" id="vp_recommend_new">...
					  	<div class="clear"></div>
					  	</div>
						  <div class="tab-pane messages vp_recommend_scroll" id="vp_recommend_active">...</div>
						</div>									
						<script>
						 	$(function () {
						    //$('.tabs a:last').tab('show')
						  })
						</script>
					   
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