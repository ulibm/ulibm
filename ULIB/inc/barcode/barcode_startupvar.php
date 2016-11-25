<?php // พ
function barcode_startupvar() {
	global $text;
	global $format;
	global $quality;
	global $width;
	global $height;
	global $type;
	global $barcode;
    if (isset($_GET["text"]))
        $text=$_GET["text"];
    if (isset($_GET["format"]))
        $format=$_GET["format"];
    if (isset($_GET["quality"]))
        $quality=$_GET["quality"];
    if (isset($_GET["width"]))
        $width=$_GET["width"];
    if (isset($_GET["height"]))
        $height=$_GET["height"];
    if (isset($_GET["type"]))
        $type=$_GET["type"];
    if (isset($_GET["barcode"]))
        $barcode=$_GET["barcode"];
    if (!isset($text))
        $text=1;
    if (!isset($type))
        $type=1;
    if (empty($quality))
        $quality=100;
    if (empty($width))
        $width=160;
    if (empty($height))
        $height=80;
    if (!empty($format))
        $format=strtoupper($format);
    else
        $format="PNG";
}
?>