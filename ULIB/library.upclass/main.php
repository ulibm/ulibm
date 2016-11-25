<?php 
	; 
function localoperation($sub,$setid) {
   while (list($k,$v)=each($sub)) {
      //printr($v);
      $cc=tmq("select count(id) as cc from member where room='$v[id]' ");
      $ccr=tfa($cc);
      $ccstr="";
      if (floor($ccr[cc])!=0) {
         $ccstr="(".$ccr[cc].")";
      }
      echo "<tr class=table_dr><td align=right class=table_td> ".get_room_name($v[id])." $ccstr</td>";
      if (floor($v[moveto])!=0) {
         echo " <td width=70 align=center class=table_td>move to</td><td class=table_td> ".get_room_name($v[moveto]) ." <B></b>";
         $smem=tmq("select * from member where room='$v[id]' ");
         while ($smemr=tfa($smem)) {
            $sql1="insert into upclass_hist_sub set pid='$setid', from1='$smemr[room]', to1='$v[moveto]',memberid='$smemr[UserAdminID]'";
            tmq($sql1,false);
            tmq("update member set room='$v[moveto]' where room='$v[id]' and UserAdminID='$smemr[UserAdminID]' ");
         }         
         echo "</td>";       
      }
      echo "</tr>";
      //printr($sub);
      if (count($v[members])>0) {
         localoperation($v[members],$setid);
      }
   }
}
   
   function localfetchsub($wh,$moveto=0) {
      global $donelog;
      if (in_array($donelog,$wh)) {
         die ("Looped:".get_room_name($wh));
      }
      //printr($donelog); echo "[$wh]"; die;
      $donelog[]=$wh;
      $s=tmq("select * from upclass_rule where to1='$wh' ",false);

      $tmp=Array();
      $tmpres=Array();
      $i=0;
      $tmpres[id]=($wh);
      $tmpres[moveto]=($moveto);
      $tmpres[name]=get_room_name($wh);

      while ($r=tfa($s)) {
         $i++;
         //echo ""
         //if (!is_array($tmp[$r[to1]])) $tmp[$r[to1]]=Array();
         //$tmp[$i]=Array();
         $tmp[]=localfetchsub($r[from1],$wh);
      } 
      //printr($tmp);die;
      $tmpres[members]=$tmp;
      return $tmpres;
   }
   $donelog=Array();
   $a=Array();
   //find destinations;
   $s=tmq("select * from room where id in (select to1 from upclass_rule) and id not in (select from1 from upclass_rule)");
   if (tnr($s)==0) {
      html_dialog("error","No data, or looped setting");
   } else {
      while ($r=tfa($s)) {
         //printr($r);
         $donelog[]=$r[id];
         //$a[$r[id]]=Array();
         $a[$r[id]]=localfetchsub($r[id]);
         //printr($a);
      }
      //printr($a);
      //printr($donelog);
   }
////////////////////////////////////////////////////////////////////////////////////////////


//printr($a);
function localloopdsp($sub,$depth=0) {
   while (list($k,$v)=each($sub)) {
      //printr($v);
      $cc=tmq("select count(id) as cc from member where room='$v[id]' ");
      $ccr=tfa($cc);
      $ccstr="";
      if (floor($ccr[cc])!=0) {
         $ccstr="(".$ccr[cc].")";
      }
      echo "<div style='padding-left: ".($depth*25)."px;'><img border=0 src='arrow.png' style='' align=baseline width=16 height=16> ".$v[name]." <B>$ccstr</b></div>";
      if (count($v[members])>0) {
         localloopdsp($v[members],$depth+1);
      }
   }
}
$w=200;
@reset($a);
   if( $mode=="operation") {
      echo "<table width=$_TBWIDTH align=center>";
      $setid=randid();
      //echo $setid;
      $now=time();
      tmq("insert into upclass_hist set dt=$now,loginid='$useradminid',code='$setid'");
      localoperation($a,$setid);
      echo "</table>
<center><font style='font-size: 48px; color: darkgreen'>Done.</font></font>
      ";
      die;
   }
   @reset($a);

while (list($k,$v)=each($a)) {

?><table width=<?php echo $_TBWIDTH;;?> align=center>
<tr><td>
<b><?php echo $v[name];?></b><BR>
<div id="top-to-bottom">
<?php
//printr($v);
localloopdsp($v[members],1);

 ?>
 </div>
</td></tr></table><?php
}




?><BR><BR><BR>
<center><a href="index.php?mode=operation" class="a_btn bigger" style='color:red;'
onclick="return confirm('Please Confirm');"
><?php echo getlang("ดำเนินการ::l::Process now");?></a></center>