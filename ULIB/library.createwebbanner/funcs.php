<?php  //พ

/*
 * imagettftextblur v1.0.0
 *
 * Copyright (c) 2013 Andrew G. Johnson  <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright Copyright (c) 2013 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @link http://github.com/andrewgjohnson/imagettftextblur
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0.0
 * @package imagettftextblur
 *
 */

if (!function_exists('imagettftextblur'))
{
    function imagettftextblur($image,$size,$angle,$x,$y,$color,$fontfile,$text,$blur_intensity = null)
    {
		//echo "imagettftextblur($image,$size,$angle,$x,$y,$color,$fontfile,$text,$blur_intensity = null)";	
        $blur_intensity = !is_null($blur_intensity) && is_numeric($blur_intensity) ? (int)$blur_intensity : 0;
        if ($blur_intensity > 0)
        {
            $text_shadow_image = imagecreatetruecolor(imagesx($image),imagesy($image));
            imagefill($text_shadow_image,0,0,imagecolorallocate($text_shadow_image,0x00,0x00,0x00));
            imagettftext($text_shadow_image,$size,$angle,$x,$y,imagecolorallocate($text_shadow_image,0xFF,0xFF,0xFF),$fontfile,$text);
            for ($blur = 1;$blur <= $blur_intensity;$blur++)
                imagefilter($text_shadow_image,IMG_FILTER_GAUSSIAN_BLUR);
            for ($x_offset = 0;$x_offset < imagesx($text_shadow_image);$x_offset++)
            {
                for ($y_offset = 0;$y_offset < imagesy($text_shadow_image);$y_offset++)
                {
                    $visibility = (imagecolorat($text_shadow_image,$x_offset,$y_offset) & 0xFF) / 255;
                    if ($visibility > 0)
                        imagesetpixel($image,$x_offset,$y_offset,imagecolorallocatealpha($image,($color >> 16) & 0xFF,($color >> 8) & 0xFF,$color & 0xFF,(1 - $visibility) * 127));
                }
            }
            imagedestroy($text_shadow_image);
        }
        else {
			//echo "imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);";
            return imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
		}
    }
}
/**
 * Writes the given text with a border into the image using TrueType fonts.
 * @author John Ciacia 
 * @param image An image resource
 * @param size The font size
 * @param angle The angle in degrees to rotate the text
 * @param x Upper left corner of the text
 * @param y Lower left corner of the text
 * @param textcolor This is the color of the main text
 * @param strokecolor This is the color of the text border
 * @param fontfile The path to the TrueType font you wish to use
 * @param text The text string in UTF-8 encoding
 * @param px Number of pixels the text border will be
 * @see http://us.php.net/manual/en/function.imagettftext.php
 */
function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
 
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
 
   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}
?>