<?php 
include("./cfg.inc.php");
limitpage_var();
html_start();
//print_r($_GET);
?><form method="post" action="_emailpuller.php">
	ค้นหาด้วย <input type="text" 
	name="name"
	value="<?php  echo $name?>"
	> <input type="submit" value="ค้นหา">
<input type="hidden" name="kid_ID" value="<?php  echo $kid_ID;?>">
</form><?php 
$s=tmq("select distinct s_name,s_email from acqn_sub where s_name like '$name%' and length(s_email)>5 ");
while ($r=tfa($s)) {
	?>&bull; <?php  echo $r[s_name]; ?> <a 
	href="javascript:parent.tmp=parent.getobj('<?php  echo $kid_ID;?>'); parent.tmp.value='<?php  echo $r[s_email]; ?>';"><?php  echo $r[s_email]; ?></a><br><?php 
}
?>