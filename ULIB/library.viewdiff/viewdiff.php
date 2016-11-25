<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="viewstrdiff";
$tmp=mn_lib();
pagesection($tmp);
$viewid=floor($viewid);
if ($viewid!=0) {
	$s=tmq("select * from viewdiffman where id='$viewid' ");
	if (tnr($s)==1) {
		$s=tfa($s);
		$cate=tmq("select * from viewdiffman_cate where code='$s[cate]' ");
		$cate=tfa($cate);

		html_dialog("Edit History","<strong>".getlang($cate[name])."</strong><br>".getlang("โดย ::l::By ").get_library_name($s[loginid])."<br>".getlang("เมื่อ ::l::Date ").ymd_datestr($s[dt])." <font class=smaller>(".ymd_ago($s[dt]).")</font>");
		$to=stripslashes($s[str]);
		//if ($s[cate]=="librarianmsg") {
			$from=tmq("select * from viewdiffman where code='$s[code]' and cate='$s[cate]' and id<$s[id] order by id desc limit 1 ",false);
			if (tnr($from)==1) {
				$from=tfa($from);
				$from=stripslashes($from[str]);
			} else {
				$from="[no previous data]";
			}
		//}
	}
}
?>
<style type="text/css">
body {margin:0;border:0;padding:0;font:11pt sans-serif}
body > h1 {margin:0 0 0.5em 0;font:2em sans-serif;background-color:#def}
body > div {padding:2px}
p {margin-top:0}
ins {color:green;background:#dfd;text-decoration:none}
del {color:red;background:#fdd;text-decoration:none}
#params {margin:1em 0;font: 14px sans-serif}
.panecontainer > p {margin:0;border:1px solid #bcd;border-bottom:none;padding:1px 3px;background:#def;font:14px sans-serif}
.panecontainer > p + div {margin:0;padding:2px 0 2px 2px;border:1px solid #bcd;border-top:none}
.pane {margin:0;padding:0;border:0;width:100%;min-height:30em;overflow:auto;font:12px monospace}
.diff {color:gray}
</style>
<?php 

function local_htmlentities($s) {
	$s=str_replace("<","&lt;",$s);
	$s=str_replace(">","&gt;",$s);


	return $s;
}

// http://www.php.net/manual/en/function.get-magic-quotes-gpc.php#82524
function stripslashes_deep(&$value) {
	$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	return $value;
	}
if ( (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) || (ini_get('magic_quotes_sybase') && strtolower(ini_get('magic_quotes_sybase'))!="off") ) {
	stripslashes_deep($_GET);
	stripslashes_deep($_POST);
	stripslashes_deep($_REQUEST);
	}

include 'finediff.php';

$granularity = 3;
if ( isset($_REQUEST['granularity']) && ctype_digit($_REQUEST['granularity']) ) {
	$granularity = max(min(intval($_REQUEST['granularity']),3),0);
	}

$from_text = '';
$to_text = '';
if ( !empty($from) || !empty($to)) {
	if ( !empty($from) ) {
		$from_text = $from;
		}
	if ( !empty($to) ) {
		$to_text = $to;
		}
	}
$from_text=stripslashes($from_text);
$to_text=stripslashes($to_text);

$diff = '';

$granularityStacks = array(
	FineDiff::$paragraphGranularity,
	FineDiff::$sentenceGranularity,
	FineDiff::$wordGranularity,
	FineDiff::$characterGranularity
	);

$from_len = strlen($from_text);
$to_len = strlen($to_text);
$start_time = gettimeofday(true);
$diff = new FineDiff($from_text, $to_text, $granularityStacks[$granularity]);
$edits = $diff->getOps();
$exec_time = gettimeofday(true) - $start_time;
$rendered_diff = $diff->renderDiffToHTML();
$rendering_time = gettimeofday(true) - $start_time;
$diff_len = strlen($diff->getOpcodes());
?>
<table align=center width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><form action="viewdiff.php" method="post">

<div class="panecontainer" style="display:inline-block;width:49.5%"><p>From</p><div><textarea name="from" class="pane"><?php  echo local_htmlentities($from_text); ?></textarea></div></div>
<div class="panecontainer" style="display:inline-block;width:49.5%"><p>To</p><div><textarea name="to" class="pane"><?php  echo local_htmlentities($to_text); ?></textarea></div></div>
<p id="params">Granularity:<input name="granularity" type="radio" value="0"<?php  if ( $granularity === 0 ) { echo ' checked="checked"'; } ?>>&thinsp;Paragraph/lines&ensp;<input name="granularity" type="radio" value="1"<?php  if ( $granularity === 1 ) { echo ' checked="checked"'; } ?>>&thinsp;Sentence&ensp;<input name="granularity" type="radio" value="2"<?php  if ( $granularity === 2 ) { echo ' checked="checked"'; } ?>>&thinsp;Word&ensp;<input name="granularity" type="radio" value="3"<?php  if ( $granularity === 3 ) { echo ' checked="checked"'; } ?>>&thinsp;Character&emsp;<input type="submit" value="<?php  echo getlang("แสดงความแตกต่าง::l::View diff");?>"><!-- &emsp;<a href="viewdiff.php"><button>Clear all</button> --></a></p>
</form>
<div class="panecontainer" style="width:99%"><p>Diff <span style="color:gray">(diff: <?php  printf('%.3f', $exec_time); ?> sec, rendering: <?php  printf('%.3f', $rendering_time); ?> sec, diff len: <?php  echo $diff_len; ?> chars)</span></p><div><div class="pane diff" style="white-space:pre-line"><?php 
echo $rendered_diff; ?></div></div>
</div></td>
</tr>
</table>
<center style="font-size: 11px; color: #999">Powered by : ViewDiff</center>
<?php foot();?>