<?php
define('BLSVSA2013_BESTELLUNG_RECHNUNGEN_PFAD', 'uploads/tx_blsvsa2013/rechnungen');

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
class Tx_Blsvsa2013_Domain_Model_Bestellung extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Anrede
	 *
	 * @var string
	 */
	protected $anrede;

	/**
	 * institution
	 *
	 * @var string
	 */
	protected $institution;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Vorname
	 *
	 * @var string
	 */
	protected $vorname;

	/**
	 * adresszusatz
	 *
	 * @var string
	 */
	protected $adresszusatz;

	/**
	 * Strasse
	 *
	 * @var string
	 */
	protected $strasse;

	/**
	 * PLZ
	 *
	 * @var string
	 */
	protected $plz;

	/**
	 * ORT
	 *
	 * @var string
	 */
	protected $ort;

	/**
	 * abweichende REchnungadreese
	 *
	 * @var boolean
	 */
	protected $abweichnedelieferadresse = FALSE;

	/**
	 * lieferinstitution
	 *
	 * @var string
	 */
	protected $lieferinstitution;

	/**
	 * liefername
	 *
	 * @var string
	 */
	protected $liefername;

	/**
	 * liefervorname
	 *
	 * @var string
	 */
	protected $liefervorname;

	/**
	 * lieferanrede
	 *
	 * @var string
	 */
	protected $lieferanrede;

	/**
	 * lieferstrasse
	 *
	 * @var string
	 */
	protected $lieferstrasse;

	/**
	 * lieferplz
	 *
	 * @var string
	 */
	protected $lieferplz;

	/**
	 * lieferort
	 *
	 * @var string
	 */
	protected $lieferort;

	/**
	 * schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule;

	/**
	 * teilnahme
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Teilnahmen
	 */
	protected $teilnahme;
	
	
	/**
	 * Status
	 *
	 * @var int
	 */
	protected $status=0;
	
	
	/**
	 * erfassungsdatum
	 *
	 * @var int
	 */
	protected $erfassungsdatum=0;

	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 * @lazy
	 */
	protected $feuser=null;
	
	/**
	 * Returns the anrede
	 *
	 * @return string $anrede
	 */
	public function getAnrede() {
		return $this->anrede;
	}

	/**
	 * Sets the anrede
	 *
	 * @param string $anrede
	 * @return void
	 */
	public function setAnrede($anrede) {
		$this->anrede = $anrede;
	}

	/**
	 * Returns the institution
	 *
	 * @return string $institution
	 */
	public function getInstitution() {
		return $this->institution;
	}

	/**
	 * Sets the institution
	 *
	 * @param string $institution
	 * @return void
	 */
	public function setInstitution($institution) {
		$this->institution = $institution;
	}

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
	 * Returns the vorname
	 *
	 * @return string $vorname
	 */
	public function getVorname() {
		return $this->vorname;
	}

	/**
	 * Sets the vorname
	 *
	 * @param string $vorname
	 * @return void
	 */
	public function setVorname($vorname) {
		$this->vorname = $vorname;
	}

	/**
	 * Returns the adresszusatz
	 *
	 * @return string $adresszusatz
	 */
	public function getAdresszusatz() {
		return $this->adresszusatz;
	}

	/**
	 * Sets the adresszusatz
	 *
	 * @param string $adresszusatz
	 * @return void
	 */
	public function setAdresszusatz($adresszusatz) {
		$this->adresszusatz = $adresszusatz;
	}

	/**
	 * Returns the strasse
	 *
	 * @return string $strasse
	 */
	public function getStrasse() {
		return $this->strasse;
	}

	/**
	 * Sets the strasse
	 *
	 * @param string $strasse
	 * @return void
	 */
	public function setStrasse($strasse) {
		$this->strasse = $strasse;
	}

	/**
	 * Returns the plz
	 *
	 * @return string $plz
	 */
	public function getPlz() {
		return $this->plz;
	}

	/**
	 * Sets the plz
	 *
	 * @param string $plz
	 * @return void
	 */
	public function setPlz($plz) {
		$this->plz = $plz;
	}

	/**
	 * Returns the ort
	 *
	 * @return string $ort
	 */
	public function getOrt() {
		return $this->ort;
	}

	/**
	 * Sets the ort
	 *
	 * @param string $ort
	 * @return void
	 */
	public function setOrt($ort) {
		$this->ort = $ort;
	}

	/**
	 * Returns the abweichnedelieferadresse
	 *
	 * @return boolean $abweichnedelieferadresse
	 */
	public function getAbweichnedelieferadresse() {
		return $this->abweichnedelieferadresse;
	}

	/**
	 * Sets the abweichnedelieferadresse
	 *
	 * @param boolean $abweichnedelieferadresse
	 * @return void
	 */
	public function setAbweichnedelieferadresse($abweichnedelieferadresse) {
		$this->abweichnedelieferadresse = $abweichnedelieferadresse;
	}

	/**
	 * Returns the boolean state of abweichnedelieferadresse
	 *
	 * @return boolean
	 */
	public function isAbweichnedelieferadresse() {
		return $this->getAbweichnedelieferadresse();
	}

	/**
	 * Returns the lieferinstitution
	 *
	 * @return string $lieferinstitution
	 */
	public function getLieferinstitution() {
		return $this->lieferinstitution;
	}

	/**
	 * Sets the lieferinstitution
	 *
	 * @param string $lieferinstitution
	 * @return void
	 */
	public function setLieferinstitution($lieferinstitution) {
		$this->lieferinstitution = $lieferinstitution;
	}

	/**
	 * Returns the liefername
	 *
	 * @return string $liefername
	 */
	public function getLiefername() {
		return $this->liefername;
	}

	/**
	 * Sets the liefername
	 *
	 * @param string $liefername
	 * @return void
	 */
	public function setLiefername($liefername) {
		$this->liefername = $liefername;
	}

	/**
	 * Returns the liefervorname
	 *
	 * @return string $liefervorname
	 */
	public function getLiefervorname() {
		return $this->liefervorname;
	}

	/**
	 * Sets the liefervorname
	 *
	 * @param string $liefervorname
	 * @return void
	 */
	public function setLiefervorname($liefervorname) {
		$this->liefervorname = $liefervorname;
	}

	/**
	 * Returns the lieferanrede
	 *
	 * @return string $lieferanrede
	 */
	public function getLieferanrede() {
		return $this->lieferanrede;
	}

	/**
	 * Sets the lieferanrede
	 *
	 * @param string $lieferanrede
	 * @return void
	 */
	public function setLieferanrede($lieferanrede) {
		$this->lieferanrede = $lieferanrede;
	}

	/**
	 * Returns the lieferstrasse
	 *
	 * @return string $lieferstrasse
	 */
	public function getLieferstrasse() {
		return $this->lieferstrasse;
	}

	/**
	 * Sets the lieferstrasse
	 *
	 * @param string $lieferstrasse
	 * @return void
	 */
	public function setLieferstrasse($lieferstrasse) {
		$this->lieferstrasse = $lieferstrasse;
	}

	/**
	 * Returns the lieferplz
	 *
	 * @return string $lieferplz
	 */
	public function getLieferplz() {
		return $this->lieferplz;
	}

	/**
	 * Sets the lieferplz
	 *
	 * @param string $lieferplz
	 * @return void
	 */
	public function setLieferplz($lieferplz) {
		$this->lieferplz = $lieferplz;
	}

	/**
	 * Returns the lieferort
	 *
	 * @return string $lieferort
	 */
	public function getLieferort() {
		return $this->lieferort;
	}

	/**
	 * Sets the lieferort
	 *
	 * @param string $lieferort
	 * @return void
	 */
	public function setLieferort($lieferort) {
		$this->lieferort = $lieferort;
	}

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
	 * Returns the teilnahme
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme
	 */
	public function getTeilnahme() {
		return $this->teilnahme;
	}

	/**
	 * Sets the teilnahme
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme
	 * @return void
	 */
	public function setTeilnahme(Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme) {
		$this->teilnahme = $teilnahme;
	}
	
	/**
	 * Returns the status
	 *
	 * @return int $status
	 */
	public function getStatus() {
		if (2 == $this->status){
			if($this->getRechnungUrl()){
				$this->setStatus(3);
			}
		}
		return $this->status;
	}
	
	/**
	 * Sets the status
	 *
	 * @param int $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the Erfassungsdatum
	 *
	 * @return int $erfassungsdatum
	 */
	public function getErfassungsdatum() {
		return $this->erfassungsdatum;
	}
	
	/**
	 * Sets the Erfassungsdatum
	 *
	 * @param int $erfassungsdatum
	 * @return void
	 */
	public function setErfassungsdatum($erfassungsdatum) {
		$this->erfassungsdatum = $erfassungsdatum;
	}

	/**
	 * Returns the feuser
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Feusers $feuser
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
	public function setFeuser(Tx_Blsvsa2013_Domain_Model_Feusers $feuser) {
		$this->feuser = $feuser;
	}
	
	
	/**
	 * liefert den Pfad einer Rechnung
	 * 
	 * @return string|NULL $url Pfad
	 */
	public function getRechnungUrl() {
		$search = sprintf('^(.*%06d.pdf)$', $this->uid);
		$files = t3lib_div::getFilesInDir(BLSVSA2013_BESTELLUNG_RECHNUNGEN_PFAD, 'pdf', 1);
		foreach ($files as $file){
			if (preg_match("/$search/", $file, $url)){
				return $url[0];
			}
		}
		return NULL;
	}
	
	public function getIsEditable() {
		return ($this->status == 1);
	}
	
	public function getHasRechnung() {
		return ($this->status > 2);
	}
	
	public function getHasUrkunden() {
		return ($this->status > 1);
	}
}
?>