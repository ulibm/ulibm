<?php 
	; 
		
        include ("../inc/config.inc.php");
        
        
$tblist=tmq("show tables");
$t=Array();
while ($r=tmq_fetch_array($tblist)) {
	$t[]=$r[0];
}



        $remotegenval=trim($remotegenval);
        $remotegenval=base64_decode($remotegenval);
        $remotegenval=trim($remotegenval);
        $remotegen=trim($remotegen);
        $remotegen=base64_decode($remotegen);
        $remotegen=trim($remotegen);
        //echo "[remotegen=$remotegen]";
        if ($remotegen!="") {
            $isgen="yes";
            $t=explode(",",$remotegen);
            @reset($t);
            while (list($k,$v)=each($t)) {
               if ($v=="library") die("disable table library");
               if ($v=="useradmin") die("disable table useradmin");
            }
            @reset($t);
            //echo "[remotegen=$remotegen]";
            //die;
        } elseif ($remotegenval!="") {
            $isgenval="yes";
            $isgenval_list=$remotegenval;
            $t=explode(",",$remotegenval);
            @reset($t);
            while (list($k,$v)=each($t)) {
               $chk=explode("=",$v);
               $v2=$chk[0];
               if ($v2=="library") die("disable table library");
               if ($v2=="useradmin") die("disable table useradmin");
            }
            @reset($t);
        } else {
            head();
            mn_root("dbmorph");

            pagesection(getlang("DB Morph"));
        }
        
        
        
   ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////

   ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////


$resval=Array();
if ($isgenval=="yes") {
   $t=explode(",",$isgenval_list);
   @reset($t);
   while (list($k,$v)=each($t)) {
      $v2=explode("=",$v);//printr($v2);
      $table=$v2[0];
      $tbkeys=$v2[1];
      $tbonlyfields=$v2[2];
      $tbonlyfields=trim($tbonlyfields);
      $tbonlyfields=explode("-",$tbonlyfields); //printr($tbonlyfields);
      $tbonlyfieldsa=$tbonlyfields;
      $tbonlyfields=implode("','",$tbonlyfields);
      $tbonlyfields="'".$tbonlyfields."'";
      //echo "[$tbonlyfields]";
      $tbkeysa=explode("-",$tbkeys);
      $resval[$table]=Array();
      $resval[$table][control]=Array();
      $resval[$table][control]=$tbkeys;
      $resval[$table][data]=Array();
      $resvalultm=tmq( "select * FROM $table");
      while ($row=tmq_fetch_array($resvalultm)) {
         $rowkey="";
         @reset($tbkeysa);
         $limitsql="";
         while (list($ktbkeysa,$vtbkeysa)=each($tbkeysa)) {
            $rowkey=$rowkey."____".$vtbkeysa."=".$row[$vtbkeysa];
            $limitsql.="$vtbkeysa='$row[$vtbkeysa]' and ";
         }
         $rowkey=ltrim($rowkey,"_");
         $limitsql=rtrim($limitsql,"and ");
         $resval[$table][data][$rowkey]=Array();
         //getcontents
            $sql = "SHOW columns FROM $table";

            //die("[$sql]");
            $resvalult = tmq($sql);
            $my_col=Array();
            while ($r=tmq_fetch_array($resvalult)) {
               $my_col[]=$r[0];
            } //printr($my_col); 
            $insert = "";
                  for ($j=0; $j < tmq_num_fields($resvalultm); $j++) {
                     if ($my_col[$j]=="id") continue;
                     //echo "[$tbonlyfields]";
                     if ($tbonlyfields!="" && $tbonlyfields!="''" && !in_array($my_col[$j],$tbonlyfieldsa)) continue;
                     //echo "$j=".$my_col[$j]."<BR>";

                     $insert.="$my_col[$j]=";
                     if (!isset($row[$j]))
                        $insert.="NULL,";
                     else if ($row[$j] != "") {
                        if ($destencode=="th") {
                           $row[$j]=iconvth($row[$j]);
                        }
                        if ($destencode=="utf") {
                           $row[$j]=iconvutf($row[$j]);
                        }
                        $insert.="'" . addslashes(addslashes($row[$j])) . "',";
                     } else {
                        $insert.="'',";
                     }
                  }
                  // $insert=str_replace(",$", "", $insert);
                  //$insert=str_replace(",\n", "", $insert);
                  $insert=rtrim($insert);
                  $insert=rtrim($insert,",");

                  $insert.=";#%%\n";
                  //echo "<pre>$insert</pre>";
          //getcontents e
            $resval[$table][data][$rowkey][data]=$insert;
            $resval[$table][data][$rowkey][limit]=$limitsql;
      }
      //$resval[$v][FULLCREATE]=get_def($dbname,$v,"NO");
   }
   
   //echo "[remotegen=$remotegen]"; die;
if ($remotegenval!="") {
   echo base64_encode(serialize($resval));
   die;
}
      //printr($resval);
   if ($remotegen=="" && $remotegenval=="") {

      ?>
      <center>
      <FORM METHOD=POST ACTION="index.php">
   <?php echo $isgenval_list ?><BR>
   <textarea style="width: 800px; height: 220px;"><?php 
   //printr($resval);
   echo base64_encode(serialize($resval)); //?></textarea>
   </FORM></center>
   <hr><BR><BR><BR><BR><BR>
   <?php
   }
}
   ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////

$res=Array();
if ($isgen=="yes") {
   @reset($t);
   while (list($k,$v)=each($t)) {
      $res[$v]=Array();
      $result=tmq( "SHOW FIELDS FROM $v");
      while ($row=tmq_fetch_array($result)) {
         $def = "    `$row[Field]` $row[Type]";
         if ($row["Default"] != "")
            $def.=" DEFAULT '$row[Default]'";
         if ($row["Null"] != "YES")
            $def.=" NOT NULL";
         if ($row[Extra] != "")
            $def.=" $row[Extra]";
         $res[$v][$row[Field]]=$def;
      }
      $res[$v][FULLCREATE]=get_def($dbname,$v,"NO");
      //break;
   }
   //printr($res);
      ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////

   ////////////////////////////////////////////////////////////////////////////
   ////////////////////////////////////////////////////////////////////////////

if ($remotegen!="") {
   echo base64_encode(serialize($res));
   die;
}
      //printr($resval);
   if ($remotegen=="" && $remotegenval=="") {

      ?>
      <center>
      <FORM METHOD=POST ACTION="index.php"   onsubmit="return confirm('Morph confirmation')">
      <INPUT TYPE="hidden" name=ismorph value="yes">
      <textarea style="width: 800px; height: 220px;"><?php echo base64_encode(serialize($res));?></textarea>

      </FORM></center>
      <hr><BR><BR><BR><BR><BR>
      <?php
   }
}

if ($ismorph=="yes") {
   echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($morphdata);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         if (in_array($k,$t)) {
            echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:existed";
         } else {
            echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:not existed, creating..";
            //$tbstruct=
            tmq($v[FULLCREATE]);
         }
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields:";
         
        $result=tmq( "SHOW FIELDS FROM $k");
        $thistbhavef=Array();
        while ($row=tmq_fetch_array($result)) {
          $thistbhavef[]=$row[Field];
        }
        //printr($thistbhavef);
         while (list($k2,$v2)=each($v)) {
            if ($k2=="FULLCREATE") continue;
            if (in_array($k2,$thistbhavef)) {
               echo "<font style='color:darkgreen'>&bull;$k2</font>  ";
            } else {
               echo "<font style='color:red'>&bull;$k2 ..creating</font>  ";
               tmq("alter table $k add ".$v2);
            }
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}


?><BR>
<TABLE width=500 align=center>
<TR>
	<TD><B>Select Options</B></TD>
</TR>
<?php 


?>



<TR>
	<TD>
	<FORM METHOD=POST ACTION="index.php" >
<INPUT TYPE="hidden" name=isgen value="yes">
<INPUT TYPE="submit"value="Generate From This DB">
</FORM>
<BR>
or
</TD>
</TR>


<TR>
	<TD><FORM METHOD=POST ACTION="index.php"   onsubmit="return confirm('Morph confirmation')">
<INPUT TYPE="hidden" name=ismorph value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="Morph This DB">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><?php 


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


			pagesection(getlang("DB Morph [val]")); 
	$ttmp=explode(",","val=main-sub,library_modules=code,library_modules_cate=code,library_modules_topcate=code,libsite_bibmodules=code,libsite_modules=code,media_mid_status=code,barcode_val=classid,index_ctrl=code,webbox_boxtype=classid,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_wiki_status=code,memcard_itype=code,memcard_var=code,libsite_vars=code,libsite_modules=code");;



if ($ismorphval=="yes") {
   echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($morphdata);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
   //printr($morphdata); die;
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking record(s):<BR>";
         $tmpc=$v[data];
         @reset($tmpc);
         while (list($k2,$v2)=each($tmpc)) {
            $k2dsp=str_replace("___",",",$k2);
            $chk=tmq("select id from $k where ".stripslashes($v2[limit]));
            if (tnr($chk)==1) {
               echo "[<font color=darkgreen>$k2dsp</font>] ";
            } else {
               echo "[<font color=red>$k2dsp</font>] ";
               $v2[data]=rtrim($v2[data],"%#\n ");
               tmq("insert into $k set ".stripslashes($v2[data]));
            }
            //$
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}


?><BR>
<TABLE width=500 align=center>
<TR>
	<TD><B>Select Options</B></TD>
</TR>
<?php 


?>



<TR>
	<TD>
	<FORM METHOD=POST ACTION="index.php" >
<INPUT TYPE="hidden" name=isgenval value="yes">
<textarea name=isgenval_list style="width:700px; height: 80px;"><?php  echo implode(",",$ttmp);?></textarea><BR>
<INPUT TYPE="submit"value="Generate From This DB">
<BR>
Destination Encode: <?php  form_quickedit("destencode",$destencode,"list:none,th,utf");?>
<BR>Print template set: printtemplate=id,printtemplate_align=code,printtemplate_itype=code,printtemplate_sub=code,printtemplate_sub_i=id,printtemplate_var=code
<BR>MemberCard template set: memcard_itype=code,memcard_var=code
<BR>MemberCard Value set: memcard_sub_i=id,memcard=code
<BR> Registry Set: val=main-sub,barcode_val=classid
<BR> Web Set: webbox_boxtype=classid,webbox_sepper_type=code,webbox_tabs_type=code,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_hpsidebar_tabs_type=code,webpage_hpsidebar_type=code,webpage_menu_type=code,webpage_wiki_status=code
<BR>
For update part of table: val=main-sub=descr,library_modules=code,library_modules_cate=code,library_modules_topcate=code,libsite_bibmodules=code,libsite_modules=code,media_mid_status=code,webbox_boxtype=classid,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_wiki_status=code
<BR>
Force set val ok: library_modules=code,library_modules_cate=code,library_modules_topcate=code,libsite_bibmodules=code,libsite_modules=code,webbox_boxtype=classid,webbox_topmenu_type=code,webmobile_menu_type=code,webpage_wiki_status=code,memcard_itype=code,memcard_var=code,libsite_vars=code,libsite_modules=code
</FORM>
<BR>
or
</TD>
</TR>


<TR>
	<TD><FORM METHOD=POST ACTION="index.php"   onsubmit="return confirm('Morph confirmation')">
<INPUT TYPE="hidden" name=ismorphval value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="Morph This DB">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><BR>
<TABLE width=500 align=center>

<?php 


if ($ismorphupdateval=="yes") {
   echo "<table align=center width=$_TBWIDTH><tr><td>";
   $morphdata=base64_decode($morphdata);
   $morphdata=unserialize($morphdata);
   if (!is_array($morphdata)) {
      html_dialog("","Invalid data , could not unserialize");
   } else {
   //printr($t);
   //printr($morphdata); die;
      @reset($morphdata);
      while (list($k,$v)=each($morphdata)) {
         echo "<b style='color: darkred;'>$k</b><BR>";
         echo "<BR> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checking record(s):<BR>";
         $tmpc=$v[data];
         @reset($tmpc);
         while (list($k2,$v2)=each($tmpc)) {
            $k2dsp=str_replace("___",",",$k2);
            $v2[data]=rtrim($v2[data],"%#;\n ");
            ////////////////////create if not exists
            $chk=tmq("select id from $k where ".stripslashes($v2[limit]));
            if (tnr($chk)==1) {
               echo "[<font color=darkgreen>$k2dsp</font>] ";
            } else {
               echo "[<font color=red>$k2dsp</font>] ";
               //tmq("insert into $k set ".stripslashes($v2[data]));
            }
            ////////////////////update val
           // die("update $k set ".stripslashes($v2[data])." where ".stripslashes($v2[limit]));
            tmq("update $k set ".stripslashes($v2[data])." where ".stripslashes($v2[limit]),false);
            //$
         }
         echo "<BR><BR>";
      }
   }
   echo "</td></tr></table>";
}
?>



<TR>
	<TD><FORM METHOD=POST ACTION="index.php"   onsubmit="return confirm('Morph UPDATE confirmation')">
<INPUT TYPE="hidden" name=ismorphupdateval value="yes">
<textarea style="width: 800px; height: 220px;" name=morphdata><?php echo stripslashes($_POST[morphdata]);?></textarea>
<INPUT TYPE="submit"value="[3] Force Update Val">
</FORM>
</TR>





<TR>
	<TD></TD>
</TR>


</TABLE><BR><?php 



foot();
?>