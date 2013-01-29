<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_blsvsa2013_domain_model_bestellung'] = array(
	'ctrl' => $TCA['tx_blsvsa2013_domain_model_bestellung']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, anrede, institution, name, vorname, adresszusatz, strasse, plz, ort, abweichnedelieferadresse, lieferinstitution, liefername, liefervorname, lieferanrede, lieferstrasse, lieferplz, lieferort, schule,status,erfassungsdatum, teilnahme, feuser,',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, anrede, institution, name, vorname, adresszusatz, strasse, plz, ort, abweichnedelieferadresse, lieferinstitution, liefername, liefervorname, lieferanrede, lieferstrasse, lieferplz, lieferort, schule, status, erfassungsdatum, teilnahme,feuser,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_blsvsa2013_domain_model_bestellung',
				'foreign_table_where' => 'AND tx_blsvsa2013_domain_model_bestellung.pid=###CURRENT_PID### AND tx_blsvsa2013_domain_model_bestellung.sys_language_uid IN (-1,0)',
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
		'anrede' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.anrede',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'institution' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.institution',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'vorname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.vorname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'adresszusatz' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.adresszusatz',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'strasse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.strasse',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'plz' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.plz',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'ort' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.ort',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'abweichnedelieferadresse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.abweichnedelieferadresse',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'lieferinstitution' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.lieferinstitution',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'liefername' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.liefername',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'liefervorname' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.liefervorname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lieferanrede' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.lieferanrede',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lieferstrasse' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.lieferstrasse',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lieferplz' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.lieferplz',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			),
		),
		'lieferort' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.lieferort',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'schule' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.schule',
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
		
			'erfassungsdatum' => array(
					'exclude' => 0,
					'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.erfassungsdatum',
					'config' => array(
							'type' => 'input',
							'size' => 5,
							'eval' => 'int,'
					),
			),
			
			'status' => array(
					'exclude' => 0,
					'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.status',
					'config' => array(
							'type' => 'input',
							'size' => 5,
							'eval' => 'int,'
					),
			),
				
			
			
		'teilnahme' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.teilnahme',
			'config' => array(
				'type' => 'select',
				'size' => 5,
				'multiple' => 1,	
				'foreign_table' => 'tx_blsvsa2013_domain_model_teilnahmen',
				'minitems' => 0,
				'maxitems' => 200,
			),
		),
		'feuser' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_bestellung.feuser',
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