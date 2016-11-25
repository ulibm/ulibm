<?php  //พ
function local_buildsearchsql($skip="",$basefid="") {
   //echo "local_buildsearchsql($skip,$basefid)"; 
	global $kwa;
	global $usecollection;
	global $processsearchfilter;
	global $repocatedb;
	global $indexfid;
	@reset($kwa);

	$_basesearchsql="  (0 ";
	if (strtolower(getval("_SETTING","searchdefbool"))=="and") {
   	$_basesearchsql="  (1 ";
	}
	$localkwai=0;
	while (list($k,$v)=each($kwa)) {
		$localkwai=$localkwai+1;
		//$v=trim();

		$v=trim($v," \"");
		$deflogic=getval("_SETTING","searchdefbool");//"OR";;//
		$defoperant="like";
		$chklogic=substr($v,0,1);
		//echo "$v [$chklogic]";
		//echo "$localkwai $v [$chklogic];<br>";
		if ($localkwai>1) {
			if ($chklogic=="-" && strlen($v)>1) {
				$v=ltrim($v,"-");
				$deflogic="AND";
				$defoperant="not like";
			}
			if ($chklogic=="+" && strlen($v)>1) {
				//echo "AN++D";
				$v=ltrim($v,"+");
				$deflogic="AND";
			}
		} else {
			$v=ltrim($v,"+-");
		}
		$_basesearchsql.=" $deflogic ($indexfid $defoperant '%".addslashes($v)."%') 
";
		//$sql=ssql($v,"kw");
	}
	$_basesearchsql.=" )";
   //echo $_basesearchsql;
   $_basesearchsql.=local_searchsqlcollection();
   //echo $_basesearchsql."&lt;--(skip=$skip)<BR>";
	if ($skip=="BUILDONLYBASE") {
		$_basesearchsql="  (0 ";
		@reset($kwa);
		$localkwai=0;
		while (list($k,$v)=each($kwa)) {
			$localkwai=$localkwai+1;
			//$v=trim();

			$v=trim($v," \"");
			$deflogic="OR";
			$defoperant="like";
			$chklogic=substr($v,0,1);
			//echo "$v [$chklogic]";
			//echo "$localkwai $v [$chklogic];";
			if ($localkwai>1) {
				if ($chklogic=="-" && strlen($v)>1) {
					$v=ltrim($v,"-");
					$deflogic="AND";
					$defoperant="not like";
				}
				if ($chklogic=="+" && strlen($v)>1) {
					$v=ltrim($v,"+");
					$deflogic="AND";
				}
			} else {
				$v=ltrim($v,"+-");
			}
			$_basesearchsql.=" $deflogic ($basefid $defoperant '%".addslashes($v)."%') 
	";
			//$sql=ssql($v,"kw");
		}
		$_basesearchsql.=" )";
		//echo $_basesearchsql;
      $_basesearchsql.=local_searchsqlcollection();
		//echo "[BUILDONLYBASE_basesearchsql=$_basesearchsql]";
		return $_basesearchsql;
	}
	//
	if ($skip!="mdtype") {
		if (local_anyyesmember($processsearchfilter[mdtype])==true) {
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[mdtype]);
			while (list($k,$v)=each($processsearchfilter[mdtype])) {
			   if ($v=="yes") {
				  $_basesearchsql.=" or mdtype like '%,$k,%' 
";
            }
			}
			$_basesearchsql.=" ) ";
		}
	}
	if ($skip!="place") {
	  //printr($processsearchfilter[place]);
		if (local_anyyesmember($processsearchfilter[place])==true) {
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[place]);
			while (list($k,$v)=each($processsearchfilter[place])) {
			   if ($v=="yes") {
				  $_basesearchsql.=" or placelist like '%$k%' ";
				}

			}
			$_basesearchsql.=" ) ";
		}
	}
	if ($skip!="lang") {
		if (local_anyyesmember($processsearchfilter[lang])==true) {
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[lang]);
			while (list($k,$v)=each($processsearchfilter[lang])) {
			   if ($v=="yes") {
				  $_basesearchsql.=" or fixw like '_________________________________$k%' ";
				}
			}
			$_basesearchsql.=" ) ";
		}
	}
	if ($skip!="yea") {
		if (floor($processsearchfilter[yea_start])!=0 || floor($processsearchfilter[yea_end])!=0) {
			$_basesearchsql.=" and
			(
			(FLOOR(SUBSTRING(fixw,6,4))>=".floor($processsearchfilter[yea_start])." and
			FLOOR(SUBSTRING(fixw,6,4))<=".(floor($processsearchfilter[yea_end])).") 
			or 
									(FLOOR(SUBSTRING(fixw,6,4))>=".(floor($processsearchfilter[yea_start])-543)." and
			FLOOR(SUBSTRING(fixw,6,4))<=".(floor($processsearchfilter[yea_end])-543).")
			)";
		}
	}
	if ($skip!="oairepo") {
		if (local_anyyesmember($processsearchfilter[oairepo])==true) {
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[oairepo]);
			while (list($k,$v)=each($processsearchfilter[oairepo])) {
			   if ($v=="yes") {
   				$_basesearchsql.=" or remoteindex = 'oai-$k' 
";
            }
			}
			$_basesearchsql.=" ) ";
		}
	}
	if ($skip!="havester") {
		if (local_anyyesmember($processsearchfilter[havester])==true) { 
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[havester]);
			while (list($k,$v)=each($processsearchfilter[havester])) {
			   if ($v=="yes") {
   				$_basesearchsql.=" or havestlist like '%,$k,%' 
";
//   				$_basesearchsql.=" or importid = 'havester:$k' 
//";
            }
			}
			$_basesearchsql.=" ) ";
		}
	}
	if ($skip!="oairepocate") {
	  //printr($processsearchfilter);
		if (local_anyyesmember($processsearchfilter[oairepocate])==true) {
			$_basesearchsql.=" and (0 ";
			@reset($processsearchfilter[oairepocate]);
			while (list($k,$v)=each($processsearchfilter[oairepocate])) {
			   if ($v=="yes") {
   				$_basesearchsql.=" or remoteindex in ( ".$repocatedb[$k][subs]." ) 
";
            }
			}
			$_basesearchsql.=" ) ";
		}
	}
	//echo "[local_buildsearchsql return = $_basesearchsql]";
	return $_basesearchsql;
}
?>