<?php
function smarty_modifier_week_format($string) {
	if ($string == null) {
		return "";
	}
    
    $weekjp_array = array('日', '月', '火', '水', '木', '金', '土');
	
	return $weekjp_array[date("w", strtotime($string))];
}
