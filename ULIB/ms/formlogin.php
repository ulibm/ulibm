<form action=mainadmin.php method=get  ID=mainform1
onsubmit="return submitform(this)" style="margin: 0 0 0 0; padding: 0 0 0 0;">
 <input type="hidden" name="fieldcode" value="<?php  echo $fieldcode?>" ID="fieldcode">
 <input type="hidden" name="use" value="<?php  echo $use?>" ID="use">
 <input type="hidden" name="gateid" value="<?php  echo $gateid?>" ID="gateid">
<table cellpadding=0 cellspacing=0 width=100% align="center" height=100% border=0>

<tr valign=middle> 

 <td align="center" style="background-color: #B9CBE1; background-image: url(bg.jpg); background-position: top left; padding-top: 5px;">
 <b><nobr>
 รหัสสมาชิก : </font></b>  <input ID="FC" type="text" name="useradminidx" size="30" class="unnamed1asd" 
 style="text-align:center"
 autocomplete=OFF >

<input style="font-size: 14; height: 24 " type=submit value="<?php  echo getlang("ตกลง::l::OK");?>" name="submit">
<?php 
 form_qrreader("
   tmpqr=getobj(\"FC\");
   tmpqr.value=data;
   tmpqrf=getobj('mainform1');
   submitform(tmpqrf);
   ");
?>
              </font></b></nobr>

</td>
</tr>

<SCRIPT LANGUAGE="JavaScript">
	  <!--
function submitform(wh) {
	parent.dspframe.location='mainadmin.php?useradminidx='+wh.useradminidx.value+"&fieldcode=<?php  echo $fieldcode?>&use=<?php  echo $use?>&gateid="+wh.gateid.value;
	wh.useradminidx.value='';
	wh.useradminidx.select();
	return false;
}
		getobj('FC').select()

          //-->

  </SCRIPT>
</table></form>
