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
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body id="Show">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>

<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
  <div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>真人秀</p></div>
	<?php include(path_to_theme().'/vp_page-Saler_top.tpl.php');?>
   <!--真人秀开始-->
    <div class="sale_tm sale_tm_list">
      <div class="sale_tit">[真人秀]
      <?php if( in_array('Seller', $user->roles) ) : ?>
    	<span class="fb_btn">
    		<?php echo l('发布特卖','new/4',array('attributes'=>array('class'=>'Seller-new-item')));?>
    	</span>
    	<?php endif; ?>	
			</div>
       
			 <?php
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
								WHERE sina.`sina_vp_type` =6
								ORDER BY  `created_at` DESC
								)
								
								)
								AND sina.`sina_vp_type` =6 AND sina.`cid` =0 
								ORDER BY  sina.`created_at` DESC
								LIMIT 0 , 30";
					$results = db_query($sql);
				}else{ // A Seller's Activity
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
								AND sina.`sina_vp_type` =6 AND sina.`cid` =0
								ORDER BY  sina.`created_at` DESC
								LIMIT 0 , 30";
		  	  $results = db_query($sql,$account->uid);
				}
				while($row = db_fetch_array($results)){
		      $sale_nids [] = $row['nid'];
		    }
	  	?>
       
        	<?php
        	foreach ($sale_nids as $sale_nid) {
						$sale_node = node_load($sale_nid);
						//if($weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'])break;
						$weibo_image_filepath=$sale_node->field_weibo_image['0']['filepath'];
						$share_sql = "SELECT count(*) FROM  {sina_vp_weibo2node} WHERE  `zid` =$sale_node->nid AND  `cid` =0";
						$share_counts = db_result(db_query($share_sql));
					?>
           <ul><li>
          	<div class="tm_con">
          	<?php 
          		if(!$weibo_image_filepath){
          			//echo $sale_node->nid ;
          		//	echo db_result(db_query("SELECT zid FROM  {sina_vp_weibo2node} WHERE  `nid` =$sale_node->nid AND  `cid` =0"));
          			$root_node = node_load(db_result(db_query("SELECT zid FROM  {sina_vp_weibo2node} WHERE  `nid` =$sale_node->nid AND  `cid` =0 ")));
          			$weibo_image_filepath = $root_node->field_weibo_image['0']['filepath'];
          		}
          		 echo l(theme_image($weibo_image_filepath, '', '',array('class'=>'Seller-Sell-image'), $getsize = TRUE),"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'tm_cpimg Seller-Sell-image-link')));?>
						<div class="bk_cmt">
							<div class="wb_bk01 bor_top">
								<div class="fb_time">
									<P><?php echo sina_vp_time_format($sale_node->created)?></P>
								</div>
								<div class="fbbk_nr">
									<div class="fb_yh"><?php echo l($sale_node->name,"UCenter/0/$sale_node->uid"); ?> <cite>[真人秀]</cite></div>
									<div class="wb_nr">
										<div class="userPic">
											<?php 
											echo l(theme('imagecache', 'small_picture', $sale_node->picture, $sale_node->name, $sale_node->name, array('class'=>'Seller-Sell-picture')),"UCenter/0/$sale_node->uid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-follow-link')));
											?>
										</div>
										<div class="msgBox_bk">
											<div class="msgCnt">
												<?php echo l(truncate_utf8($sale_node->title, 90, $wordsafe = FALSE, $dots = TRUE),"node/$sale_node->nid",array('html'=>TRUE,'attributes'=>array('class'=>'Seller-Sell-content')));?>
											</div>
										</div>
									</div>
									<div class="pubInfo">												          	
				          	 <span class="vp_add_link zf_node">
								      <?php 
								      	echo l("点评($sale_node->comment_count)","node/$sale_node->nid", array('fragment'=>'comment-form'));
									      echo ' · '; 
												echo l("分享($share_counts)","forward/6/$sale_node->nid"); 
								      ?>
							      </span>  
				          	<?php
				          		echo flag_create_link('bookmarks', $sale_node->nid);
				      			?>	
									</div>
								</div>
								<div id="comments4shows_all">
								 <?php if (function_exists('comment_render') && $sale_node->comment) {
									  		//echo comment_render($sale_node, $cid);
									  		//echo comment_render_4vp($sale_node, $cid);
									  		echo comment_form_box(array('nid' =>$sale_node->nid), '');
									  }
									?>
								</div>
							</div>
						</div>
					</div></li>  </ul>
				<?php }?>
       
        <? if(!$sale_nids){
        	echo '<div class="SaleCenter none_info">这家伙很懒，暂无内容！当然，系统可以初始化一些静态的内容在这里～</div>';
        }?>
      <!--真人秀结束-->
    </div>   
  
</div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>