<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();

	$s=tmq("select * from quickstat where id='$id'");
	$s=tmq_fetch_array($s);
	?><B><?php echo getlang("สถิติ::l::Statistic").": ".getlang($s[name]);?></B><BR>
	<?php 
echo getlang("ดึงข้อมูลจากแท็ก::l::Use tag").": ".getlang($s[tag]). " ".getlang("ด้วย::l::With")." $subid ";
echo getlang("เฉพาะข้อมูลในปี::l::These year(s) only").": ".($s[yea]);
if (trim($s[yea])=="") {
	echo getlang("ทุกปี::l::All years");
}
include("export.inc.php");

//select more field than export.inc.php
			$sqli="select * from media,media_mid where media.ID=media_mid.pid and $yeasql ";

			$sqli.=" and (
				tag$s[tag] like '__$subid%'  
				or
				tag$s[tag] like '__^a$subid%'  
				) ";
			$sqli=tmq($sqli);
echo "<BR>". number_format(tmq_num_rows($sql)) . " Bib ";
			echo number_format(tmq_num_rows($sqli))." Items";

?><TABLE>
<TR>
	<TD>Barcode</TD>
	<TD>Title</TD>
	<TD>Author</TD>
	<TD>Imprint</TD>
	<TD>Price</TD>
</TR>
<?php  while ($r=tmq_fetch_array($sqli)) {

?>
<TR>
	<TD><?php  echo $r[bcode];?></TD>
	<TD><?php  echo dspmarc(substr($r[tag245],2));?></TD>
	<TD><?php  echo dspmarc(substr($r[tag100],2));?></TD>
	<TD><?php  echo dspmarc(substr($r[tag260],2));?></TD>
	<TD><?php  echo dspmarc($r[price]);?></TD>
</TR>
<?php }?>
</TABLE>