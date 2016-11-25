<?php 
	; 
		
        include ("../inc/config.inc.php");
        include ("./inc.local.php");
		head();

if ($mode=="") {
	$mode="detail";
}

		$sdbs=tmq("select * from library_modules where code='stat-cir-statordr_$db' ");
		if (tmq_num_rows($sdbs)==0) {
			die("library_modules where code='stat-cir-statordr_$db'");
		}
		$sdbs=tmq_fetch_array($sdbs);
		$sdb["checkout_member"][name]=getlang($sdbs[name]);
		$sdb["checkout_member"][headmode]="memberbarcode";
		$sdb["checkout_book"][name]=getlang($sdbs[name]);
		$sdb["checkout_book"][headmode]="mediaid";
		$sdb["ms_member"][name]=getlang($sdbs[name]);
		$sdb["ms_member"][headmode]="memberbarcode";
		$sdb["memberlogin_member"][name]=getlang($sdbs[name]);
		$sdb["memberlogin_member"][headmode]="memberbarcode";		
		$sdb["search_text"][name]=getlang($sdbs[name]);
		$sdb["searchnotfound_text"][name]=getlang($sdbs[name]);
		$sdb["ft_resid"][name]=getlang($sdbs[name]);
		$sdb["ft_resid"][headmode]="mediaid";		
		$sdb["sharemarc"][name]=getlang($sdbs[name]);
		$sdb["sharemarc"][headmode]="mediaid";				
		$sdb["used_book"][name]=getlang($sdbs[name]);
		$sdb["used_book"][headmode]="mediaid";		


		$_REQPERM=$sdbs[code];
		$tbl="statordr_$db";
        //mn_lib();
		//pagesection($sdb["checkout_member_libsite"][name],"stats");
		$tmpdsp=mn_lib();

		$tmpdsp=str_replace('[ROOMWORD]',$_ROOMWORD,$tmpdsp);
		$tmpdsp=str_replace('[FACULTYWORD]',$_FACULTYWORD,$tmpdsp);

		pagesection("".$tmpdsp,"stats");

		//autoclear
			 $autoclear=tmq("select id FROM `$tbl` order by id desc limit $_STATCENTER_MAXRECORD,1 ",false);
			 $autoclear=tmq_fetch_array($autoclear);
			 $autoclear=floor($autoclear[id]);
			 if ($autoclear!=0) {
			 		tmq("delete from $tbl where id<$autoclear ",false);
			 }		
			 
		if ($yrtoclearstat!="" && library_gotpermission("stat-candelete")) {
			 tmq("delete from $tbl where yea='$yrtoclearstat' ");
		}
?>
<TABLE width=620 align=center cellspacing=0 class=table_border>
<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("กำลังดูข้อมูล::l::Displaying stat.");
?></TD>
<TD class=table_td><?php 
echo getlang($sdb[$db][name]);
?></TD>
</TR>

</TABLE><BR>
<?php 
$tmp[detail]="1";
$tmp[table]="2";
$addquery="";

$tabstr=$tmp[$mode]."::b::".getlang("สถิติละเอียด::l::Detailed style").",thestatordr.php?db=$db&mode=detail&$addquery";

html_xptab($tabstr);

$limitdatee+=(60*60*24);

if ($mode=="detail") {
	include("thestatordr.detail.php");
}


if (library_gotpermission("stat-candelete")) {
	 ?><br />
<br />

	 <table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>
<form action="<?php  echo $PHP_SELF?>" method="post" onsubmit="return confirm('Please Confirm');">
<input type="hidden" name="db" value="<?php  echo $db;?>" />
<tr><td class=table_head><?php  echo getlang("เคลียร์สถิติ::l::Clear Stat.");?></td>
<td class=table_td>
<select name="yrtoclearstat"><?php 
for($y=$_MSTARTY;$y<=$_MENDY;$y++) {
	echo "<option value='".($y-543)."'>$y";
}
?></select> <input type="submit" value="Clear"><?php 

?></td>
</tr>
</form>
</table>
	 <?php 
}
                foot();
?>