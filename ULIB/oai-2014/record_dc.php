<?php 
/** \file
 * \brief Definition of Dublin Core handler.
 *
 * It is not working as it does not provide any content to the metadata node. It only included
 * to demonstrate how a new metadata can be supported. For a working
 * example, please see record_rif.php.
 *
 * \sa oaidp-config.php
	*/
// พ
function create_metadata($outputObj, $cur_record, $identifier, $setspec, $db) {
/*
	$metadata_node = $outputObj->create_metadata($cur_record);
	echo "create_metadata(outputObj, cur_record, $identifier, $setspec, db)";
	//printr($cur_record);
	//printr($metadata_node);
 	$metadata_node = $outputObj->create_metadata($cur_record);
	$a = new ANDS_XML($outputObj, $metadata_node, $db);
	$a->addChild($a,"b","c");
	//$obj_node->create_obj_node($setspec, $identifier);
*/
	$metadata_node = $outputObj->create_metadata($cur_record);
	$obj_node = new ANDS_MYDC($outputObj, $metadata_node, $db);
	try {
		$obj_node->create_obj_node($setspec, $identifier);
	} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), " when adding $identifier\n";
	}
}

