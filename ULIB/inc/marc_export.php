<?php  //พ
function marc_export($tmp) {
	$marc_export_encoding=barcodeval_get("lib_marcexport_encoding");;
	if ($marc_export_encoding=="") {
		$marc_export_encoding="systemdefault";
	}
	$s=tmq("select * from media where ID='$tmp' ");
	if (tmq_num_rows($s)==0) {
		echo ("marc_export($tmp) record not found");
	}
	$s=tmq_fetch_array($s);
	$tags="select * from bkedit order by fid";
		$result=tmq($tags);
		$_RECORD_LENGTH="";//0-4
		$_LEADER="$s[leader]";//5-16
		$_LEADER_1=mb_substr($_LEADER,5,7); //0-11
		$_LEADER_2=mb_substr($_LEADER,17,23); //17-23
		$_BASE_ADDR="";//12-16
		$_DIRECTORY="";
		$_DATASET="";
		$i=0;
		while ($row=tmq_fetch_array($result))	{
			if ($s[$row[fid]]!="") {
				$i++;
				$odata=$s[$row[fid]];
				$odatas=explodenewline($odata);
				foreach ($odatas as $value) {
               $value2=str_replace("^",chr(31),$value);
               //echo "[$value=$value2]<BR>";
               $value=$value2;
					if (trim($value)!="") {
						//echo $row[fid]."=$value<BR>";
						$_DIRECTORY = "$_DIRECTORY".
							mb_substr($row[fid],-3)."".
							str_fixw(mb_strlen($value)+1,4)."".
							str_fixw(mb_strlen($_DATASET)+2,5).
							"";
						//$_DATASET = $_DATASET . "" . mb_substr($value,0,2).chr(31).mb_substr($value,2) . chr(30);
						$_DATASET = $_DATASET . "" . $value . chr(30);
					}
				}
			}
		}
		$_DIRECTORY=$_DIRECTORY.chr(30);
		$_BASE_ADDR=str_fixw(mb_strlen("$_LEADER_1$_LEADER_2$_DIRECTORY")+5+5,5);
		$_DATASET=mb_ereg_replace("^",chr(31),$_DATASET);
		//$_DATASET=mb_ereg_replace(" ",chr(32),$_DATASET);
	$_RECORD_LEN=str_fixw(mb_strlen("$_LEADER_1$_BASE_ADDR$_LEADER_2$_DIRECTORY$_DATASET")+5,5);
	
	$_RESULT="$_RECORD_LEN$_LEADER_1$_BASE_ADDR$_LEADER_2$_DIRECTORY"."$_DATASET";//.chr(29);//.chr(32)."";
	if ($marc_export_encoding=="utf8") {
		$_RESULT=iconvutf($_RESULT);
	}
	if ($marc_export_encoding=="tis620") {
		$_RESULT=iconvth($_RESULT);
	}
	//echo "[$marc_export_encoding]";
	return $_RESULT;
}
?>