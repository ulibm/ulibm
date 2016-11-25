<?php 
function ConnDB($dbname_local="")
        {
        global $conn;
        global $host;
        global $user;
        global $passwd;
        global $dbmode;
        global $dbname;
		if ($dbname_local=="") {
			$dbname_local=$dbname;
		}
		if ($dbmode=="mysql") {
			$conn=mysql_connect($host, $user, $passwd);
			if (!$conn) {
				echo tmq_error();
				die(getlang("ติดต่อกับ MYSQL Server ไม่ได้::l::Cannot connect to MYSQL Server"));
			}
		}
		if ($dbmode=="mysqli") {
			//connect in select db
		}
		if ($dbmode=="mysql") {
			if (!mysql_select_db($dbname_local, $conn)) {
				echo tmq_error();
				die(getlang("ไม่สามารถเลือกใช้งานฐานข้อมูลได้ ($host, $user, $passwd)[$dbname]::l::Cannot use specified database [$dbname]"));
			}
		}
		if ($dbmode=="mysqli") {
			$conn=mysqli_connect($host, $user, $passwd, $dbname);
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		return $conn;
}

?>