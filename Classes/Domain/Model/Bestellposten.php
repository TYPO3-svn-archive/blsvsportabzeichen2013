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
class Tx_Blsvsa2013_Domain_Model_Bestellposten extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * anzahl
	 *
	 * @var string
	 */
	protected $anzahl;

	/**
	 * bestellung
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Bestellung
	 */
	protected $bestellung;

	/**
	 * artikel
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Artikel
	 */
	protected $artikel;

	/**
	 * Returns the anzahl
	 *
	 * @return string $anzahl
	 */
	public function getAnzahl() {
		return $this->anzahl;
	}

	/**
	 * Sets the anzahl
	 *
	 * @param string $anzahl
	 * @return void
	 */
	public function setAnzahl($anzahl) {
		$this->anzahl = $anzahl;
	}

	/**
	 * Returns the bestellung
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 */
	public function getBestellung() {
		return $this->bestellung;
	}

	/**
	 * Sets the bestellung
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return void
	 */
	public function setBestellung(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		$this->bestellung = $bestellung;
	}

	/**
	 * Returns the artikel
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Artikel $artikel
	 */
	public function getArtikel() {
		return $this->artikel;
	}

	/**
	 * Sets the artikel
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Artikel $artikel
	 * @return void
	 */
	public function setArtikel(Tx_Blsvsa2013_Domain_Model_Artikel $artikel) {
		$this->artikel = $artikel;
	}

}
?>