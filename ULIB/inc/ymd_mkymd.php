<?php // พ
function ymd_mkymd($dt) {
				 $res=Array();
				 $res[0]=date("j",$dt);
				 $res[1]=date("n",$dt);
				 $res[2]=date("Y",$dt);
	return $res;
}
?>