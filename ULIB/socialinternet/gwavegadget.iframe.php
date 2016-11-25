<?php 
	include ("../inc/config.inc.php");
	// พ
?><Module> 
<ModulePrefs title="Library Gadget" height="280"> 
	<Require feature="rpc" /> 
	<Require feature="setprefs"/> 
	<Require feature="dynamic-height"/> 
</ModulePrefs> 
<Content type="html"> 
<![CDATA[ 

<div style="border: 2px solid #efefef; padding: 2px;"> 
        <iframe id='embeddedIframe<?php  echo $mid;?>' width="100%" frameborder="0" height="280"
		src="<?php  echo $dcrURL?>socialinternet/gwavegadget.iframe-dsp.php?mid=<?php  echo $mid?>"
		></iframe> 
    </div> 

  ]]>
  </Content> 
</Module>