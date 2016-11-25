<?php 
if ($_memid!="") { 
?><table width = "<?php  echo $_TBWIDTH;?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#E6E6E6" >

    <tr bgcolor = #F0F0F0>
        <td align=right><?php 
echo getlang(barcodeval_get("oss-o-name"));
	?></td><td width=100>
<?php 
html_xpbtn(getlang("ขอใช้บริการ::l::Send Request").",$dcrURL/OSS/landing.php?bibid=$ID,blue,_top");

		?></td>
    </tr>
</table><?php 
}
		?>