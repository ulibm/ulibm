<?php 
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();

$s=tmq("select * from media_mid where ismarked='YES' ");
while ($r=tmq_fetch_array($s)) {
	tmq("insert into xpbc  set bc='$r[bcode]' ");
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("การดำเนินการเรียบร้อย สามารถดูผลการเพิ่มได้ที่เมนู พิมพ์บาร์โค้ดหนังสือ ในเมนูหลัก บาร์โค้ด::l::Operation success, result of this action can view at Barcode-on-demand in Barcode module"); ?> ");
//-->
</SCRIPT>
<?php 

redir("media_type.php");

	?>