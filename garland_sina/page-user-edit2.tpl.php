<?php
	{$account=$user;}

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
<div class="vp_content UCenter">
	<?php if( $messages ) : ?>
	<div class="messages status">
	<?php print $messages; ?>
	</div>
	<?php endif; ?>
<div class="buy_left">
<div class="fl_nav">
	<div class="fl_nav">
		<a class="nav tag_dq" href="<?php echo url('UCenter/0/'.$page_uid)?>">个人资料</a>
	</div>
<?php
	print $content;
	drupal_add_css(drupal_get_path('module', 'sina_vp') .'/css/scroll.css');
	drupal_add_js(drupal_get_path('module', 'sina_vp') .'/js/scroll.js');

?>
 		<script src="<?php echo drupal_get_path('module', 'sina_vp')?>/js/gotop.js" type="text/javascript"></script>
	  <link href="<?php echo drupal_get_path('module', 'sina_vp')?>/css/gotop.css" type="text/css" rel="stylesheet">
		<a id="go-top" href="#top">
		<span class="top-btn"><span class="sj">♦</span><span class="fk">▐</span>返回顶部</span>
		</a>
		<style>.hidden{display:none;}</style>
		<script type="text/javascript">
			function toggleit(nid){
					$('#Wrap_'+nid).toggle(1000);
			}
			function show_more(nid,Wrap_type,tid){//talkWrap comtWrap zfWrap
					//$('#Wrap_'+nid)
					var c = $('#Wrap_'+nid);
					c.toggle(1000);
					if (Wrap_type != 'comtWrap')
						$.ajax({
							url: 'http://dev.weipujie.com/?q=vp/comment_ajax/'+nid,
							type: 'POST',
							data: '',
							dataType: 'json',
						  success: function(json) {								
						  	c.html(json);
						  },
						  error: function(XMLHttpRequest, textStatus, errorThrown){
							alert('发生错误，请联系管理员1');
							}
						});
						//$('#Wrap_'+nid).load('http://dev.weipujie.com/?q=vp/comment_ajax/'+nid+' #comments');
						// if($('#'+Wrap).hasClass('hidden')){$('#'+Wrap).slideDown('1000').removeClass('hidden');}
					else 
						$('#Wrap_'+nid).load('http://dev.weipujie.com/?q=forward/'+tid+'/'+nid+'/ajax #node-form');  
						//$('#'+Wrap).slideUp('1000').addClass('hidden')				
						//alert('http://dev.weipujie.com/?q=forward/'+tid+'/'+nid+' #node-form');
			};
			/*$(document).ready(function() {
				$('.counts').find('.flag').one('click', function(){					
				  var $count_value = $(this).parent().parent().find('.count_value');
					console.log('count_value',$count_value);
				  var curValue = $count_value.html();
					console.log('curValue',curValue);
				  $count_value.html( parseInt(curValue) + 1 );
					$(this).one('click', function(){
				    //wirte func minus1() code..
				    var $count_value = $(this).parent().parent().find('.count_value');
					  var curValue = $count_value.html();
						console.log('4',curValue);
						if( parseInt(curValue)==1)
							$count_value.html("0");
					  else 
							$count_value.html( parseInt(curValue) - 1 );
				  });
				});
			});*/

			
		</script>

</div>

<div class="buy_right">
  <div class="mj_tx pad5">
    <dl>
      <img src="<?php echo $account->picture?>" width="100" height="100" />
      <dt><?php
				profile_load_profile(&$account);
			 echo $account->name.'<br/>'.$account->profile_location
			?></dt>
    </dl>
    <div class="mj_dy"><a href="<?php echo url('relationships/2')?>">订阅(<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=2),array("count" => TRUE));?>)</a><a href="<?php echo url('relationships/1')?>">关注(<?php echo user_relationships_load(array("requester_id" => $account->uid,"rtid" => $rtid=1),array("count" => TRUE));?>)</a><a href="<?php echo url('relationships')?>">粉丝(<?php echo user_relationships_load(array("requestee_id" => $account->uid),array("count" => TRUE));?>)</a></div>
  </div>
  <div class="lb_about pad5">
    <ul>
      <li><a class="tag" href="<?php echo url("user/$account->uid/mentions")?>">@提到我</a></li>
      <li><a href="#">我的点评</a></li>
      <li><a href="<?php echo url("user/$account->uid/messages")?>">我的私信</a></li>
    </ul>
  </div>
  <div class="vp_in">
    <div class="vp_tit1 pad_w10">我的粉丝</div>
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
			<div class="yh02"><a href="<?php echo url("UCenter/0/$account_realtionship->uid")?>" title="<?php echo $account_realtionship->name?>"><img src="<?php echo $account_realtionship->picture;?>" width="47" height="47" /></a><br />
        <p><a href="<?php echo url("UCenter/0/$account_realtionship->uid")?>"> <?php echo $account_realtionship->name?></a></p>
      </div>
			<?}
				while($show_numbers){
					--$show_numbers;
			?>			
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">王力宏</a></p>
      </div>
			<?php	}
			?>
    </div>
  </div>
  <div class="vp_in">
    <div class="vp_tit1 pad_w10">猜你喜欢</div>
    <div class="vp_in_con2">
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#"> 许建强 </a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">蔡卓妍</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">黄百鸣</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">晚晓利</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">张亚东</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">王力宏</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">指挥家王进</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">刘卓辉</a></p>
      </div>
      <div class="yh02"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/tx2.jpg" width="47" height="47" /><br />
        <p><a href="#">王洁实</a></p>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>

	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>