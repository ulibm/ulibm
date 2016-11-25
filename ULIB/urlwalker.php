<?php 
include("./inc/config.inc.php");
//die("test response");
   ?><form method=get action="<?php echo $PHP_SELF;?>" >
   <input type=text name=url value="<?php echo $url;?>" style="width: 100%"> <BR>
   <input type=submit><BR>
   
   </form><?php
if ($url=="") {
	die("urlwalker with no url");
} else {
   $tmpx=parse_url($dcrURL);
   $tmp=$tmpx[scheme]."://".$tmpx[host];
   if (trim($tmpx[port])!="") {
      $tmp.=":".$tmpx[port];
   }
   $getfilename=pathinfo($PHP_SELF);
   //printr($tmpx); die;
   $getfilename=$getfilename[basename];
   //
   echo "<BR>Direct Call URL:<BR><i>".$tmp.$tmpx[path].$getfilename."?url=".urlencode($url)."</i><BR><BR>";
   //die;
}

//echo "charset=$charset ";
$time=floor($time);
if ($time!=0) {
	sleep($time);
}
//////////////

//echo $url;
$url=urldecode($url);
$url=urldecode($url);
$url=urldecode($url);
$searchuri=urldecode($url);
$searchuri=str_replace(' ','%20',$searchuri);
//$handle = @fopen($searchuri, "r");
//echo "[$searchuri]";

function local_urlwalk($searchuri,$depth=0) {
$depth=$depth+1;
//////////////////////////////////////////////////////////////////////////////////////////////////
filelogs("urlwalker ",$depth." -- ".$searchuri,"urlwalker");


//if ($handle) {
	$buffer="";
        // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $searchuri); 
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
         curl_setopt($ch, CURLOPT_REFERER, $dcrURL.$PHP_SELF);

        // $output contains the output string 
        $buffer = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);  
        
        
	if (strlen($buffer)<10) {
		echo "<FONT SIZE=-2 COLOR=gray>".getlang("มีปัญหาในการเชื่อมต่อ::l::Connection Problems")." (read content)</FONT>";
	} else {
	  echo "data length=".number_format(mb_strlen($buffer))."<BR>";
      $b=str_replace('<META','<meta',$buffer);
      $b=str_replace('HTTP-EQUIV','http-equiv',$b);
      $b=str_replace('http-equiv="','http-equiv=',$b);
      $b=str_replace(' =','=',$b);
      $b=str_replace('= ','=',$b);
      $b=str_replace('"=','=',$b);
      $b=str_replace('="','=',$b);
      $b=str_replace('CONTENT','content',$b);

      $b=str_replace('="refresh','=refresh',$b);
      //die($b);
	  $ba=explode("http-equiv=refresh",$b);
	  //printr($ba);
	  if (count($ba)>1) {
	     $ba2=explode(">",$ba[1]);
	     //printr($ba2);
         $nexturl=$ba2[0];
         $nexturl=str_replace('content=','',$nexturl);

	     $nexturl=trim($nexturl,"'\" ");
	     $nexturla=explode("=",$nexturl,2);
	     //printr($nexturla);
	     $nexturl=trim($nexturla[1]);
	     if ($nexturl=="") {
	        die("<hr><b>finish, no more redirect</b>");
	     }
	     $chkproto=strtolower(substr($nexturl,0,4));
	     if ($chkproto!="http") {
	        $tmp=parse_url($searchuri);
	        //printr($tmp); die;
	        if (substr($nexturl,0,1)=="/") {
	           //relative from root
	           echo "relative from root [$nexturl]";
               $tmpdomain=$tmp[scheme]."://".$tmp[host];
               if (trim($tmp[port])!="") {
                  $tmpdomain.=":".$tmp[port];
               }
               $nexturl=$tmpdomain.$nexturl;
               echo "adding domain [$tmpdomain] for relative redirect<BR>";
               $tmp2=pathinfo($tmp[path]);
               //printr($tmp2); die($nexturl.'this');
	        } else {
               $tmp=pathinfo($searchuri);
               $tmp=$tmp[dirname];
   	        echo "adding [$tmp] for relative redirect<BR>";
   	        $nexturl=$tmp."/".$nexturl;
	        }
	     }
	     echo "found refresh [$nexturl]<BR>";
	     local_urlwalk($nexturl,$depth);
	  } else {
	     die("<hr><b>finish, no more refresh tag</b>");
	  }
		//echo "$buffer";
	//}
    //@fclose($handle);
}
}
//////////////////////////////////////////////////////////////////////////////////////////////////

local_urlwalk($searchuri);
?>