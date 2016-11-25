<?php 

function local_media_headtr() {
global $local_media_headtr_firsttime;
if ($local_media_headtr_firsttime=="") {
?><SCRIPT LANGUAGE="JavaScript">
<!--
local_all_all=false;
function local_all(wh) {
//alert(wh);
	//x=document.forms["searchform"].getElementsByTagName("input");
		if (local_all_all==true)
		{
			local_all_all=false;
		} else {
			local_all_all=true;
		}
for (i = 0; i < wh.length; i++) {
		if (local_all_all==true)
		{
			wh[i].checked=local_all_all;
		} else {
			wh[i].checked=local_all_all;
		}
}

}

function local_swapitem(wh) {
	x=getobj(wh);
	if (x.checked==false) {
		x.checked=true;
	} else {
		x.checked=false;
	}
}
//-->
</SCRIPT>
<STYLE>
.searchtd_1_normal {
	background-color: #F5F5F5;
	cursor: hand; cursor: pointer;
	border-width: 0px; border-style: solid; border-color: #C8C8C8; border-top-width: 1px;
	border-bottom-width: 1px; border-bottom-color:  #FFFFFF;
}
.searchtd_1_over {
	cursor: hand; cursor: pointer;
	background-color: #FFAC00;
	border-width: 0px; border-style: solid; border-color: #FFA042; border-top-width: 1px;
	border-bottom-width: 1px;
}
.searchtd_2_normal {
	background-color: #FFFFFF;
	border-width: 0px; border-style: solid; border-color: #C8C8C8; border-top-width: 1px;
	border-bottom-width: 1px; border-bottom-color:  #FFFFFF;
}
.searchtd_2_over {
	background-color: #FFFBEC;
	border-width: 0px; border-style: solid; border-color: #FFA042; border-top-width: 1px;
	border-bottom-width: 1px;
}
.searchtd_3_normal {
	background-color: #FFFFFF;
	border-width: 0px; 
}
</STYLE>
<?php 
}
$local_media_headtr_firsttime="no";
?>
<tr bgcolor = "#ffffff">
      <td width = "20" align = center class=table_head>
<IMG SRC="neoimg/Checkmark.gif" WIDTH="16" HEIGHT="16" BORDER="0" onclick="local_all(document.forms['searchform']['marksave[]'])" style="cursor: hand; cursor: pointer;;"></td>

      <td  align = center width=690  class=table_head><?php  echo getlang("ผลการค้นหา::l::Search results"); ?></td>

      <td width = "90" class=table_head><nobr><?php  echo getlang("เลขเรียก::l::CallNumber"); ?></font></td>

  </tr>
<?php 
}
?>