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
class Tx_Blsvsa2013_Domain_Model_Leistungstabelle extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Leistung Bronze
	 *
	 * @var integer
	 */
	protected $leistungbronze;

	/**
	 * Leistung Silber
	 *
	 * @var integer
	 */
	protected $leistungsilber;

	/**
	 * Leistung Gold
	 *
	 * @var integer
	 */
	protected $leistunggold;

	/**
	 * Sportart
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Sportarten
	 * @lazy
	 */
	protected $sportart;

	/**
	 * Altersgruppe
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Altersgruppen
	 * @lazy
	 */
	protected $altersgruppe;

	/**
	 * Returns the leistungbronze
	 *
	 * @return integer $leistungbronze
	 */
	public function getLeistungbronze() {
		return $this->leistungbronze;
	}

	/**
	 * Sets the leistungbronze
	 *
	 * @param integer $leistungbronze
	 * @return void
	 */
	public function setLeistungbronze($leistungbronze) {
		$this->leistungbronze = $leistungbronze;
	}

	/**
	 * Returns the leistungsilber
	 *
	 * @return integer $leistungsilber
	 */
	public function getLeistungsilber() {
		return $this->leistungsilber;
	}

	/**
	 * Sets the leistungsilber
	 *
	 * @param integer $leistungsilber
	 * @return void
	 */
	public function setLeistungsilber($leistungsilber) {
		$this->leistungsilber = $leistungsilber;
	}

	/**
	 * Returns the leistunggold
	 *
	 * @return integer $leistunggold
	 */
	public function getLeistunggold() {
		return $this->leistunggold;
	}

	/**
	 * Sets the leistunggold
	 *
	 * @param integer $leistunggold
	 * @return void
	 */
	public function setLeistunggold($leistunggold) {
		$this->leistunggold = $leistunggold;
	}

	/**
	 * Returns the sportart
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Sportarten $sportart
	 */
	public function getSportart() {
		return $this->sportart;
	}

	/**
	 * Sets the sportart
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Sportarten $sportart
	 * @return void
	 */
	public function setSportart(Tx_Blsvsa2013_Domain_Model_Sportarten $sportart) {
		$this->sportart = $sportart;
	}

	/**
	 * Returns the altersgruppe
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe
	 */
	public function getAltersgruppe() {
		return $this->altersgruppe;
	}

	/**
	 * Sets the altersgruppe
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe
	 * @return void
	 */
	public function setAltersgruppe(Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe) {
		$this->altersgruppe = $altersgruppe;
	}

}
?>