<a href="logout.php" style="color:darkred;" data-ajax="false">Logout</a><?php 
$_TBWIDTH="100%";
member_showlonginfo($_memid);
if ( barcodeval_get("brlane-isenable") == "yes") {
	echo "<center><A HREF='html.brlane.php'  target='$inf[target]' data-ajax=\"false\"  data-role=\"button\" style='width: 300px;'>".getlang(barcodeval_get("brlane-linktext"))."</a></center>";
	$tabstr.="::".getlang(barcodeval_get("brlane-linktext")).",mainadmin.php?mempagemode=brlane";
}
//พ
member_showhold($_memid);
member_showrequest($_memid);
member_showrequestlist($_memid);
member_showfine($_memid);
?>