<?php include("./cfg.inc.php");
include("./head.php");
limitpage_var();


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

		$importFilename=$file;
		
require_once "./xls_csv_parser/reader.php";


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
$data->setOutputEncoding('TIS620');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/

/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read($_FILES['file']['tmp_name']);
//echo ($dcrs.'/_input/import/'.$importFilename);

$now=time();
error_reporting(E_ALL ^ E_NOTICE);

	for ($i=1;$i<=$data->sheets[0]['numRows'];$i++) {
		if (trim($data->sheets[0]['cells'][$i][(2)]).trim($data->sheets[0]['cells'][$i][(3)]).trim($data->sheets[0]['cells'][$i][(4)])=="") {
			continue;
		}
		$s="insert into acqn_sub  set id='',
		pid='$acqnid',
		isn='".addslashes($data->sheets[0]['cells'][$i][(2)])."',
		titl='".addslashes($data->sheets[0]['cells'][$i][(3)])."',
		auth='".addslashes($data->sheets[0]['cells'][$i][(4)])."',
		yea='".addslashes($data->sheets[0]['cells'][$i][(5)])."',
		copy='".addslashes($data->sheets[0]['cells'][$i][(6)])."',
		price='".addslashes($data->sheets[0]['cells'][$i][(7)])."',
		pricedis='".addslashes($data->sheets[0]['cells'][$i][(8)])."',
		pricenet='".addslashes($data->sheets[0]['cells'][$i][(9)])."',
		s_name='".addslashes($data->sheets[0]['cells'][$i][(10)])."',
		s_stat='".addslashes($data->sheets[0]['cells'][$i][(11)])."',
		s_subj='".addslashes($data->sheets[0]['cells'][$i][(12)])."',
		s_email='".addslashes($data->sheets[0]['cells'][$i][(13)])."',
		s_dt='$now',
		stat='suggest'
		";
		if ($setbyname=="yes") {
			$s.=", s_store='".addslashes($purefilename)."' ";
		}
		//print_r($_POST);echo $s;echo "<br>"; die;
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

                            <td class=bodysepper> <font color="#000000"> 								เลือกชื่อการเสนอราคาทรัพยากร
	<?php 
	$ps=tmq("select * from acqn where 1 order by id desc");
	?><select name="acqnid" >
	<?php 
	while ($psr=tfa($ps)) {
	?>
		<option value="<?php  echo $psr[id]?>" rel="yes"><?php  echo $psr[name]?> 
	<?php }?>
	</select><br>


อัพโหลดไฟล์
                              <input type="file" name="file"> <input type="submit" name="Submit" value="   Upload   ">
                             <INPUT TYPE="hidden" name=isupload value=yes>
                              <input type="hidden" name="MAX_FILE_SIZE" value="<?php  echo $_GLOBAL_UPLOADSIZE;?>"><br>
							<input type="checkbox" name="setbyname" checked value="yes" > ตั้งชื่อร้านค้าตามชื่อไฟล์ 
                              </font></td>
                          </tr>
						  </table>
                      </form>
					  <center>
					  <br><br>
					ตัวอย่างไฟล์ Excel<br>
					  <img src="exampleupload.png" width=800>
					  </center>
<CENTER><A HREF="index.php"><B><?php  echo getlang("กลับ::l::Back"); ?></B></A></CENTER>
					  <?php 
foot();
?>