<?php 
// nothing to install to database
$ta=tmq_list_tables();
$found=false;// พ
while ($tar=tfa($ta)) {
	if ($tar[0]=="addonsdb_0ulibupdate") {
		$found=true;
	}
}
if ($found==false) {
	tmq("
CREATE TABLE IF NOT EXISTS `addonsdb_0ulibupdate` (
  `id` double NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `descr` longtext NOT NULL,
  `isshow` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ");
}
?>