<?php 
function bibrating_recal($ID) {
	$now=time();
	$s=tmq("select * from media where ID='$ID' ",false);

	if (tmq_num_rows($s)==0) {
		tmq("delete from webpage_bibrating_sum where bibid='$ID' ");
		tmq("delete from webpage_bibrating_log where bibid='$ID' ");
		return;
	}
	
	$s=tmq("select * from webpage_bibrating_log where bibid='$ID' ",false);
	if (tmq_num_rows($s)==0) {
		tmq("delete from webpage_bibrating_sum where bibid='$ID' ");
	} else {
		$data=tmq("select count(id) as cc1, avg(score) as avg1 from webpage_bibrating_log where bibid='$ID' ",false);
		$data=tmq_fetch_array($data);
		$s=tmq("select * from webpage_bibrating_sum where bibid='$ID' ",false);
		if (tmq_num_rows($s)!=1) {
			tmq("delete from webpage_bibrating_sum where bibid='$ID' ");
			tmq("insert into webpage_bibrating_sum set bibid='$ID' , 
			dtcreate='$now' ,
			dtlast='$now' ,
			votescore='$data[avg1]' ,
			votecount='$data[cc1]'
			");
		} else {
			tmq("update webpage_bibrating_sum set 
			dtlast='$now' ,
			votescore='$data[avg1]' ,
			votecount='$data[cc1]'

			where bibid='$ID' 
			");
		}
		//update index_db พ
		tmq("update index_db set bibrating ='$data[avg1]' where mid='$ID' ");
	}
}
?>