<?php  //พ
function  serial_rebuild_serialstr($MID) {

	//printr($mdinfor);
	$slibsite=tmq("select distinct libsite from media_mid where pid='$MID' ");
	$res="";
	$tag=getval("MARC","serialtag");
	while ($rlibsite=tmq_fetch_array($slibsite)) {

		$s=tmq("select * from media_mid where pid='$MID' and libsite='$rlibsite[libsite]' and (RESOURCE_TYPE='".getval("MARC","serial-mdtype")."' or RESOURCE_TYPE='".getval("MARC","serial-bound-mdtype")."'  or RESOURCE_TYPE='c-serial' ) and  jnonpublicnote='' ",false);
		$localres="";
		while ($r=tmq_fetch_array($s)) {
			$localres.= serial_get_volstr($r[id]). " " . $r[javaistatusnote] . ";";
		}
		$localres=trim($localres,"; ");
		$librarysymbolval=getval("MARC","librarysymbolval");
		if ($rlibsite[libsite]!="main") {
			$librarysymbolval=$librarysymbolval.":".$rlibsite[libsite];
		}
		$res=$res."^a".$librarysymbolval."^b$localres
";
	}
	tmq("update media set ".$tag."='$res' where ID='$MID' ",false);
	
	//marc holding s
	//853	20$81$av.$bno.$u6$vr$i(year)$j(month)$wm$x01,07
	//http://www.loc.gov/marc/holdings/hd853855.html
	$serialdspdata="20^81";
	$serialdspS=tmq("select * from serial_info where MID='$MID' ");
	$serialdspr=tfa($serialdspS);
	//printr($serialdspr);
	$azdata=getval("global","STR_A_Z");
	$azdata=explode(",",$azdata);
	//printr($azdata);
	$currenthas=0;
	$lastenumformatdata="";
	for ($i=1;$i<=6;$i++) {
		if (trim($serialdspr["enum$i"])!="") {
			$serialdspdata=$serialdspdata."^".$azdata[$currenthas].trim($serialdspr["enum$i"]);
			$currenthas++;
			$lastenumformatdata=$serialdspr["enumr$i"];
		}
	}
	$serialdspdata=$serialdspdata."^i(year)^j(month)"; //copy code
	/*$currenthas=8;
	for ($i=1;$i<=6;$i++) {
		if (trim($serialdspr["enum$i"])!="") {
			$serialdspdata=$serialdspdata."^".$azdata[$currenthas].trim($serialdspr["enum$i"]);
			$currenthas++;
		}
	}*/
	if (trim($lastenumformatdata)!="" && trim($lastenumformatdata)!="-1")  {
		$serialdspdata=$serialdspdata."^u".count(explode(",",$lastenumformatdata));
		$serialdspdata=$serialdspdata."^vc"; //continues
	} else {
		$serialdspdata=$serialdspdata."^vr"; //resarts
	}
	if (trim($serialdspr[marccode])!="") {
		$serialdspdata=$serialdspdata."^w".trim($serialdspr[marccode]); //marc freq code
	}
	//$serialdspdata=$serialdspdata."^t".trim(getval("catconfig","inumbercode")); //copy code
	//echo "[$serialdspdata]";
	$serialdspitemdata="";
	//863  40$81.1$a29-37$i1983$j03-12
	//http://www.loc.gov/marc/holdings/hd853855.html
	$sb1="SELECT *  FROM media_mid where pid='$MID' 
	 and (RESOURCE_TYPE='".getval("MARC","serial-mdtype")."' or RESOURCE_TYPE='".getval("MARC","serial-bound-mdtype")."' ) and  jnonpublicnote='' ";	
	$sb1="$sb1 group by jenum_1,jenum_2,jenum_3,jenum_4,jenum_5,jenum_6,calln";
	$sb1.=" order by jchrono_1 , jchrono_2 , jchrono_3 ,jenum_1 ,jenum_2 ,jenum_3,jenum_4,jenum_5,jenum_6 ";
	$sql1 ="$sb1" ; 
	
	$result = tmq($sql1,false);
	$isf8=0;
	while ($r=tfa($result)) {
		$isf8++;
		//printr($r);
		$serialdspitemdata=$serialdspitemdata."40^81.$isf8";
		$currenthas=0;
		for ($i=1;$i<=6;$i++) {
			if (trim($r["jenum_$i"])!="") {
				$serialdspitemdata=$serialdspitemdata."^".$azdata[$currenthas].trim($r["jenum_$i"]);
				$currenthas++;
			}
		}
/*
		$currenthas=8;
		for ($i=1;$i<=2;$i++) {
			if (trim($r["jchrono_$i"])!="") {
				$serialdspitemdata=$serialdspitemdata."^".$azdata[$currenthas].trim($r["jchrono_$i"]);
				$currenthas++;
			}
		}*/
		$serialdspitemdata=$serialdspitemdata."^i".$r["jchrono_1"]."^j".$r["jchrono_2"]."
";
	}
	//echo "<pre>[$serialdspitemdata]</pre>";
	$serialdspdata=addslashes($serialdspdata);
	$serialdspitemdata=addslashes($serialdspitemdata);
		tmq("update media set ".getval("MARC","serial-cappat")."='$serialdspdata',".getval("MARC","serial-enumchro")."='$serialdspitemdata' where ID='$MID' ",false);

	//marc holding e
	//echo $res;
}
?>