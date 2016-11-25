<?php 
function get_content($dbnamex, $table , $insertmode="") {
		$sql = "SHOW columns FROM $table";
		$result = tmq($sql);
		$my_col=Array();
		while ($r=tmq_fetch_array($result)) {
			$my_col[]=$r[0];
		}

        global $host;
        global $user;
        global $passwd;

		$connx=tmq_connect($host, $user, $passwd);
		/*$connx=tmq_select_db($dbnamex, $connx);
        if (!$connx) {
            die(getlang("ติดต่อกับ MYSQL Server ไม่ได้::l::Cannot connect to MYSQL Server"));
		}*/
		if (!$connx=tmq_select_db($dbnamex, $connx)) {
			die(getlang("ไม่สามารถเลือกใช้งานฐานข้อมูล [$dbnamex]::l::Cannot use specified database [$dbnamex]"));
		}
        global $conn;
        $content="";
        $result=tmq("SELECT * FROM $table",false,$connx);
        while ($row=tfa($result))
            {
            $insert = "INSERT $insertmode INTO $table set ";
            for ($j=0; $j < tmq_num_fields($result); $j++)
                {
				$insert.="$my_col[$j]=";
                if (!isset($row[$j]))
                    $insert.="NULL,";
                else if ($row[$j] != "")
                    $insert.="'" . addslashes($row[$j]) . "',";
                else
                    $insert.="'',";
                }
           // $insert=str_replace(",$", "", $insert);
            //$insert=str_replace(",\n", "", $insert);
				$insert=rtrim($insert);
				$insert=rtrim($insert,",");

            $insert.=";#%%\n";
            $content.=$insert;
            }
        return $content;
        }

?>