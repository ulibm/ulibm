<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("logbrowser");
			pagesection("Logs Browser");
// พ

?><BR><TABLE align=center width=550 border=1><TR><TD>
<?php 
$ext=substr($f,-4);
	filelogs("viewlogs",$f,"viewlogfile");

if ($ext=="html") {


$handle = fopen("$f", "r");
while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    echo $buffer;
}
fclose($handle);
} else {
	echo "Only HTML file can access (this action has been loged.)";
}
?> <TD>
</TR>
</TABLE>


<BR><BR>
<B><CENTER><A HREF="index.php">Back</A></CENTER></B>
<BR><?php 
foot();
?>