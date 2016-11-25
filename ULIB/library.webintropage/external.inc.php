<?php 
//พ
$now=time();
	$showcase="select * from webpage_webintropage where  dtstart<=$now and dtend>=$now order by dt desc";
	$showcase=tmq($showcase,false);


if (tmq_num_rows($showcase)==0) {
	//die("-");
} else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<style>
#webintropage {
	z-index: 10001;

    margin: 0px 0px 0px 0px;
	/*background-color:#ffffff;*/
	position: fixed; top:0px; left:0px; width:100%; height:100%; color:#FFFFFF; 
	text-align: center; 
	vertical-align: middle;
}
</style>
<script>
function webintropage_show(){
	var thediv=getobj('webintropagebg');
	thediv.style.display = "table";
	var thediv=getobj('webintropage');
	thediv.style.display = "table";
	return false;
}
function webintropage_hide(){
	var thediv=getobj('webintropagebg');
	thediv.style.display = "none";
	var thediv=getobj('webintropage');
	thediv.style.display = "none";
	return false;
}
</script>
</head>
<body>
<div id="webintropage" style="display: none;  height: 100%;  position: absolute;  overflow: hidden;  width: 100%;">
  <div style="display: table-cell;  vertical-align: middle;">
    <div style="margin:0 auto;  "><iframe src="<?php  echo $dcrURL?>library.webintropage/view.php" width=800 height=500 frameborder=0 scrolling=no style="
		vertical-align: middle; border: white solid 20px; 
-webkit-box-shadow: -1px -1px 30px 0px rgba(50, 50, 50, 0.75);
-moz-box-shadow:    -1px -1px 30px 0px rgba(50, 50, 50, 0.75);
box-shadow:         -1px -1px 30px 0px rgba(50, 50, 50, 0.75);"></iframe>
	<br><br><a href='javascript:void(null);' onclick='return webintropage_hide();' style="color: black;">ENTER SITE</a></div>
  </div>
</div>
<div id="webintropagebg" style="display: none;  height: 100%;  position: absolute;  overflow: hidden;  width: 100%;z-index: 10000; top: 0px; left: 0px;
	filter: alpha(opacity=90); 	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=90); -moz-opacity: .90; 	-khtml-opacity: 0.9; opacity: 0.9; background-color: #ffffff">&nbsp;
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
	webipshowed=getcookie("webipshowed_c");
	//alert("["+webipshowed+"]");
	if (webipshowed+""!="yes") {
		webintropage_show();
		setcookie( "webipshowed_c", "yes");
	}
//-->
</SCRIPT>
       <div class="ribbon-wrapper-green" style="cursor: help;" onclick="webintropage_show();"><div class="ribbon-green">NEWS</div></div>
<style>
.ulibpage-wrap {
}

.ribbon-wrapper-green {
  width: 85px;
  height: 88px;
  overflow: hidden;
  position: absolute;
  top: -3px;
  right: -3px;
}

.ribbon-green {
  font: bold 15px Sans-Serif;
  color: #333;
  text-align: center;
  text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
  -webkit-transform: rotate(45deg);
  -moz-transform:    rotate(45deg);
  -ms-transform:     rotate(45deg);
  -o-transform:      rotate(45deg);
  position: relative;
  padding: 7px 0;
  left: -5px;
  top: 15px;
  width: 120px;
  background-color: #BFDC7A;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#BFDC7A), to(#8EBF45)); 
  background-image: -webkit-linear-gradient(top, #BFDC7A, #8EBF45); 
  background-image:    -moz-linear-gradient(top, #BFDC7A, #8EBF45); 
  background-image:     -ms-linear-gradient(top, #BFDC7A, #8EBF45); 
  background-image:      -o-linear-gradient(top, #BFDC7A, #8EBF45); 
  color: #6a6340;
  -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
  -moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
  box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
}

.ribbon-green:before, .ribbon-green:after {
  content: "";
  border-top:   3px solid #6e8900;   
  border-left:  3px solid transparent;
  border-right: 3px solid transparent;
  position:absolute;
  bottom: -3px;
}

.ribbon-green:before {
  left: 0;
}
.ribbon-green:after {
  right: 0;
}​
</style>
<?php 
}
?>