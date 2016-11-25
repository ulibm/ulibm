<?php // พ
    function get_def($dbname, $table,$isdropold="YES")
        {
        global $conn;
        $def="";
		if ($isdropold=="YES") {
			$def.="DROP TABLE IF EXISTS $table;#%%\n";
		}
        $def.="CREATE TABLE $table (\n";
        $result=tmq( "SHOW FIELDS FROM $table");
        while ($row=tmq_fetch_array($result))
            {
            $def .= "    `$row[Field]` $row[Type]";
            if ($row["Default"] != "")
                $def.=" DEFAULT '$row[Default]'";
            if ($row["Null"] != "YES")
                $def.=" NOT NULL";
            if ($row[Extra] != "")
                $def.=" $row[Extra]";
            $def.=",\n";
            }
        //$def=str_replace(",\n", "\n", $def);
        $def=rtrim($def);
        $def=rtrim($def,",");
        $result=tmq( "SHOW KEYS FROM $table");
        while ($row=tmq_fetch_array($result))
            {
            $kname = $row[Key_name];
            if (($kname != "PRIMARY") && ($row[Non_unique] == 0))
                $kname="UNIQUE|$kname";
            if (!isset($index[$kname]))
                $index[$kname]=array
                    (
                    );
            $index[$kname][]=$row[Column_name];
            }
        while (list($x, $columns)=@each($index))
            {
            $def .= ",\n";
            if ($x == "PRIMARY")
                $def.="   PRIMARY KEY (" . implode($columns, ", ") . ")";
            else if (substr($x, 0, 6) == "UNIQUE")
                $def.="   UNIQUE " . substr($x, 7) . " (" . implode($columns, ", ") . ")";
            else
                $def.="   KEY $x (" . implode($columns, ", ") . ")";
            }
        $result=tmq( "SHOW TABLE STATUS WHERE Name = '$table' ");
		$result=tmq_fetch_array($result);
		//printr($result); 
		$result=$result[Engine];
        $def.="\n) ";
		if (strtolower($result)!="myisam" && strtolower($result)!="innodb" ) {
			$def.=" ENGINE=$result ";
		}
		 //echo $def; die;
		///if ($table=="sessionval") {
		///	$def.=" ENGINE=MEMORY ";
		///}
		$def.=";#%%";
        return (stripslashes($def));
        }

?>