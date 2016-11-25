<?php 
;
     include("../inc/config.inc.php");
	 html_start();
	 //$_TBWIDTH="100%";
	 $_REQPERM="webbox";
	 mn_lib();
	$saveeditlinktourl=floor($saveeditlinktourl);
	if ($saveeditlinktourl!=0) {
		tmq("update webbox_tab set linktourl_target='$linktourl_target' ,linktourl_url='$linktourl_url'  where id='$saveeditlinktourl' ");
	}
	$editlinktourl=floor($editlinktourl);
	if ($editlinktourl!=0) {
		$dat=tmq("select * from webbox_tab where id='$editlinktourl' ");
		$dat=tfa($dat);
		?><table align=center width="<?php  echo $_TBWIDTH;?>" class=table_border><form method="post" action="man.tab.php">
					<input type="hidden" name="saveeditlinktourl" value="<?php  echo $editlinktourl?>">
		<tr>
			<td class=table_head width=200><?php  echo getlang("URL");?></td>
			<td class=table_td><input type="text" name="linktourl_url" value="<?php  echo $dat[linktourl_url];
		if ($dat[linktourl_url]=="") {
			echo "http://";
		}?>" size=100></td>
		</tr>
		<tr>
			<td class=table_head><?php  echo getlang("การเปิดหน้าต่างใหม่::l::Target");?></td>
			<td class=table_td><select name="linktourl_target">
<?php 	$data=explode(",","_top,_blank");
		while (list($k,$v)=each($data)) {
			echo "<option value='$v' ";
			if ($v==$dat[linktourl_target]) { echo "selected";}
			echo ">";
			if ($v=="_top") { echo getlang("ทับหน้าเดิม::l::Top frame");}
			if ($v=="_blank") { echo getlang("หน้าต่างใหม่::l::New window");}
		}
		?>
			</select> <input type="submit" ></td>
		</tr>
		</form>
		</table><?php 

	foot();
	die;
	}


         $tbname="webbox_tab";


$c[2][text]="ข้อความหัวแท็บ::l::Tab name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[9][text]="เยื้องซ้าย::l::Left padding";
$c[9][field]="indent";
$c[9][fieldtype]="list:0,1,2,3,4,5,6,7";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="สีพื้นหลัง::l::Background color";
$c[10][field]="bgcol";
$c[10][fieldtype]="color";
$c[10][descr]="";
$c[10][defval]="";

$c[11][text]="สีตัวอักษร::l::Font color";
$c[11][field]="fgcol";
$c[11][fieldtype]="color";
$c[11][descr]="";
$c[11][defval]="#330000";

$c[15][text]="ขนาดตัวอักษร::l::Font Size";
$c[15][field]="fontsize";
$c[15][fieldtype]="number";
$c[15][descr]="";
$c[15][defval]="13";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";


$c[4][text]="เรียงลำดับ::l::Order";
$c[4][field]="ordr";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="รูปแบบ::l::Tab mode";
$c[5][field]="module";
$c[5][fieldtype]="list:".getlang("ตัวแบ่ง::l::Seperator").",Webpage,Searching,Load_URL,Member_Login,Link_to_URL,Wiki_Home";
$c[5][descr]="";
$c[5][defval]="Webpage";

$c[8][text]="การจัดหน้า::l::Layout";
$c[8][field]="layout";
$c[8][fieldtype]="list:2_Column,2_Column_Right_big,3_Column_big_center,3_Column,4_Column,Full_Width,Two_Column_Left_big";
$c[8][descr]=getlang("สำหรับรูปแบบ แบบ Webpage::l::only for Webpage mode");
$c[8][defval]="2_Column";
$c[8][addon]="list-previewimg:$dcrURL"."webbox/layout,45,.gif";

$c[12][text]="แบ่งแท็บเอง::l::Mannual Layout";
$c[12][field]="layout_mannual";
$c[12][fieldtype]="text";
$c[12][descr]="<br>".getlang("ใส่จำนวนเปอร์เซ็นต์ความกว้างของคอลัมน์ คั่นด้วยเครื่องหมายคอมม่า<br>
โปรแกรมจะสร้างจำนวนคอลัมน์ตามที่กรอก<br>
- หากกรอกข้อมูลในช่องนี้ โปรแกรมจะไม่สนใจการตั้งค่าในช่อง [การจัดหน้า]::l::Enter percent of column width <br>
, seperates with comma, software will generates column automatically <br>
- if use this field software will ignore settings in [Layout]");
$c[12][defval]="";

$c[7][text]="เป็นแท็บหลัก::l::Is default tab?";
$c[7][field]="deftab";
$c[7][fieldtype]="switchsingle";
$c[7][descr]="";
$c[7][defval]="no";

$c[6][text]="แสดงหรือไม่::l::Show this tab?";
$c[6][field]="isshow";
$c[6][fieldtype]="yesno";
$c[6][descr]="";
$c[6][defval]="yes";

//dsp

function local_detail($wh) {
	global $dcrs;
	global $dcrURL;
	$s="$wh[descr]<BR>";
	if ($wh[module]=="Webpage") {
		if ($wh[layout_mannual]=="") {
			$s.="<img border=0 width=45 height=34 src='";
				$s.= "$dcrURL/webbox/layout/$wh[layout].gif";
			$s.="'>";
		} else {
			$s.="$wh[layout_mannual]";
		}
	}
	$s.="<BR><font class=smaller2>direct url: $dcrURL"."index.php?deftab=$wh[id]</font>";
	return $s;
	//
}

$dsp[7][text]="-";
$dsp[7][field]="ordr";
$dsp[7][width]="5%";

$dsp[8][text]="เยื้องซ้าย::l::Ident";
$dsp[8][field]="indent";
$dsp[8][width]="5%";

$dsp[2][text]="ข้อความหัวแท็บ::l::Tab name";
$dsp[2][field]="name";
$dsp[2][filter]="module:local_name";
$dsp[2][width]="20%";

function local_name($wh) {
	return "<div style='width:100%;background-color:$wh[bgcol];color:".$wh[fgcol].";'>$wh[name]</div>";
}

$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][filter]="module:local_detail";
$dsp[3][width]="40%";

$dsp[6][text]="แท็บหลัก::l::Default tab?";
$dsp[6][field]="deftab";
$dsp[6][filter]="switchsingle";
$dsp[6][width]="15%";

$dsp[4][text]="แสดงหรือไม่::l::Show this tab?";
$dsp[4][field]="isshow";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="15%";


$dsp[5][text]="รูปแบบ::l::Tab mode";
$dsp[5][field]="module";
$dsp[5][filter]="module:localtabman";
$dsp[5][width]="15%";

function localtabman($wh) {
	if ($wh[module]=="Link_to_URL") {
		return "Link_to_URL<br><font class=smaller2>$wh[linktourl_url]</font><br><a href='man.tab.php?editlinktourl=$wh[id]'>".getlang("แก้ไข::l::edit")."</a>";
	} else {
		return $wh[module];
	}
}

pagesection("แท็บ::l::Tabs");

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," ordr ");

?><CENTER><?php 
echo getlang("คุณอาจจะต้องรีเฟรชหน้าโฮมเพจใหม่ เพื่อให้เห็นสิ่งที่ปรับปรุง::l::You might have to reload homepage, to see the changes");
?></CENTER><?php 
foot();
?>