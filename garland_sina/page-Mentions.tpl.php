<?php
	/*
	 **/ if($uid=arg(1)){//其他人访问的买家页面 UCenter/0/3
		$account=user_load($uid);
		if($page_uid=$account->uid){
			//存在被访问用户
		}else{$account=$user;}
	}else 
	{$account=$user;}
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
<body class="vp_mentions">
<div class="top UCenter_buyer">
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
	<a class="nav tag_dq" href="<?php echo url('UCenter/0/'.$page_uid)?>">@提到我的</a>    
</div>
<?php
	print $content;

?>
		<script type="text/javascript">
			function toggleit(nid){
					//$('#Wrap_'+nid).toggle(1000);
				
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
			
		</script>

</div>

<div class="buy_right"> 
	<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
</div>
<div class="clear"></div>
	<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
  <?php print $closure ?>
</body>
</html>