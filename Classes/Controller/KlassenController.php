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
class Tx_Blsvsa2013_Controller_KlassenController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * klassenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_KlassenRepository
	 */
	protected $klassenRepository;
	
	/**
	 * Schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule;
	
	/**
	 * schulenRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_SchulenRepository
	 */
	protected $schulenRepository;
	
	/**
	 * feusers des Lehrers/Bearbeiters
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 */
	protected $feusers;
	
	/**
	 * PID des Containers für die Klassenübersicht
	 *
	 * @var int
	 */
	 protected $pidAjaxContainerKlassenuebersicht=35;
	
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
		$this->feusers = $this->feusersRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		$this->schule = $this->feusers->getSchule();
	
		$this->extKey = $this->request->getControllerExtensionKey();
		$this->extPath = t3lib_extMgm::extPath($this->extKey);
	
		$this->importClassFile = $this->extPath.'Classes/tmp/class.importtext.php';
		$this->importClass = 'ImportText';
	 
		if ( $this->settings[pidAjaxContainerKlassenuebersicht] > 0) $this->pidAjaxContainerKlassenuebersicht = (int) $this->settings[pidAjaxContainerKlassenuebersicht];
	
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
	 * injectSchulenRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository
	 * @return void
	 */
	public function injectSchulenRepository(Tx_Blsvsa2013_Domain_Repository_SchulenRepository $schulenRepository) {
		$this->schulenRepository = $schulenRepository;
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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$klassen = $this->klassenRepository->findBySchulnummer( $this->schule->getSchulnummer() );
		
		$schulsumme = $this->getSchulsumme($klassen);
		$schulen=array('alle'=>0,'bestanden'=> 0,'nichtbestanden' => 0);
		
		$this->view->assign('klassen', $klassen);
		$this->view->assign('schulsumme', $schulsumme);
		$this->view->assign('pidKlasse', $this->pidAjaxContainerKlassenuebersicht);
	}
	
	/**
	 * function getSchulsumme()
	 * (public, da auch vom SchulenController aufgerufen)
	 *
	 * @param array $klassen
	 * @return void
	 */
	public function getSchulsumme( $klassen ) {
		$schulsumme=array('alle'=>0,'bestanden'=> 0,'nichtbestanden' => 0);
		foreach ($klassen as $klasse){
			$schulsumme['alle'] += $klasse->getAlle();
			$schulsumme['bestanden'] += $klasse->getBestanden();
			$schulsumme['nichtbestanden'] += $klasse->getNichtbestanden();
		}
	
		return $schulsumme;
	}

	

}
?>