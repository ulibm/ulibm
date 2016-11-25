<?php // พ
function marcdspmod_getsql($main) {
	$s=tmq("select * from marcdspmod_rule where pid='$main' order by ordr",false);
	$sq="";
	while ($r=tmq_fetch_array($s)) {
		//printr($r);
		//if ($r[]
		$sqldecis="";
		$r[val]=stripslashes($r[val]);
		$r[val]=stripslashes($r[val]);
		$r[val]=addslashes($r[val]);
		if ($r[decis]=="Exact match") {
			$sqldecis=" = \"$r[val]\" ";
		}
		if ($r[decis]=="Match (anywhere)") {
			$sqldecis=" like \"%$r[val]%\" ";
		}
		if ($r[decis]=="Begin with") {
			$sqldecis=" like \"$r[val]%\" ";
		}
		if ($r[decis]=="End with") {
			$sqldecis=" like \"%$r[val]\" ";
		}
		if ($r[decis]=="Like (match any case)") {
			$sqldecis=" like \"$r[val]\" ";
		}
		$sq.=" $r[bool] `$r[tagid]` $sqldecis  ";
	}

	$sqall="select ID from media where 1 $sq ";
	//itemrule
	$s=tmq("select * from marcdspmod_itemrule where pid='$main' and idlist<>'' ");
	if (tnr($s)>0) {
		$s=tfa($s);
		//printr($s);
		if (strtolower(trim($s[decis]))=="not") {
		    $s[decis]=" AnD NOT ";
		}
		$sqall.=" $s[decis] (id in ($s[idlist]))";
	}

	//echo "[$sqall]";// die;
	return $sqall;
}
?>