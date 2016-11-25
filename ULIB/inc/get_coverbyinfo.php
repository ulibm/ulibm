<?php  //พ
function get_coverbyinfo($tags,$addhtml=" WIDTH='100'  border=1 style='border-color:black' hspace=0 vspace=0 ") { 
	global $dcrURL;
	global $newline;
	global $coverbyinfodb;
	global $coverbyinfodbcalled;

	if ($coverbyinfodbcalled!="yes") {
		$coverbyinfodb=tmq_dump2("coverbyinfo","id","name,req_isn,req_050,req_082,req_099,url,req_lang"," where isuse='yes' order by ordr");
		//printr($coverbyinfodb);
	}

	if (count($coverbyinfodb)==0) {
		$realres[html]=$res;
		$realres[ispass]="no";
		return $realres;
	}

	$coverbyinfodbcalled="yes";

	@reset($coverbyinfodb);
	$ispass="yes";
	while (list($k,$v)=@each($coverbyinfodb) ) {
   	$ispass="yes";
		//printr($v);
		if ($v[1]=='yes') {
			$tmp=trim(dspmarc(substr($tags[tag020],2)));
			$tmp.=trim(dspmarc(substr($tags[tag022],2)));
			$tmp.=trim(dspmarc(substr($tags[tag024],2)));
			if ($tmp=="") {
				$ispass="no";
			}
		}
		//echo "[$tmp]";
		//echo "[$ispass]";
		$v[2]=trim($v[2]);
		if ($v[2]!='') {
			$tmp=$tags[tag050];
			$tmp2=str_replace($v[2],'',$tmp);
			if ($tmp==$tmp2) {
				$ispass="no";
			}
		}
		$v[3]=trim($v[3]);
		if ($v[3]!='') {
			$tmp=$tags[tag082];
			$tmp2=str_replace($v[3],'',$tmp);
			if ($tmp==$tmp2) {
				$ispass="no";
			}
		}
		$v[4]=trim($v[4]);
		if ($v[4]!='') {
			$tmp=$tags[tag099];
			$tmp2=str_replace($v[4],'',$tmp);
			if ($tmp==$tmp2) {
				$ispass="no";
			}
		}
		//echo "[$ispass]";
		$v[6]=trim($v[6]);
		if ($v[6]!='') {
			$tmp=substr($tags[getval("MARC","fixedwidthfield")],35,3);
			$tmp=trim($tmp);
			//echo "[$tmp==$tmp2]";
			//printr($v);
			$tmp2=str_replace($v[6],'',$tmp);
			if ($tmp==$tmp2) {
				$ispass="no";
			}
		}
		if ($ispass=="yes") {
			$passkey=$k;
			break;
		}
		//printr($v);// echo "[ispass=$ispass]";
	}
	
	
	if ($ispass!="yes") {
		$realres[html]=$res;
		$realres[ispass]="no";
		return $realres;
	}
	//echo "[passkeyis=$passkey]";
	//printr($coverbyinfodb[$passkey]);
	//preparing url;
	$url=$coverbyinfodb[$passkey][5];
	$url=str_replace('[bibid]',$tags[ID],$url);
	$url=str_replace('[dcr]',$dcrURL,$url);
	$tmp=dspmarc(substr($tags[tag020],2)).$newline.dspmarc(substr($tags[tag022],2)).$newline.dspmarc(substr($tags[tag024],2));
	$tmp=explodenewline($tmp);
	$tmp=$tmp[0];
	$tmp=trim($tmp);
	$url=str_replace('[isn]',$tmp,$url);
	//echo "[$tmp]";
	$tmp=trim(dspmarc(substr($tags[tag099],2)));

	$db=explode(',','tag050,tag082,tag099');
	@reset($db);
	while (list($k,$v)=@each($db) ) {
		$url=str_replace("[$v]",$tmp,$url);
		$tmpx=strtolower($tmp);
		$url=str_replace("[$v"."_l]",$tmpx,$url);
		$tmpx=strtoupper($tmp);
		$url=str_replace("[$v"."_u]",$tmpx,$url);
		$tmpx=str_replace(" ","",$tmp);
		$url=str_replace("[$v"."_s]",$tmpx,$url);
		$tmpx=str_replace(" ","",$tmp);
		$tmpx=strtolower($tmpx);
		$url=str_replace("[$v"."_sl]",$tmpx,$url);
		$tmpx=str_replace(" ","",$tmp);
		$tmpx=strtoupper($tmpx);
		$url=str_replace("[$v"."_su]",$tmpx,$url);
		$tmpa=rem2space($tmp);
		$tmpa=explode(" ",$tmpa);
		$url=str_replace("[$v"."_a1]",$tmpa[0],$url);
		$tmpx=strtolower($tmpa[0]);
		$url=str_replace("[$v"."_a1l]",$tmpx,$url);
		$tmpx=strtoupper($tmpa[0]);
		$url=str_replace("[$v"."_a1u]",$tmpx,$url);
		$url=str_replace("[$v"."_a2]",$tmpa[1],$url);
		$url=str_replace("[$v"."_a3]",$tmpa[2],$url);
	}
	//echo "[url=$url]";
	$res="<IMG SRC='$url' $addhtml style='border: solid 1px black; border-left-width:2; border-bottom-width:2'
	onerror=\"if(this.errrec!=1) {this.errrec=1;this.src='$dcrURL/neoimg/nocover.png';}\">";
	$realres[html]=$res;
	$realres[url]=$url;
	$realres[ispass]="yes";
	return $realres;
} 
?>