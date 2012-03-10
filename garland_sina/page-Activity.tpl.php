<?php
 if($uid=arg(1)){// Activity/%uid
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
<body id="Activity">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>

<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>活动</p></div>
	<?php endif; ?>
	<div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>活动</p></div>
	<?php include(path_to_theme().'/vp_page-Saler_top.tpl.php');?>
  <div class="sale_active">
  	<?php
  		//$sql="SELECT nid  FROM  `sina_vp_weibo2node` WHERE  `uid` =$account->uid AND  `sina_vp_type` =2 ORDER BY  `created_at` DESC  LIMIT 0 , 10";
  	  
			if(arg(1)==''){ //ALL Activity
				$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
				INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
				LEFT JOIN term_node term_node ON node.vid = term_node.vid 
				LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
				WHERE (users_roles.rid = 3) AND (node.status = 1)
				AND (node.type in ("weibo")) AND ((term_data.name) = ("活动")) 
				ORDER BY node_created DESC LIMIT 0 , 30';//活动30条
				$results = db_query($sql);
			}else{ // A Seller's Activity
				$sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
				INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
				LEFT JOIN term_node term_node ON node.vid = term_node.vid 
				LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
				WHERE (users_roles.rid = 3) AND (node.status = 1) AND (node.uid = %d) 
				AND (node.type in ("weibo")) AND ((term_data.name) = ("活动")) 
				ORDER BY node_created DESC LIMIT 0 , 30';//活动30条
	  	  $results = db_query($sql,$account->uid);
			}
			while($row = db_fetch_array($results)){
	      $activity_nids [] = $row['nid'];
	    }
  	?>
    <div class="sale_tit">[活动]
    	<?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布活动','new/2',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>
    </div>
    <?php 
    	if($activity_nids){	
    	foreach ($activity_nids as $activity_nid) {
					$activity_node = node_load($activity_nid);
					//if($weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'])break;
					$weibo_image_filepath=$activity_node->field_weibo_image['0']['filepath'];		
					$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$activity_node->nid AND  `cid` =0";
					$share_counts = db_result(db_query($share_sql));
		?>
    <div class="sale_con">
      <div class="sale_hd_pic">
      	<?php echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-activity-image'), $getsize = TRUE),"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-image-link')));?>
      </div>
      <div class="sale_hd_con">
        <dl>
          <dt>活动介绍：</dt>
          <dd><?php echo l($activity_node->title,"node/$activity_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-activity-content'))); echo $activity_node->uid; ?></dd>
        </dl>
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
      </div>
    </div>
    <?php }}else{
    	echo '<div class="SaleCenter_detail none_info">这家伙很懒，暂无内容！</div>';
    }//<div class="more right"><a href="#">更多</a></div>
    ?>
    
  </div>

</div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>