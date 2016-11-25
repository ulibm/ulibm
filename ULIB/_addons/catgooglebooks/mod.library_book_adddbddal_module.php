<?php  
?>

<script type="text/javascript">
<!--
	function addonscatgooglebooksfunc() {
		tmp=getobj("addonscatgooglebooksif");
		tmpinput=getobj("addonscatgooglebooksinput");
		tmp.src="<?php  echo $dcrURL?>_addons/catgooglebooks/iframe.php?isn="+tmpinput.value;
		
	}
	function addonscatgooglebooksfunckw() {
		tmp=getobj("addonscatgooglebooksif");
		tmpinput=getobj("addonscatgooglebooksinput");
		tmp.src="<?php  echo $dcrURL?>_addons/catgooglebooks/iframe.php?kw="+tmpinput.value;
		
	}	
function localcheckEnter(e){
 e = e || event;
 var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
 return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
}
//-->
</script>


	<a href="javascript:void(null);" class="smaller a_btn" onclick="tmp=getobj('addonscatgooglebooks'); tmp.style.display='block';;"><?php  echo getlang("ดึงข้อมูลจาก Google Books::l::Get Data from Google Books");?></a>
<div ID="addonscatgooglebooks" style="background-color: white; position: absolute; top: 0px; left:0px; width: 100%; height: 100%;display:none; z-index: 100;"><center><?php 
	pagesection(getlang("ดึงข้อมูลจาก Google Books::l::Get Data from Google Books"));
?>
<?php  echo getlang("กรุณากรอก ISBN::l::ISBN");?><br>
   <input type=text ID=addonscatgooglebooksinput placeholder="put ISBN Here" onkeypress="return localcheckEnter();">
<br>
<a href="javascript:void(null);" class="a_btn bigger" style="" onclick="addonscatgooglebooksfunc(); ;"><?php  echo getlang("ตกลง::l::OK");?></a>
<a href="javascript:void(null);" class="a_btn" style="" onclick="addonscatgooglebooksfunckw(); ;"><?php  echo getlang("ค้นแบบคำค้น::l::Search as keyword");?></a>
<a href="javascript:void(null);" class="a_btn" onclick="tmp=getobj('addonscatgooglebooks'); tmp.style.display='none';;"><?php  echo getlang("ยกเลิก::l::Cancel");?></a>
<br><iframe width=600 height=300 ID=addonscatgooglebooksif></iframe>
</center></div>