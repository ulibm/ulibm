<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$loadtemplate=floor($loadtemplate);
tmq("delete from barcode_valmem");
if ($loadtemplate!=0) {
	$stp=tmq("select * from blockbarcode_tp where id='$loadtemplate' ",false);
	if (tnr($stp)==0) {
		html_dialog("error", "Cannot load template id $loadtemplate");;
	} else {
		//save old

		$s=tmq("select * from barcode_val where classid like '%blockbc%' ");
		$res=Array();
		while ($r=tfa($s)) {
			$res[$r[classid]]=$r[val];
		}
		$res=serialize($res);
		$res=addslashes($res);
		$now=time();
		tmq("delete from blockbarcode_tp where name='autosave' ");
		tmq("insert into blockbarcode_tp set name='autosave',dt='$now' ,data='$res',loginid='".$_SESSION["useradminid"]."' ");


		//load
		$r=tfa($stp);
		//$data=stripslashes($r[data]);
		$data=$r[data];
		$data=unserialize($data);
		//printr($r);
		//printr($data);
		html_dialog("Template Loaded", "Loaded template $r[name]");;
		@reset($data);
		while(list($k,$v)=@each($data)) {
		//echo "$k=$v<BR>";
			barcodeval_set($k,$v);
		}
		tmq("delete from barcode_valmem");
	}
}


$tbmn="width= 500  cellpadding=2 cellspacing=1 align=center bgcolor=888888";

?>
 <TABLE <?php echo $tbmn;?>>
<FORM METHOD=POST ACTION="bc_pdf.php" target=_blank>
<INPUT TYPE="hidden" name=save value=yes>
<TR  bgcolor=ffffff valign=top>
<TD colspan=2><?php  echo getlang("บาร์โค้ดที่จะพิมพ์::l::Barcodes"); ?><BR><?php 
$barcode_manage="BARCODE-blockbc-allbc";
include("../library.barcode/globalinc.php");
?></TD>
</TR>
<TR  bgcolor=ffffff valign=top>
<TD width=250><TEXTAREA NAME="allbc" ID="allbc" style="width:250;height: 400;"><?php echo barcodeval_get("BARCODE-blockbc-allbc");?></TEXTAREA></TD>
<TD>
<?php echo getlang("เพิ่มช่องว่าง จำนวน ::l::add blank barcode ");?> <INPUT TYPE="text" NAME="addblank" size=3 maxlength=2 value="<?php echo floor(barcodeval_get("BARCODE-blockbc-addblank"))?>"> <?php echo getlang("ช่อง::l::items");?><BR>
<div ID="BLOCKBARCODE_CHECKBOXLIST"><?php echo getlang("รูปแบบบาร์โค้ดที่ต้องการ::l::Barcode Format");?><BR>
<?php 
$ss=explode(",","plain=บาร์โค้ดเท่านั้น::l::Plain Barcode,plainlogo=บาร์โค้ดเปล่าและโลโก้::l::Plain Barcode & logo,ribbon=แบบแถบสี::l::Color Ribbon,standard=เลขหมู่และบาร์โค้ด::l::Call Number and Barcode,logobc=โลโก้และบาร์โค้ด::l::Logo and Barcode,titlebc=รายละเอียดและบาร์โค้ด::l::Detail and Barcode,calln=เลขเรียกเท่านั้น::l::CallNumber only,singlecolor=แบบอัพโหลดไฟล์พื้นหลัง::l::Upload BG Image,qrcode=QR Code");
while (list($k,$v)=each($ss)) {
	$v2=explode("=",$v);
	?>
	<FONT class=smaller><label><INPUT TYPE="checkbox" NAME="bctype[<?php  echo $v2[0];?>]" <?php  if (barcodeval_get("BARCODE-blockbc-bctype-$v2[0]")=="yes") { echo "checked";}?>> <?php echo getlang("$v2[1]");?></label> <A HREF="<?php  echo $dcrURL?>library.blockbarcode/cfg.<?php  echo $v2[0];?>.php" class="a_btn smaller2" rel="gb_page_fs[]"><?php echo getlang("ตัวเลือก::l::Settings");
	?></A><BR>
	<?php 
}	
?></div><A HREF="<?php  echo $dcrURL?>library.blockbarcode/genrunning.php" class="a_btn smaller2" rel="gb_page_fs[]" ID=BLOCKBARCODE_GENRUNNINGBTN><?php  echo getlang("สร้างบาร์โค้ดเรียงหมายเลข::l::Generate running barcode");?></A>
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
$color=barcodeval_get("BARCODE-blockbc-color");
 echo getlang("สีเพิ่มเติม::l::Color"); ?><?php 
form_quickedit("color",$color,"color");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2><?php 
$font=barcodeval_get("BARCODE-blockbc-font");
 echo getlang("ฟอนท์ที่ต้องการ::l::Font"); ?><?php 
form_quickedit("font",$font,"list:Tahoma,Browalia,Angsana,THSarabunNew,TH Baijam,TH Chakra Petch,TH Charmonman,TH K2D July8,TH Kodchasal,TH KoHo,TH Mali Grade6,TH Niramit AS,TH Srisakdi");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2><?php 
$font=barcodeval_get("BARCODE-blockbc-sizefac");
 echo getlang("ความละเอียด::l::Global Size"); ?><?php 
form_quickedit("sizefac",$font,"list:1,2,3,4,5");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=2 class=table_head>ค่าตัวแปรอื่น ๆ</TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
$margin=floor(barcodeval_get("BARCODE-blockbc-adddotline"));
 echo getlang("แสดงเส้นประ::l::Show dot line"); ?> </TD><TD colspan=1><?php 
form_quickedit("adddotline",barcodeval_get("BARCODE-blockbc-adddotline"),"yesno");
?></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
$margin=floor(barcodeval_get("BARCODE-blockbc-margin"));
 echo getlang("ระยะขอบ (ช่องไฟ)::l::Margin"); ?> </TD><TD colspan=1><?php 
form_quickedit("margin",$margin,"number");
?></TD>
</TR>
<!-- <TR bgcolor=ffffff>
<TD colspan=2><?php 
 echo getlang("อัตราส่วนกว้าง x สูง::l::Measure Width x Height"); ?> 
 <INPUT TYPE="text" NAME="setxdist" value="<?php  echo barcodeval_get("BARCODE-blockbc-setxdist");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="setydist" value="<?php  echo barcodeval_get("BARCODE-blockbc-setydist");?>" size=6></TD>
</TR>
<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขอบด้านบน::l::Top margins"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="settopmargin" value="<?php  echo barcodeval_get("BARCODE-blockbc-settopmargin");?>" size=6><?php 
?> </TD>
</TR>
 -->
<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("จำนวนช่องบาร์โค้ด คอลัมน์ x แถว::l::Cells columns x rows"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="setcols" value="<?php  echo barcodeval_get("BARCODE-blockbc-setcols");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="setrows" value="<?php  echo barcodeval_get("BARCODE-blockbc-setrows");?>" size=6></TD>
</TR>

<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขนาดกระดาษ กว้าง x สูง::l::Paper Size width x height"); ?> </TD><TD colspan=1>
 <INPUT TYPE="text" NAME="paperw" value="<?php  echo barcodeval_get("BARCODE-blockbc-paperw");?>" size=6><?php 
echo " x ";
?> <INPUT TYPE="text" NAME="paperh" value="<?php  echo barcodeval_get("BARCODE-blockbc-paperh");?>" size=6> <?php  echo getlang("มิลลิเมตร::l::Milimeter"); ?></TD>
</TR>

<TR bgcolor=ffffff>
<TD colspan=1><?php 
 echo getlang("ขอบกระดาษ::l::Margins"); ?> </TD>
<TD colspan=1 align=center><TABLE width=300 border=0>
<TR>
	<TD width=33%></TD>
	<TD width=33% align=center class=smaller2><?php  echo getlang("บน::l::top"); ?><BR>
 <INPUT TYPE="text" NAME="margintop" value="<?php  echo barcodeval_get("BARCODE-blockbc-margintop");?>" size=6 style='text-align:center;'></TD>
	<TD width=33%></TD>
</TR>
<TR>
	<TD width=33% align=center class=smaller2><?php  echo getlang("ซ้าย::l::left"); ?><BR>
 <INPUT TYPE="text" NAME="marginleft" value="<?php  echo barcodeval_get("BARCODE-blockbc-marginleft");?>" size=6 style='text-align:center;'></TD>
	<TD width=33% align=center ><IMG SRC="margin.png" WIDTH="70" HEIGHT="100" BORDER="0" ALT=""></TD>
	<TD width=33% align=center class=smaller2><?php  echo getlang("ขวา::l::right"); ?><BR>
 <INPUT TYPE="text" NAME="marginright" value="<?php  echo barcodeval_get("BARCODE-blockbc-marginright");?>" size=6 style='text-align:center;'></TD>
</TR>

<TR>
	<TD width=33%></TD>
	<TD width=33% align=center class=smaller2>
 <INPUT TYPE="text" NAME="marginbottom" value="<?php  echo barcodeval_get("BARCODE-blockbc-marginbottom");?>" size=6 style='text-align:center;'><BR><?php  echo getlang("ล่าง::l::bottom"); ?></TD>
	<TD width=33%></TD>
</TR>
</TABLE></TD>
</TR>


<TR bgcolor=ffffff>
<TD align=left colspan=2><INPUT TYPE="submit" name=submittype ID=BLOCKBARCODE_PRINTBTN  value="<?php  echo getlang("พิมพ์::l::Print"); ?>" style="width:250; background-color: #f2f8f9; font-weight: bold; border-width: 2px;"> <FONT class=smaller2 COLOR="#838383">blockbarcode v.3</FONT></TD>
</TR>
<TR bgcolor=ffffff>
<TD align=left colspan=2 ID=BLOCKBARCODE_TPTD><font class=smaller><INPUT name=submittype TYPE="submit" value="<?php  echo getlang("Save Template"); ?>" class=smaller> <?php  echo getlang("ชื่อ Template::l::Template name"); ?> <input type="text" name="templatename" class=smaller value="<?php  echo date("d-m-Y");?>"> </font><br>
<b class=smaller><?php  echo getlang("เรียกใช้ Template ที่เคยบันทึกไว้::l::Load saved template"); ?></b><br>
<?php 
$s=tmq("select * from blockbarcode_tp order by dt desc");
while ($r=tfa($s)) {
	?><a href="index.php?loadtemplate=<?php echo $r[id];?>" class="a_btn smaller"><?php  echo stripslashes($r[name]);?></a> &nbsp; <?php 
}
?><br>
<a href="mantp.php" class="smaller"><?php  echo getlang("จัดการ Template ที่เคยบันทึกไว้::l::Manages saved template"); ?></a>
</TD>
</TR>

</FORM>
</TABLE>
<?php 
foot();
?>