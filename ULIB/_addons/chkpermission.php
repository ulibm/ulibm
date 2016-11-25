<?php 
	
	if (library_gotpermission("manulibaddon") || editperm_chk("ULIBADDON:$_REQPERM","","manulibaddon")) {
	} else { 
		html_dialog("Access Denied",getlang("คุณไม่มีสิทธิ์ใช้ส่วนเสริมนี้::l::You have no permission to use this addons"));

		foot();
		die;
	}

		?>