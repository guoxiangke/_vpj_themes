<?php
	if($user->uid){
		drupal_goto('UCenter');
	}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/vp-front.css">
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <script>
    	Drupal.behaviors.front = function (context) {
    		$('#content a').attr("title",'请登录'); 
    		
    	}
    </script>
  </head>
<body id="front">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>
<div class="content" id="content">
  <div class="con_left">
    <div class="ad"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/ad01.jpg" width="628" height="120" /></div>
    <div class="wblist pad10" id="outCont">
    <ul>
    <?php 
			
			//滚动内容：6条卖家微博 3条一组，第一条为 活动，其他随机。
			$first_sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
			INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
			LEFT JOIN term_node term_node ON node.vid = term_node.vid 
			LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
			WHERE (users_roles.rid = 3) AND (node.status = 1) 
			AND (node.type in ("weibo")) AND ((term_data.name) = ("活动")) 
			ORDER BY node_created DESC LIMIT 0 , 1';//活动1条
			$second_sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
			INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
			LEFT JOIN term_node term_node ON node.vid = term_node.vid 
			LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
			WHERE (users_roles.rid = 5) AND (node.status = 1) 
			AND (node.type in ("weibo")) AND ((term_data.name) = ("真人秀")) 
			ORDER BY node_created DESC LIMIT 0 , 1';//真人秀1条
			$last_sql='SELECT node.nid AS nid, node.created AS node_created FROM node node  
			INNER JOIN users_roles users_roles ON node.uid = users_roles.uid 
			LEFT JOIN term_node term_node ON node.vid = term_node.vid 
			LEFT JOIN term_data term_data ON term_node.tid = term_data.tid 
			WHERE (users_roles.rid = 3) AND (node.status = 1) 
			AND (node.type in ("weibo")) AND ((term_data.name) != ("活动")) 
			ORDER BY node_created DESC LIMIT 0 , 9';//其他活动4条
								
			$show_nid[]=db_result(db_query($first_sql));
			$show_nid[]=db_result(db_query($second_sql));
			$result = db_query($last_sql);
			while($value = db_fetch_array($result)){
				 $show_nid[]=$value['nid'];
			}
			foreach($show_nid as $nid) {
				$node = node_load($nid);
				$account = user_load($node->uid);
				$taxonomys = $node->taxonomy;
				foreach($taxonomys as $key=>$obj){
					$taxonomy_name=$obj->name;
				}
		?><li>
      <div class="wb_01 bor_top">
        <div class="fb_time">          
          <?php //<P>59分钟前</P>
								if($time_show = sina_vp_time_format($node->created)){
								
									echo $time_show;
								}else{
									echo '<p>'.date('Y-m-d',$node->created).'</p>';
									echo '<p>'.date('H:i',$node->created).'</p>';
								}
					?>
        </div>
        <div class="fb_nr">
          <div class="fb_yh">
          	<a href="user/login" class="popups login_link">
          	<?php echo $account->name ?></a> <cite>[<?php echo $taxonomy_name?>]</cite></div>
          <div class="wb_nr">
            <div class="userPic"><a href="user/login" class="popups login_link"> <img src="<?php echo $account->picture?>" width="50" height="50" /></a></div>
            <div class="msgBox">
              <div class="msgCnt"><?php echo $node->title?></div>
            </div>
          </div>
        </div>
      </div></li>
      <?php } ?></ul>
      <script type="text/javascript">
				function slideDown(ContId,interTime,speed)
				{
					var d = document,isFirst=true;
					var contOut = d.getElementById(ContId);
					var ul = contOut.getElementsByTagName("ul")[0];		
					var intval,timeOut,sInterval;
					function run(){
						
						clearInterval(intval);			
						intval = setInterval(function(){				
							var li = contOut.getElementsByTagName("li");
							var liNum = li.length;								
							var tempLi = li[liNum-1].cloneNode(true);
							var tHeight = li[liNum-1].offsetHeight;				
							ul.insertBefore(tempLi,li[0]);
							ul.style.top= -tHeight+"px";
							var runDown = function(){
								clearInterval(sInterval);
								sInterval = setInterval(function(){						
									var uTop = parseInt(ul.offsetTop);
									if(Math.abs(uTop)>1){
										var top = Math.abs(parseInt(ul.offsetTop));
										ul.style.top = -(top - Math.ceil(top/20))+"px";		
										//ul.style.top = -(top-1)+"px";								
									}else{
										ul.style.top = 0+"px";								
										clearInterval(sInterval);							
									}
								},speed);
								ul.removeChild(li[liNum]);						
							}
							runDown();
						},interTime);
					}
					run();
					function stop(){
						clearInterval(intval);			
					}
					contOut.onmouseover = function(){
						stop();			
					}
					contOut.onmouseout = function(){		
						run();			
					}
				}
				slideDown("outCont",6000,10);
			</script>	
			<style type="text/css">				
				#outCont{position:relative;overflow:hidden;margin:0 auto;}
				#outCont ul{position:absolute;} 
			</style>
    </div>
  </div>
  <div class="con_right">
  	  <?php if ($right): ?>
        <div class="login_box bor_box mar_btm10">
          <?php if (!$left && $search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
          <?php print $right ?>
        </div>
      <?php endif; ?>
    <div class="vp_in bor_box">
      <div class="vp_tit1 pad_w10">他们在微铺</div>
      <div class="vp_in_con">
        	<?php 
								//9个人 前6个卖家 后3个买家
								//1.评论最多的卖家
							$Buyer_query = "SELECT COUNT(*) AS count, c.uid, u.name FROM {comments} c 
													INNER JOIN {users_roles} users_roles ON c.uid = users_roles.uid 
												  LEFT JOIN {users} u ON c.uid = u.uid 
												  WHERE  (users_roles.rid = 3) AND c.uid != 0 AND c.uid != 1 
													GROUP BY c.uid ORDER BY count DESC LIMIT 0,1";
						 	$Seller_query = "SELECT COUNT(*) AS count, c.uid, u.name FROM {comments} c 
													INNER JOIN {users_roles} users_roles ON c.uid = users_roles.uid 
												  LEFT JOIN {users} u ON c.uid = u.uid 
												  WHERE  (users_roles.rid = 5) AND c.uid != 0 AND c.uid != 1 
												  GROUP BY c.uid ORDER BY count DESC LIMIT 0,1";
							$result = db_query($Buyer_query);
							while($value = db_fetch_array($result)){
											 $show_B_uid[]=$value['uid'];
								}
							$result = db_query($Seller_query);
							while($value = db_fetch_array($result)){
								 $show_S_uid[]=$value['uid'];
							}	
							//2,发布节点最多的hot_user				
							$Buyer_query_node = "SELECT COUNT(*) AS count, n.uid FROM {node} n 
													INNER JOIN {users_roles} users_roles ON n.uid = users_roles.uid 
												  LEFT JOIN {users} u ON n.uid = u.uid 
												  WHERE  (users_roles.rid = 3) AND n.uid not in(0,1,".implode(',',$show_B_uid).")
												  GROUP BY n.uid ORDER BY count DESC LIMIT 0,3";
							$Seller_query_node = "SELECT COUNT(*) AS count, n.uid FROM {node} n 
													INNER JOIN {users_roles} users_roles ON n.uid = users_roles.uid 
												  LEFT JOIN {users} u ON n.uid = u.uid 
												  WHERE  (users_roles.rid = 5) AND n.uid not in(0,1,".implode(',',$show_S_uid).")
												  GROUP BY n.uid ORDER BY count DESC LIMIT 0,3";
							$result = db_query($Buyer_query_node);
							while($value = db_fetch_array($result)){
								 $show_B_uid[]=$value['uid'];
							}
							$result = db_query($Seller_query_node);
							while($value = db_fetch_array($result)){
								 $show_S_uid[]=$value['uid'];
							}
							//dpm($show_B_uid);dpm($show_S_uid);
								
								$show_numbers = 9;
								foreach($show_S_uid as $uid) { break;
									$account = user_load($uid);
									--$show_numbers;
								?>
								 <div class="yh01">
								 	<a id="login_link_<?=$show_numbers?>" href="user/login<?php //echo $account->uid?>" class="popups-form login_link">
								 		<img src="<?php echo $account->picture?>" width="47" height="47" title="<?php echo $account->name?>"  /></a><br />
					          <p><a href="user/login<?php //echo $account->uid?>" class="popups login_link"><?php echo $account->name?></a></p>
					       </div>
								<? } 
								foreach($show_B_uid as $uid) {
									$account = user_load($uid);
									--$show_numbers;
								?>
								 <div class="yh01"> 	
								 	<a id="login_link_<?=$show_numbers?>" href="user/login<?php //echo $account->uid?>" class="popups-form-reload login_link">
								 	<img src="<?php echo $account->picture?>" width="47" height="47" title="<?php echo $account->name?>"  /></a><br />
					          <p><a  href="user/login<?php //echo $account->uid?>" class="popups login_link"><?php echo $account->name?></a></p>
					       </div>
								<? }
								while($show_numbers){
										--$show_numbers;
								?>			
					      <div class="yh01">
					      		<a href="user/login" class="popups login_link">
					      			<img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /></a><br />
				          <p><a href="user/login" class="popups login_link">蔡卓妍</a></p>
				        </div>
								<?php	}
								?>
      </div>
    </div>
  </div>
</div>

<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
</body>
</html>