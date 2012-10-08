<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_blsvsa2013_domain_model_leistungstabelle'] = array(
	'ctrl' => $TCA['tx_blsvsa2013_domain_model_leistungstabelle']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sportart, altersgruppe, leistungbronze, leistungsilber, leistunggold',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,sportart, altersgruppe, leistungbronze, leistungsilber, leistunggold, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_blsvsa2013_domain_model_leistungstabelle',
				'foreign_table_where' => 'AND tx_blsvsa2013_domain_model_leistungstabelle.pid=###CURRENT_PID### AND tx_blsvsa2013_domain_model_leistungstabelle.sys_language_uid IN (-1,0)',
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
		'sportart' => array(
					'exclude' => 0,
					'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle.sportart',
					'config' => array(
							'type' => 'select',
							'foreign_table' => 'tx_blsvsa2013_domain_model_sportarten',
							'foreign_table_where' => 'ORDER BY tx_blsvsa2013_domain_model_sportarten.uid',
							'minitems' => 1,
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
			'altersgruppe' => array(
					'exclude' => 0,
					'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle.altersgruppe',
					'config' => array(
							'type' => 'select',
							'foreign_table' => 'tx_blsvsa2013_domain_model_altersgruppen',
							'minitems' => 1,
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
		'leistungbronze' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle.leistungbronze',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim'
			),
		),
		'leistungsilber' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle.leistungsilber',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim'
			),
		),
		'leistunggold' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:blsvsa2013/Resources/Private/Language/locallang_db.xml:tx_blsvsa2013_domain_model_leistungstabelle.leistunggold',
			'config' => array(
				'type' => 'input',
				'size' => 5,
				'eval' => 'trim'
			),
		),
	
	),
);

?>