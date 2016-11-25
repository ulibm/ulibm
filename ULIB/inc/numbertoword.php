<?php 
function numbertoword($number) {
	if (getlang("th::l::en")=="th") {
		$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
		$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
		$number = str_replace(",","",$number); 
		$number = str_replace(" ","",$number); 
		$number = str_replace("บาท","",$number); 
		$number = explode(".",$number); 
		if(sizeof($number)>2){ 
		return 'ทศนิยมหลายตัวนะจ๊ะ'; 
		exit; 
		} 
		$strlen = strlen($number[0]); 
		$convert = ''; 
		for($i=0;$i<$strlen;$i++){ 
			$n = substr($number[0], $i,1); 
			if($n!=0){ 
				if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
				elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
				elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
				else{ $convert .= $txtnum1[$n]; } 
				$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 

		$convert .= 'บาท'; 
		if($number[1]=='0' OR $number[1]=='00' OR 
		$number[1]==''){ 
		$convert .= 'ถ้วน'; 
		}else{ 
		$strlen = strlen($number[1]); 
		for($i=0;$i<$strlen;$i++){ 
		$n = substr($number[1], $i,1); 
			if($n!=0){ 
			if($i==($strlen-1) AND $n==1){$convert 
			.= 'เอ็ด';} 
			elseif($i==($strlen-2) AND 
			$n==2){$convert .= 'ยี่';} 
			elseif($i==($strlen-2) AND 
			$n==1){$convert .= '';} 
			else{ $convert .= $txtnum1[$n];} 
			$convert .= $txtnum2[$strlen-$i-1]; 
			} 
		} 
		$convert .= 'สตางค์'; 
		} 
		return $convert; 
	} else {
  
	    $hyphen      = '-';
	    $conjunction = ' and ';
	    $separator   = ', ';
	    $negative    = 'negative ';
	    $decimal     = ' point ';
	    $dictionary  = array(
		0                   => 'zero',
		1                   => 'one',
		2                   => 'two',
		3                   => 'three',
		4                   => 'four',
		5                   => 'five',
		6                   => 'six',
		7                   => 'seven',
		8                   => 'eight',
		9                   => 'nine',
		10                  => 'ten',
		11                  => 'eleven',
		12                  => 'twelve',
		13                  => 'thirteen',
		14                  => 'fourteen',
		15                  => 'fifteen',
		16                  => 'sixteen',
		17                  => 'seventeen',
		18                  => 'eighteen',
		19                  => 'nineteen',
		20                  => 'twenty',
		30                  => 'thirty',
		40                  => 'fourty',
		50                  => 'fifty',
		60                  => 'sixty',
		70                  => 'seventy',
		80                  => 'eighty',
		90                  => 'ninety',
		100                 => 'hundred',
		1000                => 'thousand',
		1000000             => 'million',
		1000000000          => 'billion',
		1000000000000       => 'trillion',
		1000000000000000    => 'quadrillion',
		1000000000000000000 => 'quintillion'
	    );
	    
	    if (!is_numeric($number)) {
		return false;
	    }
	    
	    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		// overflow
		trigger_error(
		    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
		    E_USER_WARNING
		);
		return false;
	    }

	    if ($number < 0) {
		return $negative . convert_number_to_words(abs($number));
	    }
	    
	    $string = $fraction = null;
	    
	    if (strpos($number, '.') !== false) {
		list($number, $fraction) = explode('.', $number);
	    }
	    
	    switch (true) {
		case $number < 21:
		    $string = $dictionary[$number];
		    break;
		case $number < 100:
		    $tens   = ((int) ($number / 10)) * 10;
		    $units  = $number % 10;
		    $string = $dictionary[$tens];
		    if ($units) {
			$string .= $hyphen . $dictionary[$units];
		    }
		    break;
		case $number < 1000:
		    $hundreds  = $number / 100;
		    $remainder = $number % 100;
		    $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
		    if ($remainder) {
			$string .= $conjunction . convert_number_to_words($remainder);
		    }
		    break;
		default:
		    $baseUnit = pow(1000, floor(log($number, 1000)));
		    $numBaseUnits = (int) ($number / $baseUnit);
		    $remainder = $number % $baseUnit;
		    $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
		    if ($remainder) {
			$string .= $remainder < 100 ? $conjunction : $separator;
			$string .= convert_number_to_words($remainder);
		    }
		    break;
	    }
	    
	    if (null !== $fraction && is_numeric($fraction)) {
		$string .= $decimal;
		$words = array();
		foreach (str_split((string) $fraction) as $number) {
		    $words[] = $dictionary[$number];
		}
		$string .= implode(' ', $words);
	    }
	    
	    return $string;	
	}
}
?>