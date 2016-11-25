<?php 
include("./inc/config.inc.php");
 include("./index.inc.php");
  stat_add("visithp_type","browsereservmat");
head();
		mn_web("browse-reservmat");  
		 // include ("./search.inc.header.php");
		include ("./webbox/searching.misc/search.inc.func.php");
$tbname="media_mid";
$s="select * from media_mid where status='reservmat' order by pid ";
pagesection(getlang("รายการหนังสือสำรอง::l::Reserve materials"));
$s=tmqp($s,"search-browse-reservmat.php?");
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
											$mrow=tmq("select * from index_db where mid='$row[pid]' ");
											$mrow=tmq_fetch_array($mrow);
											if ($mrow[ispublish]!="yes") { continue; }
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

<?php 
foot();
?>