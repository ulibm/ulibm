<?php 
    ;
		ob_start();

	set_time_limit(600);
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	loginchk_lib();
	//mn_lib();
	$anotherround="";
	$indexpertime=getval("_SETTING","indexeachround");
	if ($page=="") {
		$page=1;
	}

?>

<BR><BR>
                                <table width = "550" border = "0" cellspacing = "0" cellpadding = "0" align=center>

                                    <tr>


                                        <td><?php 

function thisecho($t) {
	$a=0;
	if ($a==1) {
		echo $t;
	}
}

if (!file_exists("../_output/marc.sql") ) {

    echo "ผิดพลาด! ไม่สามารถหาไฟล์ marc.sql ในโฟลเดอร์ _output <BR> กรุณา<A HREF='marc.php'>คลิกที่นี่ </A>เพื่อกลับไปสู่ขั้นตอนการนำเข้า MARC ขั้นตอนที่ 1";

} else {

	$successc=0;
	$failc=0;

$Stime=time();

$i=0;
$execcount=0;
$buff="";
$handle = fopen("../_output/marc.sql", "rb");
$expact=";;;;";
$startthisround=($page-1)*$indexpertime;
//echo "[$startthisround]";
while (!feof($handle)) {
	$buff .= fread($handle, 1);
	$decus=substr($buff,-4);
	if ($decus==$expact) {
		$i++;
		if ($i>=$startthisround) {
			if ($execcount<$indexpertime) {
				$buff=trim($buff,$expact);
				$buff=trim($buff,';');
				$buff=trim($buff,';');
				$buff=trim($buff,';');
				$buff=trim($buff,';');
				$buff=trim($buff,';');
				$buff=trim($buff,';');
				if (tmq($buff)!==false) {
					$successc=$successc+1;
					if ($reindexnow=='yes') {
						index_reindex(tmq_insert_id());
					}
				} else {
					$failc=$failc+1;
				}


				$buff="";
				$execcount++;
			} else {
				$anotherround="yes";
			}
		} else {
			$buff="";
		}
	}
}

$Etime=time();






echo " ".getlang("ปฏิบัติการจำนวน::l::Executed ")." $execcount ".getlang("ครั้ง ใช้เวลา::l::times in ")." ".-($Stime-$Etime)." ".getlang("วินาที::l::seconds")."<BR>";

echo " ".getlang("สำเร็จ::l::success")." $successc ".getlang("ครั้ง ผิดพลาด::l::times, error")." $failc ".getlang("ครั้ง::l::times.")."";

			if ($reindexnow=='yes') {
				$reindexnowstr=getlang("ทำ Index แล้ว::l::Indexed");
			} else {
				$reindexnowstr=getlang("ยังไม่ได้ทำ Index::l::Not indexed");
			}


	echo getlang("สถานะการ Index::l:: Index Status")."::<B>$reindexnowstr</B><BR>";

if ($anotherround=="") {
	echo "<BR><BR>".getlang("การดำเนินการเรียบร้อย::l::Operation completed")."";
	echo '<BR><A HREF="marc.php" class=a_btn><B>'.getlang("กลับ::l::Back").'</B></A>';
} else {
	?><BR><BR><CENTER><?php  echo getlang("เนื่องจากเป็นการ import ข้อมูลจำนวนมาก จึงแบ่งการ import ออกเป็นจำนวนย่อย ๆ ::l::To import large amount of data, system will split import operation to multiple part."); ?> <?php  echo getlang(" ครั้งละ ประมาณ ::l:: Estimated "); ?>
<?php  echo $indexpertime ?> <?php  echo getlang("รายการ<BR> ขณะนี้เป็นการ import รอบที่::l::records/round <BR>current round is"); ?>
 <?php  echo $page ?><BR>
	<?php  echo getlang("หลังจาก import เสร็จใจแต่ละรอบ โปรแกรมจะเริ่มทำการ import รอบต่อไปโดยอัตโนมัติ::l::. After finish this round system will continue automatically"); ?><BR><BR><BR>
<?php 
		$redirpath="marc2.php?page=".($page+1)."&reindexnow=$reindexnow";
	sleep(1);
	redir($redirpath,1);
}


}

										?></td>

                                    </tr>

                                </table>
					<?php  foot();?>