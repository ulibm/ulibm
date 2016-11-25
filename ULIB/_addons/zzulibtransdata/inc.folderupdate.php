<?php
if ($step=="") {
   $step="1pingsv";
}  
if (!function_exists("udecodelocal")) {
   
function udecodelocal($s) {
   $a=explode(":",$s);
   //echo "<pre>";print_r($a);
   $res="";
   @reset($a);
   while (list($k,$v)=each($a)) {
      if ($v=="" || $v==chr(13) || $v==chr(10)) {
         continue;
      }
      if (mb_substr($v,0,1)=="c") {
         $res=$res.("a".trim($v,"c")."b");
      }
      $res=$res.chr($v);
   }
   
					$res=str_replace("a161b","ก",$res);
					$res=str_replace("a162b","ข",$res);
					$res=str_replace("a163b","ฃ",$res);
					$res=str_replace("a164b","ค",$res);
					$res=str_replace("a165b","ฅ",$res);
					$res=str_replace("a166b","ฆ",$res);
					$res=str_replace("a167b","ง",$res);
					$res=str_replace("a168b","จ",$res);
					$res=str_replace("a169b","ฉ",$res);
					$res=str_replace("a170b","ช",$res);
					$res=str_replace("a171b","ซ",$res);
					$res=str_replace("a172b","ฌ",$res);
					$res=str_replace("a173b","ญ",$res);
					$res=str_replace("a174b","ฎ",$res);
					$res=str_replace("a175b","ฏ",$res);
					$res=str_replace("a176b","ฐ",$res);
					$res=str_replace("a177b","ฑ",$res);
					$res=str_replace("a178b","ฒ",$res);
					$res=str_replace("a179b","ณ",$res);
					$res=str_replace("a180b","ด",$res);
					$res=str_replace("a181b","ต",$res);
					$res=str_replace("a182b","ถ",$res);
					$res=str_replace("a183b","ท",$res);
					$res=str_replace("a184b","ธ",$res);
					$res=str_replace("a185b","น",$res);
					$res=str_replace("a186b","บ",$res);
					$res=str_replace("a187b","ป",$res);
					$res=str_replace("a188b","ผ",$res);
					$res=str_replace("a189b","ฝ",$res);
					$res=str_replace("a190b","พ",$res);
					$res=str_replace("a191b","ฟ",$res);
					$res=str_replace("a192b","ภ",$res);
					$res=str_replace("a193b","ม",$res);
					$res=str_replace("a194b","ย",$res);
					$res=str_replace("a195b","ร",$res);
					$res=str_replace("a196b","ฤ",$res);
					$res=str_replace("a197b","ล",$res);
					$res=str_replace("a198b","ฦ",$res);
					$res=str_replace("a199b","ว",$res);
					$res=str_replace("a200b","ศ",$res);
					$res=str_replace("a201b","ษ",$res);
					$res=str_replace("a202b","ส",$res);
					$res=str_replace("a203b","ห",$res);
					$res=str_replace("a204b","ฬ",$res);
					$res=str_replace("a205b","อ",$res);
					$res=str_replace("a206b","ฮ",$res);
					$res=str_replace("a207b","ฯ",$res);
					$res=str_replace("a208b","ะ",$res);
					$res=str_replace("a209b","ั",$res);
					$res=str_replace("a210b","า",$res);
					$res=str_replace("a211b","ำ",$res);
					$res=str_replace("a212b","ิ",$res);
					$res=str_replace("a213b","ี",$res);
					$res=str_replace("a214b","ึ",$res);
					$res=str_replace("a215b","ื",$res);
					$res=str_replace("a216b","ุ",$res);
					$res=str_replace("a217b","ู",$res);
					$res=str_replace("a218b","ฺ",$res);

					$res=str_replace("a219b","",$res);
					$res=str_replace("a220b","",$res);
					$res=str_replace("a221b","",$res);
					$res=str_replace("a222b","",$res);
					$res=str_replace("a223b","฿",$res);
					$res=str_replace("a224b","เ",$res);
					$res=str_replace("a225b","แ",$res);
					$res=str_replace("a226b","โ",$res);
					$res=str_replace("a227b","ใ",$res);
					$res=str_replace("a228b","ไ",$res);
					$res=str_replace("a229b","ๅ",$res);
					$res=str_replace("a230b","ๆ",$res);
					$res=str_replace("a231b","็",$res);
					$res=str_replace("a232b","่",$res);
					$res=str_replace("a233b","้",$res);
					$res=str_replace("a234b","๊",$res);
					$res=str_replace("a235b","๋",$res);
					$res=str_replace("a236b","์",$res);
					$res=str_replace("a237b","ํ",$res);
					$res=str_replace("a238b","™",$res);
					$res=str_replace("a239b","๏",$res);
					$res=str_replace("a240b","๐",$res);
					$res=str_replace("a241b","๑",$res);
					$res=str_replace("a242b","๒",$res);
					$res=str_replace("a243b","๓",$res);
					$res=str_replace("a244b","๔",$res);
					$res=str_replace("a245b","๕",$res);
					$res=str_replace("a246b","๖",$res);
					$res=str_replace("a247b","๗",$res);
					$res=str_replace("a248b","๘",$res);
					$res=str_replace("a249b","๙",$res);
					$res=str_replace("a250b","®",$res);

					$res=str_replace("a94b","^",$res);
					$res=str_replace("a95b","_",$res);
					$res=str_replace("a96b","`",$res);
					$res=str_replace("a97b","a",$res);
					$res=str_replace("a98b","b",$res);
					$res=str_replace("a99b","c",$res);
					$res=str_replace("a100b","d",$res);
					$res=str_replace("a101b","e",$res);
					$res=str_replace("a102b","f",$res);
					$res=str_replace("a103b","g",$res);
					$res=str_replace("a104b","h",$res);
					$res=str_replace("a105b","i",$res);
					$res=str_replace("a106b","j",$res);
					$res=str_replace("a107b","k",$res);
					$res=str_replace("a108b","l",$res);
					$res=str_replace("a109b","m",$res);
					$res=str_replace("a110b","n",$res);
					$res=str_replace("a111b","o",$res);
					$res=str_replace("a112b","p",$res);
					$res=str_replace("a113b","q",$res);
					$res=str_replace("a114b","r",$res);
					$res=str_replace("a115b","s",$res);
					$res=str_replace("a116b","t",$res);
					$res=str_replace("a117b","u",$res);
					$res=str_replace("a118b","v",$res);
					$res=str_replace("a119b","w",$res);
					$res=str_replace("a120b","x",$res);
					$res=str_replace("a121b","y",$res);
					$res=str_replace("a122b","z",$res);
					$res=str_replace("a123b","{",$res);
					$res=str_replace("a124b","|",$res);
					$res=str_replace("a125b","}",$res);
					$res=str_replace("a126b","~",$res);
					$res=str_replace("a127b","",$res);

   //echo ("$s=$res<BR>");
         $res = strval(str_replace("\0", "", $res));
   return $res;
   
}

}
$u=barcodeval_get("addonssetting_ulibtransdata_url");
$u=trim($u);
$u=rtrim($u,"/ ");
if ($u=="") {
   die("source URL is empty");
}
$u=$u."/_addons/00ulibfullupgrade/sv/sv.php?cmd=";
//echo $u;
   if ($step=="1pingsv") {
      $tmp=file_get_contents($u."1ping");
      //echo $tmp;
      if ($tmp!="pingresponse") {
      html_dialog("error","ping incomplete, server response=[$tmp]");
      die;
      } else {
      html_dialog("ok","ping complete");
      }
      ?><a href="index.php?mode=folderupdate&step=4getfilelist" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;
   }
   
   
$run=floor($run);
	?><center><?php
	   ////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($step=="4getfilelist") {
      $tmp=file_get_contents($u."4getfilelist");
      //echo $u."4getfilelist";
      $tmporig=$tmp;
      $tmp=base64_decode($tmp);
      //echo $tmp;
      $tmp=unserialize($tmp);
      if (!is_array($tmp) || count($tmp)<1) {
         die("not array- data error");
      }
      @reset($tmp);
      //echo "here";
      while (list($k,$v)=each($tmp)) {
         $tmp[$k]=udecodelocal($v);
      }
      $newtmp=base64_encode(serialize($tmp));
      //die("pause");
      //printr($tmp);
      barcodeval_set("addonssetting_ulibtransdata_struct",$newtmp);
      echo "File Structure to update : ".count($tmp);;
      //echo "<pre>";print_r($tmp);
      //echo $tmp;
               ?><BR><a href="index.php?mode=folderupdate&step=5runfolderupdate" class=a_btn><?php echo getlang("Next");?></a><?php
      foot();
      die;
   }
      ////////////////////////////////////////////////////////////////////////////////////////////////////////
      
   if ($step=="5runfolderupdate") {
      $tmp=barcodeval_get("addonssetting_ulibtransdata_struct");
      //echo($tmp);
      $tmp=base64_decode($tmp);
      $tmp=unserialize($tmp);
      //printr($tmp);
      if (!is_array($tmp) || count($tmp)<1) {
         die("not array- data error..");
      }
      if ($run>=count($tmp)) {
         echo "<h1> update complete</h1>";
         ?><a href="index.php" class=a_btn><?php echo getlang("Back");?></a><?php
         foot();
         die;
      }
      echo "Round $run/".count($tmp)."<BR>";
      $ff=$tmp[$run];
      if ($ff=="") {
         die("error at $run, directory name empty");
      }
      //echo "[$ff]<BR>";
      	echo html_graph("V",count($tmp)+1,$run,20,800,"#952F2F");
         //chk destination
         //echo "$ddest=".udecodelocal($ddest); die;
         if ($ff=="[ROOT]") {
            $ddest=rtrim($dcrs," /");
         } else {
            $ddest=$dcrs."$ff";
         }
         if (!is_dir($ddest)) {
            @mkdir($ddest);
         }
         $ddest=str_replace("/./","/",$ddest);
      if (true) { /////////////////////
         
      $req=file_get_contents($u."genfolder&fd=".base64_encode(uencode($ff))."&rand=".randid());
      //echo $u."genfolder&fd=".base64_encode(uencode($ff));
      //echo "[req=$req]";
      if (substr($req,0,3)=="ok:" && substr($req,-4)==":eou")  {
         $fu=substr($req,3,-4);
         $fu=ltrim($fu," ./");
         $fubase=barcodeval_get("addonssetting_ulibtransdata_url");
         $fubase=rtrim($fubase,"_ULIBTRANSDATA.php");
         $fu=$fubase.$fu;
         //echo "[fu=$fu]";
         echo "url ok : downloading: <!--$fu--><BR>";
         $handle = @fopen($fu, "rb");
         if ($handle) {
            $buffera="";
             while (($buffer = fgets($handle, 4096)) !== false) {
                 $buffera.= $buffer;
             }
             if (!feof($handle)) {
                 echo "Error: unexpected fgets() fail\n";
             }
             fclose($handle);
         }
         @unlink("./_tmp/file.tgz");
         //echo $buffera;
         fso_file_write("./_tmp/file.tgz","w+",$buffera);
         if (filesize("./_tmp/file.tgz")==0) {
            die("error writeing download file/ problem downloading");
         }
         echo "<BR>downloaded ".number_format(floor(filesize("./_tmp/file.tgz")/1024)) ." kb";
         $ddestdsp=str_replace($dcrs,"",$ddest);
         $ddestdsp=trim($ddestdsp," ./");
         echo "<BR>extracting [$ddestdsp]";
         $b = new gzip_file($dcrs."_addons/zzulibtransdata/_tmp/file.tgz");
         //printr($b);
      $ddest = strval(str_replace("\0", "", $ddest));
      chdir($ddest);
     // echo "now at ".getcwd();
		//echo "[ddest=$ddest]";
      //die;
         $b->set_options(array('basedir' => $ddest, 'overwrite' => 1, 'level' => 1,'storepaths' => 0));
         //$b->set_options(array('basedir' => $ddest."/"));
         
         
         if (count($b->errors) > 0) {
            printr($b->errors);
         	print ("Errors occurred."); // Process errors here
         }        
         
         html_dialog("Done","part $run update success");
         $b->extract_files();
         //printr($b); die;
         //die;
      } else {
      ?>      <meta http-equiv=refresh content="0;URL=index.php?mode=folderupdate&step=5runfolderupdate&run=<?php echo ($run+1);?>"><b></b><?php
         die("prepare error [$ff=$req] ");
         die("prepare error [$ff=$req] <a href='index.php?mode=folderupdate&step=5runfolderupdate&run=".($run+1)."'>skip to part ".($run+1)."</a>");
      }
      
      }  ////////////////////
      //printr($tmp);
      ?>
      <meta http-equiv=refresh content="0;URL=index.php?mode=folderupdate&step=5runfolderupdate&run=<?php echo ($run+1);?>">
      <a href="index.php?mode=folderupdate&step=5runfolderupdate&run=<?php echo ($run+1);?>" class=a_btn><?php echo getlang("Next to round ".($run+1)."");?></a>
      <BR>
         <?php 
   
   if (function_exists("disk_free_space")) {
    $bytes = disk_free_space("."); 
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    $class2 = 2;
    //echo $bytes . '<br />';
    if ($bytes>=1000*1000) {
     // echo "<!--";
    }
      echo "Harddisk free space : ";
      echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '<br />';
      echo sprintf('%1.2f' , $bytes / pow($base,$class2)) . ' ' . $si_prefix[$class2] . '<br />';
    if ($bytes>=$base) {
     // echo "-->";
    }
   }
   
   ?><?php
      foot();
      die;
   }
   ////////////////////////////////////////////////////////////////////////////////////////////////////////
      ////////////////////////////////////////////////////////////////////////////////////////////////////////

   ?>
   <BR><BR><a href=index.php class=a_btn><?php echo getlang("กลับ::l::Back");?></a><BR>

  <?php 

foot();
die;
?>