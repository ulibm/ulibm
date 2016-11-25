<?php 
//  install to database
$ta=tmq_list_tables();
$found=false;// พ
while ($tar=tfa($ta)) {
	if ($tar[0]=="addonsdb_serverwatch") {
		$found=true;
	}
}
if ($found==false) {
	tmq("
CREATE TABLE IF NOT EXISTS `addonsdb_serverwatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `url` longtext NOT NULL,
  `cache` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) 
 ");
 
}
//
$ta=tmq_list_tables();
$found=false;// พ
while ($tar=tfa($ta)) {
	if ($tar[0]=="addonsdb_serverwatch_log") {
		$found=true;
	}
}
if ($found==false) {
	tmq("
CREATE TABLE IF NOT EXISTS `addonsdb_serverwatch_log` (
  `id` double NOT NULL AUTO_INCREMENT,
  `pid` double NOT NULL,
  `dt` double NOT NULL,
  `cache` longtext NOT NULL,
  `tmp1` longtext NOT NULL,
  `tmp2` longtext NOT NULL,
  `tmp3` longtext NOT NULL,
  `tmp4` longtext NOT NULL,
  `tmp5` longtext NOT NULL,
  `tmp6` longtext NOT NULL,
  `tmp7` longtext NOT NULL,
  PRIMARY KEY (`id`)
)
 ");
 
}

?>