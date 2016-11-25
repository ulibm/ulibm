
<SCRIPT LANGUAGE="JavaScript">


	function mydecode(str0) {
		str0=""+str0+"";
		arrr=str0.split(":");
		//alert(str0);
		rs="";
		for (i in arrr) {
			if (arrr[i]=="" || arrr[i]=="13" || arrr[i]=="10") {
				continue;
			}
			//alert(arrr[i]);			return;
			var tmp=arrr[i].toString();
			var tmp1=tmp.substring(0, 1);
			//if (arrr[i] >= 161 && arrr[i] <= 250) {
			if (tmp1=="c") {
				//alert(tmp1); return;
				var tmp2=tmp;
				var tmp2=tmp2.substring(1, tmp2.length);
				rs=rs+"a"+(tmp2)+"b";
				//alert(rs);
				//return;
				//rs=rs+"a"+(arrr[i])+"b";
			} else {
				if (arrr[i]==0) {
					continue;
				}
				rs=rs+String.fromCharCode(arrr[i]);
			}
			//r=r+arrr[i]+"="+String.fromCharCode(arrr[i]);
		}

		res=rs.replace(/str_CallNumber/g,'<?php  echo getlang("เลขเรียก::l::Call Number");?>');
		res=res.replace(/str_barcode/g,'<?php  echo getlang("บาร์โค้ด::l::Barcode");?>');
		res=res.replace(/str_noitemforservice/g,'<?php  echo getlang("ไม่มีไอเทมให้บริการ");?>');
		res=res.replace(/str_noitem/g,'<?php  echo getlang("ไม่มีไอเทมให้บริการ::l::No item found");?>');
		res=res.replace(/str_no/g,'<?php  echo getlang("ลำดับที่::l::No.");?>');
		res=res.replace(/str_type/g,'<?php  echo getlang("ประเภท::l::Type");?>');
		res=res.replace(/str_shelf/g,'<?php  echo getlang("สถานที่::l::Shelf");?>');
		res=res.replace(/str_status/g,'<?php  echo getlang("สถานะ::l::Status");?>');
		res=res.replace(/str_chor/g,'<?php  echo getlang("ฉ");?>');
		res=res.replace(/str_item/g,'<?php  echo getlang("ไอเทม");?>');
		res=res.replace(/str_has/g,'<?php  echo getlang("มี");?>');
		res=res.replace(/str_avaiable4serv/g,'<?php  echo getlang("พร้อมให้บริการ");?>');
		res=res.replace(/str_allitemnotavai/g,'ทุกไอเทมพร้อมให้บริการ');
		res=res.replace(/str_and/g,'<?php  echo getlang("และ");?>');
		res=res.replace(/str_allitemavai/g,'<?php  echo getlang("ทุกไอเทมพร้อมให้บริการ");?>');
		//alert(rs);
		<?php /*
		for ($i=161;$i<=250;$i++) { ?>
			res=res.replace(/a<?php  echo $i;?>b/g,"<?php  echo iconvth(chr($i));?>");
		<?php 
		}	
*/		?>
					res=res.replace(/a161b/g,"ก");
					res=res.replace(/a162b/g,"ข");
					res=res.replace(/a163b/g,"ฃ");
					res=res.replace(/a164b/g,"ค");
					res=res.replace(/a165b/g,"ฅ");
					res=res.replace(/a166b/g,"ฆ");
					res=res.replace(/a167b/g,"ง");
					res=res.replace(/a168b/g,"จ");
					res=res.replace(/a169b/g,"ฉ");
					res=res.replace(/a170b/g,"ช");
					res=res.replace(/a171b/g,"ซ");
					res=res.replace(/a172b/g,"ฌ");
					res=res.replace(/a173b/g,"ญ");
					res=res.replace(/a174b/g,"ฎ");
					res=res.replace(/a175b/g,"ฏ");
					res=res.replace(/a176b/g,"ฐ");
					res=res.replace(/a177b/g,"ฑ");
					res=res.replace(/a178b/g,"ฒ");
					res=res.replace(/a179b/g,"ณ");
					res=res.replace(/a180b/g,"ด");
					res=res.replace(/a181b/g,"ต");
					res=res.replace(/a182b/g,"ถ");
					res=res.replace(/a183b/g,"ท");
					res=res.replace(/a184b/g,"ธ");
					res=res.replace(/a185b/g,"น");
					res=res.replace(/a186b/g,"บ");
					res=res.replace(/a187b/g,"ป");
					res=res.replace(/a188b/g,"ผ");
					res=res.replace(/a189b/g,"ฝ");
					res=res.replace(/a190b/g,"พ");
					res=res.replace(/a191b/g,"ฟ");
					res=res.replace(/a192b/g,"ภ");
					res=res.replace(/a193b/g,"ม");
					res=res.replace(/a194b/g,"ย");
					res=res.replace(/a195b/g,"ร");
					res=res.replace(/a196b/g,"ฤ");
					res=res.replace(/a197b/g,"ล");
					res=res.replace(/a198b/g,"ฦ");
					res=res.replace(/a199b/g,"ว");
					res=res.replace(/a200b/g,"ศ");
					res=res.replace(/a201b/g,"ษ");
					res=res.replace(/a202b/g,"ส");
					res=res.replace(/a203b/g,"ห");
					res=res.replace(/a204b/g,"ฬ");
					res=res.replace(/a205b/g,"อ");
					res=res.replace(/a206b/g,"ฮ");
					res=res.replace(/a207b/g,"ฯ");
					res=res.replace(/a208b/g,"ะ");
					res=res.replace(/a209b/g,"ั");
					res=res.replace(/a210b/g,"า");
					res=res.replace(/a211b/g,"ำ");
					res=res.replace(/a212b/g,"ิ");
					res=res.replace(/a213b/g,"ี");
					res=res.replace(/a214b/g,"ึ");
					res=res.replace(/a215b/g,"ื");
					res=res.replace(/a216b/g,"ุ");
					res=res.replace(/a217b/g,"ู");
					res=res.replace(/a218b/g,"ฺ");
					//res=res.replace(/a219b/g,"﻿");
					//res=res.replace(/a220b/g,"​");
					/*res=res.replace(/a221b/g,"–");
					res=res.replace(/a222b/g,"—");
					*/
					res=res.replace(/a219b/g,"");
					res=res.replace(/a220b/g,"");
					res=res.replace(/a221b/g,"");
					res=res.replace(/a222b/g,"");
					res=res.replace(/a223b/g,"฿");
					res=res.replace(/a224b/g,"เ");
					res=res.replace(/a225b/g,"แ");
					res=res.replace(/a226b/g,"โ");
					res=res.replace(/a227b/g,"ใ");
					res=res.replace(/a228b/g,"ไ");
					res=res.replace(/a229b/g,"ๅ");
					res=res.replace(/a230b/g,"ๆ");
					res=res.replace(/a231b/g,"็");
					res=res.replace(/a232b/g,"่");
					res=res.replace(/a233b/g,"้");
					res=res.replace(/a234b/g,"๊");
					res=res.replace(/a235b/g,"๋");
					res=res.replace(/a236b/g,"์");
					res=res.replace(/a237b/g,"ํ");
					res=res.replace(/a238b/g,"™");
					res=res.replace(/a239b/g,"๏");
					res=res.replace(/a240b/g,"๐");
					res=res.replace(/a241b/g,"๑");
					res=res.replace(/a242b/g,"๒");
					res=res.replace(/a243b/g,"๓");
					res=res.replace(/a244b/g,"๔");
					res=res.replace(/a245b/g,"๕");
					res=res.replace(/a246b/g,"๖");
					res=res.replace(/a247b/g,"๗");
					res=res.replace(/a248b/g,"๘");
					res=res.replace(/a249b/g,"๙");
					res=res.replace(/a250b/g,"®");

		<?php 
		for ($i=94;$i<=250;$i++) { 
			if ($i==129 || $i==130 || $i==219 || $i==220 || $i==221 || $i==222 || $i==131 || $i==132 || $i==133 || $i==134 || ($i>134 && $i<=161)) {
				?>res=res.replace(/a<?php  echo $i;?>b/g,"");
				<?php 
				continue;
			}
			?>
			res=res.replace(/a<?php  echo $i;?>b/g,"<?php  echo iconvth(chr($i));?>");
		<?php 
		}	
	?>
		//alert(res.substring(20,1));
		//alert(res);
		return ""+res+"";
	}

</SCRIPT>