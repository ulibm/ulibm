<?php //พ
function alerts($xxx) {
echo "<script language=javascript>";
$xxx=addslashes($xxx);
?>
xxx= 
window.open("","ALERTS","toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=500,height=300");
xxx.document.write("<body bgcolor=#FFFFFF text=#FF0000 link=#FF0000 vlink=#FF0000 alink=#FF0000>");
xxx.document.write("<center><B>");
  
xxx.document.write("<?php  echo $xxx?>");
<?php  
?>
xxx.document.write("<form >");
xxx.document.write("  <div align=center>");
xxx.document.write("    <input type=reset  value='   ปิดหน้าต่างนี้   ' onclick='self.close();'>");
xxx.document.write("  </div>");
xxx.document.write("</form>");
xxx.document.write("<script>"); 
xxx.document.write("setInterval('self.focus()',500)");
xxx.document.write("<\/script>");
<?php  
echo "</script>";
//die;
}
?>