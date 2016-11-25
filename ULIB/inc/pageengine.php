<?php 
function pageengine($page,$reclen,$url,$notfoundstr="ไม่พบข้อมูล::l::No result found") {
	global $startrow;
	if ($startrow=="" || $startrow==0) {
		$startrow=0;
	}
	global $dcrURL;
	global $_pagesplit_btn_var;

	$row_per_page=getval("pagesplit","pagelength");
	$page_per_page=getval("pagesplit","pagenumlength");

	$displaying=$row_per_page;

	$total_row = $reclen; //ได้ค่าจำนวนบรรทัดทั้งหมดที่จะต้องแสดง 

	$total_page = intval((($total_row-1)/$row_per_page)+1); //หาค่าจำนวนหน้าทั้งหมดที่ต้องแสดง 
	$currentpage = (($startrow)/$row_per_page)+1; //หาว่าหน้าที่แสดงอยู่ปัจจุบันเป็นหน้าที่เท่าไหร่ 

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
			$page_show = "<A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/back.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าก่อนหน้า::l::Previous")."'></A> $page_show"; 
		} else {
			$page_show = "<img src='$dcrURL/images/page/back_dis.gif' width=15 height=15 align=absmiddle border=0 title='หน้าก่อนหน้า'> $page_show"; 
		}
		if ($currentpage!=1) {
			$nextrow=0;
			$page_show = "<A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/first.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าแรก::l::First")."'></A> $page_show"; 
		} else {
			$page_show = " <img src='$dcrURL/images/page/first_dis.gif' width=15 height=15 align=absmiddle border=0 title='หน้าแรก'> $page_show"; 
		}

		if ($currentpage<$total_page) {
			$nextrow=($currentpage)*$row_per_page;
			$page_show = " $page_show <A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/next.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าต่อไป::l::Next")."'></A> "; 
		} else {
			$page_show = " $page_show <img src='$dcrURL/images/page/next_dis.gif' width=15 height=15 align=absmiddle border=0 title='หน้าต่อไป'> "; 
		}
		if ($currentpage!=$total_page) {
			$nextrow=($total_page-1)*$row_per_page;
			$page_show = " $page_show <A HREF='$url&startrow=".($nextrow)."'><img src='$dcrURL/images/page/last.gif' width=15 height=15 align=absmiddle border=0 title='".getlang("หน้าท้ายสุด::l::Last")."'></A> "; 
		} else {
			$page_show = " $page_show <img src='$dcrURL/images/page/last_dis.gif' width=15 height=15 align=absmiddle border=0 title='หน้าท้ายสุด'> "; 
		}
			$page_show = " $page_show [$total_page] "; 

	} else { 
		$page_show = ""; 
	} 

	$_pagesplit_btn_var="&nbsp;" . $page_show ."&nbsp;";
	$_pagesplit_btn_var=" <tr><td colspan=10 align=center bgcolor=fcfcfc>" . $_pagesplit_btn_var ." <span style=\"font-size: 12 ; color: 888888;\">[".getlang("แสดง::l::Displaying")." $displaying/$total_row".getlang(" รายการ::l::<B></B>")."]</span></td></tr> ";
	if ($total_row==0) {
				$_pagesplit_btn_var="<TR>
			<TD bgcolor=f5f5f5 colspan=10 align=center style=\"padding-top: 7px; padding-bottom: 7; color: #A6A6A6\"><B>".getlang($notfoundstr)."</B></TD>
		</TR>";
	}
	return $_pagesplit_btn_var;
}
?>