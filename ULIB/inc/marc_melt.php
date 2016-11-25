<?php  //พ
function marc_melt($ID,$isremindi="no") {
	global $r_2;
	global $r_3;
	global $r_4;
	global $r_5;
	global $r_6;
	global $r_7;
	global $r_8;
	global $r_9;
	global $r_10;
	global $r_11;
	global $r_12;
	global $r_13;
	global $r_14;
	global $r_15;
	global $r_16;
	global $r_17;
	global $r_18;
	global $r_19;
	global $r_20;
	global $r_21;
	global $r_22;
	global $r_23;
	global $r_24;
	global $r_25;
	global $r_26;
	global $r_27;
	global $r_28;
	global $r_29;
	global $r_30;
	global $r_31;
	global $r_32;
	global $r_33;
	global $r_34;
	global $r_35;

	$sql = "select * from media where ID='$ID' ";
	$result = tmq($sql);
	if (tmq_num_rows($result)==0) {
		//echo "<B>Media ID='$ID' not found!</B> ";
		return;
	}

	$raw = tmq_fetch_array($result);


	//marcdspmod s
if (strtolower(barcodeval_get("isenablemarcdspmod"))!="no") {
	$marcdspmods=tmq("select * from marcdspmod_main");
	while ($marcdspmodr=tfa($marcdspmods)) {
		marcdspmod_recalitemrule($marcdspmodr[id]);
		$marcdspmodchk=marcdspmod_getsql($marcdspmodr[id]);
		$marcdspmodchk=tmq($marcdspmodchk." and ID='$ID' ",false);
		if (tnr($marcdspmodchk)==1) {
			//echo "match";
			$raw=marcdspmod_apply($raw,$marcdspmodr[id]);
		}
	}
}
	//marcdspmod e

	while (list($key, $val) = each($raw)) {
		//echo "'$key' => $val<BR>";
		if ($indi[$key]=="YES") {
			$r[$key]=substr($raw[$key],2);
			$tmp=$r[$key];
		} else {
			$r[$key]=$raw[$key];
			$tmp=$r[$key];
		}
		$r["$key"."_num"]=count(explodenewline($tmp));
		$loopmulti=explodenewline($tmp);
		$countloop=0;
		foreach ($loopmulti as $loopmulti_key => $loopmulti_value) {
			$countloop++;
			$usekey="";
			if ($countloop>1) {
				$usekey="_$countloop";
			}
			$loopmulti_indicator=substr($loopmulti_value,0,2);
			if ($isremindi!="no") {
				$loopmulti_value=substr($loopmulti_value,2);
			}
			$tmp=marc_getsubfields($loopmulti_value);

			$tmpkey2="$key"."_indi";
			@eval("\$r$usekey"."[$tmpkey2]=\$loopmulti_indicator;");

			//printr($tmp);
			foreach ($tmp as $key2 => $value2) {
				//echo "$key<BR>";
				if (trim($value2)!="" && !is_numeric("$key")) {
					$tmpkey="$key"."_$key2";
					$tmpkey=trim($tmpkey,':');
					//echo "[$tmpkey]<BR>";
					@eval("\$r$usekey"."[$key]=\$loopmulti_value;");
					@eval("\$r$usekey"."[$tmpkey]=\$value2;");
					//echo("\$r$usekey"."[$tmpkey]=$value2;");
					//echo("\$r$usekey"."[$key]=\$loopmulti_value;");
				}
			}
		}

	}

	//printr($r);
	return $r;
}
?>