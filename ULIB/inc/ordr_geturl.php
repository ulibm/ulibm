<?php 
function ordr_geturl($a,$tbl,$condition,$conditionval,$field,$primary,$id,$direct) {
	////func("ordr_geturl");
	/*
	a - url ฐานที่จะ redir back
	condition - ชื่อฟิลด์ที่จำกำหนด scope การเปลี่ยน
	conditionval - ค่าในฟิลด์ที่จะใช้กรอง
	field - ปกติเป็น ordr
	primary - ชื่อฟิลด์ที่เป็น Primary
	id - id ของฟิลด์ Primary ที่จะเปลี่ยน
	direct - up หรือ down
	*/
	return "a=$a&tbl=$tbl&condition=$condition&conditionval=$conditionval&field=$field&primary=$primary&id=$id&direct=$direct";
}
?>