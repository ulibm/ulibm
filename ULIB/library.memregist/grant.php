<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="memregist-grant";
mn_lib();
$tbname="webpage_memregist";
//printr($selectlist);
$now=time();
echo "<center>";
if ($issave=="yes" && count($selectlist)>0) {
  	 if ($submitaction=="Add") {
  	while (list($k,$v)=each($selectlist)) {
  		$source=tmq("select * from webpage_memregist where id='$v' and granted='no' ",false);
  		if (tmq_num_rows($source)==1) {
  			$source=tmq_fetch_array($source);
  			$source[UserAdminID]=stripslashes($source[UserAdminID]);
  			$source[Password]=stripslashes($source[Password]);
  				$source[UserAdminID]=addslashes($source[UserAdminID]);
  			$source[email]=stripslashes($source[email]);
  				$source[email]=addslashes($source[email]);
  			$source[tel]=stripslashes($source[tel]);
  				$source[tel]=addslashes($source[tel]);
  			$source[UserAdminName]=stripslashes($source[UserAdminName]);
  				$source[UserAdminName]=addslashes($source[UserAdminName]);
  			$s="insert into member set 
  			email='$source[email]',
  			tel='$source[tel]',
  			UserAdminID='$source[UserAdminID]',
  			UserAdminName='$source[UserAdminName]',
  			Password='$source[Password]',
  			descr='$source[descr]',
  			libsite='$LIBSITE',
  			prefi='$source[prefi]',
				type='$memregtype'
  			";
  			tmq( $s);
				tmq("update webpage_memregist set granted='yes',granter='$useradminid',grantdt='$now' where id='$v'  ",false);
				echo getlang("เพิ่มแล้ว::l::Added").":$source[UserAdminName]<BR>";
  		}
  	}
	} elseif ($submitaction=="Delete Selected") {
		while (list($k,$v)=each($selectlist)) {
			tmq("delete from webpage_memregist where id='$v' and granted='no' ",false);
		}
	} elseif ($submitaction=="Denied Selected") {
		while (list($k,$v)=each($selectlist)) {
			$denieddescr=addslashes($denieddescr);
			tmq("update webpage_memregist set granted='denied',granter='$useradminid',grantdt='$now' ,denieddescr='$denieddescr' where id='$v'  ",false);
		}
	}
}
if ($deleteall=="yes") {
	tmq("delete from webpage_memregist where  granted='no' ",false);
	html_dialog("seccess","Delete all records");
}
echo "</center>";
$c[2][text]="Name::l::Name";
$c[2][field]="UserAdminName";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="".barcodeval_get("memregist-extfieldname")."";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[9][text]="แสดงให้ผู้ใช้เห็นหรือไม่::l::Show to user";
$c[9][field]="isshowtouser";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

//dsp


$dsp[4][text]="-";
$dsp[4][field]="id";
$dsp[4][width]="2%";
$dsp[4][filter]="module:local_checkbox";

$dsp[2][text]="Name::l::Name";
$dsp[2][field]="UserAdminName";
$dsp[2][width]="30%";
$dsp[2][filter]="module:local_detail";


function local_checkbox($wh) {
	$s="<INPUT TYPE=checkbox NAME='selectlist[]' value='$wh[id]' ID='item$wh[id]'>";

	return $s;
}

function local_detail($wh) {
	$s="<label for='item$wh[id]'>$wh[prefi] $wh[UserAdminName]<BR>
	Barcode=[$wh[UserAdminID]] Password=[$wh[Password]]<BR>
	Email=[$wh[email]] Tel.=[$wh[tel]]<BR>
	".barcodeval_get("memregist-extfieldname")."=[$wh[descr]]
	</label>";

	return $s;
}
?><FORM METHOD=POST ACTION="<?php  echo $PHP_SELF;?>">
<TABLE width=780 align=center>
	<TR>
	<TD><?php 
fixform_tablelister($tbname," granted='no' ",$dsp,"no","no","yes","mi=$mi",$c);
?></TD>
</TR>
<TR>
	<TD>
	<?php 
		echo getlang("ลบรายการที่เลือก::l::Delete selected") .": ";

	?><INPUT TYPE="submit" name="submitaction" value="Delete Selected" onclick="return confirm('<?php  echo getlang("ลบรายการที่เลือก?::l::Delete selected?");?>');"><?php 
	
	?><BR>
	<?php 
		echo getlang("ปฏิเสธการสมัคร::l::Deny registration") .": ";

	?> <?php echo getlang("เหตุผล::l::Reason");?>:<INPUT TYPE="text" NAME="denieddescr" size=50><INPUT TYPE="submit" name="submitaction" value="Denied Selected" onclick="return confirm('<?php  echo getlang("ปฏิเสธการสมัคร รายการที่เลือก?::l::Denied Selected?");?>');"><?php 
	
	?><BR><?php 
	echo getlang("เพิ่มเป็นสมาชิก::l::Add  as Member") .": ";
	form_quickedit("memregtype",barcodeval_get("memregist-defmemregtype"),"foreign:-localdb-,member_type,type,descr");
	?> <INPUT TYPE="submit" value="Add" name="submitaction"></TD>
</TR><INPUT TYPE="hidden" NAME="issave" value="yes">
</TABLE>
<center><a href="grant.php?deleteall=yes" 
onclick="return confirm('Delete ALL records/ ลบทุกรายการ?') && confirm('Please Confirm again')"
class="a_btn" style="color: darkred"><?php echo getlang("ลบข้อมูลทุกรายการ::l::Delete all records"); ?></a></center>
</FORM>
<?php 

foot();
?>