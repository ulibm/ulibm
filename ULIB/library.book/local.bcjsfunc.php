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
	?>
	/*
	if (keynum==36 || keynum==8 || keynum==35 || keynum==37 || keynum==38 || keynum==39 || keynum==40 || keynum==188) {
		 return true;
	}
	if ((keynum>=48 && keynum<=57) || (keynum<=105&&keynum>=96)) {
		return true;
	}
	return false;
	*/
			return true;
}
function removethis(wh) {
		d=getobj(wh);
		d.innerHTML=""
		d.outerHTML="";
}



function duplicatedb(first) {
				 s=getobj("BCSOURCE");
				 d=getobj("BCRESULT")
				 newhtml=s.innerHTML;

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
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");
	newhtml=newhtml.replace("REPLACEINUMMER","inumber");						 
	newhtml=newhtml.replace("REPLACETABEAN","tabean");
	newhtml=newhtml.replace("REPLACETABEAN","tabean");
	newhtml=newhtml.replace("REPLACETABEAN","tabean");			
	//alert(newhtml);
	//alert(d.innerHTML);
	tmpcb=document.getElementsByName("bcode[]"); //bc
	tmpcb2=document.getElementsByName("tabean[]"); //tabean
	tmpcb3=document.getElementsByName("inumber[]"); //Copy
	var savemode=Array();
	var savemode2=Array();
	var savemode3=Array();
	for (tmpcbx = 0; tmpcbx<tmpcb.length; tmpcbx++) {
		savemode[tmpcbx]=tmpcb[tmpcbx].value
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
	if (savemode2[tmpcbx]!=undefined) {
		tmpcb2[tmpcbx].value=savemode2[tmpcbx]
	}
	if (savemode3[tmpcbx]!=undefined) {
		tmpcb3[tmpcbx].value=savemode3[tmpcbx]
	}
}

	getobj("text"+newid).focus();
	getobj("text"+newid).select();
 return false;
}
getobj("BCSOURCE").style.visibility="hidden";
getobj("BCSOURCE").style.display="none";

</script>
<?php 

?><script>duplicatedb("yes");</script>