<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Blsvsa2013',
	array(
		'Schulen' => 'edit, update show, list, create, new, delete, listAdm, editAdm, updateAdm, listUrkunden, printUrkunden, printPackliste, showUrkunden, confirmUrkunden, fehler, importSchueler',
		'Feusers' => 'list, edit, create, new, update, delete',
		'Schueler' => 'import, export, list, edit, importErgebnisListen, importErgebnisExcel,updateSchule,listFilterName',
		'Bestellung' =>'list,edit,new,update, create, new,show,debitorwahl,fehler,createInDebitor,newTeilnehmer,createTeilnehmer,printUrkunden,printPackliste,showUrkunden,confirmUrkunden',
		'Klassen'	=> 'list',
		'Teilnahmen'	=> 'list, listklasse, updateklasse, updateFromExcel' 
		
	),
	// non-cacheable actions
	array(
		'Schulen' => 'edit, show, list, update, listAdm, editAdm, updateAdm, listUrkunden, printUrkunden, printPackliste, showUrkunden, confirmUrkunden, fehler, importSchueler',
		'Feusers' => 'list, edit, create, new, update, delete',
		'Schueler' => 'import, export, list, edit, importErgebnisListen, importErgebnisExcel,updateSchule,listFilterName',		
		'Bestellung' =>'list,edit,new,update, create, new,show,debitorwahl,fehler,createInDebitor,newTeilnehmer,createTeilnehmer,printUrkunden,printPackliste,showUrkunden,confirmUrkunden',
		'Klassen'	=> 'list',
		'Teilnahmen'	=> 'list, listklasse, updateklasse, updateFromExcel' 
	)
);

?>