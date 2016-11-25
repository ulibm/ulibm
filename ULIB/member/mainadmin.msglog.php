<?php 
if($row[email]!="") {

$dsp[3][text]="ข้อความ::l::Message";
$dsp[3][field]="foot";
$dsp[3][filter]="module:localmedia";
$dsp[3][width]="70%";
function localmedia($wh) {
    global $dcrURL;
	if ($wh[subj]=="") {
		$wh[subj]="-No-Title-";
	}
	$res="<a href='mainadmin.msglob.read.php?read=$wh[id]' rel=\"gb_page_fs[]\">".stripslashes($wh[subj])."</a>";
	return $res;
}

$dsp[7][text]="วันที่::l::Date";
$dsp[7][field]="dt";
$dsp[7][filter]="datetime";
$dsp[7][width]="30%";

$tbname="email_log ";
?><TABLE width=780 align=center>
<TR>
	<TD><?php 
fixform_tablelister($tbname," toemail='".addslashes($row[email])."' ",$dsp,"no","no","no","mempagemode=$mempagemode&submempagemode=$submempagemode",$c);
?></TD>
</TR>
</TABLE>&nbsp;<?php 

} else {
	html_dialog("Error",getlang("ในการที่จะดูประวัติการติดต่อจากบรรณารักษ์ คุณจะต้องกรอกอีเมล์ของคุณในส่วนของ [แก้ไขข้อมูลส่วนตัว]::l::Please enter your email in [edit persional information] to access this feature]"));
}


?>