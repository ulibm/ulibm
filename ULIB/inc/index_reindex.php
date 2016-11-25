<?php  
function index_reindex($mid) {
  global $dcrs;
  global $newline;
  $skippostag[]="tag130";
  $skippostag[]="tag630";
  $skippostag[]="tag730";
  $skippostag[]="tag740";
  $skippostag2[]="tag240";
  $skippostag2[]="tag245";
  $skippostag2[]="tag440";
  $skippostag2[]="tag830";
	index_remove($mid);
	$s=tmq("select * from media where id='$mid' ");
	$s=tmq_fetch_array($s);

	$i=tmq("select * from index_ctrl ");
	
	$str="";
	//auto tag s
	$bibiddsp=trim(getval("MARC","bibiddsp"));
	if ($bibiddsp!="") {
		tmq("update media set $bibiddsp='  $mid' where ID='$mid' limit 1",false);
	}
	$librarysymboltag=trim(getval("MARC","librarysymboltag"));
	$librarysymbolval=trim(getval("MARC","librarysymbolval"));
	if ($librarysymboltag!="") {
		tmq("update media set $librarysymboltag='  $librarysymbolval' where ID='$mid' limit 1 ",false);
	}
	//die;
	//auto tag e
/// build tag str to โมเม add in kw
	$mdts=tmq("select distinct word1 from webpage_bibtag where bibid='$s[ID]' ",false);
	$taggedlist=",";
	while ($mdtsr=tmq_fetch_array($mdts)) {
		$taggedlist.=",$mdtsr[word1]";
	}
	$taggedlist.=",";
	$taggedlist=addslashes($taggedlist);
	$taggedlist=str_replace(',,',',',$taggedlist);
// end build tag str

	$tmpcalln="";
	while ($ir=tmq_fetch_array($i)) {
		//echo "<B>$ir[name]</B>=";
		$ir2=tmq("select * from bkedit where $ir[fid] ='on' ");
		$tmp="";
		while ($ir2r=tmq_fetch_array($ir2)) {
			//echo $ir2r[fid]." ";
			if (trim($s[$ir2r[fid]])!="") {
				$eachrepeattag=explodenewline($s[$ir2r[fid]]);
				foreach ($eachrepeattag as $eachrepeattagi) {
					if (in_array($ir2r[fid], $skippostag)) {
						$eachrepeattagi_skip=floor(substr($eachrepeattagi,0,1));
					}
					if (in_array($ir2r[fid], $skippostag2)) {
						$eachrepeattagi_skip=floor(substr($eachrepeattagi,1,1));
					}
					$eachrepeattagi=substr($eachrepeattagi,2);
					$eachrepeattagi=dspmarc($eachrepeattagi,'[empty]');
					$eachrepeattagi=substr($eachrepeattagi,$eachrepeattagi_skip);
					//echo "**-$eachrepeattagi-**";
					$tmp=$tmp."|" . ($eachrepeattagi);
					if ($ir[code]=="calln") {
						$tmpcalln.="$eachrepeattagi";
					}
					//$eachrepeattag_subfield=marc_getsubfields($eachrepeattagi);
					//foreach ($eachrepeattag_subfield as $eachrepeattag_subfieldi) {
					//	$eachrepeattag_subfieldi=addslashes($eachrepeattag_subfieldi);
					//	//permanently remove auto adding indexword
					//	//indexword_insert("$eachrepeattag_subfieldi",10,$mid,$s[importid]);
					//}
				}
			}
		}
		//taggedlist s
		if ($ir[code]=="kw") {
			$tmp.="$taggedlist";
		}
		//taggedlist e
		//$tmp=rem2space($tmp);
		//$tmp=substr($tmp,1);
		$tmp=trim($tmp,'|');
		$tmp=addslashes($tmp);
		$str=$str . "  $ir[fid]=\"$tmp\" 
		,";
		//echo "<BR>";
	}
		//$str=index_markword($str);
	$str=trim($str,',');
	//start gather midtypes
	$mdts=tmq("select distinct RESOURCE_TYPE from media_mid where pid='$s[ID]' order by RESOURCE_TYPE",false);
	$midlist=",";
	while ($mdtsr=tmq_fetch_array($mdts)) {
		$midlist.=",$mdtsr[RESOURCE_TYPE]";
	}
	$midlist.=",";
	$midlist=str_replace(',,',',',$midlist);
	$midlist=str_replace(',,',',',$midlist);

	$statuss=tmq("select distinct status from media_mid where pid='$s[ID]' order by RESOURCE_TYPE",false);
	$statuslist=",";
	while ($statussr=tmq_fetch_array($statuss)) {
		$statuslist.=",$statussr[status]";
	}
	$statuslist.=",";
	$statuslist=str_replace(',,',',',$statuslist);
	$statuslist=str_replace(',,',',',$statuslist);

	$mdts=tmq("select bcode from media_mid where pid='$s[ID]' ",false);
	$midlist2=",";
	while ($mdtsr=tmq_fetch_array($mdts)) {
		$midlist2.=",$mdtsr[bcode]";
	}
	$midlist2.=",";

	$mdts=tmq("select distinct place from media_mid where pid='$s[ID]' order by place",false);
	$placelist=",";
	while ($mdtsr=tmq_fetch_array($mdts)) {
		$placelist.=",$mdtsr[place]";
	}
	$placelist.=",";


//havesterpart start 

global $_ISULIBHAVESTER;
if ($_ISULIBHAVESTER=="yes") {
	$mdts=tmq("select distinct havestpid from  media_havest_id where hashed='".addslashes($s[keyid])."' order by havestpid",false);
	$havestlist=",";
	while ($mdtsr=tmq_fetch_array($mdts)) {
		$havestlist.=",$mdtsr[havestpid]";
	}
	$havestlist.=",";
}
$havestlist=str_replace(',,',',',$havestlist);
//echo " [$havestlist]";
//havesterpart end - plus at insert cmd


	$placelist=str_replace(',,',',',$placelist);
	$midlist2=str_replace(',,',',',$midlist2);
	$placelist=addslashes($placelist);
	$midlist2=addslashes($midlist2);

$str="insert into index_db set ". $str . " ,
mid='$mid',
mdtype='$midlist',
bibtag='$taggedlist',
bcode='$midlist2',
ispublish='$s[ispublish]',
webpageshowcase='$s[webpageshowcase]',
havestlist='$havestlist',
placelist='$placelist',
statuslist='$statuslist',
importid='$s[importid]',
collist='$s[collist]'

";
//echo $str;//die;
	tmq("$str ",false);

	//subjectdb extract start
	$tagsubj=getval("MARC","SUBJTAG");
	$data=$s[$tagsubj];
	//$data=str_replace("\n",$newline,$data);
	$data=explodenewline($data);
	if (is_array($data)) {
		while (list($k,$v)=each($data)) {
			if ($v!="") {
				$word=trim(dspmarc(substr($v,2)));
				$tmp=tmq("select id from index_db_subj where word1='".addslashes($word)."' and mid='$s[ID]' ");
				$tmp=tmq_num_rows($tmp);
				if ($tmp==0 && $word!="") {
					tmq("insert into index_db_subj set word1='".addslashes($word)."',usoundex='".usoundex_get($word)."' ,mid='$s[ID]',importid='$s[importid]' ");
				}
			}
		}
	}
	//subjectdb extract end
	
	index_indexft($mid);
	include_once("$dcrs/dublin.bibrating.inc.php");
	bibrating_recal($mid);

	//calln for shelf browser and sorting
	tmq("update media_mid set sortcalln=calln where pid='$mid' and trim(calln)<>'' ");
	tmq("update media_mid set sortcalln='$tmpcalln' where pid='$mid' and trim(calln)='' ");
	//echo "[$str]";
	
	//update cache data in media
	tmq("update media set cachemdtype='$midlist',cacheplacelist='$placelist' where ID='$mid' limit 1 ");

}
?>