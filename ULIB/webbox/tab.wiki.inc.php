<?php 
function local_inc_wikirow($wh) {
	global $dcrURL;
	global $localstatusdb;
	global $_ISULIBMASTER;
	$dsptitle=stripslashes($wh[title]);
	$dsptitle=str_replace('_',' ',$dsptitle);
		$wicipq=tmq("select * from globalupload where keyid='wiki-$wh[id]' and wikiprofile='yes'");
		if (tmq_num_rows($wicipq)>0) {
			$coverhtml="";
			while ($wicipqr=tmq_fetch_array($wicipq)) {
				$coverhtml.="<img src='$dcrURL"."_globalupload/$wicipqr[keyid]/$wicipqr[hidename]' height=20
				Title='".stripslashes($wicipqr[filename])."' style='float:right;'>";
			}
		}
/* ซ่อนไว้เนื่องจากไม่ได้ใช้ status image
	if (!is_array($localstatusdb) ) {
		$localstatusdb=tmq_dump2("webpage_wiki_status","code","name,descr");
	}
	$wikistatuesd=explode(',',$wh[status]);
	$wikistatused=arr_filter_remnull($wikistatuesd);
	@reset($wikistatused);
	$statusimg="";
	while (list($wikistatusedk,$wikistatusedv)=@each($wikistatused)) {
		if ($_ISULIBMASTER=="yes" && $wikistatusedv=="logedinonly") {
			$statusdb[$wikistatusedv][0]="UUG เท่านั้น::l::UUG Only";
			$statusdb[$wikistatusedv][1]="บทความที่สงวนไว้สำหรับสมาชิก UUG เท่านั้น::l::This article is for UUG Members only";
		}
		$statusimg.="<img src='$dcrURL"."neoimg/wikistatus/$wikistatusedv.png' vspace=1 title=\"".getlang($statusdb[$wikistatusedv][0])."\" border=0 width=16 height=16\">";
	}
*/
	if (getval("_SETTING","wikiusemodrewrite")=="yes") {
		$linkrlink=str_replace(':','--namespace--',$wh[title]);
		return "$statusimg <A HREF='$dcrURL"."wiki/$linkrlink'> $dsptitle </A> $coverhtml";
	} else {
		return "$statusimg <A HREF='$dcrURL"."index.php?webboxload=yes&title=$wh[title]'> $dsptitle </A> $coverhtml";
	}
}

function local_wikibox($wh,$col="#555555") {
	$strdb[titlenotfound]=getlang("เป็นหัวเรื่องใหม่::l::New topic");
	$strdb[adm_edit]=getlang("แก้ไขหัวเรื่อง::l::Edit topic");
	$strdb[adm_addnew]=getlang("กรุณาใช้แบบฟอร์มด้านล่างเพื่อสร้างหัวเรื่องใหม่::l::Please use the following form to create new topic");
///
	$descrdb[titlenotfound]=getlang("คุณสามารถแจ้งเจ้าหน้าที่ให้เพิ่มหัวเรื่องนี้ ");

	$str=$strdb[$wh];
	$descr=$descrdb[$wh];
	?><BR><TABLE width=90% align=center bgcolor='<?php  echo $col?>' 
	border=0 cellpadding=3 cellspacing=1>
	<TR>
		<TD bgcolor=F7F7F7 style="padding-left: 20px;"><B><?php echo $str?></B><BR><?php echo $descr?></TD>
	</TR>
	</TABLE><?php 
}

?><?php 
/* Peace Edited 23 ธันวาคม 2551*/
/* WikiParser
 * Version 1.0
 * Copyright 2005, Steve Blinch
 * http://code.blitzaffe.com
 *
 * This class parses and returns the HTML representation of a document containing 
 * basic MediaWiki-style wiki markup.
 *
 *
 * USAGE
 *
 * Refer to class_WikiRetriever.php (which uses this script to parse fetched
 * wiki documents) for an example.
 *
 *
 * LICENSE
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * 
 *  
 *
 */

class WikiParser {
	
	function WikiParser() {
		$this->reference_wiki = '';
		$this->image_uri = '';
		$this->ignore_images = true;
	}
	function handle_sections2($matches) {
		return $this->handle_sections($matches);
	}
	function handle_sections3($matches) {
		return $this->handle_sections($matches);
	}
	function handle_sections4($matches) {
		return $this->handle_sections($matches);
	}
	function handle_sections($matches) {
		//echo "handle_sections";
		//peaceadd
		$this->section_count++;
		$level = strlen($matches[1]);
		$content = $matches[2];
		
		$this->stop = true;
		// avoid accidental run-on emphasis
		$fontsizedb[1]="18";
		$fontsizedb[2]="17";
		$fontsizedb[3]="16";
		$fontsizedb[4]="14";
		$fontsizedb[5]="13";
		$fontsizedb[6]="12";
		$fontsizedb[7]="10";
		return $this->emphasize_off() . "\n\n<TABLE width=97% cellpadding=0 cellspacing=0 style='border:0; border-style: solid;border-color: 666666;border-bottom-width: 1'>
		<TR valign=top>
			<TD><font  style='display: inline; font-size:".($fontsizedb[$level]).";font-weight:bolder; '>{$content}</font></TD><TD align=right><A name='section".$this->section_count."' HREF='javascript:void(null)' onclick='top.scrollTo(0,0);' class=smaller2>".getlang("บนสุด::l::To to top")."</A></TD>
		</TR>
		</TABLE>\n\n";
	}
	
	function handle_newline($matches) {
		if ($this->suppress_linebreaks) return $this->emphasize_off();
		
		$this->stop = true;
		// avoid accidental run-on emphasis
		return $this->emphasize_off() ;///. "<br /><br />";
	}
	
	function handle_list($matches,$close=false) {

		$listtypes = array(
			'*'=>'ul',
			'#'=>'ol',
		);
		
		$output = "";
		
		$newlevel = ($close) ? 0 : strlen($matches[1]);
		
		while ($this->list_level!=$newlevel) {
			$listchar = substr($matches[1],-1);
			$listtype = $listtypes[$listchar];
			
			//$output .= "[".$this->list_level."->".$newlevel."]";
			
			if ($this->list_level>$newlevel) {
				$listtype = '/'.array_pop($this->list_level_types);
				$this->list_level--;
			} else {
				$this->list_level++;
				array_push($this->list_level_types,$listtype);
			}
			$output .= "\n<{$listtype}>\n";
		}
		
		if ($close) return $output;
		
		$output .= "<li>".$matches[2]."</li>\n";
		
		return $output;
	}
	function handle_definitionlist2($matches,$close=false) {
		return $this->handle_definitionlist($matches,$close=false);
	}
	function handle_definitionlist($matches,$close=false) {
		
		//printr($matches);
		//echo "xxxxxxxxx";
		if ($close) {
			$this->deflist = false;
			return "</dl>\n";
		}
		
		
		$output = "";
		if (!$this->deflist) $output .= "<dl>\n";
		$this->deflist = true;
		switch($matches[1]) {
			case ';';
			case '<p>;':
				$term = $matches[2];
				$p = strpos($term,' :');
				if ($p!==false) {
					list($term,$definition) = explode(':',$term,2);
					$output .= "<dt style='font-weight:bold; color:darkred'>{$term}</dt><dd>{$definition}</dd>";
				} else {
					$output .= "<dt style='font-weight:bold; color:darkred'>{$term}</dt>";
				}
				break;
			case ':</p>';
			case ':':
				$definition = $matches[2];
				$output .= "<dd>{$definition}</dd>\n";
				break;
		}
		
		return $output;
	}
	
	function handle_preformat($matches,$close=false) {
		if ($close) {
			$this->preformat = false;
			return "</pre>\n";
		}
		
		$this->stop_all = true;

		$output = "";
		if (!$this->preformat) $output .= "<pre>";
		$this->preformat = true;
		
		$output .= $matches[1];
		
		return $output."\n";
	}
	
	function handle_horizontalrule($matches) {
		return "<hr />";
	}
	
	function wiki_link($topic) {
		//echo "wiki_link($topic)";
		$topic=str_replace(":","--namespace--",$topic);
		$tmp=ucfirst(str_replace(' ','_',$topic));

		return $tmp;
	}
	
	function handle_image($href,$title,$options) {
		//echo "handle_image";
		if ($this->ignore_images) return "";
		if (!$this->image_uri) return $title;
		
		$href = $this->image_uri . $href;
		
		$imagetag = sprintf(
			'<img src="%s" alt="%s" />',
			$href,
			$title
		);
		foreach ($options as $k=>$option) {
			switch($option) {
				case 'frame':
					$imagetag = sprintf(
						'<div style="float: right; background-color: #F5F5F5; border: 1px solid #D0D0D0; padding: 2px">'.
						'%s'.
						'<div>%s</div>'.
						'</div>',
						$imagetag,
						$title
					);
					break;
				case 'right':
					$imagetag = sprintf(
						'<div style="float: right">%s</div>',
						$imagetag
					);
					break;
			}
		}
		
		return $imagetag;
	}
	
	function handle_internallink($matches) {
		//var_dump($matches);
		//printr($matches);
		$nolink = false;
		
		$href = $matches[4];
		$title = $matches[6] ? $matches[6] : $href.$matches[7];
		$namespace = $matches[3];

		if ($namespace=='Image') {
			$options = explode('|',$title);
			$title = array_pop($options);
			
			return $this->handle_image($href,$title,$options);
		}
		
		$title = preg_replace('/\(.*?\)/','',$title);
		$title = preg_replace('/^.*?\:/','',$title);
		//$title = str_replace(":",'--namespace--',$title);
		
		if ($this->reference_wiki) {
			$href = $this->reference_wiki.($namespace?$namespace.'--namespace--':'').$this->wiki_link($href);
		} else {
			$nolink = true;
		}
		

		if ($nolink) return $title;
		//echo "$href;;;";
		
		$tmpchk=addslashes($matches[2].$matches[4]);
		$tmpchk=trim($tmpchk,']');
		$tmpchk=trim($tmpchk,'[');
		$tmpchk=str_replace(' ','_',$tmpchk);
		//printr($matches);
		$tmpchk=tmq("select id from webpage_wiki where title='$tmpchk'  and hasdata='yes' ",false);
		if (tmq_num_rows($tmpchk)==0) {
			$tmp=sprintf(
				'<a href="%s"%s  style=\'color:darkred; font-size: inherit;\'>%s</a>',
				$href,
				($newwindow?' target="_blank"':''),
				$title
			);
		} else {
			$tmp=sprintf(
				'<a href="%s"%s style=\'font-size: inherit;\'>%s</a>',
				$href,
				($newwindow?' target="_blank"':''),
				$title
			);
		
		}
		return $tmp;
	}
	
	function handle_externallink($matches) {
		$href = $matches[2];
		$title = $matches[3];
		if (!$title) {
			$this->linknumber++;
			///$title = "[{$this->linknumber}]";
			$title = $matches[2];
		}
		$newwindow = true;
		
		return sprintf(
			'<a href="%s"%s style="color:#123D70">%s</a>',
			$href,
			($newwindow?' target="_blank"':''),
			$title
		);		
	}
	
	function emphasize($amount) {
		$amounts = array(
			2=>array('<em>','</em>'),
			3=>array('<strong>','</strong>'),
			4=>array('<strong>','</strong>'),
			5=>array('<em><strong>','</strong></em>'),
		);

		$output = "";

		// handle cases where emphasized phrases end in an apostrophe, eg: ''somethin'''
		// should read <em>somethin'</em> rather than <em>somethin<strong>
		if ( (!$this->emphasis[$amount]) && ($this->emphasis[$amount-1]) ) {
			$amount--;
			$output = "'";
		}

		$output .= $amounts[$amount][(int) $this->emphasis[$amount]];

		$this->emphasis[$amount] = !$this->emphasis[$amount];
		
		return $output;
	}
	
	function handle_emphasize($matches) {
		$amount = strlen($matches[1]);
		return $this->emphasize($amount);

	}
	
	function emphasize_off() {
		$output = "";
		if (is_array($this->emphasis)) {
			foreach ($this->emphasis as $amount=>$state) {
				if ($state) $output .= $this->emphasize($amount);
			}
		}
		return $output;
	}
	
	function handle_eliminate($matches) {
		//(={1,6})(.*?)(={1,6})
		//echo $this->page_text;

		if (preg_match_all ("/<p>(={1,6})(.*?)(={1,6})/i",$this->page_text,$matchesct)) {
			if ($matches[1]=="__TOC__") {
				$str="";
				$i=0;
				//printr($matchesct);
				while (list($matchesctk,$matchesctv)=@each($matchesct[2])) {
					$randobj=randid();
					$i++;
					$addblank="";
					for($ix=1;$ix<strlen($matchesct[1][$matchesctk]);$ix++) {
						$addblank.=" &nbsp;&nbsp;";
					}
					$str.="$addblank<A HREF='#section$i' class=smaller>". $matchesctv."</A><BR>";
				}
				if ($str=="") {
					$str="- ";
				}
				$str="<TABLE width=220 align=left cellpadding=3 cellspacing=1 bgcolor=#3F777A style='z-index: 1111111111'>
				<TR>
					<TD bgcolor=#F0F7F7 align=center><B class=smaller>".getlang("เนื้อหา::l::Contents")."</B> <A HREF=\"javascript:void(0)\" onclick=\"if (getobj('a$randobj').style.display=='none') {getobj('a$randobj').style.display='';} else {getobj('a$randobj').style.display='none';}\" class=smaller2>[".getlang("ซ่อน::l::Hide")."]</A></TD>
				</TR>
				<TR>
					<TD bgcolor=#F0F7F7><TABLE  ID='a$randobj' width=100% cellpadding=0 cellspacing=0>
					<TR>
						<TD>$str</TD>
					</TR>
					</TABLE></TD>
				</TR>
				</TABLE><BR><BR><BR>\n\n";
				return $str;
			}
		}

		return "";
	}
	
	function handle_variable($matches) {
		switch($matches[2]) {
			case 'CURRENTMONTH': return date('m');
			case 'CURRENTMONTHNAMEGEN':
			case 'CURRENTMONTHNAME': return date('F');
			case 'CURRENTDAY': return date('d');
			case 'CURRENTDAYNAME': return date('l');
			case 'CURRENTYEAR': return date('Y');
			case 'CURRENTTIME': return date('H:i');
			case 'NUMBEROFARTICLES': return 0;
			case 'PAGENAME': return $this->page_title;
			case 'NAMESPACE': return 'None';
			case 'SITENAME': return $_SERVER['HTTP_HOST'];
			default: return '';	
		}
	}
	
	function parse_line($line) {
			//'preformat'=>'^\s(.*?)$',
			//'sections3'=>'(={1,6})(.*?)(={1,6})',
		$line_regexes = array(
			'definitionlist'=>'^([\;\:])\s*(.*?)$',
			'definitionlist2'=>'^<p>([\;\:])\s*(.*?)$',
			'newline'=>'^$',
			'list'=>'^([\*\#]+)(.*?)$',
			'sections'=>'<p>(={1,6})(.*?)(={1,6})',
			'sections2'=>'^(={1,6})(.*?)(={1,6})',
			'sections3'=>'(={1,6})(.*?)(={1,6})<BR \/>$',
			'sections4'=>'(={1,6})(.*?)(={1,6})<\/P>$',
			'horizontalrule'=>'----',
		);
		///			'sections'=>'^(={1,6})(.*?)(={1,6})$',
		///			'horizontalrule'=>'^----$',
		$char_regexes = array(
//			'link'=>'(\[\[((.*?)\:)?(.*?)(\|(.*?))?\]\]([a-z]+)?)',
			'internallink'=>'('.
				'\[\['. // opening brackets
					'(([^\]]*?)\:)?'. // namespace (if any)
					'([^\]]*?)'. // target
					'(\|([^\]]*?))?'. // title (if any)
				'\]\]'. // closing brackets
				'([a-z]+)?'. // any suffixes
				')',
			'externallink'=>'('.
				'\['.
					'([^\]]*?)'.
					'(\s+[^\]]*?)?'.
				'\]'.
				')',
			'emphasize'=>'(\'{2,5})',
			'eliminate'=>'(__TOC__|__NOTOC__|__NOEDITSECTION__)',
			'variable'=>'('. '\{\{' . '([^\}]*?)' . '\}\}' . ')',
		);
				
		$this->stop = false;
		$this->stop_all = false;

		$called = array();
		
		$line = rtrim($line);
		foreach ($line_regexes as $func=>$regex) {
			if (preg_match("/$regex/i",$line,$matches)) {
				$called[$func] = true;
				$func = "handle_".$func;
				$line = $this->$func($matches);
				if ($this->stop || $this->stop_all) break;
			}
		}

		if (!$this->stop_all) {
			$this->stop = false;
			foreach ($char_regexes as $func=>$regex) {
				$line = preg_replace_callback("/$regex/i",array(&$this,"handle_".$func),$line);
				if ($this->stop) break;
			}
		}
		
		$isline = strlen(trim($line))>0;
		
		// if this wasn't a list item, and we are in a list, close the list tag(s)
		if (($this->list_level>0) && !$called['list']) $line = $this->handle_list(false,true) . $line;
		if ($this->deflist && !$called['definitionlist']) $line = $this->handle_definitionlist(false,true) . $line;
		if ($this->preformat && !$called['preformat']) $line = $this->handle_preformat(false,true) . $line;
		
		// suppress linebreaks for the next line if we just displayed one; otherwise re-enable them
		if ($isline) $this->suppress_linebreaks = ($called['newline'] || $called['sections']);
		
		return $line;
	}
	
	function test() {
		$text = "WikiParser stress tester. <br /> Testing...
__TOC__		
		
== Nowiki test ==
<nowiki>[[wooticles|narf]] and '''test''' and stuff.</nowiki>

== Character formatting ==
This is ''emphasized'', this is '''really emphasized''', this is ''''grossly emphasized'''',
and this is just '''''freeking insane'''''.
Done.	

== Variables ==
{{CURRENTDAY}}/{{CURRENTMONTH}}/{{CURRENTYEAR}}
Done.

== Image test ==
[[:Image:bao1.jpg]]
[[Image:bao1.jpg|frame|alternate text]]
[[Image:bao1.jpg|right|alternate text]]
Done.

== Horizontal Rule ==
Above the rule.
----
Done.

== Hyperlink test ==
This is a [[namespace:link target|bitchin hypalink]] to another document for [[click]]ing, with [[(some) hidden text]] and a [[namespace:hidden namespace]].

A link to an external site [http://www.google.ca] as well another [http://www.esitemedia.com], and a [http://www.blitzaffe.com titled link] -- woo!
Done.

== Preformat ==
Not preformatted.
 Totally preformatted 01234    o o
 Again, this is preformatted    b    <-- It's a face
 Again, this is preformatted   ---'
Done.
		
== Bullet test ==
* One bullet
* Another '''bullet'''
*# a list item
*# another list item
*#* unordered, ordered, unordered
*#* again
*# back down one
Done.

== Definition list ==
; yes : opposite of no
; no : opposite of yes
; maybe
: somewhere in between yes and no
Done.

== Indent ==
Normal
: indented woo
: more indentation
Done.

";
		return $this->parse($text);
	}
	
	function parse($text,$title="") {
		$this->redirect = false;
		
		$this->nowikis = array();
		$this->list_level_types = array();
		$this->list_level = 0;
		
		$this->deflist = false;
		$this->linknumber = 0;
		$this->suppress_linebreaks = false;
		
		$this->page_title = $title;

		/// peace add
		$this->page_text = $text;

		$output = "";
		
		$text = preg_replace_callback('/<nowiki>([\s\S]*)<\/nowiki>/i',array(&$this,"handle_save_nowiki"),$text);

		$lines = explodenewline($text);

		///$lines = explode("\n",$text);
		
		if (preg_match('/^\#REDIRECT\s+\[\[(.*?)\]\]$/',trim($lines[0]),$matches)) {
			$this->redirect = $matches[1];
		}
		
		foreach ($lines as $k=>$line) {
			$line = $this->parse_line($line);
			$output .= $line;
		}

		$output = preg_replace_callback('/<nowiki><\/nowiki>/i',array(&$this,"handle_restore_nowiki"),$output);

		return $output;
	}
	
	function handle_save_nowiki($matches) {
		array_push($this->nowikis,$matches[1]);
		return "<nowiki></nowiki>";
	}
	
	function handle_restore_nowiki($matches) {
		return array_pop($this->nowikis);
	}
}
?>