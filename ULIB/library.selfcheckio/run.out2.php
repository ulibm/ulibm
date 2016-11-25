<?php 
include_once("../inc/config.inc.php");
html_start();
include_once("./inc.php");
$memberbarcode=trim($memberbarcode);
$memberbarcode=addslashes($memberbarcode);
$mem=tmq("select * from member where UserAdminID='$memberbarcode' ");
if (tnr($mem)!=1) {
	html_dialog("ผิดพลาด","ไม่พบสมาชิกบาร์โค้ด [$memberbarcode]"); 
	include("run.out1.php");
	die;
}
$mem=tfa($mem);
$pin=trim($pin);
$pin=addslashes($pin);
if ($pin!="" && $pin==$mem[Password]) {
	//login ok
	?>
	<script type="text/javascript">
<!--
	top.cstep="out_waitmats";
	top.cur_member="<?php  echo $memberbarcode?>";
	self.location="run.out3.php?id=<?php  echo $id;?>&memberbarcode=<?php  echo $memberbarcode?>";
//-->
</script>
<?php 
	die;
} else {
	if ($pin!="") {
		html_dialog("ผิดพลาด","รหัสผ่านผิด [$pin]"); 
	}
}
?><center><br><font style='font-size: 18px; font-weight: bold;'><?php 
echo getlang("ยินดีต้อนรับ::l::Welcome")."<br>";
?><IMG SRC='<?php  echo member_pic_url($memberbarcode);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''><?php 
echo "<br>";
echo $mem[UserAdminName];
?></font><br></center>
<script type="text/javascript">
<!--
	top.cstep="out_waitmemberpassword";
	top.cur_member="<?php  echo $memberbarcode?>";
//-->
</script>
<?php 
local_gethtml("out_enterpassword");
?><center>
<div style="width: 600px; display:block; "><div style="font-size: 36px; font-weight:bold; height: 42px;" ID="tmpmasked"></div>
<table cellspacing=3 cellpadding=3 border=0 align=center>

<tr>
	<td><a href="javascript:void(null);" onclick="localkeypad(7);" class="iobtnnumeric">7</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(8);" class="iobtnnumeric">8</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(9);" class="iobtnnumeric">9</a></td>
</tr>
<tr>
	<td><a href="javascript:void(null);" onclick="localkeypad(4);" class="iobtnnumeric">4</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(5);" class="iobtnnumeric">5</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(6);" class="iobtnnumeric">6</a></td>
</tr>
<tr>
	<td><a href="javascript:void(null);" onclick="localkeypad(1);" class="iobtnnumeric">1</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(2);" class="iobtnnumeric">2</a></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(3);" class="iobtnnumeric">3</a></td>
</tr>
<tr>
	<td></td>
	<td><a href="javascript:void(null);" onclick="localkeypad(0);" class="iobtnnumeric">0</a></td>
	<td></td>
</tr>
<tr>
	<td colspan=3 align=center>
	<a href="javascript:void(null);" onclick="localsubmit();" class="iobtngreen">ตกลง</a>
	<a href="javascript:void(null);" onclick="localreset();" class="iobtnorange">ยกเลิก</a>
	</td>
</tr>
</table>

</div></center>

	<script type="text/javascript">

function localkeypad (wh){
	var tmpip1=top.getobj("input1");
	tmpip1.value=tmpip1.value+wh.toString();
	var tmp=getobj("tmpmasked");
	tmp.innerHTML=tmp.innerHTML+"*";
}
function localreset(wh){
	var tmpip1=top.getobj("input1");
	tmpip1.value="";
	var tmp=getobj("tmpmasked");
	tmp.innerHTML="";
}
function localsubmit(){
	top.local_handleform();
}

</script>
