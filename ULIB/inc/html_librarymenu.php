<?php  //พ

function html_librarymenu($gmenuitem) {
	global $dcrURL;
	global $_ROOMWORD;
	global $_FACULTYWORD;

	$s=tmq("select * from library_modules_cate   where  code='$gmenuitem' ",false);
	$r=tmq_fetch_array($s);
	$s2ql="select * from library_modules  where  nested='$r[code]' and isshow='yes' order by ordr,name,code";
	$s2=tmq($s2ql);
	$thisperm2=false;
	while ($r2=tmq_fetch_array($s2)   ) {
		$thisperm2=$thisperm2 || library_gotpermission($r2[code]);
		if ($thisperm2==true) {
			break;
		}
	}

	if ($thisperm2==false) {
		return;
	}

	$ic=0;
			$ic++;

			$url="";
			if ( $r[url]!="") {
				$r[url]=str_replace('[dcr]',$dcrURL,$r[url]);
				$url="<A HREF='$r[url]' >";
			}
			$r[name]=str_replace('[ROOMWORD]',$_ROOMWORD,$r[name]);
			$r[name]=str_replace('[FACULTYWORD]',$_FACULTYWORD,$r[name]);


							echo "<TABLE width=100% class=table_td BORDER=0 CELLPADDING=3 CELLSPACING=0  ID=\"libmann_librarymenu_$gmenuitem\">";

			echo "<TR>
							<TD  style='background-color: ffffff; border-width: 0px;border-bottom-color: #6F9FDB; border-bottom-style: solid;border-bottom-width: 3' colspan=2 >&nbsp;<img src='$dcrURL/neoimg/menuicon/folder.png' align=absmiddle>&nbsp;<B style='font-size: 16px;color:#39537D'>$url".getlang($r[name])."</A></B></TD>
						</TR>";

						$s2=tmq($s2ql);


							while ($r2=tmq_fetch_array($s2)   ) {
								$r2[name]=str_replace('[ROOMWORD]',$_ROOMWORD,$r2[name]);
								$r2[name]=str_replace('[FACULTYWORD]',$_FACULTYWORD,$r2[name]);

								$url="";
								$thisperm2=library_gotpermission($r2[code]);
								if ($thisperm2==false ) {
									continue;
								}
								if ($thisperm2==true && $r2[url]!="") {
									$r2[url]=str_replace('[dcr]',$dcrURL,$r2[url]);
									$dcrURL2=trim($dcrURL,'/');
									$r2[url]=str_replace($dcrURL2.'//',$dcrURL2.'/',$r2[url]);
									$url="<A HREF='$r2[url]' style='font-size:16px;width: 100%; display: block;'>  ";
								}
								if ($r2[url]=="" ) {
									$url="<b style='color: #818181; font-weight: normal;'  >&nbsp;";
								}




								echo "
								<TR>
								<TD class=table_td width=16 style='background-color:#EEEEEE; width: 16' ><img src='$dcrURL/neoimg/menuicon/$r2[icon]' align=absmiddle > </TD>
												<TD width=100%
									style='background-color:#f9f9f9;' onmouseover=\"this.style.backgroundColor='#e5e5e5' \" 
									onmouseout=\"this.style.backgroundColor='#f9f9f9' \"
									onmouseup=\"this.style.backgroundColor='#f9f9f9' \"
									onmousedown=\"this.style.backgroundColor='orange' \" class=table_td>
$url";
if ($r2[isbold]=="yes") { echo "<B>";}
echo stripslashes(getlang($r2[name]));
if ($r2[isbold]=="yes") { echo "</B>";}
echo "</A>";
								echo "</TD>
											</TR>";

							}
						echo "</TABLE>";

}
?>