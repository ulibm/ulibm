<?php  
	; 
		
        include ("../inc/config.inc.php");
 	loginchk_lib();
	html_start();
?><style>
body {
	margin-top: 0px;
}
</style><?php  
//foot();
?><CENTER><?php  
$marcinfo=addslashes($marcinfo);
$marcinfo=trim($marcinfo);
if (trim($marcinfo)!="") {
tmq("insert into yaz_saved set marcinfo='".($marcinfo)."',fromsv='$fromsv', dt='".time()."' ,mddata='$mddata' ");
$newid=tmq_insert_id();
?><?php echo getlang("ทำการบันทึกข้อมูลแล้ว หากต้องการคีย์รายการดังกล่าวทันที ::l::Record saved, if need to key this record now"); ?> <A HREF="../library.book/addDBbook.php?yazid=<?php  echo $newid;?>" target=_top class=a_btn><?php echo getlang("กรุณาคลิกที่นี่::l::Click here"); ?></A><BR>
<?php  

}?>
<?php echo getlang(" ขณะนี้ในฐานข้อมูล มีรายการที่ถูกบันทึกไว้แล้วจำนวน ::l::Currently "); ?><?php echo number_format(tmq_num_rows(tmq("select id from yaz_saved")));?> <?php echo getlang("รายการ::l:: records in database"); ?> <A HREF="yazlist.php" target=_parent class=a_btn><?php echo getlang("คลิกที่นี่เพื่อจัดการ::l::Click here to manage"); ?></A></CENTER>