<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="marcdspmod";
	mn_lib();
		// หาจำนวนหน้าทั้งหมด
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("กฏของการ marcdspmod:::l::Rule for:");
	$s=tmq("select * from marcdspmod_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> <?php 
	echo $s[name];
	?></TD>
</TR>
</TABLE><BR>
<?php 
if ($clearitemrule=="yes") {
		tmq("delete from marcdspmod_itemrule where pid='$main'");
}
if ($issave!="yes") {
	$data=tmq("select * from marcdspmod_itemrule where pid='$main' ");
	if (tnr($data)>0) {
		$dataa=tfa($data);
		$dataa=unserialize($dataa[val]);
		//printr($dataa);
		extract($dataa,EXTR_OVERWRITE);
	} 
} else {
		$dataa=serialize($_POST);
		tmq("delete from marcdspmod_itemrule where pid='$main'");
		tmq("insert into marcdspmod_itemrule set val='$dataa' , pid='$main' ,decis='$decis' ",false);
		$data=tmq("select * from marcdspmod_itemrule where pid='$main' ");
		$dataa=tfa($data);
		$dataa=unserialize($dataa[val]);
		//printr($dataa);
		extract($dataa,EXTR_OVERWRITE);
}

  $sql1 ="SELECT *  FROM media_mid where 1"; 
	include("sub_itemrule.inc.sqllimit.php");
	$sql2 = "$sql1 $sqllimit order by bcode ";
	//echo $sql2;

?>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>">
<center><?php  echo getlang("เงื่อนไข::l::Boolean");
form_quickedit("decis",$decis,"list:AND,OR,NOT");
?></center><br>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td align=center>
			<?php  echo getlang("สถานะ::l::Status"); ?>
			<?php 
			frm_genlist("status","select * from media_mid_status order by name","code","name","-localdb-","yes",$status);
			?>
	
			
			<?php  echo getlang("สาขาห้องสมุด::l::Library campus"); ?> 
			<?php 
			frm_genlist("siteoflib","select * from library_site order by name","code","name","-localdb-","yes",$siteoflib,"code",$LIBSITE);
			?><BR>
			<?php  echo getlang("สถานที่จัดเก็บ::l::Shelf"); ?> 
<?php 
//print_r($editing);
if ($itemplace=="") {
	$itemplace="null";
}
frm_itemplace("itemplace",$itemplace,"yes");
$itemstatus=tmq_dump('media_mid_status','code','name');
?><br>
<?php  echo getlang("ประเภททรัพยากร::l::Resource Type"); ?>
			<?php 
			frm_restype("mdtype",$mdtype);
			?>
			<BR>
<?php 
echo getlang("วันที่เพิ่มไอเทม::l::Date add");
echo " ";
if (floor($limitdate)<20 ) {
	$limitdate=1;
}
form_pickdate("limitdate",$limitdate,"yes");
?>
<BR>
<?php 
if (floor($limitdatelastxday)<20 ) {
	$limitdatelastxday=1;
}
if (floor($limitdatelastxdayend)<20 ) {
	$limitdatelastxdayend=1;
}
if (floor($limitdatestatuschanges)<20 ) {
	$limitdatestatuschanges=1;
}
if (floor($limitdatestatuschangee)<20 ) {
	$limitdatestatuschangee=1;
}
?><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td align=center><?php 
	echo getlang("ไอเทมที่เพิ่มหลังจากวันที่::l::Item added since");
echo " ";

form_pickdate("limitdatelastxday",$limitdatelastxday,"yes");
echo "<BR>";
echo getlang("จนถึง ::l::Until ");
echo " ";
form_pickdate("limitdatelastxdayend",$limitdatelastxdayend,"yes");
?></TD>
</TR>
</TABLE>
<TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td align=center><?php 
	echo getlang("วันที่เปลี่ยนสถานะล่าสุด::l::Last Status Chage");
echo " ";

form_pickdate("limitdatestatuschanges",$limitdatestatuschanges,"yes");
echo "<BR>";
echo getlang("จนถึง ::l::Until ");
echo " ";
form_pickdate("limitdatestatuschangee",$limitdatestatuschangee,"yes");
?></TD>
</TR>
</TABLE>
Note: <input type="text" name="note" value="<?php  echo $note?>" size=20>  Admin Note <input type="text" name="adminnote" value="<?php  echo $adminnote?>" size=20>
<BR>
			&nbsp;<INPUT TYPE="submit" value="<?php  echo getlang("บันทึก::l::Save"); ?>">
	<a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a>
		<a href="sub_rule.php?main=<?php  echo $main?>" class=a_btn><?php  echo getlang("จัดการกฏ::l::Rules"); ?></a>
		<a href="sub_itemrule.php?clearitemrule=yes&main=<?php  echo $main?>" class="a_btn smaller"><?php  echo getlang("ล้างกฏ::l::clear item rules"); ?></a>
			</TD>
		  </TR>

          </table>
 <input type="hidden" name="main" value="<?php  echo $main?>">
 <input type="hidden" name="issave" value="yes">
        </form>
  <?php 

//  echo $sqllimit;
  if (trim($sqllimit)!="") {
  	include("sub_itemrule.inc.sqllimit_save.php");
	
	html_dialog("","Bib : $i");
  } else {
	tmq("update marcdspmod_itemrule set idlist='' where pid='$main' ");
	html_dialog("","ไม่กำหนดเงื่อนไข");
  }
		foot();   
	   ?>