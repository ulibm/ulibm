<?php 
include("./inc/config.inc.php");
 include("./index.inc.php");
  stat_add("visithp_type","browsereservmat");
head();
		mn_web("browse-reservmat");
   // include ("./search.inc.header.php");
		include ("./webbox/searching.misc/search.inc.func.php");
		//$tbname="webpage_bibrating_sum";
$s="select * from webpage_bibrating_sum where 1 order by votescore desc ";
pagesection(getlang("หนังสือเรียงตามลำดับความนิยม::l::Materials by rating"));
$s=tmqp($s,"search-browse-rated.php?");
?>
<table width = "<?php echo $_TBWIDTH;?>" align = center border = "0" cellspacing = "1" cellpadding = "3">
<?php 

$mdtypedb=tmq_dump("media_type","code","name");
$shelvesdb=tmq_dump2("media_place","code","name,main");
$libsitedb=tmq_dump("library_site","code","name");

local_media_headtr();
?> 

<FORM METHOD=POST ACTION="savemarked.php" target=savemarked name="searchform">

                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($s))
                                        {
											$mrow=tmq("select mid from index_db where mid='$row[bibid]' and ispublish='yes' ");
											$mrow=tmq_fetch_array($mrow);
											search_inc_media($mrow);
                                        }
                                ?>
									
									<?php 
		local_media_headtr();
		
?>
			<tr><td colspan=5 width=100%><INPUT TYPE="submit" value="Save Marked Record" class=frmbtn style="width:200px"><iframe name=savemarked width=400  height=20 frameborder=0 scrolling=NO align=absmiddle src="savemarked.php"></iframe></td></tr>
			</FORM>
<?php 
				echo $_pagesplit_btn_var;	
			?>
    </table>

<?php 			?><center>
<br /><a href="./getfeed.php?feed=bibrating" class=feedbtn><img align=absmiddle src="./neoimg/feed-icon-14x14.png" border=0> <?php  echo getlang("Feed::l::Feed");?></a>
</center><?php 

foot();
?>