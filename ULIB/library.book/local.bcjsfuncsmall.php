<?php 
//พ
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

	if (keynum==13) {
		 wh.value=wh.value+','
		 return false;
	}

	if (keynum==36 || keynum==8 || keynum==35 || keynum==37 || keynum==38 || keynum==39 || keynum==40 || keynum==188) {
		 return true;
	}
	if ((keynum>=48 && keynum<=57) || (keynum<=105&&keynum>=96)) {
		
		return true;
	}
	return false;
}
function removethis(wh) {
		d=getobj(wh)
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
	newhtml=""+newhtml+"</nobr></span>"
	
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
						d.innerHTML=d.innerHTML+newhtml+"<BR>"
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
						
				 		getobj("text"+newid).focus();
						getobj("text"+newid).select();
 
}
//getobj("BCSOURCE").style.visibility="hidden";
//getobj("BCSOURCE").style.display="none";
</script>
<?php 

?>