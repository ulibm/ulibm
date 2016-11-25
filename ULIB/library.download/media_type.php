<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
?><BR><?php 
			pagesection(getlang("ดาวน์โหลดไฟล์อรรถประโยชน์::l::Download misc. file"));

function local_dl($file,$title,$icon="Down.gif") {
?><B><A HREF="<?php echo $file?>" target=_blank><img width=16 src='../neoimg/<?php  echo $icon?>' align=absmiddle border=0> <?php echo getlang($title)?></A></B><BR>
<?php 
	
}
function local_set($item,$title) {
?>&nbsp;&nbsp;<IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle><A HREF="set.php?item=<?php  echo $item?>"><?php echo getlang($title);?></A><BR>
<?php 	
}
?>

<table width=900 align=center>
<tr valign=top>
	<td width=420>

<TABLE width=400 align=center>
<TR>
	<TD><?php 
echo "<BR><B>".getlang("ไฟล์ต้นฉบับภาพบัตรห้องสมุด::l::Member card template")."  (psd)</B><BR>";
echo "<TABLE><TR valign=top><TD>";
local_dl("card_back.psd","ด้านหลัง แบบ 1::l::Back type 1","psdicon.gif");
local_dl("card_front.psd","ด้านหน้า แบบ 1::l::Front type 1","psdicon.gif");
local_dl("_card_back1.jpg","ด้านหลัง 1::l::back JPG","icon_jpg.gif");
local_dl("_card_front1.jpg","ด้านหน้า 1::l::Front type 1","icon_jpg.gif");
echo "</TD><TD style='padding-left: 20px;'>";
echo "<IMG SRC='card1-thumb.gif' WIDTH='100' BORDER='1' ALT=''>";
echo "</TD></TR></TABLE>";
echo "<TABLE><TR valign=top><TD>";
local_dl("card_back-2.psd","ด้านหลัง แบบ 2::l::Back type 2","psdicon.gif");
local_dl("card_front-2.psd","ด้านหน้า แบบ 2::l::Front type 2","psdicon.gif");
local_dl("_card_back2.jpg","ด้านหลัง 2::l::back JPG","icon_jpg.gif");
local_dl("_card_front2.jpg","ด้านหน้า 2::l::Front type 1","icon_jpg.gif");
echo "</TD><TD style='padding-left: 20px;'>";
echo "<IMG SRC='card2-thumb.gif' WIDTH='100' BORDER='1' ALT=''>";
echo "</TD></TR></TABLE>";
echo "<TABLE><TR valign=top><TD>";
local_dl("card_back-3.psd","ด้านหลัง แบบ 3::l::Back type 3","psdicon.gif");
local_dl("card_front-3.psd","ด้านหน้า แบบ 3::l::Front type 3","psdicon.gif");
local_dl("_card_back3.jpg","ด้านหลัง 3::l::back JPG","icon_jpg.gif");
local_dl("_card_front3.jpg","ด้านหน้า 3::l::Front type 3","icon_jpg.gif");
echo "</TD><TD style='padding-left: 20px;'>";
echo "<IMG SRC='card3-thumb.gif' WIDTH='100' BORDER='1' ALT=''>";
echo "</TD></TR></TABLE>";

	echo "<BR>";

local_dl("_registform.php","แบบฟอร์มสมัครสมาชิกห้องสมุด (pdf)::l::Member  registration form (pdf)","pdf_icon16.png");

	local_set("registform-head","ข้อความส่วนหัว::l::Head");
	local_set("registform-body","ข้อความ::l::Text");

local_dl("_mannualcheckout.php","แบบฟอร์มยืม-คืนด้วยมือ (pdf)::l:: Mannual checkin-checkout (pdf)","pdf_icon16.png");

	local_set("mannual-head","ข้อความส่วนหัว::l::Head");
	local_set("mannual-body","ข้อความ::l::Text");

local_dl("_bookstamp.php","แบบฟอร์มปั๊มวันยืมคืนที่ติดหนังสือ (pdf)::l::Checkout stamp paper (pdf)","pdf_icon16.png");

	local_set("bookstamp-body","ข้อความ::l::Text");

local_dl("paper_head.psd","ไฟล์ต้นแบบภาพหัวกระดาษ (psd)::l::Paper header template (psd)","psdicon.gif");
local_dl("paper_foot.psd","ไฟล์ต้นแบบภาพท้ายกระดาษ (psd)::l::Paper footer template (psd)","psdicon.gif");
/*
echo "<BR><B>".getlang("แบบฟอร์มทวงหนังสือค้างส่ง::l::Overdue notification form")."</B><BR>";

	local_set("notification-head","ข้อความส่วนหัว::l::Head");
	local_set("notification-body1","ข้อความ 1::l::Text 1 ");
	local_set("notification-body2","ข้อความ 2::l::Text 2 ");

echo "<BR><B>".getlang("แบบฟอร์มทวงค่าปรับ::l::Fines notification form")."</B><BR>";

	local_set("finesnotification-head","ข้อความส่วนหัว::l::Head");
	local_set("finesnotification-body1","ข้อความ 1::l::Text 1 ");
	local_set("finesnotification-body2","ข้อความ 2::l::Text 2 ");
*/
	echo "<BR>";
	
local_dl("winxp.AdbeRdr707_en_US.exe","Adobe Reader 7 (EXE-winxp)","installerIcon32.png");
local_dl("AdobeReader_enu-7.0.8-1.i386.rpm","Adobe Reader 7 (RPM-linux)","installerIcon32.png");
local_dl("AdbeRdr930_en_USxp.exe","Adobe Reader 9 (EXE-winxp)","installerIcon32.png");
local_dl("AdbeRdr930_en_US7.exe","Adobe Reader 9 (EXE-Windows 7)","installerIcon32.png");
local_dl("AdbeRdr9.3.1-1_i486linux_enu.rpm","Adobe Reader 9 (RPM-linux)","installerIcon32.png");

local_dl("hashcalc.setup.exe","MD5+etc calculator (HashCalc) (EXE-win32)","installerIcon32.png");
local_dl("winMd5Sum-install.exe","MD5 calculator (winMd5Sum) (EXE-win32)","installerIcon32.png");

echo "<BR><B>".getlang("การให้บริการห้องสมุดเบื้องต้นกับโปรแกรม ULIB")."</B><BR>";
local_dl("ulib.pdf","ดาวน์โหลด (pdf)::l::Download now (pdf)","pdf_icon16.png");

echo "<BR><B>".getlang("ULIB-Kiosk")."</B><BR>";
local_dl("ulibkiosk.sfx.exe","ULIB-Kiosk","installerIcon32.png");
local_dl("dotnetfx.exe",".Net Framework 2.0","installerIcon32.png");
/*
echo "<BR><B>".getlang("ประกาศและกฏระเบียบ::l::Annouce and rules")."</B><BR>";
local_dl("ulibdresses.doc","เครื่องแต่งกาย","word_icon16.gif");
local_dl("ulibrulescards.doc","แจกแผ่นพับซึ่งหน้า","word_icon16.gif");
*/
echo "<BR><B>".getlang("อื่น ๆ::l::Others")."</B><BR>";
local_dl("ZoomIt.zip","ZoomIT","installerIcon32.png");

?>
</TD>
</TR>
</TABLE>

</td>
	<td>
<?php 
	echo "<BR><B>".getlang("ไฟล์อื่น ๆ ที่ใช้ในการปฏิบัติงาานห้องสมุด::l::General forms for librarian")."  </B><BR>";
	echo getlang("ดาวน์โหลดไปแก้ไขได้::l::Download and customise")."<br>";
	local_dl("register_nisit.doc","สมัครสมาชิกห้องสมุด","word_icon16.gif");
	local_dl("regerter_external.doc","สมัครสมาชิกห้องสมุด (บุคคลภายนอก)","word_icon16.gif");
	local_dl("requestform.doc","แบบฟอร์มขอใช้โสตทัศนอุปกรณ์ของห้องสมุด","word_icon16.gif");
	local_dl("lostbook.doc","แบบฟอร์มแจ้งหนังสือหาย","word_icon16.gif");
	local_dl("onprocessrequest.doc","แบบฟอร์มบริการหนังสือดำเนินการ","word_icon16.gif");
	local_dl("entrance_form.xls","แบบบันทึกผู้เข้าใช้บริการห้องสมุด","Excel-icon.png");
	local_dl("matsuggest.doc","แบบฟอร์มแนะนำสั่งซื้อทรัพยากร","word_icon16.gif");
	local_dl("matsuggest_card.doc","แบบฟอร์มแนะนำสั่งซื้อทรัพยากร  (บัตรแนะนำ)","word_icon16.gif");
	local_dl("bibprocess.doc","แบบฟอร์มหนังสือดำเนินการ","word_icon16.gif");
	local_dl("stamp.psd","ตราประทับทั่วไปในห้องสมุด","psdicon.gif");
	echo "<BR><B>".getlang("แผ่นพับและโบรชัวร์::l::Hand-out ")."  </B><BR>";
	local_dl("brc_search.doc","แผ่นพับแนะนำการสืบค้น","word_icon16.gif");

?>
	</td>
</tr>
</table><BR>
<?php 
		foot();
?>