<?php             include ("../../inc/config.inc.php");
				include("../_REQPERM.php");
					loginchk_lib();// พ
		$target="$dcrs/_fulltext/cover/$mid";
		@mkdir($target);
		$now=time();
		$fname=randid().".jpg";
		$target.="/".$fname;
		//echo "[$target]";
		$s=tmq("select * from media where ID='$mid' ");
		if (tmq_num_rows($s)==0) {
			die("media $mid not found");
		}
		tmq("insert into media_ftitems set
		mid='$mid',
		filename='$fname',
		fttype='cover',
		text='Cover by ULIB Camcap',
		uploadtype='upload'
		");
		tmq("insert into media_edittrace set 
		login='$useradminid',
		dt='$now',
		bibid='$mid',
		edittype='upload cover by camera fulltext name=$fname [cover]'		");
      media_updatelastdt($mid,"ft");

     @copy("./file/temp$useradminid.jpg", $target); 
	@unlink("./file/temp$useradminid.jpg");
	redir("../mediacontent.php?mid=$mid&FTCODE=cover");
?>