<?php 
function ptp($wh) {
	global $useradminid;
	global $_TBWIDTH;
	global $memberbarcode;
	global $dts;
	global $spot;
	global $dte;
	global $id;
	global $bcode;
	global $rqid;
	global $dcrURL;
	html_start();
	$s=tmq("select * from printtemplate_sub where pid='$wh' ",false);
	?><table width=600 align=center class=table_border>
	<tr>
		<td  class=table_td align=center colspan=2> <?php 
	echo getlang("เลือกเทมเพลท::l::Choose Template");	
	?>	
	</td>
	</tr>
	<?php 
   $i=0;
	while ($r=tfa($s)) {
      $i++;
		//printr($r);
		$remembered=barcodeval_get("PTP-remember-$useradminid-".$wh."");
		$stylestr="";
		//echo $remembered."=".$r[code];
		if ($remembered==$r[code]) {
         $stylestr=" style='background-color: darkred;' ";
		}
		?><tr>
		<td  <?php  echo $stylestr; ?> class=table_td align=center>
		<form method="post" action="<?php  echo $dcrURL?>library.printtemplate/_preview.php" target=dsppdf <?php if ($i==1) { echo " id=firstptpform ";};?>>
			<input type="hidden" name="ptp_wh" value="<?php  echo $wh;?>">
			<input type="hidden" name="bcode" value="<?php  echo $bcode;?>">
			<input type="hidden" name="autoprint" value="no">
			<input type="hidden" name="compilevar" value="yes">
			<input type="hidden" name="pid" value="<?php  echo $r[code]?>">
			<input type="hidden" name="dts" value="<?php  echo $dts?>">
			<input type="hidden" name="spot" value="<?php  echo $spot?>">
			<input type="hidden" name="dte" value="<?php  echo $dte?>">
			<input type="hidden" name="fineid" value="<?php  echo $id?>">
			<input type="hidden" name="rqid" value="<?php  echo $rqid?>">
			<input type="hidden" name="memberbarcode" value="<?php  echo $memberbarcode?>">
			<input type="submit" value=" <?php  echo getlang($r[name])?> " style="width: 200px; font-size: 16px;"
			onclick="clearTimeout(settimeid);">
		</form>
		
		</td><td  <?php  echo $stylestr; ?> class=table_td align=center>
		
		<form method="post" action="<?php  echo $dcrURL?>library.printtemplate/_preview.php" id="FORMFOR<?php  echo $r[code]?>"  target=dsppdf>
			<input type="hidden" name="ptp_wh" value="<?php  echo $wh;?>">
			<input type="hidden" name="bcode" value="<?php  echo $bcode;?>">
			<input type="hidden" name="autoprint" value="yes">
			<input type="hidden" name="compilevar" value="yes">
			<input type="hidden" name="dts" value="<?php  echo $dts?>">
			<input type="hidden" name="dte" value="<?php  echo $dte?>">
			<input type="hidden" name="spot" value="<?php  echo $spot?>">
			<input type="hidden" name="pid" value="<?php  echo $r[code]?>">
			<input type="hidden" name="fineid" value="<?php  echo $id?>">
			<input type="hidden" name="rqid" value="<?php  echo $rqid?>">
			<input type="hidden" name="memberbarcode" value="<?php  echo $memberbarcode?>">
			<input type="submit" value=" <?php  echo getlang($r[name])?> (<?php  echo getlang("จำ::l::Remember");?>) " style="width: 200px; font-size: 16px;"
			onclick="clearTimeout(settimeid);">
		</form>
		
		<?php 
		if ($remembered==$r[code]) {
		?><tr><td></td><td align=center><div ID="dspfor<?php  echo $r[code];?>"></div></td></tr>
		<script>
		settimeid=0;
		function countdownprint(tims) {
         tmp=getobj("FORMFOR<?php  echo $r[code]?>");
   		tmpdsp=getobj("dspfor<?php  echo $r[code]?>");
   		if (tims>=0) {
           	settimeid=setTimeout("countdownprint("+(tims-100)+")",100);
           	tmpdsp.innerHTML="Autoprint in "+(tims/100);
   		} else {
            tmp.submit();
            //var PDF = getobj("dsppdf");
            //PDF.focus();
            //PDF.contentWindow.print();
           // self.close();
           window.onfocus=function(){ setTimeout("timeoutclose();",2000);}
   		}
   	}
      countdownprint(1500);
      
      function timeoutclose() {
         window.close();
      }
      
		</script>
		<?php 
      }
		?>
		</td>
	</tr><?php 
	}
	?>
	</table>
	<?php if (library_gotpermission("printtemplate")) {?>
	<center><strong><a href="<?php  echo $dcrURL?>library.printtemplate/" class=a_btn target=_top><?php  echo getlang("จัดการ::l::Manage");?></a></strong></center>
	<?php 
	}?>
	<center><iframe ID="dsppdf" name="dsppdf" style="width: <?php  echo $_TBWIDTH?>px; height:400px;"></iframe></center>
	<?php 
   if ($i==1 && trim(barcodeval_get("PTP-remember-$useradminid-".$wh.""))=="") { // print now if not remembered and have 1 type

      ?>
      <script>
      tmp=getobj('firstptpform');
      tmp.submit();
      </script>
      <?php
   }
}
?>