<?php 

?>
                <div align = "center">
<?php 
//pagesection(getlang("ตัวเลือกระบบระบบการให้คะแนน Bib::l::Bib. Rating system options"));
$restore=trim($restore);
if ($restore!="") {
   $s=tmq("select * from upclass_hist_sub where pid='$restore' ");
   while ($r=tfa($s)) {
      $sql="update member set room='$r[from1]' where UserAdminID='$r[memberid]' ";
      //echo $sql."<BR>";
      tmq($sql);
   }
   echo "<center><font style='font-size: 32;color: darkblue;'>Restore Done.</font></center>";
}
$tbname="upclass_hist";



$dsp[6][text]="Date time";
$dsp[6][field]="dt";
$dsp[6][align]="center";
$dsp[6][filter]="datetime";
$dsp[6][width]="30%";

function local_info($wh) {
	return get_library_name($wh[loginid]);
}

$dsp[2][text]="Librarian";
$dsp[2][field]="id";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_info";

function local_info2($wh) {
   $cc=tmq("select count(id) as cc from upclass_hist_sub where pid='$wh[code]' ");
   $ccr=tfa($cc);
	return number_format($ccr[cc])." records <a onclick=\"return confirm('Confirm restore');\" href='index.php?mode=history&restore=$wh[code]'>restore</a>";
}

$dsp[3][text]="Operation";
$dsp[3][field]="id";
$dsp[3][width]="50%";
$dsp[3][filter]="module:local_info2";




fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mode=$mode",$c," id desc ");         
         
        $s=tmq("select * from room where id in (select to1 from upclass_rule) and id not in (select from1 from upclass_rule)");
   if (tnr($s)==0) {
      html_dialog("error","<b style='color:darkred;'>Looped setting</b>");
   }    

?>