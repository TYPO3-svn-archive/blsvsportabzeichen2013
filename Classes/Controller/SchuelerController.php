<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Berti Golf <berti.golf@blsv.de>, BLSV
 *  Martin Gonschor <martin.gonschOr@blsv.de>, blsv
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package blsvsa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Controller_SchuelerController extends Tx_Extbase_MVC_Controller_ActionController {


	/**
	 * extension key
	 *
	 * @var string
	 */
	protected $extKey;
	
	/**
	 * extension path
	 *
	 * @var string
	 */
	protected $extPath;
	
	/**
	 * import class
	 *
	 * @var string
	 */
	protected $importClass;

	/**
	 * import class file
	 *
	 * @var string
	 */
	protected $importClassFile;
	
	/**
	 * schulnummer
	 *
	 * @var int
	 */
	protected $schule;
	
	/**
	 * feuser
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feuser
	 */
	protected $feuser;

	/**
	 * schulenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchulenRepository
	 */
	protected $schulenRepository;

	/**
	 * schuelerRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchuelerRepository
	 */
	protected $schuelerRepository;
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feuser = $this->feuserRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		$this->schule = $this->feuser->getSchule();
		
		$this->extKey = $this->request->getControllerExtensionKey();
		$this->extPath = t3lib_extMgm::extPath($this->extKey);

		$this->importClassFile = $this->extPath.'Classes/libs/class.importtext.php';
		$this->importClass = 'ImportText';
		
	}
	
	/**
	 * injectSchuelerRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $schuelerRepository
	 * @return void
	 */
	public function injectSchuelerRepository(Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $schuelerRepository) {
		$this->schuelerRepository = $schuelerRepository;
	}

	/**
	 * injectSchulenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository
	 * @return void
	 */
	public function injectSchulenRepository(Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository) {
		$this->schulenRepository = $schulenRepository;
	}
	
	/**
	 * injectFeuserRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository
	 * @return void
	 */
	public function injectFeuserRepository(Tx_Blsvsa2013_Domain_Repository_FeuserRepository $feuserRepository) {
		$this->feuserRepository = $feuserRepository;
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$schuelers = $this->schuelerRepository->findAll();
		$this->view->assign('schuelers', $schuelers);
	}

	/**
	 * action new
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $newSchueler
	 * @dontvalidate $newSchueler
	 * @return void
	 */
	public function newAction(Tx_Blsvsa2013_Domain_Model_Schueler $newSchueler = NULL) {
		if ($newSchueler == NULL) { // workaround for fluid bug ##5636
			$newSchueler = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Schueler');
		}
		$this->view->assign('newSchueler', $newSchueler);
	}

	/**
	 * action create
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $newSchueler
	 * @return void
	 */
	public function createAction(Tx_Blsvsa2013_Domain_Model_Schueler $newSchueler) {
		$this->schuelerRepository->add($newSchueler);
		$this->flashMessageContainer->add('Your new Schueler was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $schueler
	 * @return void
	 */
	public function editAction(Tx_Blsvsa2013_Domain_Model_Schueler $schueler) {
		$this->view->assign('schueler', $schueler);
	}

	/**
	 * action update
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $schueler
	 * @return void
	 */
	public function updateAction(Tx_Blsvsa2013_Domain_Model_Schueler $schueler) {
		$this->schuelerRepository->update($schueler);
		$this->flashMessageContainer->add('Your Schueler was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $schueler
	 * @return void
	 */
	public function deleteAction(Tx_Blsvsa2013_Domain_Model_Schueler $schueler) {
		$this->schuelerRepository->remove($schueler);
		$this->flashMessageContainer->add('Your Schueler was removed.');
		$this->redirect('list');
	}

	/**
	 * action import
	 * @param array $reqdata
	 * 
	 * @return void
	 */
	public function importAction($reqdata=null) {
		if(!empty($reqdata['schuelerstring'])){

			require_once($this->importClassFile);
			$import = t3lib_div::makeInstance($this->importClass, $this->extPath);
			$erg = $import->getSchuelerFromString($reqdata['schuelerstring'], $this->schule, $this->feuser, $schuelers, $errors);

			$importiert=0;
			$vorhanden=0;
			foreach($schuelers as $newSchueler){
				$erg2 = $this->schuelerRepository->addNew($newSchueler);
				if ($erg2==1) {
					$importiert++;
				} else {
					$vorhanden++;
				}
			}
		}
		
		$importInfo = array(
				'erg' => $erg,
				'importiert' => $importiert,
				'vorhanden' => $vorhanden,
				'errors' => $errors
		);
		
		$this->view->assign('importInfo', $importInfo);
	
//		t3lib_utility_Debug::debug($reqdata, 'request');
//		t3lib_utility_Debug::debug($importInfo, 'importInfo');
	}
	
	/**
	 * action export
	 *
	 * @return void
	 */
	public function exportAction() {
		$tplFile = $this->extPath.'Resources/Private/Templates/Schueler/sportabzeichen_neu.xls';
		$savFile = $this->extPath.'Classes/libs/export_'.date('His').'.xls';
		
		
		
		$ergebnisArray = $this->getErgebnisArray();
		require_once $this->extPath.'Classes/libs/class.lib_xls.php';
		$xls = t3lib_div::makeInstance('lib_xls');
		$xls->load($tplFile);
		$xls->fillTemplate($ergebnisArray);
		$xls->save($savFile);
exit;		
		
		

		
		
		
		
		
//		t3lib_utility_Debug::debug('export', 'export');
		

/*
$schuelers = $this->schuelerRepository->findAll();
foreach ($schuelers as $schueler){
	echo $schueler->getName();
}
exit;
*/		
		
		
		
		$files = array(
			'class.tx_lib_export_xls.php',
			'class.tx_blsvschulwettbewerb_export_xls_ergebnisse.php',
			'class.tx_lib_download.php',
		);
		
		$libPath = $this->extPath.'Classes/libs/';
		foreach ($files as $file) {
			require_once $libPath.$file;
		}

		$export_class = 'tx_blsvschulwettbewerb_export_xls_ergebnisse';
		$export = t3lib_div::makeInstance($export_class);
		
		
		$tmp_file = PATH_site . 'fileadmin/_temp_/export_'.$GLOBALS['schule'].'.xls';
//		$bitmap = 'fileadmin/images/head_ergebnisse.bmp';
		$bitmap = 'fileadmin/images/sa2013titel.bmp';
		$ergebnisArray = $this->getErgebnisArray();
		
		
		
		
//		echo 'ERg:<pre>';print_r($ergebnisArray);echo '</pre>';exit;
			
		$export->createNew($tmp_file, $bitmap, $ergebnisArray);

//		$export->create($daten, $opt);
		 
		$opt['ausgabe'] = $export->get_content();
		
		$opt['name'] = 'BLSV_SPORTABZEICHEN_'.date('Y').'_'.$GLOBALS['TSFE']->fe_user->user['username'];
		$opt['ext'] = 'xls';
//		mysql_close();
		// Export verschicken
//		require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/class.tx_lib_download.php");
		$download = t3lib_div::makeInstance('tx_lib_download');
		$download->send_data($opt['ausgabe'],$opt['name'],$opt['ext']);
		
	}
	
	
	function getErgebnisArray(){
		
/*		$schueler = array(
				'0' => array(
						'anz_teilnahmen' => '0',
						'uid' => '179',
						'name' => 'Mustermädchen',
						'vorname' => 'Martina',
						'geschlecht' => '2',
						'klasse' => '10a',
						'geburtstag' => '03.04.95',
				),
				'1' => array(
						'anz_teilnahmen' => '0',
						'uid' => '180',
						'name' => 'Mustermann',
						'vorname' => 'Martin',
						'geschlecht' => '1',
						'klasse' => '10b',
						'geburtstag' => '01.01.95',
				),
		);
*/
		
		$sql="select * from tx_blsvsa2013_domain_model_schueler";
		$result=mysql_query($sql);
		if (!$result)die ("DB Fehler beim Lesen ".mysql_error()."<br>".$sql);
		while( $h = mysql_fetch_array($result) ) {
			$schueler[] = $h;
		}
		
		$gruppen = array(
				'1' => array(
						'0' => array('saname' => 'Weit- sprung',		'mindLeistung' => '350', 'ml1' => '350', 'ml2' => '350', 'ml3' => '350',	'leistung' => '85',		'ergebnisart' => '3',),
						'1' => array('saname' => 'Hoch- sprung',		'mindLeistung' => '110', 'ml1' => '110', 'ml2' => '110', 'ml3' => '110',	'leistung' => '50',		'ergebnisart' => '3',),
						'2' => array('saname' => 'Bel. Sprunggerät seit. Grätsche/Hocke Geräte-höhe:',		'mindLeistung' => '120', 'ml1' => '120', 'ml2' => '120', 'ml3' => '120',	'leistung' => '130',	'ergebnisart' => '5',),
				),
				'2' => array(
						'0' => array('saname' => '75m Lauf',			'mindLeistung' => '125', 'ml1' => '125', 'ml2' => '125', 'ml3' => '125',	'leistung' => '562',	'ergebnisart' => '2',),
						'1' => array('saname' => '100m Lauf',			'mindLeistung' => '162', 'ml1' => '162', 'ml2' => '162', 'ml3' => '162',	'leistung' => '570',	'ergebnisart' => '2',),
						'2' => array('saname' => '300m Inline Skating',	'mindLeistung' => '47', 'ml1' => '47', 'ml2' => '47', 'ml3' => '47',	'leistung' => '346',	'ergebnisart' => '1',),
				),
				'3' => array(
						'0' => array('saname' => 'Kugel 4Kg',			'mindLeistung' => '550', 'ml1' => '550', 'ml2' => '550', 'ml3' => '550',	'leistung' => '146',	'ergebnisart' => '3',),
						'1' => array('saname' => 'Schlag- ball (80g)',	'mindLeistung' => '3200', 'ml1' => '3200', 'ml2' => '3200', 'ml3' => '3200',	'leistung' => '375',	'ergebnisart' => '3',),
						'2' => array('saname' => 'Wurf- ball 200 g',	'mindLeistung' => '2500', 'ml1' => '2500', 'ml2' => '2500', 'ml3' => '2500',	'leistung' => '393',	'ergebnisart' => '3',),
						'3' => array('saname' => 'Schleuder- ball (1kg)',	'mindLeistung' => '2500', 'ml1' => '2500', 'ml2' => '2500', 'ml3' => '2500',	'leistung' => '416',	'ergebnisart' => '3',),
						'4' => array('saname' => '100m Schwim- men',	'mindLeistung' => '135', 'ml1' => '135', 'ml2' => '135', 'ml3' => '135',	'leistung' => '450',	'ergebnisart' => '1',),
						'5' => array('saname' => 'Kombi. Reck: Aufschw. Unterschw. Boden Rad- wende',	'mindLeistung' => '1', 'ml1' => '1', 'ml2' => '1', 'ml3' => '1',	'leistung' => '658','ergebnisart' => '4'),
				),
				'4' => array(
						'0' => array('saname' => '800m Lauf',			'mindLeistung' => '270', 'ml1' => '270', 'ml2' => '270', 'ml3' => '270',	'leistung' => '185',	'ergebnisart' => '1',),
						'1' => array('saname' => '2.000m Lauf',		'mindLeistung' => '740', 'ml1' => '740', 'ml2' => '740', 'ml3' => '740',	'leistung' => '199',	'ergebnisart' => '1',),
						'2' => array('saname' => '3.000m Lauf',		'mindLeistung' => '1130', 'ml1' => '1130', 'ml2' => '1130', 'ml3' => '1130',	'leistung' => '216',	'ergebnisart' => '1',),
						'3' => array('saname' => '5.000m Inline Skating',	'mindLeistung' => '990', 'ml1' => '990', 'ml2' => '990', 'ml3' => '990',	'leistung' => '249',	'ergebnisart' => '1',),
						'4' => array('saname' => '20km Rad- fahren',	'mindLeistung' => '3600', 'ml1' => '3600', 'ml2' => '3600', 'ml3' => '3600',	'leistung' => '712',	'ergebnisart' => '1',),
						'5' => array('saname' => '600m Schwim- men',	'mindLeistung' => '1140', 'ml1' => '1140', 'ml2' => '1140', 'ml3' => '1140',	'leistung' => '481',	'ergebnisart' => '1',),
						'6' => array('saname' => '5km Skilang- lauf',	'mindLeistung' => '1800', 'ml1' => '1800', 'ml2' => '1800', 'ml3' => '1800',	'leistung' => '711',	'ergebnisart' => '1',),
				),
		);
		
		
		
		
		$erg = array(
			28 => array(
				'info' => array(
					'schulname' => 'Testschule',
					'schulnummer' => '9013',
					'altersgruppe' => 'weiblich 16/17 (Jahrgänge: 1995-1996)',
					'altersgruppe_kurz' => 'AG_17w',
				),
					
				'gruppen' => $gruppen,
				'schueler' => $schueler,
			), 
		);
		return $erg;
	}
}
?>