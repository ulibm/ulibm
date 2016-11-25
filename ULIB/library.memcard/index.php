<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

tmq("delete from barcode_valmem");

$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";

?>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="bc_pdf.php" target=_blank>
<INPUT TYPE="hidden" name=save value=yes>
<TR  bgcolor=ffffff valign=top>
<TD colspan=2><?php  echo getlang("บาร์โค้ดที่จะพิมพ์::l::Barcodes"); ?><BR><?php 
$barcode_manage="BARCODE-memcardbc-allbc";
include("../library.barcode/globalinc.php");
?></TD>
</TR>
<TR  bgcolor=ffffff valign=top>
<TD width=250><TEXTAREA NAME="allbc" ID="allbc" style="width:250;height: 400;"><?php echo barcodeval_get("BARCODE-memcardbc-allbc");?></TEXTAREA></TD>
<TD>
<?php echo getlang("เพิ่มช่องว่าง จำนวน ::l::add blank barcode ");?> <INPUT TYPE="text" NAME="addblank" size=3 maxlength=2 value="<?php echo floor(barcodeval_get("BARCODE-memcardbc-addblank"))?>"> <?php echo getlang("ช่อง::l::items");?><BR>
<div ID="BLOCKBARCODE_CHECKBOXLIST"><?php echo getlang("รูปแบบบาร์โค้ดที่ต้องการ::l::Barcode Format");?><BR>
<?php 
$s=tmq("select * from memcard order by ordr,name");
while ($r=tfa($s)) { 
	?>
	<FONT class=smaller><label><INPUT TYPE="checkbox" NAME="bctype[<?php  echo $r[code];?>]" <?php  if (barcodeval_get("BARCODE-memcardbc-bctype-$r[code]")=="yes") { echo "checked";}?>> <?php echo getlang("$r[name]") ;?></label>
</A><BR>
	<?php 
}	
?></div>
<A HREF="<?php  echo $dcrURL?>library.memcard/getmembc.php" class="a_btn smaller2" rel="gb_page_fs[]" ID=BLOCKBARCODE_GENRUNNINGBTN><?php  echo getlang("ดึงบาร์โค้ดสมาชิก::l::Retrieve member barcode");?></A>
<A HREF="<?php  echo $dcrURL?>library.memcard/mantp.php" class="a_btn smaller2" xxxrel="gb_page_fs[]" ID=BLOCKBARCODE_GENRUNNINGBTN><?php  echo getlang("จัดการเทมเพลท::l::Manage Template");?></A>
<BR><HR noshade>
<div id="dspcount" style="font-size: 50;color:#8F330C"></div>
<script language="JavaScript">
<!--
function updatecount() {
	tmp=getobj("allbc");
	tmpdsp=getobj("dspcount");
	count=tmp.value.split("\n");
	//alert(count);
	nobc=-1;
	hasbc=-1
	allbc=-1
	for (i in count) {
		//alert(count[i]);
		if (count[i]=="" || count[i]==" " || count[i]=="\n") {
			nobc=nobc+1;
		} else {
			hasbc=hasbc+1;
		}
		allbc=allbc+1;
	}
	tmpdsp.innerHTML=hasbc+"/"+allbc 
}
	setInterval("updatecount()",500);
	//updatecount();
//-->
</script>
</FONT>
</TD>
</TR>




<TR bgcolor=ffffff>
<TD colspan=2><?php 
$font=barcodeval_get("BARCODE-memcardbc-font");
 echo getlang("ฟอนท์ที่ต้องการ::l::Font"); ?><?php 
form_quickedit("font",$font,"list:Tahoma,Browalia,Angsana,THSarabunNew,TH Baijam,TH Chakra Petch,TH Charmonman,TH K2D July8,TH Kodchasal,TH KoHo,TH Mali Grade6,TH Niramit AS,TH Srisakdi");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2><?php 
$font=barcodeval_get("BARCODE-memcardbc-sizefac");
 echo getlang("ความละเอียด::l::Global Size"); ?><?php 
form_quickedit("sizefac",$font,"list:1,2,3,4,5");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2 class=table_head>ค่าตัวแปรอื่น ๆ</TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
$margin=floor(barcodeval_get("BARCODE-memcardbc-adddotline"));
 echo getlang("แสดงเส้นประ::l::Show dot line"); ?> </TD><TD colspan=1><?php 
form_quickedit("adddotline",barcodeval_get("BARCODE-memcardbc-adddotline"),"yesno");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
$margin=floor(barcodeval_get("BARCODE-memcardbc-margin"));
 echo getlang("ระยะขอบ (ช่องไฟ)::l::Margin"); ?> </TD><TD colspan=1><?php 
form_quickedit("margin",$margin,"number");
?></TD>
</TR>
<!-- <TR bgcolor=ffffff>
<TD colspan=2><?php 
 echo getlang("อัตราส่วนกว้าง x สูง::l::Measure Width x Height"); ?> 
 <INPUT TYPE="text" NAME="setxdist" value="<?php  echo barcodeval_get("BARCODE-memcardbc-setxdist");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="setydist" value="<?php  echo barcodeval_get("BARCODE-memcardbc-setydist");?>" size=6></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขอบด้านบน::l::Top margins"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="settopmargin" value="<?php  echo barcodeval_get("BARCODE-memcardbc-settopmargin");?>" size=6><?php 
?> </TD>
</TR>
 -->
<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("จำนวนช่องบาร์โค้ด คอลัมน์ x แถว::l::Cells columns x rows"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="setcols" value="<?php  echo barcodeval_get("BARCODE-memcardbc-setcols");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="setrows" value="<?php  echo barcodeval_get("BARCODE-memcardbc-setrows");?>" size=6></TD>
</TR>

<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขนาดกระดาษ กว้าง x สูง::l::Paper Size width x height"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="paperw" value="<?php  echo barcodeval_get("BARCODE-memcardbc-paperw");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="paperh" value="<?php  echo barcodeval_get("BARCODE-memcardbc-paperh");?>" size=6> <?php  echo getlang("มิลลิเมตร::l::Milimeter"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขอบกระดาษ::l::Margins"); ?> </TD>
<TD colspan=1 align=center><TABLE width=300 border=0>
<TR>
	<TD width=33%></TD>
	<TD width=33% align=center class=smaller2><?php  echo getlang("บน::l::top"); ?><BR>
 <INPUT TYPE="text" NAME="margintop" value="<?php  echo barcodeval_get("BARCODE-memcardbc-margintop");?>" size=6 style='text-align:center;'></TD>
	<TD width=33%></TD>
</TR>
<TR>
	<TD width=33% align=center class=smaller2><?php  echo getlang("ซ้าย::l::left"); ?><BR>
 <INPUT TYPE="text" NAME="marginleft" value="<?php  echo barcodeval_get("BARCODE-memcardbc-marginleft");?>" size=6 style='text-align:center;'></TD>
	<TD width=33% align=center ><IMG SRC="margin.png" WIDTH="70" HEIGHT="100" BORDER="0" ALT=""></TD>
	<TD width=33% align=center class=smaller2><?php  echo getlang("ขวา::l::right"); ?><BR>
 <INPUT TYPE="text" NAME="marginright" value="<?php  echo barcodeval_get("BARCODE-memcardbc-marginright");?>" size=6 style='text-align:center;'></TD>
</TR>

<TR>
	<TD width=33%></TD>
	<TD width=33% align=center class=smaller2>
 <INPUT TYPE="text" NAME="marginbottom" value="<?php  echo barcodeval_get("BARCODE-memcardbc-marginbottom");?>" size=6 style='text-align:center;'><BR><?php  echo getlang("ล่าง::l::bottom"); ?></TD>
	<TD width=33%></TD>
</TR>
</TABLE></TD>
</TR>


<TR bgcolor=ffffff>
<TD align=left colspan=2><INPUT TYPE="submit" name=submittype ID=BLOCKBARCODE_PRINTBTN  value="<?php  echo getlang("พิมพ์::l::Print"); ?>" style="width:250; background-color: #f2f8f9; font-weight: bold; border-width: 2px;"></TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>