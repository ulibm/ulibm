	<TABLE cellpadding=0 cellspacing=0 align=center border=0 width="<?php  echo $_TBWIDTH?>">

								<tr><td colspan=2 align=center ><BR>
<?php 
//
$upachideaddlink=barcodeval_get("webpage-o-upachideaddlink");
$upachideaddlink2=barcodeval_get("webpage-o-upachideaddlink2");
//

if (barcodeval_get("collections-showlink")=="yes") {
	if (is_array($usecollection) && count($usecollection)>0)	 {
		$bstr="<B>";
		$bcol="blue";
		$bstre="</B>";
		reset($usecollection);
		$tmpcoll="";
		while (list($collock,$collecv) = each($usecollection)) {
			if ($collecv=="yes") {
				$tmps=tmq("select * from collections where id='$collock' ");
				$tmps=tmq_fetch_array($tmps);
				$tmps[name]=getlang($tmps[name]);
				if ($tmps[name]!="") {
					$tmpcoll.=" ".$tmps[name];
				}
			}
		}
		$tmpcoll=trim($tmpcoll,'');
		$addstr=getlang(":ขณะนี้เลือก::l:::Selected").$tmpcoll;
	} else {
		$bstr="";
		$bcol="gray";
		$bstre="";
		$addstr="";
	}

	$gstr.="::$bstr".getlang("คอลเลกชั่น::l::Collections")."$bstre,./collections.php,$bcol,_self,".getlang("ค้นหาสารสนเทศจากคอลเลกชั่นต่าง ๆ::l::Search from collections").$addstr;
}

if ($upachideaddlink!="yes") {
 	$gstr.="::".getlang("วันปิดทำการ::l::Close Service").",./closeservice.php,gray,_self,".getlang("แสดงรายการวันปิดทำการ::l::Close service and holiday");
 	$gstr.="::".getlang("ประเภทวัสดุสารสนเทศ::l::Resource Type").",./resource_type.php,gray,_self,".getlang("สัญลักษณ์และประเภทของวัสดุสารสนเทศที่ให้บริการ::l::Code and rules for each material type");
}

	$_SESSION['marked']=@array_unique($_SESSION['marked']);
	if (is_array($_SESSION['marked']) && count($_SESSION['marked'])>0) {
		$exportmarkurl= "./exportmarked.php";
		$bstr="<B>";
		$bcol="blue";
		$bstre="</B>";
		$addstr=" ,".getlang("คุณ Mark ไว้จำนวน ".count($_SESSION['marked'])." รายการ::l::your marked  ".count($_SESSION['marked'])." record(s)")."";
	} else {
		$exportmarkurl= "javascript:alert('".getlang("คุณยังไม่ได้ Mark รายการใดไว้::l::No item marked")."');";
		$bstr="";
		$bcol="gray";
		$bstre="";						
		$addstr="";
	}
 	$gstr.="::$bstr".getlang("ส่งออกข้อมูล::l::Export marked")."$bstre,$exportmarkurl,$bcol,_self,".getlang("ส่งออกข้อมูลที่ Mark ไว้จากการสืบค้น::l::Export your marked record ").$addstr;


 	$gstr.="::".getlang("เรียงตามชื่อเรื่อง::l::By Title").",./search-browse-title.php,gray,_self,".getlang("เปิดดูข้อมูลทั้งหมด โดยเรียงตามชื่อเรื่อง::l::Browse all database, sorted by Title");
 	$gstr.="::".getlang("เรียงตามผู้แต่ง::l::By Author").",./search-browse-author.php,gray,_self,".getlang("เปิดดูข้อมูลทั้งหมด โดยเรียงตามผู้แต่ง::l::Browse all database, sorted by Author");
if ($upachideaddlink!="yes") {
 	$gstr.="::".getlang("หัวเรื่อง::l::Subjects").",./search-browse-subject.php,gray,_self,".getlang("เปิดดูข้อมูลหัวเรื่องทั้งหมด ::l::Browse all subject in database");
}
?>



 <BR>
<TABLE align=center border=0>
<TR>
	<TD align=center><?php 
	html_guidebtn($gstr);
?></TD>
</TR>
</TABLE>
 <?php 
$gstr="";
if ($upachideaddlink2!="yes") {
 	$gstr.="::".getlang("ติดต่อเจ้าหน้าที่::l::Contact librarian").",./contact.php,dark,_self,".getlang("ติดต่อเจ้าหน้าที่::l::Contact librarian");
 	$gstr.="::".getlang("กระดานข่าว::l::Webboard").",./webboard/index.php,dark,_self,".getlang("กระดานข่าว::l::Webboard");

 	$gstr.="::".getlang("ฐานข้อมูลใช้ฟรี::l::Free Database").",./freedb.php,dark,_self,".getlang("ฐานข้อมูลใช้ฟรี::l::Free Database");
}

if (barcodeval_get("rqroom-onoff")=="yes") {
	$gstr.="::".getlang("บริการให้จองห้อง::l::Request Room").",./requestroom1.php,dark,_self,".getlang("บริการให้จองห้อง::l::Request Room");
 }	
?><TABLE align=center>
<TR>
	<TD><?php 
	html_guidebtn($gstr);
?></TD>
</TR>
</TABLE>

 </td></tr>

<tr><td colspan=2><img src=g width=45 height=1>&nbsp;<span id="div2"></span> </td></tr>
</TABLE>	