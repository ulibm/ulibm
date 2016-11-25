<?php ?>
<script type="text/javascript">
<!--
	parent.autoResizeOSS('dspiframe');

<?php 
// พ
//echo "<font class=smaller2>(<div ID=n_new>".number_format(tnr($c)).
$xx=explode(",","new,processing,waitpayment,waitpickup,done,matsent");
@reset($xx);
while (list($k,$v)=each($xx)) {
$c=tmq("select id from oss_req where stat='$v' "); 
?>
	tmp=window.parent.getobj("n_<?php  echo $v?>");
	//tmp.style.display='inline';
	tmp.innerHTML="(<?php  echo number_format(tnr($c))?>)";
<?php 
}	
?>
//-->
</script>