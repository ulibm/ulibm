<?php
set_time_limit(0);


		$dcrs=str_replace("\\","/",__FILE__);
		$dcrs=str_replace('_ULIBTRANSDATA.php','',$dcrs);
		$dcrs=rtrim($dcrs,'/');
		$dcrs="$dcrs/";
		//echo $dcrs;
		

function udecodelocal($s) {
   $a=explode(":",$s);
   //echo "<pre>";print_r($a);
   $res="";
   @reset($a);
   while (list($k,$v)=each($a)) {
      if ($v=="" || $v==chr(13) || $v==chr(10)) {
         continue;
      }
      if (mb_substr($v,0,1)=="c") {
         $res=$res.("a".trim($v,"c")."b");
      }
      $res=$res.chr($v);
   }
   
					$res=str_replace("a161b","ก",$res);
					$res=str_replace("a162b","ข",$res);
					$res=str_replace("a163b","ฃ",$res);
					$res=str_replace("a164b","ค",$res);
					$res=str_replace("a165b","ฅ",$res);
					$res=str_replace("a166b","ฆ",$res);
					$res=str_replace("a167b","ง",$res);
					$res=str_replace("a168b","จ",$res);
					$res=str_replace("a169b","ฉ",$res);
					$res=str_replace("a170b","ช",$res);
					$res=str_replace("a171b","ซ",$res);
					$res=str_replace("a172b","ฌ",$res);
					$res=str_replace("a173b","ญ",$res);
					$res=str_replace("a174b","ฎ",$res);
					$res=str_replace("a175b","ฏ",$res);
					$res=str_replace("a176b","ฐ",$res);
					$res=str_replace("a177b","ฑ",$res);
					$res=str_replace("a178b","ฒ",$res);
					$res=str_replace("a179b","ณ",$res);
					$res=str_replace("a180b","ด",$res);
					$res=str_replace("a181b","ต",$res);
					$res=str_replace("a182b","ถ",$res);
					$res=str_replace("a183b","ท",$res);
					$res=str_replace("a184b","ธ",$res);
					$res=str_replace("a185b","น",$res);
					$res=str_replace("a186b","บ",$res);
					$res=str_replace("a187b","ป",$res);
					$res=str_replace("a188b","ผ",$res);
					$res=str_replace("a189b","ฝ",$res);
					$res=str_replace("a190b","พ",$res);
					$res=str_replace("a191b","ฟ",$res);
					$res=str_replace("a192b","ภ",$res);
					$res=str_replace("a193b","ม",$res);
					$res=str_replace("a194b","ย",$res);
					$res=str_replace("a195b","ร",$res);
					$res=str_replace("a196b","ฤ",$res);
					$res=str_replace("a197b","ล",$res);
					$res=str_replace("a198b","ฦ",$res);
					$res=str_replace("a199b","ว",$res);
					$res=str_replace("a200b","ศ",$res);
					$res=str_replace("a201b","ษ",$res);
					$res=str_replace("a202b","ส",$res);
					$res=str_replace("a203b","ห",$res);
					$res=str_replace("a204b","ฬ",$res);
					$res=str_replace("a205b","อ",$res);
					$res=str_replace("a206b","ฮ",$res);
					$res=str_replace("a207b","ฯ",$res);
					$res=str_replace("a208b","ะ",$res);
					$res=str_replace("a209b","ั",$res);
					$res=str_replace("a210b","า",$res);
					$res=str_replace("a211b","ำ",$res);
					$res=str_replace("a212b","ิ",$res);
					$res=str_replace("a213b","ี",$res);
					$res=str_replace("a214b","ึ",$res);
					$res=str_replace("a215b","ื",$res);
					$res=str_replace("a216b","ุ",$res);
					$res=str_replace("a217b","ู",$res);
					$res=str_replace("a218b","ฺ",$res);

					$res=str_replace("a219b","",$res);
					$res=str_replace("a220b","",$res);
					$res=str_replace("a221b","",$res);
					$res=str_replace("a222b","",$res);
					$res=str_replace("a223b","฿",$res);
					$res=str_replace("a224b","เ",$res);
					$res=str_replace("a225b","แ",$res);
					$res=str_replace("a226b","โ",$res);
					$res=str_replace("a227b","ใ",$res);
					$res=str_replace("a228b","ไ",$res);
					$res=str_replace("a229b","ๅ",$res);
					$res=str_replace("a230b","ๆ",$res);
					$res=str_replace("a231b","็",$res);
					$res=str_replace("a232b","่",$res);
					$res=str_replace("a233b","้",$res);
					$res=str_replace("a234b","๊",$res);
					$res=str_replace("a235b","๋",$res);
					$res=str_replace("a236b","์",$res);
					$res=str_replace("a237b","ํ",$res);
					$res=str_replace("a238b","™",$res);
					$res=str_replace("a239b","๏",$res);
					$res=str_replace("a240b","๐",$res);
					$res=str_replace("a241b","๑",$res);
					$res=str_replace("a242b","๒",$res);
					$res=str_replace("a243b","๓",$res);
					$res=str_replace("a244b","๔",$res);
					$res=str_replace("a245b","๕",$res);
					$res=str_replace("a246b","๖",$res);
					$res=str_replace("a247b","๗",$res);
					$res=str_replace("a248b","๘",$res);
					$res=str_replace("a249b","๙",$res);
					$res=str_replace("a250b","®",$res);

					$res=str_replace("a94b","^",$res);
					$res=str_replace("a95b","_",$res);
					$res=str_replace("a96b","`",$res);
					$res=str_replace("a97b","a",$res);
					$res=str_replace("a98b","b",$res);
					$res=str_replace("a99b","c",$res);
					$res=str_replace("a100b","d",$res);
					$res=str_replace("a101b","e",$res);
					$res=str_replace("a102b","f",$res);
					$res=str_replace("a103b","g",$res);
					$res=str_replace("a104b","h",$res);
					$res=str_replace("a105b","i",$res);
					$res=str_replace("a106b","j",$res);
					$res=str_replace("a107b","k",$res);
					$res=str_replace("a108b","l",$res);
					$res=str_replace("a109b","m",$res);
					$res=str_replace("a110b","n",$res);
					$res=str_replace("a111b","o",$res);
					$res=str_replace("a112b","p",$res);
					$res=str_replace("a113b","q",$res);
					$res=str_replace("a114b","r",$res);
					$res=str_replace("a115b","s",$res);
					$res=str_replace("a116b","t",$res);
					$res=str_replace("a117b","u",$res);
					$res=str_replace("a118b","v",$res);
					$res=str_replace("a119b","w",$res);
					$res=str_replace("a120b","x",$res);
					$res=str_replace("a121b","y",$res);
					$res=str_replace("a122b","z",$res);
					$res=str_replace("a123b","{",$res);
					$res=str_replace("a124b","|",$res);
					$res=str_replace("a125b","}",$res);
					$res=str_replace("a126b","~",$res);
					$res=str_replace("a127b","",$res);

   //echo ("$s=$res<BR>");
   return $res;
   
}
//include("archive.php");
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

function iconvth($str) {
   //return $str;
  //mb_language("Thai");
  //mb_detect_order ("TIS620, UTF-8, ASCII");
	//printr(mb_get_info());
	  ini_set('mbstring.substitute_character', "none"); 

	$currentenc=mb_detect_encoding($str, "auto");
	//return "iconvth\$currentenc=$currentenc;";die;
	//iconv_set_encoding('output_encoding','TIS620');
	
	//if (isUTF8($str)) { echo "yes";} else { echo "no";}
	if ($currentenc!="" && isUTF8($str)) {
	    //$str=html_entity_decode(htmlentities($str, ENT_QUOTES, 'UTF-8'), ENT_QUOTES , 'TIS620');;
	    //$str=mb_convert_encoding($oldstring, 'TIS620', 'UTF-8');
		 $str2=iconv("$currentenc","TIS620//TRANSLIT",$str);///SJIS/EUC-JP/
		 $str3=iconv("$currentenc","TIS620//IGNORE",$str);///SJIS/EUC-JP/
		 if ($str2=="") {
		    $str2=$str3;
		 }
		 //$str2=mb_convert_encoding($str,'TIS-620',$currentenc); 
	} else {
		$str2=$str;
	}
	//return "$currentenc [$str=>$str2]<br />";
	return $str2;
}

  function isUTF8($str) {
       if ($str === mb_convert_encoding(mb_convert_encoding($str, "UTF-32", "UTF-8"), "UTF-8", "UTF-32")) {
           return true;
       } else {
           return false;
       }
   }

if (!function_exists("uencode")) {
function uencode($wha) {
   //echo "uencode()"; die("here");;
	$wh=iconvth($wha);
	$r="";
	for ($i=0;$i<=mb_strlen($wh);$i++) {
		if (ord(mb_substr($wh,$i,1))>160 && ord(mb_substr($wh,$i,1)) <=250) {
			$r.=":c".ord(mb_substr($wh,$i,1))."";
		} else {
			$r.=":".ord(mb_substr($wh,$i,1));
		}
	}
	//die ($r);
	return $r;
}
}
/*--------------------------------------------------
 | TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.1
 | By Devin Doucette
 | Copyright (c) 2005 Devin Doucette
 | Email: darksnoopy@shaw.ca
 +--------------------------------------------------
 | Email bugs/suggestions to darksnoopy@shaw.ca
 +--------------------------------------------------
 | This script has been created and released under
 | the GNU GPL and is free to use and redistribute
 | only if this copyright statement is not removed
 +--------------------------------------------------*/

class archive
{
	function archive($name)
	{
		$this->options = array (
			'basedir' => ".",
			'name' => $name,
			'prepend' => "",
			'inmemory' => 0,
			'overwrite' => 0,
			'recurse' => 1,
			'storepaths' => 1,
			'followlinks' => 0,
			'level' => 3,
			'method' => 1,
			'sfx' => "",
			'type' => "",
			'comment' => ""
		);
		$this->files = array ();
		$this->exclude = array ();
		$this->storeonly = array ();
		$this->error = array ();
	}

	function set_options($options)
	{
		foreach ($options as $key => $value)
			$this->options[$key] = $value;
		if (!empty ($this->options['basedir']))
		{
			$this->options['basedir'] = str_replace("\\", "/", $this->options['basedir']);
			$this->options['basedir'] = preg_replace("/\/+/", "/", $this->options['basedir']);
			$this->options['basedir'] = preg_replace("/\/$/", "", $this->options['basedir']);
		}
		if (!empty ($this->options['name']))
		{
			$this->options['name'] = str_replace("\\", "/", $this->options['name']);
			$this->options['name'] = preg_replace("/\/+/", "/", $this->options['name']);
		}
		if (!empty ($this->options['prepend']))
		{
			$this->options['prepend'] = str_replace("\\", "/", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/^(\.*\/+)+/", "", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/\/+/", "/", $this->options['prepend']);
			$this->options['prepend'] = preg_replace("/\/$/", "", $this->options['prepend']) . "/";
		}
	}

	function create_archive()
	{
		$this->make_list();

		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($this->options['overwrite'] == 0 && file_exists($this->options['name'] . ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : "")))
			{
				$this->error[] = "File {$this->options['name']} already exists.";
				chdir($pwd);
				return 0;
			}
			else if ($this->archive = @fopen($this->options['name'] . ($this->options['type'] == "gzip" || $this->options['type'] == "bzip" ? ".tmp" : ""), "wb+"))
				chdir($pwd);
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = "";

		switch ($this->options['type'])
		{
		case "zip":
			if (!$this->create_zip())
			{
				$this->error[] = "Could not create zip file.";
				return 0;
			}
			break;
		case "bzip":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
			if (!$this->create_bzip())
			{
				$this->error[] = "Could not create bzip2 file.";
				return 0;
			}
			break;
		case "gzip":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
			if (!$this->create_gzip())
			{
				$this->error[] = "Could not create gzip file.";
				return 0;
			}
			break;
		case "tar":
			if (!$this->create_tar())
			{
				$this->error[] = "Could not create tar file.";
				return 0;
			}
		}

		if ($this->options['inmemory'] == 0)
		{
			fclose($this->archive);
			if ($this->options['type'] == "gzip" || $this->options['type'] == "bzip")
				unlink($this->options['basedir'] . "/" . $this->options['name'] . ".tmp");
		}
	}

	function add_data($data)
	{
		if ($this->options['inmemory'] == 0)
			fwrite($this->archive, $data);
		else
			$this->archive .= $data;
	}

	function make_list()
	{
		if (!empty ($this->exclude))
			foreach ($this->files as $key => $value)
				foreach ($this->exclude as $current)
					if ($value['name'] == $current['name']) {
						unset ($this->files[$key]);
						//echo "skipping ".$current['name'];
					}
		if (!empty ($this->storeonly))
			foreach ($this->files as $key => $value)
				foreach ($this->storeonly as $current)
					if ($value['name'] == $current['name'])
						$this->files[$key]['method'] = 0;
		unset ($this->exclude, $this->storeonly);
	}

	function add_files($list)
	{
		$temp = $this->list_files($list);
		foreach ($temp as $current)
			$this->files[] = $current;
	}

	function exclude_files($list)
	{
		$temp = $this->list_files($list);
		//print_r($temp);
		foreach ($temp as $current)
			$this->exclude[] = $current;
		echo "excluded: $list ".count($this->exclude)."<br>";
	}

	function store_files($list)
	{
		$temp = $this->list_files($list);
		foreach ($temp as $current)
			$this->storeonly[] = $current;
	}

	function list_files($list)
	{
		if (!is_array ($list))
		{
			$temp = $list;
			$list = array ($temp);
			unset ($temp);
		}

		$files = array ();

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($list as $current)
		{
			$current = str_replace("\\", "/", $current);
			$current = preg_replace("/\/+/", "/", $current);
			$current = preg_replace("/\/$/", "", $current);
			if (strstr($current, "*"))
			{
				$regex = preg_replace("/([\\\^\$\.\[\]\|\(\)\?\+\{\}\/])/", "\\\\\\1", $current);
				$regex = str_replace("*", ".*", $regex);
				$dir = strstr($current, "/") ? substr($current, 0, strrpos($current, "/")) : ".";
				$temp = $this->parse_dir($dir);
				foreach ($temp as $current2)
					if (preg_match("/^{$regex}$/i", $current2['name']))
						$files[] = $current2;
				unset ($regex, $dir, $temp, $current);
			}
			else if (@is_dir($current))
			{
				$temp = $this->parse_dir($current);
				foreach ($temp as $file)
					$files[] = $file;
				unset ($temp, $file);
			}
			else if (@file_exists($current))
				$files[] = array ('name' => $current, 'name2' => $this->options['prepend'] .
					preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($current, "/")) ?
					substr($current, strrpos($current, "/") + 1) : $current),
					'type' => @is_link($current) && $this->options['followlinks'] == 0 ? 2 : 0,
					'ext' => substr($current, strrpos($current, ".")), 'stat' => stat($current));
		}

		chdir($pwd);

		unset ($current, $pwd);

		usort($files, array ("archive", "sort_files"));

		return $files;
	}

	function parse_dir($dirname)
	{
      //echo "parse_dir($dirname)<BR>";
		if ($this->options['storepaths'] == 1 && !preg_match("/^(\.+\/*)+$/", $dirname))
			$files = array (array ('name' => $dirname, 'name2' => $this->options['prepend'] .
				preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname, "/")) ?
				substr($dirname, strrpos($dirname, "/") + 1) : $dirname), 'type' => 5, 'stat' => stat($dirname)));
		else
			$files = array ();
		$dir = @opendir($dirname);

		while ($file = @readdir($dir))
		{
			$fullname = $dirname . "/" . $file;
			if ($file == "." || $file == "..")
				continue;
			else if (@is_dir($fullname))
			{
				if (empty ($this->options['recurse']))
					continue;
				$temp = $this->parse_dir($fullname);
				foreach ($temp as $file2)
					$files[] = $file2;
			}
			else if (@file_exists($fullname))
				$files[] = array ('name' => $fullname, 'name2' => $this->options['prepend'] .
					preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($fullname, "/")) ?
					substr($fullname, strrpos($fullname, "/") + 1) : $fullname),
					'type' => @is_link($fullname) && $this->options['followlinks'] == 0 ? 2 : 0,
					'ext' => substr($file, strrpos($file, ".")), 'stat' => stat($fullname));
		}

		@closedir($dir);

		return $files;
	}

	function sort_files($a, $b)
	{
		if ($a['type'] != $b['type'])
			if ($a['type'] == 5 || $b['type'] == 2)
				return -1;
			else if ($a['type'] == 2 || $b['type'] == 5)
				return 1;
		else if ($a['type'] == 5)
			return strcmp(strtolower($a['name']), strtolower($b['name']));
		else if ($a['ext'] != $b['ext'])
			return strcmp($a['ext'], $b['ext']);
		else if ($a['stat'][7] != $b['stat'][7])
			return $a['stat'][7] > $b['stat'][7] ? -1 : 1;
		else
			return strcmp(strtolower($a['name']), strtolower($b['name']));
		return 0;
	}

	function download_file()
	{
		if ($this->options['inmemory'] == 0)
		{
			$this->error[] = "Can only use download_file() if archive is in memory. Redirect to file otherwise, it is faster.";
			return;
		}
		switch ($this->options['type'])
		{
		case "zip":
			header("Content-Type: application/zip");
			break;
		case "bzip":
			header("Content-Type: application/x-bzip2");
			break;
		case "gzip":
			header("Content-Type: application/x-gzip");
			break;
		case "tar":
			header("Content-Type: application/x-tar");
		}
		$header = "Content-Disposition: attachment; filename=\"";
		$header .= strstr($this->options['name'], "/") ? substr($this->options['name'], strrpos($this->options['name'], "/") + 1) : $this->options['name'];
		$header .= "\"";
		header($header);
		header("Content-Length: " . strlen($this->archive));
		header("Content-Transfer-Encoding: binary");
		header("Cache-Control: no-cache, must-revalidate, max-age=60");
		header("Expires: Sat, 01 Jan 2000 12:00:00 GMT");
		print($this->archive);
	}
}

class tar_file extends archive
{
	function tar_file($name)
	{
		$this->archive($name);
		$this->options['type'] = "tar";
	}

	function create_tar()
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current)
		{
			if ($current['name'] == $this->options['name'])
				continue;
			if (strlen($current['name2']) > 99)
			{
				$path = substr($current['name2'], 0, strpos($current['name2'], "/", strlen($current['name2']) - 100) + 1);
				$current['name2'] = substr($current['name2'], strlen($path));
				if (strlen($path) > 154 || strlen($current['name2']) > 99)
				{
					$this->error[] = "Could not add {$path}{$current['name2']} to archive because the filename is too long.";
					continue;
				}
			}
			$block = pack("a100a8a8a8a12a12a8a1a100a6a2a32a32a8a8a155a12", $current['name2'], sprintf("%07o", 
				$current['stat'][2]), sprintf("%07o", $current['stat'][4]), sprintf("%07o", $current['stat'][5]), 
				sprintf("%011o", $current['type'] == 2 ? 0 : $current['stat'][7]), sprintf("%011o", $current['stat'][9]), 
				"        ", $current['type'], $current['type'] == 2 ? @readlink($current['name']) : "", "ustar ", " ", 
				"Unknown", "Unknown", "", "", !empty ($path) ? $path : "", "");

			$checksum = 0;
			for ($i = 0; $i < 512; $i++)
				$checksum += ord(substr($block, $i, 1));
			$checksum = pack("a8", sprintf("%07o", $checksum));
			$block = substr_replace($block, $checksum, 148, 8);

			if ($current['type'] == 2 || $current['stat'][7] == 0)
				$this->add_data($block);
			else if ($fp = @fopen($current['name'], "rb"))
			{
				$this->add_data($block);
				while ($temp = fread($fp, 1048576))
					$this->add_data($temp);
				if ($current['stat'][7] % 512 > 0)
				{
					$temp = "";
					for ($i = 0; $i < 512 - $current['stat'][7] % 512; $i++)
						$temp .= "\0";
					$this->add_data($temp);
				}
				fclose($fp);
			}
			else
				$this->error[] = "Could not open file {$current['name']} for reading. It was not added.";
		}

		$this->add_data(pack("a1024", ""));

		chdir($pwd);

		return 1;
	}

	function extract_files()
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);
      //echo "here";
      //printr($this);
		if ($fp = $this->open_archive())
		{
			if ($this->options['inmemory'] == 1)
				$this->files = array ();

			while ($block = fread($fp, 512))
			{
				$temp = unpack("a100name/a8mode/a8uid/a8gid/a12size/a12mtime/a8checksum/a1type/a100symlink/a6magic/a2temp/a32temp/a32temp/a8temp/a8temp/a155prefix/a12temp", $block);
				$file = array (
					'name' => $temp['prefix'] . $temp['name'],
					'stat' => array (
						2 => $temp['mode'],
						4 => octdec($temp['uid']),
						5 => octdec($temp['gid']),
						7 => octdec($temp['size']),
						9 => octdec($temp['mtime']),
					),
					'checksum' => octdec($temp['checksum']),
					'type' => $temp['type'],
					'magic' => $temp['magic'],
				);
				if ($file['checksum'] == 0x00000000)
					break;
				else if (substr($file['magic'], 0, 5) != "ustar")
				{
					$this->error[] = "This script does not support extracting this type of tar file.";
					break;
				}
				$block = substr_replace($block, "        ", 148, 8);
				$checksum = 0;
				for ($i = 0; $i < 512; $i++)
					$checksum += ord(substr($block, $i, 1));
				if ($file['checksum'] != $checksum)
					$this->error[] = "Could not extract from {$this->options['name']}, it is corrupt.";

				if ($this->options['inmemory'] == 1)
				{
					$file['data'] = fread($fp, $file['stat'][7]);
					fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					unset ($file['checksum'], $file['magic']);
					$this->files[] = $file;
				}
				else if ($file['type'] == 5)
				{
					if (!is_dir($file['name']))
						mkdir($file['name'], $file['stat'][2]);
				}
				else if ($this->options['overwrite'] == 0 && file_exists($file['name']))
				{
					$this->error[] = "{$file['name']} already exists.";
					continue;
				}
				else if ($file['type'] == 2)
				{
					symlink($temp['symlink'], $file['name']);
					chmod($file['name'], $file['stat'][2]);
				}
				else if ($new = @fopen($file['name'], "wb"))
				{
					fwrite($new, fread($fp, $file['stat'][7]));
					fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					fclose($new);
					chmod($file['name'], $file['stat'][2]);
				}
				else
				{
					$this->error[] = "Could not open {$file['name']} for writing.";
					continue;
				}
				chown($file['name'], $file['stat'][4]);
				chgrp($file['name'], $file['stat'][5]);
				touch($file['name'], $file['stat'][9]);
				unset ($file);
			}
		}
		else
			$this->error[] = "Could not open file {$this->options['name']}";

		chdir($pwd);
	}

	function open_archive()
	{
		return @fopen($this->options['name'], "rb");
	}
}

class gzip_file extends tar_file
{
	function gzip_file($name)
	{
		$this->tar_file($name);
		$this->options['type'] = "gzip";
	}

	function create_gzip()
	{
		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = gzopen($this->options['name'], "wb{$this->options['level']}"))
			{
				fseek($this->archive, 0);
				while ($temp = fread($this->archive, 1048576))
					gzwrite($fp, $temp);
				gzclose($fp);
				chdir($pwd);
			}
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = gzencode($this->archive, $this->options['level']);

		return 1;
	}

	function open_archive()
	{
		return @gzopen($this->options['name'], "rb");
	}
}

class bzip_file extends tar_file
{
	function bzip_file($name)
	{
		$this->tar_file($name);
		$this->options['type'] = "bzip";
	}

	function create_bzip()
	{
		if ($this->options['inmemory'] == 0)
		{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			if ($fp = bzopen($this->options['name'], "wb"))
			{
				fseek($this->archive, 0);
				while ($temp = fread($this->archive, 1048576))
					bzwrite($fp, $temp);
				bzclose($fp);
				chdir($pwd);
			}
			else
			{
				$this->error[] = "Could not open {$this->options['name']} for writing.";
				chdir($pwd);
				return 0;
			}
		}
		else
			$this->archive = bzcompress($this->archive, $this->options['level']);

		return 1;
	}

	function open_archive()
	{
		return @bzopen($this->options['name'], "rb");
	}
}

class zip_file extends archive
{
	function zip_file($name)
	{
		$this->archive($name);
		$this->options['type'] = "zip";
	}

	function create_zip()
	{
		$files = 0;
		$offset = 0;
		$central = "";

		if (!empty ($this->options['sfx']))
			if ($fp = @fopen($this->options['sfx'], "rb"))
			{
				$temp = fread($fp, filesize($this->options['sfx']));
				fclose($fp);
				$this->add_data($temp);
				$offset += strlen($temp);
				unset ($temp);
			}
			else
				$this->error[] = "Could not open sfx module from {$this->options['sfx']}.";

		$pwd = getcwd();
		chdir($this->options['basedir']);

		foreach ($this->files as $current)
		{
			if ($current['name'] == $this->options['name'])
				continue;

			$timedate = explode(" ", date("Y n j G i s", $current['stat'][9]));
			$timedate = ($timedate[0] - 1980 << 25) | ($timedate[1] << 21) | ($timedate[2] << 16) |
				($timedate[3] << 11) | ($timedate[4] << 5) | ($timedate[5]);

			$block = pack("VvvvV", 0x04034b50, 0x000A, 0x0000, (isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate);

			if ($current['stat'][7] == 0 && $current['type'] == 5)
			{
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000);
				$block .= $current['name2'] . "/";
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					0x00000000, 0x00000000, 0x00000000, strlen($current['name2']) + 1, 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2'] . "/";
				$files++;
				$offset += (31 + strlen($current['name2']));
			}
			else if ($current['stat'][7] == 0)
			{
				$block .= pack("VVVvv", 0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000);
				$block .= $current['name2'];
				$this->add_data($block);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					0x00000000, 0x00000000, 0x00000000, strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, $current['type'] == 5 ? 0x00000010 : 0x00000000, $offset);
				$central .= $current['name2'];
				$files++;
				$offset += (30 + strlen($current['name2']));
			}
			else if ($fp = @fopen($current['name'], "rb"))
			{
				$temp = fread($fp, $current['stat'][7]);
				fclose($fp);
				$crc32 = crc32($temp);
				if (!isset($current['method']) && $this->options['method'] == 1)
				{
					$temp = gzcompress($temp, $this->options['level']);
					$size = strlen($temp) - 6;
					$temp = substr($temp, 2, $size);
				}
				else
					$size = strlen($temp);
				$block .= pack("VVVvv", $crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000);
				$block .= $current['name2'];
				$this->add_data($block);
				$this->add_data($temp);
				unset ($temp);
				$central .= pack("VvvvvVVVVvvvvvVV", 0x02014b50, 0x0014, $this->options['method'] == 0 ? 0x0000 : 0x000A, 0x0000,
					(isset($current['method']) || $this->options['method'] == 0) ? 0x0000 : 0x0008, $timedate,
					$crc32, $size, $current['stat'][7], strlen($current['name2']), 0x0000, 0x0000, 0x0000, 0x0000, 0x00000000, $offset);
				$central .= $current['name2'];
				$files++;
				$offset += (30 + strlen($current['name2']) + $size);
			}
			else
				$this->error[] = "Could not open file {$current['name']} for reading. It was not added.";
		}

		$this->add_data($central);

		$this->add_data(pack("VvvvvVVv", 0x06054b50, 0x0000, 0x0000, $files, $files, strlen($central), $offset,
			!empty ($this->options['comment']) ? strlen($this->options['comment']) : 0x0000));

		if (!empty ($this->options['comment']))
			$this->add_data($this->options['comment']);

		chdir($pwd);

		return 1;
	}
} 
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////


function local_archiveit($dir,$mode="") {
//echo "local_archiveit($dir,$mode);";
	global $dcrs;// ๏ฟฝ
	global $dcrURL;// ๏ฟฝ
	//echo($dcrs."_addons/moduleupdate/archive.php");
	//echo $dir."<BR>";die;;

   $aname="tmpsend";
   if ($aname=="") {
      $aname="___root___";
   }
   //echo "[aname=$aname]";
   $output=$dcrs."/_ULIBTRANSDATA_OUT/$aname.tgz";
   $outputurl=substr($output,strlen($dcrs));
   
   //echo("$outputurl"); die;
   //echo("$output"); die;
   //echo "output=$output<BR>   dir=$dir";
   @unlink($output);
   @unlink($output.".tmp");
   /*
	if (!file_exists($output)) {
		touch($output);
	}
	if (!file_exists($output.".tmp")) {
		touch($output.".tmp");
	}*/
   /*
	if (!file_exists($dir."localarchive.tgz")) {
		touch($dir."localarchive.tgz");
	}
	if (!file_exists($dir."localarchive.tgz.tmp")) {
		touch($dir."localarchive.tgz.tmp");
	}*/
   
	$b = new gzip_file($output);
	$b->set_options(array('basedir' => "$dir", 'overwrite' => 1, 'level' => 3,'storepaths' => 0));
	//$b->set_options(array( 'overwrite' => 1, 'level' => 1));
	//$b->add_files(array("$dir"));
   $fss=fso_listfile($dir);
   //printr($fss);
   @reset($fss);
   $filestozip=Array();
   while (list($k,$v)=each($fss)) {
      if (!is_dir($dir."/".$v)) {
         $ext=strtolower(substr($v,-4));
         $ext3=strtolower(substr($v,-3));
         if ($v=="c.inc.php") continue;
         if ($v=="config.inc.sv.php") continue;
         //if ($ext3==".gz") continue;
         if ($ext==".php") continue;
         if ($ext==".bak") continue;
         if ($ext=="s.db") continue;
         $filestozip[]=$v;
      }
   }
   //printr($filestozip);
	$b->add_files($filestozip);
	//$b->add_files(array("index.php"));
      //echo "here";
	//$b->exclude_files($dir."/*.zip");

   /*
	$b->exclude_files($dir."archive.tgz");
	$b->exclude_files($dir."archive.tgz.tmp");
	$b->exclude_files($dir."localarchive.tgz");
	$b->exclude_files($dir."localarchive.tgz.tmp");
	$b->exclude_files($dir."*.tmp");
	$b->exclude_files($dir."*.log");
	$b->exclude_files($dir."*.bak");*/
	/*
	$b->exclude_files("_output/*.tgz");
	$b->exclude_files("_output/*.tmp");
	$b->exclude_files("_output/maxbackup.tgz");
	$b->exclude_files("_output/maxbackup.tgz.tmp");
	$b->exclude_files($dcrs."_logs/*");
	$b->exclude_files($dcrs."_input/*");
	$b->exclude_files($dcrs."_session/*");
	$b->exclude_files($dcrs."_cache/*");
	*/
	//printr($b->exclude);
	//$b->make_list();
	//printr($b->files);
	//echo count($b->files);
//echo "<PRE>";print_r($b);
	//die;
	$b->create_archive();
	if (count($test->errors) > 0) {
		print ("Errors occurred."); // Process errors here
	}
   return $outputurl;
}
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

function fso_listfile($s,$limitsize=0) {
//  $limitsize as kb
	////func("fso_listfile");
$res=Array();
	if ($handle = opendir($s)) {

	    /* This is the correct way to loop over the directory. */
	    while (false !== ($file = readdir($handle))) { 
  			if ($file=="." || $file == "..") {
  				continue;
  			}
			//echo "$file";
				if ($limitsize!=0) {
					 //echo filesize("$s/$file")."<br>";
					 if ((filesize("$s/$file"))<($limitsize*1000)) {
					 		continue;
					 }
				}
			 $res[]="$file";
	    }

	    closedir($handle); 
	} else {
		//echo "fso_listfile($s,$limitsize=0) error, cannot open dir;";
	}
	@sort($res);
	return $res;
}
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////xxxx
//////////////////////////////////////////////////////////////////////////////////////////////
	@mkdir("_ULIBTRANSDATA_OUT");
	if (!file_exists("_ULIBTRANSDATA_OUT")) {
		echo "Cannot create tempolary folder (_ULIBTRANSDATA_OUT) ;";
	}
if ($cmd=="") {

   die("cmd empty");   
}

//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="1ping") {
   die("pingresponse");
}
//////////////////////////////////////////////////////////////////////////////////////////////

if ($cmd=="4getfilelist") {
   $res=Array();
   function listFolderFiles($dir,$mode=""){
   global $res;
    $ffs = scandir($dir);
    $direnc=uencode($dir);
    //echo "[$dir=$direnc]";
    $res[]="".($direnc);
    foreach($ffs as $ff){
    	//echo $dir;
    	if ($mode=="first") {
    		if ($ff !="pic" 
    		&& $ff!="_fulltext"
    		&& $ff!="_tmp"
    		&& $ff!="web"
    		&& $ff!="webboard"
    		&& $ff!="css"
    		&& $ff!="_globalupload") {
    			continue; 
    		}
    	}
        if($ff != '.' && $ff != '..'
        && $ff != 'rootutils'
        && $ff != '_ULIBTRANSDATA_OUT'
        ) { //&& $ff != '.htaccess'
            if(is_dir($dir.'/'.$ff)) {
               listFolderFiles($dir.'/'.$ff);
            } /*else {
               $ext=strtolower(substr($ff,-4)); 
               if ($ext==".psd") continue;
               if ($ext==".exe") continue;
               if ($ext==".zip") continue;
               if ($ext==".tmp") continue;
               if ($ext==".tgz") continue;
               if ($ext=="s.db") continue;
               //$res[]=$dir."/".$ff;
            }*/
        }
    }
}

listFolderFiles(".","first");
@reset($res);
$i=0;
while (list($k,$v)=each($res)) {
   $i=$i+1;
   if (substr($v,0,strlen($dcrs))==$dcrs) {
      $res[$k]=(substr($v,strlen($dcrs)));
   }/*
   if (substr($v,0,4)=="dir:") {
      if (substr($v,0,strlen($dcrs)+4)=="dir:".$dcrs) {
        $res[$k]="dir:".substr($v,strlen($dcrs)+4);
      }
   }*/
   //remove root
   //if ($v=="".rtrim($dcrs," /")) {
   if ($v==".") {
      $res[$k]="[ROOT]";
   }
   //if ($i>100) { printr($res); die; }
}
//print_r($res);
echo base64_encode(serialize($res));
   die;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if ($cmd=="genfolder") {
   $fd=udecodelocal(base64_decode($fd));
   //echo "fd=$fd";
   if ($fd=="[ROOT]") {
      $ddest=".";
   } else {
   	$fd=trim($fd);
   	$fd=ltrim($fd," ./".chr(0));
   	//echo "[fd=$fd]";
      $ddest=$dcrs."".$fd;
      //echo "here";
   }
   //echo "[ddest=".$ddest."]<BR>";
   if (!file_exists($ddest)) {
      die("$ddest not exists");
   }
   if (!is_dir($ddest)) {
      die("$ddest not directory");
   }
   $tmp=local_archiveit("$ddest");
   echo "ok:".$tmp.":eou";


   die;
}
 ?>unknown command, eof