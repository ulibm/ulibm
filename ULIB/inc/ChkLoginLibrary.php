<?php 
    function ChkLoginLibrary($useradminid_local,$passwordadmin)
    {
       global $conn;
       global $ipautologin_system;
       $userSQL ="Select * From library Where UserAdminID='$useradminid_local'  ";
//echo "$userSQL";

					 $result = tmq($userSQL);
                 if(!$result)
                    die ("SELECT มีข้อผิดพลาด".tmq_error());
       $num = tmq_num_rows($result);
       $rs = tmq_fetch_array($result);
	   if ($ipautologin_system=="yes") {
		$passwordadminchk=$passwordadmin;
	   } else {
		$passwordadminchk=md5($passwordadmin);
	   }
	   if ($rs[Password]!=($passwordadminchk)) {
		return false;
	   }
	   if (strtoupper($rs[isallowlogin])!="YES") {
		return false;
	   }
        if($num==0) {
			return false;
        } else {
              return "Library";
		}
    }
?>