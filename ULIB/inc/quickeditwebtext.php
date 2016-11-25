<?php 

/* 
        Paul's Simple Diff Algorithm v 0.1 
        (C) Paul Butler 2007 <http://www.paulbutler.org/> 
        May be used and distributed under the zlib/libpng license. 
        
        This code is intended for learning purposes; it was written with short 
        code taking priority over performance. It could be used in a practical 
        application, but there are a few ways it could be optimized. 
        
        Given two arrays, the function diff will return an array of the changes. 
        I won't describe the format of the array, but it will be obvious 
        if you use print_r() on the result of a diff on some test data. 
        
        htmlDiff is a wrapper for the diff command, it takes two strings and 
        returns the differences in HTML. The tags used are <ins> and <del>, 
        which can easily be styled with CSS.  
*/ 

function quickeditwebtext_diff($old, $new){ 
        foreach($old as $oindex => $ovalue){ 
                $nkeys = array_keys($new, $ovalue); 
                foreach($nkeys as $nindex){ 
                        $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? 
                                $matrix[$oindex - 1][$nindex - 1] + 1 : 1; 
                        if($matrix[$oindex][$nindex] > $maxlen){ 
                                $maxlen = $matrix[$oindex][$nindex]; 
                                $omax = $oindex + 1 - $maxlen; 
                                $nmax = $nindex + 1 - $maxlen; 
                        } 
                }        
        } 
        if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new)); 
        return array_merge( 
                quickeditwebtext_diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)), 
                array_slice($new, $nmax, $maxlen), 
                quickeditwebtext_diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))); 
} 

function quickeditwebtext_htmlDiff($old, $new){ 
        $diff = quickeditwebtext_diff(explode(' ', $old), explode(' ', $new)); 
        foreach($diff as $k){ 
                if(is_array($k)) 
                        $ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":''). 
                                (!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":''); 
                else $ret .= $k . ' '; 
        } 
        return $ret; 
} 


function quickeditwebtext($t,$localwidth="100%") {
	//$randid="qewt".randid();
	global $dcrURL;
	$chk=library_gotpermission("quickeditwebtext");

	if ($chk!=false) {
		?><div class=quickeditwebtext  TITLE="<?php  echo $t?>" style="width:<?php  echo $localwidth?>;text-align:center"><A class=a_btn style="background-color: #EBECF3;font-size:12; display:block; align:center;width:160; margin-bottom:0" HREF="<?php  echo $dcrURL;?>_quickeditwebtext.php?classid=<?php  echo $t?>" rel="gb_page_fs[]" ><img src="<?php  echo $dcrURL;?>neoimg/configico.png" width=10 height=10 border=0> <?php  echo getlang("แก้ไขข้อความส่วนนี้::l::Edit text");?></A></div><?php 
	}
	$s=tmq("select * from webpage_quickeditwebtext where classid='$t' ");
	$s=tmq_fetch_array($s);
	?><div style="width:<?php  echo $localwidth?>;" <?php  if ($chk!=false) { echo " class=quickeditwebtextcontent ";}?>><?php 
	echo stripslashes(str_webpagereplacer($s[html]));
	?></div><?php 
}
?>