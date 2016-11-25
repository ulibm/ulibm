<?php 
	; 
		set_time_limit(0);		

        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_bookitem";
	$tmp=mn_lib();
	pagesection($tmp);
//print_r($_POST);
?><BR><CENTER><B><?php  echo getlang("เริ่มทำการนำเข้าข้อมูลไอเทม::l::Start import"); ?> ...</B></CENTER>
<BR>
<CENTER><?php 
$importid="[ULIBM.importer:".thaidatestr(0,"YES")."]";
$status=barcodeval_get("importer_bkitems-status");
$itemplace=barcodeval_get("importer_bkitems-itemplace");
$libsite=barcodeval_get("importer_bkitems-libsite");
$itemtype=barcodeval_get("importer_bkitems-itemtype");
$bcsep_field=barcodeval_get("importer_bkitems-bcsep_field");
$importset=barcodeval_get("importer_bkitems-importset");

$s=tmq("select * from importer_bkitems_tmp ");
$Stime=time();
$i=0;
$e=0;
$itemadded=0;

$resultdata=Array();
//print_r($_POST);
//print_r($resultmap_fid);
//echo "<BR><BR><BR>";

	$r[SPACE]=" ";
	$r['EMPTY']="";
	$resultmap_fid[matid]="matid";
	$resultmap_fid[barcode]="barcode";
	$resultmap_fid[iprice]="iprice";

	reset($resultmap_fid);
	$res="";
	$sumstr="";
	$barcodeid="";


		eval("\$matid=\"\$matid\" ;");
		eval("\$barcode=\"\$barcode\" ;");
		eval("\$iprice=\"\$iprice\" ;");

		echo "id for Material is $matid<BR>";
		echo "id for barcode is $barcode<BR>";
		echo "id for price is $iprice<BR>";

		$s=tmq("select * from importer_bkitems_tmp ");
while ($r=tmq_fetch_array($s)) {
		$price=round($r[$iprice],2);
		
	$i++;
	if (trim($r[$matid])==""  || trim($r[$barcode])=="" ) {
		echo getlang("รายการที่ $i ไม่ถูกนำเข้า, ข้อมูลเป็นค่าว่าง::l::Record No. $i cannot import, Empty data.")."<BR>";
	} else {
	//echo "[$r[$name2]$name]";

			$sql="select * from media where importref='$r[$matid]' and importid='$importset' ";
					//echo $sql;
		//die;
		$sql=tmq($sql);
		if (tmq_num_rows($sql)==0) {
		echo getlang("รายการที่ $i ไม่ถูกนำเข้า, ไม่พบหมายเลขวัสดุฯ $r[$matid]::l::Record No. $i cannot import, Canot find Material ID $r[$matid].")."<BR>";
		continue;
		}
		$sql=tmq_fetch_array($sql);
		$pid=$sql[ID];
		$barcodeid=$r[$barcode];
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
						price='$price' ,
						place='$itemplace' 
						");
						$itemadded++;
					}
				}
			}
	}
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