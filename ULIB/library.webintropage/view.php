<?php 
	; 
        include ("../inc/config.inc.php");
		html_start();
$now=time();
	$showcase="select * from webpage_webintropage where  dtstart<=$now and dtend>=$now order by dt desc";
	$showcase=tmq($showcase,false);


if (tmq_num_rows($showcase)==0) {
	die("-");
}
//html_start();
if ($bgcolor=="") {
	$bgcolor="#C9C9C9";
} 
		$set_width=floor($set_width);
		$set_height=floor($set_height);
		if ($set_width==0) {
			$set_width=400;
		}
		if ($set_height==0) {
			$set_height=280;
		}

?><style>
body {
padding: 0 0 0 0;
margin: 0 0 0 0;
background-color: <?php  echo $bgcolor;?>
}

</style>
<script type="text/javascript" src="jquery-1.2.6.pack.js"></script>

<style type="text/css">

/*Make sure your page contains a valid doctype at the top*/
#simplegallery1{ /*//CSS for Simple Gallery Example 1*/
position: relative; /*keep this intact*/
visibility: hidden; /*keep this intact*/
border: 0px solid darkred;
}

#simplegallery1 .gallerydesctext{ /*//CSS for description DIV of Example 1 (if defined)*/
text-align: left;
padding: 0px 0px;
}
.gallerystatus {
	font-size: 22px;
}
</style>

<script type="text/javascript" src="simplegallery.js.php?set_width=800&set_height=500">

/***********************************************
* Simple Controls Gallery- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>

<script type="text/javascript">

var mygallery=new simpleGallery({
	wrapperid: "simplegallery1", //ID of main gallery container,
	dimensions: [800, 500], //width/height of gallery in pixels. Should reflect dimensions of the images exactly
	imagearray: [
<?php 

	if (tmq_num_rows($showcase)!=0) {
		//index_sepper(getlang("รายการที่น่าสนใจ"));
		$count=0;
		$all=tmq_num_rows($showcase);
		while ($r=tmq_fetch_array($showcase)) {
			$count++;
			$img=fft_upload_get("webpage_webintropage","coverimg",$r[id]);
		?> ["<?php  echo $img[url];?>", "<?php 
			if ($r[linkto]!="") {
				echo "$r[linkto]";
			} else {
				echo "javascript:void(null);";
			}

		?>", "_top", "<?php  echo stripslashes($r[title]);?>"]<?php 
			//show_mediaicon($r[randid],"show","yes",100,180);
			if ($count<$all) {
				echo ",";
			}
		}
	}?>
	],
	autoplay: [true, 8000, 20], //[auto_play_boolean, delay_btw_slide_millisec, cycles_before_stopping_int]
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	oninit:function(){ //event that fires when gallery has initialized/ ready to run
		//Keyword "this": references current gallery instance (ie: try this.navigate("play/pause"))
	},
	onslide:function(curslide, i){ //event that fires after each slide is shown
		//Keyword "this": references current gallery instance
		//curslide: returns DOM reference to current slide's DIV (ie: try alert(curslide.innerHTML)
		//i: integer reflecting current image within collection being shown (0=1st image, 1=2nd etc)
	}
})

</script>
<TABLE width=100% align=center cellpadding=0 cellspacing=0 border=0 bgcolor=white>
<TR>
	<TD align=center>
<div id="simplegallery1"></div>



</TD>
</TR>
</TABLE>