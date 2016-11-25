<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="createlist";
	mn_lib();
		// หาจำนวนหน้าทั้งหมด
?><BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_td><B><?php  echo getlang("กฏของการ Createlist:::l::Rule for:");
	$s=tmq("select * from createlist_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> <?php 
	echo $s[name];
	?></TD>
</TR>
</TABLE><BR>
<?php /*
if ($clearitemrule=="yes") {
		tmq("delete from createlist_itemrule where pid='$main'");
}*/
if ($issave!="yes") {
	$data=tmq("select * from createlist_itemrule where id='$ruleid' ");
	if (tnr($data)>0 && floor($ruleid)!=0) {
		$dataa=tfa($data);
		$dataa=unserialize($dataa[val]);
		//printr($dataa);
		extract($dataa,EXTR_OVERWRITE);
		if (floor($limitdate_yea)>0) {
   		 $limitdate=ymd_mkdt($limitdate_dat,$limitdate_mon,$limitdate_yea);
		}
		if (floor($limitdatelastxday_yea)>0) {
   		$limitdatelastxday=ymd_mkdt($limitdatelastxday_dat,$limitdatelastxday_mon,$limitdatelastxday_yea);
		}
		if (floor($limitdatelastxdayend_yea)>0) {
			$limitdatelastxdayend=ymd_mkdt($limitdatelastxdayend_dat,$limitdatelastxdayend_mon,$limitdatelastxdayend_yea);
		}
		if (floor($limitdatestatuschanges_yea)>0) {
		 $limitdatestatuschanges=ymd_mkdt($limitdatestatuschanges_dat,$limitdatestatuschanges_mon,$limitdatestatuschanges_yea);
		}
		if (floor($limitdatestatuschangee_yea)>0) {
		 $limitdatestatuschangee=ymd_mkdt($limitdatestatuschangee_dat,$limitdatestatuschangee_mon,$limitdatestatuschangee_yea);
		}
	} 
} else {
		$dataa=serialize($_POST);
		//tmq("delete from createlist_itemrule where pid='$main'");
		if (floor($ruleid)==0) {
   		tmq("insert into createlist_itemrule set val='$dataa' , pid='$main' ,decis='$decis',ordr='$ordr' ",false);
		} else {
   		tmq("update createlist_itemrule set val='$dataa' , pid='$main' ,decis='$decis',ordr='$ordr' where id='$ruleid' ",false);
		}

  $sql1 ="SELECT *  FROM media_mid where 1"; 
  $sqllimit="";
	if ($status!="") {
		$sqllimit=" and status='$status' ";
	}
	$limitdate=floor(form_pickdt_get("limitdate"));
	if ($limitdate>20) {
	$sqllimit="$sqllimit and dt_str='$limitdate_dat-$limitdate_mon-$limitdate_yea' ";
	}
	$limitdatelastxday=floor(form_pickdt_get("limitdatelastxday"));
	$limitdatelastxdayend=floor(form_pickdt_get("limitdatelastxdayend"));
	$limitdatestatuschanges=floor(form_pickdt_get("limitdatestatuschanges"));
	$limitdatestatuschangee=floor(form_pickdt_get("limitdatestatuschangee"));
	if ($limitdatelastxday>20) {
		$sqllimit="$sqllimit and dt>='$limitdatelastxday' ";
	}
	if ($limitdatelastxdayend>20) {
		$sqllimit="$sqllimit and dt<='$limitdatelastxdayend' ";
	}
	if ($limitdatestatuschanges>20) {
		$sqllimit="$sqllimit and status_lastupdate>='$limitdatestatuschanges' ";
	}
	if ($limitdatestatuschangee>20) {
		$sqllimit="$sqllimit and status_lastupdate<='$limitdatestatuschangee' ";
	}

	if ($note!="") { $note=addslashes($note);
	$sqllimit="$sqllimit and note like '%$note%' ";
	}
	if ($adminnote!="") { $adminnote=addslashes($adminnote);
	$sqllimit="$sqllimit and adminnote like '%$adminnote%' ";
	}
	if ($siteoflib!="") {
	$sqllimit="$sqllimit and libsite='$siteoflib' ";
	}
	if ($mdtype!="") {
	$sqllimit="$sqllimit and RESOURCE_TYPE='$mdtype' ";
	}
	if ($itemplace!="" && $itemplace!="null") {
	$sqllimit="$sqllimit and place='$itemplace' ";
	}
	$sql2 = "$sql1 $sqllimit order by bcode ";
	//echo $sql2;

  if (trim($sqllimit)!="") {
	$sqllimit="select distinct pid from media_mid where 1 $sqllimit";
	$s=tmq("$sqllimit",false);
	$idlist="";
	$i=0;
	while ($r=tfa($s)) {
		$idlist.=",".$r[pid];
		$i++;
	}
	$idlist=trim($idlist,",");
	tmq("update createlist_itemrule set idlist='$idlist' where pid='$main' ");
	html_dialog("","Bib : $i");
  } else {
	tmq("update createlist_itemrule set idlist='' where pid='$main' ");
	html_dialog("","ไม่กำหนดเงื่อนไข");
  }
  
		
		redir("sub_itemrulemain.php?main=$main",1);
		die;
		$data=tmq("select * from createlist_itemrule where pid='$main' ");
		$dataa=tfa($data);
		$dataa=unserialize($dataa[val]);
		//printr($dataa);
		extract($dataa,EXTR_OVERWRITE);
	}

?>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>">
<center><?php  echo getlang("ลำดับ::l::order");
form_quickedit("ordr",$ordr,"number");
?><?php  echo getlang("เงื่อนไข::l::Boolean");
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
		<a href="sub_itemrulemain.php?main=<?php  echo $main?>" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></a>
			</TD>
		  </TR>

          </table>
 <input type="hidden" name="main" value="<?php  echo $main?>">
 <input type="hidden" name="ruleid" value="<?php  echo $_GET[ruleid]?>">
 <input type="hidden" name="issave" value="yes">
        </form>
  <?php 
  
  foot(); 
  die;
  
  
  
  
  
  
  
  
  
  
  
  
  
//  echo $sqllimit;
  if (trim($sqllimit)!="") {
	$sqllimit="select distinct pid from media_mid where 1 $sqllimit";
	$s=tmq("$sqllimit",false);
	$idlist="";
	$i=0;
	while ($r=tfa($s)) {
		$idlist.=",".$r[pid];
		$i++;
	}
	$idlist=trim($idlist,",");
	tmq("update createlist_itemrule set idlist='$idlist' where pid='$main' ");
	html_dialog("","Bib : $i");
  } else {
	tmq("update createlist_itemrule set idlist='' where pid='$main' ");
	html_dialog("","ไม่กำหนดเงื่อนไข");
  }
		foot();   
	   ?>