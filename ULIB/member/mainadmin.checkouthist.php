<?php 
$btnstr=getlang("หนังสือใกล้เคียง::l::Suggestion").",mainadmin.php?mempagemode=hist&submempagemode=histsuggest,gray,_top";
?><table cellpadding=0 cellspacing=0 border=0 align=center width=<?php echo $_TBWIDTH;?>>
<tr>
	<td><?php 
html_xpbtn($btnstr);
?></td>
</tr>
</table><?php 
$dsp[3][text]="วัสดุสารสนเทศ::l::Material";
$dsp[3][field]="foot";
$dsp[3][filter]="module:localmedia";
$dsp[3][width]="70%";


$dsp[7][text]="วันที่ยืม::l::Checkout date";
$dsp[7][field]="dt";
$dsp[7][filter]="datetime";
$dsp[7][width]="30%";

function localmedia($wh) {
    global $dcrURL;
		$pid=tmq("select * from media_mid where bcode='$wh[foot]' ",false);
		if (tmq_num_rows($pid)==0) {
			 return getlang("ไม่พบวัสดุสารสนเทศ รายการอาจถูกลบไปแล้ว::l::Material not found, deleted?");
		}
		$pid=tmq_fetch_array($pid);
		$wh="<a href='$dcrURL/dublin.php?ID=$pid[pid]&item=$wh[foot]' target=_blank>".marc_gettitle($pid[pid])."</a>";
		return $wh;
}
$tbname="stathist_checkout_member_media";
?><TABLE width=780 align=center>
<TR>
	<TD><?php 
fixform_tablelister($tbname," head='$_memid' ",$dsp,"no","no","no","mempagemode=$mempagemode&submempagemode=$submempagemode",$c,"dt desc");
?></TD>
</TR>
</TABLE>&nbsp;<?php 


?>