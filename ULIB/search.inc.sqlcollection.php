<?php 

////////start collection display
$collectionsql="";
//printr($usecollection);
if (is_array($usecollection) && count($usecollection)>0 )	 {
	if ($search_inc_sqlcollection_quiet!="yes") {
		echo "<span class=smaller style='background-color: #F2F2F2; width=100%'>";
		echo getlang("ค้นหาในคอลเล็กชัน::l::Searching in Collection");
	}
	$tmp="";
	while (list($collock,$collecv) = each($usecollection)) {
		if ($collecv=="yes") {
			$tmps=tmq("select * from collections where id='$collock' ");
			$tmps=tmq_fetch_array($tmps);
			$tmps[name]=getlang($tmps[name]);
				if ($tmps[name]!="") {
					$tmp.=", <img src='$dcrURL/neoimg/collectionicon/$tmps[icon]' width=16 height=16 align=absmiddle>";;
					$tmp.=" ".$tmps[name];
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
						if ($tmps[req_mdtype1]!="") {
							$collectionsql.=" and mdtype like '%$tmps[req_mdtype1]%' ";
						}
						if ($tmps[req_mdtype2]!="") {
							$collectionsql.=" and mdtype like '%$tmps[req_mdtype2]%' ";
						}
						if ($tmps[req_mdtype3]!="") {
							$collectionsql.=" and mdtype like '%$tmps[req_mdtype3]%' ";
						}
						if ($tmps[req_place]!="") {
							$collectionsql.=" and placelist like '%$tmps[req_place]%' ";
						}
					}
				$collectionsql.=") or collist like '%,$tmps[classid],%' ";
			}
		}
		$tmp=trim($tmp,',');
	}
	if ($search_inc_sqlcollection_quiet!="yes") {
		echo " : $tmp";
		echo "  <A HREF='collections.php' class=smaller>..." .getlang("เลือกใหม่::l::customize")."</A>";
		echo "</span><BR>";
	}
}
$collectionsql=trim($collectionsql);
if ($collectionsql!="") {
	$collectionsql= " and (0 $collectionsql)";
}
//echo "[$collectionsql]";
////////end collection display
?>