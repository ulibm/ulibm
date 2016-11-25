		
		<style>
		
.adminbox {
	font-size:12;

position: fixed;;
top: 20px; left: 20px;
/*visibility:hidden;*/
width: 200px;
border: 1px solid #868686;
background-color: lightyellow;
padding: 4px;
box-shadow: 3px 3px 8px #818181;
-webkit-box-shadow: 3px 3px 8px #818181;
-moz-box-shadow: 3px 3px 8px #818181;
}
		
		</style>
		
		<?php 
		?><div class=adminbox ID=adminboxID style="">
		<table width=100%>
		 <tr><td width=10><img src='<?php echo $dcrURL;?>webbox/mnset1.gif' border=0 onclick="localmnset(1);" style='cursor: hand; cursor: pointer;;'></td><td></td><td width=10><img src='<?php echo $dcrURL;?>webbox/mnset2.gif' border=0 onclick="localmnset(2);" style='cursor: hand; cursor: pointer;;'></td></tr>
		 <tr><td></td><td>
		 
		 
		<A HREF="<?php  echo $dcrURL?>webbox/man.tab.php" class="a_btn smaller2" rel="gb_page_fs[]"><IMG SRC="<?php  echo $dcrURL?>webbox/config.png" WIDTH="10" HEIGHT="10" BORDER="0" align=baseline> <?php  echo getlang("จัดการแท็บ::l::Manage Tabs");?></A>
		<BR><A HREF="<?php  echo $dcrURL?>webbox/options.php" class="a_btn smaller2" rel="gb_page_fs[]"><IMG SRC="<?php  echo $dcrURL?>webbox/config.png" WIDTH="10" HEIGHT="10" BORDER="0" align=baseline> <?php  echo getlang("ตัวเลือกอื่นๆ::l::Options");?></A>
		<?php  if (floor($deftab)!=0) {?>
			<br><A HREF="<?php  echo $dcrURL?>webbox/man.box.php?mode=add&tab=<?php  echo $deftab;?>" class="a_btn smaller2" rel="gb_page_fs[]"><IMG SRC="<?php  echo $dcrURL?>webbox/add.png" WIDTH="10" HEIGHT="10" BORDER="0" align=baseline> <?php  echo getlang("เพิ่มกล่องเนื้อหา::l::Add box");?></A>
		<?php  } ?>
		<br><A HREF="<?php  echo $dcrURL?>library.webbox.cascademenu" class="a_btn smaller2" rel="gb_page_fs[]"><IMG SRC="<?php  echo $dcrURL?>webbox/config.png" WIDTH="10" HEIGHT="10" BORDER="0" align=baseline> <?php  echo getlang("เมนูด้านบน::l::Top menu");?></A>
		
		
		</td><td></td></tr>
		 <tr><td><img src='<?php echo $dcrURL;?>webbox/mnset3.gif' border=0 onclick="localmnset(3);" style='cursor: hand; cursor: pointer;'></td><td></td><td><img src='<?php echo $dcrURL;?>webbox/mnset4.gif' border=0 onclick="localmnset(4);" style='cursor: hand; cursor: pointer;;'></td></tr>
      </table>
		</div>
		

<script>
function localmnset(wh) {
   tmpmn=getobj("adminboxID");
   if (wh==1) {
      tmpmn.style.top='10px';
      tmpmn.style.left='10px';      
   }
   if (wh==2) {
      tmpmn.style.top='10px';
      tmpmn.style.left=((ujsw-200)-35)+'px';      
   }
   if (wh==3) {
      tmpmn.style.top=(ujsh-150)+'px';
      tmpmn.style.left='10px';        
   }
   if (wh==4) {
      tmpmn.style.left=((ujsw-200)-35)+'px';      
      tmpmn.style.top=(ujsh-150)+'px';
   }
   setcookie("adminmenuboxpos",wh);
}
tmpadminmenuboxpos=getcookie("adminmenuboxpos");
if (Math.floor(tmpadminmenuboxpos)==0) {
   tmpadminmenuboxpos=1;
}
ulibglobalgetwinsize();
localmnset(tmpadminmenuboxpos);
//alert(tmpadminmenuboxpos);
</script>		