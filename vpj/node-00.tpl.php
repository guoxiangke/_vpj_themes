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
  
<div class="wb_02 bor_top" id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">
  
  <!--这里是时间-->
  <!--Start-->
  <div class="fb_time">
  
     <?php //<P>59分钟前</P>
				echo sina_vp_time_format($node->created);		
		?>
  </div>
  <!--End-->
  
  <div class="fb_nr2">
    <div class="fb_yh">
    	<a title="<?php echo $account->name?>" href="<?php if($account->uid==$user->uid){echo url('UCenter');}else{echo url('UCenter/0/'.$account->uid);}?>"><?php echo $account->name?></a> <cite>[<?php echo $taxonomy_name?>]</cite>
    	
    		 <?php if ($links): ?>
			      <span class="links top-links"><?php if($user->uid) print $links; else{
			      	?>
			      	<ul class="links inline">
			      		<li class="link_6 first"><a title="发布真人秀" href="javascript:void(0);" onclick="javascript:alert('对不起，该操作需要您登录！');">秀一下</a></li>
								<li class="link_5"><a title="发布转让" href="javascript:void(0);" onclick="javascript:alert('对不起，该操作需要您登录！');">转让</a></li>
							</ul>
			      	<?
			      }?></span>
			    <?php endif; ?>
    	
    	</div>
    <div class="wb_nr">
      <div class="userPic">
      	<?php 
      	
      	if($account->uid==$user->uid){$user_link = 'UCenter';}else{$user_link = 'UCenter/0/'.$account->uid;}
      	echo l(theme('imagecache', 'small_picture', $account->picture, $account->name, $account->name, array('class'=>'vp-user-picture')),$user_link,array('html'=>TRUE,'attributes'=>array('class'=>'vp-node-picture-link')));?>
      	
			</div>
      
      <div class="msgBox2">
        <div class="msgCnt">
        	 
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
         
        </div>
        <?php 
        //$pic=theme('imagecache', 'taobao_big', $node->field_weibo_image['0']['filepath'], $follow_user->name, $follow_user->name, array('class'=>'Seller-follow'));
        if ($pic=$node->field_weibo_image['0']['filepath']): 
        //print ' <div class="picBox"><img src="'.$pic.'" /></div>'; 
        echo l(theme_image($pic, '', '',array('class'=>''), $getsize = FALSE),"node/$node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'vp_node_pic picBox')));
        endif; ?>
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
 				<div class="msgBox2 msgBox_copy">
	        <div class="msgCnt">
	        	<span class="z_node_user"><?php echo l("@$z_node->name","UCenter/0/$z_node->uid")?></span>
	        	<?php echo $z_node->title?>
	        </div>
	        <?php //if ($pic=$z_node->field_weibo_image['0']['filepath']): print ' <div class="picBox"><img src="'.$pic.'" /></div>'; endif; ?>
        	
        	 <?php 
		        //$pic=theme('imagecache', 'taobao_big', $node->field_weibo_image['0']['filepath'], $follow_user->name, $follow_user->name, array('class'=>'Seller-follow'));
		        if ($pic=$z_node->field_weibo_image['0']['filepath']): 
		        //print ' <div class="picBox"><img src="'.$pic.'" /></div>'; 
		        echo l(theme_image($pic, '', '',array('class'=>''), $getsize = FALSE),"node/$z_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'vp_node_pic picBox picBox_fx')));
		        endif;
					 ?>
        <div class="pubInfo">
	        	<span class="copy_time"> 
							<?php //<P>59分钟前</P>
									echo l(sina_vp_time_format($z_node->created),"node/$z_node->nid",array('html'=>true));
							?>
						</span>
	        	<span class="right">		        	
				     
				      <div class="vp_add_link zf_node">
				      <?php 
				      	echo ' · '; 
				      	echo l("点评($z_node->comment_count)","node/$z_node->nid", array('fragment'=>'comment-form'));
					      echo ' · '; 
								echo l("分享($share_counts_z)","forward/$taxonomy_id_z/$z_node->nid"); 
				      ?>
				      </div> 
				      <div class="counts"><?php
	        			echo flag_create_link('bookmarks', $z_node->nid);	        		
				      ?>
				      </div>    
	        	</div>
	      </div>
			  <?php 
				}else{
											$deleted = TRUE;
										
							?>
				<div class="msgBox2 msgBox_copy">
							        <div class="msgCnt">
							        	
							        	<?php echo '此微博已被原作者删除。';		?>
							        </div>
	        
        
	      </div>
	      <?
						}
				}
				?>
       <div class="pubInfo">
					  <div class="counts">
					 	<?php
	      			//echo flag_create_link('bookmarks', $node->nid);		
			      ?>
		      </div>			   			
					<div class="vp_add_link main_node">
      			
			     <?php
      		
        	 if(arg(0)=='node'){
        	 	//echo '<span id="diandiandiandian"> · </span>';       	
						//echo l("点评($node->comment_count)","node/$node->nid", array('fragment'=>'comment-form'));
						//echo ' · '; 
						//echo l("分享($share_counts)","forward/$taxonomy_id/$node->nid"); 
					 if ($links): ?>
						   	 <div class="links bottom-links">
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
			     
				</div>
				<div id="Wrap_<?php echo $node->nid?>" class="talkWrap hidden" loading="<?php echo drupal_get_path('module','sina_vp')?>/images/loading.gif" ></div>
				<div id="Wrap_comment_<?php echo $node->nid?>" class="hidden">Wrap_comment</div>
				<div id="Wrap_share_<?php echo $node->nid?>" class="hidden">Wrap_share</div>
      </div>
    </div>
  </div> </div>
<?php }else{
	
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php print $picture ?>

<?php if ($page == 0): ?>
  <h2><?php if(function_exists(sina_vp_context_preprocess))print sina_vp_context_preprocess(&$node) ?><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
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