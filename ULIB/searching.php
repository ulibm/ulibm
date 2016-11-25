<?php 
    ;
    include ("inc/config.inc.php");
	// พ 
	if (getval("_SETTING","form_at_hp")=="webbox") {
		$tab=tmq("select * from webbox_tab where module='Searching' ");
		$tab=tfa($tab);
		$tmpa=$_GET;
		@reset($tmpa);
		$addurl=Array();
		//printr($tmpa);
		while (list($k,$v)=each($tmpa)) {
			$v=str_replace("[[plussign]]","+",$v);
			$addurl[]="$k=".urlencode($v);
		}
		$addurl2=implode($addurl,"&");
		//echo $addurl2; die;
		redir($dcrURL."index.php?deftab=$tab[id]&".$addurl2);
		die;
	}

	?><table width="<?php  echo $_TBWIDTH?>" border=0 align=center bgcolor=white cellpadding=0 cellspacing=0>
	<TR valign=top>
		<TD><?php head();
		//$mn_web_nohomepage="yes";
		mn_web("search");?></TD>
	</TR>
	<TR valign=top>
		<TD style='height: 12; background-color: white'></TD>
	</TR>
	</TABLE><?php 

    include ("./search.inc.header.php");
	include ("./search.inc.mediarow.php");


	
	$_PAGE_FILE="searching.php";
	$_PAGE_FILEBACK="index.php?setforcehpmode=search";

                    if ($MAUTHOR != "") { $searchdb[au]= $MAUTHOR; }
                    if ($MTITLE != "") { $searchdb[ti]= $MTITLE; }
                    if ($MISBN != "") { $searchdb[ISBN]= $MISBN; }
                    if ($MCALLNUM != "") { $searchdb[calln]= $MCALLNUM; }
                    if ($MSUBJECT != "") { 
											 $MSUBJECT=str_replace('--',' ',$MSUBJECT);
										   $searchdb[su]= $MSUBJECT; 
										}
                    if ($MDESCRIPTION != "") { $searchdb[kw]= $MDESCRIPTION; }
                    if ($MAUTHOR != "") { $searchdb[au]= $MAUTHOR; }


	include("searchmodule.php");

		foot();	
		?>