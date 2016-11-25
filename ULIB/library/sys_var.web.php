<?php  
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="sys_varweb";
        mn_lib();
				include("sys_var.inc.php");
?>
                <div align = "center">
<?php  
pagesection(getlang("ค่าตัวแปรระบบ-Web::l::System variables-Web"));

?>
<table border = 0 cellpadding = 0 width = 900 align = center cellspacing=30>
<form method=post action="<?php echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<?php  
local_mn("form_at_hp","_SETTING","form_at_hp","list:member_login,search,undercon,advsearch,webpage,freedb,browseauthor,browsetitle,rqroom,Wiki,webbox");
local_mn("IMPORTTANT_INDEX_ANNOUCE","_SETTING","IMPORTTANT_INDEX_ANNOUCE","longtext");
local_mn("underconstring","_SETTING","underconstring","longtext");
local_mn("web_hidefooter","_SETTING","web_hidefooter","yesno");
local_mn("globalFOOT","global","FOOT","text");
local_mn("web_hideheader","_SETTING","web_hideheader","yesno");
local_mn("globalHEAD","global","HEAD","text");
local_mn("globalHEAD2","global","HEAD 2","text");
local_mn("globalTITLEBAR","global","TITLE BAR","text");
local_mn("ulibkioskpwd","_SETTING","kioskpassword","text");
local_mn("display_search_addusis","_SETTING","display_search_addusis","yesno");
local_mn("display_biblabelatupac","_SETTING","display_biblabelatupac","yesno");
local_mn("display_LEADERatupac","_SETTING","display_LEADERatupac","yesno");
local_mn("display_serialitemstyle","_SETTING","display_serialitemstyle","list:box,list");
local_mn("useulibmconnect","_SETTING","useulibmconnect","yesno");
local_mn("useulibmconnect_url","_SETTING","useulibmconnect_url","text");
local_mn("remoteindexmap","_SETTING","remoteindexmap","longtext");
local_mn("yearthensepper","_SETTING","yearthensepper","number");
local_mn("searchdefbool","_SETTING","searchdefbool","list:AND,OR");
local_mn("searchdefsort","_SETTING","searchdefsort","list:title,titledesc,author,authordesc,rating");
local_mn("wikiusemodrewrite","_SETTING","wikiusemodrewrite","yesno");
local_mn("webhidemediabarcode","_SETTING","webhidemediabarcode","yesno");
local_mn("webhidecallnboxatresultlist","_SETTING","webhidecallnboxatresultlist","yesno");
local_mn("forceshowyearfixwinitem","_SETTING","forceshowyearfixwinitem","yesno");
local_mn("serialcoverfromft","_SETTING","serialcoverfromft","yesno");
local_mn("dublinshowbibcollection","_SETTING","dublinshowbibcollection","yesno");
local_mn("onshelfstringform","_SETTING","onshelfstring","text");
local_mn("urlmappuller","_SETTING","urlmappuller","longtext");

if ($issave=="yes") {
   redir($PHP_SELF); die;
}
?>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php  
				foot();
?>