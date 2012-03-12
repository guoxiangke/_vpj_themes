<?php
/* 
 * 导航条
 */
?>
    <div class="header-inner">
        <div class="logo">
        	<a href="http://<?php echo $_SERVER['HTTP_HOST']?>"><img src="/<?php echo path_to_theme()?>/images/logo.gif"/></a>
        </div>
        <div class="site_name">
            <div class="vpj-name"><?php  print '<a href="'. check_url($front_page) .'">'.  check_plain($site_name) .'</a>';?></div>
            <div class="vpj-wz"><?php  print '<a href="'. check_url($front_page) .'">'.  check_plain($site_slogan) .'</a>';?></div>           
        </div>
    <?php 
    if($user->uid){
    	?> 
    	<div class="navigation">
            <ul>
                <li class="vpjnav"><?php echo l('首页','UCenter');?></li>
                <li class="vpjnav"><?php echo l('我的主页','UCenter/0/'.$user->uid);?></li>
                <li class="vpjnav"><?php echo l('店铺街','VCenter');?></li>
                <li class="vpjnav"><?php echo l('广场','plaza');?></li>
            </ul>
        </div>   	
			<div class="user-xx">
			    <div class="user-img">
			    	<?php
			    				if(!$user->picture)
										$user->picture = variable_get(user_picture_default, '/sites/default/files/users/0.gif');
									imagecache_generate_image('35x35',  $user->picture);
									$pic_path = imagecache_create_path('35x35', $user->picture);
									
									//print theme('imagecache', 'preset_namespace', $image_filepath, $alt, $title, $attributes);
					      	echo  theme('imagecache', '35x35', $pic_path, $user->name, '') ; //title alt
			    	?>
			    </div>
				<div class="user-name"><p><?php echo $user->name;?>&nbsp;</p><img src="/<?php echo path_to_theme()?>/images/sajiao.png" /></div>
			</div>
    	<?php
    }else{
    	?> 
    	<div class="navigation">
            <ul>
                <li class="vpjnav"><?php echo l('首页','#',array('attributes'=>array('class'=>'login_link')));?></li>
                <li class="vpjnav"><?php echo l('店铺街','#',array('attributes'=>array('class'=>'login_link')));?></li>
                <li class="vpjnav"><?php echo l('广场','#',array('attributes'=>array('class'=>'login_link')));?></li>
            </ul>
        </div>   	

    	<?php
    }?>
    <?php
    	if($user->uid){
    		?>
				<div class="xllist">
					<div class="listlpic">
						<div class="listlpicc">
							<div class="listvp-user-op-cz"><?php echo l('修改','user_info/'.$user->uid,array('attributes'=>array('target'=>'_blank')))?></div>
							<div class="listvp-user-op-cz"><?php echo l('退出','logout')?></div>
						</div>
					</div>
				</div>
    		<?
    	}
    ?>		
		<div class="search">
		    <input  id="vp_search" type="text" value=""  class="stext">
			<!--<a href="javascript:void(0)" class="sbt"></a>-->
		</div>
    </div>
    
   <?php
   /**
    * 
  
  <div class="logo"><a href="<?php echo url('UCenter');?>" title="首页"><img src="<?php echo check_url($logo)?>" width="93" height="92" /></a></div>
  <div class="ad_talk"><img src="<?php echo drupal_get_path('theme', 'vp')?>/images/ad_talk.jpg" width="92" height="31" /></div>
  <div class="top_line"></div>
  	<?php if (isset($primary_links)&&!drupal_is_front_page()) : ?>
    <div class="navigation primary_links">      <?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
    </div>
    	<?php 
    	if(arg(0)!='new'){
    		?>
    		<a id="go-top" href="#top">
				<span class="top-btn"><span class="sj">♦</span><span class="fk">▐</span>返回顶部</span>
				</a>
				
    	<?php
    	}
    	?>
    	
    <?php include(path_to_theme().'/vp_page-suggest-float.tpl.php');?>
    <?php endif; ?>

<?php if (isset($secondary_links)) : ?>
  <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
<?php endif;
  */ ?>

