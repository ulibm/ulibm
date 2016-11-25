<?php 
if ($_memid!="") { 
?><table width = "<?php  echo $_TBWIDTH;?>" align=center border = "0" cellspacing = "1" cellpadding = "3" bgcolor = "#bbbbbb" >

    <tr bgcolor = dddddd>
        <td align=right> <?php  echo getlang("พบรายการบรรณานุกรมผิดพลาด?::l::Found Incorrect Information::");?></td>
				<td width=100>
				<?php 
html_xpbtn(getlang("แจ้งรายการบรรณานุกรมผิดพลาด::l::Report Incorrect Bib.").",$dcrURL/member/reportincorrectbib.php?ID=$ID,red,_top"

);
		?></td>
    </tr>
</table><?php 
}	
		?>