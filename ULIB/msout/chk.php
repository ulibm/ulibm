<?php 
	include ("../inc/config.inc.php");
	html_start();
	include("_REQPERM.php");
	if (!library_gotpermission($_REQPERM)) {
		html_dialog("error","no permission $_REQPERM "); die;
	}
	function localdsp($mode,$descr) {
		global $thaimonstr;
		global $memberspechtml;
		global $dcr;
		global $thaimonstrbrief;

		if ($mode=="error") {
			?><td colspan=2 align=center bgcolor=#ffecec><font style="font-size: 24px; color: red;"><?php  echo getlang($descr); ?></font></td><?php 
		}
		if ($mode=="normal") {
			$pid=tmq("select * from media_mid where bcode='$descr' ");
			$pid=tfa($pid);
			?><td  width=300><?php echo res_brief_dsp($pid[pid]);?></td><td ><?php 
	$pass=false;

	$s=tmq("select * from useinsidelib where bcode='$descr'  ");
	if (tmq_num_rows($s)!=0) {
		$pass=true;
		$s=tmq_fetch_array($s);
		
		?><TABLE width=100% class=table_border>
		<TR>
			<TD rowspan=4><?php  echo "[$descr] ".getlang("ถูกยืม โดย::l::Checkedout By")." ".get_member_name($s[hold]);?><br><IMG SRC='<?php  echo member_pic_url($s[hold]);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''></TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("วันยืม::l::Checkout date");?></TD>
			<TD><?php  echo ymd_datestr($s[dt]);;?>  <?php  echo ymd_ago($s[dt]);;?> </TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("วันยืม::l::Checkout date");?></TD>
			<TD><?php  echo ymd_datestr($s[dt]);;?>  <?php  echo ymd_ago($s[dt]);;?> </TD>
		</TR>
		<TR>
			<TD class=table_head><?php  echo getlang("โดย::l::By");?></TD>
			<TD><?php  echo get_library_name($s[loginid])?> </TD>
		</TR>		
		</TABLE><?php 	
	} 
$s=tmq("select * from checkout where mediaId='$descr' ");	
	if (tmq_num_rows($s)!=0) {
		$pass=true;
		$s=tmq_fetch_array($s);
		//echo "[$descr] ".getlang("ถูกยืม โดย::l::Checkedout By")." ".get_member_name($s[hold]);
		$membertype=tmq("select * from member where UserAdminID='$s[hold]' ");
		if (tnr($membertype)==0) {
			?><font style="font-size: 20px; color: red;"><?php  echo getlang("ไม่พบสมาชิก $s[hold] กรุณาตรวจสอบ::l::Member not found $s[hold] , please verify."); ?></font><?php 
		} else {
				$membertype=tfa($membertype);
			?><TABLE width=100% class=table_border>
					<TR>
			<TD rowspan=5 width=150><?php  echo "[$descr] ".getlang("ถูกยืม โดย::l::Checkedout By")." ".get_member_name($s[hold]);?><br><IMG SRC='<?php  echo member_pic_url($s[hold]);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''></TD>
		</TR>
		<TR>
				<TD class=table_head><?php  echo getlang("วันยืม::l::Checkout date");?></TD>
				<TD style="background-color: #f3ffec!important;"><?php  echo $s[sdat]." " . $thaimonstr[$s[smon]]." " . $s[syea];?></TD>
			</TR>
			<TR>
				<TD class=table_head><?php  echo getlang("วันส่ง::l::return date");?></TD>
				<TD style="background-color: #f3ffec!important;"><?php  echo $s[edat]." " . $thaimonstr[$s[emon]]." " . $s[eyea];?></TD>
			</TR>
			<TR>
				<TD class=table_head><?php  echo getlang("การจองต่อ::l::Request");?></TD>
				<TD style="background-color: #f3ffec!important;"><?php  
			if ($s[request]=="") {
				echo getlang("ไม่มีการจอง::l::No Request");
			} else {
				echo getlang("จอง โดย::l::Request By")." ".get_member_name($s[request]);
			}
			?></TD>
			</TR>
			<TR>
				<TD class=table_head><?php  echo getlang("การยืมต่อ::l::Renew");?></TD>
				<TD style="background-color: #f3ffec!important;"><?php  
				$maxrenew=tmq("select * from checkout_rule where member_type='$membertype[type]' and media_type='$s[RESOURCE_TYPE]' and libsite='$LIBSITE' ");
				if (tnr($maxrenew)==0) {
								?><font style="font-size: 20px; color: red;"><?php  echo getlang("ไม่พบกฏการยืมคืน $membertype[type]/$s[RESOURCE_TYPE] กรุณาตรวจสอบ::l::Checkout rule not found $membertype[type]/$s[RESOURCE_TYPE] , please verify."); ?></font><?php 

				} else {
					$maxrenew=tfa($maxrenew);
					echo getlang("ยืมต่อ ($s[renewcount]/".$maxrenew[renew].") ครั้ง::l::Renew ($s[renewcount]/".$maxrenew[renew].")");
				}
			

			?></TD>
			</TR>
			</TABLE><?php 
		}
	}
		if ($pass==false) {
			?><font style="font-size: 25px; color: red; background-color: #ffecec"><?php  echo getlang("[$descr] ทรัพยากรไม่ได้ถูกยืมออก โปรดทำการตรวจสอบ::l::This item [$descr]  not checked out, please verify."); ?></font><?php 
		}
		?></td><?php 
		}
	
	}
	$bcs=trim($bcs);
	$bcs=explode(",",$bcs);
	$bcsa=arr_filter_remnull($bcs);
	@reset($bcsa);
	$now=time();
	while (list($k,$v)=each($bcsa)) {
		tmq("insert into msout set dt=$now,bcode='$v' ");
	}
	$s=tmq("select * from msout order by id desc limit 30,1000");
	while ($r=tfa($s)) {
		tmq("delete from msout where id='$r[id]' ");
	}
	?><table width=100%>
	<?php 
	$s=tmq("select * from msout order by id desc ");
	while ($r=tfa($s)) {
		?><tr valign=top>
		<?php 
		$pid=tmq("select * from media_mid where bcode='$r[bcode]' ");
		if (tnr($pid)==0) {
			localdsp("error","ไม่พบบาร์โค้ด $r[bcode] กรุณาแยกหนังสือเพื่อลงทะเบียน");
		} else {
			$pid=tfa($pid);
			localdsp("normal",$r[bcode]);
		}
		?>
	</tr><?php 
	}
	?>
	</table>
	<script type="text/javascript">
	<!--
		parent.local_clearform();
	//-->
	</script><?php 
?>