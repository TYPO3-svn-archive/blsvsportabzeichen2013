<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_blsvsa2013_domain_model_schueler'] = array(
	'ctrl' => $TCA['tx_blsvsa2013_domain_model_schueler']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, vorname, name, geschlecht, geburtstag, klasse, grundschulwettbewerb, strasse, plz, ort, email, telefon, jahrderletztenpruefung, anzteilnahmen, schwimmnachweisgueltigbis, schule,schulnummer, feuser',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, vorname, name, geschlecht, geburtstag, klasse, grundschulwettbewerb, strasse, plz, ort, email, telefon, jahrderletztenpruefung, anzteilnahmen, schwimmnachweisgueltigbis, schule,schulnummer,feuser,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_blsvsa2013_domain_model_schueler',
				'foreign_table_where' => 'AND tx_blsvsa2013_domain_model_schueler.pid=###CURRENT_PID### AND tx_blsvsa2013_domain_model_schueler.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'vorname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.vorname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'geschlecht' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.geschlecht',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'geburtstag' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.geburtstag',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'klasse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.klasse',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'grundschulwettbewerb' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.grundschulwettbewerb',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'strasse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.strasse',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'plz' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.plz',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'ort' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.ort',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'telefon' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.telefon',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'jahrderletztenpruefung' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.jahrderletztenpruefung',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'anzteilnahmen' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.anzteilnahmen',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'schwimmnachweisgueltigbis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.schwimmnachweisgueltigbis',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'schule' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.schule',
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
			
		'schulnummer' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.schulnummer',
			'config' => array(
					'type' => 'input',
					'size' => 10,
					'eval' => 'trim'
			),
		),
		'feuser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_schueler.feuser',
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
	),
);

?>