<?php
/* 
 * 买家看到的卖家各个频道里的卖家信息。。。
 * <div class="top">
 * 	<?php include(path_to_theme().'/vp_page-top.tpl.php');?>
 * </div>
 */
?>
	<?php if( !arg(1)=='' ) : ?>
  <div class="sale_sj">
    <div class="pp_jieshao">
      <dl>
        <p class="pp_logo"><?php echo l(theme_image($account->picture, $account->name, $account->name, array('class'=>'Seller-logo'), $getsize = false),"UCenter/0/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-picture-link')));?></p>
        <dd>店铺介绍：<?php echo $account->signature?truncate_utf8($account->signature, 140, $wordsafe = FALSE, $dots = true):'您的个性签名/店铺简介显示在这里！';if($user->uid==$account->uid)echo l('点击设置',"user/$account->uid/edit", array(
    'attributes' => array(
      'class' => 'Seller-signature',
      //'rel' => 'lightbox',
    )));?> </dd>
   <dd>
    	<p class="gz_btn">
          
          <?php
           //<input name="" type="button" value="订阅" />
           $follow_counts = user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));
					 $my_follows =	user_relationships_load( array("between" => array($account->uid, $user->uid)),array("include_user_info" => TRUE));//获取当前用户与该卖家的关系
					 $follow_status=0;
						if(count($my_follows)){
							$follow_status=1; //已关注	
						}
					 $options = sina_vp_follow_toggle_options($option='focus');
           if($account->uid<>$user->uid && !in_array('Seller',$user->roles)){		//卖家查看卖家/自己，不可进行粉丝操作。 			
						echo '	<span class="focus-action focus-status focus-action-do">';
						foreach (array_keys($options) as $key) {
					    echo fasttoggle2($options[$key][$follow_status], 'follow_toggle/'. $account->uid .'/'. $options[$key]['0'] , TRUE, $key .'_'. $user->uid, 'fasttoggle-status-user-'. $key .'-'. $follow_status,$account->uid);
					  } 
						echo '</span>';
						echo '<div class="send-message user-action">';
						//echo l('私信','messages/new/'.$account->uid,array('html'=>TRUE,'attributes'=>array('class'=>'message-link')));						
		      	$url = privatemsg_get_link(array($account));
		      	echo l(t('发私信'), $url, array('query' => drupal_get_destination(),'attributes'=>array('class'=>"user-action")));
      	
				    echo '</div>';
					 }else{
					 	echo '	<span class="focus-action focus-status focus-action-do">';
						echo l('我的粉丝('.$follow_counts.')','relationships',array('html'=>TRUE,'attributes'=>array('class'=>'message-link')));
						echo '</span>';
					 	echo '<div class="send-message">';
						echo l('我的私信','messages/',array('html'=>TRUE,'attributes'=>array('class'=>'message-link')));
				    echo '</div>';
					 }
				?>
        </p>
    </dd>
      </dl>
    </div>
    <div class="pp_gz">
    	 <div class="fans">
      	<? $my_follows=_get_my_follows($account->uid);
				$counts=0;
				foreach ($my_follows as $follow_uid => $value) {
					$follow_user = user_load($follow_uid);
					$counts++;
					if($counts<4){
						?>						
		        <div class="yh02"><?php //theme_image($follow_user->picture, $follow_user->name, $follow_user->name,array('class'=>'Seller-follow'), $getsize = false);
		         echo l(theme('imagecache', 'small_picture', $follow_user->picture, $follow_user->name, $follow_user->name, array('class'=>'Seller-follow')),"UCenter/0/$follow_user->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-follow-link')));?><br />
		          <p> <?php echo l($follow_user->name,"UCenter/0/$follow_user->uid");?></p>
		        </div>
						<?php
					}else{break;}
				}
      	?>
      </div>
      <div class="bgz">
        <p><?php echo l('被订阅('.$follow_counts.')',"relationships/follows/$account->uid");?></p>     
      </div>
     
	    
    </div>
  </div>
  <?php endif; ?>