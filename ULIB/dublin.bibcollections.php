<?php
if (strtolower(getval("_SETTING","dublinshowbibcollection"))=="yes") { ?>
<table bgcolor=white width="<?php  echo $_TBWIDTH?>" border=0 align=center cellpadding=0 cellspacing=0 >
<tr valign=top><td class="smaller2" align="right">
<?php

$tmpss=tmq("select * from collections where 1 ");
$bibcollectiondspcount=0;
	while($tmps=tmq_fetch_array($tmpss)) {
			$tmps[name]=getlang($tmps[name]);
            $collectionsql="";
				if ($tmps[name]!="") {
               
					if ($tmps[controlbyselect]=="no") {
						$collectionsql.=" and ( 1 ";
					} else {
						$collectionsql.=" and ( 0 ";
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
				$collectionsql.=") or collist like '%,$tmps[classid],%' ";
            //echo $collectionsql;
            $chk=tmq("select * from index_db where mid='$ID'  $collectionsql ",false);
            if (floor(tnr($chk))!=0) {
               $bibcollectiondspcount=$bibcollectiondspcount+1;
               echo "<img align=absmiddle border=0 src=\"$dcrURL"."neoimg/collectionicon/$tmps[icon]\" width=16 height=16> ".getlang($tmps[name]);
            }
			}
   }
   if ($bibcollectiondspcount>0) {
      echo " : <a href='$dcrURL"."webbox/collections-about.php' class=smaller2>".getlang("เกี่ยวกับ Collections::l::About Collections")."</a>";
   }
            ?>
</td></tr></table><?php
} ?>