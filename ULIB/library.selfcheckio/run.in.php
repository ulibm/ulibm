<?php 
include_once("../inc/config.inc.php");
html_start();
include_once("./inc.php");

//printr($_GET);
$bcinlist=sessionval_get("bcinlist");
$bcinlist=unserialize($bcinlist);
//printr($bcinlist);
if (!is_array($bcinlist)) {
	$bcinlist=Array();
	local_gethtml("in_scanmatbc");
	
}
$mediabarcode=explode(",",$mediabarcode);
$mediabarcode=arr_filter_remnull($mediabarcode);

function local_cinmem($memberbarcode) {
	global $dcrURL;
	global $dcrs;
	global $dcr;
	$sql2="select * from member where UserAdminID='$memberbarcode'";
			//echo ($sql2);
			$result2=tmq($sql2);
				$nnnn=tmq_num_rows($result2);
				$s=tmq_fetch_array($result2);

			if ($nnnn == 0)
				{
				echo("ไม่พบรหัสสมาชิกนี้");
				}
	?>
<IMG SRC='<?php  echo member_pic_url($memberbarcode);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''>
	<TABLE cellpadding=0 border=0 cellspacing=0 width=100% style="max-width: 300px;" > 
	<TR>
		<TD class=table_head <?php  echo $addhtmlsizehead;?>><?php  echo getlang("Barcode::l::Barcode");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[UserAdminID]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ชื่อ::l::Name");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_member_name($memberbarcode);	?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ประเภทสมาชิก::l::Member Type");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		$rooms=tmq("select * from member_type where type='$s[type]'");
		$rooms=tmq_fetch_array($rooms);
		echo getlang($rooms[descr])?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("$_ROOMWORD");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		$rooms=tmq("select * from room where id='$s[room]'");
		$rooms=tmq_fetch_array($rooms);
		echo get_room_name($s[room]);
		//echo getlang($rooms[name]);
		
		
		?></TD>
	</TR>


</TABLE>
<?php 
}
?>


<table width=100% cellpadding=0 cellspacing=0 border=10 bordercolor=red>
<tr valign=top>

	<td  valign=top style="vertical-align: top;"><?php 
	@reset($mediabarcode);
	while (list($k,$v)=each($mediabarcode)) {
			$res=cir_checkin($v,date("j"),date("n"),date("Y")+543);
			array_unshift($bcinlist, $res);
			//$bcinlist[$v]=$res;
	}
	@reset($bcinlist);
	while (list($k,$res)=each($bcinlist)) {
				//echo "[$k]";

		//printr($res);
		$tmpstatus_only=$res[status];
		?><table width=100% cellspacing=0>
		<tr valign=top>
		<td width=200 align=center>
		<?php  
		if (trim($res[memberbarcode])!="") {
			local_cinmem($res[memberbarcode]);
		}	
		?>
		</td>
		<td width=200 style="vertical-align: top; <?php 
		if ($tmpstatus_only=="error") {
			echo " background-color: #ffecec;";
		}	
		?>" >
		<TABLE style="margin: 10px 10px 10px 10px;">
	   <TR>
		<TD width=180 align=center style="vertical-align: top" ><?php  echo res_brief_dsp($res[media_pid]);?></TD>
	   </TR>
	   </TABLE></td>
	   <td style="vertical-align: top; height: 100%;
	   <?php 
		if ($tmpstatus_only=="error") {
			echo " background-color: #ffecec;";
		}	
		?>
		" ><div style="width:100% ; height: calc(100%  -20px)!important; position:relative; display:block; margin: 10px 10px 10px 10px; background-color: white!important;;;">
				<?php 
		if ($res[status]=="error") {
			echo "<b style='color:darkred'>".getlang("ไม่สามารถรับคืนได้::l::Cannot Check in")."</b><br>";
		}
		$tmpstatus=$res[error];
		//echo "[$tmpstatus]";
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkred'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[msg];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkblue'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[success];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkgreen'>".getlang($tmpstatusv)."</font><br>";
		}
			?>
			</div></td>
		</tr>
		</table><?php 
	}
	
	$bcinlist=serialize($bcinlist);
	sessionval_set("bcinlist",$bcinlist);
	?></td>
</tr>
</table>