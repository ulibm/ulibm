<?php 

function pathgen($cate,$TID="") {
	global $ismanager;
	global $catedata;
	global $backto;
	global $picalbum;
	global $tmiddata;
	global $postdata;
	global $dcrURL;
	global $_TBWIDTH;
	global $_tmid;
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
		$catedata=tmq("select * from  webpage_menu where id='$cate' ");
		if (tmq_num_rows($catedata)==0) {
			die("forum id $cate doesn't exist.");
		}
		$catedata=tmq_fetch_array($catedata);
		//print_r($catedata);
	}

	?>
<style >
.localpathgenlink {
	font-size: 12px;
	font-weight: bold;
}
</style>
	<TABLE width="<?php  echo $_TBWIDTH?>" align=center >
	<TR>
		<TD width=75%><A HREF="<?php echo $dcrURL?>"><img src="home.gif" align=absmiddle border=0> <b class=localpathgenlink><?php  echo getlang("หน้าหลัก::l::Homepage");?></b></A> 
<?php 
if ($cate!="index") {
	?>		<B  class=localpathgenlink>&gt;&gt;</B>
			<A HREF="viewforum.php?ID=<?php  echo $cate?>&picalbum=<?php  echo $picalbum;?>"><B class=localpathgenlink><?php  echo getlang("หมวด::l::Category");?> <U><?php  echo getlang($catedata[name])?></U></B></A> <?php 
}
if ($TID!="") {
	$topic=$postdata[topic];
	$istopic=strpos($topic, ':');
	if ($istopic!==false) {
		$topica=explode(':',$topic);
		$topic=trim($topica[1]);
	}

	?> <B  class=localpathgenlink>&gt;&gt;</B>
	<font class=localpathgenlink> <?php  echo getlang("หัวข้อ ::l::Topic ");?><U style="color: #000000; font-weight: normal;"><?php  echo substr($topic,0,35);
	if (strlen($topic)>35) {
		echo "..";
	}?></U></font><?php 

}

	
	?></TD>
		<TD align=right  class=localpathgenlink><nobr><?php 
	if ( $ismanager==true) {
		?>[<A HREF="addtopic.php?ID=<?php echo $cate; ?>&backto=<?php  echo $backto?>&picalbum=<?php  echo $picalbum;?>"  class=localpathgenlink><?php  echo getlang("โพสท์บทความ::l::Post new article");?></A>] <?php 
			//echo $tmiddata[isans]."-".$postdata[iscan_ans];
			if ($TID!="" &&  $ismanager==true) {
				?>[<A HREF="addtopic.php?ID=<?php echo $cate; ?>&replying=<?php  echo $TID?>&backto=<?php  echo $backto?>&picalbum=<?php  echo $picalbum;?>" class=localpathgenlink><?php  echo getlang("ตอบ::l::Reply");?></A>] <?php 
			}
	}		
	?></nobr></TD>
	</TR>
	</TABLE><?php 
}
?>