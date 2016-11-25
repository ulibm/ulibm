<?php  //พ
//echo barcodeval_get("oss-o-isopen"); die;
if (strtolower(barcodeval_get("oss-o-isopen"))!="yes") {
	redir($dcrURL); die;
}
mn_web("oss");
$tmpossmemid=$_memid;

?><style>

.myButton {
	
	-moz-box-shadow:inset 0px 1px 0px 0px #ffe0b5;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffe0b5;
	box-shadow:inset 0px 1px 0px 0px #ffe0b5;
	
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #fbb450), color-stop(1, #f89306));
	background:-moz-linear-gradient(top, #fbb450 5%, #f89306 100%);
	background:-webkit-linear-gradient(top, #fbb450 5%, #f89306 100%);
	background:-o-linear-gradient(top, #fbb450 5%, #f89306 100%);
	background:-ms-linear-gradient(top, #fbb450 5%, #f89306 100%);
	background:linear-gradient(to bottom, #fbb450 5%, #f89306 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fbb450', endColorstr='#f89306',GradientType=0);
	
	background-color:#fbb450;
	
	-moz-border-radius:7px;
	-webkit-border-radius:7px;
	border-radius:7px;
	
	border:1px solid #c97e1c;
	
	display:inline-block;
	color:#ffffff;
	font-family:Trebuchet MS;
	font-size:17px;
	font-weight:bold;
	padding:6px 11px;
	text-decoration:none;
	
	text-shadow:0px 1px 0px #8f7f24;
	
}
.myButton:hover {
	
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f89306), color-stop(1, #fbb450));
	background:-moz-linear-gradient(top, #f89306 5%, #fbb450 100%);
	background:-webkit-linear-gradient(top, #f89306 5%, #fbb450 100%);
	background:-o-linear-gradient(top, #f89306 5%, #fbb450 100%);
	background:-ms-linear-gradient(top, #f89306 5%, #fbb450 100%);
	background:linear-gradient(to bottom, #f89306 5%, #fbb450 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f89306', endColorstr='#fbb450',GradientType=0);
	
	background-color:#f89306;
}
.myButton:active {
	position:relative;
	top:1px;
}


div,font,td,span,b,a,i {
	font-size:14px;
}
</style>