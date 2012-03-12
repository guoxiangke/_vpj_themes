<?php
/*

?>
<div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ' '. $status; print ' '. $zebra; ?>">

  <div class="clear-block">
  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
	<div class="submitted"><?php print $submitted; ?></div>
  <?php endif; ?>



  <?php if ($comment->new) : ?>
    <span class="new"><?php print drupal_ucfirst($new) ?></span>
  <?php endif; ?>

  <?php print $picture ?>

    <h3><?php print $title ?></h3>

    <div class="content">
      <?php print $content ?>
      <?php if ($signature): ?>
      <div class="clear-block">
        <div>—</div>
        <?php print $signature ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($links): ?>
    <div class="links"><?php print $links ?></div>
  <?php endif; ?>
</div>
<?
*/
?>
					<div class="logi_box">
						<div class="mjvp-content-child-news-nr">
						    <div class="mjcontent-child-news-nr-img">
								<?php  // width="50" height="50"									
									$grey = drupal_get_path('module', 'sina_vp_imagetool').'/images/grey.gif';
									imagecache_generate_image('35x35',  $comment->picture);
									$path = imagecache_create_path('35x35', $comment->picture);
									//print theme('imagecache', 'preset_namespace', $image_filepath, $alt, $title, $attributes);
					      	echo  theme('imagecache', '35x35', $grey, '', '', array('class'=>'lazy','data-original'=>'/'.$path),false) ;
								?>
							</div>
							<div class="mjcontent-child-news-nr-body">
			                    <div class="mjcontent-child-news-nr-title"><span style="color:#0078b6;"><?php print $submitted; ?>：</span>  <?php print $content ?>
								<div class="mjcontent-child-news-nr-tm">

									<div class="mjhhf">回复</div>
								</div>
							</div>
						</div>
					</div>
					</div>
