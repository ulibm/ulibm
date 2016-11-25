<?php 
function viewdiffman($cate,$id) {
	if (!library_gotpermission("viewstrdiff")) {
		return;
	}
	global $useradminid;
	global $dcrURL;
	?><a href="<?php  echo $dcrURL?>library.viewdiff/sub.php?pid=<?php  echo $cate;?>&filterid=<?php echo $id?>" class="a_btn smaller2" target=_blank><?php  echo getlang("ประวัติการแก้ไข::l::View History");?></a><?php 
}
?>