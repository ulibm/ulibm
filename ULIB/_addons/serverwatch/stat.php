<?php 
include("../../inc/config.inc.php");
include("info.php");


$now=time();
 
      head();
   include("../chkpermission.php");
   include("../menu.php");
   include("func.php");


	$statdbstr[200]="Normal";
	$statdbstr[500]="500 Error";
	$statdbstr[000]="Error";
   
   if ($viewd=="yes") {
   $svdb=tmq_dump2("addonsdb_serverwatch","id","name");
   $sql="select *,cache as c from addonsdb_serverwatch_log where dat='$d' and mon='$m' and yea='$y' ";
   if ($hcode!="all") {
      $sql.="and hcode='$hcode' ";
   }
   if ($serverid!="") {
      $sql.=" and pid='$serverid' ";
   }
      $s=tmq($sql,false);
      while ($r=tfa($s)) {
         $d=stripslashes($r[cache]);
         $dat=unserialize($d); 
         //printr($r);
         $retval=$r[hcode];
         $outstr.="<b>".$svdb[$r[pid]]."</b> ".(ymd_datestr($r[dt])." [HTTP Code=$retval] ");
      if ($retval=="") {
         $retval="000";
      }
      if ("$retval"=="200") {
         $outstr.= "OK";
      }
      if ("$retval"=="404") {
         $outstr.= "Not found!";
      }
      if ("$retval"=="500") {
         $outstr.= "Server Error!";
      }
      if ("$retval"=="200") {
      //$dat=unserialize($dat);
      ///if 200, stage 2
      
      $outstr.= "<BR><font class=smaller>".$dat["server_software"]."</font>";
     if (is_array($dat[Disks])) {
      $outstr.= "<BR>Disks: ".$dat[Disks][SUM]."% free<BR>";
      @reset($dat[Disks]);
      while (list($k,$v)=each($dat[Disks])) {
         $total=($v[total]);
         $free=($v[free]);
         if ($total=="") { $total="-";}
         if ($free=="") { $free="-";}
         $outstr.= " <font class=smaller2><b style='color:#555555'>".$v[name]."</b> ".$free."/".$total."</font>";
      }
     }
     $outstr.= "<BR><b>CPU</b>:".$dat[CPU]."%";;
         //printr($dat);
      //echo $dat;

      ///if 200 e
      }
      if (is_array($dat) && is_array($dat[Processes])) {
         $outstr.= "<BR>Processes: <a href='javascript:void(null);'
         onclick=\"tmp=getobj('proc".$r[id]."'); tmp.style.display='block';\">
         ".@count($dat[Processes])."</a><BR>";
         @reset($dat[Processes]);
         $outstr.= "<div style='display:none' ID='proc".$r[id]."'>";
         while (list($k,$v)=each($dat[Processes])) {
            $outstr.= $v." ";
         }
         $outstr.= "</div>";
      }

      $outstr.= "<BR>";
         //echo "<BR>";
      }
      echo "<table width=1000 align=center><tr><td>$outstr</td></tr></table>";
      foot();
      die;
   }
   
   ?><?php
	//$statdb[200][sql]="add new member%";
	$statdb=Array();
$s=tmq("select distinct hcode from addonsdb_serverwatch_log order by hcode");
while ($r=tfa($s)) {
   if ($r[hcode]=="") {
      $r[hcode]="000";
   }
   $statdb[$r[hcode]]=getlang($statdbstr[$r[hcode]]);
   if ($statdb[$r[hcode]]=="") {
      $statdb[$r[hcode]]=$r[hcode];
   }
}



	//$sql1 ="SELECT distinctrow head  FROM $tbl where mon='$USEMON' and yea='$USEYEA' "; 

	//$sql2 = "$sql1 order by head";
//	$result=tmq($sql2);
?> 


<form method="post" action="<?php  echo $PHP_SELF?>">
	<TABLE width=620 align=center cellspacing=0 class=table_border>

<TR valign=top>
<TD width=50% class=table_head><?php 
echo getlang("Select Server.");
?></TD>
<TD class=table_td><?php 

form_quickedit("serverid",$libtoview,"foreign:-localdb-,addonsdb_serverwatch,id,name,allowblank");
?> 
  <input type="submit" value="<?php  echo getlang("เลือก::l::Select");?>">
</TD>
</TR>
</TABLE>
</form><BR>

<?php


	$start=time()-(60*60*24*30*10);
	$end=time();
	$alllen=Array();
	for ($dtrun=$start;$dtrun<=$end;$dtrun+=(60*60*24)) {
			$thisy=date("Y",$dtrun);
			$thism=date("n",$dtrun);
			$alllen[]="$thisy-$thism";
	}
	$alllen=array_unique($alllen);
	$alllen=array_slice($alllen,-12) ;
	$alllen=array_reverse($alllen);
	$mmonthi=0;
	//printr($alllen);

	while (list($dtrunk,$dtrunv)=each($alllen)) {
      @reset($tmpsum);
      	unset($tmpsum);
		$mmonthi++;

		$data=explode('-',$dtrunv);
		$USEYEA=$data[0];
		$USEMON=$data[1];
		$gmdatatitle[Description]["name$mmonthi"]=$thaimonstr[$USEMON]." ".( $USEYEA+543);
      
      ?><BR>
                <table width="<?php  echo $_TBWIDTH;?>" align=center border="0" cellspacing="1" cellpadding="3" class=table_border>
                  <tr bgcolor="#006699"> 
                    <td class=table_head rowspan=2 width=150>Statistics</td>
                    <td class=table_head  colspan=32>
										<?php echo $thaimonstr[$USEMON]; ?> <?php echo $USEYEA+543; ?></td>
			</tr>
                  <tr bgcolor="#006699"> 
<?php 
for ($i=1;$i<=31;$i++) {
	$tmp="0$i";
	$tmp=substr($tmp,-2);
?><td class=table_td align=center <?php 
	$today=date("N",mktime(0, 0, 0, $USEMON, $i, $USEYEA));
	if ($today==6) {
		echo " style='background-color: #BFDFFF' ";
	}
	if ($today==7) {
		echo " style='background-color: #FFB3B3' ";
	}
?> style="font-size: 12px;"><?php  echo $tmp?></td><?php 
}
echo "<td align=center class=table_td>-</td>";
?>
</tr>
                  <?php 
         $i=1; 
		 $monthi=0;
		 @reset($statdb);
         while(list($k,$v)=each($statdb)) {
			 $monthi++;
$rowsum[$row[head]]=0;
$ittt = ($startrow)+$i;
          echo"<tr bgcolor=#F2F2F2 height=2 valign=top>";
            echo"<td   class=table_td><font face='MS Sans Serif' size=3 color=#003366>";
			$tmplocaldsp= $v;
			echo getlang($tmplocaldsp);
			echo "</td>";
///collecting data
$USEMON=floor($USEMON);
	$dts=ymd_mkdt(1,$USEMON,$USEYEA);
	$dte=ymd_mkdt(1,$USEMON+1,$USEYEA);
//echo ymd_datestr($dts);echo ymd_datestr($dte);
	$t="select dat,count(id) as cc from addonsdb_serverwatch_log where dt<=$dte and dt>=$dts ";

	if ($serverid!="") {
      $t.="and  pid ='$serverid' ";
	}
	$t.=" and hcode='$k' group by dat";

	$t.="  ";
	$t=tmq($t,false);
	$tmp=Array();

while ($r=tmq_fetch_array($t)) {
        $r[dat2]=$r[dat];
	//printr($r);
	$tmp[floor($r["dat"])]=floor($r["cc"]);//=$r["aa"];
}
///collecting data-end
//printr($tmp);
	$gdatatitle[Description]["name$monthi"]=getlang($tmplocaldsp);

for ($i=1;$i<=31;$i++) {
	$col=$coldb[$tmp[$i]];
	if ($col=="") {
		$col="#ffcc00";
	}
	if ($tmp[$i]==0) {
		$col="#FFFFFF";
	}
	?><td class=table_td align=center style="font-size: 12px;"
	<?php 
	$today=date("N",mktime(0, 0, 0, $USEMON, $i, $USEYEA));
	if ($today==6) {
		echo " style='border-bottom-color: #BFDFFF; border-bottom-style: solid; border-bottom-width: 2' ";
	}
	if ($today==7) {
		echo " style='border-bottom-color: #FFB3B3; border-bottom-style: solid; border-bottom-width: 2' ";
	}
	$tmpsum[$i]=$tmpsum[$i]+$tmp[$i];
	$rowsum[$row[head]]=getlang($rowsum[$row[head]]+$tmp[$i]);
	$gdata[$monthi]["Serie$i"]=floatval($tmp[$i]);

	?> style="background-color: <?php  echo $col;?>;"	>
	<?php  
	if (floor($tmp[$i])!=0) {
	  echo "<a href='stat.php?y=$USEYEA&m=$USEMON&d=$i&hcode=$k&viewd=yes&serverid=$serverid' target=_blank>";
	}
	echo number_format($tmp[$i])?></a></td><?php 
}
echo "<td align=right class=table_td>". number_format($rowsum[$row[head]])."</td>";
echo "</tr>";

    $i++;
		$s = $i-1;	
       }
	  // echo $_pagesplit_btn_var;
 ?>

                  <tr bgcolor="#006699"> 

                    <td class=table_head rowspan=2 width=150>Sum</td>
										<?php 
$maxonsumthismonth=0;										
	for ($i=1;$i<=31;$i++) {
		$gmdata[$mmonthi]["Serie$i"]=floatval($tmpsum[$i]);
		if ($maxonsumthismonth<floor($tmpsum[$i])) {
		 $maxonsumthismonth=floor($tmpsum[$i]);
		}
		?><td class=table_td align=center ><?php  echo number_format($tmpsum[$i])?></td><?php 
	}
?><td class=table_head align=center ><?php  echo number_format(@array_sum($tmpsum))?></td>				</tr>


<tr bgcolor="#ffffff" valign=bottom height=50> 
<?php 
	for ($i=1;$i<=31;$i++) {
	?><td class=table_td align=center ><div 
	style="xxx; width: 100%; background-color: #999999!important; border:1px solid #dddddd; height: <?php echo floor(percent_cal($maxonsumthismonth,floor($tmpsum[$i]))/2);?>px">&nbsp;</div>
</td><?php 
	}
?><td class=table_head align=center > </td>
</tr>


<?php 

?>
</table><?php 
} //loopmonth
?><center>

<a href="index.php" class=a_btn>Back</a>

</center><?php
foot();
?>