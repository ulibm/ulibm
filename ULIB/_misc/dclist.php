<?php 
include("../inc/config.inc.php");
html_start();
$tbname="keyhelp_dclist";
?><TABLE cellpadding=0 cellspacing=0 class=table_border width=100%>
	<TR>
	<TD class=table_td>
	<?php 
		 for ($i=0;$i<=9;$i++) {
		  	 echo " ";
		 		 $class1name=$i."00";
				 
				 if ("$class1"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='dclist.php?parentjsid=$parentjsid&class1=$i'>";
		 		 echo $class1name;
				 echo "</a>";
			 		echo "</b>";
		 }
		?>
		<?php 	if ($class1!="") {
				$t=tmq("select * from $tbname where dc='$class1"."00' ");
				$t=tmq_fetch_array($t);
				echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text] ]";
		?>
		 <a href='dclist.php?parentjsid=<?php  echo $parentjsid?>&class1='> back </a>
		<?php  } ?>
	</TD>
</TR>
<?php 	if ($class1!="") {?>
	<TR>
	<TD class=table_td>
	<?php 

		 for ($i=0;$i<=9;$i++) {
		  	 echo " ";
		 		 $class2name=$class1.$i."0";
				 
				 if ("$class2"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='dclist.php?parentjsid=$parentjsid&class1=$class1&class2=$i'>";
		 		 echo $class2name;
				 echo "</a>";
		 		echo "</b>";
		 }
		 
		 if ($class2!="") {
				$t=tmq("select * from $tbname where dc='$class1$class2"."0' ");
				$t=tmq_fetch_array($t);
				echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text] ]";
		  } ?>

	</TD>
</TR>
<?php }?>

<?php 	if ($class2!="") {?>
	<TR>
	<TD class=table_td>
	<?php 

		 for ($i=0;$i<=9;$i++) {
		  	 echo " ";
		 		 $class3name=$class1.$class2.$i;
				 
				 if ("$class3"=="$i") {
				 		echo "<b>";
				 }
		 		 echo "<a href='dclist.php?parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=$i'>";
		 		 echo $class3name;
				 echo "</a>";
		 		echo "</b>";

		 }
		 
		 	if ($class3!="") {
				$t=tmq("select * from $tbname where dc='$class1$class2$class3' ");
				$t=tmq_fetch_array($t);
				echo " <br />&nbsp;&nbsp;&nbsp;[ $t[text] ]";
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
	$r= "<INPUT TYPE=text NAME='' value='$wh[dc]' style='cursor: hand; cursor: pointer;; width: 80; text-align:center' ";
	if ($parentjsid!="") {
		$r.=" onclick=\"parent.getobj('$parentjsid').value=parent.getobj('$parentjsid').value+'^a$wh[dc]'; parent.showhidesuggestme_justhide(); return true;\" ";
	}
	$r.=" noonclick=\"copyText(this)\" onclick=\"this.select()\">";
	return $r;
}
function localclicker($wh) {
	 global $parentjsid;
	 global $class1;
	 global $class2;
	 global $class3;
	 $wh[dc]=trim($wh[dc]);
	if ($class1=="") {
		$limit="<a href='dclist.php?parentjsid=$parentjsid&class1=".substr($wh[dc],0,1)."'>";
	} else {
		if ($class2=="") {
				 $limit="<a href='dclist.php?parentjsid=$parentjsid&class1=$class1&class2=".substr($wh[dc],1,1)."'>";
		} else {
			if ($class3=="") {
				 $limit="<a href='dclist.php?parentjsid=$parentjsid&class1=$class1&class2=$class2&class3=".substr($wh[dc],2,1)."'>";
			} else {
				 $limit="";
			}
		}
	}
	return "$limit$wh[text]</a>";
}
$dsp[2][text]="DC";
$dsp[2][field]="dc";
$dsp[2][align]="center";
$dsp[2][width]="10%";
$dsp[2][filter]="module:copier";

$dsp[3][text]="คำอธิบาย::l::Description";
$dsp[3][field]="text";
$dsp[3][width]="80%";
$dsp[3][filter]="module:localclicker";


if ($class1=="") {
	$limit=" 1 and dc like '_00%' and length(dc) <=3 ";
} else {
	if ($class2=="") {
		 $limit=" 1 and dc like '$class1"."_0%' and length(dc) <=3 ";
	} else {
  	if ($class3=="") {
  		 $limit=" 1 and dc like '$class1$class2"."_%'  and length(dc) <=3 ";
  	} else {
  		 $limit=" 1 and dc like '$class1$class2$class3%' ";
  	}
	}
}

$o[tablewidth]="100%";

fixform_tablelister($tbname," $limit  ",$dsp,"no","no","no","class1=$class1&class2=$class2&class3=$class3&parentjsid=$parentjsid",$c," dc",$o);
?>