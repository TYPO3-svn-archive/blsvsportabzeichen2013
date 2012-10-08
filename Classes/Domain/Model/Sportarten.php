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
class Tx_Blsvsa2013_Domain_Model_Sportarten extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Sportartname
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * Sportartgruppe
	 *
	 * @var integer
	 */
	protected $sportartgruppe;

	/**
	 * Ergebnisart
	 *
	 * @var integer
	 */
	protected $ergebnisart;

	/**
	 * Reihenfolge
	 *
	 * @var integer
	 */
	protected $reihenfolge;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the sportartgruppe
	 *
	 * @return integer $sportartgruppe
	 */
	public function getSportartgruppe() {
		return $this->sportartgruppe;
	}

	/**
	 * Sets the sportartgruppe
	 *
	 * @param integer $sportartgruppe
	 * @return void
	 */
	public function setSportartgruppe($sportartgruppe) {
		$this->sportartgruppe = $sportartgruppe;
	}

	/**
	 * Returns the ergebnisart
	 *
	 * @return integer $ergebnisart
	 */
	public function getErgebnisart() {
		return $this->ergebnisart;
	}

	/**
	 * Sets the ergebnisart
	 *
	 * @param integer $ergebnisart
	 * @return void
	 */
	public function setErgebnisart($ergebnisart) {
		$this->ergebnisart = $ergebnisart;
	}

	/**
	 * Returns the reihenfolge
	 *
	 * @return integer $reihenfolge
	 */
	public function getReihenfolge() {
		return $this->reihenfolge;
	}

	/**
	 * Sets the reihenfolge
	 *
	 * @param integer $reihenfolge
	 * @return void
	 */
	public function setReihenfolge($reihenfolge) {
		$this->reihenfolge = $reihenfolge;
	}

}
?>