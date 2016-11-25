<?php // พ
function res_cov_dsp($mid,$tags="no",$width=100,$reflect="no",$addition_html="",$addition_css="") {
	global $dcrURL;
	global $res_cov_dsp_resulturl;
	global $dcrs;
	$res="";
	if ($tags=="no") {
		$tags=tmq("select * from media where id='$mid' ");
		$tags=tmq_fetch_array($tags);
	}

	$cov=tmq("select * from media_ftitems where mid='$mid' and fttype='cover' order by text limit 1");
	if (tmq_num_rows($cov)!=0) {
	  $covr=tfa($cov);
		if($covr[uploadtype]=="url") {
			$addurltail="";
			$covurl=$covr[filename];
		} else {
			$addurltail=".thumb.jpg";
			$covurl="$dcrURL/_fulltext/$covr[fttype]/$covr[mid]/$covr[filename]";
			$covdcrs=$dcrs."_fulltext/$covr[fttype]/$covr[mid]/$covr[filename]";
			$covdcrst=$covdcrs.".thumb.jpg";
			if (!file_exists($covdcrst)) {
				@copy($covdcrs,$covdcrst);
				$ext=explode('.',$covdcrs);
				//printr($ext);
				$ext=$ext[count($ext)-1];
				//echo $ext;
				fso_image_fixsize($covdcrst,"$ext",120);
			}
			$addurltailM=".thumbm.jpg";
			$covdcrstM=$covdcrs.".thumbm.jpg";
			if (!file_exists($covdcrstM)) {
				@copy($covdcrs,$covdcrstM);
				$ext=explode('.',$covdcrs);
				//printr($ext);
				$ext=$ext[count($ext)-1];
				//echo $ext;
				fso_image_fixsize($covdcrstM,"$ext",300);
			}
		}
		$res_cov_dsp_resulturl=$covurl.$addurltailM;
		$res .= "<img  $addition_html
       lowsrc='$covurl$addurltail' border=0 
       src='$covurl$addurltailM'
       srcset=\"$covurl$addurltail 120w, $covurl$addurltailM 300w\"
      style='$addition_css; -webkit-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);
-moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5); max-height:".floor($width*2).";
box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);' width=$width hspace=0 vspace=0";
		if ($reflect=="yes") { 
			$res.=" class='reflect' ";
		}
		$res.=" $addition_html>";
	} else {
		$tags=tmq("select * from media where ID='$mid' ");
		$tags=tmq_fetch_array($tags);
		$tmpreflect="";
		if ($reflect=="yes") { 
			$tmpreflect=" class='reflect' ";
		}
		$covinfo=get_coverbyinfo($tags,"$addition_html style='float: left;$addition_css; -webkit-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);
-moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);max-height:".floor($width*2).";
box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);' width=$width hspace=0 border=0 vspace=0 $tmpreflect $addition_html");
		if ($covinfo[ispass]=="yes") {
   		$res_cov_dsp_resulturl=$covinfo[url];
			$res .=  $covinfo[html];
		}
	}
	//echo "[$res]";
   //"_SETTING","serialcoverfromft" s
   $serialcoverfromft=trim(strtolower(getval("_SETTING","serialcoverfromft")));
   if ($serialcoverfromft=="yes" && $res=="") {
      $sb1="SELECT *  FROM media_mid where pid='$mid' ";	
      $sb1="$sb1 order by jenum_1 desc,jenum_2 desc,jenum_3 desc,jenum_4 desc,jenum_5 desc,jenum_6 desc,id desc";
      $sql1 ="$sb1" ; 
      $result = tmq($sql1,false);
      while ($row = tmq_fetch_array($result)) {
         $keyid="SERIAL-$row[pid]-attatch-$row[jenum_1]-$row[jenum_2]-$row[jenum_3]-$row[jenum_4]-$row[jenum_5]-$row[jenum_6]-$row[calln]";

         $serialcoverfromfts=tmq("select * from globalupload where keyid = '$keyid' and (substr(ctt,1,5)='image') order by filename asc limit 1 ",false);
         if (tnr($serialcoverfromfts)!=0) {
            $serialcoverfromftr=tfa($serialcoverfromfts);
            $res_cov_dsp_resulturl="$dcrURL/_globalupload/".$serialcoverfromftr[keyid]."/".$serialcoverfromftr[hidename];
      		$res="<img  $addition_html src='$dcrURL/_globalupload/".$serialcoverfromftr[keyid]."/".$serialcoverfromftr[hidename]."' border=0 style='$addition_css; -webkit-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);max-height:".floor($width*2)."
      -moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);max-height:".floor($width*2).";
      box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);' width=$width hspace=0 vspace=0";
      		if ($reflect=="yes") { 
      			$res.=" class='reflect' ";
      		}
      		$res.=" $addition_html>";
            break;
         }
      }

   }   
   //"_SETTING","serialcoverfromft" e
   
	if ($res=="") {
	$res_cov_dsp_resulturl="$dcrURL/neoimg/nocover.png";
		$res="<img  $addition_html src='$dcrURL/neoimg/nocover.png' border=0 style='$addition_css; -webkit-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);
-moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);max-height:".floor($width*2).";
box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.5);' width=$width hspace=0 vspace=0";
		if ($reflect=="yes") {  
			$res.=" class='reflect' ";
		}
		$res.=" $addition_html>";
	}
	return $res;
}
?>