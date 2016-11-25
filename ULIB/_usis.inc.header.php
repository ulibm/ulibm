<?php 

function local_media_usisheadtr() {
global $local_media_headtr_firsttime;
$local_media_headtr_firsttime="no";
?>
<tr bgcolor = "#666666">
      <td width = "30" align = center>
          <font color = "#FFFFFF"><nobr><b><font face = "MS Sans Serif" size = "2"><?php  echo getlang("ลำดับ::l::No."); ?></font></b> </font></td>
      <td width = "100">
          <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr>
          <CENTER>
<?php  echo getlang("เลขหมู่::l::CallNumber"); ?> </CENTER> </font></b></font></td>

      <td  align = center >
          <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"> <?php  echo getlang("ชื่อผู้แต่ง / ชื่อเรื่อง::l::Author / Title"); ?> </td>
<td width=120 align=center>
          <font color = "#FFFFFF"><b><font face = "MS Sans Serif" size = "2"><nobr><?php  echo getlang("รายละเอียด::l::Full detail"); ?>/Fulltext </font></b></font></td>
  </tr>

<?php 
}

?>