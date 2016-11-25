<?php 
	; 
	
		
        include ("../inc/config.inc.php");
        
        if ($logininfo=="yes") {
        html_start();
        ?><table align=center cellpadding=0 cellspacing=0 border=0 width=<?php echo $_TBWIDTH-200;?>>
        <tr><td><BR><BR><BR>
        <blockquote>
         <b><?php echo getlang("URL หลักของโปรแกรม (โฮมเพจ)::l::Main URL (Homepage)");?></b><br>
         <blockquote>
          <b><?php echo $dcrURL;;?></b><br>
          
         </blockquote>
        </blockquote>
        <BR>
        
         <blockquote>
         <b><?php echo getlang("URL เจ้าหน้าที่ห้องสมุด (บรรณารักษ์)::l::Librarian's URL (officer)");?></b><BR>
         <img src="<?php echo $dcrURL;?>neoimg/formlogin_library.png" width=400><BR>
         <blockquote>
          <b><?php echo $dcrURL;;?>lib</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login ID : <?php echo $useradminid; ?><BR>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password : ______________________
         </blockquote>
        </blockquote>
        
        <BR>
        <BR>
        <BR>
        
         <blockquote>
         <b><?php echo getlang("URL เจ้าหน้าที่สูงสุด (Root)::l::Administrator's URL (root)");?></b><br>
         <img src="<?php echo $dcrURL;?>neoimg/formlogin_root.png" width=400><BR>
         <blockquote>
          <b><?php echo $dcrURL;;?>root</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login ID : ______________________<BR>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password : ______________________
         </blockquote>
        </blockquote>
        
        
        </td></tr></table><BR><BR><BR><?php
        die;
        
        }
		head();
		$_REQPERM="quicklink";
        mn_lib();
pagesection("ลิงค์อื่น ๆ ::l::More links");
?><BR><BR><TABLE width=750 align=center class=table_border>
<?php  
$ar[19][name]=barcodeval_get("oss-o-name");
$ar[19][url]="$dcrURL"."OSS/";
$ar[1][name]=barcodeval_get("answerpoint_name");
$ar[1][url]="$dcrURL"."answerpoint/";
$ar[2][name]=getlang(barcodeval_get("lostandfound_name"));
$ar[2][url]="$dcrURL"."lostandfound/";
$ar[3][name]="สมัครสมาชิกออนไลน์::l::Online Registration";
$ar[3][url]="$dcrURL"."memregist.form.php";
$ar[5][name]="รายการหนังสือสำรอง::l::Reserved Books";
$ar[5][url]="$dcrURL"."search-browse-reservmat.php";
$ar[14][name]="รายการหนังสือตามชื่อผู้แต่ง::l::Matterials Sorted by Author";
$ar[14][url]="$dcrURL"."search-browse-author.php";
$ar[15][name]="รายการหนังสือตามการให้คะแนน::l::Matterials Sorted by Bib. Rating";
$ar[15][url]="$dcrURL"."search-browse-rated.php";
$ar[16][name]="รายการหัวเรื่อง::l::Subject List";
$ar[16][url]="$dcrURL"."search-browse-subject.php";
$ar[17][name]="รายการหนังสือตามชื่อเรื่อง::l::Matterials Sorted by Title";
$ar[17][url]="$dcrURL"."search-browse-title.php";
$ar[6][name]="ติดต่อเจ้าหน้าที่::l::Contact librarian";
$ar[6][url]="$dcrURL"."contact.php";
$ar[7][name]="บริการให้จองห้อง::l::Request Room";
$ar[7][url]="$dcrURL"."requestroom1.php";
$ar[8][name]="วันปิดทำการ::l::Close Service";
$ar[8][url]="$dcrURL"."closeservice.php";
$ar[9][name]="ประเภทวัสดุสารสนเทศ::l::Resource Type";
$ar[9][url]="$dcrURL"."resource_type.php";
$ar[10][name]="สถานที่จัดเก็บ::l::Places&Shelves";
$ar[10][url]="$dcrURL"."itemplaces.php";
$ar[11][name]="เกี่ยวกับ USOUNDEX::l::About USOUNDEX";
$ar[11][url]="$dcrURL"."usoundex.php";
$ar[12][name]="ระบบทางเข้า::l::Entrance gate";
$ar[12][url]="$dcrURL"."ms/";
$ar[18][name]="ระบบตรวจสอบจบ::l::Graduating check";
$ar[18][url]="$dcrURL"."library.membercheck/";
$ar[20][name]="กำหนด Collection (สืบค้น - แบบเว็บเพจ)::l::Select Collection (Searching - Webpage)";
$ar[20][url]="$dcrURL"."collections.php";
$ar[21][name]="เกี่ยวกับ Collection (สืบค้น - แบบเว็บเพจ)::l::About Collection (Searching - Webpage)";
$ar[21][url]="$dcrURL"."collections-about.php";
$ar[22][name]="กำหนด Collection (สืบค้น - เว็บไซต์แบบกล่อง)::l::Select Collection (Searching - Webbox)";
$ar[22][url]="$dcrURL"."webbox/collections.php";
$ar[23][name]="เกี่ยวกับ Collection (สืบค้น - เว็บไซต์แบบหล่อง)::l::About Collection (Searching - Webbox)";
$ar[23][url]="$dcrURL"."webbox/collections-about.php";
$ar[24][name]="แบบฟอร์มสืบค้นขั้นสูง (แบบเว็บเพจ)::l::Advance Search (Webpage)";
$ar[24][url]="$dcrURL"."index.php?forcehpmode=advsearch";
$ar[25][name]="แบบฟอร์มสืบค้นง (แบบเว็บเพจ)::l::Search Form (Webpage)";
$ar[25][url]="$dcrURL"."index.php?forcehpmode=search";


$ar[4][name]="ฐานข้อมูลออนไลน์::l::Free Databases";
$ar[4][url]="$dcrURL"."freedb.php";




@reset($ar);
while (list($k,$v)=each($ar)) {
?>
<TR>
	<TD class=table_td><A HREF="<?php  echo $v[url]?>" target=_blank><?php  echo getlang($v[name]);?></A></TD>
	<TD  class=table_td><FONT class=smaller><?php  echo $v[url]?></FONT></TD>
</TR>
<?php 
}	
?>
</TABLE>
<BR><?php 
pagesection("RSS");
?><TABLE width=<?php  echo $_TBWIDTH?> align=center class=table_border>
<?php  
unset($ar);
$ar[1][name]=getlang("หนังสือแนะนำ::l::Suggested materials") ." (Showcase)";
$ar[1][url]="$dcrURL"."getfeed.php?feed=showcase";
$ar[2][name]=getlang("กระทู้ล่าสุดจากเว็บบอร์ด::l::Newest webboard") ."";
$ar[2][url]="$dcrURL"."getfeed.php?feed=webboardnewest";
$ar[3][name]=getlang("ทรัพยากรที่ได้รับ rating สูงสุด::l::Materials by rating") ."";
$ar[3][url]="$dcrURL"."getfeed.php?feed=bibrating";
$ar[4][name]=getlang("บรรณนิทัศน์::l::Reviewed by librarian") ."";
$ar[4][url]="$dcrURL"."getfeed.php?feed=bibreview";
$ar[4][name]=getlang("ทรัพยากรที่ได้รับคอมเมนท์ล่าสุด::l::Commented materials") ."";
$ar[4][url]="$dcrURL"."getfeed.php?feed=bibcomment";

$s=tmq("select * from webboard_boardcate order by ordr,name");
while ($r=tmq_fetch_array($s)) {
	$count=count($ar)+1;
	$r[name]=getlang($r[name]);;
	$ar[$count][name]=getlang("เว็บบอร์ด - $r[name] ::l::Webboard -$r[name]");
	$ar[$count][url]="$dcrURL"."getfeed.php?feed=webboard&boardcate=$r[id]";
}
$s=tmq("select * from collections order by name");
while ($r=tmq_fetch_array($s)) {
	$count=count($ar)+1;
	$r[name]=getlang($r[name]);;
	$ar[$count][name]=getlang("ล่าสุดจากคอลเล็กชั่น - $r[name] ::l::Newest from collection -$r[name]");
	$ar[$count][url]="$dcrURL"."getfeed.php?feed=collection&collectionid=$r[classid]";
}


@reset($ar);
while (list($k,$v)=each($ar)) {
?>
<TR>
	<TD class=table_td><A HREF="<?php  echo $v[url]?>" target=_blank><?php  echo getlang($v[name]);?></A></TD>
	<TD  class=table_td><FONT class=smaller><?php  echo $v[url]?></FONT></TD>
</TR>
<?php 
}	
?>
</TABLE>
<BR>
<CENTER>

<A HREF="../library/mainadmin.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A>
<A target=_blank HREF="<?php echo $PHP_SELF;?>?logininfo=yes" class="a_btn smaller2"><?php  echo getlang("URL การล็อกอิน::l::Librarian Login URL");?></A>


</CENTER><?php 
				foot();
?>