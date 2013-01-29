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
class Tx_Blsvsa2013_Domain_Model_Schueler extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Vorname
	 *
	 * @var string
	 */
	protected $vorname;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * geschlecht
	 *
	 * @var integer
	 */
	protected $geschlecht=1;

	/**
	 * Geburtstag
	 *
	 * @var integer
	 */
	protected $geburtstag=0;

	/**
	 * Klasse
	 *
	 * @var string
	 */
	protected $klasse;

	/**
	 * Grundschulwettbewerb
	 *
	 * @var boolean
	 */
	protected $grundschulwettbewerb = FALSE;

	/**
	 * Straße
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
	 * Ort
	 *
	 * @var string
	 */
	protected $ort;

	/**
	 * Email
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * Telefon
	 *
	 * @var string
	 */
	protected $telefon;

	/**
	 * Jahr der letzten Prüfung
	 *
	 * @var integer
	 */
	protected $jahrderletztenpruefung=2000;

	/**
	 * Anzahr der bisher beurkundeten Sportabzeichen (kommulatver Aspekt)
	 *
	 * @var integer
	 */
	protected $anzteilnahmen=1;

	/**
	 * schwimmnachweisgueltigbis
	 *
	 * @var integer
	 */
	protected $schwimmnachweisgueltigbis=0;

	/**
	 * schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule=null;
	
	/**
	 * schulnummer
	 *
	 * @var string
	 */
	protected $schulnummer='0';
	
	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 * @lazy
	 */
	protected $feuser=null;
	
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
	 * Returns the geschlecht
	 *
	 * @return inetger $geschlecht
	 */
	public function getGeschlecht() {
		return $this->geschlecht;
	}

	/**
	 * Sets the geschlecht
	 *
	 * @param inetger $geschlecht
	 * @return void
	 */
	public function setGeschlecht($geschlecht) {
			if ( ( $geschlecht < 1 ) or  ($geschlecht > 2) )  throw new \InvalidArgumentException( "Tx_Blsvsa2013_Domain_Model_Schueler->geschlecht should be 1 or 2!", 1349784746 );
	
		$this->geschlecht = $geschlecht;
	}

	/**
	 * Returns the geburtstag
	 *
	 * @return integer $geburtstag
	 */
	public function getGeburtstag() {
		return $this->geburtstag;
	}

	/**
	 * Sets the geburtstag
	 *
	 * @param integer $geburtstag
	 * @return void
	 */
	public function setGeburtstag($geburtstag) {
		$this->geburtstag = $geburtstag;
	}

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
	 * Returns the grundschulwettbewerb
	 *
	 * @return boolean $grundschulwettbewerb
	 */
	public function getGrundschulwettbewerb() {
		return $this->grundschulwettbewerb;
	}

	/**
	 * Sets the grundschulwettbewerb
	 *
	 * @param boolean $grundschulwettbewerb
	 * @return void
	 */
	public function setGrundschulwettbewerb($grundschulwettbewerb) {
		$this->grundschulwettbewerb = $grundschulwettbewerb;
	}

	/**
	 * Returns the boolean state of grundschulwettbewerb
	 *
	 * @return boolean
	 */
	public function isGrundschulwettbewerb() {
		return $this->getGrundschulwettbewerb();
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
	 * Returns the email
	 *
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the telefon
	 *
	 * @return string $telefon
	 */
	public function getTelefon() {
		return $this->telefon;
	}

	/**
	 * Sets the telefon
	 *
	 * @param string $telefon
	 * @return void
	 */
	public function setTelefon($telefon) {
		$this->telefon = $telefon;
	}

	/**
	 * Returns the jahrderletztenpruefung
	 *
	 * @return integer $jahrderletztenpruefung
	 */
	public function getJahrderletztenpruefung() {
		return $this->jahrderletztenpruefung;
	}

	/**
	 * Sets the jahrderletztenpruefung
	 *
	 * @param integer $jahrderletztenpruefung
	 * @return void
	 */
	public function setJahrderletztenpruefung($jahrderletztenpruefung) {
		$this->jahrderletztenpruefung = $jahrderletztenpruefung;
	}

	/**
	 * Returns the anzteilnahmen
	 *
	 * @return integer $anzteilnahmen
	 */
	public function getAnzteilnahmen() {
		return $this->anzteilnahmen;
	}

	/**
	 * Sets the anzteilnahmen
	 *
	 * @param integer $anzteilnahmen
	 * @return void
	 */
	public function setAnzteilnahmen($anzteilnahmen) {
		$this->anzteilnahmen = $anzteilnahmen;
	}

	/**
	 * Returns the schwimmnachweisgueltigbis
	 *
	 * @return integer $schwimmnachweisgueltigbis
	 */
	public function getSchwimmnachweisgueltigbis() {
		return $this->schwimmnachweisgueltigbis;
	}

	/**
	 * Sets the schwimmnachweisgueltigbis
	 *
	 * @param integer $schwimmnachweisgueltigbis
	 * @return void
	 */
	public function setSchwimmnachweisgueltigbis($schwimmnachweisgueltigbis) {
		$this->schwimmnachweisgueltigbis = $schwimmnachweisgueltigbis;
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
	 * Sets the schulnummer
	 *
	 * @param string $schulnummer
	 * @return void
	 */
	public function setSchulnummer($schulnummer) {
		if (  ($schulnummer=='') or ($schulnummer=='0')  ) throw new InvalidArgumentException('Jedem Schuler muss eine Schulnummer zugeordnet sein',1350915961);
		$this->schulnummer = $schulnummer;
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
	 * Liefert das Alter des Schuelers
	 *
	 * @return integer $alter
	 */
	public function getAlter(){
		$alter = Tx_Blsvsa2013_Service_Tools::getAlter($this->getGeburtstag());
		return $alter;
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
	 * @param Tx_Blsvsa2013_Domain_Model_Feusers $feuser
	 * @return void
	 */
	public function setFeuser(Tx_Blsvsa2013_Domain_Model_Feusers $feuser) {
		$this->feuser = $feuser;
	}
}
?>