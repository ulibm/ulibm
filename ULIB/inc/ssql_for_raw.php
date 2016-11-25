<?php // พ
//function for library.book/DBbook.php
function ssql_for_raw($a,$b,$mode="any") {
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);
	$a = str_replace("  "," ",$a);

	$a=trim($a);
	$CC=explode(" ", $a);
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
		$xe = tmq("select * from bkedit where $b='on' ");
		$firstp="no";
		$sql = "$sql (";
		$first="yes";
		while ($r = tmq_fetch_array($xe)) {
			if ($x!="") {
				if ($first=="no") {
					$sql="$sql or ";
				}
            if ($mode=="any") {
   				$sql="$sql  ($r[fid] like '%$x%' )   \n";
            }
            if ($mode=="begin") {
   				$sql="$sql  ($r[fid] like '$x%' or $r[fid] like '__$x%' or $r[fid] like '__^a$x%' )   \n";
            }
				$first="no";
			}
		}
		$sql = "$sql ) \n";
	}

		if ($LASRBOOL=="") {
			$LASRBOOL="AnD";
		}

	return " $LASRBOOL " . $sql;
	}
?>