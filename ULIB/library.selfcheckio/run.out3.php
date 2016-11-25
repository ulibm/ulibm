<?php 
include_once("../inc/config.inc.php");
html_start();
include_once("./inc.php");

//printr($_GET);
$bcoutlist=sessionval_get("bcoutlist");
$bcoutlist=unserialize($bcoutlist);
//printr($bcoutlist);
if (!is_array($bcoutlist)) {
	$bcoutlist=Array();
}
$mediabarcode=explode(",",$mediabarcode);
$mediabarcode=arr_filter_remnull($mediabarcode);
?>
<script type="text/javascript">
<!--
	top.showfinish();
//-->
</script>

<table width=100% cellpadding=0 cellspacing=0 border=10 bordercolor=red>
<tr valign=top>
	<td width=300 style="max-width: 300px;" align=center valign=top  style="vertical-align: top;"><?php 

	$sql2="select * from member where UserAdminID='$memberbarcode'";
			//echo ($sql2);
			$result2=tmq($sql2);
				$nnnn=tmq_num_rows($result2);
				$s=tmq_fetch_array($result2);

			if ($nnnn == 0)
				{
				html_dialog("","ไม่พบรหัสสมาชิกนี้! กรุณาระบุใหม่ ::l::Barcode id not found!");
				die();
				}

				local_gethtml("out_scanmatbc");
		?>

<IMG SRC='<?php  echo member_pic_url($memberbarcode);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''>
	<TABLE cellpadding=0 border=0 cellspacing=0 width=100% style="max-width: 300px;" > 
	<TR>
		<TD class=table_head <?php  echo $addhtmlsizehead;?>><?php  echo getlang("Barcode::l::Barcode");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[UserAdminID]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ชื่อ::l::Name");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_member_name($s[UserAdminID]);	?></TD>
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
		//echo getlang($rooms[name]);?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ที่อยู่::l::Address");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[address]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("อายุสมาชิก::l::Expire");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  
		//printr($s);
                if ($s[dat] != "" && $s[dat] != 0) {
                    $todate=GregorianToJD2(date('n'), date('j'), date('Y')+543);
                    $mbdate=GregorianToJD2($s[mon], $s[dat], $s[yea]);
					$edt=mktime(0, 0, 0, $s[mon], $s[dat], $s[yea]-543);
                    if ($mbdate >= $todate) {
                        //echo "สมาชิกยังไม่หมดอายุ";
						echo ymd_datestr($edt,'date');
						echo " <font class=smaller>".ymd_ago($edt)."</font>";
                    } else {
                        echo "<b style='color:red' class=smaller>Expired:".ymd_datestr($edt,'date')."</b>";
 						echo " <font class=smaller>".ymd_ago($edt)."</font>";
                   }
                } else {
                    echo getlang("ไม่มีการกำหนดวันหมดอายุสมาชิก::l::No expire date defined");
                }
		?></TD>
	</TR>
</TABLE>
										<?php 
	?></td>
	<td  valign=top style="vertical-align: top;"><?php 
	@reset($mediabarcode);
	while (list($k,$v)=each($mediabarcode)) {
			$res=cir_checkout($memberbarcode,$v,date("j"),date("n"),date("Y")+543);
			array_unshift($bcoutlist, $res);
			//$bcoutlist[$v]=$res;
	}
	@reset($bcoutlist);
	while (list($k,$res)=each($bcoutlist)) {
				//echo "[$k]";

		//printr($res);
		$tmpstatus_only=$res[status];
		?><table width=100% cellspacing=0>
		<tr valign=top>
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
			echo "<b style='color:darkred'>".getlang("ไม่สามารถให้ยืมได้::l::Cannot Checkout")."</b><br>";
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
	
	$bcoutlist=serialize($bcoutlist);
	sessionval_set("bcoutlist",$bcoutlist);
	?></td>
</tr>
</table>