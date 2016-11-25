<?php 
function fixform_editor_save($edittp) {
	global $ffe_issave;
	global $useradminid;
	global $fixform_editor_save_newid;
	if ($ffe_issave!="yes") {
		return;
	}
	global $ffe_tb;
	global $ffe_condition;
	global $ffe_limitsql;

	$ffe_condition=stripslashes($ffe_condition);

	global $ffdat;
	//printr($edittp); 
	//printr($ffdat); die;
	//global $_POST;
	//printr($_POST);

	reset ($ffdat); 
	$dspsql=" ";
	//printr($ffdat);
	//printr($edittp);
	while (list ($key, $val) = each ($ffdat)) { 
		//printr($val);
		$tmpchk="";
		$tmpchk=substr($val,0,10);
		if ($tmpchk=="datedata::") {
			$dtdat=substr($val,10);
			//echo "[$listdat]";
			$dtdatv=form_pickdt_get($dtdat);
			//echo "[$dtdat=$dtdatv]<BR>";
			$dspsql.=" $key='".$dtdatv."' ,";
		} elseif ($tmpchk=="passdata::") {
			$valkey=substr($val,10);
			$valval="";
			eval("global $$valkey;");
			eval("\$valval=$$valkey;");
			$valval=trim($valval);
			if ($valval!="") {
				$dspsql.=" $key='".md5($valval)."' ,";
			}
			//echo $dspsql;
		} elseif ($tmpchk=="docdellb::") {
			$valkey=substr($val,10);
			eval("global $$valkey;");
			eval("\$valval=$$valkey;");
			$valval=serialize($valval);
			//echo $valval;
			//echo "here";
			$dspsql.=" $key='".addslashes($valval)."' ,";
		} elseif ($tmpchk=="switchsi::") {
			$valkey=substr($val,10);
			$valval="";
			eval("global $$valkey;");
			eval("\$valval=$$valkey;");
			//echo("\$valval=$$valkey;");
			if ($valval=="yes") {
				tmq("update $ffe_tb set $key='no' where 1",false);
			}
			$dspsql.=" $key='".$valval."' ,";
		} elseif ($tmpchk=="autoruni::") {
			if ($fftmode=="edit") {
				$dspsql.=" $key='".addslashes($ffdat[$key])."' ,";
			} else {
				$chkold=tmq("select * from $ffe_tb where $ffe_limitsql order by $key desc limit 1",false);
				$chkold=tmq_fetch_array($chkold);
				$chkold=floor($chkold[$key])+1;
				$dspsql.=" $key='".$chkold."' ,";
			}
		} elseif ($val=="special_eventsreg_regdata") {
		 global $special_eventsreg_regdata;
		 if (!is_array($special_eventsreg_regdata)) {
		    $special_eventsreg_regdata=Array();
		 }
		 //printr($special_eventsreg_regdata);
		    $val=",,".implode(",",$special_eventsreg_regdata).",,";
   		$dspsql.=" $key='".addslashes($val)."' ,";
		} elseif ($val=="special_eventsreg_reqdata") {
		 global $special_eventsreg_reqdata;
		 if (!is_array($special_eventsreg_reqdata)) {
		    $special_eventsreg_reqdata=Array();
		 }
		 //printr($special_eventsreg_regdata);
		  $val=",,".implode(",",$special_eventsreg_reqdata).",,";
		    //$val=",".implode(",,", array_keys($special_eventsreg_reqdata)).",,";
   		$dspsql.=" $key='".addslashes($val)."' ,";
		} else {
			//echo "[ $key-".$ffdat[$key]."]<HR>";
			$dspsql.=" $key='".addslashes($ffdat[$key])."' ,";
		}
	}
	///echo $dspsql;
	$dspsql=trim($dspsql,',');

	$chkold=tmq("select * from $ffe_tb where $ffe_condition");
	if (tmq_num_rows($chkold)>0) {
		$sql="update $ffe_tb set $dspsql where $ffe_condition";
		$savemode="update";
	} else {
		$sql="insert into $ffe_tb  set $dspsql , $ffe_condition";
		$savemode="insert";
	}
	///echo $sql; 
	tmq($sql);
	$newiddb=tmq_insert_id();
	$fixform_editor_save_newid=$newiddb;
	if ($savemode=="insert") {
		reset ($edittp); 
		while (list ($key, $val) = each ($edittp)) { 
			//for globalupload
			if (($val[addon]=="globalupload::"&&$val[fieldtype]=="html") || $val[fieldtype]=="multiplefile") {
				$newid="$ffe_tb-$newiddb";
				$ffdat[$val[field]]=frm_globalupload_updatetemp($newid,$ffdat[$val[field]]);
				tmq("update $ffe_tb set $val[field]='".$ffdat[$val[field]]."' where id='$newiddb' ",false);
				//echo $ffdat[$val[field]]=str_replace("/tempolary-for-$useradminid/","/$newid/",$ffdat[$val[field]]);;
			}
			//for singlefile
			tmq("update fft_upload set keyid ='$ffe_tb:$val[field]:$newiddb' where keyid='$ffe_tb:$val[field]:TEMP-$useradminid' ");
		}
	}

	echo "<CENTER><FONT SIZE=4 COLOR=darkgreen>".getlang("ทำการบันทึกข้อมูลเรียบร้อยแล้ว::l::Data saved successfully")."</FONT></CENTER>";
}

?>