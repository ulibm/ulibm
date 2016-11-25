<?php // พ
function addmedia($acq,$media) {
	tmq("delete from acq_mediasent where acq='$acq' and media='$media'  ");
	tmq("insert into acq_mediasent set acq='$acq' ,media='$media'  ");
}


function delmedia($acq,$media) {
	tmq("delete from acq_mediasent where acq='$acq' and media='$media'  ");
}
?>