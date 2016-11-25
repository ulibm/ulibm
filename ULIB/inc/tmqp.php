<?php 
function tmqp($sql,$url,$notfoundstr="ไม่พบข้อมูล::l::No result found",$row_per_pagex="") {
   global $fixform_tablelister_runcount;
   ///$row_per_pagex=3;
   $fixform_tablelister_runcount=floor($fixform_tablelister_runcount);
   global $tmqp_iseverrun;
   global $tmqp_runcount;
   if (floor($tmqp_runcount)==0) {
      $tmqp_runcount=1;
   } else {
      $tmqp_runcount=$tmqp_runcount+1;
   }
	////func(" tmqp($sql,$startrow,$url,$is_os)");
	/*
	limitpage_var ();
	tmqp("select * from npc ",$startrow,"index.php?npc=$npc");
	*/

	global $startrow;
	//$startrow=$page;
	if ($startrow=="" || $startrow==0) {
		$startrow=0;
	}
	global $dcrURL;
	global $_pagesplit_btn_var;
	global $_pagesplit_btn_var_checkboxes;
	if ($row_per_pagex=="") {
  	$row_per_page=getval("pagesplit","pagelength");
	} else {
		$row_per_page=$row_per_pagex;
	}
	$page_per_page=getval("pagesplit","pagenumlength");
	
   $localjsstr="";
   if ($tmqp_gotopage!="yes") {
      $localjsstr="<script>
function tmqp_gotopage(url,maxpage) {
   //alert(url+\" \"+maxpage);
   var tmqgotopage = parseInt(window.prompt('".getlang("กรุณาป้อนเลขหน้าที่ต้องการ จาก 1 ถึง::l::Please enter page number from 1 to")." '+maxpage+'', ''), 10);
   if (tmqgotopage==false) return;
   if (tmqgotopage>0 && tmqgotopage<=maxpage) {
      self.location=url+((tmqgotopage-1)*$row_per_page);
   } else {
      alert('".getlang("ป้อนเลขหน้าไม่ถูกต้อง::l::Invalid page number")."');
   }

}      
      </script>";
   }
   $tmqp_iseverrun="yes";
   	
	$tmpsql_count=stripos($sql,' group by '); //test for group by
	$tmpsql_distinct=stripos($sql,' distinct '); //test for group by
	$tmpsql_countas=stripos($sql,' as '); //test for as select
	//echo "[$tmpsql_count]";
	//echo "[$sql=$tmpsql_countas]";
	if ($tmpsql_count>3 || $tmpsql_countas>3 || $tmpsql_distinct>3) {
		//must do nothing
		$result=tmq($sql,false);
		$total_row = tmq_num_rows($result); //ได้ค่าจำนวนบรรทัดทั้งหมดที่จะต้องแสดง 
	} else {
		$sql_count=substr($sql,stripos($sql,'from'),strlen($sql));
		//echo $sql_count;
		$tmpsql_count=strripos($sql_count,' order by ');
		if ($tmpsql_count<5) {
			$tmpsql_count=strlen($sql_count);
		}
		$sql_count=substr($sql_count,0,$tmpsql_count);
		$sql_count="select count(id) as tmpqcount $sql_count";
		//echo $sql_count;
		$result = tmq($sql_count,false); 
		$result=tmq_fetch_array($result);
		//printr($result);
		$total_row = floor($result[tmpqcount]); //ได้ค่าจำนวนบรรทัดทั้งหมดที่จะต้องแสดง 
	}
	//

		$total_page = intval((($total_row-1)/$row_per_page)+1); //หาค่าจำนวนหน้าทั้งหมดที่ต้องแสดง 
		$currentpage = (($startrow)/$row_per_page)+1; //หาว่าหน้าที่แสดงอยู่ปัจจุบันเป็นหน้าที่เท่าไหร่ 



	$total_page = intval((($total_row-1)/$row_per_page)+1); //หาค่าจำนวนหน้าทั้งหมดที่ต้องแสดง 
	//$currentpage = (($startrow)/$row_per_page)+1; //หาว่าหน้าที่แสดงอยู่ปัจจุบันเป็นหน้าที่เท่าไหร่ 
	$result = tmq($sql." LIMIT $startrow,$row_per_page",false); 
	/* Get your result to return to func-caller*/
	
	/*displaying*/
	$displaying=tmq_num_rows($result);

	/* getting str to show on prev page*/
$page_amnt_per_page_range=getval("pagesplit","pagenumlength");
	if ($total_page>1) { //ตรวจดูว่าถ้าจำนวนหน้าทั้งหมดมีเกิน 1 หน้า ต้องแสดงบรรทัดที่จะให้เลือกหน้า 
		$page_show = ""; 
		//echo "[[ total_page=$total_page, row_per_page=$row_per_page , currentpage=$currentpage , page_per_page=$page_per_page ]]";
		$for_from=$currentpage-$page_per_page;
		$for_to=$currentpage+$page_per_page;
		//echo "for [$for_from,$for_to]";
		if ($for_from<1) {
			$for_from=1;
		}
		if ($for_to>$total_page) {
			$for_to=$total_page;
		}

		for ($i=$for_from;$i<=$for_to;$i++) {
			//echo "[for - $i]";
			if ($i==$currentpage) {
				$page_show = " $page_show  <B>$i</B>  "; 
			} else {
				$nextstartrow=($i*$row_per_page)-$row_per_page;
				$page_show = " $page_show  <A HREF='$url&startrow=".($nextstartrow)."'><U>$i</U></A> "; 
			}
		}

		//เริ่มการตรวจสอบการลิงค์ |<   <<    >>   >|
		if (($currentpage-1)>0 ) {
			$nextrow=($currentpage-2)*$row_per_page;
			$page_show = "<A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/back.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าก่อนหน้า::l::Prev. page")."'></A> $page_show"; 
		} else {
			$page_show = "<img src='$dcrURL/images/page/back_dis.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าก่อนหน้า::l::Prev. page")."'> $page_show"; 
		}
		if ($currentpage!=1) {
			$nextrow=0;
			$page_show = "<A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/first.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าแรก::l::First page")."'></A> $page_show"; 
		} else {
			$page_show = " <img src='$dcrURL/images/page/first_dis.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าแรก::l::First page")."'> $page_show"; 
		}

		if ($currentpage<$total_page) {
			$nextrow=($currentpage)*$row_per_page;
			$page_show = " $page_show <A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/next.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าต่อไป::l::Next page")."'></A> "; 
		} else {
			$page_show = " $page_show <img src='$dcrURL/images/page/next_dis.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าต่อไป::l::Next page")."'> "; 
		}
		if ($currentpage!=$total_page) {
			$nextrow=($total_page-1)*$row_per_page;
			$page_show = " $page_show <A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/last.gif' width=15 height=15 align=absmiddle border=0 title='หน้าท้ายสุด'></A> "; 
		} else {
			$page_show = " $page_show <img src='$dcrURL/images/page/last_dis.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าท้ายสุด::l::Last page")."'> "; 
		}
		$page_show = " $page_show [$total_page] "; 
		$page_show = " $page_show <img src='$dcrURL"."neoimg/gotopage.png' border=0 width=15 height=15 align=absmiddle onclick=\"tmqp_gotopage('$url&startrow=',$total_page); return true\"> ".$localjsstr; 
	} else { 
		$page_show = ""; 
	} 
   
   $_pagesplit_btn_var_checkboxesstr="";
   if ($_pagesplit_btn_var_checkboxes=="yes") {
      $_pagesplit_btn_var_checkboxesstr="<td align=center bgcolor=fcfcfc>
      <a href=\"javascript:void(null);\" onclick=\"local_tmqp_checkall$tmqp_runcount();\" style='text-decoration:none;' TITLE='". getlang("เลือกทั้งหมด::l::Select all")."'>
         <img border=0 src='$dcrURL"."neoimg/gicons/toggle/ic_check_box_grey600_18dp.png' width=18 height=18></a>
      <a href=\"javascript:void(null);\" onclick=\"local_tmqp_uncheckall$tmqp_runcount();\" style='text-decoration:none;' TITLE='".getlang("ไม่เลือกเลย::l::Select none")."'>
         <img border=0 src='$dcrURL"."neoimg/gicons/toggle/ic_check_box_outline_blank_grey600_18dp.png' width=18 height=18></a><BR>
      <A HREF='javascript:fixform_tablelister_deleteallchecked$fixform_tablelister_runcount();' style='text-decoration:none;' TITLE='".getlang("ลยทุกรายการที่เลือก::l::Delete Selected")."'>
         <img border=0 src='$dcrURL"."neoimg/gicons/action/ic_highlight_remove_redish_18dp.png' width=18 height=18></a>
      
      </td>";
   }
   ?>
<script>
function local_tmqp_checkall<?php echo $tmqp_runcount;?>() {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox' && cbs[i].getAttribute("rel")=='fixformcheckbox<?php echo $fixform_tablelister_runcount;?>') {
      cbs[i].checked = true;
    }
  }
}
function local_tmqp_uncheckall<?php echo $tmqp_runcount;?>() {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox' && cbs[i].getAttribute("rel")=='fixformcheckbox<?php echo $fixform_tablelister_runcount;?>') {
      cbs[i].checked = false;
    }
  }
}
</script>
   <?php
	$_pagesplit_btn_var="&nbsp;" . $page_show ."&nbsp;";
	$_pagesplit_btn_var=" <tr>$_pagesplit_btn_var_checkboxesstr<td colspan=10 align=center bgcolor=fcfcfc>" . $_pagesplit_btn_var ." <span style=\"font-size: 10; color: 888888;\">[".getlang("แสดง::l::Displaying")." $displaying/$total_row ".getlang("รายการ::l::<B></B>")."]</span></td></tr> ";
	if ($total_row==0) {
				$_pagesplit_btn_var="<TR>
			<TD bgcolor=f5f5f5 colspan=10 align=center style=\"padding-top: 7px; padding-bottom: 7; color: #A6A6A6\"><B>".getlang("$notfoundstr")."</B></TD>
		</TR>";
		if ($notfoundstr=="skip" || $notfoundstr=="no") {
			$_pagesplit_btn_var="";
		}
	}

	return $result;
}
?>