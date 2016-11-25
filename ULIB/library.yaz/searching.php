<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();

$z39host=$_REQUEST[z39host];
$query=$_REQUEST[query];

$nterm = str_replace('"', "", $query);
$oterm = preg_replace("\?$", "",  $query);
if (strcmp($oterm,$nterm)) {
	$trunc_right="@attr 6=1";
} else {
	$trunc_right="";
}
//$fullquery = $field . $trunc_right . ' "' . $oterm . '"';
$fullquery = $field . $trunc_right . ' "' . $oterm . '"';

$query=$fullquery;
//echo "$query";


$num_z39hosts = count($z39host);
if (empty($query) || count($z39host) == 0) {
?><SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("กรุณาใส่คำสืบค้นและเลือกเซิร์ฟเวอร์ให้เรียบร้อย::l::Please enter keyword and choose some servers"); ?>");
//-->
</SCRIPT><?php 
	redir("index.php");
die;
} else {

	?><BR><BR><TABLE width=650 align=center>
	<TR>
		<TD><FONT SIZE="" COLOR="#000033"><B><?php  echo getlang("ผลการค้นหาคำว่า::l::Resulr for searching "); ?> <?php  echo $query?></B></FONT><BR><BR><?php 
//print_r($z39hostname);
    for ($i = 0; $i < $num_z39hosts; $i++) {
		$tmps=tmq("select * from yaz_sv where id='$z39host[$i]' ");
		$tmps=tmq_fetch_array($tmps);
		$connatt=array("user" => "$tmps[login]", "password" =>"$tmps[pwd]","persistent" => false, 'piggyback' => false, 'charset' => 'tis-620');
		//printr($connatt);
		//echo $z39hostconnect[$z39host[$i]];
        $id[$z39host[$i]] = yaz_connect($z39hostconnect[$z39host[$i]],$connatt);
		yaz_syntax($id[$z39host[$i]], "usmarc");
        yaz_range($id[$z39host[$i]], 1, 3);
        yaz_search($id[$z39host[$i]], "rpn", $query);
    }
    yaz_wait();
    for ($i = 0; $i < $num_z39hosts; $i++) {
        echo '<hr /><FONT  COLOR=#003300>' . $z39hostname[$z39host[$i]] . '</FONT><BR>';
        $error = yaz_error($id[$z39host[$i]]);
        if (!empty($error)) {
            echo "<IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> <B>Error:</B> $error";
        } else {
            $hits = yaz_hits($id[$z39host[$i]]);
			if ($hits!=0) {
				echo "<A HREF='scansv.php?sv=$z39host[$i]&query=".urlencode($query)."&reccount=$hits' class=a_btn><IMG SRC='../neoimg/Green.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("สืบค้นได้ผลลัพธ์จำนวน::l::Got results").": " . number_format($hits)." ".getlang("รายการ::l::records")."</A> ";
			} else {
				echo "<IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><FONT  COLOR='#FF3300'> <B>".getlang("พบจำนวน 0 รายการ::l::No records found")."</B></FONT> ";
			}
        }
		/*
        echo '<BR>';
        for ($p = 1; $p <= 10; $p++) {
            $rec = yaz_record($id[$i], $p, "string");
            if (empty($rec)) continue;
            echo "<dt><b>$p</b></dt><dd>";
            echo nl2br($rec);
            echo "</dd>";
        }
        echo '</dl>';
		*/
    }
		?></TD>
	</TR>
	</TABLE><?php 

}

?><B><CENTER><A HREF="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A></CENTER></B><?php 

foot();

?>