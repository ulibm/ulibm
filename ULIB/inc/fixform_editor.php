<?php 
function fixform_editor($wh,$tb,$condition,$html="",$options="") {
	global $PHP_SELF;
	global $startrow;
	global $ffteditid;
	if ($options[tablewidth]=="") {
		$options[tablewidth]="780";
	}
	?>
<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>">
<INPUT TYPE="hidden" NAME="ffe_wh" value="<?php  echo $wh?>">
<INPUT TYPE="hidden" NAME="ffe_tb" value="<?php  echo $tb?>">
<INPUT TYPE="hidden" NAME="ffteditid" value="<?php  echo $ffteditid?>">
<INPUT TYPE="hidden" NAME="ffe_condition" value="<?php  echo $condition?>">
<INPUT TYPE="hidden" NAME="startrow" value="<?php  echo $startrow?>">
<INPUT TYPE="hidden" NAME="ffe_issave" value="yes">
<TABLE width='<?php  echo $options[tablewidth]?>' align=center class=table_border>

<?php 
@reset ($wh); 
while (list ($key, $val) = @each ($wh)) { 
  // echo "$key => $val<br />\n";
	//printr($val); 
  fixform_editor_i($val,$tb);
} 	
$formabortid="f".randid();
?>
	<TR>
		<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value="<?php  echo getlang("บันทึกข้อมูล::l::Submit");?>"> 
		<a href="javascript:void(null);" onclick="tmp=getobj('<?php  echo $formabortid; ?>'); tmp.submit();"><?php  echo getlang("ยกเลิก::l::"); ?></a>
		<?php  echo $html;?></TD>
	</TR>
	
	</TABLE>
</FORM>

<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>" ID="<?php  echo $formabortid;?>">
<?php  echo $html;?>
</FORM>
	<?php 
}
?>