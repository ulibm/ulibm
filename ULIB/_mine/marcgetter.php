<?php 
;
      include("../inc/config.inc.php");
/*
	$refcode1=substr($loader,0,5);
	$refcode2=floor(substr($loader,-2));
	 $s=tmq("select * from ulibsv where (refcode='$refcode1' and refordr ='$refcode2') and iscanminer='yes' ",false);
	 if (tmq_num_rows($s)==0) {
	 		echo( "error:ไม่สามารถหารายชื่อโค้ดของไซต์คุณได้ กรุณายืนยันให้แน่ใจว่า ได้ทำการลงทะเบียนโปรแกรม ULIBM เรียบร้อยแล้ว");
			die;
	 }
	 
	$refcodemine1=substr($loadfrom,0,5);
	$refcodemine2=floor(substr($loadfrom,-2));
	 $s=tmq("select * from ulibsv where (refcode='$refcodemine1' and refordr ='$refcodemine2') and ismine='yes' ",false);
	 if (tmq_num_rows($s)==0) {
	 		echo("error:ไม่สามารถหารายชื่อโค้ดของไซต์ที่เป็นเจ้าของ bib ได้ กรุณายืนยันให้แน่ใจว่า ไซต์นั้น ได้ทำการลงทะเบียนโปรแกรม ULIBM เรียบร้อยแล้ว");
			die;
	 }
	 
	 $r=tmq_fetch_array($s);
	 
	 
	 */
	 
$searchuri=urldecode($loadfrom)."/_mine/getmarcclient.php?TARGETID=".urlencode($ID);
//echo $searchuri;
$handle = @fopen($searchuri, "r");

if ($handle) {

	$buffer="";
    while (!feof($handle)) {
        $buffer .= fgets($handle, 4096);
    }
	if (strlen($buffer)<50) {
		echo "error:Couldnot download from server [$buffer]";
	} else {
		//echo $buffer;
	}
    @fclose($handle);
		$filetosave="$dcrs/_input/_tmpmarcimport.mrc";
		$resfile="$dcrs/_output/marc.sql";
		@unlink($filetosave);
		@unlink($resfile);		
		fso_file_write($filetosave,"w",$buffer);
		$IMPORTCOUNT=0;
		marc_importfromfile("_tmpmarcimport.mrc");

		if ($IMPORTCOUNT==1) {

			 
			 
			 $ct=file_get_contents($resfile);
			 tmq($ct,false);
			 		$lastadd=tmq_insert_id();
			 html_label('b',$lastadd);					
			 ?><script>
			 top.location="<?php  echo $dcrURL?>/library.book/addDBbook.php?IDEDIT=<?php  echo $lastadd?>"
			 </script><?php 
		} else {
			echo "error:Marc import failed";
		}
		
} else { // cannot create handle;
	echo  "error:Cannot connect to server";
}



        ?>