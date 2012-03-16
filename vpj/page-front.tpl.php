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
	
    <?php print $scripts ;?> 
   
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
    <script>
    	Drupal.behaviors.front = function (context) {
       /* if($(".form-text").attr("value")!=''){
  				var label = $(".form-text").prev();	
					label.css("display") == "none" || label.hide();
				}
    		$(".form-text").focus(function(){
					var input = $(this);
					var label = input.prev();					 				
						label.css("display") == "none" || label.hide();					 
					}).blur(function(){
					var input = $(this);
					var label = input.prev();
					if(input.attr("value")==''){
					label.css("display") == "block" || label.show();
					}
				});
				 ///////
				$.fx.speeds._default = 1000;
				$('#user-login').hide().dialog({
					autoOpen:false,
					draggable: true,
 					title: '请您登录',
 					draggable: true,
 					show: "blind",
					hide: "explode",

});
   
				$('.login_link').click(function(){
    			$( "#user-login" ).dialog("open");
    			console.log('click');
    			return false;
    		});  */ 
    		
    $("#email_click input").attr('placeholder','邮箱');
    $("#pass_click input").attr('placeholder','密码');
    
    $("#edit-name-wrapper input").attr('placeholder','邮箱');
    $("#edit-pass-wrapper input").attr('placeholder','密码');
    $("#edit-captcha-response-wrapper input").attr('placeholder','请输入验证码');
    
    $("#edit-submit").hide();
    $("#modal-submit").click(function(){
    			$("#edit-submit").click();
    			$('#loginModal').modal('hide')
    		}); 
    
												
   // $('.login_link').attr('data-toggle','modal').attr('href','#loginModal');
   $("#loginModal").dialog({   
		        autoOpen: false,   
		        draggable: true,
		        modal: true, 
		        title: '请您登录',
			});
		$("#edit-vpj-register-links").click(function(){
				
				window.location='/?q=enter_regcode';
		});
    $('.login_link').click(function(e){
			e.preventDefault();//阻止默认提交
    	console.log('click');
    	$("#loginModal").dialog("open");
    	$("#edit-submit").show();
    });
    	}
    </script>
  </head>
<body id="front" class="vp_front">
<div id="header-region" class="vp-clear-block">
	<?php include (path_to_theme() . '/vp_page-top.tpl.php');?>
</div>

<div class="vp-body">
  <div class="vp-body-inner">
		<div class="invp-body-min">
			<?php if( $messages ) :?>
				<div class="messages status">
				<?php print $messages; ?>
				</div>
			<?php endif; ?>
			<div class="vp-body-left">  	
					<?php print $content ?>
			</div>
			<div class="con_right">
					<?php if ($right): ?>
							
							<?php print $right ?>
					<?php endif; ?>	    
			</div>
		</div>
	</div>
</div>
<div id="footer" class="footer"><?php print $footer_message . $footer ?></div>
</body>
</html>