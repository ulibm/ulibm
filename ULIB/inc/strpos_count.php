<?php // พ
function strpos_count($haystack, $needle, $i = 0) { 
   while (strpos($haystack,$needle) !== false) {$haystack = substr($haystack, (strpos($haystack,$needle) + 1)); $i++;} 
   return $i; 
} 
?>