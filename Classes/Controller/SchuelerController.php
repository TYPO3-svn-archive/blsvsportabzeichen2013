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
	 * Schule
	 *
	 * @var int
	 */
	protected $schule;
	
	/**
	 * feusers
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 */
	protected $feusers;
	
	
	/**
	 * Anzahl der zeilen bei Einzeleingbe für Schüler
	 *
	 * @var int
	 */
	protected $anzSchuelerEinzeleingabe=35;
	
	
	
	/**
	 * Pid der Ergebniseingabe
	 *
	 * @var int
	 */
	protected $pidErgebnisEingabe=23;

	/**
	 * Pid für Import
	 *
	 * @var int
	 */
	protected $pidSchuelerImport=0;

	/**
	 * bezirke
	 *
	 * @var array
	 */
	protected $bezirke;
	
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
	 * altersgruppenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository
	 */
	protected $altersgruppenRepository;

	/**
	 * leistungstabelleRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository
	 */
	protected $leistungtabelleRepository;

	/**
	 * teilnahmenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository
	 */
	protected $teilnahmenRepository;
	
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feusers = $this->feusersRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		$this->schule = $this->feusers->getSchule();
		
		$this->extKey = $this->request->getControllerExtensionKey();
		$this->extPath = t3lib_extMgm::extPath($this->extKey);

		$userTSConfig_all = $GLOBALS["TSFE"]->fe_user->getUserTSconf();
		$this->bezirke =  $userTSConfig_all['tx_blsvsa2013.']['bezirk.'];
		
		if ( $this->settings[anzSchuelerEinzeleingabe] > 0) $this->anzSchuelerEinzeleingabe = (int) $this->settings[anzSchuelerEinzeleingabe];
		if ( $this->settings[pidErgebnisEingabe] > 0) $this->pidErgebnisEingabe = (int) $this->settings[pidErgebnisEingabe];
		if ( $this->settings[pidSchuelerImport] > 0) $this->pidSchuelerImport = (int) $this->settings[pidSchuelerImport];
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
	 * injectAltersgruppenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository $altersgruppenRepository
	 * @return void
	 */
	public function injectAltersgruppenRepository(Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository $altersgruppenRepository) {
		$this->altersgruppenRepository = $altersgruppenRepository;
	}
	
	/**
	 * injectFeusersRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_FeusersRepository $feusersRepository
	 * @return void
	 */
	public function injectFeusersRepository(Tx_Blsvsa2013_Domain_Repository_FeusersRepository $feusersRepository) {
		$this->feusersRepository = $feusersRepository;
	}

	/**
	 * injectLeistungstabelleRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $leistungstabelleRepository
	 * @return void
	 */
	public function injectLeistungstabelleRepository(Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $leistungstabelleRepository) {
		$this->leistungstabelleRepository = $leistungstabelleRepository;
	}

	/**
	 * injectTeilnahmenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $teilnahmenRepository
	 * @return void
	 */
	public function injectTeilnahmenRepository(Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $teilnahmenRepository) {
		$this->teilnahmenRepository = $teilnahmenRepository;
	}
	
	/**
	 * action list
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Klassen $klasse
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @return void
	 */
	public function listAction(Tx_Blsvsa2013_Domain_Model_Klassen $klasse=null, Tx_Blsvsa2013_Domain_Model_Schulen $schule=null) {
		if ((null!=$schule) && ($this->bezirke)){
			$schulnummer = $schule->getSchulnummer();
		} else {
			$schulnummer = $this->schule->getSchulnummer();
		}
		
		// $schuelers = $this->schuelerRepository->findAll();
		$schuelers = $this->schuelerRepository->findBySchulnummerOrKlasseSorted($schulnummer, $klasse);
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
//		$this->flashMessageContainer->add('Your new Schueler was created.');
//		$this->redirect('list');
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
	 * @param array $einzeleingabe
	 * @return void
	 */
	public function importAction($reqdata=null, $einzeleingabe=null) {
		if ( $einzeleingabe ){
			$reqdata['schuelerstring'] = Tx_Blsvsa2013_Service_SchuelerImport::erstelleStrAusEinzeleingabe( $einzeleingabe );			
		}

		if ( $reqdata ){
			$objImport = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_SchuelerImport');
			$importInfo = $objImport->doImport($reqdata['schuelerstring'], $this->teilnahmenRepository, $this->feusers, $this->schule, $this->pidSchuelerImport);
//			t3lib_utility_Debug::debug($importInfo, 'importInfo'); return;

			$messages = array();
			$messages[] = $importInfo['message'];
			if ($importInfo['errors']){
				foreach($importInfo['errors'] as $fehlerinfo){
					$messages[] = $fehlerinfo['zeile'] . ': ' . implode(' / ', $fehlerinfo['fehler']);;
				}
			}
			foreach ($messages as $message){
				$this->flashMessageContainer->add($message);
			}

			$this->cacheService->clearPageCache();
			$this->redirect('updateSchule', 'Schueler', Null, Null, $this->pidErgebnisEingabe);
		}
		
		$geburtsjahre = Tx_Blsvsa2013_Service_Tools::erstelleLoopArray( 106, (date(Y)-110) );
		$schuelerAnzahl = Tx_Blsvsa2013_Service_Tools::erstelleLoopArray($this->settings[anzSchuelerEinzeleingabe],1);
		$this->view->assign( schueleranzahlArray, $schuelerAnzahl );
		$this->view->assign( geburtsjahreArray, $geburtsjahre );

		
//		t3lib_utility_Debug::debug($reqdata, 'request');
	}
	
	/**
	 * action export
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Klassen $klasse
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 */
	public function exportAction(Tx_Blsvsa2013_Domain_Model_Klassen $klasse=null, Tx_Blsvsa2013_Domain_Model_Schulen $schule=null) {

		// Schulnummer holen
		if ((null!=$schule) && ($this->bezirke)){
			$schulnummer = $schule->getSchulnummer();
		} else {
			$schulnummer = $this->schule->getSchulnummer();
		}
		
		// Konfiguration fuer Export
		$tplFile = $this->extPath.'Resources/Private/Templates/Schueler/template.xls';
		$tmpFile = PATH_site.'typo3temp/'.'blsvsa2013_export_'.$schulnummer.'_'.date('His').'.xls';
		$xlsFile = 'BLSV_SPORTABZEICHEN_'.date('Y').'_'.$GLOBALS['TSFE']->fe_user->user['username'].'.xls';
		
		// Teilnahmen holen
		$teilnahmen = $this->teilnahmenRepository->findBySchulnummerOrKlasseSorted($schulnummer, $klasse);			
		// Ergebnisse holen und fuer Export vorbereiten
		$objErg = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_Ergebnisse');
		$ergebnisArray = $objErg->getErgebnisArray($teilnahmen, $this->altersgruppenRepository, $this->leistungstabelleRepository);
//		t3lib_utility_debug::debug($ergebnisArray); exit;
		
		// Excel exportieren
		$objXlsTpl = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_XlsTplSa');
		$objXlsTpl->fillTemplateAndSend($ergebnisArray, $tplFile, $tmpFile, $xlsFile);
	}

	/**
	 * function importErgebnisListenAction
	 * 
	 * @param string $ergebnisListe
	 */
	public function importErgebnisListenAction($ergebnisListe=null) {
		$arrErgebnisListen[0] = $ergebnisListe;

		$objErgebnisImport = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_ErgebnisImport');
		$arrImportInfo = $objErgebnisImport->importFromErgebnisListen($arrErgebnisListen, $this->teilnahmenRepository, $this->leistungstabelleRepository);
//		t3lib_utility_debug::debug($message); t3lib_utility_debug::debug($arrImportInfo); return;
		
		$this->flashMessageContainer->add($arrImportInfo['message']);

		$this->cacheService->clearPageCache();
		$this->redirect('updateSchule');
	}

	/**
	 * ErgebnisExcel importieren
	 * 
	 * @param array $importErgebnisExcel
	 */
	public function importErgebnisExcelAction($ergebnisExcel=null) {
		$objXlsTpl = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_XlsTplSa');
		$arrErgebnisListen = $objXlsTpl->getCsvDataFromFile($ergebnisExcel['tmp_name']);

		$objErgebnisImport = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_ErgebnisImport');
		$arrImportInfo = $objErgebnisImport->importFromErgebnisListen($arrErgebnisListen, $this->teilnahmenRepository, $this->leistungstabelleRepository);
//		t3lib_utility_debug::debug($message); t3lib_utility_debug::debug($arrImportInfo); return;

		$this->flashMessageContainer->add($arrImportInfo['message']);

		$this->cacheService->clearPageCache();
		$this->redirect('updateSchule');
	}

	/**
	 * action updateSchuleAction
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @return void
	 */
	public function updateSchuleAction(Tx_Blsvsa2013_Domain_Model_Schulen $schule=null) {
		if ((null!=$schule) && ($this->bezirke)){
			$schule->setStatistik($this->schuelerRepository, $this->teilnahmenRepository);
			$this->redirect('editAdm','Schulen', Null, array('schulen' => $schule, 'active' => 3));
		} else {
			$this->schule->setStatistik($this->schuelerRepository, $this->teilnahmenRepository);
			$this->redirect('list','Klassen');
		}
	}

	/**
	 * action listFilterNameAction
	 * @param string $suchtext
	 * @return void
	 */
	public function listFilterNameAction( $suchtext ) {
	
		$schuelers = $this->schuelerRepository->findByName( $suchtext );
		$this->view->assign( schuelers, $schuelers );
	}
}