<?php 

function pathgen($cate,$TID="") {
	global $ismanager;
	global $catedata;
	global $backto;
	global $tmiddata;
	global $postdata;
	global $dcrURL;
	global $_tmid;
	global $_memid;	
global $_TBWIDTH;
	if ($cate=="") {
		die("no forum id");
	}
	if ($cate=="index") {
		$catedata[id] = "index";
		$catedata[name] =getlang(barcodeval_get("webboard-boardname"));//getlang("หน้าแรกเว็บบอร์ด::l::Webboard's Home");
		//$catedata[descr] = "คำถามทางวิชาการ ถึงบรรณารักษ์";
	} elseif ($cate=="search") {
		$catedata[id] = "search";
		$catedata[name] = getlang("ค้นหาข้อมูลในเว็บบอร์ด::l::Search in webboard ");
		//$catedata[descr] = "คำถามทางวิชาการ ถึงเจ้าหน้าที่ห้องสมุด";
	} else  {
		$catedata=tmq("select * from  webboard_boardcate where id='$cate' ");
		if (tmq_num_rows($catedata)==0) {
			die("forum id $cate doesn't exist.");
		}
		$catedata=tmq_fetch_array($catedata);
		//print_r($catedata);
	}
	/*
	if ($ismanager!=true && $catedata[isshowtouser]=="no") {
		//ตรวจการอนุญาต
			die("คุณไม่มีสิทธิ์เข้าดูหัวข้อนี้ได้ กรุณาคลิก Back และเลือกหัวข้ออื่น.");
	}
	*/
	//print_r($catedata);


	//ตรวจการอนุญาต


	?>
<style >
.localpathgenlink {
	font-size: 12px;
	font-weight: bold;
}

</style>
	<TABLE width="<?php  echo $_TBWIDTH?>" align=center >
	<TR>
		<TD width=75%><A HREF="<?php echo $dcrURL?>"><img src="home.gif" align=absmiddle border=0> <b class=localpathgenlink><?php  echo getlang("หน้าหลัก::l::Homepage");?></b></A> <B class=localpathgenlink>&gt;&gt;</B>
		<A HREF="<?php echo $dcrURL?>/webboard/index.php"> <B class=localpathgenlink><?php  echo getlang(barcodeval_get("webboard-boardname"));?></B> </A>
<?php 
if ($cate!="index") {
	?>		<B  class=localpathgenlink>&gt;&gt;</B>
			<A HREF="viewforum.php?ID=<?php  echo $cate?>"><B class=localpathgenlink><?php  echo getlang("หมวด::l::Category");?> <U><?php  echo getlang($catedata[name])?></U></B></A> <?php 
}
if ($TID!="") {
	?> <B  class=localpathgenlink>&gt;&gt;</B>
	<A HREF="viewtopic.php?TID=<?php  echo $TID?>"><B class=localpathgenlink> <?php  echo getlang("หัวข้อ ::l::Topic");?><U><?php  echo str_censor(substr($postdata[topic],0,50));
	if (strlen($postdata[topic])>50) {
		echo "...";
	}?></U></B></A><?php 
}
	
	?></TD>
		<TD align=right  class=localpathgenlink><nobr><?php 
		$reqmemid= barcodeval_get("webboard-reqmemid");
	if (($catedata[isshowtouser]=="yes" && ( ($reqmemid=='yes' && $_memid!='') || $reqmemid!='yes') ) || $ismanager==true ) {
		?>[<A HREF="addtopic.php?ID=<?php echo $cate; ?>&backto=<?php  echo $backto?>"  class=localpathgenlink><?php  echo getlang("ตั้งคำถามใหม่::l::Post new topic");?></A>] <?php 
			//echo $tmiddata[isans]."-".$postdata[iscan_ans];
			if ($TID!="" && ($postdata[iscan_ans]!="no" || $ismanager==true)) {
				?>[<A HREF="addtopic.php?ID=<?php echo $cate; ?>&replying=<?php  echo $TID?>&backto=<?php  echo $backto?>" class=localpathgenlink><?php  echo getlang("ตอบ::l::Reply");?></A>] <?php 
			}
			if ($TID!="" && $ismanager==true) {
				?>[<A HREF="movetopic.php?TID=<?php echo $TID; ?>" class=localpathgenlink><?php  echo getlang("ย้าย::l::Move");?></A>] <?php 
			}
	}		
	?></nobr></TD>
	</TR>
	</TABLE><?php 
}
?>