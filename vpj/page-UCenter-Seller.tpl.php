<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
	  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php 
    //jquery_ui_add(array('ui.draggable', 'ui.droppable', 'ui.sortable'));
    print $scripts ?>
    <script type="text/javascript" src="/<?php echo drupal_get_path('module', 'sina_vp_imagetool') .'/js/jquery-1.7.1.js'?>"></script>
    <script src="/sites/all/modules/Vp/sina_vp_imagetool/js/jquery.lazyload.min.js?a" type="text/javascript"></script>		
		<script type="text/javascript">			
			var $jq = jQuery.noConflict();  
			$jq(document).ready(function(){
				$jq("img.lazy").lazyload({
			    effect : "fadeIn",
			    threshold : 500
				});
				//alert($('.gcfudiv').length);
				$('.gcfudiv').css('position','absolute');
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
			<div class="vp-body-inner">
	      <div class="mjvp-body-center">			  
					<?php if( $messages ) :
					?>
					<div class="messages status">
						<?php print $messages;?>
					</div>
					<?php endif;?>
					<div class="sellvp-body-min">
			  <div class="sellbody-left">
				  <div class="sellbody-ltop">
					  <div class="selluser-pic">
					  	<?php 
					  	//echo l(theme_image($account->picture, $account->name, $account->name, array('class'=>'Seller-logo'), $getsize = false),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-picture-link')));
					  	if(!$account->picture)
								$account->picture = variable_get(user_picture_default, 'sites/default/files/users/0.gif');
								if(arg(0)=='UCenter') 
									echo l(theme('imagecache', 'w150', $account->picture, '', '编辑个人资料', array('class'=>'vp-user-picture')),"userinfo_edit/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
								else echo l(theme('imagecache', 'w150', $account->picture, '', $account->name, array('class'=>'vp-user-picture')),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
							?>
					  </div>
						<div class="selluser-xx">
						  <div class="sellxxfb">
							  <div class="selluserna">
									<div class="sellusername">
										<?php 
										profile_load_profile(&$account);
										echo l($account->name,"UCenter/0/$account->uid");
										?>
									</div>									
									<div class="selluseradrs"><?php echo $location = $account->profile_location;?></div>
							  </div>
								<div class="sellfbnbt">
									<?php echo l('发布','new/1');?>
								</div>
								<div class="clear"></div>
							</div>
							<div class="sellxxnr">店铺介绍：
								<?php echo $account->signature?truncate_utf8($account->signature, 140, $wordsafe = FALSE, $dots = true):'您的个性签名/店铺简介显示在这里！';
								if($user->uid==$account->uid)echo l('点击设置',"user/$account->uid/edit", array('attributes' => array('class' => 'Seller-signature')));?>
	    			</div>							
						</div>
						<div class="clear"></div>
					</div>
					<div class="sellbody-bottom">
					  <div class="sellhuopao">
						  <div class="sellhuo huopaoleft">
							  <div class="sellhuo-title">
								  <p>活动</p>
									<p class="sellmore">
										<?php echo l('更多>>','plaza/Activity/all/'.$account->uid)?>
									</p>
								</div>
								<?php
						  	  $sql='SELECT node.nid AS nid, node.created AS node_created FROM node node 
									LEFT JOIN term_node term_node ON node.vid = term_node.vid 
									LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
									WHERE (node.status = 1) AND (node.uid = %d) 
									AND (node.type in ("weibo")) AND ((term_data.name) = ("活动")) 
									ORDER BY node_created DESC LIMIT 0 , 10';//从10条中取带图的活动1条
						  	  $results = db_query($sql,$account->uid);
									while($row = db_fetch_array($results)){
							      $activity_nids [] = $row['nid'];
										$rows = TRUE;
							    }
									if($activity_nids){//判断图片del  分享无图片，怎么办？
										foreach ($activity_nids as $activity_nid) {
											$activity_node = node_load($activity_nid);
											if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'])break;
										}			
										$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
										$share_counts = db_result(db_query($share_sql));
									
						  	?>
								<div class="sellhuo-xx">
								  <div class="sellhuo-pic">
								  	<?php 
								  	imagecache_generate_image('100x100',  $weibo_image_filepath);
										echo l(theme('imagecache', '100x100', $weibo_image_filepath, '', '', array('class'=>'Seller-activity-image')),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Sa-image-link')));
										?>
									</div>
									<div class="sellhuonr">
									  <div class="sellhuobody">
									  	<?php echo l($activity_node->title,"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-content'))); ?>
										</div>
										<div class="sellhuo-zz">
											<div class="vp-favor-action">
												<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
												<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
											</div>
											<?php echo l("点评$activity_node->comment_count","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
											<?php 
						          	$taxonomys = $activity_node->taxonomy;
												if(is_array($taxonomys))
												foreach($taxonomys as $key=>$obj){
													if($obj->vid==2){//v2 == 微博类型
														$taxonomy_name=$obj->name;
														$taxonomy_id = 		$obj->tid;	
													}
												}
												echo l("分享$share_counts","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
											?>
										</div>
										<!--BEGIN COMMENTS -->
										<div class="gcfudiv">
		             			<div class="gc-pl-sanjiao"></div>
			             		<div class="gc-pl-bj">
												<div class="gcfudiv-top">
													<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
													<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
													<input type="button" class="gcfudivbtn" value="点评">
													<div class="hidden">
														<div class="box">
													  <h2>点评</h2>
													  <div class="content">FORM BIAODAN
														</div>
														</div>
													</div>
													<div class="clear"></div>
												</div>
											 	<div class="gcfudiv-bottom">
														<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
														<div class="clear"></div>
			             			</div>
		             		</div>
	             		</div>
										<!--END COMMENTS-->
									</div>
									<div class="clear"></div>
								</div>
								<?}else{echo'暂无内容';}?>
							</div>
							<!--left-->
									
							<div class="sellhuo huopaoright">
							  <div class="sellhuo-title">
								  <p>爆款</p>
									<p class="sellmore">
										<?php echo l('更多>>','plaza/Activity/all/'.$account->uid)?>
									</p>
								</div>
								<?php
									$activity_nids=array();
									$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node 
									LEFT JOIN term_node term_node ON node.vid = term_node.vid 
									LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
									WHERE (node.status = 1) AND (node.uid = %d) 
									AND (node.type in ("weibo")) AND ((term_data.name) = ("爆款")) 
									ORDER BY node_created DESC LIMIT 0 , 10';//从10条中取带图的活动1条
						  	  $results = db_query($sql,$account->uid);
									while($row = db_fetch_array($results)){
							      $activity_nids [] = $row['nid'];
										$rows = TRUE;
							    }
									if($activity_nids){//判断图片del  分享无图片，怎么办？
										foreach ($activity_nids as $activity_nid) {
											$activity_node = node_load($activity_nid);
											if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'])break;
										}			
										$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
										$share_counts = db_result(db_query($share_sql));
									
						  	?>
								<div class="sellhuo-xx">
								  <div class="sellhuo-pic">
								  	<?php 
								  	imagecache_generate_image('100x100',  $weibo_image_filepath);
										echo l(theme('imagecache', '100x100', $weibo_image_filepath, '', '', array('class'=>'Seller-activity-image')),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Sa-image-link')));
										?>
								  </div>
									<div class="sellhuonr">
									  <div class="sellhuobody">
									  	<?php echo l($activity_node->title,"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-content'))); ?>
										</div>
										<div class="sellhuo-zz">
											<div class="vp-favor-action">
												<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
												<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
											</div>
											<?php echo l("点评$activity_node->comment_count","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
											<?php 
						          	$taxonomys = $activity_node->taxonomy;
												if(is_array($taxonomys))
												foreach($taxonomys as $key=>$obj){
													if($obj->vid==2){//v2 == 微博类型
														$taxonomy_name=$obj->name;
														$taxonomy_id = 		$obj->tid;	
													}
												}
												echo l("分享$share_counts","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
											?>
										</div>
										<!--BEGIN COMMENTS -->
										<div class="gcfudiv">
		             			<div class="gc-pl-sanjiao"></div>
			             		<div class="gc-pl-bj">
												<div class="gcfudiv-top">
													<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
													<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
													<input type="button" class="gcfudivbtn" value="点评">
													<div class="hidden">
														<div class="box">
													  <h2>点评</h2>
													  <div class="content">FORM BIAODAN
														</div>
														</div>
													</div>
													<div class="clear"></div>
												</div>
											 	<div class="gcfudiv-bottom">
														<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
														<div class="clear"></div>
			             			</div>
		             		</div>
	             		</div>
										<!--END COMMENTS-->
									</div>
									<div class="clear"></div>
								</div>
								<?}else{echo'暂无内容';}?>
							</div>
									<!--right-->
							<div class="clear"></div>
						</div>
						<div class="sell-ztxz">
							<div class="sell-zrx">
								<div class="sellhuo-title">
										<p>真人秀</p>
										<p class="sellmore">
											<?php echo l('更多>>','plaza/Show/all/'.$account->uid)?>
										</p>
								</div>
								<div class="sell-zrxbody">
									 <?php //10个中取4个带图片的。 && zid-uid=user
						      	//该卖家的粉丝 发的真人秀
							  		$sql="SELECT DISTINCT  sina.nid
														FROM  `sina_vp_weibo2node` sina
														WHERE sina.zid
														IN (
														SELECT n.nid
														FROM node n
														WHERE n.nid
														IN (
														SELECT sina.zid
														FROM  `sina_vp_weibo2node` sina
														WHERE sina.`sina_vp_type` =6
														ORDER BY  `created_at` DESC
														)
														AND n.uid =%d
														)
														AND sina.`sina_vp_type` =6
														ORDER BY  sina.`created_at` DESC
														LIMIT 0 , 10";
							  	  $results = db_query($sql,$account->uid);
										$news_nids=array();
										while($row = db_fetch_array($results)){
								      $news_nids [] = $row['nid'];
								    }
										$count=0;
										foreach ($news_nids as $activity_nid) {
											if($count==3)break;
											$activity_node = node_load($activity_nid);
											if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
												//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
												//$share_counts = db_result(db_query($share_sql));
												$count++;
							
				?>
									<div class="sell-zrx-xx <?php if($count==3)echo 'rightlast'?>">
										<div class="sell-zrx-pic">
											<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
										</div>
										<div class="sell-zrx-zz">
											<div class="sellzrx-love">
												<div class="vp-favor-action">
													<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
													<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
												</div>
											</div>
											<div class="sellzrx-diping">
											<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
											</div>
										</div>
										
										<!--BEGIN COMMENTS -->
										<div class="gcfudiv">
		             			<div class="gc-pl-sanjiao"></div>
			             		<div class="gc-pl-bj">
												<div class="gcfudiv-top">
													<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
													<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
													<input type="button" class="gcfudivbtn" value="点评">
													<div class="hidden">
														<div class="box">
													  <h2>点评</h2>
													  <div class="content">FORM BIAODAN
														</div>
														</div>
													</div>
													<div class="clear"></div>
												</div>
											 	<div class="gcfudiv-bottom">
														<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
														<div class="clear"></div>
			             			</div>
		             		</div>
	             		</div>
										<!--END COMMENTS-->
									</div>
									<?}} if($count==0){echo '还没有秀呢!';}?>
									<div class="clear"></div>
								</div>
							</div>
							<div class="sell-zrx sellzrx-r">
								<div class="sellhuo-title">
										<p>转让潮</p>
										<p class="sellmore">
										<?php echo l('更多>>','plaza/Transfer/all/'.$account->uid)?>
										</p>
								</div>
								<div class="sell-zrxbody">
									
								<?php 
					  	  	$sql="SELECT DISTINCT sina.nid
												FROM  `sina_vp_weibo2node` sina
												WHERE sina.zid
												IN (
												SELECT n.nid
												FROM node n
												WHERE n.nid
												IN (
												SELECT sina.zid
												FROM  `sina_vp_weibo2node` sina
												WHERE sina.`sina_vp_type` =5
												ORDER BY  `created_at` DESC
												)
												AND n.uid =%d
												)
												AND sina.`sina_vp_type` =5
												ORDER BY sina.`created_at` DESC
												LIMIT 0 , 10";
								$results = db_query($sql,$account->uid);
								$news_nids=array();
								while($row = db_fetch_array($results)){
						      $news_nids [] = $row['nid'];
						    }
								$count=0;
								if($news_nids)
								foreach ($news_nids as $activity_nid) {
										if($count==3)break;
										$activity_node = node_load($activity_nid);
										if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
											//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
											//$share_counts = db_result(db_query($share_sql));
											$count++;
								?>
									<div class="sell-zrx-xx <?php if($count==3)echo 'rightlast'?>">
										<div class="sell-zrx-pic">
											<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
										</div>
										<div class="sell-zrx-zz">
											<div class="sellzrx-love">
												<div class="vp-favor-action">
													<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
													<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
												</div>
											</div>
											<div class="sellzrx-diping">
											<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
											</div>
										</div>
										
										<!--BEGIN COMMENTS -->
										<div class="gcfudiv">
		             			<div class="gc-pl-sanjiao"></div>
			             		<div class="gc-pl-bj">
												<div class="gcfudiv-top">
													<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
													<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
													<input type="button" class="gcfudivbtn" value="点评">
													<div class="hidden">
														<div class="box">
													  <h2>点评</h2>
													  <div class="content">FORM BIAODAN
														</div>
														</div>
													</div>
													<div class="clear"></div>
												</div>
											 	<div class="gcfudiv-bottom">
														<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
														<div class="clear"></div>
			             			</div>
		             		</div>
	             		</div>
										<!--END COMMENTS-->
									</div>
									<?}} if($count==0){echo '还没有转让潮!';}?>
									<div class="clear"></div>
								</div>
							</div>
							<div class="sell-zrx">
								<div class="sellhuo-title">
										<p>新品</p>
										<p class="sellmore">
										<?php echo l('更多>>','plaza/New/all/'.$account->uid)?>
										</p>
								</div>
								<div class="sell-zrxbody">
									<?php
			  		  	  $sql='SELECT node.nid AS nid, node.created AS node_created FROM node node 
												LEFT JOIN term_node term_node ON node.vid = term_node.vid 
												LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
												WHERE (node.uid = %d)  AND  (node.status = 1)
												AND (node.type in ("weibo")) AND ((term_data.name) = ("新品")) 
												ORDER BY node_created DESC LIMIT 0 , 3';//活动3条
						  	  $results = db_query($sql,$account->uid);
									while($row = db_fetch_array($results)){
							      $news_nids [] = $row['nid'];
							    }
									$count=0;
									if($news_nids){
									foreach ($news_nids as $activity_nid) {
											if($count==3)break;
											$activity_node = node_load($activity_nid);
											if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
												//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
												//$share_counts = db_result(db_query($share_sql));
												$count++;
												?>
												<div class="sell-zrx-xx <?php if($count==3)echo 'rightlast'?>">
													<div class="sell-zrx-pic">
														<?php 
														imagecache_generate_image('100x100',  $weibo_image_filepath);
														echo l(theme('imagecache', '100x100', $weibo_image_filepath, '', '', array('class'=>'Seller-activity-image')),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Sa-image-link')));
														//echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
													</div>
													<div class="sell-zrx-zz">
														<div class="sellzrx-love">
															<div class="vp-favor-action">
															<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
															<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
															</div>
														</div>
														<div class="sellzrx-diping">
														<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
														</div>
													</div>
													
														<!--BEGIN COMMENTS -->
														<div class="gcfudiv">
						             			<div class="gc-pl-sanjiao"></div>
							             		<div class="gc-pl-bj">
																<div class="gcfudiv-top">
																	<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
																	<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
																	<input type="button" class="gcfudivbtn" value="点评">
																	<div class="hidden">
																		<div class="box">
																	  <h2>点评</h2>
																	  <div class="content">FORM BIAODAN
																		</div>
																		</div>
																	</div>
																	<div class="clear"></div>
																</div>
															 	<div class="gcfudiv-bottom">
																		<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
																		<div class="clear"></div>
							             			</div>
						             		</div>
					             		</div>
														<!--END COMMENTS-->
												</div>
												<?php
											}
									}}else{
					      	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
					      }
					  		?>
									<div class="clear"></div>
								</div>
							</div>
							<div class="sell-zrx sellzrx-r">
								<div class="sellhuo-title">
										<p>特卖</p>
										<p class="sellmore">
										<?php echo l('更多>>','plaza/Sale/all/'.$account->uid)?>
										</p>
								</div>
								<div class="sell-zrxbody">
									<?php
									unset($news_nids);
			  		  	  $sql='SELECT node.nid AS nid, node.created AS node_created FROM node node 
												LEFT JOIN term_node term_node ON node.vid = term_node.vid 
												LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
												WHERE (node.uid = %d)  AND  (node.status = 1)
												AND (node.type in ("weibo")) AND ((term_data.name) = ("特卖")) 
												ORDER BY node_created DESC LIMIT 0 , 3';//活动3条
						  	  $results = db_query($sql,$account->uid);
									while($row = db_fetch_array($results)){
							      $news_nids [] = $row['nid'];
							    }
									$count=0;
									if($news_nids){
									foreach ($news_nids as $activity_nid) {
											if($count==3)break;
											$activity_node = node_load($activity_nid);
											if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
												//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
												//$share_counts = db_result(db_query($share_sql));
												$count++;
												?>
												<div class="sell-zrx-xx <?php if($count==3)echo 'rightlast'?>">
													<div class="sell-zrx-pic">
														<?php 
														imagecache_generate_image('100x100',  $weibo_image_filepath);
														echo l(theme('imagecache', '100x100', $weibo_image_filepath, '', '', array('class'=>'Seller-activity-image')),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Sa-image-link')));
														//echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
													</div>
													<div class="sell-zrx-zz">
														<div class="sellzrx-love">
															<div class="vp-favor-action">
															<img src="/<?php echo path_to_theme()?>/images/xin.gif" height="15" width="15">
															<?echo flag_create_link('bookmarks', $activity_node->nid);	?>
															</div>
														</div>
														<div class="sellzrx-diping">
														<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>
														</div>
													</div>
													
													<!--BEGIN COMMENTS -->
													<div class="gcfudiv">
					             			<div class="gc-pl-sanjiao"></div>
						             		<div class="gc-pl-bj">
															<div class="gcfudiv-top">
																<textarea value="求点评^_^" name="textarea" class="gcfudivtext" cols="10" rows="2">求点评^_^</textarea>
																<a style="text-decoration:none; font-color:black;position:absolute; margin-left:-10px;" class="close_box" href="javascript:void(0)">x</a>
																<input type="button" class="gcfudivbtn" value="点评">
																<div class="hidden">
																	<div class="box">
																  <h2>点评</h2>
																  <div class="content">FORM BIAODAN
																	</div>
																	</div>
																</div>
																<div class="clear"></div>
															</div>
														 	<div class="gcfudiv-bottom">
																	<img width="35" height="35" class="hideMe" title="" alt="" src="http://dev.weipujie.com/?q=sites/default/files/imagecache/35x35/imagecache/35x35/users/picture-51.jpg">	<p><span class="gcvp-name">威海小K：</span>asdfadfadfadf</p>
																	<div class="clear"></div>
						             			</div>
					             		</div>
				             		</div>
													<!--END COMMENTS-->
												</div>
												<?php
											}
									}}else{
					      	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
					      }
					  		?>
									<div class="clear"></div>
								</div>
							</div>
						<div class="clear"></div>
						</div>
					</div>
					<!-- // begin UCenter -->
					<div id="vpj-s-UCenter">
					<?php
							{
								//UCenter/0-6/uid
								?>						
								<li class="mjnav-user"><?php echo l('全部','UCenter/0/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('新品','UCenter/1/'.$account->uid);?></li>				
								<li class="mjnav-user"><?php echo l('活动','UCenter/2/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('爆款','UCenter/3/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('特卖','UCenter/4/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('真人秀','UCenter/6/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('转让潮','UCenter/5/'.$account->uid);?></li>		
								<?
							}
						?>			
						</div>
						<div class="mjvp-contents">
						<?php 
						require_once './' . drupal_get_path('module', 'sina_vp') . "/sina_vp.pages.inc";						
						print(sina_UCenter_saler_page(arg(1),$account->uid));	?>
						</div>
						<!--end UCenter-->
				</div>
				<div class="sellbody-right">
				  <div class="sell-r-t">
					  <div class="sellusergz">
						  <p>232323</p>
							<p>关注</p>
						</div>
						<div class="sellusergz">
						  <p><?php echo $follow_counts = user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));?></p>
							<p>订阅</p>
						</div>
						<div class="sellusergz vpj-quline">
						  <p>232323</p>
							<p>粉丝</p>
						</div>
						<div class="clear"></div>
					</div>
					<div class="infollow-block sellinfollow-block">
					 <h2>他们在微薄</h2>
					 <div class="infollow-block-body">
					  <div class="vp_in_con">
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
							<div class="infollow-block-body-inner">
								<img src="/<?php echo path_to_theme()?>/images/5.jpg" class="infollow-block-body-img" width="50" height="50">
								<p>蔡卓研蔡卓研蔡卓研蔡卓研蔡卓研</p>
							</div>
						<div class="clear"></div>
						</div>
					 </div>
				</div>
				</div>
				<div class="clear"></div>
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