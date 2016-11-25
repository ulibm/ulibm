<BR><TABLE cellpadding=2 cellpadding=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>

<?php 
$s=tmq("select * from webpage_memfavbook where bibid='$ID' and ispublish='yes' order by rand() limit 10 ",false);
if (tmq_num_rows($s)!=0) { 
?>
<TR> 
	<TD class=table_head><?php echo getlang("สมาชิกที่บันทึกรายการนี้ไว้ในรายการโปรด::l::Members who add this to his/her favourite.");?></TD>
</TR>
<TR>
	<TD style="padding: 0 0 10 0 ;"><TABLE cellpadding=0 cellspacing=0 border=0 width=50 align=center><TR><?php  while ($r=tmq_fetch_array($s)) {?>
	<TD width=10% style="padding: 0 3 0 3"><?php echo html_membericon($r[memid],"small");?></TD>
	<?php }?>
</TR>

</TABLE></TD>
</TR>
<?php }?>


<TR>
	<TD>
<?php  include($dcrs."socialinternet/socialinternet_bib.txt");?>
</TD>
</TR>

</TABLE>