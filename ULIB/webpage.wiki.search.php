<?php 
	; 
		
    include ("inc/config.inc.php");
    include ("./webpage.wiki.inc.php");
	head();
	mn_web("webpage");
		stat_add("visithp_type","wiki");
	$ismanager=library_gotpermission("webpage-postarticle");


?>
<TABLE width="<?php  echo $_TBWIDTH?>" align=center cellpadding=0 cellspacing=0 border=0>
<TR valign=top>
	<TD width=200><?php  include("webpage.menu.php");?></TD>
	<TD align=right>
	<?php 

pagesection(getlang("แสดงบทความทั้งหมด/ค้นหา::l::All articles/ Search"),"article");

?><TABLE width=100% cellpadding=3 cellspacing=0 border=0>
<TR>
	<TD><?php 
	$tbname="webpage_wiki";

$dsp[2][text]="ชื่อเรื่อง::l::Topics";
$dsp[2][filter]="module:local_inc_wikirow";
$dsp[2][field]="title";
$dsp[2][width]="30%";

$o[tablewidth]="100%";
		?><TABLE width=100%><FORM METHOD=POST ACTION="webpage.wiki.search.php">
			<TR><TD align=right><INPUT TYPE="text" NAME="searchtext" value="<?php  echo $searchtext;?>"> <INPUT TYPE="submit" value="Search"><?php 
			if ($searchtext!="") {
				echo "<BR><A HREF=webpage.wiki.search.php class=smaller2>".getlang("แสดงทั้งหมด::l::Show all")."</A> <B class=smaller2>:</B> ";
				echo "<A HREF='webpage.wiki.php?title=".urlencode($searchtext)."' class=smaller2>".getlang("ไปยัง::l::Go to ")." '$searchtext'</A> ";
			}
			?> </TD></TR>
		</FORM></TABLE><?php 
$limit="";
if ($searchtext!="") {
	$searchtext2=addslashes($searchtext);
	$limit.=" and (title like '%$searchtext2%' or body like '%$searchtext2%'  ) ";
}
if ($ismanager!=true) {
	$limit.=" and status not like '%,draft,%' ";
}

fixform_tablelister($tbname," hasdata='yes' $limit ",$dsp,"no","no","no","searchtext=$searchtext",$c," dt desc ",$o);

?></TD>
		</TR>
		</TABLE>


</TD>
</TR>
</TABLE>
<?php 
				foot();
?>