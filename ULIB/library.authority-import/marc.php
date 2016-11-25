<?php 
  ;
  set_time_limit(600);
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();

?>
<BR>
                                <table width = "800" align=center border = "0" cellspacing = "0" cellpadding = "0">
                                    <tr>
                                        <td><?php 

if (file_exists("../_output/marc.sql") ) {
  unlink("../_output/marc.sql");
}
//printr($collist);
$addcollist=",".@implode(",",$collist).",";
//echo "[$collist]";
$setbibidcmd=trim($setbibidcmd);


										if ($filex=="")	 {
											include("marc.uploadform.php");
										    if ($handle = opendir('../_input')) { 
											   //echo "Directory handle: $handle\n"; 
											   pagesection(getlang("กรุณาเลือกไฟล์ข้อมูล::l::Please choose file to import"));
											   /* This is the correct way to loop over the directory. */ 
												   $i=1;
											   echo "<TABLE width=700 align=center>
											   <TR class=table_head>
											   	<TD > File name</TD>
											   	<TD width=50> - </TD>
											   </TR>";
											   while (false !== ($file = readdir($handle))) { 
												   if ($file!="." && $file !=".." && $file !="import" && !is_dir("../_input/$file")) {
													   $fsize=filesize("../_input/$file");
												       echo "<tr><TD >&nbsp;&nbsp;&nbsp;$i.  <A HREF='entercomment.php?filex=$file' class=a_btn>$file</A> (" .number_format($fsize/1024). "  KBytes / ".number_format(($fsize/1024)/1024,2)." MB ) </TD><TD ><A HREF=\"marc.php?delll=$file\" onclick=\"return confirm('".getlang("กรุณายืนยัน::l::Deletion confirmation")."');\" ><IMG SRC='../neoimg/Delete.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle>".getlang("ลบ::l::Delete")." </A>"; 

														echo "</TD></tr>\n";

														$i=$i+1;
												   }
											   } 
											   echo "
											   </TABLE>";
											   closedir($handle); 
											   if ($i==1) {
											      echo "- ".getlang("ไม่พบไฟล์ข้อมูลในโฟลเดอร์ _input::l::No file in folder _input")." - ";
											   }
											} 
   
										} else {
												$Stime=time();
												barcodeval_set("lastsetbibidbytag",$setbibidcmd);
											
											//
											$importEDid=marc_importfromfile($filex,"authority");
											//

//start chkdup
?><TABLE width=<?php  echo $_TBWIDTH?> align=center>
<TR>
	<TD><?php 
$chkdup=tmq("select * from importmarc_dupcheck_tmp where trim(tag100)<>'' ");
$chkdupdsped=0;
while ($chkdupr=tmq_fetch_array($chkdup)) {
	if ($chkdupdsped>50) {
		break;
	}
	$chkdupaction=tmq("select * from authoritydb where tag100 like '".addslashes($chkdupr[tag100])."'  ",false);
	if (tmq_num_rows($chkdupaction)!=0) {
		$chkdupdsped++;
		$chkdupaction=tmq_fetch_array($chkdupaction);
		echo "<FONT color=darkred class=smaller><BR>&bull; ".getlang("อาจมีรายการซ้ำ::l::Duplicate record(s)?")." ".getlang("โปรดตรวจสอบกับรายการต่อไปนี้::l::Please check this record(s)").": <A HREF='../library.authority-db/addDBbook.php?IDEDIT=$chkdupaction[ID]' class=smaller target=_blank>".($chkdupaction[tag100])."</A></FONT><BR>";
	}
}
if ($chkdupdsped!=0) {
	echo "<BR><I class=smaller2>".getlang("แสดงผลเฉพาะ 50 รายการแรกที่น่าสงสัยเท่านั้น::l::Display only first 50 suspected records.")."</I>";
}
?></TD>
</TR>
</TABLE><?php 
//end chkdup

												$Etime=time();
												echo "<BR>".getlang("ได้รายการจำนวน ".number_format($IMPORTCOUNT)." รายการ  โดยใช้เวลาดำเนินการ::l::Got ".number_format($IMPORTCOUNT)." records , Excuted in")." " .-($Stime-$Etime). " ".getlang("วินาที::l::seconds")." <BR><BR>";



											   echo(  "<FORM METHOD=POST ACTION=\"marc2.php\">

											    <HR><CENTER> <BR>
												<INPUT TYPE=submit value=\"".getlang("ระบบดำเนินการเรียบร้อย กรุณาคลิกที่นี่เพื่อดำเนินการขั้นต่อไป::l::Operation complete click here to continue")."\" style='background-color: #EDE0E0'></CENTER><HR>");

												echo ("</FORM>");
												if ($droppedgetonly!="") {
													echo "<HR> ".getlang("หมายเหตุ มีฟิลด์ที่ไม่นำเข้า ดังนี้ ::l::Note these fields are skipped from backup").":";
													$droppedgetonly=explode(",",$droppedgetonly);
													$droppedgetonly=array_unique($droppedgetonly);
													$t="";
													foreach ($droppedgetonly as $value) {
														$t=$t. ", $value";
													}
													$t=trim($t,",");
													echo $t;
												}
										}
										?><BR><BR>

										</td>
                                    </tr>
                                </table>
                    </table>
<?php 
	foot();
?>