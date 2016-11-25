<?php 
header('Content-type: application/x-javascript');
include("../../inc/config.inc.php");// พ
//print_r($_SERVER);
?>
function ugreybox_go(wh){
	tmp=wh.attributes.rel.value;
	//alert("go to" +tmp);
	var thediv=getobj('ugreyboxtopdiv');
	thediv.style.display = "block";
	var thediv=getobj('ugreyboxpagebg');
	thediv.style.display = "table-cell";
	var thediv=getobj('ugreyboxpageIF');
	thediv.src= tmp;
	var thediv=getobj('ugreyboxpageHeadertext');
	thediv.innerHTML= wh.innerText ;
	return false;
}

function initalizeugreybox(){
//alert(initalizeugreybox);
   var closeasreload="no";
	var ugbas = document.getElementsByTagName("a");
	for (i = 0; i < ugbas.length; i++) {
		if (ugbas[i].attributes.rel) {
			if(ugbas[i].attributes.rel.value=="gb_page_fs[]"){
				var rel = ugbas[i].attributes.rel.value;
				var href = ugbas[i].attributes.href.value;
				//ugbas[i].style.color="#ff0000";
				ugbas[i].attributes.href.value="javascript:void(null);";
				ugbas[i].attributes.rel.value=href;
				/////////////////////////////////
				addEvent(ugbas[i], 'click', function(){ 
					ugreybox_go(this);					
					return false;
				});
				////////////////////////////////
				//relcloseasreload
				if (ugbas[i].attributes.relcloseasreload) {
				  closeasreload="yes";
				  //alert(1);
				}
			}
		}
	}

	//prepare frame
	var ugbtag=document.createElement('div');
	ugbtag.setAttribute("id", "ugreyboxtopdiv");
	document.getElementsByTagName('body')[0].appendChild(ugbtag);
	ugbobj=getobj("ugreyboxtopdiv");
	ugbobj.style.height="100%";
	ugbobj.style.width="100%";
	ugbobj.style.position="fixed";
	ugbobj.style.top="0px";
	ugbobj.style.left="0px";
	///ugbobj.style.overflow="hidden";
	ugbobj.style.zIndex="10000";
	ugbobj.style.verticalAlign="middle";
	if (closeasreload=="no") {
   	ugbobj.innerHTML='   <div ID="ugreyboxpagewrapper"><div ID="ugreyboxpageHeader"><div ID="ugreyboxpageHeadertext">Header</div> <div ID="ugreyboxclosebtn"><a href="javascript:void(null);" onclick="return ugreybox_hide();" style="color: darkred;">Close window</a></div></div><br><center><iframe src="<?php  echo $dcrURL?>library.webintropage/view.php" width=100% height=100% frameborder=0 scrolling=auto ID="ugreyboxpageIF"></iframe><br></center> </div>  <div id="ugreyboxpagebg">&nbsp;</div>';
	} else {	   
   	ugbobj.innerHTML='   <div ID="ugreyboxpagewrapper"><div ID="ugreyboxpageHeader"><div ID="ugreyboxpageHeadertext">Header</div> <div ID="ugreyboxclosebtn"><a href="javascript:top.location.reload();" onclick="" style="color: darkred;">Close window</a></div></div><br><center><iframe src="<?php  echo $dcrURL?>library.webintropage/view.php" width=100% height=100% frameborder=0 scrolling=auto ID="ugreyboxpageIF"></iframe><br></center> </div>  <div id="ugreyboxpagebg">&nbsp;</div>';
	}
	ugreybox_hide();
}

function ugreybox_hide(){
	var thediv=getobj('ugreyboxtopdiv');
	thediv.style.display = "none";
	var thediv=getobj('ugreyboxpagebg');
	thediv.style.display = "none";
	return false;
}

addEvent(window, 'load', function(){ initalizeugreybox() });
