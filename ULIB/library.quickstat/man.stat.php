<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	pagesection(getlang("เพิ่มลบหัวข้อสถิติ::l::Manage statistic"));

	
$tbname="quickstat";
$_TBWIDTH="100%";

$c[2][text]="ชื่อสถิติ::l::Statistic Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="แท็กที่เก็บข้อมูล::l::Tag ID";
$c[3][field]="tag";
$c[3][fieldtype]="text";
$c[3][descr]=getlang("เช่น 009 060 082 050::l::eg. 009 060 082 050");;
$c[3][defval]="";

$c[4][text]="ข้อความที่จะทำเป็นสถิติ::l::String to use as Query";
$c[4][field]="stat";
$c[4][fieldtype]="longtext";
$c[4][descr]=getlang("บรรทัดละ 1 รายการ::l::1 per row");
$c[4][defval]="";

$c[5][text]="กำหนดปี::l::These years only";
$c[5][field]="yea";
$c[5][fieldtype]="longtext";
$c[5][descr]=getlang("บรรทัดละ 1 รายการ / ดึงข้อมูลจาก tag008-Date1::l::1 per row / compares with tag008-Date1");
$c[5][defval]="";




//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

//quick gen
if ($quickgenaction=="yes") {
   if ($delprev=="yes") {
      tmq("delete from quickstat where sysgen<>'no' ");
   }

   if ($stattype=="dc") {
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '000', '082', '0\n00\n01\n02\n03\n04\n05\n06\n07\n08\n09', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '100', '082', '1\n10\n11\n12\n13\n14\n15\n16\n17\n18\n19', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '200', '082', '2\n20\n21\n22\n23\n24\n25\n26\n27\n28\n29', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '300', '082', '3\n30\n31\n32\n33\n34\n35\n36\n37\n38\n39', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '400', '082', '4\n40\n41\n42\n43\n44\n45\n46\n47\n48\n49', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '500', '082', '5\n50\n51\n52\n53\n54\n55\n56\n57\n58\n59', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '600', '082', '6\n60\n61\n62\n63\n64\n65\n66\n67\n68\n69', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '700', '082', '7\n70\n71\n72\n73\n74\n75\n76\n77\n78\n79', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '800', '082', '8\n80\n81\n82\n83\n84\n85\n86\n87\n88\n89', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES( '900', '082', '9\n90\n91\n92\n93\n94\n95\n96\n97\n98\n99', '', 'yes');");
   }
   if ($stattype=="lc") {
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('C ประวัติศาสตร์เบ็ดเตล็ด', '050', 'C\nCD\nCE\nCJ\nCR\nCS\nCT', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('W อาชีพแพทย์', '050', 'W\nWA\nWB\nWC\nWD\nWE\nWF\nWG\nWH\nWI\nWJ\nWK\nWL\nWM\nWN\nWO\nWP\nWQ\nWR\nWS\nWT\nWU\nWV\nWW\nWX', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('Q วิทยาศาสตร์', '050', 'Q\nQA\nQB\nQC\nQD\nQH\nQP\nQS\nQT\nQU\nQV\nQW\nQX\nQY\nQZ', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('D ประวัติศาสตร์ทั่วไป', '050', 'D\nDS', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('G ภูมิศาสตร์', '050', 'G\nGA\nGF\nGN\nGR\nGT\nGV', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('H สังคมศาสตร์', '050', 'H\nHA\nHB\nHC\nHD\nHF\nHG\nHM\nHN\nHQ\nHT\nHV\nHX', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('J รัฐศาสตร์', '050', 'J\nJA\nJC\nJF\nJK\nJQ\nJS\nJX', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('K กฏหมาย', '050', 'K\nKB\nKE\nKF\nKK\nKP\nKQ\nKR\nKT', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('L การศึกษา', '050', 'L\nLA\nLB\nLC\nLT', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('M ศิลปะ', '050', 'M\nML\nMT', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('N ทัศนียศิลป์', '050', 'N\nNA\nNB\nNC\nNE\nNK\nNX', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('P ภาษาและวรรณคดี', '050', 'P\nPA\nPE\nPL\nPM\nPN', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('S เกษตรศาสตร์', '050', 'S\nSD\nSF\nSH', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('T วิทยาศาสตร์ประยุกต์', '050', 'T\nTA\nTD\nTE\nTJ\nTK\nTR\nTS\nTT\nTX', '', 'yes');");
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('Z สารสนเทศ', '050', 'Z\n', '', 'yes');");
   } 
   if ($stattype=="nlm") {
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('.NLM', '060', 'W\nWB\nWC\nWD\nWE\nWF\nWG\nWH\nWI\nWJ\nWK\nWL\nWM\nWN\nWO\nWP\nWQ\nWR\nWS\nWT\nWU\nWV\nWW\nWX', '', 'yes');");
   }                                                                                            
   if ($stattype=="099") {
      $tmp=tmq("select * from keyhelp_callngenner");
      $tmpstr="";
      while ($r=tfa($tmp)) {
         $tmpstr=$tmpstr."\n".$r[prefix];
      }
      tmq("INSERT INTO `quickstat` (`name`, `tag`, `stat`, `yea`, `sysgen`) VALUES('.Local Callnumber', '099', '$tmpstr', '', 'yes');");
   }                                                                                                 
}                                                                                               
 
 
//printr($_POST);
if ($ffe_issave=="yes") {
   tmq("update $tbname set sysgen='no' where ".stripslashes($ffe_condition));
}
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"name");                   
                                                                                                
html_dialog("Tools","เครื่องมือช่วยสร้างสถิติ::l::Stat. Generator");                            
	?>                                                                                           
	<center>                                                                                     
	<form method=post action="<?php  echo $PHP_SELF?>">                                              
	<input type=hidden name=quickgenaction value='yes'>                                          
	<?php  echo getlang("สร้างสถิติแบบเร็ว::l::Quick Generate stat"); ?>                             
	<select name="stattype">
      <option value="dc">DC (082)
      <option value="lc">LC (050)
      <option value="nlm">NLM (060)
      <option value="099">Local Call number (099)
    </select>
	<BR>
<label><input type=checkbox name=delprev value='yes'><?php  echo getlang("ลบสถิติที่สร้างจากระบบก่อนหน้านี้::l::Remove previously generated stat");?></label>
	<BR>
	<input type=submit value=" OK ">
	</form></center>