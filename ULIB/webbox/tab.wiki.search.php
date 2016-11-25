<?php 
	; 
		
stat_add("visithp_type","wiki");
$ismanager=library_gotpermission("webpage-postarticle");
include($dcrs."webbox/tab.wiki.inc.php");



//pagesection(getlang("แสดงบทความทั้งหมด/ค้นหา::l::All articles/ Search"),"article");

$tbname="webpage_wiki";

$dsp[2][text]="ชื่อเรื่อง::l::Topics";
$dsp[2][filter]="module:local_inc_wikirow";
$dsp[2][field]="title";
$dsp[2][width]="30%";

		?><FORM METHOD=POST ACTION="<?php  echo $dcrURL?>index.php">
		<TABLE width=100%>
			<TR><TD align=right><INPUT TYPE="text" NAME="searchtext" value="<?php  echo $searchtext;?>"> <INPUT TYPE="submit" value="Search"><?php 
			if ($searchtext!="") {
				echo "<BR><A HREF='index.php?webboxloadwikisearch=yes' class=smaller2>".getlang("แสดงทั้งหมด::l::Show all")."</A> <B class=smaller2>:</B> ";
				echo "<A HREF='index.php?webboxload=yes&title=".urlencode($searchtext)."' class=smaller2>".getlang("ไปยัง::l::Go to ")." '$searchtext'</A> ";
			}
			?> </TD></TR>
		</TABLE>
		<input type="hidden" name="webboxloadwikisearch" value="yes">
		</FORM><?php 
$limit="";
if ($searchtext!="") {
	$searchtext2=addslashes($searchtext);
	$limit.=" and (title like '%$searchtext2%' or body like '%$searchtext2%'  ) ";
}
if ($ismanager!=true) {
	$limit.=" and status not like '%,draft,%' ";
}
$_TBWIDTH="100%";
fixform_tablelister($tbname," hasdata='yes' $limit ",$dsp,"no","no","no","webboxloadwikisearch=yes&searchtext=$searchtext",$c," dt desc ",$o);

?>