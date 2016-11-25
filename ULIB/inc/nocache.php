<?php // พ
function nocache() {
  if (!headers_sent()) {
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Cache-Control: private, no-cache');
    header('Pragma: no-cache');
  }
}
?>