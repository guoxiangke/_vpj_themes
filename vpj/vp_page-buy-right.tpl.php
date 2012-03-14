<!--div class="buy_right"-->
<?php 
//Comments/In/3
if((arg(0)=='Comments')&&is_numeric(arg(2))){
	if($account=user_load(arg(2)));
}

?>
				<div class="mjnode-profile">
					<div class="mjuser-pic">
						<div class="mjvpj-pic">
							<?php if(!$account->picture)
								$account->picture = variable_get(user_picture_default, 'sites/default/files/users/0.gif');
								if(arg(0)=='UCenter') 
									echo l(theme('imagecache', '65x65', $account->picture, '编辑个人资料', $account->name, array('class'=>'vp-user-picture')),"user/$account->uid/edit",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
								else echo l(theme('imagecache', '65x65', $account->picture, $account->name, $account->name, array('class'=>'vp-user-picture')),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
							?>
						</div>
						<div class="mjvpj-info">
							<p class="mjvpj-name">
								<?php 
									profile_load_profile(&$account);
									echo l($account->name,"UCenter/0/$account->uid");
								?>
							</p>
							<p class="mjlocation">
								<?php 
								 if(in_array('Buyer', $account->roles) ){ //买家显示地理位置
									echo $account->profile_province.'&nbsp;'.$account->profile_city;
								 }?>
							</p>
						</div>
					</div>
					<div class="mjsignature">
						<?php 
						//大家好，我是微铺街的一成员，欢迎大家来到微铺街	
						 if($account->uid==$user->uid){
							if(!$account->signature){
								$account->signature="您还没有设置签名，点此设置！";								 
							}
							echo l(truncate_utf8($account->signature, 55, $wordsafe = false, $dots = TRUE),"user/$account->uid/edit");
						 }else{
								if(!$account->signature){
									$account->signature="这家伙很懒，还没有设置签名";
								}
								echo  truncate_utf8($account->signature, 55, $wordsafe = false, $dots = TRUE); 
						 }
						?>
						
					</div>
					<?php 
						$sql='SELECT count(*) FROM comments comments 
						INNER JOIN {node} node 
							ON node.nid = comments.nid 
							WHERE (node.uid) = '.$account->uid;
						$counts_comments = db_result(db_query($sql));
						$result = db_query('SELECT count(*) FROM {sina_vp_mentions} WHERE uid = %d', $account->uid);
						$counts_mentions =db_result($result);
						$counts_mentions=$counts_mentions?$counts_mentions:0;
						if(arg(0)=='Comments'){$tag_comments='tag';}
						if(arg(0)=='Mentions'){$tag_mentions='tag';}
						if(arg(0)=='messages'){$tag_messages = 'tag';}
						$counts_messages=privatemsg_unread_count()?privatemsg_unread_count():0;
						//if($account->uid==$user->uid){
						?>
					<div class="mjabout">
						<ul>
							<li><?php echo l("@提到我($counts_mentions)","Mentions/$account->uid",array('attributes'=>array('class'=>"$tag_mentions")));?></li>
							<li><?php echo l("我的点评($counts_comments)","Comments/In/$account->uid",array('attributes'=>array('class'=>"$tag_comments")));?></li>
							<li><?php echo l("未拆私信($counts_messages)",'messages',array('attributes'=>array('class'=>"$tag_messages")));?></li>
						</ul>
					</div>
				</div>
				<div class="mjfollow-block">
					<div class="mjfollow-block-head">
						这些人关注了他
					</div>
					<div class="mjfollow-block-body">
						<?php
							$follows_uids=_get_my_follows($account->uid);
							//echo '<pre>';print_r($follows_uids);
							$show_numbers = 9;
							foreach($follows_uids as $uid=>$realtionship){
								--$show_numbers;
								if(!$show_numbers)break;
								$account_realtionship = user_load($uid);
								if(!$account_realtionship->picture)
								$account_realtionship->picture = variable_get(user_picture_default, 'sites/default/files/users/0.gif');
						?>
						<div class="mjfollow-block-body-inner">
							<div class="mjfollow-block-body-img">
								<?php
									echo l(theme('imagecache', '35x35', $account_realtionship->picture, '', $account_realtionship->name, 
													array('class'=>'vp-user-picture')),"UCenter/0/$account_realtionship->uid",
													array('html'=>TRUE,'attributes'=>array('class'=>'vp-node-picture-link')));
								?>								
							</div>
							<div class="mjfollow-block-body-size">
								<?php echo l($account_realtionship->name,"UCenter/0/$account_realtionship->uid");?>
							</div>
						</div>
						<?}
							while($show_numbers){
								--$show_numbers;
							
						?>	
						<div class="mjfollow-block-body-inner">
							<div class="mjfollow-block-body-img"><img src="<?php echo path_to_theme();?>/images/5.jpg" width="35" height="35"/>
							</div>
							<div class="mjfollow-block-body-size">
								蔡卓研
							</div>
						</div>
						<?}?>
					</div>
				</div>
				<div class="mjrecommend-block">
					<div class="mjrecommend-block-head">
						你可能喜欢的店铺
					</div>
					<?php
					$show_numbers=5;
					while($show_numbers){
								--$show_numbers;
							
					?>
					<div class="mjrecommend-block-body">
						<div class="mjrecommend-block-body-img"><img src="<?php echo path_to_theme();?>/images/5.jpg" width="35" height="35"/>
						</div>
						<div class="mjrecommend-block-body-gz">
							<span class="mjgz-name">蔡卓妍</span><span class="mjgz-color">--关注</span>
						</div>
					</div>
					<?}?>
				</div>