<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("havester");

$s=tmq("select * from ulibhavestlist order by rand()");
?><CENTER><A HREF="clientlist.php"><B>กลับ</B></A></CENTER><CENTER><TABLE cellpadding=0 cellspacing=2 border=0><?php 
$i=0;
while ($r=tmq_fetch_array($s)) {
	?>
<TR>
	<TD><iframe ID="if<?php  echo $i;?>" src="" style="-moz-border-radius-topleft:7;
-moz-border-radius-topright:7;
-moz-border-radius-bottomright:7;
-moz-border-radius-bottomleft:7;
-webkit-border-top-left-radius:7;
-webkit-border-top-right-radius:7;
-webkit-border-bottom-left-radius:7;
-webkit-border-bottom-right-radius:7;
border: 3px solid #667999;
width:700; height: 100;
margin: 0 0 0 0
"></iframe></TD><TD><iframe ID="ifrel<?php  echo $i;?>" src="" style="-moz-border-radius-topleft:7;
-moz-border-radius-topright:7;
-moz-border-radius-bottomright:7;
-moz-border-radius-bottomleft:7;
-webkit-border-top-left-radius:7;
-webkit-border-top-right-radius:7;
-webkit-border-bottom-left-radius:7;
-webkit-border-bottom-right-radius:7;
border: 3px solid #990000;
width:290; height: 100;
margin: 0 0 0 0
"></iframe><SCRIPT LANGUAGE="JavaScript">
<!--
	setTimeout("tmp=getobj('if<?php  echo $i;?>');tmp.src='run.php?code=<?php  echo $r[code]; ?>';",<?php  echo $i*20?>000);
	setTimeout("tmp=getobj('ifrel<?php  echo $i;?>');tmp.src='run-relcheck.php?code=<?php  echo $r[code]; ?>';",<?php  echo $i*25?>000);
//-->
</SCRIPT></TD>
</TR><?php 
		$i++;

}
?>
</TABLE></CENTER><?php 
foot();
?>