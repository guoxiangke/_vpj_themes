<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>  
    <?php print $scripts ?>
    
    <!--[if lt IE 7]>
      <?php print phptemplate_get_ie_styles(); ?>
    <![endif]-->
  </head>
	<body>
		<div id="header-region" class="vp-clear-block">
			<?php
			include (path_to_theme() . '/vp_page-top.tpl.php');
			?>
		</div>
		<div class="vp-body">
			<div class="vp-body-inner">
				<?php //if ($show_messages && $messages): print $messages; endif; ?>
	      <div class="mjvp-body-center"> 
					
					<div class="mjvp-body-left">
						<div class="mjvp-user-nav">
						<?php
							if(arg(0)=="UCenter" && 
								(count(arg())==1)||(count(arg())==2)){
									//UCenter
									//UCenter/0-6
								?>
								<li class="mjnav-user"><?php echo l('全部','UCenter');?></li>
								<li class="mjnav-user"><?php echo l('新品','UCenter/1');?></li>				
								<li class="mjnav-user"><?php echo l('活动','UCenter/2');?></li>
								<li class="mjnav-user"><?php echo l('爆款','UCenter/3');?></li>
								<li class="mjnav-user"><?php echo l('特卖','UCenter/4');?></li>
								<li class="mjnav-user"><?php echo l('真人秀','UCenter/6');?></li>
								<li class="mjnav-user"><?php echo l('转让潮','UCenter/5');?></li>		
								<?	
							}else{
								//UCenter/0-6/uid
								?>						
								<li class="mjnav-user"><?php echo l('全部','UCenter/0/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('新品','UCenter/1/'.$account->uid);?></li>				
								<li class="mjnav-user"><?php echo l('活动','UCenter/2/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('爆款','UCenter/3/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('特卖','UCenter/4/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('真人秀','UCenter/6/'.$account->uid);?></li>
								<li class="mjnav-user"><?php echo l('转让潮','UCenter/5/'.$account->uid);?></li>		
								<?
							}
						?>			
						</div>
						<div class="mjvp-contents">
						<?php print $content;	?>
						</div>
					</div>
					<div class="mjvp-body-right">
						<?php include(path_to_theme().'/vp_page-buy-right.tpl.php');?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		
		<div id="footer" class="footer">
			<?php print $footer_message . $footer
			?>
		</div>
		<?php print $closure
		?>
	</body>
</html>