<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Blsvsa2013',
	array(
		'Schulen' => 'edit, update show, list, update, create, new, delete',
		'Feuser' => 'list, edit, create, new, update, delete',
		'Schueler' => 'import, export, list, edit',
		
	),
	// non-cacheable actions
	array(
		'Schulen' => 'edit, show, list, update',
		'Feuser' => 'list, edit, create, new, update, delete',
		'Schueler' => 'import, export, list, edit',
	)
);

?>