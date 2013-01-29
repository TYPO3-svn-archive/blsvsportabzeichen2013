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
class Tx_Blsvsa2013_Domain_Model_Artikel extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Artikelnummer aus navision
	 *
	 * @var string
	 */
	protected $artikelnummer;

	/**
	 * Beschreibung des Artikels
	 *
	 * @var string
	 */
	protected $artikel;

	/**
	 * Preis
	 *
	 * @var integer
	 */
	protected $preis=0;

	/**
	 * Returns the artikelnummer
	 *
	 * @return string $artikelnummer
	 */
	public function getArtikelnummer() {
		return $this->artikelnummer;
	}

	/**
	 * Sets the artikelnummer
	 *
	 * @param string $artikelnummer
	 * @return void
	 */
	public function setArtikelnummer($artikelnummer) {
		$this->artikelnummer = $artikelnummer;
	}

	/**
	 * Returns the artikel
	 *
	 * @return string $artikel
	 */
	public function getArtikel() {
		return $this->artikel;
	}

	/**
	 * Sets the artikel
	 *
	 * @param string $artikel
	 * @return void
	 */
	public function setArtikel($artikel) {
		$this->artikel = $artikel;
	}

	/**
	 * Returns the preis
	 *
	 * @return integer $preis
	 */
	public function getPreis() {
		return $this->preis;
	}

	/**
	 * Sets the preis
	 *
	 * @param integer $preis
	 * @return void
	 */
	public function setPreis($preis) {
		$this->preis = $preis;
	}

}
?>