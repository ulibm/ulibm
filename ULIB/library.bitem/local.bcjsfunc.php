<?php  //พ

?><script >
function localbckeydown2(e,wh) {
	if(window.event) {// IE
     keynum = e.keyCode;
  } else if(e.which) {// Netscape/Firefox/Opera
    keynum = e.which;
  }
	if (keynum==13) {
		 return false;
	}
}
function localbckeydown(e,wh) {
	if(window.event) {// IE
     keynum = e.keyCode;
  } else if(e.which) {// Netscape/Firefox/Opera
    keynum = e.which;
  }
	//alert(keynum);
	if (keynum==46 || keynum==8 || keynum==37 || keynum==38 || keynum==39 || keynum==40) {
		 return true;
	}
 <?php 
 if ($_bcjsfunc_skipmulti!="yes") {
 ?>
	if (keynum==13) {
		 duplicatedb();
		 return false;
	}
	<?php 
}

	$allowedc2b=getval("catconfig","allowed_char2barcode");
	$allowedc2bi=0;
	$allowedc2bjs="false  ";
	while ($allowedc2bi<strlen($allowedc2b)) {
		$allowedc2bic=substr($allowedc2b,$allowedc2bi,1);
		$allowedc2bjs=$allowedc2bjs." || keynum==".ord($allowedc2bic);
		for ($i=0;$i<10;$i++) {
			if (floor(ord($allowedc2bic))==(48+$i)) {
				$allowedc2bjs=$allowedc2bjs." || keynum==".(96+$i);
			}
		}
		//echo ";".$allowedc2bic;
		$allowedc2bi=$allowedc2bi+1;
	}
	//echo $allowedc2bjs; die;
	?>
	if (<?php  echo $allowedc2bjs?>) 	{
		return true;
	} 
		return false;
}
function removethis(wh) {
		d=getobj(wh);
		d.innerHTML=""
		d.outerHTML="";
}



function duplicatedb(first,predefinedbc) {
				 s=getobj("BCSOURCE");
				 d=getobj("BCRESULT")
				 newhtml=s.innerHTML;
if (predefinedbc== null || predefinedbc==undefined || predefinedbc=="") {
   predefinedbc="";
}
	newhtml="<span ID='[RANDOMHERE]'><nobr>"+newhtml+"  ";
	if (first!="yes") {
		 newhtml=" "+newhtml+" <B onclick=\"removethis('[RANDOMHERE]')\"> <IMG SRC='../neoimg/red.gif' WIDTH=21 HEIGHT=21 BORDER=0 ></B>";
	}
	newhtml=""+newhtml+"</nobr><BR></span>"
	
	newid=Math.floor(Math.random()*1000000);
	newid="NEWITEM"+newid;
	
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);	
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);	
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);			
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);
	newhtml=newhtml.replace("[RANDOMHERE]",newid);	
		newhtml=newhtml.replace("[RANDOMHERE]",newid);			
	newhtml=newhtml.replace("REPLACETHIS","bcode");
	newhtml=newhtml.replace("REPLACETHIS","bcode");
	newhtml=newhtml.replace("REPLACETHIS","bcode");			
	newhtml=newhtml.replace("REPLACETHIS","bcode");			
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");						 
	newhtml=newhtml.replace("REPLACETABEAN","tabean");
	newhtml=newhtml.replace("REPLACETABEAN","tabean");
	newhtml=newhtml.replace("REPLACETABEAN","tabean");
	newhtml=newhtml.replace("REPLACETABEAN","tabean");			
	newhtml=newhtml.replace("REPLACECALLN","calln");
	newhtml=newhtml.replace("REPLACECALLN","calln");
	newhtml=newhtml.replace("REPLACECALLN","calln");			
	newhtml=newhtml.replace("REPLACECALLN","calln");			
	//alert(newhtml);
	//alert(d.innerHTML);
	tmpcb=document.getElementsByName("bcode[]"); //bc
	tmpcb1=document.getElementsByName("calln[]"); //callno
	tmpcb2=document.getElementsByName("tabean[]"); //tabean
	tmpcb3=document.getElementsByName("inumber[]"); //Copy
	var savemode=Array();
	var savemode1=Array();
	var savemode2=Array();
	var savemode3=Array();
	for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
		savemode[tmpcbx]=tmpcb[tmpcbx].value
		savemode1[tmpcbx]=tmpcb1[tmpcbx].value
		savemode2[tmpcbx]=tmpcb2[tmpcbx].value
		savemode3[tmpcbx]=tmpcb3[tmpcbx].value
	}

						d.innerHTML=d.innerHTML+newhtml+""
						startrunning++;
						<?php 
						if (strtolower(trim(getval("catconfig","isshowinumberfirstitem")))!="yes") {
							?>
							if (startrunning!=1) {
								 getobj("inumber"+newid).value="<?php  echo trim(getval("catconfig","inumbercode"));?>."+startrunning;
							}
							<?php 
						} else {
							?>
								 getobj("inumber"+newid).value="<?php  echo trim(getval("catconfig","inumbercode"));?>."+startrunning;
							<?php 
						}
						?>
for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
	if (savemode[tmpcbx]!=undefined) {
		tmpcb[tmpcbx].value=savemode[tmpcbx]
	}
	if (savemode1[tmpcbx]!=undefined) {
		tmpcb1[tmpcbx].value=savemode1[tmpcbx]
	}
	if (savemode2[tmpcbx]!=undefined) {
		tmpcb2[tmpcbx].value=savemode2[tmpcbx]
	}
	if (savemode3[tmpcbx]!=undefined) {
		tmpcb3[tmpcbx].value=savemode3[tmpcbx]
	}
}
				
						getobj("text"+newid).value=predefinedbc;
				 		getobj("text"+newid).focus();
						getobj("text"+newid).select();
if (predefinedbc== null || predefinedbc==undefined || predefinedbc=="") { } else {
   ///console.log("clicked "+newid);
   getobj('bcchecker'+newid).src='bccheck.php?bc='+predefinedbc;
}


 return false;
}
getobj("BCSOURCE").style.visibility="hidden";
getobj("BCSOURCE").style.display="none";

</script>
<?php 
if ($bcrunning!="yes") {
?><script>duplicatedb("yes");</script>
<?php } ?>