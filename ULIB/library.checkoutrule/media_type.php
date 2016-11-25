<?php 
;
include("../inc/config.inc.php");
head();
$_REQPERM="checkoutrule";
$tmp=mn_lib();

pagesection($tmp);
if ($managing=="") {
	$managing="main";
}
$str=getlang("กำลังจัดการกฏการยืมคืนของสาขา <b>".get_libsite_name($managing)."</b>::l::manage checkrule for campus <b>".get_libsite_name($managing)."</b>");
html_dialog("Info","$str");
?>
<CENTER>
<form method="get" action="<?php  echo $PHP_SELF?>">
	<?php  echo getlang("หรือเลือกสาขาห้องสมุดอื่นเพื่อจัดการ::l::or choose another campus to manage");?> : 
	<?php  frm_libsite("managing",$managing);?> <input type="submit" value="<?php  echo getlang("เลือก::l::Manage"); ?>">
</form>
<BR>
<BR>
<B><?php  echo getlang("กรุณาเลือกประเภทวัสดุที่จะทำการแก้ไข::l::Please choose material type to edit "); ?></B> </CENTER><BR>
<?php 


	// หาจำนวนหน้าทั้งหมด

  $sql1 ="SELECT *  FROM media_type"; 

  if ($keyword <> "") { 

   $sql1= "$sql1 WHERE 1 and ((descr like '%$keyword%') or (UserAdminName 

like '%$keyword%'))"; 

  } 

	$sql2 = "$sql1 order by name ";

//echo $sql2;

	$result = tmqp($sql2,"media_type.php?keyword=$keyword&managing=$managing");

?> 
                <table width="<?php  echo $_TBWIDTH;?>" border="0" cellspacing="1" cellpadding="3" align=center class=table_border>

                  <tr bgcolor="#006699" class=table_head> 

                    <td width="2%" class="table_head"><b>

<nobr><?php  echo getlang("ลำดับที่::l::No."); ?></nobr></font></b></font></td>

                    <td><b><?php  echo getlang("รหัส::l::Code"); ?></font></b></font></td>

<td width=75% ><b><?php  echo getlang("ชื่อ::l::Name"); ?></td>

                  </tr>

                  <?php 

         $i=1; 

         while($row = tmq_fetch_array($result)){

	  $ID = $row[code];

               $name=$row[name];

$ittt = (($startrow))+$i;

      if ($i % 2 ==0) {

          echo"<tr valign=top bgcolor=#ffffff height=2>";

      } else {

          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";

      }             

            echo"<td><font >$ittt</font></td>";

            echo"<td><font  color=#003366>

<A HREF=\"checkout_rule.php?choosedmat=$ID&managing=$managing\"><B>$ID</B><BR>";
echo "<img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/mediatype/$row[code].png")==true) {
		echo  "$dcrURL/_tmp/mediatype/$row[code].png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "'>";

echo "</A> </font></a></td>";

            echo"<td><font >
<B>$name </B></font></a><BR>
	
<TABLE border=0>";
			$s2=tmq("select * from member_type order by type");
			$arr=Array();
			while ($r=tmq_fetch_array($s2)) {
				$arr[]=getlang($r[type]);
				echo "<TR><td width=20></td><TD class=smaller>".html_membertype_icon($r[type])."<U>".getlang($r[descr])."</U>&nbsp;&nbsp;&nbsp;</TD><TD class=smaller>";
				$s3=tmq("select * from checkout_rule where member_type='$r[type]' and media_type='$row[code]' and libsite='$managing' ",false);
				if (tnr($s3)==0) {
				  echo "<b style='color:red; font-weight:bold;' TITLE='Checkout Rule Not found!'>!!!!</b>";
				}
				$s3=tmq_fetch_array($s3); //printr($s3);
				if ($s3[cancheckout]=='yes') {
					echo getlang("ยืมออกได้ $s3[day] วัน ค่าปรับ $s3[fine] บาท::l::allow checkout $s3[day] day, fine $s3[fine] bath/day");
					if ($s3[fee]!=0) {
						echo getlang(" ค่าธรรมเนียมการยืม $s3[fee] บาท/เล่ม::l::, checkout fee $s3[fee] bath/item");
					}
					if (floor($s3[renew])!='0') {
						echo " ".getlang("ยืมต่อได้ $s3[renew] ครั้ง::l::allow $s3[renew] renew");
					} else {
						echo " ".getlang("ยืมต่อไม่ได้::l::cannot renew");
					}
				} else {
					echo getlang("ยืมออกไม่ได้::l::cannot checkout");
				}

				echo "</TD></TR>";
			}
		   echo "</TABLE>
</td>";

            $i2 = $i2 +1;  

//การดูสื่อประกอล

echo "</td>";

//echo "<td width=1% width=2 > <nobr><font size=1>$issn</nobr></td>";


           echo"</tr>";

    $i++;

		$s = $i-1;	

       } 

			   	echo $_pagesplit_btn_var;

 ?>

                </table>

<?php  

    tmq("delete from checkout_rule where media_type not in (select code from media_type) and member_type not in (select type from member_type)");


?>

        </form>

  <?php 
		foot();   
	   ?>