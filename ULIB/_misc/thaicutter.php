<?php 
include("../inc/config.inc.php");
html_start();
//printr($_GET);
$az=explode(',',$_STR_A_Zth);
sort($az);
$azalphab=getval('global',"STR_A_Zthalpha");
$azalphab=explode(',',$azalphab);
sort($azalphab);
//echo "[$recparentval]";

$recparentval=dspmarc($recparentval);
$recparentval=urldecode($recparentval);
$recparentval=trim($recparentval);
$recparentval=mb_strtolower($recparentval);
//$recparentval=str_remspecialsign($recparentval);
//echo "[$recparentval]";
$recparentval=str_replace(' ','',$recparentval);
//printr($az);
if ($recparentval!="" && mb_strlen($recparentval)>=3) {
	$recparentval2="";
	for ($i=0;$i<=mb_strlen($recparentval);$i++) {
		 //echo " ".mb_substr($recparentval,$i,1);
		if (in_array(mb_substr($recparentval,$i,1),$az)) {
			$recparentval2.=mb_substr($recparentval,$i,1);
		}
	}
	//echo "[$recparentval2]";
} 
if ($recparentval2=="" || strlen($recparentval2)<3) {
	html_dialog("","กรุณากรอกข้อความยาวกว่า 3 ตัวอักษร<BR>เลขผู้แต่งภาษาไทยไม่นับรวมอักขระภาษาอังกฤษ::l::Please enter 3 character or more<BR>A-Z characters excluded");
	die;
}
	//echo "[$recparentval2]";
$thalpha="";
for ($i=0;$i<=strlen($recparentval2);$i++) {
	if (in_array(mb_substr($recparentval2,$i,1),$azalphab)) {
		$thalpha.=mb_substr($recparentval2,$i,1);
	}
}

	//echo "[$thalpha]";

if ($thalpha=="") {
	html_dialog("","กรุณากรอกชื่อผู้แต่งด้วย::l::Please enter Author name");
	die;
}

$a1stdigit=mb_substr($thalpha,0,1);
$remove1stchar=explode($a1stdigit,$recparentval2,2);;
$remove1stchar=implode('',$remove1stchar);

$word=$remove1stchar;
//$word="เพลียเบียร์ โปะ กกกกก ggเเasdfและก็ asdf at asdflkj $word<br>";
//echo "[$word]<br>";
$s=tmq("select * from keyhelp_thauthname order by ordr");
while ($r=tmq_fetch_array($s)) {
	//echo "-[อ$r[search1]--$r[replace1]]<BR>";
	//$r[search1]=str_replace("([","/[^",$r[search1]);
	//$r[search1]=str_replace("])","_]/u",$r[search1]);
	//$r[search1]=str_replace("([a-zA-Z0-9ก-ฮ๐-๙])",'/([^\w\sก-๙]|_)/u',$r[search1]);
	//echo "[$r[search1]-$r[replace1]]=$word<br>";
	//$r[replace1]="${1}".$r[replace1];
	//$word=preg_replace($r[search1], $r[replace1].'--$1--${1}', urlencode($word)); 
	$r[replace1]=str_replace("\\","",$r[replace1]);
	if ($r[replace1]=="") { $r[replace1]='$1'; }
//$find = 'ก*ก ';
//$find = preg_quote($find, '/');  // "/" is the delimiter used below
$find=$r[search1];//"แ([a-zA-Z0-9ก-ฮ๐-๙])ะ";
//echo $find."<br>";
//$find = str_replace('\*', '.*'); // preg_quote escaped that, unescape and convert
//echo "find=[$find] relace=[$r[replace1]] = ";
$word= preg_replace('/'.$find.'/u', $r[replace1], $word);
//echo $word."<br>";
//echo array_flip(get_defined_constants(true)['pcre'])[preg_last_error()];
	//print_r($word);
	
	//echo print_r($word);
	//echo "[$r[search1]-$r[replace1]]=$word<br>";
}
//echo "[$word]";
//echo "[$remove1stchar/$a1stdigit/$word]";


/*
for ($i=10;$i<=255;$i++) {
	echo chr($i).',';
}*/
?><BR><TABLE width=500 class=table_border align=center>
<FORM METHOD=POST ACTION="">
	<TR valign=middle>
	<TD  class=table_head width=180><?php  echo getlang("เลขผู้แต่ง::l::Thai Author No.");?></TD>
	<TD  class=table_td align=center><input style="font-size: 26; height: 40; text-align: center; width: 150" onfocus="this.select();"  onmouseup="this.select()" onclick="this.select(); " value="<?php  echo $a1stdigit.substr($word,0,2);?>"></TD>
	<TD width=50><nobr>
   <B onclick="localfillthis_dc('<?php  echo $a1stdigit.substr($word,0,2);?>');" ><img src="../neoimg/uptod.png" border=0 width=18 height=18></B>
   <B style="display:inline;" onclick="localfillthis_lc('<?php  echo $a1stdigit.substr($word,0,2);?>');" ><img src="../neoimg/uptol.png" border=0 width=18 height=18></B></nobr><BR>
<nobr>	<B style="display:inline;padding-top:3;" onclick="localfillthis_nlm('<?php  echo $a1stdigit.substr($word,0,2);?>');" ><img src="../neoimg/upton.png" border=0 width=18 height=18></B>
	<B style="display:inline;padding-top:3;" onclick="localfillthis_localc('<?php  echo $a1stdigit.substr($word,0,2);?>');" ><img src="../neoimg/upto9.png" border=0 width=18 height=18></B></nobr>
	</TD></TR>
<TR valign=middle>
	<TD  class=table_head><?php  echo getlang("กรณีเป็นอักษรย่อ::l::Abrief. No.");?></TD>
	<TD  class=table_td align=center><input style="font-size: 26; height: 40; text-align: center; width: 150" onmouseup="this.select()" onfocus="this.select();" onclick="this.select();" value="<?php  echo $a1stdigit."1".substr($word,0,1);?>"></TD>
	<TD><B onclick="localfillthis_dc('<?php  echo $a1stdigit."1".substr($word,0,1);?>');" ><img src="../neoimg/uptod.png" border=0 width=18 height=18></B>
   <B style="display:inline;" onclick="localfillthis_lc('<?php  echo $a1stdigit."1".substr($word,0,1);?>');" ><img src="../neoimg/uptol.png" border=0 width=18 height=18><BR>
	<B style="display:inline;padding-top:3;" onclick="localfillthis_localc('<?php  echo $a1stdigit."1".substr($word,0,1);?>');" ><img src="../neoimg/upton.png" border=0 width=18 height=18></B>
	<B style="display:inline;padding-top:3;" onclick="localfillthis_nlm('<?php  echo $a1stdigit."1".substr($word,0,1);?>');" ><img src="../neoimg/upto9.png" border=0 width=18 height=18></B>
	</TD>
</TR>
</FORM>
</TABLE><SCRIPT LANGUAGE="JavaScript">
<!--
function localfillthis_dc(wh) {
	parent.addtodcnum(wh);
}
function localfillthis_lc(wh) {
	parent.addtolcnum(wh);
}
function localfillthis_localc(wh) {
	parent.addtolocalcnum(wh);
}
function localfillthis_nlm(wh) {
	parent.addtonlmnum(wh);
}
//-->
</SCRIPT>
<center><a href="<?php  echo $dcrURL; ?>_misc/thaicutter.man.php" class="smaller2 a_btn"><?php  echo getlang("แก้ไข::l::Edit");?></a></center>