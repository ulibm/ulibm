<?php 
set_time_limit(0);

    ;
	include ("../inc/config.inc.php");
	loginchk_lib();// พ

 if(!empty($ID))      {  

	if ($ID=="[EMPTY]") {
		$ID="";
	}
		echo "deleting bib .. {";
	   $s=tmq("select * from media where importid='$ID' ");

		   echo tmq_num_rows($s);
		while ($r=tmq_fetch_array($s)) {
			tmq("delete from media_mid where pid='$r[ID]' ");
			index_remove($r[ID]);
			index_ftremove($r[ID]);
			 $sql ="delete from media where  ID='$r[ID]'" ;
			 tmq($sql);
	   }
	   echo "}&nbsp; ...done<BR><BR>";
     $sql ="delete from index_db where importid='$ID'" ;
	 tmq($sql);
     $sql ="delete from index_db_subj where importid='$ID'" ;
	 tmq($sql);
     $sql ="delete from indexword where importid='$ID'" ;

    tmq($sql);
redir("media_type.php");

}

?>