<?php 
header('Content-type: application/x-javascript');
include("../inc/config.inc.php");
// พ
?>

function libmannstartIntro<?php  echo $addid;?>(){
	var intro = introJs();
	  intro.setOptions({
		steps: [	  <?php 
		$s=tmq("select * from bkedit where fid='$code' order by ordr");	  
		$i=0;
		$c=tnr($s);
		$locallsepper="<br>&nbsp;&nbsp;&nbsp;";
		while ($r=tfa($s)) {
		  //printr($r);
		  $r[name]=getlang($r[name]);
			$namea=explodenewline($r[name]);
			$r[name]=implode("<BR>",$namea)." ($code)";
			$strdsp=$r[name];
			if (trim($r[example])!=""){
   			$strdsp.="<BR><b>Example:</b><BR>";
   			$tmp=str_replace("\$","^",$r[example]);
   			$tmp=explodenewline($tmp);
   			$tmp=$locallsepper.implode("$locallsepper",$tmp);
   			$strdsp.=$tmp;
			}
			if (trim($r[indiexamplecache])!=""){
   			$strdsp.="<BR><b>Indicators:</b>";
   			$tmp=str_replace("\$","^",$r[indiexamplecache]);
   			$tmp=explodenewline($tmp);
   			$tmp=$locallsepper.implode("$locallsepper",$tmp);
   			$strdsp.=$tmp;
			}			
			$i++;
			?>
			{
			intro: "<?php  echo getlang($strdsp);

			?>"
			<?php  if (trim($r[jsid])!="") {
				echo ",element: '#$r[jsid]'";
			}?>
			<?php  if (trim($r[jsid])!="") {
				echo ",position: '$r[position]'";
			}?>
			
		  }
		  <?php 
			if (trim($r[subfieldinfocache])!=""){// echo "xxxxxxxxxxxxxx";
			   echo ",";
   			$namea=explodenewline($r[name]);
   			$r[name]=implode("<BR>",$namea);// ." ($code)";
   			$strdsp=$r[name];
			   //$strdsp.="<BR><b>Subfields:</b><BR>";
   			$tmp=str_replace("\$","^",$r[subfieldinfocache]);
   			$tmp=explodenewline($tmp); //printr($tmp);
   			$tmp=$locallsepper.implode("$locallsepper",$tmp);
   			//echo $tmp;
   			$strdsp.=$locallsepper.$tmp;
			?>
			{
			intro: "<?php  echo ($strdsp);

			?>"
			<?php  if (trim($r[jsid])!="") {
				echo ",element: '#$r[jsid]'";
			}?>
			<?php  if (trim($r[jsid])!="") {
				echo ",position: '$r[position]'";
			}?>
			
		  }
		  <?php 
			
			}
			
		}
	  ?>
		]
	  });

	  intro.start();
  }