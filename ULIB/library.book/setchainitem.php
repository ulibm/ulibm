<?php 
	; 
        include ("../inc/config.inc.php");
		head();
	 include("_REQPERM.php");
        mn_lib();
        pagesection(getlang("โยงรายการนี้เป็นดรรชนีวารสาร::l::Relocate this bib as journal index"));
        if ($step=="confirmed") {
         ?><center><?php  echo getlang("ทำรายการเสร็จเรียบร้อย ::l::Operation success"); 
         res_brief_dsp($parentid);
         $now=time();
         tmq("delete from chainerlink where chain='journalindex' and frommid='$midid' and destid='$IDEDIT' ",false);
         tmq("insert into chainerlink set chain='journalindex' ,fromid='$parentid' , frommid='$midid' , destid='$IDEDIT',dt=$now",false);
         //printr($_POST);
         $olddat=tmq("select leader from media where ID='$IDEDIT' ");
         $tldr=tfa($olddat);
         $tldr=substr($tldr[leader],0,7)."b".substr($tldr[leader],8);
         $newldr=$tldr;
         //echo "[$newldr]";
         tmq("update media set leader='$newldr' where id='$IDEDIT' ",false);
         index_reindex($parentid);
         index_reindex($IDEDIT);
         index_indexft($parentid,true);
         index_indexft($IDEDIT,true);
         
           echo "<a href='index.php?IDEDIT=$IDEDIT' class=a_btn>Back</a>";
         foot();
         die;
        }
        if ($step=="sendfirstbc") {
            $chk=tmq("select * from media_mid where bcode='$MBC'");
            if (tnr($chk)!=1) {
               html_dialog("Error",getlang("ไม่พบบาร์โค้ด $MBC::l::Barcode $MBC not found"));
            } else {
            $chkr=tfa($chk);
               ?><center><?php  echo getlang("คุณต้องการที่จะตั้งค่ารายการต่อไปนี้ ::l::Do you want this bibs"); 
   				
   				res_brief_dsp($IDEDIT);
    				echo getlang("เป็นดรรชนีวารสารของทรัพยากรบาร์โค้ดดังต่อไปนี้::l::of the following item's barcode");
               echo "<BR><b>$MBC</b><BR>";
               echo "Call number=".marc_getcalln($chkr[pid])."<BR>";
               echo "Item Call number=".marc_getmidcalln($chkr[bcode]).marc_getserialcalln($chkr[id])."<BR>";
               //$chkr=tfa($chk);
               res_brief_dsp($chkr[pid]);
               ?><br>
				<form action="setchainitem.php" method=post>
				<input type=hidden value="confirmed" name="step">
				<input type=hidden value="<?php  echo $IDEDIT?>" name="IDEDIT">
				<input type=hidden value="<?php  echo $chkr[pid]?>" name="parentid">
				<input type=hidden value="<?php  echo $chkr[id]?>" name="midid">
				<input type=hidden value="<?php  echo $MBC?>" name="MBC">
				<input type=text name="dsp" ID="dsp" value="<?php  echo $MBC?>"> 
				<input type=submit value="<?php  echo getlang("ยืนยัน::l::Confirm");?>">
				</form>
				<script>
				tmp=getobj("dsp");
				tmp.focus();
				</script><?php 
               echo "<a href='$PHP_SELF?IDEDIT=$IDEDIT' class=a_btn>Back</a>";
            } 
            foot(); die;
            
        }
        
        
        
				?><center><?php  echo getlang("คุณต้องการที่จะตั้งค่ารายการต่อไปนี้ ::l::Do you want this bibs"); 
				
				res_brief_dsp($IDEDIT);
				echo getlang("เป็นดรรชนีวารสารของทรัพยากรบาร์โค้ดดังต่อไปนี้::l::of the following item's barcode");
				?><br>
				<form action="setchainitem.php" method=post>
				<input type=hidden value="sendfirstbc" name="step">
				<input type=hidden value="<?php  echo $IDEDIT?>" name="IDEDIT">
				<input type=text name="MBC" ID="MBC"> 
				<input type=submit value="<?php  echo getlang("ตรวจสอบ::l::Next");?>">
				</form></center>
				<script>
				tmp=getobj("MBC");
				tmp.focus();
				</script>
				<BR><BR>
<?php  foot();
?>