<?php 


/**
 * Calculate differences between two dates with precise semantics. Based on PHPs DateTime::diff()
 * implementation by Derick Rethans. Ported to PHP by Emil H, 2011-05-02. No rights reserved.
 * 
 * See here for original code:
 * http://svn.php.net/viewvc/php/php-src/trunk/ext/date/lib/tm2unixtime.c?revision=302890&view=markup
 * http://svn.php.net/viewvc/php/php-src/trunk/ext/date/lib/interval.c?revision=298973&view=markup
 */

function _date_range_limit($start, $end, $adj, $a, $b, &$result)
{
    if ($result[$a] < $start) {
        $result[$b] -= intval(($start - $result[$a] - 1) / $adj) + 1;
        $result[$a] += $adj * intval(($start - $result[$a] - 1) / $adj + 1);
    }

    if ($result[$a] >= $end) {
        $result[$b] += intval($result[$a] / $adj);
        $result[$a] -= $adj * intval($result[$a] / $adj);
    }

    return $result;
}

function _date_range_limit_days(&$base, &$result)
{
    $days_in_month_leap = array(31, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $days_in_month = array(31, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    _date_range_limit(1, 13, 12, "m", "y", $base);

    $year = $base["y"];
    $month = $base["m"];

    if (!$result["invert"]) {
        while ($result["d"] < 0) {
            $month--;
            if ($month < 1) {
                $month += 12;
                $year--;
            }

            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;
        }
    } else {
        while ($result["d"] < 0) {
            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;

            $month++;
            if ($month > 12) {
                $month -= 12;
                $year++;
            }
        }
    }

    return $result;
}

function _date_normalize(&$base, &$result)
{
    $result = _date_range_limit(0, 60, 60, "s", "i", $result);
    $result = _date_range_limit(0, 60, 60, "i", "h", $result);
    $result = _date_range_limit(0, 24, 24, "h", "d", $result);
    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    $result = _date_range_limit_days($base, $result);

    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    return $result;
}

/**
 * Accepts two unix timestamps.
 */
function _date_diff($one, $two)
{
    $invert = false;
    if ($one > $two) {
        list($one, $two) = array($two, $one);
        $invert = true;
    }

    $key = array("y", "m", "d", "h", "i", "s");
    $a = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $one))));
    $b = array_combine($key, array_map("intval", explode(" ", date("Y m d H i s", $two))));

    $result = array();
    $result["y"] = $b["y"] - $a["y"];
    $result["m"] = $b["m"] - $a["m"];
    $result["d"] = $b["d"] - $a["d"];
    $result["h"] = $b["h"] - $a["h"];
    $result["i"] = $b["i"] - $a["i"];
    $result["s"] = $b["s"] - $a["s"];
    $result["invert"] = $invert ? 1 : 0;
    $result["days"] = intval(abs(($one - $two)/86400));

    if ($invert) {
        _date_normalize($a, $result);
    } else {
        _date_normalize($b, $result);
    }

    return $result;
}

function format_interval($interval) {
    $result = "";
	$counted=0;
    if (floor($interval[y])!=0 && $counted<=2) {
		$result .= $interval[y]." ".getlang("ปี::l::years"); 
		$counted=$counted+2;
	}
    if (floor($interval[m])!=0 && $counted<=2) { 
		$result .= " ".$interval[m]." ".getlang("เดือน::l::months");
		$counted=$counted+2;
	} 
    if (floor($interval[d])!=0 && $counted<=2) { 
		$result .= " ".$interval[d]." ".getlang("วัน::l::days"); 
		$counted=$counted+1;
	} 
    if (floor($interval[h])!=0 && $counted<=2) { 
		$result .= " ".$interval[h]." ".getlang("ชั่วโมง::l::hours"); 
		$counted=$counted+1;
	} 
    if (floor($interval[i])!=0 && $counted<=2) {
		$result .= " ".$interval[i]." ".getlang("นาที::l::minutes");
		$counted=$counted+1;
	} 
    if (floor($interval[s])!=0 && $counted<=2) { 
		$result .= " ".$interval[s]." ".getlang("วินาที::l::seconds"); 
		$counted=$counted+1;
	} 

	$result=trim($result);
	/*if ($interval[invert]==1) {
		$result=getlang("อีก ".$result."::l::next ".$result);
	} else {
		$result=getlang("".$result." ที่แล้ว::l::".$result." ago");
	}*/
    return $result;
}

//$date = "1986-11-10 19:37:22";

//print_r(_date_diff(strtotime($date), time()));
function ymd_ago($timestamp,$tp1="อีก %::l::next %",$tp2="%ที่แล้ว::l::% ago"){

	global $thaidaystr;
   //printr($thaidaystr);
   $dayiduse=date("w",$timestamp);
   //echo $dayiduse;
   //echo jddayofweek(0);;
   $dayiduse=$dayiduse-jddayofweek(0);
	$now=time();
	if (($now-$timestamp)<15 && ($now-$timestamp)>=0) {
		return getlang("ไม่กี่วินาทีที่แล้ว::l::few seconds ago");
	}
	$interval=_date_diff($timestamp, time());
	//printr($interval);
	$result = format_interval($interval);
	$result_final=str_replace("%",$result,$tp);

	//humanize 
   //printr($thaidaystr);
   
	if ($interval[invert]==1) {
		if ($interval[days]>=2 && $interval[days]<7) {
			return getlang("วัน".$thaidaystr[$dayiduse]."::l::".$thaidaystr[$dayiduse]);
		}
		if ($interval[days]>=7 && $interval[days]<13) {

         //$dayiduse=$dayiduse-1;
         //if ($dayiduse==-1) $dayiduse=6;
         //echo $dayiduse;
			return getlang("วัน".$thaidaystr[$dayiduse]."หน้า::l::next ".$thaidaystr[$dayiduse]);
		}
	} else {
		if ($interval[days]>=2 && $interval[days]<7) {

         //$dayiduse=$dayiduse-1;
         //if ($dayiduse==-1) $dayiduse=6;      
			return getlang("วัน".$thaidaystr[$dayiduse]."ที่ผ่านมา::l::last ".$thaidaystr[$dayiduse]);
		}

	}

	if ($interval[invert]==1) {
		$tp1=getlang($tp1);
		$result_final=str_replace("%",$result,$tp1);
	} else {
		$tp2=getlang($tp2);
		$result_final=str_replace("%",$result,$tp2);
	}
	
	return $result_final;
}

/*
function ymd_ago($timestamp){
	if ($timestamp==0) {
		return "-";
	}
   $difference = time() - $timestamp;
   if ($difference<=60) {$difference=0;}
   if ($difference<=20 && $difference>=0) {
		return getlang("ไม่กี่วินาทีที่แล้ว::l::few seconds ago");
   }
   //humanize within 14 day (2 weeks max)

   $periods = array(getlang("วินาที::l::seconds"), getlang("นาที::l::minutes"), getlang("ชั่วโมง::l::hours"), getlang("วัน::l::days"), getlang("สัปดาห์::l::weeks"), getlang("เดือน::l::months"), getlang("ปี::l::years"), "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   //if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ".getlang("ที่แล้ว::l::ago");
   return $text;
  }
  */
?>