<?php 
include("./cfg.inc.php");
include("./head.php");

$dr="./import/";

if ($isupload!="") {

$newname=$_FILES['file']['name'];
$purefilename=explode("-",$newname);
$purefilename=$purefilename[0];
// In PHP earlier then 4.1.0, $_FILES  should be used instead of $_FILES. 
//echo $_FILES['file']['name'] . "<BR>";
if ($file_size>$MAX_FILE_SIZE) {
	echo "ขนาดไฟล์ใหญ่เกินไปครับ";
	die();
}

if (strlen($_FILES['file']['tmp_name'])!=0) { 
   //copy($_FILES['file']['tmp_name'], "$dr" . $newname); 
} else { 
   echo "Possible file upload attack. Filename: " . $_FILES['file']['name']; 
   echo "ท่านไม่ได้เลือกไฟล์";
	   die;
} 

///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////

		$importFilename=$_FILES['file']['tmp_name'];
		/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../inc/phpexcel/Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


//$inputFileName = $dcrs."_input/import/$importFilename";
$inputFileName = $importFilename;
//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$now=time();

	for ($i=1;$i<=count($data);$i++) {
		//printr($data[$i]);die;
		if (trim($data[$i][B]).trim($data[$i][C]).trim($data['cells'][$i][D])=="") {
			continue;
		}
		$s="insert into acqn_sub  set id='',
		pid='$acqnid',
		isn='".addslashes($data[$i][B])."',
		titl='".addslashes($data[$i][C])."',
		auth='".addslashes($data[$i][D])."',
		yea='".addslashes($data[$i][E])."',
		copy='".addslashes($data[$i][F])."',
		price='".addslashes($data[$i][G])."',
		pricedis='".addslashes($data[$i][H])."',
		pricenet='".addslashes($data[$i][I])."',
		s_name='".addslashes($data[$i][J])."',
		s_stat='".addslashes($data[$i][K])."',
		s_subj='".addslashes($data[$i][L])."',
		s_email='".addslashes($data[$i][M])."',
		s_dt='$now',
		stat='suggest'
		";
		if ($setbyname=="yes") {
			$s.=", s_store='".addslashes($purefilename)."' ";
		}
		//print_r($_POST);echo $s;echo "<br>"; die;
		//die($s);
		@tmq( $s);
		//echo "$s<br>";

	}
	?><script type="text/javascript">
	<!--
		alert("นำเข้าจำนวน <?php  echo $i?> รายการ");
	//-->
	</script><?php 
	
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////

redir("index.php");
die;
//
}
?>
<br><br>
					  
					  <form name="form1" method="post" action="UPLOAD.php" enctype="multipart/form-data">
                        <table align=center border=0 cordercolor=666666 cellpadding=1 cellspacing=0>
                          <tr bgcolor="#FFFFFF"> 
                          <tr valign=middle bgcolor="#FFFFFF"> 

                            <td class=bodysepper> <font color="#000000">
							<?php  echo getlang("เลือกชื่อการเสนอราคาทรัพยากร::l::Select from list");?>
	<?php 
	$ps=tmq("select * from acqn where 1 order by id desc");
	?><select name="acqnid" >
	<?php 
	while ($psr=tfa($ps)) {
	?>
		<option value="<?php  echo $psr[id]?>" rel="yes"><?php  echo $psr[name]?> 
	<?php }?>
	</select><br>


<?php 
 echo getlang("อัพโหลดไฟล์::l::Upload ");
?>
                              <input type="file" name="file"> <input type="submit" name="Submit" value="   Upload   ">
                             <INPUT TYPE="hidden" name=isupload value=yes>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>"><br>
							<input type="checkbox" name="setbyname" checked value="yes" > <?php  echo getlang("ตั้งชื่อร้านค้าตามชื่อไฟล์::l::Set store name by file name");?> 
                              </font></td>
                          </tr>
						  </table>
                      </form>
					  <center>
					  <br><br>
					<?php  echo getlang("ตัวอย่างไฟล์ Excel::l::Excel file demo ");?> : <a href="./upload/demo.xls">Download</a><br>
					  <img src="exampleupload.png" width=800>
					  </center>
<CENTER><A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>
					  <?php 
foot();
?>