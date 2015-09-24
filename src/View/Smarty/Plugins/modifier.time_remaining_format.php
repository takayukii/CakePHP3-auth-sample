<?php

function smarty_modifier_time_remaining_format ( $time )
{ 
	$unix   = strtotime($time);
    $now    = time();
    $diff_sec   = $unix - $now;

    if($diff_sec < 60){
        $time   = $diff_sec;
        $time   .= "秒後";
    }
    elseif($diff_sec < 3600){
        $time   = $diff_sec / 60;
        $time   .= "分";
		$time   .= $diff_sec % 60;
		$time   .= "秒後";
    }
    elseif($diff_sec < 86400){
        $time   = (int)($diff_sec/3600);
        $time   .= "時間";
		$time   .= (int)($diff_sec % 3600 / 60);
		$time   .= "分";
		$time   .= (int)($diff_sec % 3600 % 60);
		$time   .= "秒後";
    }
    elseif($diff_sec < 2764800){
        $time   = $diff_sec/86400;
        $unit   = "日後";
    }
    else{
        if(date("Y") != date("Y", $unix)){
            $time   = date("Y年n月j日", $unix);
        }
        else{
            $time   = date("n月j日", $unix);
        }

        return $time;
    }

    return $time;
} 

?>