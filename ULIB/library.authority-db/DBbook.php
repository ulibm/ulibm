<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
$libsitedb=tmq_dump2("library_site","code","name");
?>


          <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" cellpadding="3">
  <form name="form1" action="DBbook.php" method="post" >            <tr align="center">
              <td colspan="3">
			  
			  <TABLE cellspacing=0 cellpadding=2 width=780>
			  <TR>
			  	<TD colspan=9 bgcolor=e9e9e9><img 
src="../image/search.gif" width="18" height="15" hspace="4"><?php  echo getlang("ค้นหา::l::Search"); ?></TD>
</TR>
			  <TR>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>

			  	<TD><?php  echo getlang("ข้อความ::l::Text"); ?></TD>
				<TD>
				<input type="text" name="keyword" value="<?php  echo $keyword;?>" size=15  style="border-color:darkred;border-left-width:3">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>

<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD><input type="submit" name="Submit" value="<?php  echo getlang("ตกลง::l::Submit"); ?>">
</TD>
<TD width=5 bgcolor=e9e9e9>&nbsp;</TD>
<TD>
<a href="addDBbook.php?typeid=<?php  echo $typeid; ?>&faculty=<?php  echo $faculty; 
?>" class=a_btn><?php  echo getlang("เพิ่มรายการใหม่::l::Key new record"); ?></a><BR>

<A HREF="parsemarc.php" class=a_btn><?php  echo getlang("วาง MARC::l::Parse MARC");?></A>
</TD>			  </TR>
			  </TABLE>
</td>
            </tr>
            <tr align="center">
              <td colspan="3"><?php 

    // หาจำนวนหน้าทั้งหมด
  $sql1 ="SELECT * FROM authoritydb where 1 ";

  if ($keyword <> "") {
		$sql1= "$sql1  and (tag100 like '%$keyword%' or
		tag110 like '%$keyword%' or
		tag111 like '%$keyword%' or
		tag130 like '%$keyword%' or
		tag148 like '%$keyword%' or
		tag150 like '%$keyword%' or
		tag151 like '%$keyword%' or
		tag155 like '%$keyword%' or
		tag180 like '%$keyword%' or
		tag181 like '%$keyword%' or
		tag182 like '%$keyword%' or
		tag185 like '%$keyword%'
		) ";
  }

	$sql1="$sql1 order by id desc";
//echo $sql1;

	///$result=my sql_unbuffered_query($sql1);
    $result = tmqp($sql1,"DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&authorname=$authorname",$addstr);
	//echo $sql1;
         
?> </div> 
                <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="1" 
cellpadding="3" bgcolor=#F9EA9F> 
                  <tr bgcolor="#A27100"> 
                    <td width="9%"><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("ลำดับที่::l::No."); ?></font></b></font></td> 
         <td><font color="#FFFFFF"><b><font face="MS Sans Serif" size="2"><?php  echo getlang("รายการหัวเรื่อง::l::Subject"); ?></font></b></font><font color="#FFFFFF"><b><font 
face="MS Sans Serif" size="2"></font></b></font></td>
                    <td width="10%"><font color="#FFFFFF"><b><font 
face="MS Sans Serif" size="2"><?php  echo getlang("::l::"); ?><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit"); ?></font></b></font></td> 
                  </tr> 
                  <?php  
       	/* */
		$i=1;  
$tagnamedb=tmq_dump("bkedit_authority","fid","name");
 while($row = tmq_fetch_array($result)){ 

	$mID = $row[ID]; 
	//printr($row);



	$ittt = ($startrow)+$i; 
	if ($linkfrom==$mID)  {
			  echo "<tr bgcolor=#BFFFE6> "; 
	} else {
		if ($i%2==0) {
			  echo "<tr bgcolor=#FFF1BB> "; 
		} else {
			  echo " <tr bgcolor=#FFFFFF> "; 
		}	
	}
$strtype= $row3[show];  
// echo "$strtype ";  
echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>"; 

echo "<td><font face='MS Sans Serif' size=2 color=#003366>";

$tmp=explode(',',"tag100,tag110,tag111,tag130,tag148,tag150,tag151,tag155,tag180,tag181,tag182,tag185");
while (list($k,$v)=each($tmp)) {
	if ($row[$v]!="") {
		echo "<FONT class=smaller>".$tagnamedb[$v].":</FONT><BR>".substr($row[$v],2,strlen($row[$v]))."";
	}
}



echo "</font>"; 

echo "<BR><FONT class=smaller2 COLOR=666666>tag999:".dspmarc($row[tag999])."</FONT>";

   echo "</td>"; 
 echo"<td align=center><font class=smaller2>";
	echo "<a onclick=\"return confirm('".getlang("คุณต้องการที่จะลบรายการนี้ใช่หรือไม่::l::Do you really want to delete this?")."'); \"
	href='delBook.php?ID=$mID&RESOURCE_TYPE=$mRTYPE&FORMAT=$mFORMAT&LANGUAGE=$mLang&typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword'>".getlang("ลบ::l::Delete")."</a>/";

 echo "<a 
href='addDBbook.php?IDEDIT=$mID&RESOURCE_TYPE=$mRTYPE&FORMAT=$mFORMAT&LANGUAGE=$mLang&typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword' >".getlang("แก้::l::Edit")."</a>";

 ?></font></td> <?php 
           echo "</tr>"; 
		$i++; 
        $s = $i-1; 
}
	
echo $_pagesplit_btn_var;
?>
<script language="javascript"> 
function resizeIframe2(id) { 
	try { 
		frame = document.getElementById(id); 
		frame.scrolling = "no"; 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight + 2; 
		 if (tmpfrheight>1600) {
			 tmpfrheight=1600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<?php 
 //if (tmq_num_rows($result)==0 && getval("_SETTING","connecttoulibuc")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3)) {
 if ( getval("_SETTING","displayyazatbookman")=="yes" && (strlen($keyword)>3 || strlen($isbn)>3 || strlen($authorname)>3)) {
				?>
				
<tr  style="background-color: white;"><td colspan=3 align=center style="background-color: white;"><iframe width=98% height=160 ID="yazdisplayIFRAME" frameborder=no scrolling=AUTO noonload="resizeIframe2('yazdisplayIFRAME');" src="./quickyaz.php?<?php  echo "keyword=".
	urlencode($keyword)."&isn=".urlencode($isbn)."&authorname=".urlencode($authorname);
?>"
style="border: solid 2 #FF8000; border-left-width: 12px;"
></iframe>
</td></tr>
<?php 	
		}

		
 ?> 
                </table> 
<?php 

        // table แสดงเลขหน้า 
?>       </td> 
            </tr> 
         </form>          </table> 
      </td> 
    </tr> 
  </table> 
  <?php if (floor($startrow)==0) {?>
  <TABLE width=<?php  echo $_TBWIDTH?> align=center>
  <TR>
	<TD><B><?php  echo getlang("5 รายการล่าสุด::l::5 latest bib.");?></B><BR>
	<?php 
		$s=tmq("select * from authoritydb order by ID desc limit 5");
		while ($r=tmq_fetch_array($s)) {
$tmp=explode(',',"tag100,tag110,tag111,tag130,tag148,tag150,tag151,tag155,tag180,tag181,tag182,tag185");
while (list($k,$v)=each($tmp)) {
	if ($r[$v]!="") {
		echo "<FONT class=smaller2>".$tagnamedb[$v].":<BR>".substr($r[$v],2,strlen($r[$v]))."</FONT>";
	}
}
			echo "<FONT class=smaller2 COLOR=666666>tag999:".dspmarc($r[tag999])."</FONT>  <A HREF='addDBbook.php?IDEDIT=$r[ID]' class=smaller2>".getlang("แก้ไข::l::Edit")."</A><BR>";
		}
	?></TD>
  </TR>
  </TABLE>
  <?php 
  }
  foot();
  ?>