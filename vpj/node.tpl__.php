
<?php
if(arg(0)=='UCenter'||$node->type=='weibo'){
		$account = user_load($node->uid);
		$taxonomys = $node->taxonomy;
		foreach($taxonomys as $key=>$obj){
			if($obj->vid==2){
				$taxonomy_name=$obj->name;
				$taxonomy_id = 		$obj->tid;	
			}
		}
		$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$node->nid AND  `cid` =0";
		$share_counts = db_result(db_query($share_sql));
		$is_zf_sql = "SELECT zid zid FROM  {sina_vp_weibo2node} WHERE  `nid` =$node->nid AND  `cid` =0 AND  `zid` <>0 ";
		$is_zf = db_result(db_query($is_zf_sql));
		
?>

 <div class="vp-conetnt mjvp-conetnt">
		    <div class="vp-conetnt-left mjvp-conetnt-left">
				<div class="vp-user-pic mjvp-user-pic">
				<!--头像-->
								<?php  // width="50" height="50"
									if($account->uid==$user->uid){$user_link = 'UCenter';}else{$user_link = 'UCenter/0/'.$account->uid;}
											
									$grey = drupal_get_path('module', 'sina_vp_imagetool').'/images/grey.gif';
											imagecache_generate_image('50x50',  $account->picture);
											$path = imagecache_create_path('50x50', $account->picture);
									echo l(theme('imagecache', '50x50', $grey, '', '', array('class'=>'lazy','data-original'=>'/'.$path),FALSE)
									,$user_link
									,array('html'=>TRUE,'attributes'=>array('class'=>'vp-user-pic-link')));
								?>
				</div>
				<div class="vp-user-op mjvp-user-op">
				    <div class="vp-user-op-ico mjvp-user-op-ico"></div>
					<div class="lpic mjlpic">
					    <div class="lpicc mjlpicc">
							<div class="vp-user-op-cz mjvp-user-op-cz">秀一下</div>
							<div class="vp-user-op-cz mjvp-user-op-cz">转让</div>
						</div>
					</div>
				</div>
			</div>
            <div class="vp-conetnt-right mjvp-conetnt-right">
				<div class="content-info-top mjcontent-info-top">
					<div class="content-user vp-float mjvp-float">
                        <span class="username mjusername"><!--用户名--><?php echo l($account->name,'UCenter/0/'.$account->uid)?></span>
                        <span class="vp-term mjvp-term">[<?php echo $taxonomy_name?>]<!--类别--></span>
					</div>        
			    </div>
				<div class="vp-context mjvp-context">
                    <div class="vp-context-body mjvp-context-body">
					<!--正文开始-->
					<?php  
						if($is_zf&&$taxonomy_id!=5&&$taxonomy_id!=6){
									$output = l('分享|',"node/$node->nid");
								}
						if($is_zf&&$taxonomy_id==5){
									$zf_node = node_load($is_zf);
									$output = "来自".l("@".$zf_node->name,"UCenter/0/$zf_node->uid").'的转让 | ';
								}
						if($is_zf&&$taxonomy_id==6){
									$zf_node = node_load($is_zf);
									$output = "来自".l("@".$zf_node->name,"UCenter/0/$zf_node->uid").'的真人秀 | ';
								}
						$output = '<span class="vp-source">'.$output."</span>";
						echo $output.sina_vp_content_process($node->title);
					?>
					<!--正文结束-->
                    </div>
					<!--加载图片部分-->
					<?php
							if($pic_path=$node->field_weibo_image['0']['filepath']) {
								$parents_pic_flag = TRUE; //原帖是否有图片 //以后会有多图 foreach，仿izhuanjiao
								//theme('imagecache', '180x180', $pic_path, '', '', array('class'=>'lazy'));
							
							echo '<div class="vp-context-image  status-box">';
						 	foreach($node->field_weibo_image as $key=>$value){
						 		if(arg(0)=='node'){

									imagecache_generate_image('w516',  $value['filepath']);
									$path = imagecache_create_path('w516', $value['filepath']);
									imagecache_generate_image('w516',  $value['filepath']);
									$ori_path = imagecache_create_path('w516', $value['filepath']);
									echo "<div class='vp-context-image-bk image_box mjvp-context-image-bk'>	
						 				
						 					<img src='/".$ori_path."' style='max-width:180px;height:auto' />
								
								
									</div>";
								
								
								}else{
							?>
							<div class="vp-context-image-bk image_box mjvp-context-image-bk">					    
								<?php
									imagecache_generate_image('w516',  $value['filepath']);
									$path = imagecache_create_path('w516', $value['filepath']);
									//print theme('imagecache', 'preset_namespace', $image_filepath, $alt, $title, $attributes);
									echo  theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy thumb-image izjmax-width','data-original'=>$path),false) ;
									imagecache_generate_image('w516',  $value['filepath']);
									$ori_path = imagecache_create_path('w516', $value['filepath']);
								?>
									<img src="/<?echo $ori_path;?>" class="normal-image-hidden">
					    </div>
							<?php
							echo '</div>';
							}
								}
							}
						?>
					<!--加载图片结束-->
<!--开始遍历评论-->
					<?php 
					if($is_zf&&$taxonomy_id!=5&&$taxonomy_id!=6){
		  			 $z_node = node_load($is_zf);
						if($z_node->nid){
							 $share_sql_z = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$z_node->nid AND  `cid` =0";
							 $share_counts_z = db_result(db_query($share_sql_z));
							 $taxonomys_z = $z_node->taxonomy;
							 foreach($taxonomys_z as $key=>$obj){
								if($obj->vid==2){
									$taxonomy_name_z=$obj->name;
									$taxonomy_id_z = 		$obj->tid;	
								}
							}
						
		  			
					?>
<!--child node begin-->
					<div class="child-node mjchild-node">
						 <div class="vp-context-body-child mjvp-context-body-child">
					      <span style="color:#0078b6;"><?php echo l("@$z_node->name","UCenter/0/$z_node->uid")?> </span>
								<?php echo $z_node->title?>
						</div>
						<?php
						//begin子图片  转发分享是要子图片的，秀&转让不要子图片
						if(!$parents_pic_flag){//若父无图片，则显示子图片
						?>
						<div class="vp-context-image mjvp-context-image">
							<?php  
						
								if($pic_path=$z_node->field_weibo_image['0']['filepath']) {
									$parents_pic_flag = TRUE; //原帖是否有图片 //以后会有多图 foreach，仿izhuanjiao
									//theme('imagecache', '180x180', $pic_path, '', '', array('class'=>'lazy'));
								}else{}
								
								//echo l(theme_image($pic, '', '',array('class'=>''), $getsize = FALSE),"node/$node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'vp_node_pic picBox')));
							 	foreach($z_node->field_weibo_image as $key=>$value){
								?>
								<div class="vp-context-image-bk mjvp-context-image-bk">						    
									<?php echo  theme('imagecache', 'w180', $value['filepath'], '', '', array('class'=>'lazy'));?>
						    </div>
								<?php
							}?>
						</div>
						<?php	
						}
						//end子图片
						?>
						<div class="content-info-bottom-child mjcontent-info-bottom-child">
							<div class="content-time vp-float-time mjvp-float-time">
							<?php echo l(sina_vp_time_format($z_node->created),"node/$z_node->nid",array('html'=>true));?>
							</div>
							<div class="vp-link mjvp-link">
								<span class="vp-loveit mjvp-loveit">
									<div class="lovepic mjlovepic"><img src="<?php echo path_to_theme();?>/images/xin.gif" /></div>
									<div class="lovexh mjlovexh"><?echo flag_create_link('bookmarks', $z_node->nid);	?></div>
								</span>
								<span class="vp-loveit mjvp-loveit"><?echo l("点评($z_node->comment_count)","node/$z_node->nid", array('fragment'=>'comment-form'));?></span>
								<span class="vp-loveit mjvp-loveit"><?php echo l("分享($share_counts_z)","forward/$taxonomy_id_z/$z_node->nid"); ?></span>
							</div>
							<div class="clear"></div>	
                        </div>  						
					</div>
				<?	}
					else{
											$deleted = TRUE;
										
							?>
							<div class="child-node mjchild-node">
								 <div class="vp-context-body-child mjvp-context-body-child">
										此微博已被原作者删除。
								</div>
							</div>
			
	      <?
						}
				}
				?>
				<!--child node end-->
					<div class="content-info-bottom mjcontent-info-bottom">
					<div class="vp_add_link main_node mjvp_add_link main_node">
      			
			     <?php
      		
        	 if(arg(0)=='node'){
        	 	//echo '<span id="diandiandiandian"> · </span>';       	
						//echo l("点评($node->comment_count)","node/$node->nid", array('fragment'=>'comment-form'));
						//echo ' · '; 
						//echo l("分享($share_counts)","forward/$taxonomy_id/$node->nid"); 
					 if ($links): ?>
						   	 <div class="links bottom-links ">
						   	 	<?php if($user->uid){print $links ;}
					 							else{//匿名用户
					 								?>
					 								<ul class="links inline">
														<li class="flag-bookmarks"><span><span class="flag-wrapper flag-bookmarks flag-bookmarks-365">
														      <a rel="nofollow" class="flag flag-action flag-link-toggle flag-processed" title="喜欢" href="javascript:void(0);" onclick="javascript:alert('对不起，该操作需要您登录！');">喜欢(0)</a><span class="flag-throbber">&nbsp;</span>
														    </span>
														</span></li>
														<li class="comment_ajax active"><a class="active" title="评论" href="javascript:void(0);" onclick="javascript:alert('请登录后评论！');"> · 点评(17)</a></li>
														<li class="forward_link last"><a title="分享" href="javascript:void(0);"  onclick="javascript:alert('对不起，该操作需要您登录！');"> · 分享(0)</a></li>
													</ul>
					 								<?
					 							}?>
						   	 </div>	
					 <?php endif; 
        	 }elseif(user_access('add new forward')){
						 		 	//转发分享 、点评 用ahah做。如果是自己的微博，不显示。&&$node->uid!=$user->uid
						 		 	//echo drupal_get_form('weibo_ajax_forward', $node);
							 echo flag_create_link('bookmarks', $node->nid);		
						 	?>
							<span id="diandiandiandian"> · </span>
							<a href="javascript:void(0);"  class="vp_comment_add" request="<?php echo url("vp/comment_ajax/$node->nid")//no_comments ?>" nid="<?php echo $node->nid?>">点评(<?php echo $node->comment_count?>)</a>   	
						
							<span id="diandiandiandian"> · </span>
							<a href="javascript:void(0);"  class="vp_share_add" request="<?php echo url("forward/$taxonomy_id/$node->nid/ajax")?>" tid="<?php echo $taxonomy_id?>" nid="<?php echo $node->nid?>">分享(<?php echo $share_counts?>)</a>   	
					<?php	}
					//<a href="javascript:toggleit('.$node->nid.');"  class="hidden_next_input">
					?>
					</div>


<?php
	/**
	*这里是隐藏的评论
	*/





	/**
	*					<div class="vp-content-child-news">
					    <div class="vp-content-child-news-bk"><input type="text" class="chlidtext"></div> 
						<div class="vp-content-child-news-dp">
						    <div class="content-child-news-dp-left">
								<input type="checkbox" name="tb" id="tb" class="tbwb"/>
								同步到新浪微博
							</div>
							<div class="content-child-news-dp-right">
							    <input type="button" name="" class="dpnv" value="点评">
							</div>
						</div>


<!--遍历评论-->
						<div class="vp-content-child-news-nr">
						    <div class="content-child-news-nr-img"><img src="5.jpg" width="35" height="35" /></div>
							<div class="content-child-news-nr-body">
			                    <div class="content-child-news-nr-title"><span style="color:#0078b6;">七格格：</span>弄丢了功能更能够更快养车的你能给那个养车<span style="color:#0078b6;"> @杨丽丽 </span>年开了那个能跟开工工你在承担再拿个</div>
								<div class="content-child-news-nr-tm">
								    <div class="tmm">10秒前</div>
									<div class="hhf">回复</div>
								</div>
							</div>
						</div>	
<!---->


                        <div class="content-more">更多>></div>						
					</div>
	*/





	/**
	*End
	*/
?>

				<div id="Wrap_<?php echo $node->nid?>" class="talkWrap hidden" loading="<?php echo drupal_get_path('module','sina_vp')?>/images/loading.gif" ></div>
				<div id="Wrap_comment_<?php echo $node->nid?>" class="hidden">Wrap_comment</div>
				<div id="Wrap_share_<?php echo $node->nid?>" class="hidden">Wrap_share</div>
					


                    <div class="clear"></div>					
				</div>                
            </div>
			</div>
            <div class="clear"></div>
        </div>

<?php
/**
 *					
 */
			
?>
<?php
}?>