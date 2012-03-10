<?php
 if($uid=arg(2)){//其他人访问的买家页面 UCenter/0/3
		$account=user_load($uid);
		if($page_uid=$account->uid){
			//存在被访问用户
		}else{$account=$user;}
	}else{$account=$user;}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
    <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
   
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body class="UCenter_seller">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>

<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
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
		      	echo l(t('发私信'), $url, array('query' => drupal_get_destination(),'attributes'=>array('class'=>"user-action",'target'=>'_blank')));
      	
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
        <p><?php echo l('被订阅('.$follow_counts.')',"relationships/follows/$account->uid",array('attributes'=>array('class'=>"user-action",'target'=>'_blank')));?></p>     
      </div>
     
	    
    </div>
  </div>
  <div class="sale_active">
  	<?php
  		//$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$account->uid AND  `sina_vp_type` =2 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
  	  $sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
			INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
			LEFT JOIN term_node term_node ON node.vid = term_node.vid 
			LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
			WHERE (users_roles.rid = 3) AND (node.status = 1) AND (node.uid = %d) 
			AND (node.type in ("weibo")) AND ((term_data.name) = ("活动")) 
			ORDER BY node_created DESC LIMIT 0 , 10';//从10条中取带图的活动1条
  	  $results = db_query($sql,$account->uid);
			while($row = db_fetch_array($results)){
	      $activity_nids [] = $row['nid'];
				$rows = TRUE;
	    }
			/*
			 ** */ 
			if($activity_nids){//判断图片del  分享无图片，怎么办？
				foreach ($activity_nids as $activity_nid) {
					$activity_node = node_load($activity_nid);
					if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'])break;
				}			
				$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
				$share_counts = db_result(db_query($share_sql));
			}
  	?>
    <div class="sale_tit">[活动]
    	<?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布活动','new/2',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>
    </div>    	
    
    <div class="sale_con">
     <?if($activity_nids){?>
     	 <div class="sale_hd_pic">
      	<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
      </div>
      <div class="sale_hd_con">
        <dl>
          <dt>活动介绍：</dt>
          <dd><?php echo l($activity_node->title,"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-content'))); ?></dd>
        </dl>
        <div class="pubInfo">        		
        	<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>			          	
          	 · 
          	<?php 
	          	$taxonomys = $activity_node->taxonomy;
							foreach($taxonomys as $key=>$obj){
								if($obj->vid==2){//v2 == 微博类型
									$taxonomy_name=$obj->name;
									$taxonomy_id = 		$obj->tid;	
								}
							}
							echo l("分享($share_counts)","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
						?>
        	<?php
        		echo flag_create_link('bookmarks', $activity_node->nid);
    			?></div>
      </div>
      
    </div>
    	<?}else{
      	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
      	}
   		 ?>
    <div class="more right"><?php echo l('更多',"Activity/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?></div>
  </div>
  <!--新品开始-->
  <div class="sale_active">
    <div class="sale_tit">[新品]
    	<?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布新品','new/1',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>
    </div>
     <div class="xp_con">
      <ul>
     	<?php //10个中取4个带图片的。
	  		//$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$account->uid AND  `sina_vp_type` =1 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  		  	  $sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
										INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
										LEFT JOIN term_node term_node ON node.vid = term_node.vid 
										LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
										WHERE (users_roles.rid = 3) AND (node.status = 1) AND (node.uid = %d) 
										AND (node.type in ("weibo")) AND ((term_data.name) = ("新品")) 
										ORDER BY node_created DESC LIMIT 0 , 10';//活动1条
	  	  $results = db_query($sql,$account->uid);
				while($row = db_fetch_array($results)){
		      $news_nids [] = $row['nid'];
		    }
				$count=0;
				if($news_nids){
				foreach ($news_nids as $activity_nid) {
						if($count==4)break;
						$activity_node = node_load($activity_nid);
						if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							<li>
								<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-News-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-News-image-link')));?>
								<br />
			          <p><?php echo l($activity_node->title,"node/$activity_node->nid")?></p>
			          <div class="pubInfo">
			          				          	
			          	<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>			          	
          	 · 
			          	<?php 
				          	$taxonomys = $activity_node->taxonomy;
										foreach($taxonomys as $key=>$obj){
											if($obj->vid==2){//v2 == 微博类型
												$taxonomy_name=$obj->name;
												$taxonomy_id = 		$obj->tid;	
											}
										}
										echo l("分享($share_counts)","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
									?>
			          	<?php
			          		echo flag_create_link('bookmarks', $activity_node->nid);
		        			?></div>
			        </li>
							<?php
						}
				}}else{
      	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
      }
  		?>

      </ul>
    </div>
    <div class="more right">
    	<?php echo l('更多',"News/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?>
    </div>
  </div>
  <!--新品结束-->
  <div class="tm_sale">
       <!--特卖开始-->
    <div class="sale_tm">
      <div class="sale_tit">[特卖]
      <?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布特卖','new/4',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>	
			</div>
       <div class="tm_con">
			 <?php
				$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
										INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
										LEFT JOIN term_node term_node ON node.vid = term_node.vid 
										LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
										WHERE (users_roles.rid = 3) AND (node.status = 1) AND (node.uid = %d) 
										AND (node.type in ("weibo")) AND ((term_data.name) = ("特卖")) 
										ORDER BY node_created DESC LIMIT 0 , 10';//活动1条
	  	  $results = db_query($sql,$account->uid);
				while($row = db_fetch_array($results)){
		      $sale_nids [] = $row['nid'];
		    }
				if($sale_nids){
					foreach ($sale_nids as $sale_nid) {
							$sale_node = node_load($sale_nid);
							if($weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'])break;
					}
					$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$sale_node->nid AND  `cid` =0";
					$share_counts = db_result(db_query($share_sql));

	  	?>
        <ul>
          <li>
          	
          	<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-Sell-image'), $getsize = TRUE),"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'tm_cpimg Seller-Sell-image-link')));?>
						<div class="bk_cmt">
							<div class="wb_bk01 bor_top">
								<div class="fb_time">
									<P><?php echo sina_vp_time_format($sale_node->created)?></P>
								</div>
								<div class="fbbk_nr">
									<div class="fb_yh"><?php echo l($sale_node->name,"UCenter/0/$sale_node->uid"); ?> <cite>[特卖]</cite></div>
									<div class="wb_nr">
										<div class="userPic">
											
											<?php 
											echo l(theme('imagecache', 'small_picture', $sale_node->picture, $sale_node->name, $sale_node->name, array('class'=>'Seller-Sell-picture')),"UCenter/0/$sale_node->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-follow-link')));?>
											
										</div>
										<div class="msgBox_bk">
											<div class="msgCnt">
												<?php echo l($sale_n,"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-content')));  ?>
											</div>
										</div>
									</div>
									<div class="pubInfo">
									<?php echo l("点评($sale_node->comment_count)","node/$sale_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>			          	
			          	 · 
			          	<?php 
				          	$taxonomys = $sale_node->taxonomy;
										foreach($taxonomys as $key=>$obj){
											if($obj->vid==2){//v2 == 微博类型
												$taxonomy_name=$obj->name;
												$taxonomy_id = 		$obj->tid;	
											}
										}
										echo l("分享($share_counts)","forward/$taxonomy_id/$sale_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
									?>
			          	<?php
			          		echo flag_create_link('bookmarks', $sale_node->nid);
			      			?>	
									</div>
								</div>
							</div>
						</div>
					</li>
        </ul><?}else{
        	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
        }?>
      </div>
      
	    <div class="more right">
	    	<?php echo l('更多',"Sale/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?>
	    </div>
      <!--特卖结束-->
    </div>
    <!--爆款开始-->
    <div class="sale_bk">
      <div class="sale_tit">[爆款]
			<?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布爆款','new/3',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>	
    	</div>
       <div class="bk_con">
        
        	<?php
        		$sale_nids=array();			  		
						$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
										INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
										LEFT JOIN term_node term_node ON node.vid = term_node.vid 
										LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
										WHERE (users_roles.rid = 3) AND (node.status = 1) AND (node.uid = %d) 
										AND (node.type in ("weibo")) AND ((term_data.name) = ("爆款")) 
										ORDER BY node_created DESC LIMIT 0 , 10';//活动1条
	  	  		$results = db_query($sql,$account->uid);
						while($row = db_fetch_array($results)){
				      $sale_nids [] = $row['nid'];
				    }
						if($sale_nids){
							foreach ($sale_nids as $sale_nid) {
									$sale_node = node_load($sale_nid);
									if($weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'])break;
							}
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$sale_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
			  	?>
          <ul>
          	<li>
          	<?php 
          	echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-Sell-image'), $getsize = TRUE),"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'bk_cpimg Seller-Sell-image-link')));?>
          <div class="bk_cmt">      <div class="wb_bk01 bor_top">
        <div class="fb_time">
          <P><?php echo sina_vp_time_format($sale_node->created)?></P>
        </div>
        <div class="fbbk_nr">
          <div class="fb_yh"><?php echo l($sale_node->name,"UCenter/0/$sale_node->uid"); ?><cite>[爆款]</cite></div>
          <div class="wb_nr">
            <div class="userPic"> 
							<?php 
							echo l(theme('imagecache', 'small_picture', $sale_node->picture, $sale_node->name, $sale_node->name, array('class'=>'Seller-Sell-picture')),"UCenter/0/$sale_node->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-picture-link')));
							?>							
						</div>
            <div class="msgBox_bk">
              <div class="msgCnt">
							<?php echo l($sale_node->title,"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-content')));  ?>
							</div>
            </div>
          </div>
          <div class="pubInfo">
          	<?php echo l("点评($sale_node->comment_count)","node/$sale_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>			          	
          	 · 
          	<?php 
	          	$taxonomys = $sale_node->taxonomy;
							foreach($taxonomys as $key=>$obj){
								if($obj->vid==2){//v2 == 微博类型
									$taxonomy_name=$obj->name;
									$taxonomy_id = 		$obj->tid;	
								}
							}
							echo l("分享($share_counts)","forward/$taxonomy_id/$sale_node->nid/",array('attributes'=>array('class'=>'Seller-Sell-forward')));?>
          	
          	<?php
          		echo flag_create_link('bookmarks', $sale_node->nid);
      			?></div>
          </div>
        </div>
      </div></div></li>
      
        </ul>
        <?}else{
        	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
        }?>
      </div>
      <div class="more right">
	    	<?php echo l('更多',"Special/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?>
	    </div>
    </div>
    <!--爆款结束-->
  </div>
  <!--真人秀开始-->
  <div class="sale_active">
    <div class="sale_tit">[真人秀]    
    	<?php if( in_array('Buyer', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php 
    		$sql='select nid from node where uid=%d order by created desc limit 0,1';
				$first_nid =db_result(db_query($sql,$account->uid));
			  echo l('发布真人秀','new/6/'.$first_nid,array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>
    </div> 	  
    <div class="zrx_con bor_box">
      <ul>
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
								LIMIT 0 , 30";
	  		/*//跟粉丝无关，随便谁秀我的东东都显示在我的主页上。
				 * $my_follows=_get_my_follows($account->uid);
				foreach ($my_follows as $follow_uid => $value) {
					$follow_uids[] = $follow_uid;
				}
				$follow_uids = array_unique($follow_uids);
				$follow_uids = implode(",",$follow_uids);
	  		$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
										INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
										LEFT JOIN term_node term_node ON node.vid = term_node.vid 
										LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
										WHERE (users_roles.rid = 5) AND (node.status = 1) 
										AND (node.type in ("weibo")) AND ((term_data.name) = ("真人秀")) 
										ORDER BY node_created DESC LIMIT 0 , 10';//活动1条 AND (node.uid = %d) ,$account->uid AND n.uid in('.$follows_uid.') 
	  	 */	
	  	  $results = db_query($sql,$account->uid);
				$news_nids=array();
				while($row = db_fetch_array($results)){
		      $news_nids [] = $row['nid'];
		    }
				$count=0;
			//	echo '<pre>';print_r($sql);
				foreach ($news_nids as $activity_nid) {
						if($count==4)break;
						$activity_node = node_load($activity_nid);
						if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
							//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							//$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							
								<li>
									<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-show-little-image','width'=>'69','height'=>'111'), $getsize = FALSE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'bk_cpimg Seller-Show-image-link zrx-li','id'=>'zrx-'.$count))); ?>
								</li>	
				      
							<?php
						}
				}
  		?>
     </ul>
      <?php 
      	$count=0;
      	foreach ($news_nids as $activity_nid) {
					if($count==4)break;
					$activity_node = node_load($activity_nid);
					if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
						$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
						$share_counts = db_result(db_query($share_sql));
						$count++;
						if($count==1){
							 $display_class='current_zrx';
						}else{ $display_class='hidden';}
			?>
      <div class="zrx_switch zrx_big  <?php echo $display_class.' zrx-'.$count?>">
      	<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-show-little-image ','width'=>'411','height'=>'484'), $getsize = FALSE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'bk_cpimg Seller-Show-image-link'))); ?>
      </div>
      <div class="zrx_switch zrx_cmt <?php echo $display_class.' zrx-'.$count?>">
      	<div class="wb_zrx01 bor_top">
        <div class="fb_time">
          <P><?php echo sina_vp_time_format($activity_node->created)?></P>
        </div>
        <div class="fbzrx_nr">
          <div class="fb_yh"><?php echo l($activity_node->name,"UCenter/0/$activity_node->uid"); ?> <cite>[真人秀]</cite></div>
          <div class="wb_nr">
            <div class="userPic">
            	<?php 
							echo l(theme('imagecache', 'small_picture', $activity_node->picture, $activity_node->name, $activity_node->name, array('class'=>'Seller-Sell-picture')),"UCenter/0/$activity_node->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-picture-link')));
							?>	
						</div>
            <div class="msgBox_zrx">
              <div class="msgCnt">
              	<?php echo l($activity_node->title,"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-content')));?>
							</div>
            </div>
          </div>
          <div class="pubInfo">
						<?php echo l("点评($activity_node->comment_count)","node/$activity_node->nid/",array('fragment'=>'comment-form','attributes'=>array('class'=>'Seller-Sell-forward')));?>			          	
          	 · 
          	<?php 
	          	$taxonomys = $activity_node->taxonomy;
							foreach($taxonomys as $key=>$obj){
								if($obj->vid==2){//v2 == 微博类型
									$taxonomy_name=$obj->name;
									$taxonomy_id = 		$obj->tid;	
								}
							}
							echo l("分享($share_counts)","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
						?>
	        	<?php
	        		echo flag_create_link('bookmarks', $activity_node->nid);
	    			?>			          	
	        	
					</div>
					<div id="comments4shows" >
						 <?php if (function_exists('comment_render') && $activity_node->comment) {
						   //echo comment_render($activity_node, $cid);
						   	echo comment_form_box(array('nid' =>$sale_node->nid), '');
						  }
						?>
					</div>
       		
        </div>
      </div>
      </div>
      <?}}?>
      <? if(!$news_nids){
        	echo '<div class="SaleCenter none_info">还木有人在你家秀呢！</div>';
        }?>

    </div>
    <div class="more right">
	    	<?php echo l('更多',"Show/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?>
	  </div>
  </div>
  <!--真人秀结束-->
  <!--转让潮开始-->
  <div class="sale_active">
    <div class="sale_tit">[转让潮]
    <?php if( in_array('Buyer', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php     		
    		echo l('发布转让','new/5/'.$first_nid,array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>
    </div> 	    
    <div class="zr_con"><ul>      
      			<?php //10个中取4个带图片的。 && zid-uid=user
	  		//$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE `sina_vp_type` =5 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  //$results = db_query($sql);
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
								LIMIT 0 , 30";
				$results = db_query($sql,$account->uid);
				$news_nids=array();
				while($row = db_fetch_array($results)){
		      $news_nids [] = $row['nid'];
		    }
				$count=0;
				if($news_nids)
				foreach ($news_nids as $activity_nid) {
						if($count==4)break;
						$activity_node = node_load($activity_nid);
						if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
							//$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							//$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
					
							<li>
								<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-show-little-image ','width'=>'230','height'=>'282'), $getsize = FALSE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Show-image-link'))); ?>
								<div class="pubInfo">
				          	<?php echo l("点评(".$activity_node->comment_count.")","node/$activity_node->nid",array('fragment'=>'comments')); ?>		          	
				          	 · 
				          	<?php $taxonomys = $activity_node->taxonomy;
													foreach($taxonomys as $key=>$obj){
														if($obj->vid==2){//v2 == 微博类型
															$taxonomy_name=$obj->name;
															$taxonomy_id = 		$obj->tid;	
														}
													}
													echo l("分享($share_counts)","forward/$taxonomy_id/$activity_node->nid",array('attributes'=>array('class'=>'Seller-Sell-forward')));
									 ?>
				          	<?php
				          		echo flag_create_link('bookmarks', $activity_node->nid);
			        			?>
		        		</div>							
							</li>
						
							<?php
						}
				}
  		?></ul>
       <? if(!$news_nids){
        	echo '<div class="SaleCenter none_info">还木有人转让你的东东幺！</div>';
        }?>
    </div>
    <div class="more right">
	    	<?php echo l('更多',"Transfer/$account->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-more','target'=>'_blank'))); ?>
	  </div>
  </div>
  <!--转让潮结束-->
</div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>