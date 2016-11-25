<?php  

	function local_getnhiddenquerysting($skip) {
		global $_SERVER;
		$skipa=explode(',',$skip);
		$addquerya=explode('&',$_SERVER[QUERY_STRING]);
		reset ($addquerya); 
		while (list ($key, $val) = each ($addquerya)) { 
			$addqueryi=explode('=',$val);
			//echo "$addqueryi[0]";
			if(in_array($addqueryi[0], $skipa)) {
				 continue;
			}	//echo urldecode($addqueryi[0])."-".urldecode($addqueryi[1]);
			if ($addqueryi[1]=="") {
				 continue;
			}

			echo "<INPUT TYPE='hidden' NAME='".urldecode($addqueryi[0])."' value='".addslashes(urldecode($addqueryi[1]))."'>";
		}
	}

	function local_gethiddenquery($source,$skip) {
			$skipa=explode(',',$skip);
			//printr($skipa); // พ 
  		$addquerya=explode('&',$source);
			
  		reset ($addquerya); 
			$res="";
  		while (list ($key, $val) = each ($addquerya)) { 
  			$addqueryi=explode('=',$val);
  			//echo "$addqueryi[0]";
  			if(in_array($addqueryi[0], $skipa) || $addqueryi[1]=="") {
						//echo "[$addqueryi[0]]";
				  	continue;
  			}	//echo urldecode($addqueryi[0])."-".urldecode($addqueryi[1]);
  			if ($addqueryi[1]=="") {
  				 continue;
  			}
  			$res.="&".urldecode($addqueryi[0]).'='.(urldecode($addqueryi[1]));//remove addslashes since add explodewithquote
  	}
		return $res;
	}
?>