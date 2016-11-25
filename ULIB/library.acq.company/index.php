<?php  //พ
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$tbname="acq_company";



$c[13][text]="Name::l::Name";
$c[13][field]="name";
$c[13][fieldtype]="text";
$c[13][descr]="";
$c[13][defval]="";

$c[2][text]="Address_1::l::Address_1";
$c[2][field]="address_1";
$c[2][fieldtype]="longtext";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Phone 1::l::Phone 1";
$c[3][field]="phone_1";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Phone 2::l::Phone 2";
$c[4][field]="phone_2";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Phone 3::l::Phone 3";
$c[5][field]="phone_3";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="Phone 4::l::Phone 4";
$c[6][field]="phone_4";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="Fax 1::l::Fax 1";
$c[7][field]="fax_1";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";

$c[8][text]="Fax 2::l::Fax 2";
$c[8][field]="fax_2";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="Fax 3::l::Fax 3";
$c[9][field]="fax_3";
$c[9][fieldtype]="text";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="Email 1::l::Email 1";
$c[10][field]="email_1";
$c[10][fieldtype]="text";
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="Email 2::l::Email 2";
$c[11][field]="email_2";
$c[11][fieldtype]="text";
$c[11][descr]="";
$c[11][defval]="";

$c[12][text]="Email 3::l::Email 3";
$c[12][field]="email_3";
$c[12][fieldtype]="text";
$c[12][descr]="";
$c[12][defval]="";

$c[14][text]="Note::l::Note";
$c[14][field]="note";
$c[14][fieldtype]="text";
$c[14][descr]="";
$c[14][defval]="";

//dsp

$dsp[13][text]="Name::l::Name";
$dsp[13][field]="name";
$dsp[13][width]="30%";

$dsp[14][text]="Note::l::Note";
$dsp[14][field]="note";
$dsp[14][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>