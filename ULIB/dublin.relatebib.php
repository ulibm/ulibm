<?php 
	$relauthdb_relaname[titl]=getlang("ชื่อเรื่อง::l::Title");
	$relauthdb_relaname[auth]=getlang("ผู้แต่ง::l::Author");
	$relauthdb_relaname[subj]=getlang("หัวเรื่อง::l::Subject");
	$relauthdb[titl]="tag245";
	$relauthdb[auth]="tag100";
	$relauthdb[subj]="tag650";

	$relaresult=Array();
	$sourceinfo=tmq("select * from media where ID='$ID' ");
	$sourceinfo=tmq_fetch_array($sourceinfo);
	while (list($k,$v)=each($relauthdb)) {
		$searchkeys=explodenewline($sourceinfo[$v]);
		$searchkeys=arr_filter_remnull($searchkeys);
		while (list($searchkeysk,$searchkeysv)=each($searchkeys)) {
			$search=substr($searchkeysv,2);
			if ($search!="") {
				//$search=$search[0];
				$search=dspmarc($search);
				$search=trim($search);
				$finding=tmq("select * from index_db where $k like '%".addslashes($search)."%' and mid<>'$ID'  order by rand() limit 3",false);
				if ($search!="" && tmq_num_rows($finding)!=0) {
					$relaresult[$k].="&nbsp;&nbsp;&nbsp; <FONT class=smaller><B  class=smaller>".$relauthdb_relaname[$k]."</B> [$search] </FONT><BR><UL>";
					while ($findingr=tmq_fetch_array($finding)) {
						$relaresult[$k].="<LI>&nbsp;  <A HREF='dublin.php?ID=$findingr[mid]' target=_blank class=smaller2>".mb_substr(marc_gettitle($findingr[mid]),0,70)."</A> <BR>";
					}
					$relaresult[$k].="</UL>";
				}
			}
		}
	}

	if (count($relaresult)!=0) {
		?><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
		<TR>
			<TD class=table_td><B><?php 
		echo getlang("รายการใกล้เคียง::l::Relate Records");	
		?></B><BR>
		<?php 
	while (list($k,$v)=each($relaresult)) {
	      if (trim($v)=="") continue;

			echo $v;
			echo "<BR>";
	}
		?></TD>
		</TR>
			</TABLE><?php 
	}
	//printr($relaresult);
?>