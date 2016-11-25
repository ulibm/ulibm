<?php 
include("../inc/config.inc.php");
html_start();
$tagnamedb=tmq_dump("bkedit_authority","fid","name");

$laststr=trim($laststr);
$laststr=trim($laststr,'.');
$laststr=trim($laststr);
if (strlen($laststr)<3) {
	html_dialog("",getlang("กรุณากรอกข้อมูลยาวกว่านี้::l::Please enter longer information"));
	die;
}

if ($addnow=="yes" && $addtotag!="") {
	$s=tmq("select * from authoritydb_rule where workonmarctag like '%$tagid%'");
	if (tmq_num_rows($s)!=0) {
		$s=tmq_fetch_array($s);
		tmq("insert into authoritydb set $addtotag='$laststr' ,tag999='  ^a".get_library_name($useradminid)."' ");
	}
}
//printr($_GET);
?>
<script>
function addthis(wh) {
	//alert(parent);
	//alert(wh);
 <?php 
 $chk=tmq("select * from bkedit where fid='$tagid' ");
 $chk=tmq_fetch_array($chk);
$defindi1=mb_substr($chk[defindi1],0,1);
$defindi2=mb_substr($chk[defindi2],0,1);
if ($defindi1=='' || $defindi1=='b') {
	$defindi1='_';
}
if ($defindi2=='' || $defindi2=='b') {
	$defindi2='_';
}
 if ($chk[isrepeat]!="R") {
 		?>
		  parent.getobj('result_<?php  echo $tagid?>').innerHTML='';
		 	newid=parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",wh,"no");
			//alert(newid);
			//alert(wh);
			parent.setlastfocus("data"+newid);
			parent.showhidesuggestme_justhide();
			<?php 
 } else {
 ?> 
     parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",""+wh+"","yes");
	 <?php 
 }
 ?>

}
</script>
<?php 


function copier($wh) {
	global $parentjsid;
	$wh[word1]=(mb_substr($wh[word1],2,mb_strlen($wh[word1])));
	if ($parentjsid=="") {
		$s= "<INPUT TYPE=text NAME='' value='$wh[word1]' style='cursor:hand; cursor: pointer; width: 100%' 
		noonclick=\"copyText(this)\" onclick=\"this.select()\">";
	} else {
		$dsp=dspmarc($wh[word1]);
		$dsp=str_remspecialsign($dsp);      			
		$s="<a href='javascript:void(0)' onclick=\"addthis('".addslashes($wh[word1])."');\" class=smaller>$dsp</a>";
	}
	return $s;
}


$s=tmq("select * from authoritydb_rule where workonmarctag like '%$tagid%'");
$sql=" 0 ";
while ($r=tmq_fetch_array($s)) {
	$sql.=" or $r[fid] like '%$laststr%' ";
}
$chk=tmq("select * from authoritydb where $sql",false);
if (tmq_num_rows($chk)==0) {
	echo getlang("ไม่พบ [$laststr] ในฐานข้อมูล Authority Control ต้องการเพิ่มทันทีหรือไม่?::l:: [$laststr] not found in Authority Control database, add now?")." ";
	echo getlang("เพิ่มใน::l::Add to").":";
	$s=tmq("select distinct fid from authoritydb_rule where workonmarctag like '%$tagid%' order by checkmode ");

	while ($r=tmq_fetch_array($s)) {
		$tagname=tmq("select * from bkedit_authority where fid='$r[fid]' ");
		if (tmq_num_rows($tagname)!=0) {
			$tagname=tmq_fetch_array($tagname);
			echo "<A class='a_btn smaller' HREF='auth.php?mid=$mid&tagid=$tagid&parentjsid=$parentjsid&laststr=$laststr&addnow=yes&addtotag=$r[fid]'>".$tagname[name]."($r[fid])</A>";
		}
	}
	die;
} else {
	echo "<B>".getlang("รายการที่มีในฐานข้อมูล Authority Control แล้ว::l::Record(s) exists in Authority Control Database")."</B><BR>";
	while ($chkr=tmq_fetch_array($chk)) {
		$tmp=explode(',',"tag100,tag110,tag111,tag130,tag148,tag150,tag151,tag155,tag180,tag181,tag182,tag185");
		while (list($k,$v)=each($tmp)) {
			if ($chkr[$v]!="") {
				echo "<FONT class=smaller>".$tagnamedb[$v].":<A class='a_btn smaller' HREF='javascript:void(null);' onclick=\"addthis('".mb_substr($chkr[$v],0,mb_strlen($chkr[$v]))."')\">".mb_substr($chkr[$v],0,mb_strlen($chkr[$v]))."</A></FONT> ";
			}
		}
	}
	echo "<BR>";
}
/////////////////////

$s=tmq("select * from authoritydb_rule where workonmarctag like '%$tagid%' order by checkmode ");

while ($r=tmq_fetch_array($s)) {
	$resultdsp="";
	$resultdsp.= "<B>".ucwords(strtolower($r[checkmode])) . "</B> ";
	$s2=tmq("select * from authoritydb where $r[fid] like '%$laststr%' ");
	$dspcount=0;
	$resultdsp.=$tagnamedb[$r[pullfromtag]];
	while ($r2=tmq_fetch_array($s2)) {
		$datalist=explodenewline($r2[$r[pullfromtag]]);
		while (list($k1,$v1)=each($datalist)) {
			$str=marc_getsubfields($v1,"no");
			$str[w]="";
			$str2="";
			while (list($k,$v)=each($str)) {
				if ($v!="") {
					$str2.=" ".$v;//"=".$r2[$r[pullfromtag]];
				}
			}
			if (trim($str2)!="") {
				$dspcount++;
				$addstr="";
				@reset($str);
				while (list($kadd,$vadd)=each($str)) {
					if ($vadd!="") {
						$addstr.="^$kadd$vadd";
					}
				}
				$resultdsp.= " <nobr>&bull; <A HREF='javascript:void(null);' onclick=\"addthis('$addstr')\">".$str2."</A></nobr> ";
			}
		}
	}
	if ($dspcount>0) {
		echo $resultdsp;
		echo "<BR>";
	}
}


?>