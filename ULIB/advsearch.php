<?php  include("searchformcss.php");?>
<TABLE width=750 align=center border=0><FORM METHOD=GET ACTION="advsearching.php" target=_top>

<TR>
	<TD align=center><B><?php  echo getlang("ใส่คำค้น::l::Search"); ?>:</B> <INPUT TYPE="hidden" name='bool[]' value='[[AND]]'>
	<INPUT TYPE="text" NAME="kw[]" <?php 
	if ($prevsearch=="yes") {
		echo " value=\"".trim(sessionval_get("searchstr2usis"))."\"";
	}
	?>> <SELECT NAME="searchopt[]">
	<?php 
	$s=tmq("select * from index_ctrl where searchable='yes' order by ordr");
	while ($r=tmq_fetch_array($s)) {
		echo "<option value='$r[code]'>".getlang($r[name])."</option>";
	}
	?>
	</SELECT> 
	<?php 
	if ($noaddoptionbtn!="yes") {
	?>
	<A HREF="#" onclick="addopt(); return false;"><IMG SRC="neoimg/AddGray.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="<?php  echo getlang("เพิ่มตัวเลือก::l::More options"); ?>"></A>
	<?php 
	}	
	?><INPUT TYPE="image" SRC="./neoimg/ulibsearch.png" align=absmiddle style="border-width: 0px; width: 32; height: 32;">
	</TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
alladvsearchopt=1;
function addopt() {
	if(alladvsearchopt>=4) {
		return;
	}
	alladvsearchopt=alladvsearchopt+1;
	str=new String("<span id='replaceme'><SELECT NAME='bool[]' ><OPTION SELECTED value='[[AND]]''>AND<OPTION value='[[OR]]'>OR<OPTION value='[[NOT]]'>NOT</SELECT> <INPUT TYPE=text NAME=\"kw[]\"> <SELECT NAME=\"searchopt[]\"><?php 
	$s=tmq("select * from index_ctrl where searchable='yes' order by ordr");
	while ($r=tmq_fetch_array($s)) {
		echo "<option value='$r[code]'>".getlang($r[name])."</option>";
	}
	?></SELECT><!--  :: <A HREF=# onclick=\"remove('replaceme'); return false\">ลบ</A> --><BR></span>");
	tmp=Math.random()*1000000;
	tmp="i"+Math.ceil(tmp)
	str=str.replace("replaceme",tmp);
	str=str.replace("replaceme",tmp);
	str=str.replace("replaceme",tmp);
	//getobj('addopt').insertAdjacentHTML("beforeEnd", str);
	getobj('addopt').innerHTML=getobj('addopt').innerHTML+str
}

function remove(wh) {
	//alert(wh)
	getobj(wh).innerHTML="";
	getobj(wh).outerHTML="";
}
//-->
</SCRIPT>
<TR>
	<TD align=center><span id="addopt"></span></TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
//addopt()
//addopt()
//-->
</SCRIPT>
<?php 
	if ($_advsearch_includemode!="yes") {
?>								
<TR>
	<TD><BR>&nbsp;</TD>
</TR>
                    <tr align=center>
                        <td bgcolor = "" width = "77%" bgcolor = "#FFFFFF" valign = bottom colspan = 1>
                            <nobr><!-- <input type = "submit" name = "Submit" value = "<?php  echo getlang("ค้นหา::l::Search"); ?>" class = "unnamedbtnweb"> -->
							<input type = "reset" value = "<?php  echo getlang("ลบคำค้น::l::Reset"); ?>" class = "unnamedbtnweb" name = "reset">
							<?php 
$upachidechkperinfo=barcodeval_get("webpage-o-upachidechkperinfo");			
if ($upachidechkperinfo!="yes") {				
							?>
							<input type = reset value = "<?php  echo getlang("ตรวจสอบรายละเอียดส่วนตัว::l::Check personal record"); ?>" onclick = "location='/<?php 
echo $dcr;
?>/member/'" class = unnamedbtn>
<?php 
}
?>
<input style='width: 120px' type = reset value = "Basic Search" onclick = "location='/<?php 
echo $dcr;
?>/index.php?setforcehpmode=search'" class = unnamedbtnweb style="font-weight: normal;" ><INPUT TYPE="hidden" NAME="noaddoptionbtn" value="<?php  echo $noaddoptionbtn;?>">
                        </td>
                    </tr>
<?php 
}
?> 
</FORM>

</TABLE><?php 
if ($_advsearch_includemode!="yes") {
	include("searchformFooter.php");
	include("searchFormJS.php");
}
?>
