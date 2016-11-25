<?php 
session_start();
include("../cfg.inc.php");
//include("./_REQPERM.php");
       html_start();        
  

	$permupload="no";
               
$_sessiud=session_id();
if ($_sessiud=="") {
	echo "<BR><BR>";
	html_dialog("","กรุณาล็อกอินเข้าระบบสมาชิกของเว็บไซต์ก่อน จึงจะสามารถแนะนำทรัพยากรได้");
	echo "<BR><BR>";
	$backto="$dcrURL"."acqn/vote.php?pid=$pid";
	form_member_login();
	foot();
	die;
}
//include("../member/menuadmin.php");
$dat=tmq("select * from acqn where id='$pid' ");
$dat=tfa($dat);

?><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<TR>
	<TD class=table_head width=25%><?php echo getlang("เลือกแนะนำทรัพยากร::l::Suggest Materials");?></TD>
	<TD class=table_td><B><?php echo $dat[name]?></B><BR>
	<?php echo $dat[descr]?></TD>
</TR>
</TABLE>
<CENTER><A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back");?></B></A></CENTER><?php 


?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function opacity(id, opacStart, opacEnd, millisec) {
    //speed for each frame
    var speed = Math.round(millisec / 100);
    var timer = 0;

    //determine the direction for the blending, if start and end are the same nothing happens
    if(opacStart > opacEnd) {
        for(i = opacStart; i >= opacEnd; i--) {
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
    } else if(opacStart < opacEnd) {
        for(i = opacStart; i <= opacEnd; i++)
            {
            setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
            timer++;
        }
    }
}

//change the opacity for different browsers
function changeOpac(opacity, id) {
    var object = document.getElementById(id).style;
    object.opacity = (opacity / 100);
    object.MozOpacity = (opacity / 100);
    object.KhtmlOpacity = (opacity / 100);
    object.filter = "alpha(opacity=" + opacity + ")";
} 

function clickvote(votetype,bookid,onid,offid) {
	if (votetype=="not")
	{
		opacity(onid, 50, 20, 500);
		opacity(offid, 50, 20, 500);
	} else {
		opacity(onid, 50, 100, 500);
		opacity(offid, 100, 50, 500);
	}
	x=getobj('iframesaver');
	x.src='votesaver.php?pid=<?php  echo $pid;?>&votefor='+bookid+'&votetype='+votetype;
}
//-->
</SCRIPT>
<?php 
$permupload="no";

$tbname="acqn_sub";


$c[1][text]="รายละเอียดทรัพยากร";
$c[1][field]="text";
$c[1][fieldtype]="longtext";
$c[1][descr]="";
$c[1][defval]="";

$c[2][text]="-";
$c[2][field]="pid";
$c[2][fieldtype]="addcontrol";
$c[2][descr]="";
$c[2][defval]=$pid;


//

$dsp[1][text]="รายละเอียดทรัพยากร";
$dsp[1][field]="text";
$dsp[1][filter]="module:local_dsp";
$dsp[1][width]="60%";

$voted=tmq("select * from acqn_voted where memid='$_sessiud' and pid='$pid'  ",false);
$voted=tfa($voted);
$voted=$voted[data];
//echo $voted;

function local_dsp($wh) {
	global $voted;
	$s="<TABLE cellpadding=0 cellspacing=0 border=0 width=100%>
	<TR>
		<TD 
		onmouseover=\"this.style.backgroundColor='#E1F2FF'\"
		onmouseout=\"this.style.backgroundColor='transparent'\"
		style=\"font-size: 18;\"
		>
	<div style='display:block; width:170; float:right;'>
	<nobr>";
	$pos = strpos($voted, ",on-$wh[id],");
	$posnot = strpos($voted, ",off-$wh[id],");
	if ($pos !== false) { 
		//$s.= "pos";
		$style1=" ;filter:alpha(opacity=100) ;-moz-opacity:1; opacity:1;; ";
		$style2=" ;filter:alpha(opacity=20); -moz-opacity:0.20; opacity:0.20;;";
	} elseif ($posnot!==false) {
		//$s.= "posnot";
		$style1=" ;filter:alpha(opacity=20); -moz-opacity:.20; opacity:.20;; ";
		$style2=" ;filter:alpha(opacity=100); -moz-opacity:1; opacity:1;;";
	} else {
		//$s.= "else";
		$style1=" ;filter:alpha(opacity=15); -moz-opacity:.15; opacity:.15;; ";
		$style2=" ;filter:alpha(opacity=15); -moz-opacity:.15; opacity:.15;;";
	}
	
	$s.="<img src='Checkmark.png' width=64 style='$style1'
	ID='chkON$wh[id]' title='เห็นว่าควรจัดซื้อ'
	onclick=\"clickvote('on','$wh[id]','chkON$wh[id]','chkOFF$wh[id]')\" align=middle>
	<img src='gray.png' width=32 style='filter:alpha(opacity=20); -moz-opacity:.20; opacity:.20;'
	ID='chkNON$wh[id]' title='ไม่ออกความเห็น' align=middle
	onclick=\"clickvote('not','$wh[id]','chkON$wh[id]','chkOFF$wh[id]')\">
	<img src='Delete.png' width=64 style='$style2'
	ID='chkOFF$wh[id]' title='เห็นว่า ไม่ควร จัดซื้อ'
	onclick=\"clickvote('off','$wh[id]','chkOFF$wh[id]','chkON$wh[id]')\" align=middle>

	</nobr>
	</div>
	".stripslashes($wh[titl])." 
	ผู้แต่ง:".stripslashes($wh[auth])." 
	ปี:".stripslashes($wh[yea])." <br>
	".stripslashes($wh[pub])."
	<!-- <BR> <A class='a_btn smaller2' HREF='../board/addtopic.php?ID=18&backto=&predefinedtext=".stripslashes($wh[text])."' target=_blank>แนะนำเรื่องนี้ในกระทู้แนะนำสั่งซื้อ</A> -->
</TD>
	</TR>
	</TABLE>
	";

	return $s;
}

?><FORM METHOD=POST ACTION="vote.php">
<INPUT TYPE="hidden" NAME="pid" value="<?php  echo $pid?>">
<INPUT TYPE="hidden" NAME="issave" value="yes">
	<?php 
fixform_tablelister($tbname," pid='$pid' ",$dsp,"$permupload","$permupload","$permupload","pid=$pid",$c,"id",$o);
?>
</FORM>
<iframe name="saver" ID="iframesaver" style='display:none'></iframe><?php 

    
?>
<SCRIPT LANGUAGE="JavaScript" src="/counter2?Arec_acqn">
<!--
//-->
</SCRIPT>


<?php 
foot();
?>