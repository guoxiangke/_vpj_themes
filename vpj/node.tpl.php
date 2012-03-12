
<?php
if($node->type=='weibo'){
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
 <div class="mjvp-conetnt">
		    <div class="mjvp-conetnt-left">
				<div class="mjvp-user-pic">
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
				<?php if(($user->uid<>$node->uid) && in_array('Buyer', $user->roles)){//只有买家可以秀可转让，不可转让自己的。
					?>
				<div class="mjvp-user-op">
				    <div class="mjvp-user-op-ico"></div>
					<div class="mjlpic">
					    <div class="mjlpicc">
							<div class="mjvp-user-op-cz">秀一下</div>
							<div class="mjvp-user-op-cz">转让</div>
						</div>
					</div>
				</div>	
					<?php
				}?>
				
			</div>
            <div class="mjvp-conetnt-right">
				<div class="mjcontent-info-top">
					<div class="content-user mjvp-float">
                        <span class="mjusername"><?php echo l($account->name,'UCenter/0/'.$account->uid)//用户名?></span>
                        <span class="mjvp-term">[<?php echo $taxonomy_name//类别?>]</span>
					</div>        
			    </div>
				<div class="mjvp-context">
          <div class="mjvp-context-body">					
						<?php  
						//<!--正文开始-->
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
						//<!--正文结束-->
						?>				
          </div>
          <?php 
						//<!--加载图片部分--> 分2中情况，1是UCenter页仿izhuanjiao图片展示，节点页图片带淘宝链接。
						if($pic_path=$node->field_weibo_image['0']['filepath']) {
							$parents_pic_flag = TRUE; //标记父节点是否有图片，用于判定子图片的是否显示。
							foreach($node->field_weibo_image as $key=>$value){ //兼容以后多图情况。
									imagecache_generate_image('w516',  $value['filepath']);
									$path = imagecache_create_path('w516', $value['filepath']);
									imagecache_generate_image('w516',  $value['filepath']);
									// izjmax-width
						 		if(arg(0)=='node'){//节点页，终极页 显示方式，带淘宝链接。								
									?>
									<div class="mjvp-context-image">
				             <div class="mjvp-context-image-bk">
												<?php												
												if($image_link = $node->field_image_link['0']['url']){
													echo  l(theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy normal-image','data-original'=>'/'.$pic_path),false)
																	,$image_link
																	,array('html'=>TRUE,'attributes'=>array('class'=>'weibo_image_link','target'=>'_blank')));
												}else{
														echo theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy normal-image','data-original'=>'/'.$pic_path));														
												}?>										    
									   </div>  						
									</div>
								
								<?php								
								}else{
								?>
									<div class="mjvp-context-image status-box">
				             <div class="mjvp-context-image-bk image_box">
												<?php	
														echo theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy thumb-image','data-original'=>'/'.$path),false);
														echo '<img src="/'.$path.'" class="normal-image-hidden">';
												?>										    
									   </div>						
									</div>
					<?php
						}
						}}
						//<!--加载图片结束-->
					?>
					

					<?php 
					//<!--转发/分享 子节点 child node begin-->
					if($is_zf){//&&$taxonomy_id!=5&&$taxonomy_id!=6
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

					<div class="mjchild-node">
						 <div class="mjvp-context-body-child">
					      <span style="color:#0078b6;"><?php echo l("@$z_node->name","UCenter/0/$z_node->uid")?> </span>
								<?php echo $z_node->title?>
						 </div>
						<?php
						//begin子图片
						if($pic_path=$z_node->field_weibo_image['0']['filepath']&&!$parents_pic_flag) {//若父无图片，则显示子图片 
							foreach($z_node->field_weibo_image as $key=>$value){ //兼容以后多图情况。
										imagecache_generate_image('w516',  $value['filepath']);
										$path = imagecache_create_path('w516', $value['filepath']);
										imagecache_generate_image('w516',  $value['filepath']);
										// izjmax-width
							 		if(arg(0)=='node'){//节点页，终极页 显示方式，带淘宝链接。								
										?>
										<div class="vp-context-image">
					             <div class="vp-context-image-bk">
													<?php												
													if($image_link = $node->field_image_link['0']['url']){
														echo  l(theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy normal-image','data-original'=>'/'.$pic_path),false)
																		,$image_link
																		,array('html'=>TRUE,'attributes'=>array('class'=>'weibo_image_link','target'=>'_blank')));
													}else{
															echo theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy normal-image','data-original'=>'/'.$pic_path));														
													}?>										    
										   </div>  						
										</div>
									
									<?php								
									}else{
									?>
										<div class="vp-context-image status-box">
					             <div class="vp-context-image-bk image_box">
													<?php	
															echo theme('imagecache', 'w516', $grey, '', '', array('class'=>'lazy thumb-image','data-original'=>'/'.$path),false);
															echo '<img src="/'.$path.'" class="normal-image-hidden">';
													?>										    
										   </div>						
										</div>
							<?php
								}
							}
						}
						//end子图片
						?>
						<div class="mjcontent-info-bottom-child">
							<div class="mjvp-float-time">
							<?php echo l(sina_vp_time_format($z_node->created),"node/$z_node->nid",array('html'=>true));?>
							</div>
								<div class="mjvp-link">
									<span class="mjvp-loveit">
										<div class="mjlovepic"><img src="<?php echo path_to_theme();?>/images/xin.gif" /></div>
										<div class="mjlovexh"><?echo flag_create_link('bookmarks', $z_node->nid);	?></div>
									</span>
									<span class="mjvp-loveit"><?echo l("点评($z_node->comment_count)","node/$z_node->nid", array('fragment'=>'comment-form'));?></span>
									<span class="mjvp-loveit"><?php echo l("分享($share_counts_z)","forward/$taxonomy_id_z/$z_node->nid"); ?></span>
								</div>
								<div class="clear"></div>	
              </div>  						
					</div>
				<? }
					else{
								$deleted = TRUE;
							?>
							<div class="mjchild-node">
								 <div class="mjvp-context-body-child">
										此微博已被原作者删除。
								</div>
							</div>
	      <?
						}
				}
				//<!--child node end-->
				?>
				
	         		<div class="mjcontent-info-bottom">
								<div class="mjcontent-time mjvp-float-time">12秒前</div>
								<div class="mjvp-link">
									<span class="mjvp-loveit">
										<div class="mjlovepic"><img src="/<?php echo path_to_theme()?>/images/xin.gif"></div>
										<div class="mjlovexh"><?echo flag_create_link('bookmarks', $node->nid);	?></div>
									</span>
									<span class="mjvp-loveit">
										<a href="javascript:void(0);"  class="vp_comment_add" request="<?php echo url("vp/comment_ajax/$node->nid")//no_comments ?>" nid="<?php echo $node->nid?>">点评(<?php echo $node->comment_count?>)</a>
									</span>
									<span class="mjvp-loveit">
										<a href="javascript:void(0);"  class="vp_share_add" request="<?php echo url("forward/$taxonomy_id/$node->nid/ajax")?>" tid="<?php echo $taxonomy_id?>" nid="<?php echo $node->nid?>">分享(<?php echo $share_counts?>)</a>	
									</span>
								</div>
							</div>
						  <div id="Wrap_<?php echo $node->nid?>" class="talkWrap hidden" loading="<?php echo drupal_get_path('module','sina_vp')?>/images/loading.gif" ></div>
							<div id="Wrap_comment_<?php echo $node->nid?>" class="hidden">Wrap_comment</div>
							<div id="Wrap_share_<?php echo $node->nid?>" class="hidden">Wrap_share</div>
            </div>
			</div>
            <div class="clear"></div>
        </div>
<?php
}else{ //当其他类型的节点时，系统默认方式。
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php print $picture ?>

<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

  <div class="content clear-block">
    <?php print $content ?>
  </div>

  <div class="clear-block">
    <div class="meta">
    <?php if ($taxonomy): ?>
      <div class="terms"><?php print $terms ?></div>
    <?php endif;?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php print $links; ?></div>
    <?php endif; ?>
  </div>

</div>
<?php
}?>