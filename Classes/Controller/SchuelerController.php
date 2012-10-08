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
		$importInfo = array();
		
		if(!empty($reqdata['schuelerstring'])){
			
			require_once($this->importClassFile);
			$import = t3lib_div::makeInstance($this->importClass, $this->extPath);
			
//				$schuelers = $import->getSchuelers($reqdata['schuelerstring'], $importInfo, );
				
				$schuelerImp = $import->getSchuelerArray($reqdata['schuelerstring']);
				$schuelerNeu = $import->getSchuelerNeu($this->schule->getUid(), $schuelerImp['good']);
				
				$importInfo = array(
						'gesamt' => count($schuelerImp['good']),
						'neu' => count($schuelerNeu),
						'fehler' => count($schuelerImp['bad']),
						'fehlerzeilen' => $schuelerImp['bad'],
				);
				$messages[0] = 'TestMessage';
				$schuelers = $import->getSchuelers($this->schule, $schuelerNeu, $this->feuser);

			

			
			foreach ($messages as $message){
				$this->flashMessageContainer->add($message);
			}

			
			foreach($schuelers as $newSchueler){
				$this->schuelerRepository->add($newSchueler);
			}

			t3lib_utility_Debug::debug($reqdata, 'request');
			t3lib_utility_Debug::debug($importInfo, 'ImportInfo');
		}
		
		$this->view->assign('importInfo', $importInfo);
		$this->view->assign('errornumber', 1);
	
		
	}
}
?>