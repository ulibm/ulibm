<?php 
include("../inc/config.inc.php");
	 head();
	 mn_root("filebrowser");
    $fileorig=$file;
    $file=base64_decode($file);
    $file=trim($file);
    $file=str_replace("..","",$file);
    if ($file=="") die("no file name");
    $filee=$dcrs.$file;
    if (!file_exists($filee)) die($file." not found");
    

    html_dialog("","editing $file");
	 if ($issave=="yes") {
      $filebody=stripslashes($filebody);
      fso_file_write($filee,"w",$filebody);
      html_dialog("","Saved $file");
	 }
?>

   <style type="text/css">
   #codeTextarea{
      width:500px;
      height:510px;
   }
   .textAreaWithLines{
      font-family:courier;      
      border:1px solid #600;
      
   }
   .textAreaWithLines textarea,.textAreaWithLines div{
      border:0px;
      line-height:120%;
      font-size:16px;
   }
   .lineObj{
      color:red;
   }
   </style>
   
   <script type="text/javascript">
   
   var lineObjOffsetTop = 2;
   
   function createTextAreaWithLines(id)
   {
      var el = document.createElement('DIV');
      var ta = document.getElementById(id);
      ta.parentNode.insertBefore(el,ta);
      el.appendChild(ta);
      
      el.className='textAreaWithLines';
 el.id='textAreaWithLines';
      el.style.width = (ta.offsetWidth + 30) + 'px';
      ta.style.position = 'absolute';
      ta.style.left = '30px';
      el.style.height = (ta.offsetHeight + 2) + 'px';
      el.style.overflow='hidden';
      el.style.position = 'relative';
      el.style.width = (ta.offsetWidth + 30) + 'px';
      var lineObj = document.createElement('DIV');
      lineObj.style.position = 'absolute';
      lineObj.style.top = lineObjOffsetTop + 'px';
      lineObj.style.left = '0px';
      lineObj.style.width = '27px';
      el.insertBefore(lineObj,ta);
      lineObj.style.textAlign = 'right';
      lineObj.className='lineObj';
lineObj.id='lineObj';
      var string = '';
      for(var no=1;no<200;no++){
         if(string.length>0)string = string + '<br>';
         string = string + no;
      }
      
      ta.onkeydown = function() { positionLineObj(lineObj,ta); };
      ta.onmousedown = function() { positionLineObj(lineObj,ta); };
      ta.onscroll = function() { positionLineObj(lineObj,ta); };
      ta.onblur = function() { positionLineObj(lineObj,ta); };
      ta.onfocus = function() { positionLineObj(lineObj,ta); };
      ta.onmouseover = function() { positionLineObj(lineObj,ta); };
      lineObj.innerHTML = string;
      
   }
   
   function positionLineObj(obj,ta)
   {
      obj.style.top = (ta.scrollTop * -1 + lineObjOffsetTop) + 'px';   
   
      
   }
   
   </script>
<form action=<?php echo $PHP_SELF;?> method=post><table align=center width=1000><tr><td align=center>
<div>
<textarea style="width:100%; height: 400px;" name='filebody' ID=filebody
onscroll=""><?php 
$handle = @fopen($filee, "r");
if ($handle) {
    $b="";
    while (($buffer = fgets($handle, 4096)) !== false) {
        $b.=$buffer;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() failn";
    }
    fclose($handle);
    echo htmlspecialchars($b);
}
?></textarea>
</div>
<input type=hidden value="<?php echo $fileorig;?>" name=file>
<input type=hidden value="yes" name=issave>
<input type=hidden value="0" name=scrollpos ID=scrollpos>
<BR><input type=submit value=' Save to file '>
</td></tr></table>
</form>

   <script type="text/javascript">
   createTextAreaWithLines('filebody');
function localsaveposs() {
 tmp=getobj('scrollpos');
 tmp2=getobj('lineObj');
 tmp.value=tmp2.style.top;
 //console.log('scroll');
}
setInterval("localsaveposs();",100);
<?php if ($scrollpos!="") {
   ?> tmp3=getobj('lineObj');
console.log('scroll to <?php echo $scrollpos;?>');
tmp3.style.top='<?php echo $scrollpos;?>';<?php
} ?>
   </script>
<?php
foot();
?>