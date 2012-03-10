<?php
	/*发布页
	 **/
	{$account=$user;}
	if(in_array('Buyer',$account->roles)){	//对于卖家		
			//return '亲，您貌似来到了禁区～！^_^';
	}
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
<body id="page_new">
<div class="top">
   <?php include(path_to_theme().'/vp_page-top.tpl.php');?>
</div>
<div class="vp_content_ucenter UCenter">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
<div class="buy_left">
<div class="fl_nav">
	<?php switch (arg(1)) {
		case '1':
			$tag_dq_1 = 'tag_dq';
			break;
		case '2':
			$tag_dq_2 = 'tag_dq';
			break;
		case '3':
			$tag_dq_3 = 'tag_dq';
			break;	
		case '4':
			$tag_dq_4 = 'tag_dq';
			break;
		case '5':
			$tag_dq_5 = 'tag_dq';
			break;	
		case '6':
			$tag_dq_6 = 'tag_dq';
			break;
		default:
			$tag_dq = 'tag_dq';
			break;
	}

	?>
	<a class="nav <?php echo $tag_dq  ?>" href="<?php echo url('UCenter/0/'.$page_uid)?>">全部</a>    
	<a class="nav <?php echo $tag_dq_1?>" href="<?php echo url('UCenter/1/'.$page_uid)?>">新品</a>    
	<a class="nav <?php echo $tag_dq_3?>" href="<?php echo url('UCenter/3/'.$page_uid)?>">爆款</a>    
	<a class="nav <?php echo $tag_dq_4?>" href="<?php echo url('UCenter/4/'.$page_uid)?>">特卖</a>    
	<a class="nav <?php echo $tag_dq_2?>" href="<?php echo url('UCenter/2/'.$page_uid)?>">活动</a>    
	<a class="nav <?php echo $tag_dq_6?>" href="<?php echo url('UCenter/6/'.$page_uid)?>">真人秀</a>    
	<a class="nav <?php echo $tag_dq_5?>" href="<?php echo url('UCenter/5/'.$page_uid)?>">转让潮</a></div>
<?php
	if(arg(1)==5||arg(1)==6){
		
		$account = user_load(node_load(arg(2))->uid);//$root_user
		?>
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
   
  </div>
  
		<?php
	}	
	print $content;
	if(arg(1)==5||arg(1)==6){
		?> <div class="bgz clear-block">
        <p><?php echo l('被订阅('.$follow_counts.')',"relationships/follows/$account->uid",array('attributes'=>array('class'=>"user-action",'target'=>'_blank')));?></p>
        <p>您的真人秀将显示在俺滴首页上哦～</p>     
 	 </div>
 	 <?php
	}
	{$account=$user;}
?>
 		<script src="<?php echo drupal_get_path('module', 'sina_vp')?>/js/gotop.js" type="text/javascript"></script>
	  <link href="<?php echo drupal_get_path('module', 'sina_vp')?>/css/gotop.css" type="text/css" rel="stylesheet">
		<a id="go-top" href="#top">
		<span class="top-btn"><span class="sj">♦</span><span class="fk">▐</span>返回顶部</span>
		</a>
		

</div>

<div class="buy_right"> 
	<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
</div>
<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>