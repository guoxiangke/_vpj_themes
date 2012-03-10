<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
   <!--link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/bootstrap.css"-->
   <link rel="stylesheet" type="text/css" href="<?php echo drupal_get_path('theme', 'vp')?>/layout.css">
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
<body id='VCenter'>
	<div class="top">
	   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
	
	</div>
<div class="vp_content">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
	<div class="VCenter">
		<div class='VCenter-top'><p id='VCenter_title' class='VCenter-nav'>店铺街</p></div>
		<?php			
				//订阅最多
	$sql='SELECT `requestee_id` FROM `user_relationships` where `rtid`=2  group by `requestee_id` order by count(1) desc limit 0,6';
	$results = db_query($sql);
	$count =6;
	$output.='<div class="shoplist"><div class="list_title"><h3>订阅最多</h3></div>';
	while($row = db_fetch_array($results)){
		$account = user_load($row['requestee_id']);		
		if($account->picture==''){$account->picture='sites/default/files/users/0.gif';}
		$output.='<div class="shop"><div class="shop-pic"><a href="'.url("UCenter/0/$account->uid").'"><img width="120px" height="120px" src="'.$account->picture.'"/></a></div><div class="shop-name"><a href="'.url("UCenter/0/$account->uid").'">'.$account->name.'</a></div></div>';
		$count--;
	}
	while ($count--) {		
		$output.='<div class="shop"><div class="shop-pic"><img width="120px" height="120px" title="loveshome的头像" alt="loveshome的头像" src="http://dev.weipujie.com/sites/default/files/users/picture-18.jpg"></div><div class="shop-name">loveshoneloveshoneloveshoneloveshone</div></div>';
	}
	$output.='<div class="clear"></div></div>';
	
	//最新加入 views
	$sql='select u.uid uid from users u  INNER JOIN users_roles users_roles ON u.uid = users_roles.uid
	 WHERE (users_roles.rid = 3) AND (u.status <> 0) order by created desc limit 0,6';
	$results = db_query($sql);
	$count =6;
	$output.='<div class="shoplist"><div class="list_title"><h3>最新加入</h3></div>';
	while($row = db_fetch_array($results)){
		$account = user_load($row['uid']);	
		if($account->picture==''){$account->picture='sites/default/files/users/0.gif';}	
		$output.='
		<div class="shop">
			<div class="shop-pic">
				<a href="'.url("UCenter/0/$account->uid").'">
					<img width="120px" height="120px" src="'.$account->picture.'"/>
					
				</a>
			</div>
			<div class="shop-name"><a href="'.url("UCenter/0/$account->uid").'">'.$account->name.'</a>
			</div>
		</div>';
		$count--;
	}
	while ($count--) {		
		$output.='<div class="shop"><div class="shop-pic"><img width="120px" height="120px" title="loveshome的头像" alt="loveshome的头像" src="sites/default/files/users/picture-18.jpg"></div><div class="shop-name">loveshone</div></div>';
	}
	//$output.=views_embed_view($name='new_Vshop', $display_id = 'default');
	$output.='<div class="clear"></div></div>';
	
	//最活跃
	$sql='select n.uid uid from node n  INNER JOIN users_roles users_roles ON n.uid = users_roles.uid
 WHERE (users_roles.rid = 3)  group by n.uid order by count(1) desc limit 0,6';
	$results = db_query($sql);
	$count =6;
	$output.='<div class="shoplist"><div class="list_title"><h3>最活跃</h3></div>';
		while($row = db_fetch_array($results)){
		$account = user_load($row['uid']);
		if($account->picture==''){$account->picture='sites/default/files/users/0.gif';}
		$output.='<div class="shop"><div class="shop-pic"><a href="'.url("UCenter/0/$account->uid").'"><img width="120px" height="120px" src="'.$account->picture.'"/></a></div><div class="shop-name"><a href="'.url("UCenter/0/$account->uid").'">'.$account->name.'</a></div></div>';
		$count--;
	}
	while ($count--) {		
		$output.='<div class="shop"><div class="shop-pic"><img width="120px" height="120px" title="loveshome的头像" alt="loveshome的头像" src="sites/default/files/users/picture-18.jpg"></div><div class="shop-name">loveshoneloveshoneloveshoneloveshone</div></div>';
	}
	$output.='<div class="clear"></div></div>';
	print $output;
	//print $content;
		?>
	</div>
</div>

<div class="clear"></div>
	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>