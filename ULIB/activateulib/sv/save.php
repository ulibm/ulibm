<?php 
include("../../inc/config.inc.php");// พ
include("./_conf.php");
		 $now=time();
html_start();
if ($issave1!="yes") {
	 die("1");
}
$issave=base64_decode($issave);
if ($issave!=$url) {
	 die("2");
}

	$orgname_thai=addslashes(trim(base64_decode($orgname_thai)));
	$orgname_eng=addslashes(trim(base64_decode($orgname_eng)));
	$address=addslashes(trim(base64_decode($address)));
	$contact=addslashes(trim(base64_decode($contact)));
	$refcode=addslashes(trim(base64_decode($refcode)));
	$url=addslashes(trim($url));
	
	if (strlen($orgname_thai)<=5) {
		html_dialog("","Please enter organization name (Thai)");
		local_genbackbtn($url."activateulib/register.php");
		die;
	}
	if (strlen($orgname_eng)<=5) {
		html_dialog("","Please enter organization name (English)");
		local_genbackbtn($url."activateulib/register.php");
		die;
	}
	if (strlen($address)<=5) {
		html_dialog("","Please enter address");
		local_genbackbtn($url."activateulib/register.php");
		die;
	}
	if (strlen($contact)<=5) {
		html_dialog("","Please contact information");
		local_genbackbtn($url."activateulib/register.php");
		die;
	}
	
  if ($refcode=="") {
		 //getnew refcode
		 $refcode=str_replace(' ','',$orgname_eng);
		 $refcode=str_remspecialsign($refcode);
		 $refcode=strtoupper(trim(substr($refcode,0,5)));
		 if ($refcode=="") {
		 		html_dialog("","cannot extract refcode from orgname (eng)");
				local_genbackbtn($url."activateulib/register.php");
				die;
		 }
		// echo $refcode; 
		 $s=tmq("select * from ulibsv where orgname_eng='$orgname_eng' or orgname_thai='$orgname_thai'  ",false);
		 ///or url='$url'
		 if (tmq_num_rows($s)!=0) {
		 		$s=tmq_fetch_array($s);
		 		html_dialog("Error","$orgname_eng,($orgname_thai)<br /><br /> already registered (Name already taken)");
				local_genbackbtn($url."activateulib/register.php");
				die;
		 }
		 $s=tmq("select * from ulibsv where refcode='$refcode' order by refordr desc");
		 $s=tmq_fetch_array($s);
		 $nextref=floor($s[refordr])+1;
		 $nextref=str_fixw($nextref,2);
		 //insert

		 tmq("insert into ulibsv set refcode='$refcode',refordr='$nextref' ,
		  orgname_thai='$orgname_thai',
			 orgname_eng='$orgname_eng',
			 url='$url',
			 address='$address',
			 contact='$contact',
			 dt=$now,
			 alwayson='$alwayson'
			 
			  ");
				echo "<center>";
				html_dialog("Success","Success , Click 'Finish Registration' to complete registration");
				?><table align=center><tr><td><?php 
				 	html_guidebtn(getlang("<b>Finish Registration</b>").",$url"."activateulib/gotrefcode.php?result=".$refcode.$nextref."&result2=".trim(base64_encode($refcode.$nextref),'=').",green,_self");
					?></td></tr></table><?php 
					echo "</center>";
					die;
	} else {
		//update by refcode
		$refcode1=strtoupper(substr($refcode,0,5));
		$refcode2=substr($refcode,-2);
		if ($refcode1=="" || $refcode2=="") {
			 die("refcode is empty");
		}
		
		$got=tmq("select * from ulibsv	where refcode='$refcode1' and refordr='$refcode2' ");
		if (tmq_num_rows($got)!=1) {
				echo "<center>";
				html_dialog("Error","Error, your referfence code not found, <br /> please click 'Reset Refcode' to reset your referrence code and try register again");
				?><table align=center><tr><td><?php 
 	html_guidebtn(getlang("<b>Reset Refcode</b>").",$url"."activateulib/resetrefcode.php,green,_self");
					?></td></tr></table><?php 
					echo "</center>";
					die;
		}
		
		tmq("update ulibsv set 
			 orgname_thai='$orgname_thai',
			 orgname_eng='$orgname_eng',
			 url='$url',
			 address='$address',
			 contact='$contact',
			 dt=$now,
			 alwayson='$alwayson'
		where refcode='$refcode1' and refordr='$refcode2' ");
		
				echo "<center>";
				html_dialog("Success","Update Success , Click 'Finish Updating' to complete registration");
				?><table align=center><tr><td><?php 
				 	html_guidebtn(getlang("<b>Finish Registration</b>").",$url"."activateulib/gotrefcode.php?result=".$refcode.$nextref."&result2=".trim(base64_encode($refcode.$nextref),'=').",green,_self");
					?></td></tr></table><?php 
					echo "</center>";
					die;
	}
	//sleep(10);
?>