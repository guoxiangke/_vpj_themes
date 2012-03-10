<?php
/**
 *  如果没有输入注册码，跳出输入表单
 *  写在block:display_regcode
 * 	可以删除
 */
global $user;
if (!regcode_user_load() && $user -> uid) {
	//如果没有输入注册码，跳出输入表单
	$output .= '<div class="hidden" id="regcode-voucher-show">' . drupal_get_form('regcode_voucher') . '</div>';
	echo $output .= ' <script>
    	Drupal.behaviors.front = function (context) {    		 
    			dialog("请输入内测邀请码","id:regcode-voucher-show","500px","auto","id");  	    		   	
    	}
    </script>';
}
?>