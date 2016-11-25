<?php 
    /*   * ***********************************************************************  * **  : Configuration File   **  * *************************************************************************  */
    /*ฟังก์ชั่นตรวจสอบ Login และ Password */
    function ChkLoginAdminroot($useradminid, $passwordadmin)
        {
        global $conn;
        $userSQL="Select * From useradmin Where UserAdminID='$useradminid'  ";
        //echo $userSQL; 
        $result=tmq($userSQL);
        if (!$result)
            die ("SELECT มีข้อผิดพลาด" . tmq_error());
        $num=tmq_num_rows($result);
        $rs=tmq_fetch_array($result);
	   if ($rs[Password]!=md5($passwordadmin)) {
		return false;
	   }

        if (empty($num))
            return false;
        else
            return "Root";
        }
?>
