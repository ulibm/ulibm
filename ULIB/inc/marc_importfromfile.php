<?php 
function marc_importfromfile($filex,$todb="media") {
if (!function_exists("thisecho")) {
  function thisecho($t) {
  $a=0;
    if ($a==1) {
       echo $t;
    }
  }
} 

tmq("delete from importmarc_dupcheck_tmp");

	global $addimportid;
	global $setbibidcmd;
	global $addcollist;
	global $dcrs;
	global $getonly;				 
	global $IMPORTCOUNT;
	global $droppedgetonly;			

	$get_setbibidcmd="";

if ($getonly=="") {
	if ($todb=="media") {
		$s=tmq("select * from bkedit",false);
	} elseif ($todb="authority") {
		$s=tmq("select * from bkedit_authority",false);
	}
  $getonly=",";
  while ($r=tmq_fetch_array($s)) {
  	$getonly="$getonly,$r[fid]";
  }
  $getonly=mb_ereg_replace("tag","",$getonly);
  thisecho ("<B>getonly = $getonly <BR></B>");
}				 
											$IMPORTCOUNT=0;
											sleep(1);
											$importid=date("s:i:H d/m/Y") . "::$addimportid";

											$filename = "$dcrs/_input/$filex"; 
											
                     if (!$fd = fopen($filename, 'rb')) {
                          echo "Cannot open file ($filename)";
                          exit;
                     }
											while (!feof($fd))  {
												for ($testi=0;$testi<10; $testi++) {
													$testpos=ftell($fd);
													//if ($testpos>4000000) { die("testpos=$testpos");}
													thisecho("<br>[testpos=$testpos]");
													$testempty=fread ($fd, 1);
													thisecho( "[testempty=$testempty](".ord($testempty).")");
													if ($testempty==chr(13) || $testempty==chr(10)) {
														//echo("testempty");
														$newtestpos=ftell($fd);
														thisecho("[newtestpos=$newtestpos]");
													} else {
														fseek($fd,$testpos);
													}
												}
												$reclength = fread ($fd, 5);
												//echo "[reclen==$reclength]<BR>";
												$LEADER=fread ($fd, 7);
												$indexlength = fread ($fd, 5);
                                    $indexlength=floor($indexlength);
												$tmp1=fread ($fd, 3);
												$len_len=fread ($fd, 1);
												$start_len=fread ($fd, 1);
												$tmp2=fread ($fd, 2);
												$FULLLEADER="$reclength$LEADER$indexlength$tmp1$len_len$start_len$tmp2";
												thisecho ("[FULLLEADER=$reclength$LEADER($indexlength)$tmp1$len_len$start_len$tmp2]<BR>");
												$indexlength=$indexlength-24;
												if ($indexlength>0) {
													thisecho( "reclen = $reclength /indexlength =$indexlength<BR> ");
													$index = fread ($fd, $indexlength);
													thisecho( "<B>index= $index </B><BR>");
													thisecho( "<U>($reclength-(7+5+5+$indexlength+3+1+1+2</U>=");
													thisecho( "[[" . ($reclength-(7+5+5+$indexlength+3+1+1+2)) . "]]<BR>");
													$tmp="";
                                       $tmpii=0;
													while ( $tmpii<10000) {
                                       $tmpi=fread($fd,1);
                                          //echo "readed:$tmpi=".ord($tmpi)."<BR>";
                                          $tmpii++;
                                          $tmp=$tmp.$tmpi;
                                          if ($tmpi==chr(29)) {
                                             break;
                                          }
													}
                                       $p2=$tmp;
                                       $canclestag="no";
                                       if ($tmp=="") {
                                          $canclestag="yes";
                                          $p2="";
                                       }
													/*
													if (   $tmp = fread ($fd, ($reclength-(7+5+5+$indexlength+3+1+1+2)))  ) {
														$p2 = $tmp;
														$canclestag="no";
														// do nothing
													} else {
														$canclestag="yes";
														$p2="";
													}
                                       */
												
												/*$tmp=mb_strpos($p2,"eng d");
												echo "<H1>" .$tmp. "</H1>";
												$tmp=mb_substr($p2,$tmp+5,1);
												echo "<H1>" .$tmp. "1</H1>";
												$tmp=ord($tmp);
												echo "<H1><U>" .$tmp. "</U></H1>";
												$p2= mb_ereg_replace(chr(31),"",$p2);
												$p2= mb_ereg_replace(chr(30),"_",$p2);*/
////////////////////////////////////////////////////////
if ($cancelstag=="yes") {
   continue;
}
$leftstr = $index;
$addindi=0;
$FULLLEADER=addslashes($FULLLEADER);
if ($todb=="media") {
	$s="insert into media set \nleader='$FULLLEADER' , \n";
} elseif ($todb=="authority") {
	$s="insert into authoritydb set \nleader='$FULLLEADER' , \n";
}
//echo " [" . ($index)."]<BR>";
//echo " alldata=[" . ($p2)."]<BR>";
thisecho(" alldata=[" . ($p2)."]<BR>");
$getonced="";
while (mb_strlen($leftstr) >=4 && mb_strlen($p2)>20) {  //loop แต่ละแท็ก ในรายการนี้
	$addindi=$addindi;
	$usestr = mb_substr($leftstr,0,12);
	$leftstr = mb_substr($leftstr,12);
	thisecho( "use=$usestr/left=$leftstr <BR>");
	$f_id = mb_substr($usestr,0,3);
	$f_length = mb_substr($usestr,3,$len_len);
	$f_start = mb_substr($usestr,3+$len_len,$start_len);
	thisecho( "field=$f_id / len = $f_length / start = $f_start<BR>");
   $f_start=floor($f_start);
   $f_length=floor($f_length);
	$f_dat = mb_substr($p2,$f_start+$addindi,$f_length);
   //echo "[[$f_start+$addindi,$f_length]]";
   //echo "[[$f_dat]]";
	$subf=chr(31);
	$f_usedat=mb_ereg_replace($subf,"^",$f_dat);
   
	$subfe=chr(30);
	//$f_usedat=mb_ereg_replace($subfe,"<<",$f_usedat);
	//$f_usedat = mb_substr($f_usedat,2);
	$f_usedat = mb_substr($f_usedat,0,-2);
   $lib_marcimport_encoding=barcodeval_get("lib_marcimport_encoding");
   if ($lib_marcimport_encoding=="tis620") {
      thisecho("lib_marcimport_encoding=$lib_marcimport_encoding<BR>");
   	$f_usedat = iconvth($f_usedat);
   }
   if ($lib_marcimport_encoding=="utf8") {
      thisecho("lib_marcimport_encoding=$lib_marcimport_encoding<BR>");
   	$f_usedat = iconvutf($f_usedat);
   }
	$f_usedat = addslashes($f_usedat);
	thisecho("dat=[$f_usedat] (add $addindi)<BR><BR>");
	if (mb_strpos($getonly,$f_id)===false) {
		thisecho ("<FONT COLOR=red><BR>DROPBY getonly $f_id<BR></FONT>");
		$droppedgetonly.=",$f_id";
		//ไม่ทำอะไร
	} else {
		if ($getonced[$f_id]!="yes") {
		  $s="$s tag$f_id='$f_usedat',\n";
		   $getonced[$f_id]="yes";
		} else {
			$s=mb_ereg_replace("tag$f_id='","tag$f_id='$f_usedat\n",$s);
			thisecho ("<FONT COLOR=orange><BR>RE-ADD by getonced $f_id -- adding [$f_usedat]<BR></FONT>");
		}
		if ($f_id=="100") {
			$tmpdupchk100=$f_usedat;
		}
		if ($f_id=="245") {
			$tmpdupchk245=$f_usedat;
		}
		thisecho ("<FONT COLOR=orange><BR>ADD $f_id<BR></FONT>");
		//echo "<B>$f_id=$getonced[$f_id] </B>";
		if ($setbibidcmd!="") {
			if ("tag$f_id"==$setbibidcmd) {
				$get_setbibidcmd=$f_usedat;
			}
		}
	}
}
$get_setbibidcmd=trim($get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('^B','^b',$get_setbibidcmd);
$get_setbibidcmd=explode('^b',$get_setbibidcmd);
$get_setbibidcmd=$get_setbibidcmd[0];
$get_setbibidcmd=mb_ereg_replace('^A','',$get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('^a','',$get_setbibidcmd);
$get_setbibidcmd=str_remspecialsign($get_setbibidcmd);
$get_setbibidcmd=strtolower($get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('a','',$get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('b','',$get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('-','',$get_setbibidcmd);
$get_setbibidcmd=mb_ereg_replace('x','1000',$get_setbibidcmd);
if ($get_setbibidcmd!="") {
	$s.=" ID='$get_setbibidcmd', ";
	//echo "[$get_setbibidcmd]";
}
if ($todb=="media") {
	$s = "$s importid='$importid',collist='$addcollist' ;;;;"; //use ;;;; to seperate records
} elseif ($todb=="authority") {
	$s = "$s importid='$importid' ;;;;"; //use ;;;; to seperate records
}


$s = trim($s,",");
////////////////////////////////////////////////////////
		thisecho(  " <U>data=$p2</U> <HR>");
		thisecho( "<B><PRE>[$s]</PRE></B>");
		//echo $s;
		//tmq($s);
		$fp = fopen("$dcrs/_output/marc.sql","a"); 
		$string = "$s\n";  // escape the slash from being magically 
								// being transformed into a newline 
		fwrite($fp, $string);
		$IMPORTCOUNT++;

		tmq("insert into importmarc_dupcheck_tmp set tag100='".addslashes($tmpdupchk100)."',tag245='".addslashes($tmpdupchk245)."' ");

		thisecho(  " <HR>");
	} //if indexlength >0
} //while not feof
			fclose ($fd); 
			return $importid;
}
?>