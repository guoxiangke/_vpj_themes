<?php
/* 
 * 买家看到的卖家各个频道里的卖家信息。。。
 * <div class="top">
 * 	<?php include(path_to_theme().'/vp_page-top.tpl.php');?>
 * </div>
 */
?>
<div id="vpfankui">
<?php 
	$title = '<img alt="反馈" src="http://image3.qqvoice.com:8181/website/image/feeback_liuyan.jpg">	';
	echo l($title,'node/303',array('html'=>ture,'attributes'=>array('target'=>'_blank','title'=>'找茬有奖')));
?>
</div>
<style type="text/css">
#vpfankui {
    float: right;
    height: 109px;
    position: fixed;
    right: 0;
    top: 50%;
    width: 40px;
}
</style>