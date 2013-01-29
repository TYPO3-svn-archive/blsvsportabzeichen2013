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
class Tx_Blsvsa2013_Controller_InstitutionsartartController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$institutionsartarts = $this->institutionsartartRepository->findAll();
		$this->view->assign('institutionsartarts', $institutionsartarts);
	}

	/**
	 * action show
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 * @return void
	 */
	public function showAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart) {
		$this->view->assign('institutionsartart', $institutionsartart);
	}

	/**
	 * action new
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $newInstitutionsartart
	 * @dontvalidate $newInstitutionsartart
	 * @return void
	 */
	public function newAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $newInstitutionsartart = NULL) {
		$this->view->assign('newInstitutionsartart', $newInstitutionsartart);
	}

	/**
	 * action create
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $newInstitutionsartart
	 * @return void
	 */
	public function createAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $newInstitutionsartart) {
		$this->institutionsartartRepository->add($newInstitutionsartart);
		$this->flashMessageContainer->add('Your new Institutionsartart was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 * @return void
	 */
	public function editAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart) {
		$this->view->assign('institutionsartart', $institutionsartart);
	}

	/**
	 * action update
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 * @return void
	 */
	public function updateAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart) {
		$this->institutionsartartRepository->update($institutionsartart);
		$this->flashMessageContainer->add('Your Institutionsartart was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 * @return void
	 */
	public function deleteAction(Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart) {
		$this->institutionsartartRepository->remove($institutionsartart);
		$this->flashMessageContainer->add('Your Institutionsartart was removed.');
		$this->redirect('list');
	}

}
?>