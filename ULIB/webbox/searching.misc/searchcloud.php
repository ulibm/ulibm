<?php  //พ
	$cloud="select * from searchcloud where isshow ='yes' order by ordr ";
	$cloud=tmq($cloud,false);
	$indexdb=tmq_dump2("index_ctrl","code","fid");
	while ($clor=tmq_fetch_array($cloud)) {
		$maxcloud=$clor[dspnum];
		if ($maxcloud>40) {$maxcloud=40;}
		if ($maxcloud<3) {$maxcloud=3;}
		echo "<i  class=smaller>".getlang($clor[name])."</i><BR>";
		$alla=explodenewline($clor[cloud]);
		$alla=arr_filter_remnull($alla);
		$allac=count($alla);
		//echo "[$allac/$maxcloud]";
		if ($allac>=$maxcloud) {$allac=$maxcloud;}
		$rand_keys = array_rand($alla, count($alla));
		echo "<div style='padding-left: 3px; display:block;border-width: 1px; border-style: dotted; border-color: #CECECE;'>";
		//printr($mapdb);
		for ($i=0;$i<$allac;$i++) {
			$cloudi=trim($alla[$rand_keys[$i]]);
			$cloudi=trim($cloudi);
			if ($cloudi=="") {
				continue;
				//echo("<BR>$i=$rand_keys[$i]");
			}
			$c="select count(id) as cc from index_db where ispublish='yes' and  
			".$indexdb[$clor[fid]]." like '%".addslashes($cloudi)."%'  ";
			//echo "[$mapdb[$searchdbkey]]";
			$c=tmq($c,false);
			$c=tmq_fetch_array($c);
			$c=floor($c[cc]);
			$fsize=11;
			$fcol='#000001';
			if ($c==0) {	$fsize=11; $fcol='#777777';}
			if ($c>=3) {	$fsize=13; $fcol='#000050';}
			if ($c>=5) {	$fsize=13; $fcol='#00005a';}
			if ($c>=7) {	$fsize=13; $fcol='#000064';}
			if ($c>=9) {	$fsize=13; $fcol='#00006e';}
			if ($c>=15) {	$fsize=14; $fcol='#000078';}
			if ($c>=20) {	$fsize=14; $fcol='#000082';}
			if ($c>=25) {	$fsize=14; $fcol='#000096';}
			if ($c>=30) {	$fsize=14; $fcol='#0000a0';}
			if ($c>=35) {	$fsize=14; $fcol='#0000aa';}
			if ($c>=40) {	$fsize=14; $fcol='#0000b4';}
			if ($c>=45) {	$fsize=15; $fcol='#0000be';}
			if ($c!=0) {
				 echo " <!--<nobr>--><A HREF='javascript:void(null);' onclick=\"local_cloudsearch('".trim(($cloudi)).
				 	"','".$clor[fid]."');\" style='font-size:$fsize;color:$fcol; font-family:Tahoma;' >";
			 } else {
			}
			echo trim($cloudi);
			echo "<FONT  COLOR=black style='font-size:11; font-family:Tahoma;' >(";
				echo number_format($c);
			echo ")</FONT>";
			if ($c!=0) {
				 echo "</A>";
			}
			echo "<!--</nobr>--> <WBR />
			\n";
			//printr($clor);
			@reset($mapdb);
		}
		echo "</div>";

	}
?><script type="text/javascript">
	<!--
function local_cloudsearch(cloudkw,cloudidx) {
	local_haltloading();
	tmp=getobj("singlesearchbox");
	tmp.value=cloudkw;
	tmp2=getobj("S_INDEXCODE");		
	var txt = "";
	for (var i=0; i<tmp2.length; i++) {
		if (tmp2.options[i].value==cloudidx) {
			tmp2.selectedIndex=i;
			break;
		}
	}
	keydownsearchbox_submit();
}
	//-->
	</script>