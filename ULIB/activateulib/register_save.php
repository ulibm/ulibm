<?php  //พ
	; 
		
	include ("../inc/config.inc.php");
	head();
	mn_root("activateulib");
?><BR><?php 
	pagesection(getlang("ULIBM - Modify Information"),"login");
	if ($issave!="yes") {
		die;
	}
	$orgname_thai=addslashes(trim(str_remspecialsign($orgname_thai)));
	$orgname_eng=addslashes(trim(str_remspecialsign($orgname_eng)));
	$address=addslashes(trim($address));
	$contact=addslashes(trim($contact));
	$refcode=addslashes(trim(str_remspecialsign($refcode)));
	if (strlen($orgname_thai)<=5) {
		html_dialog("","Please enter organization name (Thai)");
		die;
	}
	if (strlen($orgname_eng)<=5) {
		html_dialog("","Please enter organization name (English)");
		die;
	}
	if (strlen($address)<=5) {
		html_dialog("","Please enter address");
		die;
	}
	if (strlen($contact)<=5) {
		html_dialog("","Please contact information");
		die;
	}

	barcodeval_set("activateulib-refcode",$refcode);
	barcodeval_set("activateulib-alwayson",$alwayson);
	barcodeval_set("activateulib-orgname-thai",$orgname_thai);
	barcodeval_set("activateulib-orgname-eng",$orgname_eng);
	barcodeval_set("activateulib-address",$address);
	barcodeval_set("activateulib-contact",$contact);
?><BR><?php 
	html_dialog("Success","Information saved.<BR>Submit to ULIB Central to complete registration.");
?><BR>
<table border = 0 cellpadding = 3 width = 780 align = center cellspacing=0 class=table_border>

<tr valign = "top"><td class=table_td>
<iframe width=780 height=400 src="register_save_if.php" frameborder="0"></iframe>
</td>
</tr>
</table>
<?php 

foot();
?>