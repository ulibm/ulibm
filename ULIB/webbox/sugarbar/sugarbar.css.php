<?php
include("../../inc/config.inc.php");
?>.sugarbar{
	width: 100%;
	top: -100%;
	left: 0;
	position: fixed;
	background: #<?php  echo barcodeval_get("webboxoptions-topmenu_barcolor");?>;
	color: white;
	padding-right: 7px;
	z-index: 100;
	transition: all 0.5s;
	box-shadow: 0 5px 5px rgba(0,0,0,.3);
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.sugarbar a{
	color: lightyellow;
}

.sugarclose{
	float: right;
	cursor: pointer;
	-webkit-user-select: none; /* disable chrome touch-to-search */
}