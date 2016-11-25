<?php 
//set where you want to store files
//in this example we keep file in folder upload 
//$HTTP_POST_FILES['ufile']['name']; = upload file name
//for example upload file name cartoon.gif . $path will be upload/cartoon.gif
$dir="upload/".date("j");;
//$path= "$dir/".$_FILES['ufile']['name'];
$ext=explode(".",$_FILES['ufile']['name']);
//print_r($ext);
$ext=strtolower($ext[count($ext)-1]);
$path= "$dir/$storename-".date("H-i-s").".$ext";
@mkdir($dir);
//echo $ext;
//echo $path;
//die;
if ($ext!="xls" && $ext!="xlsx") {
	?>กรุณาอัพโหลดไฟล์ Excel เท่านั้น <br><a href="index.php">กลับ</a><?php 
	die;
}
//print_r($_FILES);
//echo $_FILES['ufile']['size'];
if(floor($_FILES['ufile']['size'])>1)
{
if(copy($_FILES['ufile']['tmp_name'], $path))
{
echo "อัพโหลดสำเร็จ :-)<BR/>";

//$HTTP_POST_FILES['ufile']['name'] = file name
//$HTTP_POST_FILES['ufile']['size'] = file size
//$HTTP_POST_FILES['ufile']['type'] = type of file
echo "ร้านค้า: $storename<BR/>"; 
echo "ขนาดไฟล์: ".$_FILES['ufile']['size']."<BR/>"; 
//echo "File Type :".$HTTP_POST_FILES['ufile']['type']."<BR/>"; 
//echo "File Type :".$HTTP_POST_FILES['ufile']['type']."<BR/>"; 
//echo "<img src=\"$path\" width=\"150\" height=\"150\">";
?><a href="index.php">กลับ</a><?php 
}
else
{
echo "Error";
}
}
?>