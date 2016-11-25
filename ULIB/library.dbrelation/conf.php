<?php 
$rules[1][name]="ประเภทของวัสดุสารสนเทศที่ใช้งาน::l::Using Material Types";
$rules[1][fromsql]="select distinct RESOURCE_TYPE as var1,count(id) as ccdsp from media_mid group by RESOURCE_TYPE";
$rules[1][to_tb]="media_type";
$rules[1][to_field]="code";
$rules[1][to_namefield]="name";
$rules[1][skipfound]="no";

$rules[2][name]="ประเภทของสมาชิกที่ใช้งาน::l::Using Member Types";
$rules[2][fromsql]="select distinct type as var1,count(id) as ccdsp from member group by type";
$rules[2][to_tb]="member_type";
$rules[2][to_field]="type";
$rules[2][to_namefield]="descr";

$rules[3][name]="$_ROOMWORD ของสมาชิกที่ใช้งาน::l::Using $_ROOMWORD Types";
$rules[3][fromsql]="select distinct room as var1,count(id) as ccdsp from member group by room";
$rules[3][to_tb]="room";
$rules[3][to_field]="id";
$rules[3][to_namefield]="name";
$rules[3][skipempty]="no";

$rules[4][name]="$_FACULTYWORD ของสมาชิกที่ใช้งาน::l::Using $_FACULTYWORD Types";
$rules[4][fromsql]="select distinct major as var1,count(id) as ccdsp from member group by major";
$rules[4][to_tb]="major";
$rules[4][to_field]="id";
$rules[4][to_namefield]="name";
$rules[4][skipempty]="yes";

$rules[5][name]="สาขาห้องสมุดของสมาชิกที่ใช้งาน::l::Using Library Site";
$rules[5][fromsql]="select distinct libsite as var1,count(id) as ccdsp from member group by libsite";
$rules[5][to_tb]="library_site";
$rules[5][to_field]="code";
$rules[5][to_namefield]="name";

$rules[6][name]="สถานะของไอเทมที่ใช้งาน::l::Using Item's Status";
$rules[6][fromsql]="select distinct status as var1,count(id) as ccdsp from media_mid group by status";
$rules[6][to_tb]="media_mid_status";
$rules[6][to_field]="code";
$rules[6][to_namefield]="name";
$rules[6][skipempty]="yes";

$rules[7][name]="สถานที่จัดเก็บไอเทมที่ใช้งาน::l::Using Item's Shelves";
$rules[7][fromsql]="select distinct place as var1,count(id) as ccdsp from media_mid group by place";
$rules[7][to_tb]="media_place";
$rules[7][to_field]="code";
$rules[7][to_namefield]="name";

$rules[8][name]="สาขาห้องสมุดเจ้าของไอเทมที่ใช้งาน::l::Using Item's Library Site";
$rules[8][fromsql]="select distinct libsite as var1,count(id) as ccdsp from media_mid group by libsite";
$rules[8][to_tb]="library_site";
$rules[8][to_field]="code";
$rules[8][to_namefield]="name";

$rules[9][name]="ไอเทมที่โยงกับ Bib ID::l::Relation between item and Bib ID";
$rules[9][fromsql]="select pid as var1,count(id) as ccdsp from media_mid group by pid";
$rules[9][to_tb]="media";
$rules[9][to_field]="ID";
$rules[9][to_namefield]="tag245";
$rules[9][skipfound]="yes";


?>