<?php  //พ
global $ID;
global $newline;
$sql = "select * from media where ID='$ID' ";
$result = tmq($sql);
$Num = tmq_num_rows($result);
if($Num == 0) {
	//bib not found
	//echo "bib not found";
} else {
	$zotero=getval("CROSSWALK","marc_dc");
	$zotero=explodenewline($zotero);
	$zotero=arr_filter_remnull($zotero);
	//printr($zotero);
	$zdata=marc_melt($ID,"yes");

	@reset($zotero);
	while (list($zoterok,$zoterov)=each($zotero)) {
		//echo $zoterov."sss";
		$zi=explode("=",$zoterov);
		$zi[0]=trim($zi[0]);
		$zi[2]=trim($zi[2]);
		if ($zi[0]=="") { continue; }
		//echo "<b>".$zi[0]."</b>-";
		//echo "<b>".$zi[1]."</b><br>";
		$eachtag=explode(",",$zi[1]);
		@reset($eachtag);
		//printr($eachtag);
		while (list($eachtagk,$eachtagv)=each($eachtag)) {
			$eachtagv=str_replace("^","_",$eachtagv);
		//	echo "<u>".$eachtagv."</u><br>";
			$issubstr = strpos($eachtagv, "/");
			$tmp_nextone="none";
			if ($issubstr === false) {
				$substrprop=Array();
				if ($eachtagv!="leader") {
					$tmp=$zdata["tag".$eachtagv];
				} else {
					$tmp=$zdata["leader"];
				}
			} else { 
				//found
				$substrprop=explode("/",$eachtagv);
				if ($substrprop[0]!="leader") {
					$tmp=$zdata["tag".$substrprop[0]];
				} else {
					$tmp=$zdata["leader"];
				}
				$tmp=substr($tmp,floor($substrprop[1])-1,($substrprop[2]-$substrprop[1]));
				//    leader/5/6/leader/6/7,
				if (trim($substrprop[3])=="") {
					$tmp_nextone="none";
				} else {
					$tmp_nextone=substr($zdata[$substrprop[3]],floor($substrprop[4]),($substrprop[5]-$substrprop[4]));
				}
				//echo "[$tmp/$tmp_nextone]=".$zdata[$substrprop[3]];
			}
			$tmp=str_replace("|"," ",$tmp);
			//echo " ".$zi[4];
			if ($zi[4]!="" && trim($tmp)=="") {
				$tmp=$zi[4];
			}
			if ($tmp!="") { 
				//echo $tmp."<br>";
				$tmp=explodenewline($tmp);
				$tmp=arr_filter_remnull($tmp);
				@reset($tmp);

				while (list($tmpk,$tmpv)=each($tmp)) {
					$tmpv=dspmarc($tmpv);
					$tmpsubdc="";
					if ($zi[2]!="") {
						$tmpsubdc=".".$zi[2];
					}
					$tmpv=addslashes($tmpv);
					$tmpv=trim($tmpv);
					$tmpv=trim($tmpv,": ");
					$tmpv_orig=$tmpv;
					if ($tmpv!="") {
						if ($zi[3]=="DCMITypeVocabulary") {
							$dcmi=getval("CROSSWALK","marc_dc_dcmi");
							//echo("[[$dcmi]]");
							eval("$dcmi");
							$dcmi=$tmpdcmi;
							//echo "[$tmpv_orig/$tmp_nextone=";
							$tmpv=$dcmi["$tmpv_orig"]["$tmp_nextone"];
							//echo $tmpv."]";
							if (trim($tmpv)=="") {
								$tmpv=$dcmi["$tmpv_orig"]["none"];
							}
							//printr($dcmi);
							//$tmpv="mapping";
						}
						if ($tmpv!="") {
							$tmpmeta="<meta name=\"".trim($zi[0])."$tmpsubdc\" content=\"$tmpv\" />$newline";
						} else {
						}
					}

					echo $tmpmeta;
				}
			}

		}
	}
}
?>