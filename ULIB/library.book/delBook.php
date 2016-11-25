<?php 
;
     include("../inc/config.inc.php");
loginchk_lib();


  echo $Sstr;
 if(!empty($ID)) {  
	 //startcheck
	$x="select * from media where ID='$ID' ";
	$x=tmq($x);
	if (tnr($x)!=1) {
		 html_dialog("","Error ผิดพลาด ไม่พบรายการที่ต้องการลบ");
		 foot();
		 die;
	}
	$x=tmq_fetch_array($x);
  if ($x[LIBSITE]!=$LIBSITE && getlibsitebibrule($LIBSITE,$x[LIBSITE],"permission-delete")!="yes") {
	html_dialog("Error!",getlang("คุณไม่มีสิทธิ์ลบ Bib นี้::l::You have no permission to delete this Bib. "));	
	die;
  }
  //end check

     $sql ="delete from media where ID='$ID'" ;
     //echo $sql;

	index_remove($ID);
	index_ftremove($ID);//use only in delete event

//die;
if(tmq($sql)) {  
	$now=time();
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$ID',
		edittype='delete bib.'
		");
	//tmq("delete from chainerlink where destid='$ID' ");
	if ($chainid!="" && $chainmaster!="") {
		tmq("delete from chainerlink where destid='$ID' ");
		redir("../library.chainer/items.php?chainid=$chainid&chainmaster=$chainmaster",0);
	} else {

   	$chkchain=tmq("select * from chainerlink where destid='$ID' ",false);
   	while ($chkchainr=tfa($chkchain)) {
      	//printr($chkchainr);
         tmq("delete from chainerlink where id='$chkchainr[id]'",false); //die;
         index_indexft($chkchainr[fromid],true);
         //index_indexft($chkchainr[destid],true);
         index_indexft($chkchainr[fromid]);
         //index_indexft($chkchainr[destid]);
   	}

		$typeid = urlencode($typeid);
		$faculty = urlencode($faculty);
		$keyword = urlencode($keyword);
		redir("DBbook.php?typeid=$typeid&faculty=$faculty&startrow=$startrow&keyword=$keyword",0);
	}
} else {
	echo"<font face ='ms sans serif'  size ='3'>";
	echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล อาจมีข้อผิดพลาดเกิดขึ้น กรุณาตรวจสอบอีกครั้ง";
	echo"</font>";
}  
/////////////////////////////////////////////
	$sql ="delete from media_mid where pid=$ID" ;
	tmq($sql);

} else { 
   echo "<b>Error </b> <br>ไม่สามารถบันทึกข้อมูล 
กรุณาใส่ข้อมูลให้เรียบร้อย ตรวจสอบอีกครั้ง";  
} 
echo $Estr;
?>