<?php  //พ
	include ("../config.inc.php");

// Author: Matthew Wilson
// Date: December 28, 2007
// Copyright 2007 TechsSupport.org

/////////////////////////////////////////
// ----- DEFINE CAPTCHA VARIABLES ----- //
////////////////////////////////////////
//
// The height and width of the image
$width = 120;
$height = 40;
	
// The min and max number of characters in the image
$min = 3;
$max = 3;
	
// The min and max font size for the characters
$minFont = 14;
$maxFont = 20;
	
// The number of pixels each character should be apart.
$spacing = 25;
	
// The font to use for the characters.
$font = './comic.ttf';
	
// Number of elipses to be in the background.
$numElipses = 25;
	
// The min and max width for the elipses.
$minElipseWidth = 10;
$maxElipseWidth = 200;
	
// The min and max height for the elipses.
$minElipseHeight = 10;
$maxElipseHeight = 50;
	
// The min and max red color range for the background.
// *** NOTE: *** This range follows the RGB standard
// and must be between 0 and 255. 0 = black, 255 = white.
$minColRedRange = 50;
$maxColRedRange = 255;
	
// The min and max green color range for the background.
// *** NOTE: *** This range follows the RGB standard
// and must be between 0 and 255. 0 = black, 255 = white.
$minColGreenRange = 50;
$maxColGreenRange = 255;
	
// The min and max blue color range for the background.
// *** NOTE: *** This range follows the RGB standard
// and must be between 0 and 255. 0 = black, 255 = white.
$minColBlueRange = 50;
$maxColBlueRange = 255;
	
// The level of contrast between the background and the
// text. *** NOTE: *** This value is a percentage and must
// be between 0 and 1. A value of 0.75 means that the text
// color will be 25% darker than the background.
$textVariantIntensity = 0.2;
	
// The level of contrast between the background and the
// elipses. *** NOTE: *** This value is a percentage and must
// be between 0 and 1. A value of 0.75 means that the elipse
// color will be 25% darker than the background.
$elipseVariantIntensity = 0.90;
	
// Define the numbers you want in the random string.
$numbers = array('1', '2', '3', '4', '5', '6', '7', '8', '9');

// Define the uppercase characters you want in the random string.
$upper = array('A', 'B', 'D', 'E', 'F', 'G', 'H',
			   'J', 'K', 'M', 'N', 'P', 'Q', 'R',
			   'T', 'U', 'Y');

// Define the lowercase characters you want in the random string.
$lower = array('a', 'b', 'd', 'e', 'f', 'g', 'h',
			   'j', 'k', 'm', 'n', 'p', 'q', 'r',
			   't', 'u', 'y',);
//
//////////////////////////////////
// ----- END CONFIGURATION ----- //
//////////////////////////////////
?>