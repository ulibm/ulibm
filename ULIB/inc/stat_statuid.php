<?php  // พ
function stat_statuid($rid) {
	global $_SERVER; //printr($_SERVER);
	global $IPADDR;
	global $dcrs;
	global $PHP_SELF;
	
	$phpself = addslashes($PHP_SELF);
	$agent = addslashes($_SERVER[HTTP_USER_AGENT]);
	//var_dump($agent);
	$chk=tmq("select id from stat_globaluid where statuid='$rid' ");
	if (tnr($chk)==0) {
		//delete old vars s
		tmq("DELETE FROM stat_globaluid
			WHERE id NOT IN (
			  SELECT id
			  FROM (
				SELECT id
				FROM stat_globaluid
				ORDER BY id DESC
				LIMIT 100
			  ) foo
			); ");
		//delete old vars e
		$now=time();
		tmq("insert into stat_globaluid set
		statuid='$rid',
		dt='$now',
		phpself='$phpself',
		agent='$agent',
		yea='".date("Y",$now)."',
		mon='".date("n",$now)."',
		dat='".date("j",$now)."',
		ip='".addslashes($IPADDR)."'
		
		");
		$path_statuid=$dcrs."_logs/statuid/";
		@mkdir($path_statuid);
		$path_statuid=$dcrs."_logs/statuid/".date("Y",$now);
		@mkdir($path_statuid);
		$path_statuid=$path_statuid."/".date("n",$now);
		@mkdir($path_statuid);
		$path_statuid=$path_statuid."/".date("j",$now);
		@mkdir($path_statuid);
		$path_statuid=$path_statuid."/".date("G",$now);
		@mkdir($path_statuid);
		//file
		$path_statuid=$path_statuid."/".$rid.".txt";
		$ct=Array();
		$ct["statuid"]=$rid;
		$ct["phpself"]=$phpself;
		$ct["agent"]=$agent;
		$ct["fullserver"]=serialize($_SERVER);
		$ct["dt"]=$now;
		$ct["ip"]=$IPADDR;
		$ct["yea"]=date("Y",$now);
		$ct["dat"]=date("j",$now);
		$ct["mon"]=date("n",$now);
		$ct=serialize($ct);
		fso_file_write($path_statuid,"w+",$ct);

	} else {
		return;
	}
}
?>