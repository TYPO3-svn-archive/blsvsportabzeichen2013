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
class Tx_Blsvsa2013_Domain_Model_Schulen extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Schulnummer
	 *
	 * @var string
	 */
	protected $schulnummer=0;

	/**
	 * Schulname
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * Schulart
	 *
	 * @var integer
	 */
	protected $schulart=0;

	/**
	 * Strasse
	 *
	 * @var string
	 */
	protected $strasse;

	/**
	 * Postleitzahl
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
	 * Telefonnummer
	 *
	 * @var string
	 */
	protected $telefon;

	/**
	 * E-Mail-Adresse
	 *
	 * @var string
	 */
	protected $email;

	/**
	 * Bezirk
	 *
	 * @var integer
	 */
	protected $bezirk=0;

	/**
	 * Kreis
	 *
	 * @var integer
	 */
	protected $kreis=0;

	/**
	 * BLSV-Kreis
	 *
	 * @var integer
	 */
	protected $blsvkreis=0;

	/**
	 * Bankempfänger
	 *
	 * @var string
	 */
	protected $bankempfaenger;

	/**
	 * Kontonummer
	 *
	 * @var string
	 */
	protected $kto;

	/**
	 * Bankleitzahl
	 *
	 * @var string
	 */
	protected $blz;

	/**
	 * Verwendungszweck
	 *
	 * @var string
	 */
	protected $verwendungszweck;

	/**
	 * Grundschulen
	 *
	 * @var boolean
	 */
	protected $grundschulen=FALSE;

	/**
	 * Schulwettbewerb
	 *
	 * @var boolean
	 */
	protected $schulwettbewerb=FALSE;

	/**
	 * Anzahl Schüler
	 *
	 * @var integer
	 */
	protected $anzschueler=0;

	/**
	 * Anzahl teilnahmeberechtigter Schüler
	 *
	 * @var integer
	 */
	protected $anzteilnahmeberechtigt=0;

	/**
	 * Anzahl bestandene Schüler
	 *
	 * @var integer
	 */
	protected $anzbestanden=0;

	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 * @lazy
	 */
	protected $feuser=null;
	
	/**
	 * Art der Schule bzw. institution z.B. Polizei
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Institutionsartart
	 * @lazy
	 */
	protected $institutionsartart;

	/**
	 * tstamp
	 *
	 * @var integer
	 */
	protected $tstamp;
	

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
	 * Returns the schulart
	 *
	 * @return integer $schulart
	 */
	public function getSchulart() {
		return $this->schulart;
	}

	/**
	 * Sets the schulart
	 *
	 * @param integer $schulart
	 * @return void
	 */
	public function setSchulart($schulart) {
		$this->schulart = $schulart;
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
	 * Returns the bezirk
	 *
	 * @return integer $bezirk
	 */
	public function getBezirk() {
		return $this->bezirk;
	}

	/**
	 * Sets the bezirk
	 *
	 * @param integer $bezirk
	 * @return void
	 */
	public function setBezirk($bezirk) {
		$this->bezirk = $bezirk;
	}

	/**
	 * Returns the kreis
	 *
	 * @return integer $kreis
	 */
	public function getKreis() {
		return $this->kreis;
	}

	/**
	 * Sets the kreis
	 *
	 * @param integer $kreis
	 * @return void
	 */
	public function setKreis($kreis) {
		$this->kreis = $kreis;
	}

	/**
	 * Returns the blsvkreis
	 *
	 * @return integer $blsvkreis
	 */
	public function getBlsvkreis() {
		return $this->blsvkreis;
	}

	/**
	 * Sets the blsvkreis
	 *
	 * @param integer $blsvkreis
	 * @return void
	 */
	public function setBlsvkreis($blsvkreis) {
		$this->blsvkreis = $blsvkreis;
	}

	/**
	 * Returns the bankempfaenger
	 *
	 * @return string $bankempfaenger
	 */
	public function getBankempfaenger() {
		return $this->bankempfaenger;
	}

	/**
	 * Sets the bankempfaenger
	 *
	 * @param string $bankempfaenger
	 * @return void
	 */
	public function setBankempfaenger($bankempfaenger) {
		$this->bankempfaenger = $bankempfaenger;
	}

	/**
	 * Returns the kto
	 *
	 * @return string $kto
	 */
	public function getKto() {
		return $this->kto;
	}

	/**
	 * Sets the kto
	 *
	 * @param string $kto
	 * @return void
	 */
	public function setKto($kto) {
		$this->kto = $kto;
	}

	/**
	 * Returns the blz
	 *
	 * @return string $blz
	 */
	public function getBlz() {
		return $this->blz;
	}

	/**
	 * Sets the blz
	 *
	 * @param string $blz
	 * @return void
	 */
	public function setBlz($blz) {
		$this->blz = $blz;
	}

	/**
	 * Returns the verwendungszweck
	 *
	 * @return string $verwendungszweck
	 */
	public function getVerwendungszweck() {
		return $this->verwendungszweck;
	}

	/**
	 * Sets the verwendungszweck
	 *
	 * @param string $verwendungszweck
	 * @return void
	 */
	public function setVerwendungszweck($verwendungszweck) {
		$this->verwendungszweck = $verwendungszweck;
	}

	/**
	 * Returns the grundschulen
	 *
	 * @return boolean $grundschulen
	 */
	public function getGrundschulen() {
		return $this->grundschulen;
	}

	/**
	 * Sets the grundschulen
	 *
	 * @param booelan $grundschulen
	 * @return void
	 */
	public function setGrundschulen($grundschulen) {
		$this->grundschulen = $grundschulen;
	}
	

	/**
	 * Determines if a Schule  is participating at the grundschulwettbewerb.
	 * @return void
	 */
	public function isGrundschulen() {
		return $this->getGrundschulen();
	}

	/**
	 * Returns the schulwettbewerb
	 *
	 * @return booelaen $schulwettbewerb
	 */
	public function getSchulwettbewerb() {
		return $this->schulwettbewerb;
	}

	/**
	 * Sets the schulwettbewerb
	 *
	 * @param boolean $schulwettbewerb
	 * @return void
	 */
	public function setSchulwettbewerb($schulwettbewerb) {
		$this->schulwettbewerb = $schulwettbewerb;
	}
	
	/**
	 * Determines if a Schule  is participating at the schulwettbewerb.
	 * @return boolean TRUE, if the user is a project member, otherwise FALSE.
	 */
	public function isSchulwettbewerb() {
		return $this->getSchulwettbewerb();
	}

	/**
	 * Returns the anzschueler
	 *
	 * @return integer $anzschueler
	 */
	public function getAnzschueler() {
		return $this->anzschueler;
	}

	/**
	 * Sets the anzschueler
	 *
	 * @param integer $anzschueler
	 * @return void
	 */
	public function setAnzschueler($anzschueler) {
		$this->anzschueler = $anzschueler;
	}

	/**
	 * Returns the anzteilnahmeberechtigt
	 *
	 * @return integer $anzteilnahmeberechtigt
	 */
	public function getAnzteilnahmeberechtigt() {
		return $this->anzteilnahmeberechtigt;
	}

	/**
	 * Sets the anzteilnahmeberechtigt
	 *
	 * @param integer $anzteilnahmeberechtigt
	 * @return void
	 */
	public function setAnzteilnahmeberechtigt($anzteilnahmeberechtigt) {
		$this->anzteilnahmeberechtigt = $anzteilnahmeberechtigt;
	}

	/**
	 * Returns the anzbestanden
	 *
	 * @return integer $anzbestanden
	 */
	public function getAnzbestanden() {
		return $this->anzbestanden;
	}

	/**
	 * Sets the anzbestanden
	 *
	 * @param integer $anzbestanden
	 * @return void
	 */
	public function setAnzbestanden($anzbestanden) {
		$this->anzbestanden = $anzbestanden;
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
	
	/**
	 * Returns the institutionsartart
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 */
	public function getInstitutionsartart() {
		return $this->institutionsartart;
	}

	/**
	 * Sets the institutionsartart
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart
	 * @return void
	 */
	public function setInstitutionsartart(Tx_Blsvsa2013_Domain_Model_Institutionsartart $institutionsartart) {
		$this->institutionsartart = $institutionsartart;
	}

	
	/**
	 * Setzt die felder anzschueler, anzteilnahmeberechtigt, anzbestanden
	 * 
	 * @param Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $repSchueler
	 * @param Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen
	 */
	public function setStatistik(Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $repSchueler, Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen){
		$this->setAnzschueler($repSchueler->getAnzahl($this->getSchulnummer()));
		$this->setAnzteilnahmeberechtigt($repTeilnahmen->getAnzahl($this->getSchulnummer()));
		$this->setAnzbestanden($repTeilnahmen->getAnzahlBestanden($this->getSchulnummer()));
	}
	
	/**
	 * Returns the UrkundenStatus
	 *
	 * @return integer $urkundenStatus
	 */
	public function getUrkundenStatus() {
		if ($this->anzbestanden > 0){
			$urkundenStatus = 1;
		}
		// nicht bestanden 
		else {
			if ($this->tstamp > 0){
				$urkundenStatus = 2;
			} else {
				$urkundenStatus = 3;
			}
		}
		return $urkundenStatus;		
	}
	
}
?>