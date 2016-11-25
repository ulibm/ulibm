<?php  //พ
header('Content-type: application/x-javascript');
include("../inc/config.inc.php");
?>
var cstep="none";

function local_focusme() {
	tmp=getobj("input1"); tmp.value=""; tmp.focus(); 
}

function b_cancel() {
	cur_member="";
	local_focusme();
	tmp=getobj("menu_main");
	tmp.style.display='block';
	tmp=getobj("menu_maincancel");
	tmp.style.display='none';
	tmp=getobj("menu_finish");
	tmp.style.display='none';
	tmp=getobj("mainif");
	tmp.src='./galleria/index.php?code='+base_code;
	cstep="none";
}

function b_out() {
	local_focusme();
	cstep="out_waitmember";
	tmp=getobj("menu_main");
	tmp.style.display='none';
	tmp=getobj("menu_finish");
	tmp.style.display='none';
	tmp=getobj("menu_maincancel");
	tmp.style.display='block';
	tmp=getobj("mainif");
	tmp.src='run.out1.php?id='+base_code;
}
function b_in() {
	local_focusme();
	cstep="in_waitcheckin";
	tmp=getobj("menu_main");
	tmp.style.display='none';
	tmp=getobj("menu_finish");
	tmp.style.display='block';
	tmp=getobj("menu_maincancel");
	tmp.style.display='none';
	tmp=getobj("mainif");
	tmp.src='run.in.php?id='+base_code;
}
function b_finish() {
	if (cstep=="in_waitcheckin") {
		local_focusme();
		cstep="out_waitprint";
		tmp=getobj("menu_main");
		tmp.style.display='none';
		tmp=getobj("menu_finish");
		tmp.style.display='none';
		tmp=getobj("menu_maincancel");
		tmp.style.display='block';
		tmp=getobj("mainif");
		tmp.src='run.waitprint.in.php?id='+base_code;
	} else {
		local_focusme();
		cstep="out_waitprint";
		tmp=getobj("menu_main");
		tmp.style.display='none';
		tmp=getobj("menu_finish");
		tmp.style.display='none';
		tmp=getobj("menu_maincancel");
		tmp.style.display='block';
		tmp=getobj("mainif");
		tmp.src='run.waitprint.php?id='+base_code+'&memberbarcode='+cur_member;
	}
}
function showfinish() {
	tmp=getobj("menu_main");
	tmp.style.display='none';
	tmp=getobj("menu_finish");
	tmp.style.display='none';
	tmp=getobj("menu_maincancel");
	tmp.style.display='none';
	tmp=getobj("menu_finish");
	tmp.style.display='block';
}

function local_handleform() {
	valobj=getobj("input1");
	val=valobj.value;
	//alert('local_handleform '+cstep+" cur_member="+cur_member);
	if (cstep=="out_waitmember") {
		tmp=getobj("mainif");
		tmp.src='run.out2.php?memberbarcode='+val+'&id='+base_code;
		
		local_focusme();
		return;
	} 
	if (cstep=="out_waitmemberpassword") {
		tmp=getobj("mainif");
		tmp.src='run.out2.php?memberbarcode='+cur_member+'&pin='+val+'&id='+base_code;
		local_focusme();
		return;
	}
	if (cstep=="out_waitmats") {
		tmp=getobj("mainif");
		tmp.src='run.out3.php?memberbarcode='+cur_member+'&mediabarcode='+val+'&id='+base_code;
		local_focusme();
		return;
	}
	if (cstep=="in_waitcheckin") {
		tmp=getobj("mainif");
		tmp.src='run.in.php?firstscreen=yes&mediabarcode='+val+'&id='+base_code;
		local_focusme();
		return;
	}

}