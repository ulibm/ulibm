<?php 
    ;
include ("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$membertypedb=tmq_dump2("member_type","type","descr");
?>
                                <form name = "form1" action = "DBddal.php" method = "post">
                                    <table width = "<?php 
   echo $_TBWIDTH;
?>" align=center border = "0" cellspacing = "1" cellpadding = "3">
                                        <tr align = "center">
                                            <td colspan = "3">
                                                <font face = "MS Sans Serif" size = "2">
                                                <img src = "../image/search.gif" width = "18" height = "15" hspace = "4">
												<?php  echo getlang("ค้นหาจากชื่อ::l::Search from name"); ?>  <input type = "text" name = "keyword" value = "<?php  echo $keyword;?>"> 
												<?php  echo getlang("ค้นหาจากบาร์โค้ด::l::Search from barcode"); ?>  <input type = "text" name = "keywordbc" value = "<?php  echo $keywordbc;?>"> 
<?php  
form_room("searchtype",$searchtype,"yes");
//form_quickedit("searchtype",$searchtype,"foreign:-localdb-,member_type,type,descr,allowblank")?>
												<input type = "submit" name = "Submit" value = "<?php  echo getlang("ค้นหา::l::Search"); ?>"><BR>
<?php 
   echo "".getlang("เรียงลำดับ::l::Sort")."";
?> 
<select name=optionsort id=optionsort onchange="localoptionsortchage(this);">
<?php
$sortoptions=Array("none","name","namedesc","bc","bcdesc");
@reset($sortoptions);
$sorted=trim($sorted);
$sortdsp=Array();
$sortdsp[none]=getlang("-");
$sortdsp[name]=getlang("ชื่อสมาชิก ก-ฮ::l::Name a-z");
$sortdsp[namedesc]=getlang("ชื่อสมาชิก ฮ-ก::l::Name z-a");
$sortdsp[bc]=getlang("บาร์โค้ด 0-9::l::Barcode 0-9");
$sortdsp[bcdesc]=getlang("บาร์โค้ด 9-0::l::Barcode 9-0");
while (list($k,$v)=each($sortoptions)) {
   $sl="";
   $vdsp=$sortdsp[$v];
   if ($sorted==$v) {
      $sl="selected checked";
   }
   echo "<option value='$v' $sl>$vdsp";
}
?>
</select> 
<script>
function localoptionsortchage(wh) {
   self.location="<?php echo $PHP_SELF;?>?keyword=<?php echo $keyword;?>&keywordbc=<?php echo $keywordbc;?>&searchtype=<?php echo $searchtype;?>&sorted="+wh.options[wh.selectedIndex].value;
}
</script>
 <?php 
if ($keyword != "" || $searchtype != "" || $keywordbc != "" ||$fclimittype!="") {
   echo "<BR><a href='DBddal.php' class=a_btn>".getlang("แสดงทั้งหมด::l::View all")."</a>";
}
?>
 
                                <a href = "addDBddal.php" class=a_btn><?php  echo getlang("เพิ่มสมาชิกห้องสมุด::l::Add new member"); ?></a></font></td>
                                        </tr>
                                        <tr align = "center">
                                            <td colspan = "3">
                                                <div align = "left">

												<?php 
	if (empty($page))
		{
		$page=1;
		}
	// หาจำนวนหน้าทั้งหมด
	t("select","*");
	t("from","member");
	t("where","1");



	$OTHERLIBSITE=library_gotpermission("managemember-otherlib");

if ($OTHERLIBSITE != true) {
	t("where","and libsite","=","$LIBSITE");
}

if ($keyword <> "") {
	t("where","and (");
	t("where","descr","like","%$keyword%");
	t("where","or UserAdminName","like","%$keyword%");
	t("where",")");
}
if ($keywordbc <> "") {
	t("where","and (");
	t("where","UserAdminID","=","$keywordbc");
	t("where",")");
}
if ($searchtype <> "") {
	t("where","and room","=","$searchtype");
}
if ($fclimittype <> "") {
   $fclimittypeuse=$fclimittype;
   if ($fclimittypeuse=="[blank]") {
      $fclimittypeuse="";
   }
	t("where","and type","=","$fclimittypeuse");
}
if ($sorted=="name") {
   t("order","UserAdminName","ASC");
}
if ($sorted=="namedesc") {
   t("order","UserAdminName","DESC");
}
if ($sorted=="bc") {
   t("order","UserAdminID","ASC");
}
if ($sorted=="bcdesc") {
   t("order","UserAdminID","DESC");
}
$sql1=t("g");
	$sql2="$sql1";
	//echo $sql1;
	$result=tmqp($sql2,"DBddal.php?searchtype=$searchtype&keyword=$keyword&keywordbc=$keywordbc&fclimittype=$fclimittype&sorted=$sorted");
	?>
                                                </div>


<!--  table for faucets-->
<table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" 
cellpadding="0" bgcolor=#ffffff> 
<tr valign=top>
<?php 
if (strtolower(getval("config","hidesystemmemfaucet"))!="yes") {
?>
<td width=180 style="background: #666666; padding: 4px 4px 4px 4px ;"><?php
$rsdb=tmq_dump2("member_type","type","descr");
//$rsdbcc=tmq_dump2("media_type","code","cachelibfaucet");
if ($recalfaucet=="yes") { // recal only at first page
   $fcsql="select distinct type as ss, count(id) as cc from member ";
   $fcsql.=" group by type order by cc desc";
   $fc=tmq($fcsql);
} else {
   $fcsql="select type as ss, cachelibfaucet as cc from member_type order by cachelibfaucet desc ";
   $fc=tmq($fcsql);

}
echo "<div style=\" display:inline-block; font-size: 15px; width: 100%; color: white; font-weight: bold;\">MEMBER TYPE</div>";
   if ($recalfaucet=="yes") { 
      tmq("update member_type set cachelibfaucet='0' ;");
   }
      if (tnr($fc)==0) {
      echo "<div style=\" display:inline-block; font-size: 12px; width: 100%;";
      echo "background-color: #ffffff; color: darkgray; border-radius: 4px; 
-moz-border-radius: 4px; 
-webkit-border-radius: 4px; ";
      echo "\">";
      echo " - " .getlang("ไม่มีข้อมูล::l::No data")." - ";
      echo "</div>";
   }
while ($fcr=tfa($fc)) {
   if ($recalfaucet=="yes") { 
      tmq("update member_type set cachelibfaucet='$fcr[cc]' where type='$fcr[ss]' ;");
   }
   if (floor($fcr[cc])==0) continue;
   $tmprsname= getlang($rsdb[$fcr[ss]]);
   if (trim($tmprsname)=="") {
      $tmprsname="$fcr[ss]";
   }
   echo "<div style=\" display:inline-block; font-size: 12px; width: 100%;";
   echo "background-color: #ffffff; color: darkgray; border-radius: 4px; 
-moz-border-radius: 4px; 
-webkit-border-radius: 4px; ";
   if ($fclimittype==$fcr[ss]) {
      echo "background-color: #FFEFE8; color: black;";
   } else {
      echo "background-color: #ffffff; color: black;";
   }
   if ($tmprsname=="") {
      $tmprsname="[blank]";
   }
   if ($fcr[ss]=="") {
      $fcr[ss]="[blank]";
   }
   echo "\" >&nbsp;<a href=\"$PHP_SELF?searchtype=$searchtype&keyword=$keyword&keywordbc=$keywordbc&fclimittype=$fcr[ss]\" target=_top 
   style='text-decoration: none; color: inherit;'>";
   echo $tmprsname;
   echo "</a> (";
   echo number_format($fcr[cc]);
   echo ")</div><BR>";
}
?></td>
<?php  } //is show faucets?>
<td>
                                                
<table width = "<?php 
if (strtolower(getval("config","hidesystemmemfaucet"))!="yes") { 
   echo $_TBWIDTH-180;
} else {
   echo $_TBWIDTH;
}
?>" align=center border = "0" cellspacing = "1" cellpadding = "3">
<tr bgcolor = "#006699">
    <td width = "2%">
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>
    <td width = 20%>
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("บาร์โค้ดสมาชิก::l::Barcode ID"); ?></font></b></font></td>
    <!-- <td width = 20%>
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("รหัสผ่าน::l::Password"); ?></td> -->
    <td width = 30%>
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" width = 20% size = "2"><?php  echo getlang("ชื่อ-สกุล::l::Name"); ?></td>
    <td width = 20%>
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif"  size = "2"><?php  echo getlang("รายละเอียด::l::Information"); ?></td>
    <td width = "13%">
        <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></font></b></font></td>
</tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $ID = $row[UserAdminID];
                                        $Password=$row[Password];
                                        $UserAdminName=$row[UserAdminName];
                                        $descr=$row[descr];
                                        $email=$row[email];
                                        $type=$row[type];
                                        $statusactive=$row[statusactive];
                                        $ittt=($startrow) + $i;
                                        if ($i % 2 == 0)
                                            {
                                            echo "<tr valign=top bgcolor=#ffffff height=2>";
                                            }
                                        else
                                            {
                                            echo "<tr bgcolor=#F2F2F2 height=2 valign=top>";
                                            }
                                        echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                                        echo "<td><font face='MS Sans Serif' size=2 color=#003366>
$ID ";
?>
<div id="pwdbtnfor<?php  echo $i;?>" class=""><a href="javascript:void(null);" class=smaller2 style="color: #9aa3ab"
onclick="tmp=getobj('pwdfor<?php  echo $i;?>');tmp.style.display='block';tmp=getobj('pwdbtnfor<?php  echo $i;?>');tmp.style.display='none';"><?php  echo getlang("รหัสผ่าน::l::Password");?></a></div>

<div id="pwdfor<?php  echo $i;?>" style="display:none">
	&nbsp;&nbsp;<?php  echo getlang("รหัสผ่าน::l::Password");?>: <font color="#4b3232"><?php  echo $Password;?></font>
</div><?php 
echo "</font></a></td>";
                                        //echo "<td><font face='MS Sans Serif' size=2 color=#003366>$Password  </font></a></td>";
                                        echo "<td><font face='MS Sans Serif' size=2 color=#003366>
$UserAdminName   </font></td>";
                                        echo "<td><font class=smaller>
" . getlang($membertypedb[$type]);
if (trim($membertypedb[$type])=="") {
   echo "[$type]";
}
echo " <FONT style='color:555555;' class=smaller>($statusactive) </FONT>";
echo "
$descr    </font></a></td>";

                                        $i2=$i2 + 1;
                                        //การดูสื่อประกอล
                                        echo "</td>";
                                        ////ดูว่ามีห้องสมุดอื่นหรือไม่
                                        echo "<td><nobr  class=smaller>
<a href='delMedia.php?ID=$ID&searchtype=$searchtype&keyword=$keyword&keywordbc=$keywordbc'
 onclick=\"return confirm('ต้องการจะลบรายการ $ID แน่หรือ');\" class=smaller>".getlang("ลบ::l::Delete")."</a> :
 <a href='editMedia.php?ID=$ID&TYPE=$mType'  class=smaller>".getlang("แก้::l::Edit")."</a> : 
 <a href='detail.php?sid=$sid&id=$ID'  class=smaller  target=_blank>".getlang("ดูรายละเอียด::l::View")."</a></nobr><BR>";
echo "<a href='chbarcode.php?ID=$ID'  class=smaller>".getlang("เปลี่ยนบาร์โค้ด::l::Change Barcode")."</a>";
echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                        $s=$i - 1;
                                        }

										echo $_pagesplit_btn_var;

                                ?>
                                                </table>
                                                <?php 
                                                    ?>
                                            </td>
                                        </tr>
                                
                                    </table></form>
                                    
                                    

</td></tr></table> <!-- end table for faucets-->    

                                
									<TABLE width=<?php  echo $_TBWIDTH;?> align=center>
									<TR>
										<TD><B><?php  echo getlang("สมาชิกล่าสุด:::l::Recently added member:");?></B> <?php 

t("select","*");
t("from","member");
t("where","1");
if ($OTHERLIBSITE != true) {
	t("where","and libsite","=","$LIBSITE");
}
t("limit","10");
t("order","dtadd");

$s=t(false);

while ($r=tmq_fetch_array($s)){
	echo " <A HREF='detail.php?id=$r[UserAdminID]' target=_blank class=smaller>";
	echo stripslashes($r[UserAdminName])."</A> <A HREF='editMedia.php?ID=$r[UserAdminID]' class=smaller2 style='color: #005555; text-decoration:underline;'>".getlang("แก้ไข::l::Edit")."</A> ";
	echo "<FONT style='font-size:13'>(".stripslashes($r[UserAdminID]) .")</FONT>";
	echo ", &nbsp;";
}
										?></TD>
									</TR>
									</TABLE>
<?php 
foot();?>