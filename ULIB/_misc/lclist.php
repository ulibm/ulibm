<?php 
include("../inc/config.inc.php");
html_start();
$tbname="keyhelp_lclist";
$az=explode(',',$_STR_A_Z);
sort($az);

?><TABLE cellpadding=0 cellspacing=0 class=table_border width=100%>
	<TR>
	<TD class=table_td>
	<?php 
		 $sub=tmq("select distinct substring(num,1,1) as aa from $tbname where 1  ");
		 while ($subr=tmq_fetch_array($sub)) {
			 $i=$subr[aa];
			 echo " ";
		 		 $class1name=strtoupper($i)."";
				 
				 if ("$class1"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='lclist.php?parentjsid=$parentjsid&class1=$i'>";
		 		 echo $class1name;
				 echo "</a>";
			 		echo "</b>";
		 }
		?>
		<?php 	if ($class1!="") {
					$t=tmq("select * from $tbname where num like '$class1"."' ");
					echo " <br />";
					if (tmq_num_rows($t)!=0) {
						$t=tmq_fetch_array($t);
						echo " &nbsp;&nbsp;&nbsp;[ ".ucwords(strtolower($t[text]))." ]";
					} 
		?>
		 <a href='lclist.php?parentjsid=<?php  echo $parentjsid?>&class1='> back </a>
		<?php  } ?>
	</TD>
</TR>
<?php 	if ($class1!="") {?>
	<TR>
	<TD class=table_td>
	<?php 

		 $sub=tmq("select distinct substring(num,2,1) as aa from $tbname where num like '$class1%' ");
		 while ($subr=tmq_fetch_array($sub)) {
			 $i=$subr[aa];

		  	 echo " ";
		 		 $class2name="<FONT COLOR=aaaaaa>".$class1."</FONT>".($i)."";
				 
				 if ("$class2"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='lclist.php?parentjsid=$parentjsid&class1=$class1&class2=$i'>";
		 		 echo $class2name;
				 echo "</a>";
		 		echo "</b>";
		 }
		 
		 if ($class2!="") {
				$t=tmq("select * from $tbname where num='$class1$class2"."' ");
				echo " <br />";
				if (tmq_num_rows($t)!=0) {
					$t=tmq_fetch_array($t);
					echo " &nbsp;&nbsp;&nbsp;[ $t[text] ]";
				}
		  } ?>

	</TD>
</TR>
<?php }?>

<?php 	if ($class2!="") {?>
	<TR>
	<TD class=table_td>
	<?php 

		 $sub=tmq("select distinct substring(num,3,1) as aa from $tbname where num like '$class1$class2%' ");
		 while ($subr=tmq_fetch_array($sub)) {
			 $i=$subr[aa];
		  	 echo " ";
		 		 $class3name="<FONT COLOR=aaaaaa>".$class1.$class2."</FONT>".$i;
				 
				 if ("$class3"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='lclist.php?parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=$i'>";
		 		 echo $class3name;
				 echo "</a>";
		 		echo "</b>";

		 }
		 
		 	if ($class3!="") {
				$t=tmq("select * from $tbname where num='$class1$class2$class3' ");
				echo " <br />";
				if (tmq_num_rows($t)!=0) {
					$t=tmq_fetch_array($t);
					echo " &nbsp;&nbsp;&nbsp;[ $t[text] ]";
				}
		  }
		?>
	</TD>
</TR>
<?php }?>
</TABLE>
<?php 




//dsp
?><script language="javascript" type="text/javascript">
function copyText(theSel) {
if (!document.all) return; // IE only
theSel.select();
window.clipboardData.setData('Text',theSel.value);
}
</script> <?php 


function copier($wh) {
	 global $parentjsid;
	$r= "<INPUT TYPE=text NAME='' value='$wh[num]' style='cursor: hand; cursor: pointer;; width: 80; text-align:center' ";
	if ($parentjsid!="") {
		$r.=" onclick=\"parent.getobj('$parentjsid').value=parent.getobj('$parentjsid').value+'^a$wh[num]'; parent.showhidesuggestme_justhide(); return true;\" ";
	}
	$r.=" noonclick=\"copyText(this)\" onclick=\"this.select()\">";
	return $r;
}
function localclicker($wh) {
	 global $parentjsid;
	 global $class1;
	 global $class2;
	 global $class3;
	 $wh[num]=trim($wh[num]);
	if ($class1=="") {
		$limit="<a href='lclist.php?parentjsid=$parentjsid&class1=".substr($wh[num],0,1)."'>";
	} else {
		if ($class2=="") {
				 $limit="<a href='lclist.php?parentjsid=$parentjsid&class1=$class1&class2=".substr($wh[num],1,1)."'>";
		} else {
			if ($class3=="") {
				 $limit="<a href='lclist.php?parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=".substr($wh[num],2,1)."'>";
			} else {
				 $limit="";
			}
		}
	}
	return "$limit$wh[text]</a>";
}
$dsp[2][text]="LC";
$dsp[2][field]="num";
$dsp[2][align]="center";
$dsp[2][width]="10%";
$dsp[2][filter]="module:copier";

$dsp[3][text]="คำอธิบาย::l::Description";
$dsp[3][field]="text";
$dsp[3][width]="80%";
$dsp[3][filter]="module:localclicker";


if ($class1=="") {
	$limit=" 1 and num like '_%' and length(num) <=1 ";
} else {
	if ($class2=="") {
		 $limit=" 1 and num like '$class1"."_%' ";
	} else {
  	if ($class3=="") {
  		 $limit=" 1 and num like '$class1$class2"."_%'  ";
  	} else {
  		 $limit=" 1 and num like '$class1$class2$class3%' ";
  	}
	}
}

$o[tablewidth]="100%";


fixform_tablelister($tbname," $limit  ",$dsp,"no","no","no","class1=$class1&class2=$class2&class3=$class3&parentjsid=$parentjsid",$c," num",$o);
?>