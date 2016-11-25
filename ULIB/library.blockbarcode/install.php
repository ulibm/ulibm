<?php 
include("../inc/config.inc.php");
html_start();
?><CENTER><?php 
echo "<H1>ติดตั้ง บาร์โค้ดแบบตรงบล็อค สำหรับเวอร์ชัน 5.x</H1>";

if ($action=="") {
	?><A HREF="install.php?action=installandpermission">ติดตั้งและเปิดสิทธิ์ให้บรรณารักษ์ทุกคนใช้</A><BR>
	<A HREF="install.php?action=install">ติดตั้งเท่านั้น</A><BR><FONT SIZE="" COLOR="red">แทนที่ไฟล์ ../inc/barcode/barcode39.php ด้วยไฟล์ชื่อ barcode39.php ในโฟลเดอร์นี้ด้วย<BR>และนำไฟล์ media_type.php ไปแทนที่ไฟล์ใน ../inc/library.bitemman/ </FONT><?php 
}

if ($action!="") {
	echo "เริ่มดำเนินการติดตั้ง";
	tmq("delete from `library_modules` where code='barcodeblock1' ");
	tmq("INSERT INTO `library_modules` (`id`, `icon`, `code`, `name`, `url`, `nested`, `ordr`, `isshow`, `isbold`) VALUES (209, 'barcode', 'barcodeblock1', 'บาร์โค้ดแบบตรงบล็อค::l::Positioned barcode', '[dcr]/library.blockbarcode/', 'barcodemenu', 50, 'yes', 'no');");
	tmq("delete from barcode_valmem");
	tmq("delete from barcode_val where classid like 'BARCODE-blockbc-%' ");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23075, 'BARCODE-blockbc-standard-isshownum', 'yes');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (12916, 'BARCODE-blockbc-titlebc-isshownum', 'yes');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (12917, 'BARCODE-blockbc-titlebc-addtext', 'สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (19345, 'BARCODE-blockbc-logobc-isshownum', 'yes');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (19346, 'BARCODE-blockbc-logobc-addtext', ' สำนักวิทยบริการ ม.มหาสารคาม');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (19347, 'BARCODE-blockbc-logobc-spinewidth', '40');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23077, 'BARCODE-blockbc-standard-callntag', 'tag099');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23078, 'BARCODE-blockbc-standard-callnformat', 'DC');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23079, 'BARCODE-blockbc-standard-spinewidth', '30');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23076, 'BARCODE-blockbc-standard-addtext', '        สำนักวิทยบริการ MSU');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (13963, 'BARCODE-blockbc-ribbon-isshownum', 'yes');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23737, 'BARCODE-blockbc-ribbon-callntag', 'tag099');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (13965, 'BARCODE-blockbc-ribbon-callnformat', 'DC');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23739, 'BARCODE-blockbc-ribbon-colorof[DVD]', '0C2E78');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23740, 'BARCODE-blockbc-ribbon-colorof[VCD]', '08FF00');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23741, 'BARCODE-blockbc-ribbon-colorof[CDA]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23742, 'BARCODE-blockbc-ribbon-colorof[น]', 'FF8000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23743, 'BARCODE-blockbc-ribbon-colorofchar[a]', '8A1903');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23744, 'BARCODE-blockbc-ribbon-colorofchar[b]', 'FF8000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23745, 'BARCODE-blockbc-ribbon-colorofchar[c]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23746, 'BARCODE-blockbc-ribbon-colorofchar[d]', '035203');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23747, 'BARCODE-blockbc-ribbon-colorofchar[e]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23748, 'BARCODE-blockbc-ribbon-colorofchar[f]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23749, 'BARCODE-blockbc-ribbon-colorofchar[g]', 'FFE500');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23750, 'BARCODE-blockbc-ribbon-colorofchar[h]', '0026FF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23751, 'BARCODE-blockbc-ribbon-colorofchar[i]', 'D61FFF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23752, 'BARCODE-blockbc-ribbon-colorofchar[j]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23753, 'BARCODE-blockbc-ribbon-colorofchar[k]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23754, 'BARCODE-blockbc-ribbon-colorofchar[l]', 'D61FFF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23755, 'BARCODE-blockbc-ribbon-colorofchar[m]', '000B5E');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23756, 'BARCODE-blockbc-ribbon-colorofchar[n]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23757, 'BARCODE-blockbc-ribbon-colorofchar[o]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23758, 'BARCODE-blockbc-ribbon-colorofchar[p]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23759, 'BARCODE-blockbc-ribbon-colorofchar[q]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23760, 'BARCODE-blockbc-ribbon-colorofchar[r]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23761, 'BARCODE-blockbc-ribbon-colorofchar[s]', '730000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23762, 'BARCODE-blockbc-ribbon-colorofchar[t]', '3C003D');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23763, 'BARCODE-blockbc-ribbon-colorofchar[u]', '3F9E00');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23764, 'BARCODE-blockbc-ribbon-colorofchar[v]', 'D61FFF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23765, 'BARCODE-blockbc-ribbon-colorofchar[w]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23766, 'BARCODE-blockbc-ribbon-colorofchar[x]', 'C800FF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23767, 'BARCODE-blockbc-ribbon-colorofchar[y]', '277006');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23768, 'BARCODE-blockbc-ribbon-colorofchar[z]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23769, 'BARCODE-blockbc-ribbon-colorofchar[0]', 'FFB300');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23770, 'BARCODE-blockbc-ribbon-colorofchar[1]', 'E80505');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23771, 'BARCODE-blockbc-ribbon-colorofchar[2]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23772, 'BARCODE-blockbc-ribbon-colorofchar[3]', 'FF8000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23773, 'BARCODE-blockbc-ribbon-colorofchar[4]', '000000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23774, 'BARCODE-blockbc-ribbon-colorofchar[5]', '0026FF');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23775, 'BARCODE-blockbc-ribbon-colorofchar[6]', 'FF0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23776, 'BARCODE-blockbc-ribbon-colorofchar[7]', '00FF4D');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23777, 'BARCODE-blockbc-ribbon-colorofchar[8]', 'ED0000');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23778, 'BARCODE-blockbc-ribbon-colorofchar[9]', '0025F5');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23738, 'BARCODE-blockbc-ribbon-addtext', '  สำนักวิทยบริการ MSU');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23810, 'BARCODE-blockbc-addblank', '0');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23811, 'BARCODE-blockbc-margin', '5');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23817, 'BARCODE-blockbc-color', '00158A');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23809, 'BARCODE-blockbc-allbc', '20001');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23812, 'BARCODE-blockbc-setxdist', '198');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23813, 'BARCODE-blockbc-setydist', '107.55');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23814, 'BARCODE-blockbc-pagemarginx', '100');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23815, 'BARCODE-blockbc-pagemarginy', '0');");
tmq("INSERT INTO `barcode_val` (`id`, `classid`, `val`) VALUES (23816, 'BARCODE-blockbc-bctype-plain', 'yes');");

}
if ($action=="installandpermission") {
	$s=tmq("select * from library");
	while ($r=tmq_fetch_array($s)) {
		tmq("delete from library_permission where lib='$r[UserAdminID]' and code='barcodeblock1'  ");
		tmq("insert into library_permission set lib='$r[UserAdminID]' , code='barcodeblock1'  ");
	}
}
if ($action!="") {
	echo "<H1 style='color:darkgreen'>การติดตั้งเสร็จเรียบร้อย</H1><H3>กรุณาลบไฟล์ install.php ในโฟลเดอร์ library.blockbarcode ออก</H3>";
}
?></CENTER>
<?php  foot();?>