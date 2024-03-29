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
class Tx_Blsvsa2013_Controller_FeuserController extends Tx_Extbase_MVC_Controller_ActionController {

	
	
	/**
	 * feuser
	 *
	 * @var int
	 */
	protected $feuser;
	
	/**
	 * feuserRepository
	 *
	 * @var Tx_Blsvsa2013_Domain_Repository_FeuserRepository
	 */
	
	protected $feuserRepository;

	/**
	 * injectFeuserRepository
	 *
	 * @param Tx_Blsvsa2013_Domain_Repository_FeuserRepository $feuserRepository
	 * @return void
	 */
	public function injectFeuserRepository(Tx_Blsvsa2013_Domain_Repository_FeuserRepository $feuserRepository) {
		$this->feuserRepository = $feuserRepository;
	}
	

	/**
	 * Initializes the current action
	 * @return void
	 */
	protected function initializeAction() {
			
		$this->feuser = $this->feuserRepository->findByUid( $GLOBALS['TSFE']->fe_user->user['uid'] ) ;
			
	}
	
	/**
	 * erstellt Liste der Lehrer der Schule
	 * @return void
	 */
	protected function listAction() {
			
		//echo($this->feuser->getSchule());
		
		$lehrer = $this->feuserRepository->findBySchule( $this->feuser->getSchule() );
		
		
		$this->view->assign( 'feusers', $lehrer );
		
			
	}
	
	
	

}
?>