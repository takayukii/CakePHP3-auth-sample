<?php
function smarty_modifier_percent_format($value, $length = 0) {
	return number_format(round($value * 100, $length), $length, ".", "");
}
