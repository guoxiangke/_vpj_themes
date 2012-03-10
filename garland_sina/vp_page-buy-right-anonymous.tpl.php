<!--div class="buy_right"-->
<?php 
//Comments/In/3
/*
 * if((arg(0)=='Comments')&&is_numeric(arg(2))){
	if($account=user_load(arg(2)));
}
 * */
if(!$account->uid){ //匿名用户查看 
	$account=user_load(40);
}
?>
  <div class="mj_tx pad5">
    <dl>
      <?php
      	if(!$account->picture)
				$account->picture = variable_get(user_picture_default, 'sites/default/files/users/0.gif');
      	if(arg(0)=='UCenter') 
      	echo l(theme('imagecache', 'middle_picture', $account->picture, '编辑个人资料', $account->name, array('class'=>'vp-user-picture')),"user/$account->uid/edit",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
				else echo l(theme('imagecache', 'middle_picture', $account->picture, $account->name, $account->name, array('class'=>'vp-user-picture')),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Buyer-user-link')));
				
				//<img src="<?php echo $account->picture?$account->picture:'/sites/default/files/users/0.gif'? >" width="100" height="100" />      
      ?>
      
      <dt><?php
				profile_load_profile(&$account);
			 	if(arg(0)=='UCenter') echo l($account->name,"user/$account->uid/edit",array('attributes'=>array('title'=>'编辑个人资料')));
				else echo l($account->name,"UCenter/0/$account->uid");
			?>
			<br/>
			<span class="location">
				<?php echo $account->profile_location?>
			</span>
			<div class="signature">
				<?php 
				 if($account->uid==$user->uid){	 
				 	//$edit_info = l('『修改』',"user/$account->uid/edit");
				 	if($account->signature){$signature=$edit_info.$account->signature; }
					else{$signature=$edit_info."这家伙很懒，还没有设置签名";	 }
				 }else{
				 		if($account->signature){$signature=$account->signature;}
						else{$signature="这家伙很懒，还没有设置签名";}
				 }
					
					echo  truncate_utf8($signature, 55, $wordsafe = false, $dots = TRUE)?>
			</div>
			</dt>
    </dl>
    <div class="mj_dy">
    	<?php if($account->uid==$user->uid){
    		if(in_array('Seller', $account->roles)){
    			?>
		    	<span class="follow-action follow-me">订阅<span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=2),array("count" => TRUE));?></span></span>
		    	<span class="follow-action follow-me">关注<span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=1),array("count" => TRUE));?></span></a></span>
		    	<span class="follow-action follow-me"><a title="我的粉丝" href="<?php echo url('relationships')?>">粉丝</a><span class="follow-plus">+<?php echo user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));?></span></a></span>
		    	<?php
    		}else{?>
    	<span class="follow-action follow-me"><a title="我的订阅" href="<?php echo url('relationships/2')?>">订阅</a><span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=2),array("count" => TRUE));?></span></span>
    	<span class="follow-action follow-me"><a title="我的关注" href="<?php echo url('relationships/1')?>">关注</a><span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=1),array("count" => TRUE));?></span></a></span>
    	<span class="follow-action follow-me"><a title="我的粉丝" href="<?php echo url('relationships')?>">粉丝</a><span class="follow-plus">+<?php echo user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));?></span></a></span>
    	<?php }
				}else{//被访问买家页面 不带链接?>
    	<span class="follow-action follow-he"><a title="Ta的订阅" href="<?php echo url("relationships/2/$account->uid")?>">订阅</a><span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=2),array("count" => TRUE));?></span></span>
    	<span class="follow-action follow-he"><a title="Ta的关注" href="<?php echo url("relationships/1/$account->uid")?>">关注</a><span class="follow-plus">+<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=1),array("count" => TRUE));?></span></span>
    	<span class="follow-action follow-he"><a title="Ta的粉丝" href="<?php echo url("relationships/follows/$account->uid")?>">粉丝</a><span class="follow-plus">+<?php echo user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));?></span></span>
    	<?php }?>
    </div>
    <?php
    			//-粉丝 else +粉丝			
			  $options = sina_vp_follow_toggle_options($option='follow');
				$my_follows =	user_relationships_load(array("requester_id" => $user->uid),array("sort" => 'requestee_id',"include_user_info" => TRUE));//所有的
				$follow_status=0;
				foreach(array_keys($my_follows) as $key){
					if($account->uid==$key){
						$follow_status=1; //已关注					
						//$rid = $my_follows[$key][0]->rid;// 关系id		
					}
				}
				
	    	$his_follows =	user_relationships_load(array("requester_id" => $account->uid),array("sort" => 'requestee_id',"include_user_info" => TRUE));//所有的
	    	foreach(array_keys($his_follows) as $key){
						if($user->uid==$key){
							$follow_status_me=1; //他已关注了我					
							//$rid = $my_follows[$key][0]->rid;// 关系id		
						}
				}
				if($follow_status_me&&$follow_status){
					echo '<div><span class="follow-action follow-status">互相关注</span></div>';
				}elseif($follow_status_me){
					echo '<div><span class="follow-action follow-status">他是您的粉丝</span></div>';
				}
				if($account->uid<>$user->uid && !in_array('Seller',$user->roles) ){		//卖家查看买家，不可进行粉丝操作。			
					echo '	<span class="follow-action follow-status follow-action-do">';
					foreach (array_keys($options) as $key) {
				    echo fasttoggle2($options[$key][$follow_status], 'follow_toggle/'. $account->uid .'/'. $options[$key]['0'] , TRUE, $key .'_'. $user->uid, 'fasttoggle-status-user-'. $key .'-'. $follow_status,$account->uid);
				  } 
					echo '</span>';
				}
    	?>
    	
  </div>
  <div class="lb_about pad5">
    <ul>
      
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
      	if($account->uid==$user->uid){?>
      	<li><?php echo l("@提到我($counts_mentions)","Mentions/$account->uid",array('attributes'=>array('class'=>"$tag_mentions")));?>
      	</li>
      	<li><?php echo l("我的点评($counts_comments)","Comments/In/$account->uid",array('attributes'=>array('class'=>"$tag_comments")));?></li>
      	<li><?php echo l("未拆私信($counts_messages)",'messages',array('attributes'=>array('class'=>"$tag_messages")));?></li>
      <?php }else{?>
      	<li><a  href="<?php echo url("Mentions/$account->uid")?>">@提到TA的(<?php echo $counts_mentions;?>)</a></li>
      	<li><?php echo l("TA的点评($counts_comments)","Comments/In/$account->uid",array('attributes'=>array('class'=>"$tag_comments")));?>
      	</li>
      	<li><?php 
      	$url = privatemsg_get_link(array($account));
      	echo l(t('发私信'), $url, array('query' => drupal_get_destination(),'attributes'=>array('class'=>"action")));
      	// url("user/$account->uid/messages")
      	?></li>
      <?php
      }?>
      这是匿名用户看到的右侧，需要定制～～
    </ul>
  </div>
  <div class="vp_in">
    <div class="vp_tit1 pad_w10"><?php if($account->uid==$user->uid){?>我的粉丝<?}else{?>这些人关注了TA<?}?></div>
    <div class="vp_in_con2">
			<?php
				$follows_uids=_get_my_follows($account->uid);
				//echo '<pre>';print_r($follows_uids);
				$show_numbers = 9;
				foreach($follows_uids as $uid=>$realtionship){
					--$show_numbers;
					if(!$show_numbers)break;
					$account_realtionship = user_load($uid);
			?>
			<div class="yh02"><a href="<?php echo url("UCenter/0/$account_realtionship->uid")?>" title="<?php echo $account_realtionship->name?>"><img src="<?php echo $account_realtionship->picture;?>" width="50" height="50" /></a><br />
        <p><a href="<?php echo url("UCenter/0/$account_realtionship->uid")?>"> <?php echo $account_realtionship->name?></a></p>
      </div>
			<?}
				while($show_numbers){
					--$show_numbers;
			?>			
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">王力宏力宏力宏力宏</a></p>
      </div>
			<?php	}
			?>
    </div>
  </div>
  <div class="vp_in">
    <div class="vp_tit1 pad_w10">猜你喜欢</div>
    <div class="vp_in_con2">
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#"> 许建强 </a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">蔡卓妍</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">黄百鸣</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">晚晓利</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">张亚东</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">王力宏指挥家王进指挥家王进</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">指挥家王进指挥家王进</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">刘卓辉</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="50" height="50" /><br />
        <p><a href="#">王洁实</a></p>
      </div>
    </div>
  </div>
<!--/div-->