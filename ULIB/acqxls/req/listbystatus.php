<?php 
include("../../inc/config.inc.php");
include("../cfg.inc.php");
head();

if ($mode=="") {
	$mode="whatever";
	//die("กรุณาระบุการแสดงผล");
}
	?><CENTER><FORM method="post" action="listbystatus.php"><BR>
<table align=center width="<?php  echo $_TBWIDTH?>">
<tr valign=top><td>

<table align=center width="100%">
<tr valign=top>
<td width=50%>
ค้นจากชื่อเรื่อง ชื่อผู้แต่ง ISBN </td><td>	<input type="text" name="kw" value="<?php  echo $kw;?>"></td></tr>
<tr valign=top>
<td width=50%>ค้นจากชื่อผู้แนะนำ </td><td><input type="text" name="kwa" value="<?php  echo $kwa;?>"><BR>
 <INPUT type="submit" value=" ทำการค้นหา ">
</td></tr>

</table>


</td>
<td>
<label><input type="radio" name="mode" value="whatever"
	<?php  if ($mode=="whatever") { echo " selected checked";}?>>
	ทุกสถานะ</label><br>
<label><input type="radio" name="mode" value="suggest"
	<?php  if ($mode=="suggest") { echo " selected checked";}?>>
	รอดำเนินการ</label><br>

	<label><input type="radio" name="mode" value="ordering"
		<?php  if ($mode=="ordering") { echo " selected checked";}?>
	>
	สั่งซื้อแล้ว </label><br>
	
	<label><input type="radio" name="mode" value="reject"
		<?php  if ($mode=="reject") { echo " selected checked";}?>
	>
	หนังสือขาดตลาด/ไม่จัดพิมพ์ </label><br>
	<label><input type="radio" name="mode" value="bookrecieve"
		<?php  if ($mode=="bookrecieve") { echo " selected checked";}?>>
	หนังสือที่ได้รับตัวเล่มแล้ว</label>
</td></tr>
</table>

 <a href="suggest.php">คลิกที่นี่เพื่อแนะนำสั่งซื้อ</a>
		
	</FORM></CENTER><?php 
$kw=trim($kw);
$mode=trim($mode);

$v=$kw;
?><TABLE width=1000 align=center border=0>
<TR>
	<TD><?php 
	echo "<DIV style='display:block; background-color: #e5e5e5; widht:100%'>
		
	<FONT style='color:black;font-size:20;'>ค้นหา: ".stripslashes($v)."</FONT></DIV>";
	$smaster="select distinct pid as pidd from acqn_sub where 1 ";
	
	
	if ($mode!="whatever") {
		$smaster.=" and  (stat='$mode')   ";
	}
	if ($v!="") {
		$smaster.=" and  (titl like '%$v%' or isn like '%$v%' or auth like '%$v%')   ";
	}
	if ($kwa!="") {
		$smaster.=" and (s_name like '%$kwa%' or s_email like '%$kwa%' )  ";
	}
	$smaster.="  order by id asc ";
	//echo $smaster;
	$s=tmq($smaster);
	if (tnr($s)!=0) { echo "ค้นพบ ".tnr($s)." รายการ<BR>";} else {
		echo "<FONT  color=darkgreen style='font-size:15; font-weight:bold;'>ไม่พบข้อมูล</FONT>";
	}
	if (tnr($s)>10) { echo "แสดงผลการค้นหา 10 รายการแรก<BR>";}
	?><TABLE width=1000 align=center border=0 cellpadding=0 cellspacing=0>
	<TR>
		<TD><?php 
		$countdsp=0;
	while ($r=tfa($s) ) {
		$countdsp++;
		if ($countdsp>10) continue;
		$pidinfo=tmq("select * from acqn where id='$r[pidd]' ");
		$pidinfo=tfa($pidinfo);
		$sthis="select * from acqn_sub where 1 ";
	if ($mode!="whatever") {
		$sthis.=" and  (stat='$mode')   ";
	}
	if ($v!="") {
		$sthis.=" and (titl like '%$v%' or isn like '%$v%' or auth like '%$v%')   ";
	}
	if ($kwa!="") {
		$sthis.=" and (s_name like '%$kwa%' or s_email like '%$kwa%' )  ";
	}
	//$sthis.="  order by id asc ";
		
		$sthis.="and pid='$r[pidd]' order by id desc limit 10";
		$sthis=tmq($sthis);
		?><table width=100% class=table_border>
		<tr>
			<td class=table_head2 style='font-size:18'><?php  
		//print_r($pidinfo);	
		echo $pidinfo[name]?></td>
		</tr>
		<tr>
			<td bgcolor=white><?php 
		while ($sthisr=tfa($sthis)) {
			$sthisr[titl]=trim($sthisr[titl]);
			if ($sthisr[titl]=="") {
				$sthisr[titl]="<i>ไม่ได้ระบุชื่อเรื่อง</i>";
			}
			echo "&bull; <a  href=\"javascript:void(null)\" onclick=\"window.open('../viewsub.php?id=$sthisr[id]','viewsub','width=500,height=500');\">$sthisr[titl] $sthisr[auth] $sthisr[pub] $sthisr[yea]</a> 
			<font style=' border-width:0px!important; border-color: ".$_s[$sthisr[stat]][color].";background-color: ".$_s[$sthisr[stat]][bg].";cursor: hand; cursor: pointer;;display: inline-block; border-width:1px; border-style: solid; width:200px;font-size: 13px;;'>สถานะ ".$_s[$sthisr[stat]][name]."</font> ";
			$acqxlsref=tmq("select acqxlsref,ID from media where acqxlsref='$sthisr[id]' limit 1 ");
			if (tnr($acqxlsref)==1) {
			   $acqxlsrefr=tfa($acqxlsref);
			   echo "<a href=\"$dcrURL"."dublin.php?ID=$acqxlsrefr[ID]\" target=_blank class='smaller a_btn'>".getlang("ดูรายการบรรณานุกรม::l::Click here to view")."</a>";
			}
			
			echo "<br>";
		}	
		?></td>
		</tr>
		</table><?php 
	}
	//print_r("$v");
	?></div></TD>
</TR>
</TABLE><br><?php 

?></TD>
</TR>
</TABLE><BR>
<?php  foot();?>