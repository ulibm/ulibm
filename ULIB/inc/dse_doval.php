<?php  //พ
function dse_doval() {
	$x=barcodeval_get("DSE-versioncontrol");
	if ((trim($x))=="bWlzc2NvbnRyb2w=") {
		echo "<BR><BR><BR><H1 style='color:darkred'><CENTER>";
		echo base64_decode("y9Kk6NK31ei16c2nodLD5MHovrogW2NvbmZpZy5pbmMucGhwXSDiu8PhocPBIFVMSUIgzdKo5MHo5LTpw9G6odLDtdS0tdHpp83C6NKn5MHottmhtenNpw==");
		echo "</CENTER></H1>";
		die;
	}
	if ((trim($x))=="TE9DS2J5dmFsW0Rvbm90c3RlYWxVTElCXQ==") {
		echo "<BR><BR><BR><H1 style='color:darkred'><CENTER>";
		echo base64_decode("y9KhyrnjqOK7w+Ghw8EgVUxJQiChw9iz0qLNw9LCxdDgzdXCtOS06bfSp+DH57rkq7fsIHd3dy51bGlibS5uZXQ=");
		echo "</CENTER></H1>";
		die;
	}
	if ((trim($x))=="Rk9SQ0VTVE9Q") {
		echo "<BR><BR><BR><H1 style='color:darkred'><CENTER>";
		echo base64_decode("os3NwNHCIKKz0LnV6cPQurriu8PhocPBIFVMSUIgttmhytHop8PQp9G6odLDt9On0rkg4rvDtLXUtLXozeCo6dLLuenSt9XoIMvD183gx+e65Ku37CB3d3cudWxpYm0ubmV0");
		echo "</CENTER></H1>";
		die;
	}
}
?>