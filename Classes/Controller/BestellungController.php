<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Berti Golf <berti.golf@blsv.de>, BLSV
 *  Martin Gonschor <martin.gonschor@blsv.de>, blsv
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
class Tx_Blsvsa2013_Controller_BestellungController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * bestellungRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_BestellungRepository
	 */
	protected $bestellungRepository;

	/**
	 * bestellpostenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_BestellpostenRepository
	 */
	protected $bestellpostenRepository;

	/**
	 * teilnahmenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_TeilnamenRepository
	 */
	protected $teilnahmenRepository;

	/**
	 * schuelerRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchuelerRepository
	 */
	protected $schuelerRepository;
	
	/**
	 * artikelRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_ArtikelRepository
	 */
	protected $artikelRepository;
	
	/**
	 * schulenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchulenRepository
	 */
	protected $schulenRepository;

	/**
	 * urkundenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_UrkundenRepository
	 */
	protected $urkundenRepository;
	
	/**
	 * bezirke
	 *
	 * @var array
	 */
	protected $bezirke;
	
	/**
	 * Pid Auf der Die Namensuche insatllliert ist
	 *
	 * @var integer
	 */
	protected $pidNamenssuche = 0;

	/**
	 * Pid fuer Bestellungen
	 *
	 * @var integer
	 */
	protected $pidBestellungen = 0;

	/**
	 * Pid fuer Bestellposten
	 *
	 * @var integer
	 */
	protected $pidBestellposten = 0;
	
	/**
	 * Pid fuer Teilnahmen
	 *
	 * @var integer
	 */
	protected $pidTeilnahmen = 0;

	/**
	 * Pid fuer Teilnahmen
	 *
	 * @var integer
	 */
	protected $pidSchulen = 0;
	
	
	/**
	 * Pid fuer neue Teilnehmer
	 *
	 * @var integer
	 */
	protected $pidTeilnehmerNeu = 0;
	
	/**
	 * feusers
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 */

	protected $feusers;
	
	/**
	 * feueserRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_FeusersRepository
	 */
	protected $feusersRepository;
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feusers = $this->feusersRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;		
		$userTSConfig_all = $GLOBALS["TSFE"]->fe_user->getUserTSconf();
		$this->bezirke =  $userTSConfig_all['tx_blsvsa2013.']['bezirk.'];	 
		if ( $this->settings[ 'pidbestellungNamenssuche' ] > 0) $this->pidNamenssuche = (int) $this->settings['pidbestellungNamenssuche'];
		if ( $this->settings[ 'pidBestellungBestellung' ] > 0) $this->pidBestellung = (int) $this->settings['pidBestellungBestellung'];
		if ( $this->settings[ 'pidBestellungBestellposten' ] > 0) $this->pidBestellposten = (int) $this->settings['pidBestellungBestellposten'];
		if ( $this->settings[ 'pidBestellungTeilnahmen' ] > 0) $this->pidTeilnahmen = (int) $this->settings['pidBestellungTeilnahmen'];
		if ( $this->settings[ 'pidBestellungSchulen' ] > 0) $this->pidSchulen = (int) $this->settings['pidBestellungSchulen'];
		if ( $this->settings[ 'pidBestellungTeilnehmerNeu' ] > 0) $this->pidTeilnehmerNeu = (int) $this->settings['pidBestellungTeilnehmerNeu'];
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
	 * injectBestellungRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_BestellungRepository $bestellungRepository
	 * @return void
	 */
	public function injectBestellungRepository(Tx_Blsvsa2013_Domain_Repository_BestellungRepository $bestellungRepository) {
		$this->bestellungRepository = $bestellungRepository;
	}
	
	/**
	 * injectBestellpostenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_BestellpostenRepository $bestellpostenRepository
	 * @return void
	 */
	public function injectBestellpostenRepository(Tx_Blsvsa2013_Domain_Repository_BestellpostenRepository $bestellpostenRepository) {
		$this->bestellpostenRepository = $bestellpostenRepository;
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
	 * injectArtikelRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_ArtikelRepository $schulenRepository
	 * @return void
	 */
	public function injectArtikelRepository(Tx_Blsvsa2013_Domain_Repository_ArtikelRepository $artikelRepository) {
		$this->artikelRepository = $artikelRepository;
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
	 * action list
	 * @param array $filter
	 * @return void
	 */
	public function listAction( array $filter = NULL) {
		$classloader = new Tx_ExtensionBuilder_Utility_ClassLoader;
		$bestellungen = $this->bestellungRepository->findAll();
		$this->view->assign('bestellungen', $bestellungen);
		
		if (!$this->bezirke){
			
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate( 'tx_blsvsa2013_controller_bestellung.keinBezirkZugeordnet' , $this->extensionName )  );
			$this->redirect('fehler');
		}
		
			$this->view->assign('bezirk', current($this->bezirke ) );		
	}

	/**
	 * action show
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return void
	 */
	public function showAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$schule = $bestellung->getSchule();
		$teilnahmen = $this->teilnahmenRepository->findByBestellung($bestellung);
		$bestellpostens = $this->bestellpostenRepository->findByBestellung($bestellung);
		
		$this->view->assign('bestellung', $bestellung);
		$this->view->assign('schule', $schule );
		$this->view->assign('teilnahmen', $teilnahmen);
		$this->view->assign('bestellpostens', $bestellpostens );
		$this->view->assign('newBestellung', $newBestellung );
		$this->view->assign('punktegesamtOptions', Tx_Blsvsa2013_Domain_Service_PunktegesamtOptionsService::getOptions());
		$this->view->assign('pidNamenssuche', $this->pidNamenssuche);
		$this->view->assign('pidTeilnehmerNeu', $this->pidTeilnehmerNeu);
		
	}

	/**
	 * action new
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $newBestellung
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @dontvalidate $newBestellung
	 * @return void
	 */
	public function newAction( Tx_Blsvsa2013_Domain_Model_Bestellung $newBestellung = NULL, Tx_Blsvsa2013_Domain_Model_Schulen $schule = NULL) {
		if ( $newBestellung == NULL ) { // workaround for fluid bug ##5636
			$newBestellung = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Bestellung');
		}

		$artikels = $this->artikelRepository->findall();
		foreach ( $artikels as $artikel){
			$newBestellposten = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Bestellposten');
			$newBestellposten->setArtikel( $artikel );
			$bestellpostens[] = $newBestellposten;
		}
				
		$this->view->assign( 'bestellpostens', $bestellpostens );
		$this->view->assign( 'schule', $schule );
		$this->view->assign( 'newBestellung', $newBestellung );
		$this->view->assign( 'pidNamenssuche', $this->pidNamenssuche);
		$this->view->assign( 'pidTeilnehmerNeu', $this->pidTeilnehmerNeu);
	}
	
	/**
	 * action debitorwahl
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $newSchule
	 * @param array $debitorwahl	
	 * @dontvalidate $newSchule
	 * @return void
	 */
	public function debitorwahlAction( Tx_Blsvsa2013_Domain_Model_Schulen $newSchule = NULL, $debitorwahl = NULL ) {
		// t3lib_utility_debug::debug($debitorwahl);
		// t3lib_utility_debug::debug($_REQUEST);
		
		if (!$this->bezirke){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate( 'tx_blsvsa2013_controller_bestellung.keinBezirkZugeordnet', $this->extensionName ) );
			$this->redirect('fehler');
		}
		
		If ($debitorwahl == NULL ){
			$debitorwahl[ 'debitorsuche' ]	=	'';
			$debitorwahl[ 'institutionen' ]	= 	0;
			$debitorwahl[ 'bezirk ']		=	current($this->bezirke );
		}
		
		$schulen =	$this->schulenRepository->findDebitor( $debitorwahl );

		if ($newSchule == NULL) { // workaround for fluid bug ##5636
			$newSchule = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Schulen');
			$newSchule->setBezirk($debitorwahl['bezirk']);
			if ($debitorwahl['institutionen']>0) {
				$newSchule->setSchulart($debitorwahl['institutionen']);
			} else {
				$newSchule->setSchulart(6);
			}
//!!!			$newSchule->setPid();
		}

		
		$this->view->assign( 'debitorwahl', $debitorwahl );
		$this->view->assign( 'newSchule', $newSchule );
		$this->view->assign( 'schulen', $schulen );
		$this->view->assign( 'bezirk', current( $this->bezirke ) );

		$this->view->assign( 'bezirkeOptions', Tx_Blsvsa2013_Domain_Service_BezirkeOptionsService::getOptions());
		$this->view->assign( 'institutionenOptions', Tx_Blsvsa2013_Domain_Service_InstitutionenOptionsService::getOptions());
	}	
	
	
	/**
	 * action create 
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $newBestellung
	 * @param array $bestellposten
	 * @param integer $institution
	 * @return void
	 */
	public function createAction(Tx_Blsvsa2013_Domain_Model_Bestellung $newBestellung, array $bestellposten = NULL, $institution=NULL) {
		$objSchule = $this->schulenRepository->findOneByUid((int)$institution);
		if (!$objSchule) {
			$this->errorFind('errorFindSchule', (int)$institution);
		}
		
		if($_REQUEST['teilnahmen']){
			$arrTeilnahmen = $_REQUEST['teilnahmen'];
		} else {
			$arrTeilnahmen = array();
		}
		
		if($this->request->hasArgument('bestellposten')){
			$arrBestellpostens = $this->request->getArgument('bestellposten');
		} else {
			$error = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_bestellung.errorNoBestellposten', 'blsvsa2013');
			throw new \Exception( $error, 1359030216 );
		}
		
		// Bestellung anlegen
		$newBestellung->setSchule($objSchule);
		$newBestellung->setInstitution($objSchule->getName());
		$newBestellung->setStatus(1); // Bestellung erstellt
		
		$newBestellung->setErfassungsdatum(time());
		$newBestellung->setFeuser($this->feusers);
		$newBestellung->setPid($this->pidBestellung);
		
		$this->bestellungRepository->add($newBestellung);
		$info['teilnahmen'] = $this->teilnahmenRepository->insupdByTeilnahmen($newBestellung, $arrTeilnahmen, $this->schuelerRepository, $this->feusers, $this->pidTeilnahmen);
		$info['bestellposten'] = $this->bestellpostenRepository->insupdByBestellposten($newBestellung, $arrBestellpostens, $this->artikelRepository, $this->pidBestellposten);

//		t3lib_utility_debug::debug($info); exit;

		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_controller_bestellung.created', $this->extensionName));
		$this->redirect('show', NULL, NULL, array('bestellung' => $newBestellung));
	}

	/**
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return void
	 */
	public function editAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$this->checkStatus($bestellung);
		
		$schule = $bestellung->getSchule();
		$teilnahmen = $this->teilnahmenRepository->findByBestellung($bestellung);
		$bestellpostens = $this->bestellpostenRepository->findByBestellung($bestellung);
		
		$this->view->assign('bestellung', $bestellung);
		$this->view->assign('schule', $schule );
		$this->view->assign('teilnahmen', $teilnahmen);
		$this->view->assign('bestellpostens', $bestellpostens );
		$this->view->assign('newBestellung', $newBestellung );
		$this->view->assign('punktegesamtOptions', Tx_Blsvsa2013_Domain_Service_PunktegesamtOptionsService::getOptions());
		$this->view->assign('pidNamenssuche', $this->pidNamenssuche);
		$this->view->assign('pidTeilnehmerNeu', $this->pidTeilnehmerNeu);
	}

	/**
	 * action update
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return void
	 */
	public function updateAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$this->checkStatus($bestellung);
		
		if($_REQUEST['teilnahmen']){
			$arrTeilnahmen = $_REQUEST['teilnahmen'];
		} else {
			$arrTeilnahmen = array();
		}
		
		if($this->request->hasArgument('bestellposten')){
			$arrBestellpostens = $this->request->getArgument('bestellposten');
		} else {
			$error = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_bestellung.errorNoBestellposten', 'blsvsa2013');
			throw new \Exception( $error, 1359030216 );
		}

		$this->bestellungRepository->update($bestellung);
		$info['teilnahmen'] = $this->teilnahmenRepository->insupdByTeilnahmen($bestellung, $arrTeilnahmen, $this->schuelerRepository, $this->feusers, $this->pidTeilnahmen);
		$info['bestellposten'] = $this->bestellpostenRepository->insupdByBestellposten($bestellung, $arrBestellpostens, $this->artikelRepository, $this->pidBestellposten);

		// t3lib_utility_debug::debug($info); exit;
		
		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_controller_bestellung.updated', $this->extensionName));
		$this->redirect('show', NULL, NULL, array('bestellung' => $bestellung));
	}

	/**
	 * action delete
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return void
	 */
	public function deleteAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$this->bestellungRepository->remove($bestellung);
		$this->flashMessageContainer->add('Your Bestellung was removed.');
		$this->redirect('list');
	}
	

	/**
	 * action fehler
	 *
	 * @return void
	 */
	public function fehlerAction() {
		
	}
	
	/**
	 * action createInDebitor
	 * 
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $newSchule
	 */
	public function createInDebitorAction(Tx_Blsvsa2013_Domain_Model_Schulen $newSchule=Null) {
		// t3lib_utility_debug::debug($_REQUEST); exit;
		// t3lib_utility_debug::debug($newSchule); exit;

		$this->schulenRepository->add($newSchule);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');

		$persistenceManager->persistAll();

		$uid = $newSchule->getUid();
		
		if ($uid){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate( 'tx_blsvsa2013_controller_bestellung.debitorAngelegt' , $this->extensionName )  );
		}
		$this->redirect('debitorwahl', Null, Null, array('debitorwahl' => array('debitorsuche'=>$uid)));
	}

	/**
	 * action newTeilnehmer
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $newTeilnehmer
	 * #@dontvalidate $newTeilnehmer
	 * @return void
	 */
	public function newTeilnehmerAction(Tx_Blsvsa2013_Domain_Model_Schueler $newTeilnehmer = NULL ) {
		$this->view->assign('newTeilnehmer', $newTeilnehmer);
	}
	
	/**
	 * action createTeilnehmer
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $newTeilnehmer
	 * #@dontvalidate $newTeilnehmer
	 * @return void
	 */
	public function createTeilnehmerAction(Tx_Blsvsa2013_Domain_Model_Schueler $newTeilnehmer = NULL) {
		// t3lib_utility_debug::debug($_REQUEST[tx_blsvsa2013_blsvsa2013][newTeilnehmer]);

		$newTeilnehmer->setGeburtstag( 12 * 3600 + strtotime( substr( $newTeilnehmer->getGeburtstag() , -4, 4).'-'. substr( $newTeilnehmer->getGeburtstag() , 3, 2 ) .'-'.   substr( $newTeilnehmer->getGeburtstag() , 0, 2 ) ) );		
		$newTeilnehmer->setFeuser($this->feusers);
		$newTeilnehmer->setPid($this->pidTeilnahmen);
		$newTeilnehmer->setJahrderletztenpruefung(date('Y'));
		// t3lib_utility_debug::debug($newTeilnehmer);

		$this->schuelerRepository->add($newTeilnehmer);
		$this->flashMessageContainer->add(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_bestellung.teilnehmerErstellt', $this->extensionName));
	}
	
	public function errorFind($name, $info){
		$error = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_bestellung.'.$name, 'blsvsa2013', array($info));		
		throw new \Exception( $error, 1357827111 );		
	}
	
	/**
	 * Bestellungsstatus pruefen und ggf. redirect nach show
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 */
	public function checkStatus(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		if ($bestellung->getStatus()>1) {
			$this->redirect('show', NULL, NULL, array('bestellung' => $bestellung));
		}
	}
 
	

	
	
	
	/**
	 * action printUrkunden
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 */
	public function printUrkundenAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung){
		$opt = array();
		$daten = array();
	
		$opt['name'] = 'urkunden_druck';
	
		$daten['tabelle'] = $this->urkundenRepository->findByBestellung($bestellung);
		$pdfUrkunden = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_PdfUrkunden');
		$pdfUrkunden->create($daten, $opt);
		exit;
	}
	
	/**
	 * action printPackliste
	 *
	 * @return void
	 */
	public function printPacklisteAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$opt = array();
		$daten = array();
	
		$opt['inhalte'] = 'packliste';
		$opt['name'] = 'urkunden_packliste';
	
		$daten['tabelle'] = $this->urkundenRepository->findByBestellung($bestellung);
		$pdfUrkunden = t3lib_div::makeInstance('Tx_Blsvsa2013_Service_PdfUrkunden');
		$pdfUrkunden->create($daten, $opt);
		exit;
	}
	
	/**
	 * action showUrkunden
	 *
	 * @return void
	 */
	public function showUrkundenAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$opt = array();
		$daten = array();
	
		$opt['bild'] = PATH_typo3conf . 'ext/blsvsa2013/Resources/Private/Layouts/urkunde.jpg';
		$opt['name'] = 'urkunden_ansicht';
	
		$daten['tabelle'] = $this->urkundenRepository->findByBestellung($bestellung);
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
	public function confirmUrkundenAction(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$this->urkundenRepository->confirmByBestellung($bestellung, true);
		$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_controller_bestellung.UrkundenBestaetigt', $this->extensionName ) );
		$this->redirect('list');
	}
	
}
?>