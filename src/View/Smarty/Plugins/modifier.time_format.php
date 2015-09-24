<?php
function smarty_modifier_time_format($string, $format, $movetime = null) {
	if ($string == null) {
		return "－";
	}
	
	if (!is_numeric($string)){
        if ($movetime) {
            $string = strtotime($string." ".$movetime);
        } else {
            $string = strtotime($string);
        }
	}
	return date($format, $string);
}
