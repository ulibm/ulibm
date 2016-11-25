<?php 
function html_library_name($wh) {
	global $dcrURL;
	global $html_library_name_evercall;
	global $html_library_name_running;
	$html_library_name_running=floor($html_library_name_running)+1;
	if ($html_library_name_evercall!="yes") {
		$html_library_name_evercall="yes";
	?><link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL?>js/balloontip/balloontip.css.php" />
<script type="text/javascript" src="<?php  echo $dcrURL?>js/balloontip/balloontip.js.php"></script><?php 
	}
  $s=tmq("select * from library where UserAdminID='$wh' ");
  $r=tmq_fetch_array($s);
  if (trim("$r[UserAdminName]")=="") {
  	return "<I><small>".getlang("ไม่พบชื่อเจ้าหน้าที่ห้องสมุด::l::Librarian not found")." $wh</small></I>";
  }
  $ret="<a href=\"javascript:void(null);\" rel=\"balloon$html_library_name_running\" style='text-decoration: none; font-size: inherit;'>".getlang($r[UserAdminName])."</a>";
	?><div id="<?php  echo "balloon$html_library_name_running";?>" class="balloonstyle"><IMG SRC="<?php  echo get_library_pic($r[UserAdminID]);?>" hspace=3 vspace=3 WIDTH="50" BORDER="0" ALT="" style="float:left;"> <font class=smaller><?php  echo getlang($r[UserAdminName]);?></font><font class=smaller2><br> <?php  echo get_libsite_name($r[libsite]);?></font>
</div><?php 
  return $ret;

}

?>