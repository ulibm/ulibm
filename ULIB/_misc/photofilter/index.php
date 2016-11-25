<?php
include("../../inc/config.inc.php");
html_start();
head();
$_REQPERM="mainmenu";
mn_lib();

   $path=base64_decode($p);
   $path=ltrim($path,"/");
   $path=str_replace("..","",$path);
   
      $path_parts = pathinfo($path);
   $ex=strtolower($path_parts[extension]);
   if ($ex=="jpg" || $ex=="png" || $ex=="jpeg" ) {
   } else {
      die("jpg or png file only");;
   }
   
   if (!file_exists($dcrs."$path")) {
      die("<font TITLE='$path'>path not found</font>");
   }
   //echo $path;
   $spath=$dcrs.$path;
   //echo "<BR>".$spath;

   $dest=$dcrs."_tmp/_photofiltertmp_$useradminid.$ex";
   $desturl=$dcrURL."_tmp/_photofiltertmp_$useradminid.$ex";

if ($save=="yes") {
   @rename($spath,$spath.".backup");
   @rename($dest,$spath);
   if (file_exists($spath.".thumb.jpg")) {
      copy($spath, $spath.".thumb.jpg");
		fso_image_fixsize($spath.".thumb.jpg",$ex);
   }
   ?>
   <script>
   self.close();
   </script>
   <?php
   die;
}
$a=Array("");
$a[IMG_FILTER_NEGATE]=Array("");
$a[IMG_FILTER_NEGATE][name]="Invert Colors";
$a[IMG_FILTER_GRAYSCALE]=Array("");
$a[IMG_FILTER_GRAYSCALE][name]="Grayscale";
$a[IMG_FILTER_BRIGHTNESS]=Array("");
$a[IMG_FILTER_BRIGHTNESS][name]="Brightness ";
$a[IMG_FILTER_BRIGHTNESS][filters]=Array();
$a[IMG_FILTER_BRIGHTNESS][filters][1]="level of brightness.";
$a[IMG_FILTER_CONTRAST]=Array("");
$a[IMG_FILTER_CONTRAST][name]="Contrast ";
$a[IMG_FILTER_CONTRAST][filters]=Array();
$a[IMG_FILTER_CONTRAST][filters][1]="level of contrast.";
$a[IMG_FILTER_COLORIZE]=Array("");
$a[IMG_FILTER_COLORIZE][name]="Colorize ";
$a[IMG_FILTER_COLORIZE][filters]=Array();
$a[IMG_FILTER_COLORIZE][filters][1]="Red.";
$a[IMG_FILTER_COLORIZE][filters][2]="Green.";
$a[IMG_FILTER_COLORIZE][filters][3]="Blue.";
$a[IMG_FILTER_COLORIZE][filters][4]="Alpha.:127";
$a[IMG_FILTER_EDGEDETECT]=Array("");
$a[IMG_FILTER_EDGEDETECT][name]="Edge Detect";
$a[IMG_FILTER_EMBOSS]=Array("");
$a[IMG_FILTER_EMBOSS][name]="Emboss";
$a[IMG_FILTER_GAUSSIAN_BLUR]=Array("");
$a[IMG_FILTER_GAUSSIAN_BLUR][name]="Gaussian Blur";
$a[IMG_FILTER_SELECTIVE_BLUR]=Array("");
$a[IMG_FILTER_SELECTIVE_BLUR][name]="Selective Blur";
$a[IMG_FILTER_MEAN_REMOVAL]=Array("");
$a[IMG_FILTER_MEAN_REMOVAL][name]="Mean Removal";
$a[IMG_FILTER_SMOOTH]=Array("");
$a[IMG_FILTER_SMOOTH][name]="Smooth";
$a[IMG_FILTER_SMOOTH][filters]=Array();
$a[IMG_FILTER_SMOOTH][filters][1]="level of smooth.";
$a[IMG_FILTER_PIXELATE]=Array("");
$a[IMG_FILTER_PIXELATE][name]="Pixelate";
$a[IMG_FILTER_PIXELATE][filters]=Array();
$a[IMG_FILTER_PIXELATE][filters][1]="block size ";
$a[IMG_FILTER_PIXELATE][filters][2]="pixelation effect ";


?>
<form action="<?php echo $PHP_SELF;?>#preview" method=post>
<table width=1000 align=center border=0 cellpadding=0 cellspacing=5>
<tr><td class=table_head2 align=center>Filters</td></tr>
<?php 
@reset($a);
while (list($k,$v)=each($a)) {
?>
<tr><td width=150>
<label>
<input type=checkbox name="applyfilter_<?php echo $k;?>" value="yes"
<?php $tmp="";
//echo("\$tmp=\$_POST['applyfilter_$k'];");
eval("\$tmp=\$_POST['applyfilter_$k'];");
//echo $tmp;
if ($tmp=="yes") {
   echo "checked selected";
}
?>
>
<b><?php echo $v[name]; ?></b>
<?php
   if (is_array($v[filters])) {
      $a2=$v[filters];
      while (list($k2,$v2)=each($a2)) {
         echo "<BR>&nbsp;&nbsp;&nbsp;&nbsp;";
         $v2a=explode(":",$v2);
         echo $v2a[0];
         $max=floor($v2a[1]);
         if ($max==0) { $max=255; }
         ?><input name="args_<?php echo $k;?>_<?php echo $k2;?>" type="range" max="<?php echo $max;?>"
         <?php
         eval("\$tmp=\$_POST['args_$k"."_$k2'];");
         $tmp=floor($tmp);
         echo " value='$tmp' ";
         ?>
         /><?php


      }
   }
?>
</label>
</td><td></td></tr>
<?php 
}
?>
<tr><td class=table_head2 align=center>Preview</td></tr>

</table>
<center>
<input type=hidden value="<?php echo $p;?>" name=p>
<input type=submit value=" Update Filters "> 
<input type=button value=" Save " 
style="color: darkred"
onclick="self.location='<?php echo $PHP_SELF."?save=yes&p=$p";?>';" >
</center>
</form>
<?php
@unlink($dest);
@copy($spath,$dest);
@reset($a);
if ($ex=="png") {
  $image = imagecreatefrompng($dest);
  imageAlphaBlending($image, true);
   imageSaveAlpha($image, true);

}elseif ($ex=="jpg"||$ex=="jpeg") {
  $image = imagecreatefromjpeg($dest);
} else {
   die("not support file type $ex");
}
while (list($k,$v)=each($a)) {
   eval("\$tmp=\$_POST['applyfilter_$k'];");
   eval("\$tmpa1=\$_POST['args_$k"."_1'];"); 
   eval("\$tmpa2=\$_POST['args_$k"."_2'];"); 
   eval("\$tmpa3=\$_POST['args_$k"."_3'];"); 
   eval("\$tmpa4=\$_POST['args_$k"."_4'];"); 
   
   if ($tmp=="yes") {
      if ($tmpa3!="") {
         imagefilter($image, $k,$tmpa1,$tmpa2,$tmpa3);
      } elseif ($tmpa2!="") {
         imagefilter($image, $k,$tmpa1,$tmpa2);
      } elseif ($tmpa1!="") {
         imagefilter($image, $k,$tmpa1);
      } else {
         imagefilter($image, $k,$tmpa1,$tmpa2,$tmpa3);
      }
   }
}
if ($ex=="png") {
  imagepng($image, $dest);
}elseif ($ex=="jpg"||$ex=="jpeg") {
  imagejpeg($image, $dest);
}
imagedestroy($image);
html_dialog("","One way operation, can not undo if saved");

?><center>
<table width=1000 align=center border=0 cellpadding=0 cellspacing=5>
<tr valign=top><td><a name=preview></a>
<img src="<?php echo $desturl;?>?randid=<?php echo randid();?>" style="width: 700px; max-width: 1000px; border: dotted 1px gray">
</td><td>
Original<br>
<img src="<?php echo $dcrURL."/".$path;?>?randid=<?php echo randid();?>" style="width: 300px; max-width: 500px;border: dotted 1px gray">
</td></tr></table>
<?php 


foot(); ?>