<?php  //พ
    function html_guidebtn($str) {
		global $html_guidebtn_iscalled;
		global $dcrURL;
		$str=trim($str,':');
		if ($html_guidebtn_iscalled=="") {
			?><style type="text/css">

/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */

a.ovalbutton{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-gray-left.gif') no-repeat top left;
	display: block;
	float: left;
	font: normal 13px Tahoma; /* Change 13px as desired */
	line-height: 16px; /* This value + 4px + 4px (top and bottom padding of SPAN) must equal height of button background (default is 24px) */
	height: 24px; /* Height of button background height */
	padding-left: 11px; /* Width of left menu image */
	text-decoration: none;
}

a:link.ovalbutton, a:visited.ovalbutton, a:active.ovalbutton{
	color: #000000; /*button text color*/
}

a.ovalbutton span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-gray-right.gif') no-repeat top right;
	display: block;
	padding: 4px 11px 4px 0; /*Set 11px below to match value of 'padding-left' value above*/
}

a.ovalbutton:hover{ /* Hover state CSS */
	background-position: bottom left;
}

a.ovalbutton:hover span{ /* Hover state CSS */
	background-position: bottom right;
	color: black;
}

.buttonwrapper{ /* Container you can use to surround a CSS button to clear float */
	overflow: hidden; /*See: http://www.quirksmode.org/css/clearing.html */
	width: 100%;
}

a.dark{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-dark-left.gif') no-repeat top left
}

a.dark span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-dark-right.gif') no-repeat top right;
}

a.green{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-green-left.gif') no-repeat top left
}

a.green span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-green-right.gif') no-repeat top right;
}

a.orange{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-orange-left.gif') no-repeat top left
}

a.orange span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-orange-right.gif') no-repeat top right;
}

a.blue{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-blue-left.gif') no-repeat top left
}

a.blue span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-blue-right.gif') no-repeat top right;
}

a.red{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-red-left.gif') no-repeat top left
}

a.red span{
	background: transparent url('<?php  echo $dcrURL;?>neoimg/guidebtn/oval-red-right.gif') no-repeat top right;
}

</style>
</style>
<?php 
		}
		$html_guidebtn_iscalled="yes";
		//frm= text,url [,color] [,_target]
		global $dcrURL;
		$str=explode("::",$str);
$str=arr_filter_remnull($str);
if (count($str)==0) {
	 return;
}
?><div class="buttonwrapper" nostyle="border-width: 1px;border-style: solid;border-color: red"><nobr><?php 
	while (list($k,$v)=each($str)) {
		$i=explode(',',$v);
		//printr($i);
		if ($i[3]=="") {
			$i[3]="_self";
		}
		if ($i[2]=="") { //default color
			$i[2]="gray";
		}
		?><a class="ovalbutton <?php  echo $i[2]?>"  href="<?php echo $i[1]; ?>" target="<?php  echo $i[3]?>" style="margin-left: 2px"
		<?php 
		if ($i[4]!="")	 { // on search page only
			?> onMouseover="show_text('<?php  echo $i[4];?>','div2')" onMouseout="resetit('div2')" <?php 
		}
		?>><span><?php  echo $i[0]?></span></a><?php 
	}
?></nobr>
</div>
<?php 
        }
?>