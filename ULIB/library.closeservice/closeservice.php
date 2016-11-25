<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
if ($managing=="") {
	$managing="main";
}

$str=getlang("กำลังจัดการวันปิดทำการของสาขา <b>".get_libsite_name($managing)."</b>::l::manage close service for campus <b>".get_libsite_name($managing)."</b>");
html_dialog("Info","$str");
?>
<CENTER>
<form method="get" action="<?php  echo $PHP_SELF?>">
	<?php  echo getlang("หรือเลือกสาขาห้องสมุดอื่นเพื่อจัดการ::l::or choose another campus to manage");?> : 
	<?php  frm_libsite("managing",$managing);?> <input type="submit" value="<?php  echo getlang("เลือก::l::Manage"); ?>">
</form>
<BR>
<BR>
<B><?php 
?>
                    <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
                        <tr valign = "top">
                            <td>
                                <form name = "form1" action = "DBddal.php" method = "post">
                                    <table width = "100%" border = "0" cellspacing = "1" cellpadding = "3">
                                        <tr align = "center">
                                            <td colspan = "3">
                                                <div align = "left">
                                                    <font size = "2" face = "MS Sans Serif, Microsoft Sans 
Serif"><a href = "addclose.php?managing=<?php echo $managing;?>" class=a_btn><?php  echo getlang("เพิ่มวันปิดบริการ::l::Add"); ?> </a>
                                <?php 
                                    $sql1="SELECT *  FROM closeservice where libsite='$managing' ";
                                    $sql2="$sql1 order by yea , mon DESC, dat DESC ";
                                    $result=tmqp( $sql2,"closeservice.php?");
                                ?>
                                                </div>
	<table width = "780" align=center border = "0" cellspacing = "1" cellpadding = "3" class=table_border>
		<tr bgcolor = "#006699">
			<td width = "2%" class=table_head>
				<nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></td>
			<td class=table_head><?php  echo getlang("รายการวันปิดทำการ::l::Date"); ?> </td>
			<td class=table_head width = 30%><?php  echo getlang("คำอธิบาย::l::Description"); ?></td>
			<td class=table_head width = "13%"><?php  echo getlang("ลบ::l::Delete"); ?></td>
		</tr>
                                <?php 
                                    $i=1;
                                    while ($row=tmq_fetch_array($result))
                                        {
                                        $DatabaseID=$row[DatabaseID];
                                        $yea=$row[yea];
                                        $mon=$row[mon];
                                        $dat=$row[dat];
                                        $mID=$row[id];
                                        $mDescr=$row[descr];
                                        if ($mDescr == "") { $mDescr=""; }
                                        $ittt=($startrow) + $i;
                                        if ($i % 2 == 0) { echo "<tr valign=top bgcolor=#ffffff height=2>"; }
                                        else { echo "<tr bgcolor=#F2F2F2 height=2 valign=top>"; }
                                        echo "<td><font face='MS Sans Serif' size=2>$ittt</font></td>";
                                        echo "<td><font face='MS Sans Serif' size=2 color=#003366>
 $dat " . $thaimonstr[$mon] ." ";
 if ($yea==-1) {
	echo getlang("ของทุกปี::l::Every year");
 } else {
	echo $yea;
 }
 echo " </font></a>";
                                        echo "</td>";
                                        //echo "<td>&nbsp;$mDescr</td>";
                                        echo "<td> <font size=2 face='MS Sans Serif'> &nbsp;$mDescr";
                                        //การดูสื่อประกอล
                                        echo "</td>";
                                        echo "<td align=center><font face='MS Sans Serif' size=2><a 
href='delclose.php?ID=$mID&managing=$managing' onclick='return confirm(\" $cfrm\")'>".getlang("ลบ::l::Delete")."</a>";
                                        echo "</tr>";
                                        $i++;
                                        $s=$i - 1;
                                        }
											echo $_pagesplit_btn_var;
                                ?>
                                                </table>
                                                <?php 
                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table><?php foot();?>