<?php // พ
//function for searching.php
function ssql($a,$b) {
	global $ssql_searchedword; // for search assist later
	$ssql_searchedword=Array();
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);

	$a=trim($a);
	//$CC=explode(" ", $a);
	$CC=explodewithquote($a);
	//printr($CC);
	$sql=" ";

	$firstp="yes";
	reset($CC);
	foreach ($CC as $x) {
		if ($x=="[[AND]]" || $x=="[[OR]]" || $x=="[[NOT]]") {
			if ($x=="[[AND]]") {
				$LASRBOOL="AND";
			}
			if ($x=="[[OR]]" ) {
				$LASRBOOL="OR";
			}
			if ($x=="[[NOT]]") {
				$LASRBOOL="AND NOT";
			}
			break;
		}
	}
	/*
	echo "<BR><PRE>";
	print_r($CC);
	echo "</PRE><HR>";
	*/
//$CC=array_filter($CC, "ssql_rembool");
	foreach ($CC as $x) {
		//echo "[<I>$x</I>]";
		if ($x=="[[AND]]") {
			$BOOL="AND";
		}
		if ($x=="[[OR]]" ) {
			$BOOL="OR";
		}
		if ($x=="[[NOT]]") {
			$BOOL="AND NOT";
		}
		if ($x=="[[AND]]" || $x=="[[OR]]" || $x=="[[NOT]]") {
			continue;
		}
		if ($BOOL=="") {
			$BOOL="AnD";
		}
		if ($firstp=="no") {
			$sql="$sql $BOOL ";
		}
		//$xe = tmq("select * from bkedit where $b='on' ");
		$firstp="no";
		$sql = "$sql (";
		$first="yes";
		//while ($r = tmq_fetch_array($xe)) {
			if ($x!="") {
				if ($first=="no") {
					$sql="$sql or ";
				}
				$ssql_searchedword[]=$x;
				$sql="$sql  ($b like '%$x%' )   \n";
				$first="no";
			}
		//}
		$sql = "$sql ) \n";
	}

		if ($LASRBOOL=="") {
			$LASRBOOL="AnD";
		}

	return " $LASRBOOL " . $sql;
	}
?>