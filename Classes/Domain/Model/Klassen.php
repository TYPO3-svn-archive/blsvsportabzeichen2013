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
class Tx_Blsvsa2013_Domain_Model_Klassen extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * klasse
	 *
	 * @var string
	 */
	protected $klasse;

	/**
	 * geschlecht
	 *
	 * @var integer
	 */
	protected $geschlecht=1;

	/**
	 * schulnummer
	 *
	 * @var string
	 */
	protected $schulnummer='';

	/**
	 * bestanden
	 *
	 * @var integer
	 */
	protected $bestanden=0;

	/**
	 * nichtbestanden
	 *
	 * @var integer
	 */
	protected $nichtbestanden=0;

	/**
	 * alle
	 *
	 * @var integer
	 */
	protected $alle=0;

	/**
	 * Returns the klasse
	 *
	 * @return string $klasse
	 */
	public function getKlasse() {
		return $this->klasse;
	}

	/**
	 * Sets the klasse
	 *
	 * @param string $klasse
	 * @return void
	 */
	public function setKlasse($klasse) {
		$this->klasse = $klasse;
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
	 * Returns the schulnummer
	 *
	 * @return string $schulnummer
	 */
	public function getSchulnummer() {
		return $this->schulnummer;
	}

	/**
	 * Sets the schulnummer
	 *
	 * @param string $schulnummer
	 * @return void
	 */
	public function setSchulnummer($schulnummer) {
		$this->schulnummer = $schulnummer;
	}

	/**
	 * Returns the bestanden
	 *
	 * @return integer $bestanden
	 */
	public function getBestanden() {
		return $this->bestanden;
	}

	/**
	 * Sets the bestanden
	 *
	 * @param integer $bestanden
	 * @return void
	 */
	public function setBestanden($bestanden) {
		
		$this->bestanden = $bestanden;
	}

	/**
	 * Returns the nichtbestanden
	 *
	 * @return integer $nichtbestanden
	 */
	public function getNichtbestanden() {
		return $this->nichtbestanden;
	}

	/**
	 * Sets the nichtbestanden
	 *
	 * @param integer $nichtbestanden
	 * @return void
	 */
	public function setNichtbestanden($nichtbestanden) {
		$this->nichtbestanden = $nichtbestanden;
	}

	/**
	 * Returns the alle
	 *
	 * @return integer $alle
	 */
	public function getAlle() {
		
		return $this->alle;
	}

	/**
	 * Sets the alle
	 *
	 * @param integer $alle
	 * @return void
	 */
	public function setAlle($alle) {
		$this->alle = $alle;
	}

}
?>