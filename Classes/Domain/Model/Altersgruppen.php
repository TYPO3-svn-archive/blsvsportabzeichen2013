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
class Tx_Blsvsa2013_Domain_Model_Altersgruppen extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Bezeichnung
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $bezeichnung;

	/**
	 * Geschlecht
	 *
	 * @var integer
	 */
	protected $geschlecht;

	/**
	 * Alter von
	 *
	 * @var integer
	 */
	protected $altervon;

	/**
	 * Alter bis
	 *
	 * @var integer
	 */
	protected $alterbis;

	/**
	 * Returns the bezeichnung
	 *
	 * @return string $bezeichnung
	 */
	public function getBezeichnung() {
		return $this->bezeichnung;
	}

	/**
	 * Sets the bezeichnung
	 *
	 * @param string $bezeichnung
	 * @return void
	 */
	public function setBezeichnung($bezeichnung) {
		$this->bezeichnung = $bezeichnung;
	}

	/**
	 * Returns the geschlecht
	 *
	 * @return integer $geschlecht
	 */
	public function getGeschlecht() {
		return $this->geschlecht;
	}

	/**
	 * Sets the geschlecht
	 *
	 * @param integer $geschlecht
	 * @return void
	 */
	public function setGeschlecht($geschlecht) {
		$this->geschlecht = $geschlecht;
	}

	/**
	 * Returns the altervon
	 *
	 * @return integer $altervon
	 */
	public function getAltervon() {
		return $this->altervon;
	}

	/**
	 * Sets the altervon
	 *
	 * @param integer $altervon
	 * @return void
	 */
	public function setAltervon($altervon) {
		$this->altervon = $altervon;
	}

	/**
	 * Returns the alterbis
	 *
	 * @return integer $alterbis
	 */
	public function getAlterbis() {
		return $this->alterbis;
	}

	/**
	 * Sets the alterbis
	 *
	 * @param integer $alterbis
	 * @return void
	 */
	public function setAlterbis($alterbis) {
		$this->alterbis = $alterbis;
	}

}
?>