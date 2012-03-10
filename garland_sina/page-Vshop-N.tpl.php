<?php
	$Shoper = user_load(arg(1));
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
<body>
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>

<div class="vp_content">
  <div class="sale_sj">
    <div class="pp_jieshao">
      <dl>
        <p class="pp_logo"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/pp_logo.jpg" width="203" height="63" /></p>
        <dd>店铺介绍：ONLY大品牌是你不变的选择 </dd>
      </dl>
    </div>
    <div class="pp_gz">
      <div class="bgz">
        <p>被订阅(<?php echo user_relationships_load(array("requestee_id" => $Shoper->uid),array("count" => TRUE));?>)</p>
        <p class="gz_btn">
          <input name="" type="button" value="订阅" />
        </p>
      </div>
      <div class="fans">
      	<? $my_follows=_get_my_follows($Shoper->uid);
				$counts=4;
				foreach ($my_follows as $follow_uid => $value) {
					$follow_user = user_load($follow_uid);
					$counts--;
					if($counts){
						?>						
		        <div class="yh02"><img src="<?php echo $follow_user->picture?>" width="47" height="47" /><br />
		          <p><a href="#"> <?php echo $follow_user->name?> </a></p>
		        </div>
						<?php
					}
				}
      	?>
      </div>
    </div>
  </div>
  <div class="sale_active">
  	<?php
  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$Shoper->uid AND  `sina_vp_type` =2 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
  	  $results = db_query($sql);
			while($row = db_fetch_array($results)){
	      $activity_nids [] = $row['nid'];
	    }
			foreach ($activity_nids as $activity_nid) {
					$activity_node = node_load($activity_nid);
					if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'])break;
			}
			$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
			$share_counts = db_result(db_query($share_sql));
  	?>
    <div class="sale_tit">[活动]<span class="fb_btn"><a href="?q=new/2">发布活动</a></span></div>
    <div class="sale_con">
      <div class="sale_hd_pic"><img src="<?php echo $weibo_image_filepath?>" width="635" height="215" /></div>
      <div class="sale_hd_con">
        <dl>
          <dt>活动介绍：</dt>
          <dd><?php echo $activity_node->title?></dd>
        </dl>
        <div class="pubInfo">
        	<?php
        		echo flag_create_link('bookmarks', $activity_node->nid);//.'(<span class="count_value" id="counts_'.$activity_node->nid.'">'.sina_vp_flag_get_counts($activity_node->nid).'</span>) ·';
    				//<a href="#">喜欢(< ?php echo sina_vp_flag_get_counts($activity_node->nid)? >) · </a>
    			?>	
        	<a href="#">点评(<?php echo $activity_node->comment_count;?>) · </a>
        	<a href="#">分享(<?php echo $share_counts?>)</a></div>
      </div>
    </div>
    <div class="more right"><a href="#">更多</a></div>
  </div>
  <!--新品开始-->
  <div class="sale_active">
    <div class="sale_tit">[最新新品]<span class="fb_btn"><a href="?q=new/1">发布新品</a></span></div>
     <div class="xp_con">
      <ul>
     	<?php //10个中取4个带图片的。
	  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$Shoper->uid AND  `sina_vp_type` =1 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  $results = db_query($sql);
				while($row = db_fetch_array($results)){
		      $news_nids [] = $row['nid'];
		    }
				$count=0;
				foreach ($news_nids as $activity_nid) {
						if($count==4)break;
						$activity_node = node_load($activity_nid);
						if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							<li><img src="<?php echo $weibo_image_filepath?>" width="220" height="357" /><br />
			          <p><a href="?=node/<?php echo $activity_node->nid?>"><?php echo $activity_node->title?></a></p>
			          <div class="pubInfo">
			          	<?php
			          		echo flag_create_link('bookmarks', $activity_node->nid);//.'(<span class="count_value" id="counts_'.$activity_node->nid.'">'.sina_vp_flag_get_counts($activity_node->nid).'</span>) ·';
		        				//<a href="#">喜欢(< ?php echo sina_vp_flag_get_counts($activity_node->nid)? >) · </a>
		        			?>			          	
			          	<a href="#">点评(<?php echo $activity_node->comment_count;?>) · </a>
			          	<a href="#">分享(<?php echo $share_counts?>)</a></div>
			        </li>
							<?php
						}
				}
  		?>

      </ul>
    </div>
    <div class="more right"><a href="#">更多</a></div>
  </div>
  <!--新品结束-->
  <div class="tm_sale">
       <!--特卖开始-->
    <div class="sale_tm">
      <div class="sale_tit">[特卖]<span class="fb_btn"><a href="#">发布特卖产品</a></span></div>
       <div class="tm_con">
			 <?php
	  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$Shoper->uid AND  `sina_vp_type` =4 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  $results = db_query($sql);
				while($row = db_fetch_array($results)){
		      $sale_nids [] = $row['nid'];
		    }
				foreach ($sale_nids as $sale_nid) {
						$sale_node = node_load($sale_nid);
						if($weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'])break;
				}
				$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$sale_node->nid AND  `cid` =0";
				$share_counts = db_result(db_query($share_sql));
	  	?>
        <ul>
          <li><a class="tm_cpimg" href="#"><img src="<?php echo $weibo_image_filepath?>" width="193" height="313" /></a>
						<div class="bk_cmt">
							<div class="wb_bk01 bor_top">
								<div class="fb_time">
									<P><?php echo sina_vp_time_format($sale_node->created)?></P>
								</div>
								<div class="fbbk_nr">
									<div class="fb_yh"><a href="#"><?php echo $sale_node->name?></a> <cite>[爆款]</cite></div>
									<div class="wb_nr">
										<div class="userPic"> <img src="<?php echo $sale_node->picture?>" width="50" height="50" /></div>
										<div class="msgBox_bk">
											<div class="msgCnt"><a href="node/<?php echo $sale_node->nid?>"><?php echo $sale_node->title?></a></div>
										</div>
									</div>
									<div class="pubInfo">
									<?php
          		echo flag_create_link('bookmarks', $sale_node->nid);//.'(<span class="count_value" id="counts_'.$sale_node->nid.'">'.sina_vp_flag_get_counts($sale_node->nid).'</span>) ·';
      				//<a href="#">喜欢(< ?php echo sina_vp_flag_get_counts($sale_node->nid)? >) · </a>
      			?>			          	
          	<a href="#">点评(<?php echo $sale_node->comment_count;?>) · </a>
          	<a href="#">分享(<?php echo $share_counts?>)</a>
									</div>
								</div>
							</div>
						</div>
					</li>
        </ul>
      </div>
      <div class="more right"><a href="#">更多</a></div>
      <!--特卖结束-->
    </div>
    <!--爆款开始-->
    <div class="sale_bk">
      <div class="sale_tit">[爆款]<span class="fb_btn"><a href="?q=new/3">发布爆款</a></span></div>
       <div class="bk_con">
        <ul>
        	<?php
        		$sale_nids=array();
			  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$Shoper->uid AND  `sina_vp_type` =3 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
			  	  $results = db_query($sql);
						while($row = db_fetch_array($results)){
				      $sale_nids [] = $row['nid'];
				    }
						foreach ($sale_nids as $sale_nid) {
								$sale_node = node_load($sale_nid);
								if($weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'])break;
						}
						$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$sale_node->nid AND  `cid` =0";
						$share_counts = db_result(db_query($share_sql));
			  	?>
          <li><a class="bk_cpimg" href="#"><img src="<?php echo $weibo_image_filepath?>" width="193" height="313" /></a>
          <div class="bk_cmt">      <div class="wb_bk01 bor_top">
        <div class="fb_time">
          <P><?php echo sina_vp_time_format($sale_node->created)?></P>
        </div>
        <div class="fbbk_nr">
          <div class="fb_yh"><a href="#"><?php echo $sale_node->name?></a> <cite>[爆款]</cite></div>
          <div class="wb_nr">
            <div class="userPic"> <img src="<?php echo $sale_node->picture?>" width="50" height="50" /></div>
            <div class="msgBox_bk">
              <div class="msgCnt"><a href="node/<?php echo $sale_node->nid?>"><?php echo $sale_node->title?></a></div>
            </div>
          </div>
          <div class="pubInfo">
          	<?php
          		echo flag_create_link('bookmarks', $sale_node->nid);//.'(<span class="count_value" id="counts_'.$sale_node->nid.'">'.sina_vp_flag_get_counts($sale_node->nid).'</span>) ·';
      				//<a href="#">喜欢(< ?php echo sina_vp_flag_get_counts($sale_node->nid)? >) · </a>
      			?>			          	
          	<a href="#">点评(<?php echo $sale_node->comment_count;?>) · </a>
          	<a href="#">分享(<?php echo $share_counts?>)</a></div>
          </div>
        </div>
      </div></div></li>
        </ul>
      </div>
      <div class="more right"><a href="#">更多</a></div>
    </div>
    <!--爆款结束-->
  </div>
  <!--真人秀开始-->
  <div class="sale_active">
    <div class="sale_tit">[真人秀]</div>
    <div class="zrx_con bor_box">
      <ul>
      <?php //10个中取4个带图片的。 && zid-uid=user
	  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE `sina_vp_type` =6 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  $results = db_query($sql);
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
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							<li><a href="?q=node/<?php echo $activity_node->nid?>"><img src="<?php echo $weibo_image_filepath?>" width="69" height="111" /></a></li>
							<?php
						}
				}
  		?>
      </ul>
      <div class="zrx_big"><a href="#"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/zrx_big.jpg" /></a></div>
      <div class="zrx_cmt">      <div class="wb_zrx01 bor_top">
        <div class="fb_time">
          <P>59分钟前</P>
        </div>
        <div class="fbzrx_nr">
          <div class="fb_yh"><a href="#">loveshome</a> <cite>[爆款]</cite></div>
          <div class="wb_nr">
            <div class="userPic"> <img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx.jpg" width="50" height="50" /></div>
            <div class="msgBox_zrx">
              <div class="msgCnt">这是个140字的微博示例啊，每天成千上万的互联网帐号存在被盗的风险，你知道自己帐号的安全状况么，请立即查看»每天成千上万的互联网帐号存在被盗的风险，你知道自己帐号的安全状况么，请立即查看»每天成千上万的互联网帐号存在被盗的风险，你知道自己帐号的安全状况么，请立即查看»每天成千上万的互联 </div>
            </div>
          </div>
          <div class="pubInfo"><a href="#">喜欢(12) · </a><a href="#">点评(24) · </a><a href="#">分享(36)</a></div>
                <div class="talkWrap210 comtWrap zfWrap210">
        <div class="com_nr"> <!--<span class="left"> <span class="number cNote"> 评论 <i class="l"></i> 原文， <a target="_blank" onclick="MI.Bos('btnComtView')" href="#"> 共111条评论 <i class="l"></i> <em class="ffsong">&gt;&gt;</em> </a> </span> <span class="replyTitle"></span> <span class="addReply"> <a href="#">[清空评论]</a> </span> </span>--> <a class="close" title="关闭" href="#">关闭</a> </div>
        <div class="cont">
          <textarea id="" class="inputTxt" name="" padding="2" style="overflow-y: hidden; height: 35px; width:200px;"></textarea>
          
          <div class="bot"><input class="dp_btn" type="button" value="点评" />
          </div>
        </div>
            </div>
        </div>
      </div></div>
    </div>
    <div class="more right"><a href="#">更多</a></div>
  </div>
  <!--真人秀结束-->
  <!--转让潮开始-->
  <div class="sale_active">
    <div class="sale_tit">[转让潮]</div>
    <div class="zr_con">
      <ul>
      		<?php //10个中取4个带图片的。 && zid-uid=user
	  		$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE `sina_vp_type` =5 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  $results = db_query($sql);
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
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							<li><a href="?q=node/<?php echo $activity_node->nid?>"><img src="<?php echo $weibo_image_filepath?>" width="230" height="282" /></a></li>
							<?php
						}
				}
  		?>
      </ul>
    </div>
    <div class="more right"><a href="#">更多</a></div>
  </div>
  <!--转让潮结束-->
</div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>