<?php //พ encoded
//@error_reporting( E_ALL );
//@error_reporting( E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
//@error_reporting( E_ALL  & ~E_WARNING );
@error_reporting( E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
@ini_set( "display_errors", true);
@setlocale(LC_TIME, 'th_TH.UTF8'); 

@date_default_timezone_set('Asia/Bangkok');
@ini_set('precision',30);

if (!headers_sent()) {
	header('Content-Type: text/html; charset=utf-8');
}

if ($_CONFIG != "YES") {

	//start trap old var.
	if (isset ($HTTP_SERVER_VARS)) {
		$_SERVER = &$HTTP_SERVER_VARS;
	}
	if (isset ($HTTP_GET_VARS)) {
		$_GET = &$HTTP_GET_VARS;
	}
	if (isset ($HTTP_POST_VARS)) {
		$_POST = &$HTTP_POST_VARS;
	}
	if (isset ($HTTP_COOKIE_VARS)) {
		$_COOKIE = &$HTTP_COOKIE_VARS;
	}
	if (isset ($HTTP_POST_FILES)) {
		$_FILES = &$HTTP_POST_FILES;
	}
	if (isset ($HTTP_ENV_VARS)) {
		$_ENV = &$HTTP_ENV_VARS;
	}
	if (isset ($HTTP_SESSION_VARS)) {
		$_SESSION = &$HTTP_SESSION_VARS;
	}
	//end trap old var.

	

	$POST=$_POST;//use with tb_editor

	$IPADDR=$_SERVER["REMOTE_ADDR"];
	//echo $IPADDR; print_r($_SERVER);
	$__AUTOCONFIG="yes";

	if ($__AUTOCONFIG=="yes") {
		$dcrs=str_replace("\\","/",__FILE__);
		$dcrs=str_replace('/inc/config.inc.php','',$dcrs);
		$dcrs=rtrim($dcrs,'/');
		$dcrs="$dcrs/";
		//echo $dcrs;
		$dcr=str_replace("\\","/",__FILE__);
		$dcr=str_replace('/inc/config.inc.php','',$dcr);
		$dcr=rtrim($dcr,'/');
		$dcr=trim($dcr);
		//$dcr=explode('/',trim($dcr,'/'));
		//$dcr= $dcr[count($dcr)-1];
		$dcr=substr($dcr,strlen(rtrim($_SERVER[DOCUMENT_ROOT],"/")));
		$dcr=trim($dcr,'/');
		//echo $dcr;
		$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https' : 'http';
//print_r($_SERVER);
      if ($_SERVER['HTTPS']=='on') {
         $protocol="https";
      }
		$dcrURL="$protocol://"."$_SERVER[HTTP_HOST]/$dcr";
		$dcrURL=trim($dcrURL,'/');
		$dcrURL.='/';
		//echo $dcrURL;
	} else {
		$dcr="ULIB6";
		$dcrURL="http://localhost:8080/ULIB6";
		$dcrURL=trim($dcrURL,'/');
		$dcrURL.='/';
		$dcrs = realpath(__FILE__) ;
		$dcrs=substr($dcrs,0,strlen($dcrs)-strlen("inc/config.inc.php"));
		$dcrs=str_replace("\\","/",$dcrs);
		$dcrs=rtrim($dcrs,'/');
		$dcrs.='/';
	}
	$_autosave_dbsql="no";
	$dcrs_pcache=$dcrs."_cache/";
	$webpageboarddcrs=$dcrs."/web/";
	$webpageboarddcrURL=$dcrURL."web/";
	$_MMTOPX=3;

// session functions s
	function ulibses_open($save_path, $session_name) {
	  global $sess_save_path;
	  $sess_save_path = $save_path;
	  return(true);
	}

	function ulibses_close() {
	  return(true);
	}

	function ulibses_read($id) {
	  global $sess_save_path;
	  $sess_file = "$sess_save_path/sess_$id";
	  $tmp =  (string) @file_get_contents($sess_file);
	  return $tmp;
	}

	function ulibses_write($id, $sess_data) {
	  global $sess_save_path;
	  $sess_file = "$sess_save_path/sess_$id";
	  if ($fp = @fopen($sess_file, "w")) {
		$return = fwrite($fp, $sess_data);
		fclose($fp);
		return $return;
	  } else {
		return(false);
	  }
	}

	function ulibses_destroy($id) {
	  global $sess_save_path;
	  $sess_file = "$sess_save_path/sess_$id";
	  return(@unlink($sess_file));
	}

	function ulibses_gc($maxlifetime) {
	  global $sess_save_path;
	  foreach (glob("$sess_save_path/sess_*") as $filename) {
		if (filemtime($filename) + $maxlifetime < time()) {
		  @unlink($filename);
		}
	  }
	  return true;
	}

	function ulibsess_register() {
		global $_SESSION;
		global $HTTP_SESSION_VARS;
		$arg_list = func_get_args();
		$numargs = func_num_args();
		for ($i = 0; $i < $numargs; $i++) {
			if (function_exists("session_register")) {
				@session_register("$arg_list[$i]");
			}
			eval("global \$$arg_list[$i];global \$_SESSION;\$_SESSION[".$arg_list[$i]."]=\$$arg_list[$i]; unset(\$$arg_list[$i]); ");
			eval("global \$$arg_list[$i];global \$HTTP_SESSION_VARS;\$HTTP_SESSION_VARS[".$arg_list[$i]."]=\$$arg_list[$i];");
		}
	}
	function ulibsess_unset() {
		global $_SESSION;
		global $HTTP_SESSION_VARS;
		$arg_list = func_get_args();
		$numargs = func_num_args();
		for ($i = 0; $i < $numargs; $i++) {
			if (function_exists("session_unregister")) {
				@session_unregister("$arg_list[$i]");
			}
			if ($arg_list[$i]!="") {
				eval("global \$_SESSION;unset(\$_SESSION[".$arg_list[$i]."]);\$_SESSION[".$arg_list[$i]."]=''; ");
				eval("global \$HTTP_SESSION_VARS;unset(\$HTTP_SESSION_VARS[".$arg_list[$i]."]);");
			}
		}
	}

	function ulibsess_unregister() {
		global $_SESSION;
		global $HTTP_SESSION_VARS;
		$arg_list = func_get_args();
		$numargs = func_num_args();
		for ($i = 0; $i < $numargs; $i++) {
			if (function_exists("session_unregister")) {
				@session_unregister("$arg_list[$i]");
			}
			eval("global \$$arg_list[$i];global \$_SESSION;\$_SESSION[".$arg_list[$i]."]=''; ");
			eval("global \$$arg_list[$i];global \$HTTP_SESSION_VARS;\$HTTP_SESSION_VARS[".$arg_list[$i]."]='';");
		}
	}
// session functions e

//initialize session handler s
/*
ini_set("session.cookie_path","/$dcr");
$sess_save_path=$dcrs."_session/";
$ulibsess_enebled=true;
session_save_path($sess_save_path);
session_set_save_handler("ulibses_open", "ulibses_close", "ulibses_read", "ulibses_write", "ulibses_destroy", "ulibses_gc");
//initialize session handler e
*/
session_start();

	
if ($ulibsess_enebled==true && isset($_SESSION)) {
	extract($_SESSION, EXTR_SKIP);
}

	if (!file_exists("$dcrs/inc/barcodeval_get.php")) {
		echo "<B>ULIB-Error:</B> File in $dcrs"."inc/ not found, Path Exists?<BR>
		ไม่พบไฟล์ใน $dcrs"."inc/ กรุณาตรวจสอบการตั้งค่า Path ต่าง ๆ<HR>";
		die;
	}
	
		include ("$dcrs/inc/html_membertype_icon.php");	
		include ("$dcrs/inc/str_getvalidfilename.php");	
		include ("$dcrs/inc/html_photofilter.php");	
		include ("$dcrs/inc/html_flattab.php");	
		include ("$dcrs/inc/form_qrreader.php");	
		include ("$dcrs/inc/media_updatelastdt.php");	
		include ("$dcrs/inc/ldap.inc.php");	
      include("$dcrs/inc/get_room_name.php"); //if (ob_get_length()) {echo "SENTED1!".ob_get_contents()."!";die;}
      include("$dcrs/inc/form_room.php");
      include("$dcrs/inc/get_noitemstr.php");//if (ob_get_length()) {echo "SENTED2!".ob_get_contents()."!";die;}
		include ("$dcrs/inc/globalupload_changekeyid.php");
		include ("$dcrs/inc/cir_checkin.php");
		include ("$dcrs/inc/marcdspmod_recalitemrule.php");
		include ("$dcrs/inc/marcdspmod_apply.php");
		include ("$dcrs/inc/marcdspmod_getsql.php");
		include ("$dcrs/inc/stat_statuid.php");
		include ("$dcrs/inc/cir_checkout.php");
		include ("$dcrs/inc/html_ugallery.php");
		include ("$dcrs/inc/tmq_connect.php");
		include ("$dcrs/inc/uploadengine.php");
		include ("$dcrs/inc/tmq_select_db.php");
		include ("$dcrs/inc/tmq_num_fields.php");
		include ("$dcrs/inc/tmq_tablename.php");

		include ("$dcrs/inc/t_fixval.php");
		include ("$dcrs/inc/t_buildsql.php");
		include ("$dcrs/inc/tl.php");
		include ("$dcrs/inc/t_fixcolname.php");
		include ("$dcrs/inc/t.php");
		include ("$dcrs/inc/tmq_error.php");

		include ("$dcrs/inc/addons_module.php");
		include ("$dcrs/inc/udecode.php");
		include ("$dcrs/inc/uencode.php");
		include ("$dcrs/inc/quickeditwebtext.php");
		include ("$dcrs/inc/str_webpagereplacer.php");
		include ("$dcrs/inc/res_icon.php");
		include ("$dcrs/inc/html_geticon.php");
		include ("$dcrs/inc/str_censor.php");
		include ("$dcrs/inc/editperm_chk.php");
		include ("$dcrs/inc/editperm_dsp.php");
		include ("$dcrs/inc/editperm_form.php");
		include ("$dcrs/inc/download_tofile.php");
		include ("$dcrs/inc/viewdiffman.php");
		include ("$dcrs/inc/viewdiffman_add.php");

		include ("$dcrs/inc/str_formatisn.php");
		include ("$dcrs/inc/tmq_rows_affected.php");
		include ("$dcrs/inc/umail_chk.php");
		include ("$dcrs/inc/marc_meltin_item.php");
		include ("$dcrs/inc/tmq_insert_id.php");
		include ("$dcrs/inc/umail_mail.php");
		include ("$dcrs/inc/umail_que.php");
		include ("$dcrs/inc/bitem_get_chaininfo.php");
		include ("$dcrs/inc/html_membericon.php");
		include ("$dcrs/inc/fft_upload_get.php");
		include ("$dcrs/inc/getlibsitebibrule.php");
		include ("$dcrs/inc/gen404.php");
		include ("$dcrs/inc/ymd_ago.php");	
		include ("$dcrs/inc/res_cov_dsp.php");	
		include ("$dcrs/inc/frm_globalupload.php");	
		include ("$dcrs/inc/iconvutf.php");	
		include ("$dcrs/inc/pcache_s.php");		
		include ("$dcrs/inc/pcache_e.php");		
		include ("$dcrs/inc/get_coverbyinfo.php");		
		include ("$dcrs/inc/explodewithquote.php");		
		include ("$dcrs/inc/marc_importfromfile.php");		
		include ("$dcrs/inc/html_label.php");
		include ("$dcrs/inc/sessionval_get.php");
		include ("$dcrs/inc/isUTF8.php");
		include ("$dcrs/inc/removenewline.php");
		include ("$dcrs/inc/sessionval_set.php");
		include ("$dcrs/inc/tmq_fetch_array.php");
		include ("$dcrs/inc/marc_getmidcalln.php");
		include ("$dcrs/inc/tmq_num_rows.php");
		include ("$dcrs/inc/member_showrequestlist.php");
		include ("$dcrs/inc/html_displayrqitem.php");
		include ("$dcrs/inc/captcha_s.php");
		include ("$dcrs/inc/captcha_e.php");
		include ("$dcrs/inc/html_xptab.php");			
		include ("$dcrs/inc/explodenewline.php");				
		include ("$dcrs/inc/ymd_mkymd.php");			
		include ("$dcrs/inc/index_ftremove.php");			
		include ("$dcrs/inc/iconvth.php");			
		include ("$dcrs/inc/html_guidebtn.php");			
		include ("$dcrs/inc/statordr_add.php");			
		include ("$dcrs/inc/stat_add.php");
		include ("$dcrs/inc/getlcnum.php");	
		include ("$dcrs/inc/getnlmnum.php");	
		include ("$dcrs/inc/stathist_add.php");
		include ("$dcrs/inc/mn_web.php");	
		include ("$dcrs/inc/ymd_mkdt.php");
		include ("$dcrs/inc/str_html2rgb.php");
		include ("$dcrs/inc/tmq_dump2.php");
		include ("$dcrs/inc/html_librarymenu.php");
		include ("$dcrs/inc/index_indexft.php");
		include ("$dcrs/inc/form_pickdate.php");
		include ("$dcrs/inc/fso_image_fixsize.php");
		include ("$dcrs/inc/form_pickdate_str.php");
		include ("$dcrs/inc/form_pickdatetime.php");
		include ("$dcrs/inc/form_pickdatetime_len.php");
		include ("$dcrs/inc/form_pickdt_get.php");
		include ("$dcrs/inc/form_pickdt_len_get.php");

		include ("$dcrs/inc/html_libmann.php");
		include ("$dcrs/inc/nocache.php");
		include ("$dcrs/inc/frm_genlist.php");
		include ("$dcrs/inc/html_xpbtn.php");
		include ("$dcrs/inc/get_member_name.php");
		include ("$dcrs/inc/str_preformat.php");	
		include ("$dcrs/inc/form_quickedit.php");				
		include ("$dcrs/inc/html_rows0_str.php");
		include ("$dcrs/inc/ymd_datestr.php");			
		include ("$dcrs/inc/html_start.php");
		include ("$dcrs/inc/html_dialog.php");
		include ("$dcrs/inc/aliceos_tmqs.php");
		include ("$dcrs/inc/aliceos_tmqp.php");
		include ("$dcrs/inc/fixform_editor.php");
		include ("$dcrs/inc/fixform_editor_i.php");
		include ("$dcrs/inc/fixform_editor_save.php");
		include ("$dcrs/inc/fixform_tablelister.php");
		include ("$dcrs/inc/usoundex_USOUNDEXCTRLARRAY.php");
		include ("$dcrs/inc/tmq_list_tables.php");
		include ("$dcrs/inc/usoundex_get.php");
		include ("$dcrs/inc/printr.php");
		include ("$dcrs/inc/ssql_for_raw.php");
		include ("$dcrs/inc/html_graph.php");
		include ("$dcrs/inc/percent_cal.php");
		include ("$dcrs/inc/blowfish.php");
		include ("$dcrs/inc/blowfish_defaultkey.ini.php");
		include ("$dcrs/inc/getlang.php");
		include ("$dcrs/inc/randid.php");
		include ("$dcrs/inc/str_remspecialsign.php");
		include ("$dcrs/inc/index_init_INDEXWORDDB.php");
		include ("$dcrs/inc/indexword_insert.php");
		include ("$dcrs/inc/ordr.php");
		include ("$dcrs/inc/ordr_geturl.php");
		include ("$dcrs/inc/sql_gotallliblimit_bylibmember.php");
		include ("$dcrs/inc/index_remove.php");
		include ("$dcrs/inc/index_markword.php");
		include ("$dcrs/inc/marc_getinfofrom_uglymarc.php");
		include ("$dcrs/inc/index_reindex.php");
		include ("$dcrs/inc/get_library_name.php");
		include ("$dcrs/inc/html_library_name.php");
		include ("$dcrs/inc/get_library_pic.php");
		include ("$dcrs/inc/ChkLoginAdminmember.php");
		include ("$dcrs/inc/ChkLoginAdminroot.php");
		include ("$dcrs/inc/ChkLoginAdmintech.php");
		include ("$dcrs/inc/ChkLoginLibrary.php");
		include ("$dcrs/inc/CloseDB.php");
		include ("$dcrs/inc/fso_file_importmelt.php");
		include ("$dcrs/inc/member_pic_url.php");
		include ("$dcrs/inc/member_pic_spath.php");
		include ("$dcrs/inc/getlibsitevars.php");
		include ("$dcrs/inc/barcodeval_set.php");
		include ("$dcrs/inc/barcodeval_get.php");
		include ("$dcrs/inc/ConnDB.php"); // ConnDB(); call first time at btm of this file
		include ("$dcrs/inc/GregorianToJD2.php");
		include ("$dcrs/inc/pageengine.php");
		include ("$dcrs/inc/marc_getyea.php");
		
		include ("$dcrs/inc/alerts.php");
		include ("$dcrs/inc/arr_filter_remnull.php");
		include ("$dcrs/inc/marc_melt.php");
		include ("$dcrs/inc/bitem_get_checkoutstr.php");
		include ("$dcrs/inc/bitem_pricehelp.php");
		include ("$dcrs/inc/get_itemplace_name.php");
		include ("$dcrs/inc/frm_itemplace.php");

		include ("$dcrs/inc/c.inc.php");
		include ("$dcrs/inc/ddl.php");
		include ("$dcrs/inc/ddx.php");
		include ("$dcrs/inc/ddxl.php");
		include ("$dcrs/inc/dspmarc.php");
		include ("$dcrs/inc/foot.php");
		include ("$dcrs/inc/file_get_contents.php");
		include ("$dcrs/inc/form_lib_login.php");
		include ("$dcrs/inc/form_member_login.php");
		include ("$dcrs/inc/form_root_login.php");
		include ("$dcrs/inc/frm_libsite.php");
		include ("$dcrs/inc/frm_restype.php");
		include ("$dcrs/inc/fso_file_write.php");
		include ("$dcrs/inc/getLine.php");
		include ("$dcrs/inc/get_content.php");
		include ("$dcrs/inc/filelogs.php");
		include ("$dcrs/inc/fso_listfile.php");
		include ("$dcrs/inc/get_def.php");
		include ("$dcrs/inc/get_itemmodule.php");
		include ("$dcrs/inc/get_libsite_name.php");
		include ("$dcrs/inc/get_media_type.php");
		include ("$dcrs/inc/get_mid_status.php");
		include ("$dcrs/inc/getdcnum.php");
		include ("$dcrs/inc/getduedecis.php");
		include ("$dcrs/inc/getlibsiterule.php");
		include ("$dcrs/inc/getval.php");
		include ("$dcrs/inc/head.php");
		include ("$dcrs/inc/hidemarc.php");
		include ("$dcrs/inc/html_displayitem.php");
		include ("$dcrs/inc/html_displaymarc.php");
		include ("$dcrs/inc/html_displaymedia.php");
		include ("$dcrs/inc/html_displayserial.php");
		include ("$dcrs/inc/html_htmlarea_gen.php");
		include ("$dcrs/inc/html_htmlareajs.php");
		include ("$dcrs/inc/libfunc.inc.php");
		include ("$dcrs/inc/library_gotpermission.php");
		include ("$dcrs/inc/loginchk_lib.php");
		include ("$dcrs/inc/loginchk_root.php");
		include ("$dcrs/inc/marc_export.php");
		include ("$dcrs/inc/marc_getauth.php");
		include ("$dcrs/inc/marc_getcalln.php");
		include ("$dcrs/inc/marc_getserialcalln.php");
		include ("$dcrs/inc/marc_getserialdat.php");
		include ("$dcrs/inc/marc_getsubfields.php");
		include ("$dcrs/inc/html_tooltip_int.php");
		include ("$dcrs/inc/str_tojsescape.php");
		include ("$dcrs/inc/html_tooltip.php");
		include ("$dcrs/inc/marc_gettitle.php");
		include ("$dcrs/inc/member_isoverduing.php");
		include ("$dcrs/inc/member_showfine.php");
		include ("$dcrs/inc/member_showhold.php");
		include ("$dcrs/inc/member_showinfo.php");
		include ("$dcrs/inc/member_showlonginfo.php");
		include ("$dcrs/inc/memberbin_showlonginfo.php");
		include ("$dcrs/inc/member_showrequest.php");
		include ("$dcrs/inc/mn_lib.php");
		include ("$dcrs/inc/mn_root.php");
		include ("$dcrs/inc/pagesection.php");
		include ("$dcrs/inc/pdf/load_pdf_ini.php");
		include ("$dcrs/inc/redir.php");
		include ("$dcrs/inc/rem2space.php");
		include ("$dcrs/inc/res_brief_dsp.php");
		include ("$dcrs/inc/scol.php");
		include ("$dcrs/inc/serial_get_volstr.php");
		include ("$dcrs/inc/serial_rebuild_serialstr.php");
		include ("$dcrs/inc/ssql.php");
		include ("$dcrs/inc/numbertoword.php");
		include ("$dcrs/inc/ssql_rembool.php");
		include ("$dcrs/inc/str_fixw.php");
		include ("$dcrs/inc/str_remjump_numeric.php");
		include ("$dcrs/inc/str_replace2.php");
		include ("$dcrs/inc/strpos_count.php");
		include ("$dcrs/inc/tmq.php");
		include ("$dcrs/inc/tmq_dump.php");
		include ("$dcrs/inc/tmqp.php");
		include ("$dcrs/inc/walkbackweekclose.php");
		include ("$dcrs/inc/ymd.inc.php");
		include ("$dcrs/inc/thaidatestr.php");
		include ("$dcrs/inc/frm_globalupload_updatetemp.php");
		include ("$dcrs/inc/member_log.php");
		include ("$dcrs/inc/form_quickedit_memval.php");
		include ("$dcrs/inc/ptp.php");
		include ("$dcrs/inc/JSON.php");

		//Initialize db
		ConnDB();
		if ($dbcoll!="") {
			tmq("set names '$dbcoll';");
         mb_internal_encoding("$dbcoll");
		}
   tmq("SET SESSION sql_mode = '';");
		//dse core initializing
		/*
		include ("$dcrs/inc/dse.php");
		include ("$dcrs/inc/dse_strapval.php");
		include ("$dcrs/inc/dse_doval.php");
		include ("$dcrs/inc/dse.exec.php");
      */
      
      
// emulate register global on
$_localtmpsystemreaddslashes=trim(strtolower(getval("_SETTING","systemreaddslashes")));
	if(!function_exists("get_magic_quotes_gpc") ) { //&& !get_magic_quotes_gpc()){
		$func = create_function('&$value','$value = addslashes($value);');
		array_walk_recursive($_GET,$func);
		array_walk_recursive($_POST,$func);
		array_walk_recursive($_COOKIE,$func);
	}
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][addslashes($k)] = $v;
                if($_localtmpsystemreaddslashes!="yes") {
                  $process[] = &$process[$key][($k)];
                } else {
                  $process[] = &$process[$key][addslashes($k)];
                }
            } else {
                if($_localtmpsystemreaddslashes!="yes") {
                   $process[$key][addslashes($k)] = ($v);
                } else {
                   $process[$key][addslashes($k)] = addslashes($v);
                }
            }
        }
    }
    unset($process);
	$superglobals = array($_SERVER, $_ENV, $_FILES, $_COOKIE, $_POST, $_GET);
	if (isset($_SESSION)) {
		array_unshift($superglobals, $_SESSION);
	}
	foreach ($superglobals as $superglobal) {
		extract($superglobal, EXTR_OVERWRITE);
	}
	//end emulate register global on
   
   
		  //externalmodule
		  define('FPDF_FONTPATH',"$dcrs/inc/pdf/font/");
          include ("$dcrs/inc/pdf/fpdf.php");
          include ("$dcrs/inc/barcode/barcode39.php");
          include ("$dcrs/inc/barcode/barcode_startupvar.php");
          include ("$dcrs/inc/config.inc.sv.php");					
 }
$_TBWIDTH=1000;
$_DEFDBENCODE="UTF-8";
$_CONFIG="YES";
$_STATCENTER_MAXRECORD=5000;
$_MSTARTY=getval("FORM","LIST_YEAR_START");
$_MENDY=getval("FORM","LIST_YEAR_END");
$_ROOMWORD=getlang(getval("_SETTING","room_word"));
$_FACULTYWORD=getlang(getval("_SETTING","faculty_word"));
$_IS_ENABLE_AUTO_INDEXWORD=getlang(getval("_SETTING","IS_ENABLE_AUTO_INDEXWORD"));

$_STR_A_Z=getval("global","STR_A_Z");
$_STR_A_Zth=getval("global","STR_A_Zth");
    $cfrm=getlang("ท่านแน่ใจหรือว่าต้องการลบรายการนี้\\n\\nหากเป็นรายการที่มีการเชื่อมโยงกันขอแนะนำให้ใช้วิธีแก้ไขเอา::l::Are you sure to delete this record?\\n\\nFor records with relations please edit instead.");
    $Sstr='<table width="550" border="1" cellspacing="0" cellpadding="3" align="center">
  <tr>
    <td bgcolor="f2f2f2"><font face="MS Sans Serif" size="2"><b>'.getlang("ระบบแจ้งว่า::l::System message").'</b></font></td>
  </tr>
  <tr>
    <td>&nbsp;';
    $Estr='</td>
    </tr>
  </table>
  ';
$_HTMLTEMPLATE=tmq("select * from htmltemplate where isuse='yes' and isdef<>'yes' and dtstart<='".time()."' and dtend>='".time()."' order by rand() ");
if (tmq_num_rows($_HTMLTEMPLATE)==0) {
	$_HTMLTEMPLATE=tmq("select * from htmltemplate where  isdef='yes'");
	if (tmq_num_rows($_HTMLTEMPLATE)==0) {
		$_HTMLTEMPLATE="default";
	} else {
		$_HTMLTEMPLATE=tmq_fetch_array($_HTMLTEMPLATE);
		$_HTMLTEMPLATE=$_HTMLTEMPLATE["id"];
	}
} else {
	$_HTMLTEMPLATE=tmq_fetch_array($_HTMLTEMPLATE);
	$_HTMLTEMPLATE=$_HTMLTEMPLATE[id];
}

//ConnDB();
if ("$_SESSION[lang_control_val]"=="") {
	$lang_control_val=getval("_SETTING","default_lang");
	ulibsess_register("lang_control_val");
}

if (is_dir("$dcrs/install/")) {

	html_start();
	html_dialog("ไม่อนุญาต::l::Disallowed","กรุณาลบโฟลเดอร์ /install/ ในโฟลเดอร์โปรแกรมทิ้งหลังติดตั้งเสร็จ::l::Please remove folder /install/ after installation.");
	if ($removeinstallnode=="yes") {
		 @rename("$dcrs/install_fixhide/","$dcrs/install_fixhide_".randid());
		 rename("$dcrs/install/","$dcrs/install_fixhide/");
		 sleep(2);
		 html_dialog("","เรียบร้อย, กรุณาทดลองกดรีเฟรชอีกครั้ง::l::Done, please try to refresh");
	} else {
	echo "<center> <a href='$dcrURL?removeinstallnode=yes'>".getlang("คลิกที่นี่เพื่อย้ายโฟลเดอร์ install ออก::l::Click here to remove install folder")."</a></center>";
	}
	die;
}

$newline="
";
?>