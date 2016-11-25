<?php 
   include_once($dcrs."webbox/searching.misc/search.inc.sqlcollection.php");
	if ($index=="") {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","search index is missing [$index]");
	resp();
	}// พ 
	if ($keyword=="") {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","search keyword is missing [$keyword]");
	resp();
	}
	$perpage=floor($perpage);
	if ($perpage==0) {
		$perpage=10;
	}
	$page=floor($page);
	if ($page==0) {
		$page=1;
	}
	//printr($_GET);
	$chkindex=tmq("select * from index_ctrl where code='$index' ");
	if (tnr($chkindex)==0) {
	bresp("error","1");
	bresp("error_name",$er_dat);
	bresp("error_description","invalid search index is missing [$index]");
	resp();
	}
	$indexfid=$index;
	include($dcrs."webbox/searching.misc/local_buildsearchsql.php");
	include($dcrs."webbox/searching.misc/search.inc.func.php");

	$kw=explodewithquote($keyword);
	//printr($kw); echo $_GET[keyword];
	@reset($kw);
	$kwa=Array(); // 
	$foundignoreword=Array(); // 
	while (list($kwk,$kwv)=each($kw)) {
		$sqlignoreword=tmq("select * from ignoreword where word='$kwv' ",false);
		$sqlignoreword=tmq_num_rows($sqlignoreword);
		if ($sqlignoreword!=0) {
			$foundignoreword[] = $kwv;
		} else {
			$kwa[] = trim($kwv," ,");
			statordr_add("search_text",iconvth($kwv));
		}
		//$searchdb[$searchdbkey]=$ALLNONSTOPWORD;
		//echo $setx."<BR>";
	}
	$_basesearchsql=local_buildsearchsql();
	$sql="select mid from index_db where ispublish='yes' and remoteindex='localdb' and $_basesearchsql ";
	//$_basesearchsql=$sql;
	$s=tmq($sql);
	$resultcount=tnr($s);
	$maxpage=ceil($resultcount/$perpage);
	bresp("resultcount","$resultcount");
	bresp("maxpage","$maxpage");
	bresp("currentpage","$page");
	$thisresult=tmq($sql . "order by titl asc limit ".(($page-1)*$perpage).",$perpage",false);
	$thisresulta=Array();
	$thisresulti=0;
	while ($thisresultr=tfa($thisresult)) {
	  //printr($thisresultr);
		$thisresulti++;
		$thisresulta[$thisresulti]=Array();
		$thisresulta[$thisresulti][bibid]=$thisresultr[mid];
		$thisresulta[$thisresulti][title]=marc_gettitle($thisresultr[mid]);
		$thisresulta[$thisresulti][calln]=marc_getcalln($thisresultr[mid]);
		$thisresulta[$thisresulti][author]=marc_getauth($thisresultr[mid]);
		$thisresulta[$thisresulti][biburl]=$dcrURL."dublin.php?ID=".($thisresultr[mid]);
		$thisresulta[$thisresulti][biburl_api]=$dcrURL."_api/api/index.php?command=getbib&bibid=".($thisresultr[mid]);
	}
	bresp("biblist",$thisresulta);
	//echo $sql;	


	resp();

?>