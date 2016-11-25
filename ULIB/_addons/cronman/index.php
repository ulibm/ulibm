<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");

$now=time();
html_dialog("","Cron Manager เป็นเครื่องมือช่วยจัดการการตั้งค่าของโปรแกรม Cron สำหรับเซิร์ฟเวอร์ลีนุกซ์ (หรือบนวินโดวส์ผ่าน Cygwin) <BR>");
pagesection(getlang("Cron Manager"));


$tbname="addonsdb_cronman";


$c[1][text]="ชื่อเรียก::l::Name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$timedescr=explode(",",",Minutes,Hours,Days,Month,Days of the week");
for ($i=1;$i<=5;$i++) {
   $c[10+$i][text]="".$timedescr[$i];
   $c[10+$i][field]="t$i";
   $c[10+$i][fieldtype]="text";
   $c[10+$i][descr]="";
   $c[10+$i][defval]="*";
}

$c[2][text]="Command";
$c[2][field]="cmd";
$c[2][fieldtype]="longtext";
$c[2][descr]="<br> replace space with \\space";
$c[2][defval]="";

//dsp

$dsp[1][text]="ชื่อเรียก::l::Name";
$dsp[1][field]="name";
$dsp[1][width]="20%";

$dsp[3][text]="Schedule";
$dsp[3][field]="name";
$dsp[3][filter]="module:localdsp";
$dsp[3][width]="20%";

function localdsp($w) {
   return "$w[t1] $w[t2] $w[t3] $w[t4] $w[t5] <BR><a href='index.php?viewlog=$w[id]' class='smaller2 a_btn'>View log</a>";
}

$dsp[2][text]="Command";
$dsp[2][field]="cmd";
$dsp[2][width]="60%";

?><center><a href="config.php?refresh=true" class=a_btn>Settings</a></center><?php
$viewlog=floor($viewlog);
if ($viewlog!=0) {
?>
<table align=center width=1000><tr><td bgcolor=#f0f0f0>
<?php 
   $s=tmq("select * from addonsdb_cronman where id='$viewlog' ");
   if (tnr($s)==0) {
      die("id [$viewlog] not found");
   }
   $s=tfa($s);
   $logpath=barcodeval_get("addons-cronman-cronlogfilecmd");
   $logpath=str_replace("%file","$viewlog",$logpath);
   $logpath2=str_replace("/","\\",$logpath);
   //echo "[$logpath]";
   //echo "[$logpath2]";
   $dat1=`$logpath`;
   $dat2=`$logpath2`;
   $dat=$dat1.$dat2;
   echo "Last Result:<br>".$dat."<hr noshade>";
   //echo "viewlog";
   $cmd=barcodeval_get("addons-cronman-cronlogcmd");
   $dat=`$cmd`;
   $data=explodenewline($dat);
   //$s[cmd]=str_replace(" ","\\ ",$s[cmd]);
   while (list($k,$v)=each($data)) {
      //echo "$s[cmd]--$v<hr>";
      if (strpos($v,"$s[cmd]")!==false) {
         $va=explode(" CMD ",$v);
         $va=$va[0];
         echo "&bull; ".$va."<BR>";
      }
   }
?>
</td></tr></table>
<?php
}

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);
?>
<table align=center width=1000><tr><td>
<?php 
include("examples.php");

$s=tmq("select * from $tbname");
if (tnr($s)!=0) {
echo "<BR>Copy the following text to the end of your crontab file (usually /etc/crontab)<br>
<textarea style='width:100%; background-color: #eeeeee; height: 300px; font-size: 11px;'>#start ulib addon cronman
";
$logpath=barcodeval_get("addons-cronman-cronlogpath");
$logpath=str_replace(" ","\\ ",$logpath);

while ($r=tfa($s)) {
   $r[cmd]=str_replace("\\\\","\\",$r[cmd]);
   echo $r[t1]."\t".$r[t2]."\t".$r[t3]."\t".$r[t4]."\t".$r[t5]."\t".$r[cmd]." &gt; $logpath$r[id].txt 2&gt;&1\n";
}
echo "#end ulib addon cronman</textarea>";
   ?><?php
}

?>
</td></tr></table>
<?php
foot();
?>