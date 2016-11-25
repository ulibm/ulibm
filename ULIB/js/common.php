<?php  //พ
header('Content-type: application/x-javascript');
include("../inc/config.inc.php");
?>

function getHTTPObject(type_mine) {
	http_request = false;
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if(http_request.overrideMimeType) {
			http_request.overrideMimeType(type_mine);
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
			http_request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}
	return http_request;
}

/*
function uajax(u,callback) {
	localxmlhttp=getHTTPObject('text/xml');
	//alert(rnd);
	localxmlhttp.onreadystatechange=function() {
		if (localxmlhttp.readyState==4 && localxmlhttp.status==200) {
			//alert(callback+"('"+localxmlhttp.responseText+"')");
			eval(callback+"('"+localxmlhttp.responseText+"')");
		} 
	}
	localxmlhttp.open("GET","<?php  echo $dcrURL?>globalpuller.php?charset=UTF-8&url="+u,true);
	localxmlhttp.send();
}*/
	var req_fifo=Array();
	var eleID=Array();
	var urlID=Array();
  var i=0;

  function GetAsyncData(url,callback) {
    eleID[i]=callback;
    if (window.XMLHttpRequest) 
    {
      req_fifo[i] = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) 
    {
      req_fifo[i] = new ActiveXObject("Microsoft.XMLHTTP");
    }
      req_fifo[i].abort();
      req_fifo[i].onreadystatechange = function(index){ return function() { GotAsyncData(index); }; }(i);
      req_fifo[i].open("GET", url, true);
      req_fifo[i].send(null);
      i++;
  }
  function GotAsyncData(id) {
    if (req_fifo[id].readyState != 4 || req_fifo[id].status != 200) {
      return;
    }
	/*
    document.getElementById(eleID[id]).innerHTML=
      req_fifo[id].responseText;
	  */
			//alert(eleID[id]+"('"+req_fifo[id].responseText+"')");
			eval(eleID[id]+"('"+req_fifo[id].responseText+"')");

    req_fifo[id]=null;
    eleID[id]=null;
    return;
  }


  function reget(id) {
    myid=eleID[id];
    url=urlID[id];
      req_fifo[id].abort();
      req_fifo[id].onreadystatechange = function(index){ return function() { GotAsyncData(index); }; }(id);
      req_fifo[id].open("GET", url, true);
      req_fifo[id].send(null);
  }

	function udecode(str0) {
		str0=""+str0+"";
		arrr=str0.split(":");
		rs="";
		for (i in arrr) {
			if (arrr[i]=="" || arrr[i]=="13" || arrr[i]=="10") {
				continue;
			}
			var tmp=arrr[i].toString();
			var tmp1=tmp.substring(0, 1);
			if (tmp1=="c") {
				var tmp2=tmp;
				var tmp2=tmp2.substring(1, tmp2.length);
				rs=rs+"a"+(tmp2)+"b";
			} else {
				if (arrr[i]==0) {
					continue;
				}
				rs=rs+String.fromCharCode(arrr[i]);
			}
		}

		res=rs;

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
		return ""+res+"";
	}

function uencode(str0) {
	
	res="";
	var i;
	for (i = 0; i < str0.length; i++) {
		res=res+":"+str0.charCodeAt(i)+"";
	}
	return res;
}

function MM_openBrWindow(theURL, winName, features)
    {         //v2.0
    ttop = 0  //(parseInt(screen.height)-410)/2
    tleft = 0 //(parseInt(screen.width)-400)/2
    window.open(theURL, winName, 'toolbar=no,location=yes,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=' + screen.width + ',height=' + (screen.height - 180) + ',top=0,left=0,addressbar=yes');
    return false;
    }

function numbersonly(){
//enter backspace delete
	if (event.keyCode==13 || event.keyCode==8 || event.keyCode==46) {
		return true;
	}
	if ((event.keyCode>=48 && event.keyCode<=57) || (event.keyCode<=105&&event.keyCode>=96)) {
		return true;
	}
	return false;
}

function getobj(the_id) {

	if (typeof the_id != 'string') {
		return the_id;
	}

	if (typeof document.getElementById != 'undefined') {
		return document.getElementById(the_id);
	} else if (typeof document.all != 'undefined') {
		return document.all[the_id];
	} else if (typeof document.layers != 'undefined') {
		return document.layers[the_id];
	} else {
		return null;
	}
}

function addslashes(str) {
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\0/g,'\\0');
	return str;
}
function stripslashes(str) {
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\\\/g,'\\');
	str=str.replace(/\\0/g,'\0');
	return str;
}




//CS1.1

var exclude=1;
var agt=navigator.userAgent.toLowerCase();
var win=0;var mac=0;var lin=1;
if(agt.indexOf('win')!=-1){win=1;lin=0;}
if(agt.indexOf('mac')!=-1){mac=1;lin=0;}
var lnx=0;if(lin){lnx=1;}
var ice=0;
var ie=0;var ie4=0;var ie5=0;var ie6=0;var com=0;var dcm;
var op5=0;var op6=0;var op7=0;
var ns4=0;var ns6=0;var ns7=0;var mz7=0;var kde=0;var saf=0;
if(typeof navigator.vendor!="undefined" && navigator.vendor=="KDE"){
	var thisKDE=agt;
	var splitKDE=thisKDE.split("konqueror/");
	var aKDE=splitKDE[1].split("; ");
	var KDEn=parseFloat(aKDE[0]);
	if(KDEn>=2.2){
		kde=1;
		ns6=1;
		exclude=0;
		}
	}
else if(agt.indexOf('webtv')!=-1){exclude=1;}
else if(typeof window.opera!="undefined"){
	exclude=0;
	if(/opera[\/ ][5]/.test(agt)){op5=1;}
	if(/opera[\/ ][6]/.test(agt)){op6=1;}
	if(/opera[\/ ][7-9]/.test(agt)){op7=1;}
	}
else if(typeof document.all!="undefined"&&!kde){
	exclude=0;
	ie=1;
	if(typeof document.getElementById!="undefined"){
		ie5=1;
		if(agt.indexOf("msie 6")!=-1){
			ie6=1;
			dcm=document.compatMode;
			if(dcm!="BackCompat"){com=1;}
			}
		}
	else{ie4=1;}
	}
else if(typeof document.getElementById!="undefined"){
	exclude=0;
	if(agt.indexOf("netscape/6")!=-1||agt.indexOf("netscape6")!=-1){ns6=1;}
	else if(agt.indexOf("netscape/7")!=-1||agt.indexOf("netscape7")!=-1){ns6=1;ns7=1;}
	else if(agt.indexOf("gecko")!=-1){ns6=1;mz7=1;}
	if(agt.indexOf("safari")!=-1 || (typeof document.childNodes!="undefined" && typeof document.all=="undefined" && typeof navigator.taintEnabled=="undefined")){mz7=0;ns6=1;saf=1;}
	}
else if((agt.indexOf('mozilla')!=-1)&&(parseInt(navigator.appVersion)>=4)){
	exclude=0;
	ns4=1;
	if(typeof navigator.mimeTypes['*']=="undefined"){
		exclude=1;
		ns4=0;
		}
	}
if(agt.indexOf('escape')!=-1){exclude=1;ns4=0;}
if(typeof navigator.__ice_version!="undefined"){exclude=1;ie4=0;}
/*
var returns Description 
   
	ie 1 Internet Explorer 4+ and IE-based third-party browsers. You can also be more specific:  
	ie4 0 ... Internet Explorer 4 only.  
	ie5 1 ... Internet Explorer 5 or 6.  
	ie6 0 ... Internet Explorer 6 only.  
	ns4 0 Netscape 4  
	ns6 0 Gecko and KDE-based browsers - which includes Netscape 6 and 7, Mozilla, Konqueror and Safari. You can also identify smaller groups within this: 
	ns7 0 ... Netscape 7.  
	mz7 0 ... any gecko browser except Netscape. This is principally designed to identify Mozilla's own builds from Version 0.6 onwards, but it also returns true for any other non-netscape gecko browser.  
	kde 0 ... Konqueror, from KDE 2.2 onwards.  
	saf 0 ... Safari. This variable will identify Safari irrespective of which browser it's set to identify as.  
	op5 0 Opera 5  
	op6 0 Opera 6  
	op7 0 Opera 7 
These variables will identify Opera irrespective of which browser it's set to identify as. 
Underpinning these is a safety variable, for protecting legacy browsers:
	exclude 0  
There are also three OS variables: 
	win 1 Windows  
	mac 0 Mac OS  
	lin 0 Linux, or anything else  
and you can query a lower-case version of the user agent string:
	agt mozilla/4.0 (compatible; msie 7.0; windows nt 5.1; .net clr 2.0.50727; .net clr 3.0.04506.30; .net clr 3.0.04506.648) 

*/

/*  COOKIE */
function deletecookie( name, path, domain ) {
if ( Get_Cookie( name ) ) document.cookie = name + "=" +
( ( path ) ? ";path=" + path : "") +
( ( domain ) ? ";domain=" + domain : "" ) +
";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}
	
function getcookie( check_name ) {

	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f

	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}

function setcookie( name, value, expires, path, domain, secure )
{
// set time, it's in milliseconds
var today = new Date();
today.setTime( today.getTime() );
/*
if the expires variable is set, make the correct
expires time, the current script below will set
it for x number of days, to make it for hours,
delete * 24, for minutes, delete * 60 * 24
*/
if ( !expires )
{
	expires = 7;
}
expires = expires * 1000 * 60 * 60 * 24;
var expires_date = new Date( today.getTime() + (expires) );
if (path==undefined) {
   path="/";
}
document.cookie = name + "=" +escape( value ) +
( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
( ( path ) ? ";path=" + path : "" ) +
( ( domain ) ? ";domain=" + domain : "" ) +
( ( secure ) ? ";secure" : "" );
}

function mytrim (str) {
    str = str.replace(/^\s+/, '');
    for (var i = str.length - 1; i >= 0; i--) {
        if (/\S/.test(str.charAt(i))) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    return str;
}

function addEvent(element, event, fn) {
	//addEvent(window, 'load', function(){ some_methods_1() });
	//addEvent(window, 'load', function(){ some_methods_2() });
    if (element.addEventListener)
        element.addEventListener(event, fn, false);
    else if (element.attachEvent)
        element.attachEvent('on' + event, fn);
}

function isiniframe () {
    try {
        return window.self !== window.top;
    } catch (e) {
        return true;
    }
}

//get windows size for further scripts
var ujswin, ujsd, ujse, ujsg, ujsw, ujsh;
function ulibglobalgetwinsize() {
 ujswin = window,
    ujsd = document,
    ujse = ujsd.documentElement,
    ujsg = ujsd.getElementsByTagName('body')[0],
    ujsw = ujswin.innerWidth || ujse.clientWidth || ujsg.clientWidth,
    ujsh = ujswin.innerHeight || ujse.clientHeight || ujsg.clientHeight;
//alert(ujsw + ' × ' + ujsh);
}

function ulibjs_getOffset( el ) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    return { top: _y, left: _x };
}
//var x = getOffset( document.getElementById('yourElId') ).left; 

