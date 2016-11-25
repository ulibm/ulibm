<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varcat";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php 
pagesection(getlang("ค่าตัวแปรระบบ-การลงรายการ::l::System variables-Cataloging"));

?>
<table border = 0 cellpadding = 0 width = 900 align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<?php 
local_mn("bibitemquicktext","catconfig","bibitemquicktext","longtext");
local_mn("isshowinumberfirstitem","catconfig","isshowinumberfirstitem","yesno");
local_mn("inumbercode","catconfig","inumbercode","text");
local_mn("isshowinumberfirstitemserial","catconfig","isshowinumberfirstitemserial","yesno");
local_mn("inumbercodeserial","catconfig","inumbercodeserial","text");
local_mn("allowed_char2barcode","catconfig","allowed_char2barcode","text");
local_mn("marc_bibiddsp","MARC","bibiddsp","text");
local_mn("marc_callnumtags","MARCdsp","callnum","text");
local_mn("marc_librarysymboltag","MARC","librarysymboltag","text");
local_mn("marc_librarysymbolval","MARC","librarysymbolval","text");
local_mn("serialboundmdtype","MARC","serial-bound-mdtype","foreign:-localdb-,media_type,code,name,no");
local_mn("serialmdtype","MARC","serial-mdtype","foreign:-localdb-,media_type,code,name,no");
local_mn("serialcappat","MARC","serial-cappat","text");
local_mn("serialenumchro","MARC","serial-enumchro","text");
local_mn("confdef_bc_len","config","def_bc_len","number");
local_mn("confdef_bc_lenmem","config","def_membc_len","number");
local_mn("hidesystemlibfaucet","config","hidesystemlibfaucet","yesno");
local_mn("bibphysicaldesctext","catconfig","bibphysicaldesctext","longtext");


?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>