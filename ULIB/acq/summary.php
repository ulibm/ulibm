<?php 
include("./cfg.inc.php");
include("./head.php");

?><?php 
pagesection("สรุปตามร้านค้า (เฉพาะรายการที่สั่งซื้อ)");
$s=tmq("select distinct s_store from acqn_sub where (stat='ordering' or stat='bookrecieve')  and pid='$pid' group by s_store,stat");
?><table class=table_border align=center width=780>
<tr>
	<td class=table_head>ร้านค้า</td>
	<td class=table_head width=20%>จำนวนรายการ</td>
	<td class=table_head width=20%>จำนวนเงิน</td>
	<td class=table_head width=20%>จำนวนรายการ<br> (รับตัวเล่มแล้ว)</td>
	<td class=table_head width=20%>จำนวนเงิน<br> (รับตัวเล่มแล้ว)</td>
</tr><?php 
$sum1=0;
$sum2=0;
while ($r=tfa($s)) {
	?><tr>
	<td class=table_td><?php  echo $r[s_store];?></td>
	<td class=table_td align=right><?php  
	$p=tmq("select sum(pricenet) as pp,count(id) as cc from acqn_sub where (stat='ordering' or stat='bookrecieve' )  and s_store='".addslashes($r[s_store])."' and pid='$pid' ");
	$p=tfa($p);
	echo $p[cc];
	$sum1=$sum1+$p[cc];
	$sum2=$sum2+$p[pp];
	$lastc=$p[cc];

	?></td>
	<td class=table_td align=right><?php  


	echo number_format($p[pp],2);?></td>
	<td class=table_td align=right><?php  
	$p=tmq("select sum(pricenet) as pp,count(id) as cc from acqn_sub where (stat='bookrecieve' )  and s_store='".addslashes($r[s_store])."' and pid='$pid' ");
	$p=tfa($p);
	if ($p[cc]==$lastc) {
		echo "<b style='color:darkgreen'>";
	}
	echo $p[cc];?></td>
	<td class=table_td align=right><?php  
	if ($p[cc]==$lastc) {
		echo "<b style='color:darkgreen'>";
	}
	echo number_format($p[pp],2);?></td>
</tr><?php 
	$sum3=$sum3+$p[cc];
	$sum4=$sum4+$p[pp];
}
?><tr>
	<td class=table_head2>รวม</td>
	<td class=table_head2><?php  
	echo number_format($sum1);?></td>
	<td class=table_head2 align=right><?php  
	echo number_format($sum2,2);?></td>
	<td class=table_head2><?php  
	echo number_format($sum3);?></td>
	<td class=table_head2 align=right><?php  
	echo number_format($sum4,2);?></td>
</tr>
</table>

<?php 
pagesection("สรุปตามคณะ (เฉพาะรายการที่สั่งซื้อ)");
$s=tmq("select distinct s_subj,count(id) as cc from acqn_sub where (stat='ordering' or stat='bookrecieve')  and pid='$pid' group by s_subj");
?><table class=table_border align=center width=780>
<tr>
	<td class=table_head>คณะ</td>
	<!-- <td class=table_head>จำนวนรายการ</td>
	<td class=table_head>จำนวนเงิน</td> -->
</tr><?php 
$sum1=0;
$sum2=0;
while ($r=tfa($s)) {
	?><tr>
	<td class=table_head2 style="text-align:left;"><?php  echo $r[s_subj];
	if ($r[s_subj]=="") {
		echo "ไม่ระบุ";
	}
	?></td>
	<!-- <td class=table_head2 align=right><?php  echo $r[cc];?></td>
	<td class=table_head2 align=right><?php  
	$p=tmq("select sum(pricenet) as pp from acqn_sub where stat='ordering' and s_subj='".addslashes($r[s_subj])."' and pid='$pid' ");
	$p=tfa($p);

	echo number_format($p[pp],2);?></td> -->
</tr>
<tr>
	<td class=table_td >
	
	
			<table ssclass=table_border align=right width=70%>
			<tr>
				<td sclass=table_head2><b>ร้านค้า</b></td>
				<td class=table_head2 width=20%>จำนวนรายการ</td>
				<td class=table_head2 width=20%>จำนวนเงิน</td>
				<td class=table_head2 width=20%>จำนวนรายการ<br> (รับตัวเล่มแล้ว)</td>
				<td class=table_head2 width=20%>จำนวนเงิน<br> (รับตัวเล่มแล้ว)</td>			</tr><?php 
			$ss=tmq("select s_store,count(id) as cc from acqn_sub where s_subj='".addslashes($r[s_subj])."' and (stat='ordering' or stat='bookrecieve')  and pid='$pid' group by s_store ",false);

			$sums1=0;
			$sums2=0;
			while ($rs=tfa($ss)) {
				?><tr>
				<td class=table_td><?php  echo $rs[s_store];?></td>
				<td class=table_td align=right><?php  
				$p=tmq("select sum(pricenet) as pp,count(id) as cc from acqn_sub where s_subj='".addslashes($r[s_subj])."' and (stat='ordering' or stat='bookrecieve')  and s_store='".addslashes($rs[s_store])."' and pid='$pid' ");
				$p=tfa($p);
				echo $p[cc];?></td>
				<td class=table_td align=right><?php  
				$sums1=$sums1+$p[cc];
				$sums2=$sums2+$p[pp];
				$lastc=$p[cc];
				echo number_format($p[pp],2);?></td>
				<td class=table_td align=right><?php  
				$p=tmq("select sum(pricenet) as pp,count(id) as cc from acqn_sub where s_subj='".addslashes($r[s_subj])."' and ( stat='bookrecieve')  and s_store='".addslashes($rs[s_store])."' and pid='$pid' ");
				$p=tfa($p);
				if ($p[cc]==$lastc) {
					echo "<b style='color:darkgreen'>";
				}
				echo $p[cc];?></td>
				<td class=table_td align=right><?php  
				if ($p[cc]==$lastc) {
					echo "<b style='color:darkgreen'>";
				}
				$sums3=$sums3+$p[cc];
				$sums4=$sums4+$p[pp];
				echo number_format($p[pp],2);?></td>

			</tr><?php 

			}
			?><tr>
				<td sclass=table_head2 align=center><b>รวมของคณะ <?php 
				echo $r[s_subj];	
			?></b></td>
				<td sclass=table_head2 width=100 align=center><b><?php  
				echo number_format($sums1);?></b></td>
				<td sclass=table_head2 align=right width=100><b><?php  
				echo number_format($sums2,2);?></b></td>
				<td sclass=table_head2 width=100 align=center><b><?php  
				echo number_format($sums3);?></b></td>
				<td sclass=table_head2 align=right width=100><b><?php  
				echo number_format($sums4,2);?></b></td>
			</tr>
			</table>


	
	</td>
</tr>
<?php 
	$sum1=$sum1+$r[cc];
	$sum2=$sum2+$p[pp];
}
?><<!-- tr>
	<td class=table_head2>รวม</td>
	<td class=table_head2><?php  
	echo number_format($sum1,2);?></td>
	<td class=table_head2 align=right><?php  
	echo number_format($sum2,2);?></td>
</tr> -->
</table><?php 
foot();
?>