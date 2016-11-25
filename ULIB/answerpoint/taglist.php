<?php 
include("../inc/config.inc.php");
$_REQPERM="answerpoint";
head();
        mn_lib();

$tbname="webpage_answerpoint_tag";

pagesection(getlang("แก้ไขแท็กในระบบ AnswerPoint::l::Edit tag for AnswerPoint"));

$c[2][text]="ข้อความ::l::Tag name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

//dsp


$dsp[2][text]="ข้อความ::l::Tag name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"name");

?><CENTER><A HREF="<?php  echo $dcrURL?>/answerpoint/">
<B><?php echo getlang("กลับไปยัง Answerpoint::l::Back to AnswerPoint");?>
</B></A></CENTER><?php 
foot();
?>
