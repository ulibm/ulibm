<?php // พ
function t_buildsql($q) {
	global $dbmode;
	@reset($q);
	//printr($q);
	$s=""; //result sql
	if ($dbmode=="pgsql") {
		if (is_array($q["select"])) {
			//echo count($q["select"])."xxx";
			if (count($q["select"])<=1) {
				$s="SELECT ".$q["select"][0]["a"];
			} else {
				$s="SELECT ";
				while (list($k,$v)=each($q["select"])) {
					$i++;
					$s.="". t_fixcolname($q["select"][$k]["a"]);
					if ($i<count($q["select"])) {
						$s.=",";
					}
				}
			}


			if ($q["from"][0]["a"]!="") {
				$s.="\n FROM ".$q["from"][0]["a"];
			}
		}
		/////////////////////
		if (is_array($q["insert"])) {
			$s="INSERT ";
			$s.="\n INTO ".$q["insert"][0]["a"];
			$s.="\n   (";
			$i=0;
			if (is_array($q["set"])) {
				$s.="";
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="\n   ". t_fixcolname($q["set"][$k]["a"]);
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
			$s.=") VALUES (";
			$i=0;
			if (is_array($q["set"])) {
				$s.="";
				@reset($q["set"]);
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="\n   ". t_fixval($q["set"][$k]["c"],$q["set"][$k]["a"],$q)."";
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
			$s.=")";
			//echo "$s";
		}
		/////////////////////
		if (is_array($q["update"])) {
			$s="UPDATE ".$q["update"][0]["a"];
			$i=0;
			if (is_array($q["set"])) {
				$s.="\n   SET ";
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="\n    ". t_fixcolname($q["set"][$k]["a"]). $q["set"][$k]["b"]. "".t_fixval($q["set"][$k]["c"],$q["set"][$k]["a"],$q)."";
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
		}
		/////////////////////
		if (is_array($q["delete"])) {
			$s="DELETE FROM ".$q["delete"][0]["a"].$q["from"][0]["a"];
		}
		/////////////////////
		$i=0;
		if (is_array($q["where"])) {
			if ($q["unwhere"][0]["a"]=="yes") {
				$s.="\n ";
			} else {
				$s.="\n WHERE ";
			}
			while (list($k,$v)=each($q["where"])) {
				if (strtolower(trim($q["where"][$k]["a"]))=="and (") {
					$s.="\n    AND ( ";
					continue;
				}
				if ($q["where"][$k]["a"]=="1" && $q["where"][$k]["c"]=="") {
					$s.="\n    true ";
					continue;
				} 
				if ($q["where"][$k]["a"]=="1" && $q["where"][$k]["c"]=="") {
					$s.="\n    true ";
					continue;
				} 
				if ((substr($q["where"][$k]["a"],-1) == "("  || substr($q["where"][$k]["a"],-1) == ")" )
					&& strlen(trim($q["where"][$k]["a"]))==1) {
					$s.="\n ". ($q["where"][$k]["a"]). $q["where"][$k]["b"]. "".t_fixval($q["where"][$k]["c"],$q["where"][$k]["a"],$q)." ";
					continue;
				}
				$s.="\n    ". t_fixcolname($q["where"][$k]["a"]). $q["where"][$k]["b"]. "'".$q["where"][$k]["c"]."'";
				
			}
		}
		/////////////////////
		if (is_array($q["raw"])) {

			$s.="\n  ". $q["raw"][0]["a"]."";
		}
		/////////////////////
		if (is_array($q["group"])) {
			$s.="\n GROUP BY ". t_fixcolname($q["group"][0]["a"])." ";
		}
		if (is_array($q["order"])) {
			if ($q["order"][0]["a"]=="rand()") {
				$q["order"][0]["a"]="RANDOM()";
			}
			$s.="\n ORDER BY ". t_fixcolname($q["order"][0]["a"])." ".($q["order"][0]["b"]);
		}
		/////////////////////
		if (is_array($q["limit"])) {
			if (trim($q["limit"][0]["b"])!="") {
				$s.="\n LIMIT ".$q["limit"][0]["b"];
				$s.=" OFFSET ".$q["limit"][0]["a"];
			} else {
				$s.="\n LIMIT ".$q["limit"][0]["a"];
			}
		}
		return $s;
	}
	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////
	if ($dbmode=="mysql" || $dbmode=="mysqli") {
		//printr($q);
		if (is_array($q["select"])) {
			//printr($q);
			//echo $q["select"][0]["a"];
			$s="SELECT ".$q["select"][0]["a"];
			if ($q["from"][0]["a"]!="") {
				$s.="\n FROM ".$q["from"][0]["a"];
			}
		}
		/////////////////////
		if (isset($q["insert"]) && is_array($q["insert"])) {
			$s="INSERT ";
			$s.="\n INTO ".$q["insert"][0]["a"];
			$s.="\n   (";
			$i=0;
			if (is_array($q["set"])) {
				$s.="";
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="". t_fixcolname($q["set"][$k]["a"]);
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
			$s.=") VALUES (";
			$i=0;
			if (is_array($q["set"])) {
				$s.="";
				@reset($q["set"]);
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="'". $q["set"][$k]["c"]."'";
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
			$s.=")";

		}
		/////////////////////
		if (isset($q["update"]) && is_array($q["update"])) {
			$s="UPDATE ".$q["update"][0]["a"];
			$i=0;
			if (is_array($q["set"])) {
				$s.="\n   SET ";
				while (list($k,$v)=each($q["set"])) {
					$i++;
					$s.="\n    ". ($q["set"][$k]["a"]). $q["set"][$k]["b"]. "'".$q["set"][$k]["c"]."'";
					if ($i<count($q["set"])) {
						$s.=",";
					}
				}
			}
		}
		/////////////////////
		if (isset($q["delete"]) && is_array($q["delete"])) {
			$s="DELETE FROM ".$q["delete"][0]["a"].$q["from"][0]["a"];
		}
		/////////////////////
		$i=0;
		if (is_array($q["where"])) {
			if ($q["unwhere"][0]["a"]=="yes") {
				$s.="\n ";
			} else {
				$s.="\n WHERE ";
			}
			while (list($k,$v)=each($q["where"])) {
				if (strtolower(trim($q["where"][$k]["a"]))=="and (") {
					$s.="\n    AND ( ";
					continue;
				}
				if ($q["where"][$k]["a"]=="1" && $q["where"][$k]["c"]=="") {
					$s.="\n    true ";
					continue;
				} 
				if ($q["where"][$k]["a"]=="1" && $q["where"][$k]["c"]=="") {
					$s.="\n    true ";
					continue;
				} 
				if ((substr($q["where"][$k]["a"],-1) == "("  || substr($q["where"][$k]["a"],-1) == ")" )
					&& strlen(trim($q["where"][$k]["a"]))==1) {
					$s.="\n ". ($q["where"][$k]["a"]). $q["where"][$k]["b"]. "".t_fixval($q["where"][$k]["c"],$q["where"][$k]["a"],$q)." ";
					continue;
				}
				$s.="\n    ". t_fixcolname($q["where"][$k]["a"]). $q["where"][$k]["b"]. "'".$q["where"][$k]["c"]."'";
				
			}
		}		/////////////////////
		if (isset($q["raw"]) && is_array($q["raw"])) {

			$s.="\n  ". $q["raw"][0]["a"];
		}
		/////////////////////
		if (isset($q["group"]) && is_array($q["group"])) {
			$s.="\n GROUP BY ". t_fixcolname($q["group"][0]["a"])." ";
		}
		if (isset($q["order"]) && is_array($q["order"])) {
			$s.="\n ORDER BY ". $q["order"][0]["a"]." ".$q["order"][0]["b"];
		}
		/////////////////////
		if (isset($q["limit"]) &&  is_array($q["limit"])) {
			$s.="\n LIMIT ".$q["limit"][0]["a"];
			if (trim($q["limit"][0]["b"])!="") {
				$s.=",".$q["limit"][0]["b"];
			}
		}
		//echo $s;
		return $s;
	}


	die("unknown dbmode [$dbmode]");
}
?>