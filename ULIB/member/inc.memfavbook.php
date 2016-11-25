<?php 
if ($_memid!="") { 
?><table width = "<?php  echo $_TBWIDTH;?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#E6E6E6" >

    <tr bgcolor = #F0F0F0>
        <td align=right><?php 
$favbook=tmq("select * from webpage_memfavbook where memid='$_memid' and bibid='$ID' ");	
if (tmq_num_rows($favbook)==0) {
	echo getlang("เพิ่มเล่มนี้ไว้ในรายการโปรด?::l::Add this to Favourite List::");
	echo ' :: <img src="'.$dcrURL.'/neoimg/FavoritesAdd24.png" align=absmiddle width=24 height=24>';
} else {
	echo getlang("เล่มนี้คือหนึ่งในรายการโปรดของคุณ::l::This is one of your Favourite List");
	echo ' :: <img src="'.$dcrURL.'/neoimg/Favorites24.png" align=absmiddle width=24 height=24>';
}
?></td>
<td width=100>
<?php 
if (tmq_num_rows($favbook)==0) {
	html_xpbtn(getlang("เพิ่มรายการนี้::l::Add this to Fav.").",$dcrURL/member/mainadmin.php?mempagemode=favbook&addfavbook=$ID,green,_top::".
	getlang("ไปจัดการหนังสือโปรด::l::Manage My Fav. Book").",$dcrURL/member/mainadmin.php?mempagemode=favbook,green,_top");
} else {
html_xpbtn(getlang("ไปจัดการหนังสือโปรด::l::Manage My Fav. Book").",$dcrURL/member/mainadmin.php?mempagemode=favbook,green,_top");
}

		?></td>
    </tr>
</table><?php 
} 
		?>