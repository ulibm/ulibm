<?php

	?><center><form method="post" action="index.php">
	<input type="hidden" name="savesettings" value="yes">
	<?php 
   echo getlang("กรุณาระบุ URL แหล่งข้อมูล::l::Please enter source data for upgrade");
   ?><BR>
<input type="text" name="addonssetting_ulibtransdata_url" style='width:400px;' value="<?php  echo barcodeval_get("addonssetting_ulibtransdata_url");?>"><BR>
<font class=smaller2>http://website.com/ULIB/_ULIBTRANSDATA.php</font><BR>
		 <input type="submit" value="Save">
	</form>
   <BR><BR><a href=index.php class=a_btn><?php echo getlang("กลับ::l::Back");?></a>
   </center><?php 

foot();
die;
?>