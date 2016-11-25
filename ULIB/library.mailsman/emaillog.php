<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="mailsman";
mn_lib();
if ($deleteall=="yes") {
	tmq("delete from email_log");
}
$tbname="email_log";

$c=Array();

//dsp
/*
$dsp[4][text]="Icon::l::Icon";
$dsp[4][field]="icon";
$dsp[4][filter]="module:localicon";
$dsp[4][width]="10%";
*/
$dsp[2][text]="วันเดือนปี::l::Date";
$dsp[2][field]="dt";
$dsp[2][filter]="datetime";
$dsp[2][width]="20%";

$dsp[7][text]="ข้อมูล";
$dsp[7][field]="setid";
$dsp[7][width]="50%";
$dsp[7][filter]="module:local_info";

/*
$dsp[5][text]="ส่ง::l::Send";
$dsp[5][field]="id";
$dsp[5][align]="center";
$dsp[5][filter]="module:local_send";
$dsp[5][width]="15%";

$dsp[6][text]="คำสั่ง::l::Command";
$dsp[6][field]="name";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_cmd";
$dsp[6][width]="16%";

*/
function local_info($wh) {
	$wh[body]=mb_substr($wh[body],0,150)."..";
		$s="<b><a href='emaillog.read.php?read=$wh[id]' rel=\"gb_page_fs[]\">".stripslashes($wh[subj])."</a></b>";
	$s.="<br>
	To: $wh[toemail]<br>
	".stripslashes($wh[body])."";
				 return "<FONT class=smaller>$s</FONT><FONT class=smaller2><BR>".getlang("ส่งโดย::l::Send by")." ".get_library_name($wh[libid])."</FONT>";;
}
?><center><form method="post" action="">
<?php  echo getlang("ค้นหา::l::Search");?>	<input type="text" name="kw" value="<?php  echo $kw?>"> <input type="submit" value="Search">
</form></center><?php 
$limit=" 1 ";
if ($kw!="") {
	$limit=" 1 and (subj like '%".addslashes($kw)."%' or body like '%".addslashes($kw)."%' ) ";
}
fixform_tablelister($tbname," $limit ",$dsp,"yes","no","no","mi=$mi&kw=$kw",$c,'id desc',$o,"");
?><center><a href="emaillog.php?deleteall=yes" class=a_btn style='color: darkred' onclick="return confirm('Please confirm');"><?php  echo getlang("Clear all log");?></a></center><?php 

foot();
?>