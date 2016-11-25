<?php 
	; 
set_time_limit(0);		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_book";
	$tmp=mn_lib();
	pagesection($tmp);
//printr($_POST);
?><BR><CENTER><B><?php  echo getlang("เริ่มทำการนำเข้าข้อมูลวัสดุฯ::l::Start import"); ?> ...</B></CENTER>
<BR>
<CENTER><?php 
		//printr($_POST);

$importid="[ULIBM.importer:".thaidatestr(0,"YES")."]";
$status=barcodeval_get("importer_book-status");
$itemplace=barcodeval_get("importer_book-itemplace");
$isbc=barcodeval_get("importer_book-isbc");
$libsite=barcodeval_get("importer_book-libsite");
$itemtype=barcodeval_get("importer_book-itemtype");
$bcsep_field=barcodeval_get("importer_book-bcsep_field");

$s=tmq("select * from importer_book_tmp ");
$Stime=time();
$i=0;
$e=0;
$itemadded=0;
$resultmap_fid=tmq_dump("importer_book_map","classid","fid");;
$resultmap_tp=tmq_dump("importer_book_map","classid","tp");;
$resultdata=Array();
//print_r($_POST);
//print_r($resultmap_fid);
//echo "<BR><BR><BR>";
$isfirst="yes";
	tmq("delete from barcode_val where classid like 'importmemory-book-%' ");
	tmq("delete from barcode_valmem where classid like 'importmemory-book-%' ");


while ($r=tmq_fetch_array($s)) {
	//printr($r);
	$r[SPACE]=" ";
	$r['EMPTY']="";
	reset($resultmap_tp);
	reset($resultmap_fid);
	$res="";
	$sumstr="";
	$barcodeid="";
	foreach ($resultmap_fid as $k=> $v) {
		$thisv="";
		eval("\$thisv=\$$k ;");
		@reset($thisv);
		$meltedvalue="";
		//printr($v);
		//echo "($k)";
		for ($khi=1;$khi<=10;$khi++) {
			//barcodeval_get("importmemory-book-$wh-$i-select");
			//echo "--$thisv[$khi]<BR>";
			//printr($thisv_v);
			if ($thisv[$khi]=="EMPTY") {
				$thisv[$khi]="";
			}
			if (substr($thisv[$khi],0,5)=="[data") {
				$thisvtmpk=trim($thisv[$khi],'[');
				$thisvtmpk=trim($thisvtmpk,']');
				$r[$thisvtmpk]=stripslashes($r[$thisvtmpk]);
				$r[$thisvtmpk]=addslashes($r[$thisvtmpk]);

				eval("\$thisvtmp=\"\$r[$thisvtmpk]\" ;");
				//echo("\$thisvtmp=\"\$r[$thisvtmpk]\" ;<BR>");
			} else {
				eval("\$thisvtmp=\"\$thisv[$khi]\" ;");
				//echo("\$thisvtmp=\"\$thisv[$khi]\" ;<BR>");
			}
			//echo "[-$thisv_k,$thisv_v-]";
			
			//echo "v=[$v]thisvtmp=[$thisvtmp]".$thisv[$khi]."<BR>";
			if ($isfirst=="yes") {
			   barcodeval_set("importmemory-book-".trim($v," ][")."-$khi",$thisv[$khi]);
			}
			$meltedvalue.=$thisvtmp;
		}
		//$meltedvalue="[$thisv]";
		$meltedvalue=addslashes("$meltedvalue");
		//echo "[$meltedvalue]<BR>";
		if ($k=='ITEMBARCODE') {
			//echo "CCCCCC$meltedvalue<BR>";
			$barcodeid=$meltedvalue;
			$barcodeid=addslashes($barcodeid);
			continue;
		}
		//echo "$meltedvalue<HR>";
		//echo "CCCCCC$resultmap_tp[$k]<BR>";
		$resutlval=str_replace("[data]","$meltedvalue",$resultmap_tp[$k]);
		$resultval=addslashes("$resultval");
		//echo "CCCCCC$resutlval<BR>";
		$res="$res  $resultmap_fid[$k] ='$resutlval'  ,";
		$sumstr="$sumstr$resutlval";
	}

	$i++;
	if (trim($sumstr)=="") {
		echo getlang("รายการที่ $i ไม่ถูกนำเข้า, ข้อมูลเป็นค่าว่าง::l::Record No. $i cannot import, Empty data.")."<BR>";
	} else {
	//echo "[$r[$name2]$name]";

		$sql="insert into media set
		$res
		importid='$importid'
		";
		//echo $sql;		die;
		tmq($sql);
		$pid=tmq_insert_id();
		if ($isbc=="on") {
			if ($barcodeid!="") {
				$barcodeid=explode($bcsep_field,$barcodeid); 
				foreach ($barcodeid as $barcodeidk=>$barcodeidv) {

					$barcodeidv=str_remspecialsign($barcodeidv);
					$barcodeidv=trim($barcodeidv);

					if ($barcodeidv!="") {
						tmq("insert into media_mid set
						RESOURCE_TYPE='$itemtype' ,
						pid='$pid' ,
						bcode='$barcodeidv' ,
						status='$status' ,
						libsite='$libsite' ,
						place='$itemplace' 
						");
						$itemadded++;
					}
				}
			}
		}
	}
	$isfirst="no";
}
$Etime=time();

?></CENTER>
<BR><CENTER>
<B><?php  echo getlang("ผลการนำเข้า::l::Import result"); ?></B><BR><?php  echo getlang("นำเข้าสำเร็จ::l::Success"); ?> 
<?php  echo number_format($i);?> <?php  echo getlang("รายการ โดยใช้เวลา::l::records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::seconds"); ?> (<?php  echo getlang("ผิดพลาด::l::Error"); ?>  <?php  echo number_format($e);?> <?php  echo getlang("ครั้ง เพิ่มรายการไอเทมจำนวน $itemadded รายการ::l::times, $itemadded items added. "); ?>)<BR>
<BR><BR>
*<?php  echo getlang("หากมีการผิดพลาด ข้อความรายละเอียดความผิดพลาดจะแสดงด้านบน::l::If any error occored, error detail wil shown above."); ?></CENTER>

<BR>
<BR><BR>
<?php  foot();
?>