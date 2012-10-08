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
class Tx_Blsvsa2013_Domain_Model_Feuser extends Tx_Extbase_Domain_Model_FrontendUser {

	/**
	 * schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule;
	
	/**
	 * feuser
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feuser
	 * @lazy
	 */
	protected $feuser;

	/**
	 * Returns the schule
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 */
	public function getSchule() {
		return $this->schule;
	}
	
	

	/**
	 * Sets the schule
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @return void
	 */
	public function setSchule(Tx_Blsvsa2013_Domain_Model_Schulen $schule) {
		$this->schule = $schule;
	}
	
	/**
	 * Returns the feuser
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Feuser $feuser
	 */
	public function getFeuser() {
		return $this->feuser;
	}
	
	/**
	 * Sets the feuser
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Feuser $feuser
	 * @return void
	 */
	public function setFeuser(Tx_Blsvsa2013_Domain_Model_Feuser $feuser) {
		$this->feuser = $feuser;
	}

}
?>