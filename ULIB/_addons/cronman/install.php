<?php 
//  install to database
$ta=tmq_list_tables();
$found=false;// พ
while ($tar=tfa($ta)) {
	if ($tar[0]=="addonsdb_cronman") {
		$found=true;
	}
}
if ($found==false) {
	tmq("
CREATE TABLE IF NOT EXISTS addonsdb_cronman (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,

  `t1` longtext NOT NULL,
  `t2` longtext NOT NULL,
  `t3` longtext NOT NULL,
  `t4` longtext NOT NULL,
  `t5` longtext NOT NULL,
  `t6` longtext NOT NULL,
  `cmd` longtext NOT NULL,
  
  PRIMARY KEY (`id`)
) 
 ");
 
}
//

?>