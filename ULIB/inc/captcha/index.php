<?php //พ
// Author: Matthew Wilson
// Date: December 28, 2007
// Copyright 2007 TechsSupport.org

// Include the configuration
include("./config.php");

/////////////////////////////////////////
// ----- START STRING GENERATION ----- //
////////////////////////////////////////
//
// Start the session and pass the header
header('Content-type: image/png');
	
// Generate a random string length based on the random lengths passed to the function.
$strLength = rand($min,$max);

// Create a randomAmount variable to then calculate the number of
// each type of character that should appear in the random string.
$randomAmount = $strLength;

// Calculate the amount of numbers in the random string,
// leaving  at least 2 characters so that at least 1 random
// uppercase and lowercase letter may also appear in the string.
$numNum = rand(1,($randomAmount-2));
$randomAmount -= $numNum;

// Calculate the amount of uppercase characters in the random
// string, leaving at least 1 character for a lowercase
// character in the random string.
$numUpper = rand(1,($randomAmount-1));
$randomAmount -= $numUpper;

// Whatever is left will be the amount of lowercase
// characters in the random string.
$numLower = $randomAmount;

// Create an empty string that will eventually be
// the random string.
$string = '';

// Shuffle the numbers array and then assign the first
// numNum elements to the string.
shuffle($numbers);
for ($x = 0; $x < $numNum; $x++) {
	$string .= $numbers[$x];
}

// Shuffle the uppercase letters array and then assign
// the first numUpper elements to the string.
shuffle($upper);
for ($x = 0; $x < $numUpper; $x++) {
	$string .= $upper[$x];
}

// Shuffle the lowercase letters array and then assign
// the first numLower elements to the string.
shuffle($lower);
for ($x = 0; $x < $numLower; $x++) {
	$string .= $lower[$x];
}

// Now shuffle the string so it also becomes random.
$string = str_shuffle($string);

// Encrypt the string and store it as a session variable.
$captcha=md5($string);
$captchasecret=$captcha;
//$_SESSION['captcha'] = 
//echo $captcha;
//$_SESSION['captcha'] = "";
//ulibsess_unregister('captcha');
//$_SESSION['captcha'] = $captcha;
ulibsess_register("captchasecret");
//ulibsess_register('captcha');
//print_r($_SESSION);
//die;
//
///////////////////////////////////////
// ----- END STRING GENERATION ----- //
//////////////////////////////////////
	
////////////////////////////////////////
// ----- START IMAGE GENERATION ----- //
///////////////////////////////////////
//
// Check to see if a color range outside the bounds was set
if ($minColRedRange < 0) {
	$minColRedRange = 0;
}
if ($maxColRedRange > 255) {
	$maxColRedRange = 255;
}
if ($minColGreenRange < 0) {
	$minColGreenRange = 0;
}
if ($maxColGreenRange > 255) {
	$maxColGreenRange = 255;
}
if ($minColBlueRange < 0) {
	$minColBlueRange = 0;
}
if ($maxColBlueRange > 255) {
	$maxColBlueRange = 255;
}	
// Determine a random color based on the color ranges.
$randColR = rand($minColRedRange,$maxColRedRange);
$randColG = rand($minColGreenRange,$maxColGreenRange);
$randColB = rand($minColBlueRange,$maxColBlueRange);
	
// Make sure the textVariantIntensity is between 0 and 1.
if ((!isset($textVariantIntensity)) ||
		   ($textVariantIntensity == 0) ||
		   ($textVariantIntensity < 0) ||
		   ($textVariantIntensity > 1)) {
	$textVariantIntensity = 0.75;
}
// Set the text colors based on the textVariantIntensity
$redText = $randColR * $textVariantIntensity;
$greenText = $randColG * $textVariantIntensity;
$blueText = $randColB * $textVariantIntensity;
	
// Make sure the elipseVariantIntensity is between 0 and 1.
if ((!isset($elipseVariantIntensity)) ||
		   ($elipseVariantIntensity == 0) ||
		   ($elipseVariantIntensity < 0) ||
		   ($elipseVariantIntensity > 1)) {
	$elipseVariantIntensity = 0.90;
}
// Set the elipse colors based on the elipseVariantIntensity
$redElipse = $randColR * $elipseVariantIntensity;
$greenElipse = $randColG * $elipseVariantIntensity;
$blueElipse = $randColB * $elipseVariantIntensity;
	
// Calculate the middle of the image so the text is placed properly.
$midHeight = $height / 2;

// Initialize the image with the given dimensions.
$captcha = imageCreate($width, $height);
	
// Set the background color and the text color that is slightly darker.
$backColor = imageColorAllocate($captcha, $randColR, $randColG, $randColB);
$txtColor = imageColorAllocate($captcha, ($redText), ($greenText), ($blueText));
$elipseColor = imageColorAllocate($captcha, ($redElipse), ($greenElipse), ($blueElipse));

// Add numElipses to the background of the image.
for($i = 1; $i <= $numElipses; $i++) {
	imageellipse($captcha, rand(1,$width), rand(1,$height),rand($minElipseWidth,$maxElipseWidth),
				 rand($minElipseHeight,$maxElipseHeight),$elipseColor);
}

// For each character in the string, rotate it randomly and
// place it in the image.
for($i=1; $i<=$strLength; $i++) {
	$clockorcounter = rand(1,2);
	if ($clockorcounter == 1) {
		$rotangle = rand(0,45);
	}
	if ($clockorcounter == 2) {
		$rotangle = rand(315,360);
	}

	// Place the character on the image with minFont and maxFont sizes.
	imagettftext($captcha, rand($minFont,$maxFont), $rotangle,($i*$spacing),
				 $midHeight, $txtColor, "$font", substr($string,($i-1),1));
}

//Send the headers (at last possible time).
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Fri, 19 Jan 1994 05:00:00 GMT");
header("Pragma: no-cache");

//Output the image as a PNG.
imagePNG($captcha);

//Delete the image from memory.
imageDestroy($captcha);
//
//////////////////////////////////////
// ----- END IMAGE GENERATION ----- //
/////////////////////////////////////
?>