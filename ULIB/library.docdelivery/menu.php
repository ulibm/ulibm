<style type="text/css">
.arrowyello{
	width: 180px; /*width of menu*/
	border-style: solid solid none solid;
	border-color: #94AA74;
	border-size: 1px;
	border-width: 1px;
}
.arrowyello ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}	
.arrowyello li a{
	font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	display: block;
	background: transparent url(arrowyellow.gif) 100% 0;
	  height: 24px; /*Set to height of bg image- padding within link (ie: 32px - 4px - 4px)*/
	padding: 4px 0 4px 10px;
	line-height: 24px; /*Set line-height of bg image- padding within link (ie: 32px - 4px - 4px)*/
	text-decoration: none;
}	
.arrowyello li a:link, .arrowyello li a:visited {
	color: #2a2a2a;
}
.arrowyello li a:hover{
	color: #26370A;
	background-position: 100% -32px;
}	
.arrowyello li a.selected{
	color: #26370A;
	background-position: 100% -64px;
}
</style>

<style type="text/css">
.arrowgreen{
	width: 180px; /*width of menu*/
	border-style: solid solid none solid;
	border-color: #94AA74;
	border-size: 1px;
	border-width: 1px;
}
.arrowgreen ul{
	list-style-type: none;
	margin: 0;
	padding: 0;
}	
.arrowgreen li a{
	font: bold 12px Verdana, Arial, Helvetica, sans-serif;
	display: block;
	background: transparent url(arrowgreen.gif) 100% 0;
	  height: 24px; /*Set to height of bg image- padding within link (ie: 32px - 4px - 4px)*/
	padding: 4px 0 4px 10px;
	line-height: 24px; /*Set line-height of bg image- padding within link (ie: 32px - 4px - 4px)*/
	text-decoration: none;
}	
.arrowgreen li a:link, .arrowgreen li a:visited {
	color: #2a2a2a;
}
.arrowgreen li a:hover{
	color: #26370A;
	background-position: 100% -32px;
}	
.arrowgreen li a.selected{
	color: #26370A;
	background-position: 100% -64px;
}
</style>
<?php ?>
	<?php  
	$jsstyleall="";
	$jsstylealla="";
	if (library_gotpermission("docdelivery_manager")) {
		$maxmenu=4;
		for ($i=1;$i<=$maxmenu;$i++) {
			$jsstylealla=$jsstylealla."tmp=getobj('mna$i');tmp.className='';";
		}
	}
	$maxmenu=2;
	for ($i=1;$i<=$maxmenu;$i++) {
		$jsstyleall=$jsstyleall."tmp=getobj('mn$i');tmp.className='';";
	}
	?>
<div class="arrowgreen">
	<ul>
	<?php  
	?>
		<li><a ID=mn1 onclick="<?php  echo $jsstyleall.$jsstylealla;?>this.className='selected'; " target=mainframe href="inbox.php" class="selected"><?php  echo getlang("เอกสารที่ได้รับ::l::My Documents");?></a></li>
		<li><a ID=mn2 onclick="<?php  echo $jsstyleall.$jsstylealla?>this.className='selected'; " target=mainframe href="inbox.php?viewbin=yes" ><?php  echo getlang("ถังขยะ::l::Bin");?></a></li>
	</ul>
</div>
<?php 
	if (library_gotpermission("docdelivery_manager")) {
	?><div class="arrowyello">
	<ul>

		<li><a ID=mna4 onclick="<?php  echo $jsstylealla.$jsstyleall?>this.className='selected'; " target=mainframe href="docs.php" style="font-size: 18px;"><?php  echo getlang("ระบบเอกสาร::l::Documents");?></a></li>
		<li><a ID=mna1 onclick="<?php  echo $jsstylealla.$jsstyleall?>this.className='selected'; " target=mainframe href="office.php" ><?php  echo getlang("จัดการฝ่าย::l::Manage Offices");?></a></li>
		<li><a ID=mna2 onclick="<?php  echo $jsstylealla.$jsstyleall?>this.className='selected'; " target=mainframe href="person.php" ><?php  echo getlang("จัดการผู้รับเอกสาร::l::Manage Reciever");?></a></li>
		<li><a ID=mna3 onclick="<?php  echo $jsstylealla.$jsstyleall?>this.className='selected'; " target=mainframe href="doctype.php" ><?php  echo getlang("จัดการประเภทเอกสาร::l::Document TYpe");?></a></li>
		<!-- <li><a ID=mna4 onclick="<?php  echo $jsstylealla.$jsstyleall?>this.className='selected'; " target=mainframe href="resptype.php" ><?php  echo getlang("ประเภทการตอบรับ::l::Response Type");?></a></li> -->
	</ul>
</div>
<?php 
$tags=tmq("select * from docdelivery_readrule where tags<>'' and deleted='no' and loginid='$useradminid' ");
$tdata="";
while ($tagr=tfa($tags)) {
	$tdata.=",".$tagr[tags];
}
$tdata=trim($tdata," ,");
$tdata=str_replace(",,",",",$tdata);
$tdata=str_replace(",,",",",$tdata);
$tdata=str_replace(",,",",",$tdata);
$tdata=explode(",",$tdata);
$tdata=arr_filter_remnull($tdata);
//printr($tdata);
@reset($tdata);
while (list($k,$v)=each($tdata)) {
	?><a target=mainframe href="inbox.php?tags=<?php  echo stripslashes($v);?>"  onclick= "<?php  echo $jsstylealla.$jsstyleall?>tmp=getobj('mn1');tmp.className='selected';" class="smaller2 a_btn"><?php  echo stripslashes($v);?></a><?php 
}
		?>
<?php }?>
