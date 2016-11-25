<?php 
//พ
////////start collection display
function local_searchsqlcollection() {
$collectionsql="";
global $usecollection;
//printr($usecollection);
if (is_array($usecollection) && count($usecollection)>0 )	 {

	$tmp="";
   @reset($usecollection);
	while (list($collock,$collecv) = each($usecollection)) {
		if ($collecv=="yes") {
			$tmps=tmq("select * from collections where id='$collock' ");
			$tmps=tmq_fetch_array($tmps);
			$tmps[name]=getlang($tmps[name]);
				if ($tmps[name]!="") {

					if ($tmps[controlbyselect]=="no") {
						$collectionsql.=" or ( 1 ";
					} else {
						$collectionsql.=" or ( 0 ";
					}
					if ($tmps[controlbyselect]=="no") {
						if ($tmps[isreqeconnect]=="yes") {
							$collectionsql.=" and (length(index02)>6 ";
							$collectionsql.=" or length(ulibnote)>2 )";
						}
						if ($tmps[req_fttype]!="") {
							$collectionsql.=" and ulibnote like '%,$tmps[req_fttype],%' ";
						}
						if ($tmps[req_mdtype1].$tmps[req_mdtype2].$tmps[req_mdtype3]!="") {
                     $collectionsql.=" and (0 ";
   						if ($tmps[req_mdtype1]!="") {
   							$collectionsql.=" or mdtype like '%$tmps[req_mdtype1]%' ";
   						}
   						if ($tmps[req_mdtype2]!="") {
   							$collectionsql.=" or mdtype like '%$tmps[req_mdtype2]%' ";
   						}
   						if ($tmps[req_mdtype3]!="") {
   							$collectionsql.=" or mdtype like '%$tmps[req_mdtype3]%' ";
   						}
                     $collectionsql.=" ) ";
                  }
						if ($tmps[req_place]!="") {
							$collectionsql.=" and placelist like '%$tmps[req_place]%' ";
						}
					}
						if ($tmps[req_mdstatus]!="") {
							$collectionsql.=" and statuslist like '%$tmps[req_mdstatus]%' ";
						}
				$collectionsql.=") or collist like '%,$tmps[classid],%' ";
			}
		}
		$tmp=trim($tmp,',');
	}

}
$collectionsql=trim($collectionsql);
if ($collectionsql!="") {
	$collectionsql= " and (0 $collectionsql)";
}
//echo "[$collectionsql]";
////////end collection display
return $collectionsql;
}
?>