<?php  //พ
;
 include("../inc/config.inc.php");

    /*===========================================================================*/
    /*      PHP Barcode Image Generator v1.0 [9/28/2000]
            Copyright (C)2000 by Charles J. Scheffold - cs@wsia.fm
    
    
            ---
            UPDATE 09/21/2002 by Laurent NAVARRO - ln@altidev.com - http://www.altidev.com
            Updated to be compatible with register_globals = off and on
            ---
            UPDATE 4/6/2001 - Important Note! This script was written with the assumption
            that "register_globals = On" is defined in your PHP.INI file! It will not 
            work as-is      and as described unless this is set. My PHP came with this 
            enabled by default, but apparently many people have turned it off. Either 
            turn it on or modify the startup code to pull the CGI variables in the old 
            fashioned way (from the HTTP* arrays). If you just want to use the functions 
            and pass the variables yourself, well then go on with your bad self.
            ---
            
            This code is hereby released into the public domain.
            Use it, abuse it, just don't get caught using it for something stupid.
    
    
            The only barcode type currently supported is Code 3 of 9. Don't ask about 
            adding support for others! This is a script I wrote for my own use. I do 
            plan to add more types as time permits but currently I only require 
            Code 3 of 9 for my purposes. Just about every scanner on the market today
            can read it.
    
    
            PARAMETERS:
            -----------
            $barcode        = [required] The barcode you want to generate
    
    
            $type           = (default=0) It's 0 for Code 3 of 9 (the only one supported)
            
            $width          = (default=160) Width of image in pixels. The image MUST be wide
                                      enough to handle the length of the given value. The default
                                      value will probably be able to display about 6 digits. If you
                                      get an error message, make it wider!
    
    
            $height         = (default=80) Height of image in pixels
            
            $format         = (default=jpeg) Can be "jpeg", "png", or "gif"
            
            $quality        = (default=100) For JPEG only: ranges from 0-100
    
    
            $text           = (default=1) 0 to disable text below barcode, >=1 to enable
    
    
            NOTE: You must have GD-1.8 or higher compiled into PHP
            in order to use PNG and JPEG. GIF images only work with
            GD-1.5 and lower. (http://www.boutell.com)
    
    
            ANOTHER NOTE: If you actually intend to print the barcodes 
            and scan them with a scanner, I highly recommend choosing 
            JPEG with a quality of 100. Most browsers can't seem to print 
            a PNG without mangling it beyond recognition. 
    
    
            USAGE EXAMPLES FOR ANY PLAIN OLD HTML DOCUMENT:
            -----------------------------------------------
    
    
            <IMG SRC="barcode.php?barcode=HELLO&quality=75">
    
    
            <IMG SRC="barcode.php?barcode=123456&width=320&height=200">
                    
            
    */
    /*=============================================================================*/
    //-----------------------------------------------------------------------------
    // Startup code
    //-----------------------------------------------------------------------------
	barcode_startupvar();
    switch ($type)
        {
        default: $type=1;
        case 1:
            Barcode39($barcode, $width, $height, $quality, $format, $text);
            break;
        }
?>