<?php  //พ
// thanks to tripleaxis
//http://www.tripleaxis.com/codeViewer.php?file=php/XMLFileStructure.php

function parse_dir( $folder,$fileFilter,$folderFilter,$showPath ){
	
	if( is_array( $folderFilter ) && in_array( $folder,$folderFilter ) ) return;
	
	$dir 		= @opendir( $folder );	
	$fname 		= array_pop( explode( "/",$folder) );
	$fname 		= empty( $fname ) ? "node" : str_replace( " ","_",$fname );
	$path_parts = pathinfo(realpath( $folder ));
	$path 		= ( $showPath ) ? " fullpath=\"".realpath( $folder )."\"" : "";
	$filecount 	= 0;
	$foldercount = 0;
	$xml 		= "";
	
	while ( false != ( $item = @readdir( $dir ) ) ) {		
		if( $item == "." || $item == ".." ) continue;
		if( is_dir( "$folder/$item" ) ){
			$xml.= parse_dir( "$folder/$item",$fileFilter,$folderFilter,$showPath );
			$foldercount++;
			continue;
		}		
		$ftype = array_pop( explode( ".", strtolower( $item ) ) );
		$goodfile = is_array( $fileFilter ) ? !in_array( "$folder/$item",$fileFilter ) : true;
		if ( $goodfile ) {			
			$xml.= "<node label='".$item."'/>";
			$filecount++;			
		}
	}	
	
	$xml = "<node label=\"".strToUpper($fname)."\" folders=\"$foldercount\" files=\"$filecount\"$path>$xml</node>";	
	return $xml;

}

// GET FOLDER INFO:
$basedir = "./"; //current dir as default
/*
$excludeFiles = array( "$basedir/private.txt","$basedir/swf/arrow.fla" );
$excludeFolders = array( "$basedir/hidden_folder" );
*/
$showFullPath = true;

// WRITE OUT XML:
header( 'Cache-Control: no-cache' );
header( 'Pragma: no-cache' );
header( 'User-Agent: XS3_XMLFILEStructure_Script' );
header( 'content-type: text/xml' );
die( parse_dir( $basedir,$excludeFiles,$excludeFolders,$showFullPath ) );
?>