<?php
//copy form page-UCenter-Seller.tpl.php 卖家新品展示页
 if($uid=arg(1)){//其他人访问的买家页面 UCenter/0/3
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
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body id="News">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>

<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
  <div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>转让潮</p></div>
	<?php include(path_to_theme().'/vp_page-Saler_top.tpl.php');?>
	<!--转让潮开始-->
  <div class="sale_active">
    <div class="sale_tit">[转让潮]</div>
    <div class="zr_con">
      <ul>
      		<?php //10个中取4个带图片的。 && zid-uid=user
	  		//$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE `sina_vp_type` =5 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
	  	  //$results = db_query($sql);
	  	  	
				if(arg(1)==''){ //ALL News
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
								
								)
								AND sina.`sina_vp_type` =5 AND sina.`cid` =0 
								ORDER BY sina.`created_at` DESC
								LIMIT 0 , 30";
					$results = db_query($sql);
				}else{ // A Seller's Activity
						$sql="SELECT  DISTINCT sina.nid
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
								AND sina.`sina_vp_type` =5 AND sina.`cid` =0 
								ORDER BY sina.`created_at` DESC
								LIMIT 0 , 30";
		  	  $results = db_query($sql,$account->uid);
				}
				$results = db_query($sql,$account->uid);
				$news_nids=array();
				while($row = db_fetch_array($results)){
		      $news_nids [] = $row['nid'];
		    }
				$count=0;
				if($news_nids)
				foreach ($news_nids as $activity_nid) {
						//if($count==4)break;
						$activity_node = node_load($activity_nid);
						if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath']){							
							$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
							$share_counts = db_result(db_query($share_sql));
							$count++;
							?>
							<li>
								<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-show-little-image ','width'=>'230','height'=>'282'), $getsize = FALSE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Show-image-link'))); ?>
								<br />
			          <p>
			          	<?php
			          	echo l($activity_node->title,"node/$activity_node->nid");
			          	?>
								</p>
			          <div class="pubInfo">
			          		<?php $taxonomys = $activity_node->taxonomy;
												foreach($taxonomys as $key=>$obj){
													if($obj->vid==2){//v2 == 微博类型
														$taxonomy_name=$obj->name;
														$taxonomy_id = 		$obj->tid;	
													}
												}
										 ?>
								 		<span class="vp_add_link zf_node">
								      <?php 
								      	echo l("点评($activity_node->comment_count)","node/$activity_node->nid", array('fragment'=>'comment-form'));
									      echo ' · '; 
												echo l("分享($share_counts)","forward/$taxonomy_id/$activity_node->nid"); 
								      ?>
							      </span>  
			          	
			          	<?php
			          		echo flag_create_link('bookmarks', $activity_node->nid);
		        			?>
		        		</div>
							</li>
							<?php
						}
				}
  		?>
        <? if(!$news_nids){
        	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
        }?>
        </ul>
    </div>
  </div>
  <!--转让潮结束-->
</div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>