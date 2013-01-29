<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Blsvsa2013',
	'BLSV SA 2013'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . blsvsa2013;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .blsvsa2013. '.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Sportabzeichen online 2013');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Schulen', 'Sportabzeichen online 2013 - Schulen');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/Verwaltung', 'Sportabzeichen online 2013 - Verwaltung');

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_schulen', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_schulen.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_schulen');
$TCA['tx_blsvsa2013_domain_model_schulen'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schulen',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'schulnummer,name,schulart,strasse,plz,ort,telefon,email,bezirk,kreis,blsvkreis,bankempfaenger,kto,blz,verwendungszweck,grundschulen,schulwettbewerb,anzschueler,anzteilnahmeberechtigt,anzbestanden,feuser,institutionsartart,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Schulen.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_schulen.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_teilnahmen', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_teilnahmen.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_teilnahmen');
$TCA['tx_blsvsa2013_domain_model_teilnahmen'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'vorname,name,geschlecht,geburtstag,anzteilnahmen,punktegesamt,urkundenart,gedruckt,drucktstamp,klasse,grundschulwettbewerb,schwimmnachweisgueltigbis,leistungstabelle1,ablagedatum1,pruefer1,ergebnis1,punkte1,leistungstabelle2,ablagedatum2,pruefer2,ergebnis2,punkte2,leistungstabelle3,ablagedatum3,pruefer3,ergebnis3,punkte3,leistungstabelle4,ablagedatum4,pruefer4,ergebnis4,punkte4,pruefungsjahr,schule,leistung1,leistung2,leistung3,leistung4,feuser,schueler,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Teilnahmen.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_teilnahmen.gif'
	),
);

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	// no type field defined, so we define it here. This will only happen the first time the extension is installed!!
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
	$tempColumns = array();
	$tempColumns[$TCA['fe_users']['ctrl']['type']] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers.tx_extbase_type',
		'config' => array(
			'type' => 'select',
			'items' => array(
				array('LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers.tx_extbase_type.0','0'),
			),
			'size' => 1,
			'maxitems' => 1,
			'default' => 'Tx_Blsvsa2013_Feusers'
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
}

$TCA['fe_users']['types']['Tx_Blsvsa2013_Feusers']['showitem'] = $TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers','Tx_Blsvsa2013_Feusers');
t3lib_extMgm::addToAllTCAtypes('fe_users', $TCA['fe_users']['ctrl']['type'],'','after:hidden');

$tmp_blsvsa2013_columns = array(

	'schulnummer' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers.schulnummer',
		'config' => array(
			'type' => 'input',
			'size' => 10,
			'eval' => 'trim'
		),
	),
	'schule' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers.schule',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_blsvsa2013_domain_model_schulen',
			'minitems' => 0,
			'maxitems' => 1,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
	'feuser' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers.feuser',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'fe_users',
			'minitems' => 0,
			'maxitems' => 1,
			'appearance' => array(
				'collapseAll' => 0,
				'levelLinksPosition' => 'top',
				'showSynchronizationLink' => 1,
				'showPossibleLocalizationRecords' => 1,
				'showAllLocalizationLink' => 1
			),
		),
	),
);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_blsvsa2013_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_Blsvsa2013_Feusers','Tx_Blsvsa2013_Feusers');

$TCA['fe_users']['types']['Tx_Blsvsa2013_Feusers']['showitem'] = $TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser']['showitem'];
$TCA['fe_users']['types']['Tx_Blsvsa2013_Feusers']['showitem'] .= ',--div--;LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_feusers,';
$TCA['fe_users']['types']['Tx_Blsvsa2013_Feusers']['showitem'] .= 'schulnummer, schule, feuser';

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_leistungstabelle', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_leistungstabelle.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_leistungstabelle');
$TCA['tx_blsvsa2013_domain_model_leistungstabelle'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle',
		'label' => 'sportart',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'leistungbronze,leistungsilber,leistunggold,sportart,altersgruppe,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Leistungstabelle.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_leistungstabelle.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_sportarten', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_sportarten.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_sportarten');
$TCA['tx_blsvsa2013_domain_model_sportarten'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_sportarten',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,sportartgruppe,ergebnisart,reihenfolge,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Sportarten.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_sportarten.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_altersgruppen', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_altersgruppen.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_altersgruppen');
$TCA['tx_blsvsa2013_domain_model_altersgruppen'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_altersgruppen',
		'label' => 'bezeichnung',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'bezeichnung,geschlecht,altervon,alterbis,testtca,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Altersgruppen.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_altersgruppen.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_institutionsartart', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_institutionsartart.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_institutionsartart');
$TCA['tx_blsvsa2013_domain_model_institutionsartart'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_institutionsartart',
		'label' => 'institutionsart',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'institutionsart,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Institutionsartart.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_institutionsartart.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_schueler', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_schueler.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_schueler');
$TCA['tx_blsvsa2013_domain_model_schueler'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'vorname,name,geschlecht,geburtstag,klasse,grundschulwettbewerb,strasse,plz,ort,email,telefon,jahrderletztenpruefung,anzteilnahmen,schwimmnachweisgueltigbis,schule,schulnummer',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Schueler.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_schueler.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_artikel', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_artikel.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_artikel');
$TCA['tx_blsvsa2013_domain_model_artikel'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_artikel',
		'label' => 'artikel',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'artikelnummer,artikel,preis,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Artikel.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_artikel.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_bestellung', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_bestellung.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_bestellung');
$TCA['tx_blsvsa2013_domain_model_bestellung'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung',
		'label' => 'schule',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'anrede,institution,name,vorname,adresszusatz,strasse,plz,ort,abweichnedelieferadresse,lieferinstitution,liefername,liefervorname,lieferanrede,lieferstrasse,lieferplz,lieferort,schule,teilnahme,feuser,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Bestellung.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_bestellung.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_bestellposten', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_bestellposten.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_bestellposten');
$TCA['tx_blsvsa2013_domain_model_bestellposten'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellposten',
		'label' => 'artikel',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'anzahl,bestellung,artikel,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Bestellposten.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_bestellposten.gif'
	),
);
t3lib_extMgm::addLLrefForTCAdescr('tx_blsvsa2013_domain_model_klassen', 'EXT:blsvsa2013/Resources/Private/Language/locallang_csh_tx_blsvsa2013_domain_model_klassen.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_blsvsa2013_domain_model_klassen');
$TCA['tx_blsvsa2013_domain_model_klassen'] = array(
		'ctrl' => array(
				'title'	=> 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_klassen',
				'label' => 'klasse',
				'searchFields' => 'klasse,geschlecht,schulnummer,bestanden,nichtbestanden,alle,',
				'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Klassen.php',
				'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_blsvsa2013_domain_model_klassen.gif'
		),
);



?>