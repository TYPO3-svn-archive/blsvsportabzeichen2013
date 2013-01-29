<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_blsvsa2013_domain_model_teilnahmen'] = array(
	'ctrl' => $TCA['tx_blsvsa2013_domain_model_teilnahmen']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, vorname, name, geschlecht, geburtstag, anzteilnahmen, punktegesamt, urkundenart, gedruckt, drucktstamp, klasse, grundschulwettbewerb, schwimmnachweisgueltigbis, leistungstabelle1, ablagedatum1, pruefer1, ergebnis1, punkte1, leistungstabelle2, ablagedatum2, pruefer2, ergebnis2, punkte2, leistungstabelle3, ablagedatum3, pruefer3, ergebnis3, punkte3, leistungstabelle4, ablagedatum4, pruefer4, ergebnis4, punkte4, pruefungsjahr, schule, leistung1, leistung2, leistung3, leistung4, feuser, schueler, bestellung',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, vorname, name, geschlecht, geburtstag, anzteilnahmen, punktegesamt, urkundenart, gedruckt, drucktstamp, klasse, grundschulwettbewerb, schwimmnachweisgueltigbis, leistungstabelle1, ablagedatum1, pruefer1, ergebnis1, punkte1, leistungstabelle2, ablagedatum2, pruefer2, ergebnis2, punkte2, leistungstabelle3, ablagedatum3, pruefer3, ergebnis3, punkte3, leistungstabelle4, ablagedatum4, pruefer4, ergebnis4, punkte4, pruefungsjahr, schule, leistung1, leistung2, leistung3, leistung4, feuser, schueler, bestellung,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_blsvsa2013_domain_model_teilnahmen',
				'foreign_table_where' => 'AND tx_blsvsa2013_domain_model_teilnahmen.pid=###CURRENT_PID### AND tx_blsvsa2013_domain_model_teilnahmen.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.vorname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'geschlecht' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.geschlecht',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'geburtstag' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.geburtstag',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'anzteilnahmen' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.anzteilnahmen',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'punktegesamt' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.punktegesamt',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'urkundenart' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.urkundenart',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'gedruckt' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.gedruckt',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'drucktstamp' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.drucktstamp',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'klasse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.klasse',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'grundschulwettbewerb' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.grundschulwettbewerb',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'schwimmnachweisgueltigbis' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.schwimmnachweisgueltigbis',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'leistung1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistung1',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ablagedatum1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ablagedatum1',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'pruefer1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.pruefer1',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ergebnis1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ergebnis1',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'punkte1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.punkte1',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'leistung2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistungs2',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ablagedatum2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ablagedatum2',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'pruefer2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.pruefer2',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ergebnis2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ergebnis2',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'punkte2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.punkte2',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'leistung3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistung3',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ablagedatum3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ablagedatum3',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'pruefer3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.pruefer3',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ergebnis3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ergebnis3',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'punkte3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.punkte3',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'leistung4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistung4',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ablagedatum4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ablagedatum4',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'pruefer4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.pruefer4',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'ergebnis4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.ergebnis4',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'punkte4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.punkte4',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'pruefungsjahr' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.pruefungsjahr',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'schule' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.schule',
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
		'leistungstabelle1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistungstabelle1',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blsvsa2013_domain_model_leistungstabelle',
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
		'leistungstabelle2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistungstabelle2',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blsvsa2013_domain_model_leistungstabelle',
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
		'leistungstabelle3' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistungstabelle3',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blsvsa2013_domain_model_leistungstabelle',
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
		'leistungstabelle4' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.leistungstabelle4',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blsvsa2013_domain_model_leistungstabelle',
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
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.feuser',
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
		'schueler' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.schueler',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_blsvsa2013_domain_model_schueler',
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
		'bestellung' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_teilnahmen.bestellung',
				'config' => array(
						'type' => 'select',
						'foreign_table' => 'tx_blsvsa2013_domain_model_bestellung',
						'minitems' => 0,
						'maxitems' => 1,
				),
		),
	),
);

?>