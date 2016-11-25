<?php 
 include("./inc/config.inc.php");
 html_start();
 loginchk_lib();
 if ($mid=="") {
	die("no mid passed");
 }
 $mid=urldecode($mid);
 $mid=urldecode($mid);
 $mid=urldecode($mid);
 $mid=urlencode($mid);
 $now=time();
$iseditpermmanager=library_gotpermission("webeditpagepermission");
if ($iseditpermmanager!=true) {
	die("your login have no permission to this module;");
}
if ($clearrules=="yes") {
	tmq("delete from library_editperm 
		where classid='$mid'");
}
if ($issave=="yes") {
	$edidtablelist=",,".@implode($permthis,',').",,";
	$longlog="$useradminid::$now (".ymd_datestr($now).")::$edidtablelist".$newline;
	$c=tmq("select * from library_editperm where classid='$mid' ");
	if (tmq_num_rows($c)==0) {
		tmq("insert into library_editperm set 
		classid='$mid',
		editable='$edidtablelist',
		ruler='$useradminid',
		dt='$now',
		longlog='$longlog'
		");
	} else {
		tmq("update library_editperm set 	
		editable='$edidtablelist',
		ruler='$useradminid',
		dt='$now',
		longlog=concat('$longlog',longlog)
		where classid='$mid'
	");
	}
}
$m=tmq("select * from library_editperm where classid='$mid' ");
$m=tmq_fetch_array($m);

$s=tmq("select * from library_site order by code");
	?><TABLE width=100% align=center class=table_border cellspacing=2 cellpadding=0><FORM METHOD=POST ACTION="_editperm.php">
	<INPUT TYPE="hidden" NAME="mid" value="<?php  echo $mid?>">
	<INPUT TYPE="hidden" NAME="issave" value="yes">
<SCRIPT LANGUAGE="JavaScript">
<!--
function clickcheck(wh,tabid) {
	tmp=getobj(wh);
	tmptab=getobj(tabid);
	//alert(tmp.checked);
	if (tmp.checked==true)	{
		tmptab.className="localselected";
	} else {
		tmptab.className="localnoselected";
	}
}
//-->
</SCRIPT>
<style>
.localselected {
	background-color: #C1FFD1;
	border-color: #6BC153;
	border-width: 0px;
	border-style: solid;
	border-right-width: 2px;
	border-left-width: 10px;
}
.localnoselected {
	background-color: white;
	border-color: #CCCCCC;
	border-width: 0px;
	border-style: solid;
	border-right-width: 2px;
	border-left-width: 10px;
	background-color: transparent;
}

</style>

	<TR>
		<TD class=table_head><?php  echo getlang("กรุณาเลือกล็อกอินที่จะอนุญาตให้แก้ไข::l::Select login to allow");?> <img align=absmiddle src="<?php  echo $dcrURL?>neoimg/ExpandCanvas.png" style="cursor:hand; cursor: pointer;" onclick="parent.editpermIFRAMEcontrol(); this.style.display='none';"></TD>
	</TR>
	<?php 
	$alljsclick="";
	$nonejsclick="";

	while ($r=tmq_fetch_array($s)) {
		$s2=tmq("select * from library where libsite ='$r[code]' and UserAdminID<>'$useradminid' order by UserAdminName",false);
		if (tmq_num_rows($s2)>0) {
		?><TR>
			<TD class=table_head2><?php  echo getlang("สาขาห้องสมุด::l::Lib. Branch"); echo " ";
		echo getlang($r[name])?></TD>
		</TR>
		<?php 
		while ($r2=tmq_fetch_array($s2)) {
			$pos = strpos("$m[editable]", ",$r2[UserAdminID],");
			?><TR>
				<TD noclass=table_td ID="TD_<?php  echo $r2[UserAdminID]?>" <?php 
					if ($pos === false && $m[editable]!="") {
						echo " class='localnoselected' ";
					} else {
						echo " class='localselected' ";
					}			?>><label for="CB_<?php  echo $r2[UserAdminID]?>" style="width: 100%; display:inline-block;">&nbsp; <font class=smaller><img align=absmiddle src='./neoimg/misc/32316.GIF'>
				<INPUT TYPE="checkbox" NAME="permthis[]" value="<?php  echo $r2[UserAdminID]?>" style="border-width:0;
				<?php 				if ($r2[UserAdminID]=='nida' || $r2[UserAdminID]=='msu' || $r2[UserAdminID]=='kmutnb' )	 {
					echo "background-color:red";
				}?>"
				ID="CB_<?php  echo $r2[UserAdminID]?>" <?php 
					if ($pos === false && $m[editable]!="") {
						echo " ";
					} else {
						echo " selected checked  ";
					}
				?>   onclick="clickcheck('CB_<?php  echo $r2[UserAdminID]?>','TD_<?php  echo $r2[UserAdminID]?>');" >
				<?php 
			echo getlang($r2[UserAdminName])

				?></font></label></TD>
			</TR><SCRIPT LANGUAGE="JavaScript">
			<!--
				clickcheck('CB_<?php  echo $r2[UserAdminID]?>','TD_<?php  echo $r2[UserAdminID]?>');
			//-->
			</SCRIPT>
			<?php 
			$alljsclick.="tmp=getobj('CB_$r2[UserAdminID]');tmp.checked=true;clickcheck('CB_$r2[UserAdminID]','TD_$r2[UserAdminID]');";
			$nonejsclick.="tmp=getobj('CB_$r2[UserAdminID]');tmp.checked=false;clickcheck('CB_$r2[UserAdminID]','TD_$r2[UserAdminID]');";
		}
	}
}
?>
<TR>
	<TD class=table_td align=center><INPUT TYPE="submit" value=" Save Permission " class=a_btn> <INPUT TYPE="reset" value='reset' class=a_btn>
	<A HREF="_editperm.php?mid=<?php  echo $mid?>&clearrules=yes" class=a_btn style="color: darkred"><?php  echo getlang("ไม่กำหนด::l::Remove rules");?></A>
	<A HREF="javascript:void(null);" onclick="<?php  echo $alljsclick;?>" class=a_btn style="color: darkred"><?php  echo getlang("เลือกทั้งหมด::l::Select all");?></A>
	<A HREF="javascript:void(null);"  onclick="<?php  echo $nonejsclick;?>" class=a_btn style="color: darkred"><?php  echo getlang("ไม่เลือกเลย::l::Select none");?></A>
	</TD>
</TR>

	</FORM>
</TABLE>