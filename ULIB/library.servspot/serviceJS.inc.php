<?php 
function local_servicejs($wh,$remainingtime) {
global $dcrURL;
global $showonly;
?><div style="width: 240px; display:block; height: 240px; float:left; border: 1px solid #aaaaaa; margin: 2px 2px 2px 2px ;overflow: hidden;;">
<div class=table_head2><?php  echo stripslashes($wh[name]);?></div>
<?php 
   $s=tmq("select * from servicespot_client_i where spotid='$wh[id]' ");
   if (floor(tnr($s))==0) {
      tmq("update servicespot_client set addtime='0' where  id='$wh[pid]'");
      ?> <div align=center style="padding-top: 40%"> - - <BR>
      <a class=a_btn href="serviceJS-man.php?spot=<?php  echo $wh[id]; ?>" rel="gb_page_fs[]" relcloseasreload="yes"><?php  echo getlang("เข้าใช้");?></a>
      
      </div><?php 
   } else {
   //$remainingtime=-500;
   if ($remainingtime<=0) {
      ?><div style='clear:both'></div>
<div ID=passtimediv<?php  echo $wh[id]; ?> style="display: block; width: 240px; height: 100px;"> </div>
 <div style='clear:both'></div><?php 
   }
      ?>
      
    
 <script type="application/javascript">
function countdownComplete<?php  echo $wh[id]; ?>(){
	top.location.reload();
}
<?php  if ($remainingtime>0) {
   $col="#006600";
   if ($remainingtime<(10*60)) {
      $col="#660000";
   }
   if ($remainingtime<(5*60)) {
      $col="#990000";
   }
   if ($remainingtime<(2*60)) {
      $col="#ff0000";
   }
?>
var myCountdown2<?php  echo $wh[id]; ?> = new Countdown({
									time: <?php  echo $remainingtime?>, 
									width: 240, 
									hideLine	: true,
									height: 80, 
									numbers		: 	{
            						color	: "#FFFFFF",
            						bkgd	: "<?php  echo $col?>"
						         },
									onComplete	: countdownComplete<?php  echo $wh[id]; ?>,
									rangeHi:"hour"	// <- no comma on last item!
									});  
      <?php 
      } else {
      ?>
      
function upTime<?php  echo $wh[id]; ?>(x) {
  x = Math.abs(x);
  difference = Math.abs(x)*1000;
 // alert(difference); return;
  //difference = (now-countTo);

  days=Math.floor(difference/(60*60*1000*24)*1);
  hours=Math.floor((difference%(60*60*1000*24))/(60*60*1000)*1);
  mins=Math.floor(((difference%(60*60*1000*24))%(60*60*1000))/(60*1000)*1);
  secs=Math.floor((((difference%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
  tmp=getobj('passtimediv<?php  echo $wh[id]; ?>');
  tmpstr='เกินเวลา ';
    tmpstr+='<div style="clear:both"></div>';
   if (days!=0) {
      tmpstr+='<div style="-webkit-border-radius: 10px;-moz-border-radius: 10px; border-radius: 10px; margin: 2px; float:left; background-color: rgb(0, 102, 0); position: relative; overflow: visible; padding: 0px; margin-right: 0px; margin-bottom: 0px; font-size: 48px; vertical-align: baseline; outline: 0px; -webkit-user-select: none; cursor: inherit; -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px 0px; left: 0px; top: 0px; height: 60px; width: 72px; -webkit-box-shadow: none; box-shadow: none; white-space: nowrap; line-height: 1.25em; color: rgb(255, 255, 255); font-family: Arial, _sans; text-align: center; font-weight: normal; text-shadow: none; text-decoration: none; zoom: 1; size: 60px; z-index: 0; ">'+days+'</div> &nbsp;วัน ';
      tmpstr+='<div style="clear:both"></div>';
  }
   tmpstr+='<div style="-webkit-border-radius: 10px;-moz-border-radius: 10px; border-radius: 10px; margin: 2px; float:left; background-color: rgb(200, 0, 0); position: relative; overflow: visible; padding: 0px; margin-right: 0px; margin-bottom: 0px; font-size: 48px; vertical-align: baseline; outline: 0px; -webkit-user-select: none; cursor: inherit; -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px 0px; left: 0px; top: 0px; height: 60px; width: 72px; -webkit-box-shadow: none; box-shadow: none; white-space: nowrap; line-height: 1.25em; color: rgb(255, 255, 255); font-family: Arial, _sans; text-align: center; font-weight: normal; text-shadow: none; text-decoration: none; zoom: 1; size: 60px; z-index: 0;">'+hours+'</div>'; 
   tmpstr+='<div style="-webkit-border-radius: 10px;-moz-border-radius: 10px; border-radius: 10px; margin: 2px; float:left; background-color: rgb(200, 0, 0); position: relative; overflow: visible; padding: 0px; margin-right: 0px; margin-bottom: 0px; font-size: 48px; vertical-align: baseline; outline: 0px; -webkit-user-select: none; cursor: inherit; -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px 0px; left: 0px; top: 0px; height: 60px; width: 72px; -webkit-box-shadow: none; box-shadow: none; white-space: nowrap; line-height: 1.25em; color: rgb(255, 255, 255); font-family: Arial, _sans; text-align: center; font-weight: normal; text-shadow: none; text-decoration: none; zoom: 1; size: 60px; z-index: 0; ">'+mins+'</div>'; 
  tmpstr+='<div style="-webkit-border-radius: 10px;-moz-border-radius: 10px; border-radius: 10px; margin: 2px; float:left; background-color: rgb(200, 0, 0); position: relative; overflow: visible; padding: 0px; margin-right: 0px; margin-bottom: 0px; font-size: 48px; vertical-align: baseline; outline: 0px; -webkit-user-select: none; cursor: inherit; -webkit-transform-origin: 0px 0px; transform-origin: 0px 0px 0px; left: 0px; top: 0px; height: 60px; width: 72px; -webkit-box-shadow: none; box-shadow: none; white-space: nowrap; line-height: 1.25em; color: rgb(255, 255, 255); font-family: Arial, _sans; text-align: center; font-weight: normal; text-shadow: none; text-decoration: none; zoom: 1; size: 60px; z-index: 0; ">'+secs+'</div>'
  tmp.innerHTML=tmpstr
  clearTimeout(upTime<?php  echo $wh[id]; ?>.to);
  upTime<?php  echo $wh[id]; ?>.to=setTimeout(function(){ upTime<?php  echo $wh[id]; ?>(x+1); },1000);
}
 // Month,Day,Year,Hour,Minute,Second
  upTime<?php  echo $wh[id]; ?>(<?php  echo $remainingtime?>);
      <?php 
      }
      ?></script>
      
    <center>  
            <a class=a_btn href="serviceJS-man.php?spot=<?php  echo $wh[id]; ?>" rel="gb_page_fs[]" relcloseasreload="yes"><?php  echo getlang("จัดการ::l::Manage");?></a>
    <a href="serviceJS.php?showonly=<?php  echo $showonly; ?>&clearthis=<?php  echo $wh[id]; ?>" class=a_btn style='color:darkred;'><?php  echo getlang("เคลียร์จุดให้บริการนี้::l::Clear this spot");?></a><BR>
              <a class='smaller a_btn' href="_printspot.php?spot=<?php  echo $wh[id]; ?>" target=_blank relcloseasreload="yes"><img width=16 height=16
              src="<?php echo $dcrURL;?>neoimg/gicons/action/ic_print_black_18dp.png">  <?php echo getlang("พิมพ์::l::Print");?></a>
   <a href="serviceJS.php?showonly=<?php  echo $showonly; ?>&addtimethis=<?php  echo $wh[id]; ?>&timeadd=<?php
   //printr($wh);
   $spotinfo=tmq("select * from servicespot_room where id='$wh[pid]'");
   $spotinfor=tfa($spotinfo);
   echo $spotinfor[minutesallow];
  // printr($spotinfor);
   ?>" class='a_btn smaller' style='color:;'
   onclick="return confirm('add time?');"
   ><?php  echo getlang("เพิ่มเวลา $spotinfor[minutesallow] นาที::l::Add $spotinfor[minutesallow] minutes");?></a>
    <BR>
    <?php 
    //printr($wh);
    echo "<font class=smaller>".getlang("เริ่ม::l::Since").":".ymd_datestr($wh[cu_regis],"shortdt");;
    echo "</font><BR>";
    echo "<font class=smaller>".getlang("ถึง::l::to").":".ymd_datestr(time()+$remainingtime,"shortdt");;
    echo "</font><BR>";
    //memberlist
    $ml=tmq("select * from servicespot_client_i where spotid='$wh[id]' ");
    while ($mlr=tfa($ml)) {
      echo strip_tags(get_member_name($mlr[member]))."<BR>";
    }
    
    
   }
   //printr($wh);
?></div><?php 
}
?>