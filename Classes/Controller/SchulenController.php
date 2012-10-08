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
	 * schulnummer
	 *
	 * @var int
	 */
	protected $schulnummer;
	
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
	* feuserRepository
	*
	* @var Tx_Blsvsa2013_Domain_Repository_FeuserRepository
	*/
	protected $feuserRepository;
	
	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
			
		$this->feuser = $this->feuserRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
		$this->schulnummer = $GLOBALS['TSFE']->fe_user->user['schule'];
		
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
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schulen
	 * @return void
	 */
	public function editAction(Tx_Blsvsa2013_Domain_Model_Schulen $schulen=Null) {
		$schulen = $this->schulenRepository->findByUid( $this->schulnummer);
		//t3lib_utility_Debug::debug($schulen, 'schule');
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
		$this->schulenRepository->update($schulen);
		if (!($schulen->isGrundschulen() or $schulen->isSchulwettbewerb())){
			$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.keinwettbwerbangegeben', $this->extensionName) );
		}
		
		$this->flashMessageContainer->add( Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_model_schulen.angabengespeichert', $this->extensionName) );
		$this->redirect('edit');
	}
	
	

}
?>