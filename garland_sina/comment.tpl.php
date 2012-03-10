<?php
if($pid=$comment->pid){ //对回复的回复处理
	$parent_comment = _comment_load($pid);
};
if(1){?>
	<div rel="<?php echo $comment->cid?>" class="clear" id="<?php echo $comment->cid?>">
    <div class="fbcom_nr">
      <div class="wb_nr">
        <div class="userPic"> 
        	<img width="38" height="38" src="<?php print $comment->picture?$comment->picture:'/sites/default/files/users/0.gif'; ?>"></div>
        <div class="msgBox402">
          <!--div class="fbcom_yh">
           
          </div-->
          <div class="msgCnt">
          	<?php 
          		echo l("$comment->registered_name","UCenter/0/$comment->uid");
							echo '说：';
          		if($comment->pid){
	          		//echo '回复'.l("@$parent_comment->name","UCenter/0/$parent_comment->uid").':';
	          	} 
	          	print $content;
          	?>
          	<span class="new"><?php //print $new ?></span>
          	</div>
           <div class="pubInfo"><span class="copy_time"><?php print date('m月d日 H:i',$comment->timestamp); ?></span>
           	<span class="right">  <?php if ($links): ?>
					    <div class="links"><?php print $links ?></div>
					  	<?php endif; ?>
					  </span></div>
        </div>
      </div>
    </div><div class='clear'></div>
   </div><div class='clear'></div>
<?}else{
?>
<div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ' '. $status; print ' '. $zebra; ?>">

  <div class="clear-block">
  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
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
<?php }?>