<?php 
include("../inc/config.inc.php");
head();
include("inc.local.php");
if ($viewsingleuid!="") {
	?><table align=center width=<?php  echo $_TBWIDTH;?> >
	<tr>
		<td><div  style="width: <?php  echo $_TBWIDTH;?>!important; overflow: scroll;"><?php 
	$s=tmq("select * from stat_globaluid where statuid='$viewsingleuid' ");
	$r=tfa($s); //printr($r);
	$fpath=$dcrs."_logs/statuid/$r[yea]/$r[mon]/$r[dat]/".date("G",$r[dt])."/$r[statuid].txt";
	//echo $fpath;
	if (file_exists($fpath)) {
		echo "<br><font noclass=smaller2>";
		$data=file_get_contents($fpath);
		$data=unserialize($data);
		//printr($data);
		$fdata=unserialize($data[fullserver]);
		$data[fullserver]="";
		printr($data);
		echo "<HR noshade>";
		printr($fdata);
	} else {
		echo "Log file not found";
	}
	?></div></td>
	</tr>
	</table><?php 
	die("eof.");;
}

		$sdbs=tmq("select * from library_modules where code='stat-cir-".$stat."_$db' ");
		if (tmq_num_rows($sdbs)==0) {
			die("library_modules where code='stat-cir-$stat"."_$db'");
		}
		$sdbs=tmq_fetch_array($sdbs);
		$sdb=local_getsdb_thestat();
		$_REQPERM=$sdbs[code];

	$tmp=mn_lib();
	pagesection($tmp);
$tbname=$stat."_".$db;


if ($fulldet=="yes") {
	$s=tmq("select * from $tbname"."_log where 1 and dat='$d' and mon='$m' and yea='$y'  and head='$head' ");
	$res="";
	?><center><?php 
	while ($r=tfa($s)) {
		//print_r($r);
		echo "&bull; ".ymd_datestr($r[lastdt]);

		$fpath=$dcrs."_logs/statuid/$r[yea]/$r[mon]/$r[dat]/".date("G",$r[lastdt])."/$r[statuid].txt";
		//echo $fpath;
		if (file_exists($fpath)) {
			echo "<br><font class=smaller2>";
			$data=file_get_contents($fpath);
			$data=unserialize($data);
			//printr($data);
			$fdata=unserialize($data[fullserver]);
			echo $fdata[REMOTE_ADDR]."-";
			echo $fdata[HTTP_USER_AGENT]."-";
		}
			echo " </font> <a href=\"$PHP_SELF?viewsingleuid=$r[statuid]\" target=_blank class='smaller2 a_btn'>view</a><BR>";
	}
	?></center><?php 
		foot();
die;
}



$c[2][text]="ชื่อวันหมดอายุ::l::Template name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[20][text]="วันเดือนปี::l::Date";
$c[20][field]="dt";
$c[20][fieldtype]="date";
$c[20][descr]="";
$c[20][defval]="";

//dsp


$dsp[2][text]="Stat";
$dsp[2][field]="head";
$dsp[2][filter]="module:local_head";
$dsp[2][width]="30%";
function local_head($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[head],$sdb[$db][headmode]);
}

$dsp[4][text]="Detailed";
$dsp[4][field]="foot";
$dsp[4][filter]="module:local_foot";
$dsp[4][width]="30%";
function local_foot($wh) {
	global $tbname;
	global $d;
	global $m;
	global $y;
	global $stat;
	global $db;
	global $PHP_SELF;

	return "<a href='$PHP_SELF?stat=$stat&db=$db&y=$y&m=$m&d=$d&fulldet=yes&head=$wh[head]'>Full detail</a>";
}


$dsp[3][text]="จำนวน::l::Count";
$dsp[3][field]="cc";
$dsp[3][width]="30%";

$iscandel="no";
if (library_gotpermission("stat-candelete")) {
	$iscandel="yes";
}
fixform_tablelister($tbname," 1 and dat='$d' and mon='$m' and yea='$y'  ",$dsp,"no","no","$iscandel","mi=$mi&d=$d&m=$m&y=$y&stat=$stat&db=$db",$c);


foot();
?>