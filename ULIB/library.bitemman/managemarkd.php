<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
?><TABLE align=center width=780>
<TR>
	<TD><?php 
		$s=tmq("select count(id) as cc from media_mid where ismarked='YES' ");
	$s=tmq_fetch_array($s);
	if ($s[cc]!=0) {
		?><BR> <CENTER><B><?php  echo getlang("จัดการรายการที่ Mark ไว้แล้ว::l::Manage Marked Records"); ?> (<?php  echo number_format($s[cc]);?> <?php  echo getlang("รายการ::l::records"); ?>)</B></CENTER> <BR><B><?php  echo getlang("คำเตือน::l::Warning"); ?>!</B> <?php  echo getlang(" ส่วนนี้จะเป็นการแก้ไขรายการวัสดุโดยการคลิกเพียงครั้งเดียว<BR> ขอแนะนำให้ทำการสำรองข้อมูลไว้ก่อน เพื่อป้องกันความผิดพลาด::l::This operation is a Single-Click command.<BR>We recommended to backup database befor continuing."); ?><BR><BR>

		<TABLE width=780 align=center>
		<TR>
			<TD align=center colspan=2>	<B><?php  echo getlang("กรุณาเลือกคำสั่ง::l::Choose command."); ?></B></TD>
		</TR>
		
				<TR>
			<TD><B><?php  echo getlang("เพิ่มใน บาร์โค้ดเอนกประสงค์::l::Add in Barcode-on-demand"); ?></B></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_xpbc.php"><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"></FORM></TD>
		</TR>
		
		
				<TR>
			<TD><B><?php  echo getlang("เพิ่มใน รายการพิมพ์บาร์โค้ดหนังสือ::l::Add in Books-Barcode"); ?></B></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_xpbcbook.php"><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7"></FORM></TD>
		</TR>
		

		
		<TR>
			<TD><B><?php  echo getlang("เพิ่มใน   พิมพ์บาร์โค้ดและเลขเรียกหนังสือ::l::Add in Books-Barcode and Call number"); ?></B></TD>
			<TD>

<TABLE><TR>
		<TD  ><FORM METHOD=POST ACTION="ch_barcode.php"><INPUT TYPE="submit" value=" LC/NLM "  style="background-color: #FFC4C7">
				<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-xpbc_bookcraft-allbc">
</FORM></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_barcode.php"><INPUT TYPE="submit" value=" DC "  style="background-color: #FFC4C7">
			<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-xpbc_dcbookcraft-allbc">
</FORM></TD>
</TR></TABLE>

			</TD>
		</TR>

		<TR>
			<TD><B><?php  echo getlang("เพิ่มใน  พิมพ์เลขเรียกหนังสือ::l::Add in Books-Barcode Call number "); ?></B></TD>
			<TD>

<TABLE><TR>
		<TD  ><FORM METHOD=POST ACTION="ch_barcode.php"><INPUT TYPE="submit" value=" LC/NLM "  style="background-color: #FFC4C7">
		<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-xpbc_bookfront-allbc">
		</FORM></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_barcode.php"><INPUT TYPE="submit" value=" DC "  style="background-color: #FFC4C7">		<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-xpbc_dcbookfront-allbc"></FORM>
</TD>
</TR></TABLE>

			</TD>
		</TR>
		

		<TR>
			<TD><B><?php  echo getlang("เพิ่มใน  ชื่อเรื่อง เลขเรียก BC ไอเทม::l::Add in Books-Barcode Title, Callnumber, BC-item"); ?></B></TD>
			<TD><FORM METHOD=POST ACTION="ch_barcode.php">
<INPUT TYPE="submit" value=" เพิ่ม "  style="background-color: #FFC4C7">
		<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-titlcallnbcitem-allbc">
			</FORM></TD>
		</TR>

		<TR>
			<TD><B><?php  echo getlang("เพิ่มใน  การพิมพ์บาร์โค้ดแบบตรงบล็อค::l::Add in Block-barcode"); ?></B></TD>
			<TD><FORM METHOD=POST ACTION="ch_barcode.php">
<INPUT TYPE="submit" value=" เพิ่ม "  style="background-color: #FFC4C7">
		<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-blockbc-allbc">
			</FORM></TD>
		</TR>


		<TR>
			<TD><B><?php  echo getlang("เพิ่มใน  ชื่อเรื่อง เลขเรียก BC Bib::l::Add in Books-Barcode Title, Callnumber, BC-Bib"); ?></B></TD>
			<TD><FORM METHOD=POST ACTION="ch_barcode.php">
<INPUT TYPE="submit" value=" เพิ่ม "  style="background-color: #FFC4C7">
		<INPUT TYPE="hidden" NAME="bcid" value="BARCODE-titlcallnbcbib-allbc">
			</FORM></TD>
		</TR>


				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนสถานะเป็น::l::Change Status to"); ?></B> </TD>
			<TD><FORM METHOD=POST ACTION="ch_status.php" onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');"><SELECT NAME="status">
<?php 
	echo "<option value=''>ปกติ ";
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[code]'>".getlang($r[name])." ($r[code]) ";
}
?> 
			</SELECT> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7">
			</FORM></TD>
		</TR>
		

				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนห้องสมุดที่เป็นเจ้าของ::l::Change Library campus"); ?></B></TD>
			<TD><FORM METHOD=POST ACTION="ch_siteoflib.php" onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');">
			<?php 
frm_libsite("siteoflib");	
?> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7">
</FORM></TD>
		</TR>
		

				<TR>
			<TD><B><?php  echo getlang("เปลี่ยนสถานที่จัดเก็บ::l::Change Shelf"); ?></B></TD>
			<TD><FORM METHOD=POST ACTION="ch_place.php"  onsubmit="return confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!');"><?php frm_itemplace("itemplace","NONE","NO");
?> <INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการ::l::Operate"); ?>"  style="background-color: #FFC4C7">
</FORM></TD>
		</TR>
		

				<TR>
			<TD><B><?php  echo getlang("ลบ::l::Delete"); ?></B></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_del.php" onsubmit="return ( confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง การกระทำนี้ไม่สามารถยกเลิกการกระทำได้::l::Please confirm again this action cannot be undone."); ?>!') && confirm('<?php  echo getlang("กรุณายืนยันการลบ::l::CONFIRM DELETION"); ?>'));"><INPUT TYPE="submit" value="<?php  echo getlang("ดำเนินการลบ::l::Operate deletion"); ?>"  style="background-color: #FFC4C7">
			</FORM></TD>
		</TR>
		


				<TR>
			<TD><B><?php  echo getlang("เคลียร์สถานะ เพิ่งรับคืน::l::Clear Just-Returned status"); ?></B></TD>
			<TD  ><FORM METHOD=POST ACTION="ch_clearjustreturn.php" onsubmit="return ( confirm('<?php  echo getlang("กรุณายืนยันอีกครั้ง::l::Please confirm again ."); ?>!'));"><INPUT TYPE="submit" value="<?php  echo getlang("เคลียร์::l::Clear"); ?>">
			</FORM></TD>
		</TR>
		
<?php 
	} else {
		?><BR> <CENTER><B><?php  echo getlang("ยังไม่ได้ Mark รายการใดไว้::l::No record marked"); ?></B></CENTER> <BR><?php 
	}
	

	?></TD>
</TR>
</TABLE>
<BR><CENTER><br />
<?php 
$sno=tmq("select * from media_mid where ismarked='YES' and price=0 ");
$s=tmq("select sum(price) as pp,count(id) as cc from media_mid where ismarked='YES'  ");
$s=tmq_fetch_array($s);
echo getlang("มีทรัพยากรที่ไม่ได้กำหนดราคาทั้งหมด ::l:: Items without spec. price ");
echo number_format(tmq_num_rows($sno));
echo getlang(" items.<br />");
echo getlang("มีทรัพยากรกำหนดราคาทั้งหมด ::l:: Items with price ");
echo number_format($s[cc]);
echo getlang(" items. <br />");
echo getlang(" รวมมูลค่า ::l:: Sum price ");
echo number_format($s[pp]);
echo getlang(" ฿.");
?><br /><br />
<?php 
	$bcount=tmq("select distinct pid from media_mid where ismarked='YES'  ");
	$bcount=number_format(tmq_num_rows($bcount));
	$icount=tmq("select id from media_mid where ismarked='YES'  ");
	$icount=number_format(tmq_num_rows($icount));
?>
<?php  echo getlang("ส่งออก Bib ::l::Export Bib. ");?> [<?php  echo $bcount;?>] 
<a href="exportxls_b.php?exportmode=csv" class=a_btn>CSV</a> 
<a href="exportxls_b.php?exportmode=csvreadable" class=a_btn>CSV เฉพาะเนื้อหา</a> 
<a href="exportxls_b.php?exportmode=full" class=a_btn>ข้อมูลเต็ม</a>
<a href="exportxls_b.php?exportmode=brieve" class=a_btn>ข้อมูลย่อ</a>
<a href="exportxls_b.php?exportmode=shorted" class=a_btn>เฉพาะชื่อเรื่อง</a>
<a href="exportxls_b.php?exportmode=marc" class=a_btn>MARC</a><br>

<?php  echo getlang("ส่งออก Item ::l::Export Item.");?> [<?php  echo $icount;?>] <a href="exportxls_i.php?exportmode=full" class=a_btn>CSV</a><br />
<a href="catcard.php" class=a_btn><?php  echo getlang("พิมพ์บัตรรายการ::l::Print Catalog Card");?> [<?php  echo $icount;?>] </a><br />
<br /><B>

<A HREF="media_type.php" class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER></B> 
<?php 
		foot();   
	   ?>