<?php 
//printr($_SESSION);
   if (sessionval_get("selfcheckiocheck")=="" || loginchk_lib("check")) {
      if (loginchk_lib("check")) {
         
          //ulibsess_unset($useradminid, $passwordadmin, $loginadmin, $Level);
          ulibsess_unset("useradminid", "passwordadmin", "loginadmin", "Level");
            //printr($_SESSION);die;
            sessionval_set("selfcheckiocheck",randid());
          redir("index.php");
          die;
      }
      html_start();
      html_dialog("Session Expired",getlang("กรุณาแจ้งเจ้าหน้าที่ให้ทำการเปิดระบบอีกครั้ง::l::Please inform librarian to authorize this session again"));
      foot();
      die;
   }
   
   ?>