<SCRIPT LANGUAGE="JavaScript">
<!-- /*พ*/
quicksearchmode="normalquicksearch";
quicksearchlen="10";
quicksearchaddword="yes";
quicksearchaddtaglist="yes";
quicksearchcurrentarrowid=0;
quicksearchcurrentvalue="";

function internaltextboxsuggestionarrow(e) {
if (!e) e=window.event;
	if ((e.charCode) && (e.keyCode==0))
	{
		code = e.charCode;
	} else {
		code = e.keyCode;
	}
	//alert(code);
	arrowing=0
	switch(code)
	  {
	  case 38:
		// Key up.
		arrowing=1
		if (getobj("SUGGESTEDSUB"+(quicksearchcurrentarrowid-1))) {
			quicksearchcurrentarrowid=quicksearchcurrentarrowid-1
		}
		break;
	  case 40:
		// Key down.
		arrowing=1
		if (getobj("SUGGESTEDSUB"+(quicksearchcurrentarrowid+1))) {
			quicksearchcurrentarrowid=quicksearchcurrentarrowid+1
		}
		break;

	  case 37:
		arrowing=1
		break;
	  case 38:
		arrowing=1
		break;

	  case 13: //enter
		if (getobj("SUGGESTEDSUB"+(quicksearchcurrentarrowid))) {
			quicksearchcurrentarrowid=quicksearchcurrentarrowid;
			tmp=getobj("SUGGESTEDSUB"+quicksearchcurrentarrowid);
			if(document.all){
				local_fillword2(tmp.innerText);
			} else{
				local_fillword2(tmp.textContent);
			}
		}
		break;

	 default:
       quicksearchcurrentarrowid=0;
		break;
	}

	if (arrowing==1) {
		//alert("SUGGESTEDSUB"+quicksearchcurrentarrowid);
		for (i=0; i<=20; i++) {
			if (getobj("SUGGESTEDSUB"+i))
			{
				tmp=getobj("SUGGESTEDSUB"+i);
				tmp.style.backgroundColor="";
			}
		}
		if (getobj("SUGGESTEDSUB"+quicksearchcurrentarrowid))
		{
			tmp=getobj("SUGGESTEDSUB"+quicksearchcurrentarrowid);
			tmp.style.backgroundColor="#99E89B";
		}
		else {
			//alert("noid "+quicksearchcurrentarrowid)
			//alert(getobj("INTERNALTEXTBOXKWSEARCHdsp").innerHTML);
		}
		return false;
	}
 }
function internaltextboxsuggestion(wh) {
	if (wh.value.length<=2) {
		tmp=getobj("INTERNALTEXTBOXKWSEARCHdsp");
		tmp.style.display="none";
		return;
	}
	if (wh.timeoutvalue!=undefined) {
	  clearTimeout(wh.timeoutvalue);
	}
	//alert(quicksearchcurrentvalue)
	if (quicksearchcurrentvalue==wh.value) {
		return;
	}
	wh.timeoutvalue=setTimeout("internaltextbodsuggestionaction('"+wh.value+"')",1100);
	//alert(wh.timeoutvalue);
}
function internaltextbodsuggestionaction(kw) {
	getobj('INTERNALTEXTBOXKWSEARCHsuggestor').src = 'webpage.inc.quicksearch.suggestor.php?kw='+(kw)+'&quicksearchmode='+quicksearchmode+"&quicksearchlen="+quicksearchlen+"&quicksearchaddword="+quicksearchaddword+"&quicksearchaddtaglist="+quicksearchaddtaglist
	//alert(kw);
}
function local_fillword(wh) {
	getobj('INTERNALTEXTBOXKWSEARCH').value=wh
	getobj('INTERNALTEXTBOXKWSEARCHdsp').style.display='none';
}
function local_fillword2(wh) {
	getobj('INTERNALTEXTBOXKWSEARCH').value=wh
	internaltextbodsuggestionaction(wh);
	getobj('INTERNALTEXTBOXKWSEARCH').focus();
	//alert(wh);
}
//-->
</SCRIPT>
<iframe width=100 height=100 style="display:none" name="INTERNALTEXTBOXKWSEARCHsuggestor" ID="INTERNALTEXTBOXKWSEARCHsuggestor"></iframe>

<div style="left: 347px; top: 1024px; width: 20px;display:none;position:absolute;
border-color: #6B6B6B; border-width: 1px; border-style: solid;
background-color: #F5F5F5
" class="" id="INTERNALTEXTBOXKWSEARCHdsp">

</div>