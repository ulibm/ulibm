<?php 

include("./cfg.inc.php");
include("./_localfunc.php");
               
     head();

	?>
	
	
	<?php 
	$ismanager=loginchk_lib("check");
	 $kw=trim($kw);

	$s=tmq("select * from  webboard_boardcate where isshowtouser='yes' ");
	$selectsql="select * from webboard_posts where nestedid=0 and  (0 or ";
	while ($r=tmq_fetch_array($s)) {
		$selectsql.=" boardid='$r[id]' or";
	}
	$selectsql=trim($selectsql,"or");
	$selectsql.=" )";

 echo "<BR><TABLE width=780 align=center>
<TR>
	<TD><B style=\"font-size: 22px;\">".getlang(barcodeval_get("webboard-boardname"))."</B></TD>
</TR>
</TABLE>";

pathgen("search");


$now=time();

if ($kw=="") {
	$kw=getlang("ใส่คำค้นที่นี่::l::Enter keyword here");
}
?>
<TABLE cellpadding=0 cellspacing=0 align=center width=780 >
<FORM METHOD=POST ACTION="search.php">
	<TR>
	<TD align=right> <?php  echo getlang("ค้นหาใน::l::Searching in");?> <?php  echo getlang(barcodeval_get("webboard-boardname"));?> <INPUT TYPE="text" NAME="kw" value='<?php  echo $kw;?>' 
	onfocus="if (this.value=='<?php  echo $kw;?>') { this.value='';}"
	onblur="if (this.value=='') { this.value='<?php  echo $kw;?>';}"
	> <INPUT TYPE="submit" value=" <?php  echo getlang("ค้นหา::l::Search");;?> "></TD>
</TR>
</FORM>
</TABLE>
<TABLE cellpadding=3 cellspacing=1 bgcolor=black align=center width=780 class=table_border>
<?php 
$suse=$selectsql;
if ($ismanager!=true) {
	$suse.= " and ishide<>'yes' ";
}
$suse.= " and ( topic like '%$kw%' or text like '%$kw%'  )";

$suse.= " and ispin<>'yes' order by lastactive asc ";//desc
//echo $suse;


$suse=tmqp($suse,"search.php?ID=$ID&kw=$kw","skip");
echo $_pagesplit_btn_var;

?>
<TR bgcolor=eeeeee>
	<TD width=100  class=table_head><nobr><B><?php  echo getlang("วันที่::l::Date");?></B></TD>
	<TD width=50%  class=table_head><B><?php  echo getlang("คำถามล่าสุด::l::Last update");?></B></TD>
	<TD width=7%  class=table_head><B><?php  echo getlang("ตอบ::l::Reply");?></B></TD>
	<TD width=23%  class=table_head><B><?php  echo getlang("ผู้ถาม::l::Poster");?></B></TD>
	<TD width=23% class=table_head><B><?php  echo getlang("หมวด::l::Category");?></B></TD>
</TR>
<?php 
$row_per_page=getval("pagesplit","pagelength");

$s=$selectsql;
if ($ismanager!=true) {
	$s.= " and ishide<>'yes' ";
}

if ($ismanager!=true) {
	$s.= " and ishide<>'yes' ";
}
$s.= " and ispin='yes' order by lastactive desc ";
//echo $s;
$s=tmq($s);
while ($r=tmq_fetch_array($s)) {
	viewtopicrow($r,"search");
}	

html_rows0_str($suse,getlang("ไม่พบข้อความที่ต้องการ::l::Keyword not found"),6);
while ($r=tmq_fetch_array($suse)) {
	viewtopicrow($r,'search');
}	
echo $_pagesplit_btn_var;
?>
</TABLE>
<?php 

pathgen("search");
include("./inc.webboardjump.php");

foot();

?>