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
class Tx_Blsvsa2013_Controller_SchulenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * Anzahl der zeilen bei Einzeleingbe für Schüler
	 *
	 * @var int
	 */
	protected $anzSchulenSchuelerEinzeleingabe=35;
	
	/**
	 * schulnummer
	 *
	 * @var int
	 */
	protected $schulnummer;
	
	/**  
	 * feuser
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers 
	 */
	protected $feuser;
	
	/**
	 * schulenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchulenRepository
	 */
	protected $schulenRepository;

	/**
	 * klassenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_KlassenRepository
	 */
	protected $klassenRepository;
	
	/**
	* feusersRepository
	*
	* @var Tx_Blsvsa2013_Domain_Repository_FeusersRepository
	*/
	protected $feusersRepository;

	/**
	 * urkundenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_UrkundenRepository
	 */
	protected $urkundenRepository;

	/**
	 * teilnahmenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository
	 */
	protected $teilnahmenRepository;

	/**
	 * Pid für Import
	 *
	 * @var int
	 */
	protected $pidSchulenSchuelerImport=0;

	/**
	 * PID des Containers für die Klassenübersicht
	 *
	 * @var int
	 */
	protected $pidSchulenAjaxContainerKlassenuebersicht=35;
	
	/**
	 * bezirke
	 *
	 * @var array
	 */
	protected $bezirke;
	
	/**
	 * urkunden Auswahl
	 * 
	 * @var string
	 */
	protected $urkundenAuswahl;
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feuser = $this->feusersRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		if (!$this->feuser) throw new \Tx_Blsvsa2013_Exception_Error('Angemeldeter User kann nicht ermittelt werden N° = ' . $GLOBALS['TSFE']->fe_user->user['uid'] , 1349880193 );
		$this->schulnummer = $GLOBALS['TSFE']->fe_user->user['schulnummer']; 

		$userTSConfig_all = $GLOBALS["TSFE"]->fe_user->getUserTSconf();
		$this->bezirke =  $userTSConfig_all['tx_blsvsa2013.']['bezirk.'];
		
		$this->urkundenAuswahl = isset($this->settings['urkundenAuswahl']) ? $this->settings['urkundenAuswahl'] : '';
		
		if ( $this->settings[anzSchulenSchuelerEinzeleingabe] > 0) $this->anzSchulenSchuelerEinzeleingabe = (int) $this->settings[anzSchulenSchuelerEinzeleingabe];
		if ( $this->settings[pidSchulenSchuelerImport] > 0) $this->pidSchulenSchuelerImport = (int) $this->settings[pidSchulenSchuelerImport];
		if ( $this->settings[pidSchulenAjaxContainerKlassenuebersicht] > 0) $this->pidSchulenAjaxContainerKlassenuebersicht = (int) $this->settings[pidSchulenAjaxContainerKlassenuebersicht];
	}
	
	
	/**
	 * injectKlassenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_KlassenRepository $klassenRepository
	 * @return void
	 */
	public function injectKlassenRepository(Tx_Blsvsa2013_Domain_Repository_KlassenRepository $klassenRepository) {
		$this->klassenRepository = $klassenRepository;
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
	 * injectfeusersRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository
	 * @return void
	 */
	public function injectfeusersRepository(Tx_Blsvsa2013_Domain_Repository_FeusersRepository $feusersRepository) {
		$this->feusersRepository = $feusersRepository;
	}

	/**
	 * injectUrkundenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_UrkundenRepository $urkundenRepository
	 * @return void
	 */
	public function injectUrkundenRepository(Tx_Blsvsa2013_Domain_Repository_UrkundenRepository $urkundenRepository) {
		$this->urkundenRepository = $urkundenRepository;
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
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @return void
	 */
	public function editAction(Tx_Blsvsa2013_Domain_Model_Schulen $schulen=Null) {
		$schulen = $this->schulenRepository->findOneBySchulnummer( $this->schulnummer);
		if (!$schulen) throw new \Exception(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.1350026965', $this->extensionName)  . $this->schulnummer   , 1350026965 );		
		
		$this->view->assign( 'schulen', $schulen );
		
	}

	/**
	 * action update
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @dontvalidate
	 * @return void
	 */
	public function updateAction(Tx_Blsvsa2013_Domain_Model_Schulen $schulen) {
		
		$schulen->setFeuser( $this->feuser );
		if( $schulen->getSchulnummer()<>$this->schulnummer) {
			throw new \Exception('Die Schulnummer stimmt nicht mit der Schulnummer des agemeldeten Users überein!' , 1350027838 );
		}
		
		$this->schulenRepository->update($schulen);
		if (!($schulen->isGrundschulen() or $schulen->isSchulwettbewerb())){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.keinwettbwerbangegeben', $this->extensionName) );
		}
		
		$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.angabengespeichert', $this->extensionName) );
		$this->redirect('edit');
	}

	/**
	 * action listAdm
	 * 
	 * @return void
	 */
	public function listAdmAction() {
//		t3lib_utility_debug::debug($this->request->getArguments(), 'Request');
//		t3lib_utility_debug::debug($this->bezirke, 'bezirke');

		$bezirk = $this->getBezirk();
		
		$args = $this->request->getArguments();
		if ($args['suchtext']) { $suchtext = $args['suchtext'];	}
		if ($args['filter']) { $filter = $args['filter'];	}
		
		$schulen = $this->schulenRepository->findByAdmSearch($this->bezirke, $filter, $suchtext);
		
		$this->view->assign('schulen', $schulen);
		$this->view->assign('suchtext', $suchtext);
		$this->view->assign('filter', $filter);
	}

	/**
	 * action editAdm
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @param number $active
	 * @return void
	 */
	public function editAdmAction(Tx_Blsvsa2013_Domain_Model_Schulen $schulen=Null, $active=0) {
		// t3lib_utility_debug::debug($schulen->getUid(), 'Schulen');
		// Schuldaten
		$this->view->assign( 'schulen', $schulen );

		// Einzeleingabe
		$geburtsjahre = Tx_Blsvsa2013_Service_Tools::erstelleLoopArray( 106, (date(Y)-110) );
		$schuelerAnzahl = Tx_Blsvsa2013_Service_Tools::erstelleLoopArray($this->anzSchulenSchuelerEinzeleingabe,1);
		$this->view->assign('schueleranzahlArray', $schuelerAnzahl);
		$this->view->assign('geburtsjahreArray', $geburtsjahre);
		
		// Klassenübersicht
		$ctrlKlassen = t3lib_div::makeInstance('Tx_Blsvsa2013_Controller_KlassenController');
		$klassen = $this->klassenRepository->findBySchulnummer( $schulen->getSchulnummer() );
		$schulsumme = $ctrlKlassen->getSchulsumme($klassen);
		$schulen = array('alle'=>0,'bestanden'=> 0,'nichtbestanden' => 0);
		$this->view->assign('klassen', $klassen);
		$this->view->assign('schulsumme', $schulsumme);
		$this->view->assign('pidKlasse', $this->pidSchulenAjaxContainerKlassenuebersicht);
		$this->view->assign('active', $active);
	}

	/**
	 * action updateAdm
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @return void
	 */
	public function updateAdmAction(Tx_Blsvsa2013_Domain_Model_Schulen $schulen) {
	
		$this->schulenRepository->update($schulen);
		if (!($schulen->isGrundschulen() or $schulen->isSchulwettbewerb())){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.keinwettbwerbangegeben', $this->extensionName) );
		}
	
		$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.angabengespeichert', $this->extensionName) );
		$this->redirect('editAdm', 'Schulen', Null, array('schulen'=>$schulen, 'active'=>0));
	}

	
	/**
	 * action listAdm
	 *
	 * @return void
	 */
	public function listUrkundenAction() {
		$bezirk = $this->getBezirk();
		
		$info = $this->urkundenRepository->getStatistik($bezirk);
		$schulenUrkunden = $this->urkundenRepository->findByBezirk($bezirk, $this->urkundenAuswahl);
		$this->view->assign('info', $info);
		$this->view->assign('schulenUrkunden', $schulenUrkunden);

//		t3lib_utility_debug::debug($this->request->getArguments(), 'Request');
//		t3lib_utility_debug::debug($this->bezirke, 'bezirke');
	}

	/**
	 * action printUrkunden
	 * 
	 */
	public function printUrkundenAction() {
		$bezirk = $this->getBezirk();
				
		$opt = array();
		$daten = array();
		
		$opt['name'] = 'urkunden_druck';
		
		$schule = $this->request->getArgument('schule');
		$daten['tabelle'] = $this->urkundenRepository->findByBezirkAndSchule($bezirk, $schule['schule_uid'], $schule['status']);
		$pdfUrkunden = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_PdfUrkunden');
		$pdfUrkunden->create($daten, $opt);
		exit;
	}
	
	/**
	 * action printPackliste
	 *
	 * @return void
	 */
	public function printPacklisteAction() {
		$bezirk = $this->getBezirk();
		$opt = array();
		$daten = array();

		$opt['inhalte'] = 'packliste';
		$opt['name'] = 'urkunden_packliste';
		
		$schule = $this->request->getArgument('schule');
		$daten['tabelle'] = $this->urkundenRepository->findByBezirkAndSchule($bezirk, $schule['uid'], $schule['status']);
		$pdfUrkunden = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_PdfUrkunden');
		$pdfUrkunden->create($daten, $opt);
		exit;
	}
	
	/**
	 * action showUrkunden
	 *
	 * @return void
	 */
	public function showUrkundenAction() {
		$bezirk = $this->getBezirk();
		$opt = array();
		$daten = array();
		
		$opt['bild'] = PATH_typo3conf . 'ext/blsvsa2013/Resources/Private/Layouts/urkunde.jpg';
		$opt['name'] = 'urkunden_ansicht';
		
		$schule = $this->request->getArgument('schule');
		$daten['tabelle'] = $this->urkundenRepository->findByBezirkAndSchule($bezirk, $schule['uid'], $schule['status']);
		$pdfUrkunden = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_PdfUrkunden');
		$pdfUrkunden->create($daten, $opt);
		exit;
	}
	
	/**
	 * action confirmUrkunden
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @return void
	 */
	public function confirmUrkundenAction() {
		$bezirk = $this->getBezirk();
		$schule = $this->request->getArgument('schule');
		$this->urkundenRepository->confirmByBezirkAndSchule($bezirk, $schule['uid'], $schule['status'], true);
		$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_urkunden_confirmation', $this->extensionName) );
		$this->redirect('listUrkunden');
	}

	/**
	 * action importSchueler
	 * 
	 * @param array $reqdata
	 * @param array $einzeleingabe
	 * @return void
	 */
	public function importSchuelerAction($reqdata=null, $einzeleingabe=null) {
		$active = 2;
		if ( $einzeleingabe ){
			$reqdata['schuelerstring'] = Tx_Blsvsa2013_Service_SchuelerImport::erstelleStrAusEinzeleingabe( $einzeleingabe );
			$reqdata['schulnummer'] = $einzeleingabe['schulnummer'];
			$active = 1;
		}

		if ( $reqdata ){
			$objSchule = $this->schulenRepository->findOneBySchulnummer($reqdata['schulnummer']);		
			$objImport = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_SchuelerImport');
			$importInfo = $objImport->doImport($reqdata['schuelerstring'], $this->teilnahmenRepository, $this->feuser, $objSchule, $this->pidSchulenSchuelerImport);
			
//			t3lib_utility_Debug::debug($importInfo, 'importInfo');
			
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
			$this->redirect('editAdm', 'Schulen', Null, array('schulen'=>$objSchule, 'active'=>$active));
		}
	}
	
	/**
	 * action fehler
	 *
	 * @return void
	 */
	public function fehlerAction() {
	
	}

	/**
	 * Bezirk holen
	 * 
	 * @return integer $bezirk
	 */
	private function getBezirk(){
		if (!$this->bezirke){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate( 'tx_blsvsa2013_controller_schulen.keinBezirkZugeordnet' , $this->extensionName )  );
			$this->redirect('fehler');
		} else {
			$bezirk = current($this->bezirke);
		}
		return $bezirk;
	}
}
?>