<?php 
		header("Content-Type: text/css");
        include ("../../inc/config.inc.php");// พ
?>
#ugreyboxpage {
	z-index: 10001;
    margin: 0px 0px 0px 0px;
	/*background-color:#ffffff;*/
	position: fixed; top:0px; left:0px; width:100%; height:100%; color:#FFFFFF; 
	text-align: center; 
	vertical-align: middle;
}
#ugreyboxpagewrapper {
	vertical-align: middle;
	border: white solid 5px;
	-webkit-box-shadow: -1px -1px 20px 0px rgba(50, 50, 50, 0.75);
	-moz-box-shadow:    -1px -1px 20px 0px rgba(50, 50, 50, 0.75);
	box-shadow: -1px -1px 20px 0px rgba(50, 50, 50, 0.75);
	margin: 20px 20px 20px 20px;
	width: calc(100% - 50px);
	height: calc(100% - 50px);
}
#ugreyboxpageHeader {
	background-color: white;
	font-size: 18px;
	border: 0px solid black;
	border-bottom-width: 1px;
	width: calc(100% - 10px);
	padding-left: 10px;
	display: inline-block;
}
#ugreyboxpagebg {
	height: 100%;  
	position: absolute;  
	overflow: hidden;  
	width: 100%; top: 0px; 
	left: 0px;	
	filter: alpha(opacity=90); 	
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=90);
	-moz-opacity: .90; 
	-khtml-opacity: 0.9; opacity: 0.9; 
	background-color: #ffffff;
	z-index: -1;
	bottom: 0px;
	min-height: 100%;
}
#ugreyboxclosebtn {
	width: 150px;
	float: right;
	text-align: right;
	color: darkred;
}
#ugreyboxpageHeadertext {
	display: inline;
}
#ugreyboxpageIF {
	height: calc(100% - 20px);
}