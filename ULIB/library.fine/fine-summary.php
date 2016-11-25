<?php 
    ;
	include("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
	pagesection("สรุปค่าปรับ::l::Fine Summary");
	function localsepper($str) {
		?><b><?php  echo getlang($str);?></b><hr noshade><?php 
	}
		$dts=form_pickdt_get("dts");
		$dte=form_pickdt_get("dte");
		if (floor($dts)==0) {
			$dts=ymd_mkdt(date("d"),date("m")-1,date("Y"));
		}
		if (floor($dte)==0) {
			$dte=ymd_mkdt(date("d"),date("m"),date("Y"));
		}
		$dtsql=" and (
			dt>=$dts and dt<=".($dte+(60*60*24))."
		)";
		$linkparam="&dts=$dts&dte=$dte";
	?>
	<table width=650 align=center>
	<tr>
		<td>

		<form method="post" action="<?php  echo $PHP_SELF; ?>">
			<table width=100%>
		<tr>
			<td align=right><?php  echo getlang("เริ่มจากวันที่::l::From");?>
			</td>
			<td> <?php 
			form_quickedit("dts",$dts,"date");
			?></td>
		</tr>		<tr>
			<td align=right>
			<?php  echo getlang("ถึงวันที่::l::To");?>
			</td>
			<td> <?php 
			form_quickedit("dte",$dte,"date");
			?>  <input type="submit" value=" View "></td>
		</tr>
		</table>
		</form><br>
<center><a href="print.php?dts=<?php  echo $dts;?>&dte=<?php  echo $dte;?>" target=_blank class=a_btn><?php  echo getlang("พิมพ์::l::Print") ?></a></center>
		<?php  localsepper("แยกตามประเภทสมาชิก::l::By member type"); ?>
		<table width=100% class=table_border>
		<tr>
			<td class=table_head width=50%>-</td>
			<td class=table_head width=25%><?php  echo getlang("เงิน::l::Cach");?></td>
			<td class=table_head width=25%><?php  echo getlang("Credit");?></td>
		</tr>
<?php 
		$s=tmq("select * from member_type order by descr");
		while ($r=tfa($s)) {
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and member in (select UserAdminID from member where type='$r[type]' )
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><a href="fine-report.php?membertype=<?php echo $r[type] . $linkparam;?>" target=_blank><?php  echo html_membertype_icon("$r[type]").getlang($r[descr])?></a></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>			<?php 
		}
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and member not in (select UserAdminID from member where 1 )
			",false);
			$cr=tfa($c);
?>		
<tr>
			<td class=table_td>Others</td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>	
		</table>
		<br>
		
	
		<?php  localsepper("แยกตามชื่อเจ้าหน้าที่ห้องสมุด::l::By Librarian"); ?>
		<table width=100% class=table_border>
		<tr>
			<td class=table_head width=50%>-</td>
			<td class=table_head width=25%><?php  echo getlang("เงิน::l::Cach");?></td>
			<td class=table_head width=25%><?php  echo getlang("Credit");?></td>
		</tr>
<?php 
		//$s=tmq("select * from library order by UserAdminName");
		$s=tmq("select distinct lib as UserAdminID from finedone order by lib");
		while ($r=tfa($s)) {
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and lib='$r[UserAdminID]' 
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><a href="fine-report.php?library=<?php echo $r[UserAdminID] . $linkparam;?>" target=_blank><?php  echo get_library_name($r[UserAdminID])?></a></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>			<?php 
		}
?>		
		</table>
		<br>

		<?php  localsepper("แยกตามสาขาของเจ้าหน้าที่ห้องสมุด::l::By Campus of Librarian"); ?>
		<table width=100% class=table_border>
		<tr>
			<td class=table_head width=50%>-</td>
			<td class=table_head width=25%><?php  echo getlang("เงิน::l::Cach");?></td>
			<td class=table_head width=25%><?php  echo getlang("Credit");?></td>
		</tr>
<?php 
		$s=tmq("select * from library_site order by name");
		while ($r=tfa($s)) {
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and lib in  (select UserAdminID from library where libsite='$r[code]' )
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><a href="fine-report.php?libsite=<?php echo $r[code] . $linkparam;?>" target=_blank><?php  echo get_libsite_name($r[code])?></a></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>			<?php 
		}
					$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and lib  not in  (select UserAdminID from library where 1 )
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><?php  echo getlang("Others");	?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>

		</table>
		<br>
		
		<?php  localsepper(getlang("แยกตาม ::l::By ").getlang($_ROOMWORD)); ?>
		<table width=100% class=table_border>
		<tr>
			<td class=table_head width=50%>-</td>
			<td class=table_head width=25%><?php  echo getlang("เงิน::l::Cach");?></td>
			<td class=table_head width=25%><?php  echo getlang("Credit");?></td>
		</tr>
<?php 
		$s=tmq("select * from room order by pid,name");
		while ($r=tfa($s)) {
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and member in  (select UserAdminID from member where room='$r[id]' )
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><a href="fine-report.php?room=<?php echo $r[id] . $linkparam;?>" target=_blank><?php  echo get_room_name($r[id])?></a></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>			<?php 
		}
?>		
		</table>
		<br>		


		<?php  localsepper(getlang("แยกตาม ::l::By ").getlang($_FACULTYWORD)); ?>
		<table width=100% class=table_border>
		<tr>
			<td class=table_head width=50%>-</td>
			<td class=table_head width=25%><?php  echo getlang("เงิน::l::Cach");?></td>
			<td class=table_head width=25%><?php  echo getlang("Credit");?></td>
		</tr>
<?php 
		$s=tmq("select * from major order by name");
		while ($r=tfa($s)) {
			$c=tmq("select sum(cach) as c1, sum(credit) as c2 from finedone 
			where 1 $dtsql 
			and member in  (select UserAdminID from member where major='$r[id]' )
			",false);
			$cr=tfa($c);
			?>
		<tr>
			<td class=table_td><a href="fine-report.php?major=<?php echo $r[id] . $linkparam;?>" target=_blank><?php  echo getlang($r[name])?></a></td>
			<td class=table_td align=right><?php  echo number_format($cr[c1]);?></td>
			<td class=table_td align=right><?php  echo number_format($cr[c2]);?></td>
		</tr>			<?php 
		}
?>		
		</table>
		<br>


		</td>
	</tr>
	</table>
	
	<?php 
	foot();
?>