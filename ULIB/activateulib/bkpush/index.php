<?php  
	; 
		// พ
        include ("../../inc/config.inc.php");
		include("../sv/_conf.php");
html_start();
function local_download($file_source,$fname,$certid) {
   $file_source=rtrim($file_source,"/ ");
   $file_source=$file_source."/root.backup/get.php?filename=".trim(base64_encode("backup-full.sql.gz"),"= ")."&certid=".md5($certid);
   //echo "local_download($file_source,$fname)";
	global $dcrs;
	$file_target=$dcrs."_svpush/$fname";
        $rh = fopen($file_source, 'rb');
        $wh = fopen($file_target, 'wb+');
        if ($wh===false) {
           echo " error opening file";
           return true;
        }
        if ($rh===false ) {
           echo " error reading  file";
           return true;
        }
        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 1024)) === FALSE) {
                   // 'Download error: Cannot write to file ('.$file_target.')';
                   echo " Download error: Cannot write to file ('.$file_target.') ";
                   return true;
               }
        }
        fclose($rh);
        fclose($wh);
        // No error
        return false;
    }

if ($certid=="") {
	 html_dialog("Error","Invalid Certification ID");
	 die;
}
$refcode1=strtoupper(substr($certid,0,5));
		$refcode2=substr($certid,-2);
		if ($refcode1=="" || $refcode2=="") {
			 die("refcode is empty");
		}
		
		$s=tmq("select * from ulibsv	where refcode='$refcode1' and refordr='$refcode2' ");
		if (tmq_num_rows($s)!=1) {
				html_dialog("Error","Error, Certification ID found, ($certid)");
					die;
		}
		
		$s=tmq_fetch_array($s);

		echo "Saving Backup for:<B>".getlang($s[orgname_eng])."</B>..<BR>
		<FONT class=smaller2 COLOR=777777>$s[url]...</FONT>..<BR>";
		local_download($s[url],"$certid-".date("Y-m-d").".gz",$certid);
      echo number_format(filesize("../../_svpush/"."$certid-".date("Y-m-d").".gz"))."b ";
		echo "Done, ULibM Server keep only one copy each day";
?>