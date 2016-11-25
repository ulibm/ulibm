<?php
if ($step=="") {
   $step="1pingsv";
}  
$u=barcodeval_get("addonssetting_libfullupgrade_url");
$u=trim($u);
$u=rtrim($u,"/ ");
if ($u=="") {
   die("source URL is empty");
}
$u=$u."/_addons/00ulibfullupgrade/sv/sv.php?cmd=";
//echo $u;
$run=floor($run);
	?><center><?php
   if ($step=="5runfolderupdate") {
      $tmp=barcodeval_get("addonssetting_libfullupgrade_struct");
      //echo($tmp);
      $tmp=base64_decode($tmp);
      $tmp=unserialize($tmp);
      if (!is_array($tmp) || count($tmp)<50) {
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
      echo "[$ff]<BR>";
      	echo html_graph("V",count($tmp)+1,$run,20,800,"#952F2F");
         //chk destination
         if ($ff=="[ROOT]") {
            $ddest=rtrim($dcrs," /");
         } else {
            $ddest=$dcrs."$ff";
         }
         if (!is_dir($ddest)) {
            @mkdir($ddest);
         }
      if (substr($ff,0,strlen("_tmp"))=="_tmp" ||
      substr($ff,0,strlen("_cache"))=="_cache" ||
      substr($ff,0,strlen("_globalupload/"))=="_globalupload/" ||
      substr($ff,0,strlen("_fulltext"))=="_fulltext" ||
      substr($ff,0,strlen("pic"))=="pic" ||
      $ff=="_tmp/fft_upload/webpage_indexphotonews" ||
      $ff=="_globalupload" ||
      $ff=="_tmp/headbar" 
      ) { ///////////////////////
         html_dialog("skip","Skipping local data folder");
      } else { /////////////////////
         
      $req=file_get_contents($u."genfolder&fd=".base64_encode($ff));
      //echo $u."genfolder&fd=".base64_encode($ff);
      //echo $req;
      if (substr($req,0,3)=="ok:" && substr($req,-4)==":eou")  {
         $fu=substr($req,3,-4);
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
         @unlink("_tmpe");
         @mkdir("_tmpe");
         //echo $buffera;
         fso_file_write("./_tmp/file.tgz","w+",$buffera);
         if (filesize("./_tmp/file.tgz")==0) {
            die("error writeing download file/ problem downloading");
         }
         echo "<BR>downloaded ".number_format(floor(filesize("./_tmp/file.tgz")/1024)) ." kb";
         echo "<BR>extracting";
         $b = new gzip_file($dcrs."_addons/00ulibfullupgrade/_tmp/file.tgz");
         //printr($b);

         echo "<BR>Destination=".substr($ddest,strlen($dcrs));

//printr($b->files);
         $b->set_options(array('basedir' => $ddest."/", 'overwrite' => 1, 'level' => 1,'storepaths' => 0));
         //$b->set_options(array('basedir' => $ddest."/"));
         //printr($b);
         $b->extract_files();
         if (count($b->errors) > 0) {
            printr($b->errors);
         	print ("Errors occurred."); // Process errors here
         }        
         
         html_dialog("Done","part $run update success");
      } else {
         die("prepare error [$ff=$req] ");
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

   </center><?php 

foot();
die;
?>