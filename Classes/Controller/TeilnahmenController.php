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
class Tx_Blsvsa2013_Controller_TeilnahmenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * teilnahmenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository
	 */
	protected $teilnahmenRepository;
	
	
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
	 * feusersRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_FeusersRepository
	 */
	protected $feusersRepository;

	/**
	 * leistungstabelleRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository
	 */
	protected $leistungstabelleRepository;
	
	/**
	 * bezirke
	 *
	 * @var array
	 */
	protected $bezirke;
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feusers = $this->feusersRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		$this->schule = $this->feusers->getSchule();
		$userTSConfig_all = $GLOBALS["TSFE"]->fe_user->getUserTSconf();
		$this->bezirke =  $userTSConfig_all['tx_blsvsa2013.']['bezirk.'];
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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$teilnahmens = $this->teilnahmenRepository->findAll();
		$this->view->assign('teilnahmens', $teilnahmens);
	}

	/**
	 * action listklasse
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Klassen $klasse
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @return void
	 */
	public function listklasseAction(Tx_Blsvsa2013_Domain_Model_Klassen $klasse=null, Tx_Blsvsa2013_Domain_Model_Schulen $schule=null) {
		if ((null!=$schule) && ($this->bezirke)){
			$schulnummer = $schule->getSchulnummer();
		} else {
			$schulnummer = $this->schule->getSchulnummer();
		}		
		$teilnahmen = $this->teilnahmenRepository->findBySchulnummerOrKlasseSorted($schulnummer, $klasse);
		$this->view->assign('teilnahmen', $teilnahmen);
	}
	
	/**
	 * action listschule
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @return void
	 */
	public function listschuleAction(Tx_Blsvsa2013_Domain_Model_Schulen $schule=null) {
		if ((null!=$schule) && ($this->bezirke)){
			$schulnummer = $schule->getSchulnummer();
		} else {
			$schulnummer = $this->schule->getSchulnummer();
		}
	
		$klasse = null;
		$teilnahmen = $this->teilnahmenRepository->findBySchulnummerOrKlasseSorted($schulnummer, $klasse);
		$this->view->assign('teilnahmen', $teilnahmen);
	}
	
	
	/**
	 * action show
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen
	 * @return void
	 */
	public function showAction(Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen) {
		$this->view->assign('teilnahmen', $teilnahmen);
	}

	/**
	 * action new
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $newTeilnahmen
	 * @dontvalidate $newTeilnahmen
	 * @return void
	 */
	public function newAction( Tx_Blsvsa2013_Domain_Model_Teilnahmen $newTeilnahmen = NULL) {
		$this->view->assign('newTeilnahmen', $newTeilnahmen);
	}

	/**
	 * action create
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $newTeilnahmen
	 * @return void
	 */
	public function createAction( Tx_Blsvsa2013_Domain_Model_Teilnahmen $newTeilnahmen) {
		$this->teilnahmenRepository->add($newTeilnahmen);
		$this->flashMessageContainer->add('Your new Teilnahmen was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen
	 * @return void
	 */
	public function editAction( Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen) {
		$this->view->assign('teilnahmen', $teilnahmen);
	}

	/**
	 * action update
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen
	 * @return void
	 */
	public function updateAction( Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen) {
		$this->teilnahmenRepository->update($teilnahmen);
		$this->flashMessageContainer->add('');
		$this->redirect('list');
	}

	/**
	 * action updateklasse
	 *
	 * @param array  $teilnahmen
	 *
	 * @return void
	 */
	public function updateklasseAction( array $teilnahmen ) {
		foreach ( $teilnahmen as $uid => $arrTeilnahme ){
			$teilnahme = $this->teilnahmenRepository->findByUid( $uid );
			
			$teilnahme->setFeuser( $this->feusers);
			$teilnahme->setanzteilnahmen( $arrTeilnahme['anzteilnahmen'] );
			$teilnahme->setPunktegesamt( $arrTeilnahme['punktegesamt'] );			
			$teilnahme->setPruefungsjahr( date('Y') );			
				
			//$this->teilnahmenRepository->update($teilnahme);
						
		}
//		$this->flashMessageContainer->add('');
		$schule = $teilnahme->getSchule();
				
		$this->cacheService->clearPageCache();		
		$this->redirect('updateSchule', 'Schueler', Null, array('schule' => $schule));
	}
	
	/**
	 * action updateklasse
	 * 
	 * @param Tx_Blsvsa2013_Service_ErgebnisImport $objErgebnisImport
	 * @return void
	 */
	public function updateFromExcelAction(Tx_Blsvsa2013_Service_ErgebnisImport $objErgebnisImport ) {
/*		$arrImportInfo = $objErgebnisImport->importFromErgebnisListen($ergebnisListen, $this->teilnahmenRepository, $this->leistungstabelleRepository);
		t3lib_utility_debug::debug($arrImportInfo);
		
		exit;

		$objErgebnisImport = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_ErgebnisImport', $this->schule);
		$arrImportInfo = $objErgebnisImport->importFromErgebnisListen($ergebnisListen, $this->teilnahmenRepository, $this->leistungstabelleRepository);
		
		$this->flashMessageContainer->add('');
		
		t3lib_utility_debug::debug($arrImportInfo, 'arrImportInfo');
		
//		$this->redirect('list','Klassen');*/
	}
	
	
	/**
	 * action delete
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen
	 * @return void
	 */
	public function deleteAction( Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahmen) {
		$this->teilnahmenRepository->remove($teilnahmen);
		$this->flashMessageContainer->add('Your Teilnahmen was removed.');
		$this->redirect('list');
	}
}
?>