<?php 
include("../inc/config.inc.php");
html_start();
?>
<style>
.localquickstatheader {
	padding-left: 5px;
	color: #2b527d;
}
</style>
<?php 
if ($mode=="mats") {
	echo "<b class=localquickstatheader>".getlang("จำนวน Bib::l::Bib Count")." :</b> ";
	$s=tmq("select id from media ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Bib ที่มีเชื่อมโยงในแท็ก 856::l::Bib Count (Have URLs in tag 856)")." :</b> ";
	$s=tmq("select id from media where tag856 like '%://%' ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Bib ที่มี Leader/07 = m::l::Bib Count (Leader/07 = m)")." :</b> ";
	$s=tmq("select id from media where leader like '_______m%' ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Bib ที่มี Leader/07 = s::l::Bib Count (Leader/07 = s)")." :</b> ";
	$s=tmq("select id from media where leader like '_______s%' ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Bib ที่มี Leader/07 = b::l::Bib Count (Leader/07 = b)")." :</b> ";
	$s=tmq("select id from media where leader like '_______b%' ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Item::l::Item Count")." :</b> ";
	$s=tmq("select id from media_mid ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";
	echo  "<b class=localquickstatheader>".getlang("จำนวน Item สถานะปกติ::l::Item Count with normal status")." :</b> ";
	$s=tmq("select id from media_mid where status='' ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR><BLOCKQUOTE>";
		echo  "<b class=localquickstatheader>".getlang("จำนวน Item สถานะอื่นๆ::l::Item Count with other status")." : </b><BR>";
		$s=tmq("select * from media_mid_status where code<>'' ");
		while ($r=tmq_fetch_array($s)) {
			$s2=tmq("select id from media_mid where status='$r[code]' ");
			$s2=tmq_num_rows($s2);
			if ($s2!=0) {
				echo  "<b class=localquickstatheader>&nbsp;&nbsp;".getlang($r[name])." :</b> ";
				echo number_format($s2);
				echo " <BR>";
			}
		}
	echo "</BLOCKQUOTE>";
	echo "<BLOCKQUOTE>";
		echo  "<b class=localquickstatheader>".getlang("จำนวน Item ตามประเภททรัพยากร::l::Item Count by Resource Type")." : </b><BR>";
		$s=tmq("select * from media_type where 1 ");
		while ($r=tmq_fetch_array($s)) {
			$s2=tmq("select id from media_mid where RESOURCE_TYPE='$r[code]' ");
			$s2=tmq_num_rows($s2);
			if ($s2!=0) {
				echo  "<b class=localquickstatheader>&nbsp;&nbsp;".getlang($r[name])." :</b> ";
				echo number_format($s2);
				echo " <BR>";
			}
		}
	echo "</BLOCKQUOTE>";
	echo "<BLOCKQUOTE>";
		echo  "<b class=localquickstatheader>".getlang("จำนวน Item ตามสถานที่จัดเก็บ::l::Item Count by Place")." : </b><BR>";
		$s=tmq("select * from library_site where 1 ");
		while ($r=tmq_fetch_array($s)) {
			echo  "<b class=localquickstatheader>&nbsp;&nbsp;".getlang($r[name])." : </b><BR>";
			$s2=tmq("select * from media_place where main='$r[code]' ");
			while ($r2=tmq_fetch_array($s2)) {
				$sc=tmq("select id from media_mid where place='$r2[code]' ");
				$sc=tmq_num_rows($sc);
				if ($sc!=0) {
					echo  "<b class=localquickstatheader>&nbsp;&nbsp;&nbsp;&nbsp;".getlang($r2[name])." :</b> ";
					echo number_format($sc);
					echo " <BR>";
				}
			}
		}
	echo "</BLOCKQUOTE>";
}

if ($mode=="mem") {
	echo  "<b class=localquickstatheader>".getlang("จำนวนสมาชิก::l::All members")." :</b> ";
	$s=tmq("select UserAdminID from member ");
	$s=tmq_num_rows($s);
	echo number_format($s);
	echo "<BR>";

		echo  "<b class=localquickstatheader>".getlang("จำนวนสมาชิก ตามคำนำหน้า::l::Members by prefix")." : </b><BR><BLOCKQUOTE>";
		$s=tmq("select distinct prefi from member ");
		while ($r=tmq_fetch_array($s)) {
			$s2=tmq("select UserAdminID from member where prefi='$r[prefi]' ");
			$s2=tmq_num_rows($s2);
			if ($s2!=0) {
				if ($r[prefi]=="") {
					echo  "<b class=localquickstatheader>".getlang("ไม่ระบุ::l::Empty")."</b>";
				}
				echo "<b class=localquickstatheader>".getlang($r[prefi])." : </b>";
				echo number_format($s2);
				echo " <BR> ";
			}
		}
	echo "</BLOCKQUOTE>";

}
?>