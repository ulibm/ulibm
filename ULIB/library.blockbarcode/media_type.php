<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
		// หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT *  FROM media_mid where 1"; 
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

	if ($siteoflib!="") {
	$sqllimit="$sqllimit and libsite='$siteoflib' ";
	}
	if ($bcode!="") {
	$sqllimit="$sqllimit and bcode='$bcode' ";
	}
	if ($tabean!="") {
	$sqllimit="$sqllimit and tabean='$tabean' ";
	}
	if ($itemplace!="" && $itemplace!="null") {
	$sqllimit="$sqllimit and place='$itemplace' ";
	}
	$sql2 = "$sql1 $sqllimit order by bcode ";
	//echo $sql2;
	if ($markshown=="yes") {
		//$sql="update media_mid  set ismarked='NO'  ";
		//tmq($sql);
		$sql="update media_mid  set ismarked='YES' where 1 $sqllimit ";
		tmq($sql);
	}
	if ($isclearall=="yes") {
		$sql="update media_mid  set ismarked='NO'  ";
		tmq($sql);
	}
?>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
<FORM METHOD=POST ACTION="media_type.php">
       		  <TR>
		  	<TD align=center>
			<?php  echo getlang("บาร์โค้ด::l::Barcode"); ?> <INPUT TYPE="text" NAME="bcode" value="<?php  //echo $bcode; ?>"> <?php  echo getlang("เลขทะเบียน::l::Code"); ?>  <INPUT TYPE="text" NAME="tabean"value="<?php  //echo $tabean; ?>"><BR>
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
?><BR>
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
</TABLE><BR>			
			&nbsp;<INPUT TYPE="submit" value="<?php  echo getlang("ค้นหา::l::Search"); ?>">
			<BR><BR>
			<INPUT TYPE="reset" value=" <?php  echo getlang("Mark ทุกรายการที่แสดงอยู่::l::Mark all displaying records"); ?> " onclick="self.location='media_type.php?<?php 
			$addQUERY="status=$status&siteoflib=$siteoflib&bcode=$bcoded&tabean=$tabean&itemplace=$itemplace&markshown=yes&limitdate_dat=$limitdate_dat&limitdate_mon=$limitdate_mon&limitdate_yea=$limitdate_yea&limitdatelastxday_dat=$limitdatelastxday_dat&limitdatelastxday_mon=$limitdatelastxday_mon&limitdatelastxday_yea=$limitdatelastxday_yea&limitdatelastxdayend_dat=$limitdatelastxdayend_dat&limitdatelastxdayend_mon=$limitdatelastxdayend_mon&limitdatelastxdayend_yea=$limitdatelastxdayend_yea&limitdatestatuschanges_dat=$limitdatestatuschanges_dat&limitdatestatuschanges_mon=$limitdatestatuschanges_mon&limitdatestatuschanges_yea=$limitdatestatuschanges_yea&limitdatestatuschangee_dat=$limitdatestatuschangee_dat&limitdatestatuschangee_mon=$limitdatestatuschangee_mon&limitdatestatuschangee_yea=$limitdatestatuschangee_yea";
			echo $addQUERY;
			?>' " style="background-color: #FFE8E9">
			<?php 
				$result = tmqp($sql2,"media_type.php?$addQUERY");
	$s=tmq("select count(id) as cc from media_mid where ismarked='YES' ");
	$s=tmq_fetch_array($s);
	if ($s[cc]!=0) {
		?><INPUT TYPE="reset" value=" <?php  echo getlang("จัดการรายการที่ Mark ไว้แล้ว::l::Manage Marked records"); ?> (<?php  echo number_format($s[cc]);?>) " onclick="self.location='managemarkd.php' ">
		<INPUT TYPE="reset" value=" <?php  echo getlang("ล้างรายการที่ Mark ไว้::l::Clear all Marked"); ?> " onclick="self.location='media_type.php?isclearall=yes' "><?php 
	}
	
			?>
			</TD>
		  </TR>
       </FORM>       <tr align="center">
              <td colspan="3"> 
                <div align="left"><font size="2" face="MS Sans Serif, Microsoft Sans 
Serif">
<?php 
?> </div>
                <table width="<?php  echo $_TBWIDTH?>" border="0" cellspacing="1" cellpadding="3" class=table_border>
                  <tr bgcolor="#006699"> 
                    <td width="2%" class=table_head><b>
<nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></b></td>
                    <td width=30% class=table_head><b><?php  echo getlang("ชื่อวัสดุฯ::l::Information"); ?> </b></td>
                    <td width=30% class=table_head><b><?php  echo getlang("บาร์โค้ด::l::Barcode"); ?> </b></td>
                    <td width=30% class=table_head><b><?php  echo getlang("สาขาห้องสมุด/สถานะ::l::Library campus/status"); ?> </b></td>
                    <td width="5%" class=table_head><nobr>
<b><?php  echo getlang("แก้ไข::l::Edit"); ?></b></td>
                  </tr>
                  <?php 
         $i=1; 
         while($row = tmq_fetch_array($result)){
	  $ID = $row[id];
               $name=$row[name];
$ittt = (($startrow))+$i;
      if ($i % 2 ==0) {
          echo"<tr valign=top bgcolor=#ffffff height=2>";
      } else {
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
      }             
            echo"<td class=table_td><nobr>$ittt </td>";
            echo"<td class=table_td>
<A HREF='../dublin.php?ID=$row[pid]' target=_blank>".marc_gettitle($row[pid])."&nbsp;</A>
</B> </a></td>";
echo"<td class=table_td>
<B>$row[bcode]</B><BR>".marc_getmidcalln($row[bcode])."</td>";
            echo"<td class=table_td>
".get_libsite_name($row[libsite])."<BR>
<B>";
if ($row[status]!="") {
	echo "<small>&nbsp;&nbsp;&nbsp;<IMG SRC='../neoimg/Warning.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".get_mid_status($row[status])."($row[status])</small>";
}
echo "</B> </a></td>";
            $i2 = $i2 +1;  
//การดูสื่อประกอล
//echo "</td>";
 echo"<td class=table_td align=center>";
 echo"<!-- 
<a href='delMedia_type.php?ID=$ID' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>/ --><font face='MS Sans Serif' 
size=2>";
echo "<a href='editMedia_type.php?ID=$ID&TYPE=$mType'>".getlang("แก้::l::Edit")."</a></td>";
           echo"</tr>";
    $i++;
		$s = $i-1;	
       } 
echo $_pagesplit_btn_var;
?>
                </table>
<?php  
    
?>
              </td>
            </tr>
          </table>
 
        </form>
		<TABLE cellpadding=0 cellspacing=0 border=0 width=100%>
<FORM METHOD=POST ACTION="scanbc.php">
					<TR>
			<TD align=right><A HREF="../library.barcode/bc.php" class="a_btn smaller"><?php  echo getlang("ไปยังระบบบาร์โค้ด::l::Go to barcode system");?> </A>  
			<A HREF="../library.blockbarcode/" class="a_btn smaller"><?php  echo getlang("ไปยังการพิมพ์บาร์โค้ดแบบตรงบล็อค::l::Go to block-barcode");?> </A>  
			<INPUT TYPE="submit" value="<?php  echo getlang("เลือกรายการด้วยการสแกนบาร์โค้ด::l::Add by scanning barcode.");?>"></TD>
		</TR>
		</FORM>
		</TABLE>
      </td>
    </tr>
  </table>
  <?php 
		foot();   
	   ?>