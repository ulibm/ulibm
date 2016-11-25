<?php  
;
      include("inc/config.inc.php");
	  html_start();
	  pagesection("ULibM: แสดงเนื้อหาอิเล็กทรอนิกส์::l::ULibM: Displaying E-content","fulltext");
	  ?><CENTER><?php  
			$urlstat=explode('/',$url);
			//printr($urlstat);
		$mid=$urlstat[count($urlstat)-2];
		$chk=substr($url,0,strlen($dcrURL));
		//echo "[$url]";
		$codebtn=getlang("กลับหน้าหลัก::l::Back to homepage").",/$dcr/,gray,_top" ."::".
		getlang("ลบกรอบ::l::Full frame").",".urldecode($url).",green,_top"."::".
		getlang("ปิดหน้าต่าง::l::Close Window").",javascript:top.close(),red";
		//echo "[$chk-$dcrURL]";
		html_xpbtn($codebtn);
?></CENTER>