
<script type="text/javascript">
<!--
	var keydownsearchboxtimer=0;
	function keydownsearchbox() {
		clearTimeout(keydownsearchboxtimer);
		keydownsearchboxtimer=setTimeout("keydownsearchbox_submit();",1000);
	}
	function keydownsearchbox_submit() {
		//hideSmartInputFloater();
		clearTimeout(keydownsearchboxtimer);
		tmp=getobj("singlesearchbox");
		search_KW=tmp.value;
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");
		search_KW=search_KW.replace("+","[[plussign]]");

		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		search_KW=search_KW.replace("-","[[minussign]]");
		S_INDEXCODE=getobj("S_INDEXCODE");
		//alert(tmp.value);
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?indexcode="+(S_INDEXCODE.options[S_INDEXCODE.selectedIndex].value)+"&KW="+search_KW+"";
	}
//-->
</script>
<script language="javascript"> 
function local_autosizeiframe(id) { 
	try { 
		frame = getobj(id); 
		frame.scrolling = "no"; 
		frame.scrolling = "no"; 
		innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document; 
		objToResize = (frame.style) ? frame.style : frame; 
		 tmpfrheight = innerDoc.body.scrollHeight;// + 2; 
		 if (tmpfrheight>1600) {
			// tmpfrheight=1600;
		 }
		 objToResize.height = tmpfrheight;
	} catch (e) { 
		window.status = e.message; 
	} 
} 
</script> 
<div id=ooo></div>
<style>
.csssgnofocus {
	color: #626d9d!important;
	font-size: 12px;
}
.csssgfocus {
	color: #ffffff!important;
	background-color: #26455b;
	font-size: 12px;
}
</style><script type="text/javascript">
<!--
maxsgbox=0;
focussgitem="no";
sglastword="";
focussgitemi=-1;
function local_directclicksgitem(item) {
		wh=getobj("singlesearchbox");
		tmpval=wh.value+" ";
		var lastIndex = tmpval.lastIndexOf(" ");
		var newval=tmpval.substring(0,lastIndex);
		var lastIndex = newval.lastIndexOf(" ");
		var newval=newval.substring(0,lastIndex);
		console.log(lastIndex+" /"+newval);
		try
		  {
		tmp=getobj("sgitem"+item);
		wh.value=newval+" "+tmp.innerHTML+" ";
		wh.focus();
		  }
		catch(err)
		  {
		  //Handle errors here
		  }
}
function local_searchkeytrap(e,wh) {
	keydownsearchbox();
	//tmp=getobj("ooo");
	//tmp.innerHTML=wh.value;
	var kk=e.keyCode? e.keyCode : e.charCode
	//alert(kk);
	if (kk==32) { //handle space (choose);
		tmpval=wh.value+"";
		var lastIndex = tmpval.lastIndexOf(" ");
		var newval=tmpval.substring(0,lastIndex);
		var lastIndex = newval.lastIndexOf(" ");
		var newval=newval.substring(0,lastIndex);
		//console.log(lastIndex+" /"+newval);
			try
		  {
		tmp=getobj("sgitem"+focussgitemi);
		wh.value=newval+" "+tmp.innerHTML;
		  }
		catch(err)
		  {
		  //Handle errors here
		  }
	}
	if (kk==40) { //handle down
		if (focussgitemi==-1) 	{
			//focussgitemi=0;
		}
		focussgitem="yes";
		focussgitemi=focussgitemi+1;
		if (focussgitemi>maxsgbox) {
			focussgitemi=maxsgbox;
		}
		if (focussgitemi<0) {
			focussgitemi=0;
		}
		local_searchsghilight();
	}
	if (kk==38) { //handle up
		if (focussgitemi==-1) 	{
			focussgitemi=0;
		}
		focussgitem="yes";
		focussgitemi=focussgitemi-1;
		if (focussgitemi<0) {
			focussgitemi=0;
		}
		if (focussgitemi>maxsgbox) {
			focussgitemi=maxsgbox;
		}
		local_searchsghilight();
	}
	if (sglastword==wh.value) {
		return false;
	}
	sglastword=wh.value;
	xmlhttp=getHTTPObject();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			tmp=getobj("ooo");
			tmpstrres=xmlhttp.responseText+"";
			tmpstrres=""+udecode(tmpstrres)+"";
			//tmp.innerHTML=tmp.innerHTML+"<br>"+tmpstrres;
			local_extractsearchsuggest(tmpstrres);
			focussgitem="no";
		}
	}
	//tmp.innerHTML=tmp.innerHTML+"<br><?php  echo $dcrURL; ?>webbox/searching.misc/searchsuggest.php?str="+encodeURIComponent(wh.value)+"";
	xmlhttp.open("GET","<?php  echo $dcrURL; ?>webbox/searching.misc/searchsuggest.php?str="+encodeURIComponent(wh.value),true);
	xmlhttp.send();

}
function local_extractsearchsuggest(str) {
	tmpdiv=getobj("S_SUGGEST");
	stra=str.split(":::");
	tmpdiv.innerHTML="";
	var arrayLength = stra.length;
	for (var i = 0; i < arrayLength; i++) {
		if (i>10) {
			return;
		}
		maxsgbox=i;
		tmp=stra[i];
		tmpdiv.innerHTML=tmpdiv.innerHTML+"  <a href='javascript:void(null);' onclick='local_directclicksgitem("+i+")' ID='sgitem"+i+"' class='csssgnofocus'>"+tmp+"</a>" ;
	}
	focussgitemi=-1;
	local_searchsghilight();
}
function local_searchsghilight() {
	//console.log(focussgitemi);
	for (var i = 0; i <= maxsgbox; i++) {
		tmp=getobj("sgitem"+i);
		tmp.className="csssgnofocus";
	}
	try
  {
	tmp=getobj("sgitem"+focussgitemi);
	tmp.className ="csssgfocus";
  }
catch(err)
  {
  //Handle errors here
  }
}
//-->
</script>
<?php //echo("[$KW]");?>
<form method="post" action="index.php" onsubmit="keydownsearchbox_submit(); return false;" target="S_RESULT">
<input type="hidden" name="deftab" value="<?php  echo $deftab; ?>">
	<TABLE width=1000 align=center cellpadding=0 cellspacing=0 border=0>
	<TR valign=top>
		<td width=200><?php  local_edithtmlbtn("search6-leftofform","แทรก/แก้ไขเนื้อหา::l::Insert/edit html"); ?></td>
		<td align=center><?php  echo getlang("ป้อนคำค้น::l::Looking for");?> 
		<input ID="singlesearchbox" type="text" size="35" 
		style="width: 280px!important;"
		placeholder="<?php  echo getlang("ป้อนคำค้นที่นี่::l::Put Keyword Here");?>"
		name="KW" value="<?php  echo trim(($KW)); ?>" onkeyup="local_searchkeytrap(event,this);"
		/> 
		<?php 
		$sidx=tmq("select * from index_ctrl where searchable='yes' order by ordr",false);
		?>
		<select name="indexcode" ID="S_INDEXCODE">
			<?php 
			while ($sidxr=tfa($sidx)) {
				$sl="";
				if ($sidxr[code]=="kw"|| $sidxr[code]==$_REQUEST["indexcode"]) { $sl="selected";}
				echo "<option value='$sidxr[code]' $sl>".getlang($sidxr[name]);
			}
			?>
		</select>
		
		<input type="submit" value="Search">		
		<?php  local_edithtmlbtn("search6-belowsearchform","แทรก/แก้ไขเนื้อหา::l::Insert/edit html"); ?>
		<br><div ID=S_SUGGEST style="font-size: 12px; text-align: left;"></div>
		</td>
		<td width=200><div ID="markedsavedDIV" style="text-align: center" align=center><?php 
if (is_array($_SESSION[marked]) && count($_SESSION[marked])!=0) {
	?><a href='<?php echo $dcrURL?>webbox/searching.misc/exportmarked.php' target=S_RESULT class=smaller2><?php  echo getlang("ส่งออกรายการที่เลือกไว้ ::l::Export saved "); 
   echo count($_SESSION[marked]);
   echo getlang(" รายการ::l:: records");?></a><?php 
} 
if (count($historyviewbiblist)!=0) {
	?><a href='<?php echo $dcrURL?>webbox/searching.misc/recentviews.php' target=S_RESULT class=smaller2><?php  echo getlang("รายการที่คลิกดูเร็ว ๆ นี้ ::l::Recent views "); 
echo count($historyviewbiblist);
echo getlang(" รายการ::l:: records");?></a><?php 
}
		?></div>
<div ID="historyviewbiblistDIV" style="text-align: center" align=center><?php 
		$historyviewbiblist=sessionval_get("historyviewbiblist");
$historyviewbiblist=unserialize($historyviewbiblist);
$historyviewbiblist=arr_filter_remnull($historyviewbiblist);
if (count($historyviewbiblist)!=0) {
	?><a href='<?php echo $dcrURL?>webbox/searching.misc/recentviews.php' target=S_RESULT class=smaller2><?php  echo getlang("รายการที่คลิกดูเร็ว ๆ นี้ ::l::Recent views "); 
echo count($historyviewbiblist);
echo getlang(" รายการ::l:: records");?></a><?php 
}
		?></div><div ID="historysearchlistDIV" style="text-align: center" align=center>
<?php 
$localsearchhist=sessionval_get("localsearchhist");
$localsearchhist=unserialize($localsearchhist);
$localsearchhist=arr_filter_remnull($localsearchhist);
if (count($localsearchhist)!=0) {
?>
<a href='<?php echo $dcrURL?>webbox/searching.misc/recentsearch.php' target=S_RESULT class=smaller2><?php  echo getlang("ประวัติการสืบค้น ::l::Recent search "); ?></a>
<?php  } ?></div>		<?php 
//collection s
if (barcodeval_get("collections-showlink")=="yes") {
   ?><div class=smaller2>
   <a href="<?php  echo $dcrURL?>webbox/collections.php" class=smaller2>Collections</a> <?php 
	if (is_array($usecollection) && count($usecollection)>0 )	 {
		reset($usecollection);
		$tmpcoll="";
		while (list($collock,$collecv) = each($usecollection)) {
			if ($collecv=="yes") {
				$tmps=tmq("select * from collections where id='$collock' ");
				$tmps=tmq_fetch_array($tmps);
				$tmps[name]=getlang($tmps[name]);
				if ($tmps[name]!="") {
					$tmpcoll.=" ".$tmps[name];
				}
			}
		}
		$tmpcoll=trim($tmpcoll,'');
		$addstr=getlang("ขณะนี้เลือก::l:::Selected").$tmpcoll;
		echo $addstr;
	}
	?></div><?php 
}
//collection e
	if (loginchk_lib('check')==true) {
		include($dcrs."webbox/adminmenu.php");
	}
	local_edithtmlbtn("search6-rightofform","แทรก/แก้ไขเนื้อหา::l::Insert/edit html"); ?></td>
	</tr>
</table>
</form>
<TABLE width=1000 align=center cellpadding=0 cellspacing=0 border=0>
	<TR valign=top>
		<td width=200> 
<?php  local_edithtmlbtn("search6-before-filter","แทรก/แก้ไขเนื้อหา::l::Insert/edit html"); ?>
    <div ID=FILTERDSP style="padding-left: 3px; width: 198px;">

</div>
<?php  include($dcrs."webbox/searching.misc/searchcloud.php");?>
<?php  local_edithtmlbtn("search6-after-filter","แทรก/แก้ไขเนื้อหา::l::Insert/edit html"); ?></td>
		<td><iframe FRAMEBORDER=NO name="S_RESULT" ID="S_RESULT" width=800 style="border: 0px solid red; min-height: 500px;"
		scrolling=NO  onload="local_autosizeiframe('S_RESULT')" src="<?php echo $dcrURL?>webbox/searching.misc/search_welcome.php"></iframe></td>
	</tr>
</table>
<script type="text/javascript">
<!--
setInterval("local_autosizeiframe('S_RESULT')",500);

	if ("<?php  echo $_GET[KW];?>"!="" && "<?php  echo $KW?>"!="") {
		keydownsearchbox_submit();
	}
//-->
</script>
<script>
setInterval("local_autosizeiframe('S_RESULT')",500);
//document.getElementById("wickStatus").innerHTML = '<a target="_blank" href="./sample_data.js">Loaded <b>' + collection.length + '</b> Sample Addresses</a>';
</script>


<script type="text/javascript">
<!--
	function local_localsearchhistupdate(data) {
		tmp=getobj('historysearchlistDIV');
		if (data=="resetall") {
			tmp.innerHTML="";
		} else {
			tmp.innerHTML="<a href='<?php echo $dcrURL?>webbox/searching.misc/recentsearch.php' target=S_RESULT class=smaller2><?php  echo getlang("ประวัติการสืบค้น ::l::Recent search "); ?></a>";
		}
	}
	function local_histupdate(data) {
		tmp=getobj('historyviewbiblistDIV');
		if (data=="resetall") {
			tmp.innerHTML="";
		} else {
			tmp.innerHTML="<a href='<?php echo $dcrURL?>webbox/searching.misc/recentviews.php' target=S_RESULT class=smaller2><?php  echo getlang("รายการที่คลิกดูเร็ว ๆ นี้ ::l::Recent views "); ?>" + data+" <?php echo getlang("รายการ::l::records");?></a>";
		}
	}	
	var search_KW="";
	var search_indexcode="";
	var search_yea_s=0;
	var search_yea_e=0;
	function local_filterupdate(data,det,det2,det3,det4) {

		tmp=getobj('FILTERDSP');
		if (data=="setsearchindex") {
			search_indexcode=det;
		}
		if (data=="setsearchkw") {
			search_KW=det;
		}

		if (data=="clear") {
			tmp.innerHTML="";
			//tmp.innerHTML=tmp.innerHTML+"search_KW="+search_KW+"<br>";
			//tmp.innerHTML=tmp.innerHTML+"search_indexcode="+search_indexcode+"<br>";
		}
		if (data=="resetall") {
			tmp.innerHTML=tmp.innerHTML+"<a class=smaller  href='javascript:void(null);' onclick=\"local_haltloading();local_submitresetfilter()\"><?php  echo getlang("ล้างตัวเลือกทั้งหมด::l::Reset all");?></a><br>";
		}
		if (data=="addheader") {
			tmp.innerHTML=tmp.innerHTML+"<b class=smaller>"+det+"</b><br>";
		}
		if (data=="addsearchoption_single") {
			tmp.innerHTML=tmp.innerHTML+"<a class=smaller href='javascript:void(null);' onclick=\"local_haltloading();local_submitsearch('"+det2+"')\">"+det+"</a><br>";
		}
		if (data=="addsearchoption") {
			tmp.innerHTML=tmp.innerHTML+"<a class=smaller href='javascript:void(null);' onclick=\"local_haltloading();local_submitsearch_filter('"+det2+"','"+det3+"')\">"+det+"</a><br>";
		}
		if (data=="addyearoption") {
			if (Math.floor(det3)==0) {
				search_yea_s=Math.floor(det);
				det3=det;
			} else {
				search_yea_s=Math.floor(det3);
			}
			if (Math.floor(det4)==0) {
				det4=det2;
				search_yea_s=Math.floor(det2);
			} else {
				search_yea_s=Math.floor(det4);
			}
			tmp.innerHTML=tmp.innerHTML+"<font class=smaller>";
			tmp.innerHTML=tmp.innerHTML+"<?php  echo getlang("เริ่มจาก::l::From");?> <div ID=yearranges style='display:inline; ' class=smaller>"+det3+"</div> <div ID=yearranges2 style='display:inline;color: #999999' class=smaller >"+(parseInt(det3)-543)+"</div><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td class=smaller2 width=32>"+det+"</td><td><input type=\"range\" onmouseup=\"local_yearranges(this);\" id=\"yranges\" value='"+det3+"' min=\""+det+"\" max=\""+det2+"\"  style='width: 120px;' class=input_rangetype oninput=\"local_showrangevals(this.value)\" ></td><td class=smaller2 width=32>"+det2+"</td></tr></table>";
			tmp.innerHTML=tmp.innerHTML+"<?php  echo getlang("ถึงปี::l::to");?> <div ID=yearrangee style='display:inline' class=smaller>"+det4+"</div> <div ID=yearrangee2 style='display:inline;color: #999999' class=smaller >"+(parseInt(det4)-543)+"</div><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td class=smaller2 width=32>"+det+"</td><td><input type=\"range\" onmouseup=\"local_yearrangee(this);\" id=\"yrangee\" value='"+det4+"' min=\""+det+"\" max=\""+det2+"\"  style='width: 120px;' class=input_rangetype oninput=\"local_showrangevale(this.value)\"></td><td class=smaller2 width=32>"+det2+"</td></tr></table>";
			tmp.innerHTML=tmp.innerHTML+"</font>";
         
		}
		if (data=="addyearoptiongraph") {
      	tmpgraphstr="<table width=100% border=0 cellspacing=0 cellpadding=0><tr valign=bottom><td width=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
         yeara=det.split(";"); 
         maxnuminyear=yeara[0];
         yearall=yeara[1];
         yearallloop=yearall.split(":");
         graphmaxh=30;
         for (i = 0; i < yearallloop.length; i++) { 
            localtmpval=yearallloop[i].split("=");
            thisval=(localtmpval[1]/maxnuminyear)*100;
            thisval=Math.floor(thisval);
            thisval=thisval/100;
            tmpgraphstr+="<td > ";
            tmpgraphstr+="<div onmouseover='localdspyearinfo("+localtmpval[0]+","+localtmpval[1]+")' onmouseout='localdspyearinfo_clear()' style='display:block;;height:"+(Math.floor(thisval*graphmaxh)+5)+"px; background-color: gray; width: 100%; float: left;' > </div> ";
            tmpgraphstr+="</td>";
        }

			tmpgraphstr+="<td width=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>";
			tmpgraphstr+="<table width=100%><tr><td align=center colspan=3><div id='localdspyearinfodiv' style='text-align: center; font-size: 10px!important;' ></div></td></tr></table>";
			tmp.innerHTML+=tmpgraphstr;

      }
		//alert(1);
	}
   function localdspyearinfo(y,cc) {
      tmp=getobj("localdspyearinfodiv");
      tmp.innerHTML=y+ " = " + cc;
   }
   function localdspyearinfo_clear() {
      tmp=getobj("localdspyearinfodiv");
      tmp.innerHTML="";
   }
	function local_submitsearch(whidx) {
		local_haltloading();
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?indexcode="+whidx+"&KW="+search_KW+"";
	}
	function local_submitresetfilter() {
		local_haltloading();
		tmp=getobj("singlesearchbox");
		S_INDEXCODE=getobj("S_INDEXCODE");
		//alert(tmp.value);
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?resetfilter=yes&indexcode="+(S_INDEXCODE.options[S_INDEXCODE.selectedIndex].value)+"&KW="+tmp.value+"";
	}
	function local_submitsearch_filter(searchmodule,classid) {
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?searchfilter["+searchmodule+"]="+classid+"&indexcode="+search_indexcode+"&KW="+search_KW+"";
	}
	function local_showrangevals(wh) {
		tmp=getobj("yearranges");
		tmp.innerHTML=wh;
		tmpX=getobj("yearranges2");
		tmpX.innerHTML=parseInt(wh)-543;
	}
	function local_showrangevale(wh) {
		tmp=getobj("yearrangee");
		tmp.innerHTML=wh;
		tmpX=getobj("yearrangee2");
		tmpX.innerHTML=parseInt(wh)-543;
	}
	function local_yearranges(wh) {
		tmp=getobj("yearranges");
		tmp.innerHTML=wh.value;
		tmpX=getobj("yearranges2");
		tmpX.innerHTML=parseInt(wh.value)-543;
		tmp2=getobj("yrangee");
		if (parseInt(wh.value)>parseInt(tmp2.value)) {
			tmp2.value=wh.value;
			//return false;
		}
		local_haltloading();
		search_yea_s=parseInt(wh.value);
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?set_yea_start="+wh.value+"&set_yea_end="+tmp2.value+"&indexcode="+search_indexcode+"&KW="+search_KW+"";

	}
	function local_yearrangee(wh) {
		tmp=getobj("yearrangee");
		tmpX=getobj("yearrangee2");
		tmpX.innerHTML=parseInt(wh.value)-543;
		tmp2=getobj("yranges");
		tmp.innerHTML=wh.value;
		search_yea_e=wh.value;
		if (parseInt(wh.value)<parseInt(tmp2.value)) {
			tmp2.value=wh.value;
			//return false;
		}
		local_haltloading();
		tmpresult=getobj("S_RESULT");
		tmpresult.src="<?php  echo $dcrURL?>webbox/searching.misc/search.php?set_yea_end="+wh.value+"&set_yea_start="+tmp2.value+"&indexcode="+search_indexcode+"&KW="+search_KW+"";
	}

	function local_haltloading() {
		tmp=getobj('FILTERDSP');
		tmp.innerHTML="<center><img src='<?php  echo $dcrURL?>webbox/loading_animation.gif'><BR><?php  echo getlang("กำลังปรับใช้ตัวเลือก::l::Applying Filters");?>";
	}
	function local_directfromsearchif(searchkw) {
		local_haltloading();
		tmp=getobj("singlesearchbox");
		//alert(searchkw);
		tmp.value=searchkw;
		keydownsearchbox_submit();
	}
//-->
</script>



<?php 
$lookingforindex="";

//pass through check
$MSUBJECT=trim($MSUBJECT);
if ($MSUBJECT!="") {
	$lookingforindex="su";
	$searchfor=$MSUBJECT;
}
$MAUTHOR=trim($MAUTHOR);
if ($MAUTHOR!="") {
	$lookingforindex="au";
	$searchfor=$MAUTHOR;
}
$MCALLNUM=trim($MCALLNUM);
if ($MCALLNUM!="") {
	$lookingforindex="calln";
	$searchfor=$MCALLNUM;
}
$MDESCRIPTION=trim($MDESCRIPTION);
if ($MDESCRIPTION!="") {
	$lookingforindex="kw";
	$searchfor=$MDESCRIPTION;
}
$MISBN=trim($MISBN);
if ($MISBN!="") {
	$lookingforindex="ISBN";
	$searchfor=$MISBN;
}
$MTITLE=trim($MTITLE);
if ($MTITLE!="") {
	$lookingforindex="ti";
	$searchfor=$MTITLE;
}
if ($lookingforindex!="") {
	?>
	<script type="text/javascript">
	<!--
		tmp=getobj("singlesearchbox");
		tmp.value="<?php  echo ($searchfor); ?>";
		tmp2=getobj("S_INDEXCODE");		
		var txt = "";
		for (var i=0; i<tmp2.length; i++) {
			if (tmp2.options[i].value=="<?php  echo $lookingforindex; ?>") {
				tmp2.selectedIndex=i;
				break;
			}
		}
		keydownsearchbox_submit();
	//-->
	</script><?php 
}
stat_add("visithp_type","searchmodule");

?>