<?php 
header('Content-type: application/x-javascript');
include("../../inc/config.inc.php");
// พ
?>

function libmannstartIntro<?php  echo $addid;?>(){
	var intro = introJs();
	  intro.setOptions({
		steps: [	  <?php 
		$s=tmq("select * from libmann where nested='$code' order by ordr");	  
		$i=0;
		$c=tnr($s);
		while ($r=tfa($s)) {
			$namea=explodenewline($r[name]);
			$r[name]=implode("<BR>",$namea);
			$i++;
			?>
			{
			intro: "<?php  echo getlang($r[name]);
				$img=fft_upload_get("libmann","imgfile",$r[id]);
				//printr($img);
				if ($img[status]!="ok") {
				} else {
					echo "<img src='$img[url]' hspace=4 vspace=4 style='max-width: 750px;'>";
				}
			?>"
			<?php  if (trim($r[jsid])!="") {
				echo ",element: '#$r[jsid]'";
			}?>
			<?php  if (trim($r[jsid])!="") {
				echo ",position: '$r[position]'";
			}?>
			
		  }
		  <?php 
			if ($i<$c) { echo ",";}
		}
	  ?>
		]
	  });

	  intro.start();
  }