<?php

function selectBox($result, $id, $name){
        $arr = [];
        foreach ($result as $key => $val) {
            $arr[$val->$id] = $val->$name;
        }
        return $arr;
}

function is_empty($object) {
    return !isset($object) || empty($object) ;
}

function val($object,$default = null) {
    return !is_empty($object) ? $object : $default;
}

function paramsUrl($searchParams) {
    $arr = [];
    foreach ($searchParams as $key => $val) {
       if (!is_empty($val)) {
          $arr[$key] = $val;
       }
    }
    return $arr;
}

function diffForHumansText($string) {
 
     if (strrpos($string, 'second ago')) {
        $string= str_replace('second ago', '秒', $string);
    }

    if (strrpos($string, 'seconds ago')) {
        $string= str_replace('seconds ago', '秒前', $string);
    }

    if (strrpos($string, 'minute ago')) {
        $string = str_replace('minute ago', '分前', $string);
    }

    if (strrpos($string, 'minutes ago')) {
        $string = str_replace('minutes ago', '数分前', $string);
    }

    if (strrpos($string, 'hour ago')) {
        $string = str_replace('hour ago', '1時間前', $string);
    }

    if (strrpos($string, 'hours ago')) {
        $string = str_replace('hours ago', '時間前', $string);
    }

    if (strrpos($string, 'day ago')) {
        $string = str_replace('day ago', '前日', $string);
    }

    if (strrpos($string, 'days ago')) {
        $string = str_replace('days ago', '日前', $string);
    }

    if (strrpos($string, 'week ago')) {
        $string = str_replace('week ago', '一週間前', $string);
    }

    if (strrpos($string, 'weeks ago')) {
        $string = str_replace('weeks ago', '先週', $string);
    }

    if (strrpos($string, 'month ago')) {
        $string = str_replace('month ago', 'ひと月前', $string);
    }

    if (strrpos($string, 'months ago')) {
        $string = str_replace('months ago', '先月', $string);
    }

    if (strrpos($string, 'year ago')) {
        $string = str_replace('year ago', '一年前', $string);
    }

    if (strrpos($string, 'years ago')) {
        $string = str_replace('years ago', '数年前', $string);
    }

    return $string;
}
function encode_token($privatekey,$userid,$token){
		$string=base64_encode($userid."|".$token);
		$string2=base64_encode($privatekey.$string);
		return urlencode(base64_encode($string."|".md5($string2)));
		
	}
function encode_token2($privatekey,$userid,$publickey,$accesstoken){
	
		$string=base64_encode($userid."|".$publickey."|".$accesstoken);
		$string2=base64_encode($privatekey.$string);
		return urlencode(base64_encode($string."|".md5($string2)));
}
	
function decode_token($privatekey,$encodekey){
		$encodekey=urldecode($encodekey);
		$endcode = explode("|",base64_decode($encodekey));
		
		
		
		$string2md=$endcode[1];
		
		
		
		$string=$endcode[0];
		$udecode=explode("|",base64_decode($string));
		$userid=$udecode[0];
		$token=$udecode[1];
		
		if (md5(base64_encode($privatekey.$string))==$string2md){
			
			return array('uid'=>$userid,'token'=>$token,'validate'=>true);
			}else{
			return array('validate'=>false);
		}	
	}

function password2Hash($plainText) {
    $out = hash('sha256', $plainText,true);
    return base64_encode($out);
}

function minusDay($date, $minus) {
    return date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " - ".$minus." days"));
}