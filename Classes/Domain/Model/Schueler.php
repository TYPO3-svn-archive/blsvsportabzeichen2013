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
	 * @validate NotEmpty
	 */
	protected $vorname;

	/**
	 * Name
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;

	/**
	 * Geschlecht
	 *
	 * @var integer
	 */
	protected $geschlecht;

	/**
	 * Geburtstag
	 *
	 * @var integer
	 */
	protected $geburtstag;

	/**
	 * Anzahl Teilnahmen
	 *
	 * @var integer
	 */
	protected $anzteilnahmen;

	/**
	 * Punkte gesamt
	 *
	 * @var integer
	 */
	protected $punktegesamt;

	/**
	 * Urkundenart
	 *
	 * @var integer
	 */
	protected $urkundenart;

	/**
	 * gedruckt
	 *
	 * @var integer
	 */
	protected $gedruckt;

	/**
	 * Drucktimestamp
	 *
	 * @var integer
	 */
	protected $drucktstamp;

	/**
	 * Klasse
	 *
	 * @var string
	 */
	protected $klasse;

	/**
	 * Grundschulwettbewerb
	 *
	 * @var integer
	 */
	protected $grundschulwettbewerb;

	/**
	 * Schwimmnachweis
	 *
	 * @var boolean
	 */
	protected $schwimmnachweis = FALSE;

	/**
	 * gültig bis
	 *
	 * @var integer
	 */
	protected $gueltigbis;

	/**
	 * Leistungstabelle Gruppe 1
	 *
	 * @var integer
	 */
	protected $leistungstabelle1;

	/**
	 * Ablagedatum Gruppe 1
	 *
	 * @var integer
	 */
	protected $ablagedatum1;

	/**
	 * Prüfer Gruppe 1
	 *
	 * @var integer
	 */
	protected $pruefer1;

	/**
	 * Ergebnis Gruppe 1
	 *
	 * @var integer
	 */
	protected $ergebnis1;

	/**
	 * Punkte Gruppe 1
	 *
	 * @var integer
	 */
	protected $punkte1;

	/**
	 * Leistungstabelle Gruppe 2
	 *
	 * @var integer
	 */
	protected $leistungstabelle2;

	/**
	 * Ablagedatum Gruppe 2
	 *
	 * @var integer
	 */
	protected $ablagedatum2;

	/**
	 * Prüfer Gruppe 2
	 *
	 * @var integer
	 */
	protected $pruefer2;

	/**
	 * Ergebnis Gruppe 2
	 *
	 * @var integer
	 */
	protected $ergebnis2;

	/**
	 * Punkte Gruppe 2
	 *
	 * @var integer
	 */
	protected $punkte2;

	/**
	 * Leistungstabelle Gruppe 3
	 *
	 * @var integer
	 */
	protected $leistungstabelle3;

	/**
	 * Ablagedatum Gruppe 3
	 *
	 * @var integer
	 */
	protected $ablagedatum3;

	/**
	 * Prüfer Gruppe 3
	 *
	 * @var integer
	 */
	protected $pruefer3;

	/**
	 * Ergebnis Gruppe 3
	 *
	 * @var integer
	 */
	protected $ergebnis3;

	/**
	 * Punkte Gruppe 3
	 *
	 * @var integer
	 */
	protected $punkte3;

	/**
	 * Leistungstabelle Gruppe 4
	 *
	 * @var integer
	 */
	protected $leistungstabelle4;

	/**
	 * Ablagedatum Gruppe 4
	 *
	 * @var integer
	 */
	protected $ablagedatum4;

	/**
	 * Prüfer Gruppe 4
	 *
	 * @var integer
	 */
	protected $pruefer4;

	/**
	 * Ergebnis Gruppe 4
	 *
	 * @var integer
	 */
	protected $ergebnis4;

	/**
	 * Punkte Gruppe 4
	 *
	 * @var integer
	 */
	protected $punkte4;

	/**
	 * Schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule;

	/**
	 * Leistung 1
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistung1;

	/**
	 * Leistung 2
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistung2;

	/**
	 * Leistung 3
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistung3;

	/**
	 * Leistung 4
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistung4;

	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feuser
	 * @lazy
	 */
	protected $feuser;

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
	 * Returns the punktegesamt
	 *
	 * @return integer $punktegesamt
	 */
	public function getPunktegesamt() {
		return $this->punktegesamt;
	}

	/**
	 * Sets the punktegesamt
	 *
	 * @param integer $punktegesamt
	 * @return void
	 */
	public function setPunktegesamt($punktegesamt) {
		$this->punktegesamt = $punktegesamt;
	}

	/**
	 * Returns the urkundenart
	 *
	 * @return integer $urkundenart
	 */
	public function getUrkundenart() {
		return $this->urkundenart;
	}

	/**
	 * Sets the urkundenart
	 *
	 * @param integer $urkundenart
	 * @return void
	 */
	public function setUrkundenart($urkundenart) {
		$this->urkundenart = $urkundenart;
	}

	/**
	 * Returns the gedruckt
	 *
	 * @return integer $gedruckt
	 */
	public function getGedruckt() {
		return $this->gedruckt;
	}

	/**
	 * Sets the gedruckt
	 *
	 * @param integer $gedruckt
	 * @return void
	 */
	public function setGedruckt($gedruckt) {
		$this->gedruckt = $gedruckt;
	}

	/**
	 * Returns the drucktstamp
	 *
	 * @return integer $drucktstamp
	 */
	public function getDrucktstamp() {
		return $this->drucktstamp;
	}

	/**
	 * Sets the drucktstamp
	 *
	 * @param integer $drucktstamp
	 * @return void
	 */
	public function setDrucktstamp($drucktstamp) {
		$this->drucktstamp = $drucktstamp;
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
	 * @return integer $grundschulwettbewerb
	 */
	public function getGrundschulwettbewerb() {
		return $this->grundschulwettbewerb;
	}

	/**
	 * Sets the grundschulwettbewerb
	 *
	 * @param integer $grundschulwettbewerb
	 * @return void
	 */
	public function setGrundschulwettbewerb($grundschulwettbewerb) {
		$this->grundschulwettbewerb = $grundschulwettbewerb;
	}

	/**
	 * Returns the schwimmnachweis
	 *
	 * @return boolean $schwimmnachweis
	 */
	public function getSchwimmnachweis() {
		return $this->schwimmnachweis;
	}

	/**
	 * Sets the schwimmnachweis
	 *
	 * @param boolean $schwimmnachweis
	 * @return void
	 */
	public function setSchwimmnachweis($schwimmnachweis) {
		$this->schwimmnachweis = $schwimmnachweis;
	}

	/**
	 * Returns the boolean state of schwimmnachweis
	 *
	 * @return boolean
	 */
	public function isSchwimmnachweis() {
		return $this->getSchwimmnachweis();
	}

	/**
	 * Returns the gueltigbis
	 *
	 * @return integer $gueltigbis
	 */
	public function getGueltigbis() {
		return $this->gueltigbis;
	}

	/**
	 * Sets the gueltigbis
	 *
	 * @param integer $gueltigbis
	 * @return void
	 */
	public function setGueltigbis($gueltigbis) {
		$this->gueltigbis = $gueltigbis;
	}

	/**
	 * Returns the leistungstabelle1
	 *
	 * @return integer $leistungstabelle1
	 */
	public function getLeistungstabelle1() {
		return $this->leistungstabelle1;
	}

	/**
	 * Sets the leistungstabelle1
	 *
	 * @param integer $leistungstabelle1
	 * @return void
	 */
	public function setLeistungstabelle1($leistungstabelle1) {
		$this->leistungstabelle1 = $leistungstabelle1;
	}

	/**
	 * Returns the ablagedatum1
	 *
	 * @return integer $ablagedatum1
	 */
	public function getAblagedatum1() {
		return $this->ablagedatum1;
	}

	/**
	 * Sets the ablagedatum1
	 *
	 * @param integer $ablagedatum1
	 * @return void
	 */
	public function setAblagedatum1($ablagedatum1) {
		$this->ablagedatum1 = $ablagedatum1;
	}

	/**
	 * Returns the pruefer1
	 *
	 * @return integer $pruefer1
	 */
	public function getPruefer1() {
		return $this->pruefer1;
	}

	/**
	 * Sets the pruefer1
	 *
	 * @param integer $pruefer1
	 * @return void
	 */
	public function setPruefer1($pruefer1) {
		$this->pruefer1 = $pruefer1;
	}

	/**
	 * Returns the ergebnis1
	 *
	 * @return integer $ergebnis1
	 */
	public function getErgebnis1() {
		return $this->ergebnis1;
	}

	/**
	 * Sets the ergebnis1
	 *
	 * @param integer $ergebnis1
	 * @return void
	 */
	public function setErgebnis1($ergebnis1) {
		$this->ergebnis1 = $ergebnis1;
	}

	/**
	 * Returns the punkte1
	 *
	 * @return integer $punkte1
	 */
	public function getPunkte1() {
		return $this->punkte1;
	}

	/**
	 * Sets the punkte1
	 *
	 * @param integer $punkte1
	 * @return void
	 */
	public function setPunkte1($punkte1) {
		$this->punkte1 = $punkte1;
	}

	/**
	 * Returns the leistungstabelle2
	 *
	 * @return integer $leistungstabelle2
	 */
	public function getLeistungstabelle2() {
		return $this->leistungstabelle2;
	}

	/**
	 * Sets the leistungstabelle2
	 *
	 * @param integer $leistungstabelle2
	 * @return void
	 */
	public function setLeistungstabelle2($leistungstabelle2) {
		$this->leistungstabelle2 = $leistungstabelle2;
	}

	/**
	 * Returns the ablagedatum2
	 *
	 * @return integer $ablagedatum2
	 */
	public function getAblagedatum2() {
		return $this->ablagedatum2;
	}

	/**
	 * Sets the ablagedatum2
	 *
	 * @param integer $ablagedatum2
	 * @return void
	 */
	public function setAblagedatum2($ablagedatum2) {
		$this->ablagedatum2 = $ablagedatum2;
	}

	/**
	 * Returns the pruefer2
	 *
	 * @return integer $pruefer2
	 */
	public function getPruefer2() {
		return $this->pruefer2;
	}

	/**
	 * Sets the pruefer2
	 *
	 * @param integer $pruefer2
	 * @return void
	 */
	public function setPruefer2($pruefer2) {
		$this->pruefer2 = $pruefer2;
	}

	/**
	 * Returns the ergebnis2
	 *
	 * @return integer $ergebnis2
	 */
	public function getErgebnis2() {
		return $this->ergebnis2;
	}

	/**
	 * Sets the ergebnis2
	 *
	 * @param integer $ergebnis2
	 * @return void
	 */
	public function setErgebnis2($ergebnis2) {
		$this->ergebnis2 = $ergebnis2;
	}

	/**
	 * Returns the punkte2
	 *
	 * @return integer $punkte2
	 */
	public function getPunkte2() {
		return $this->punkte2;
	}

	/**
	 * Sets the punkte2
	 *
	 * @param integer $punkte2
	 * @return void
	 */
	public function setPunkte2($punkte2) {
		$this->punkte2 = $punkte2;
	}

	/**
	 * Returns the leistungstabelle3
	 *
	 * @return integer $leistungstabelle3
	 */
	public function getLeistungstabelle3() {
		return $this->leistungstabelle3;
	}

	/**
	 * Sets the leistungstabelle3
	 *
	 * @param integer $leistungstabelle3
	 * @return void
	 */
	public function setLeistungstabelle3($leistungstabelle3) {
		$this->leistungstabelle3 = $leistungstabelle3;
	}

	/**
	 * Returns the ablagedatum3
	 *
	 * @return integer $ablagedatum3
	 */
	public function getAblagedatum3() {
		return $this->ablagedatum3;
	}

	/**
	 * Sets the ablagedatum3
	 *
	 * @param integer $ablagedatum3
	 * @return void
	 */
	public function setAblagedatum3($ablagedatum3) {
		$this->ablagedatum3 = $ablagedatum3;
	}

	/**
	 * Returns the pruefer3
	 *
	 * @return integer $pruefer3
	 */
	public function getPruefer3() {
		return $this->pruefer3;
	}

	/**
	 * Sets the pruefer3
	 *
	 * @param integer $pruefer3
	 * @return void
	 */
	public function setPruefer3($pruefer3) {
		$this->pruefer3 = $pruefer3;
	}

	/**
	 * Returns the ergebnis3
	 *
	 * @return integer $ergebnis3
	 */
	public function getErgebnis3() {
		return $this->ergebnis3;
	}

	/**
	 * Sets the ergebnis3
	 *
	 * @param integer $ergebnis3
	 * @return void
	 */
	public function setErgebnis3($ergebnis3) {
		$this->ergebnis3 = $ergebnis3;
	}

	/**
	 * Returns the punkte3
	 *
	 * @return integer $punkte3
	 */
	public function getPunkte3() {
		return $this->punkte3;
	}

	/**
	 * Sets the punkte3
	 *
	 * @param integer $punkte3
	 * @return void
	 */
	public function setPunkte3($punkte3) {
		$this->punkte3 = $punkte3;
	}

	/**
	 * Returns the leistungstabelle4
	 *
	 * @return integer $leistungstabelle4
	 */
	public function getLeistungstabelle4() {
		return $this->leistungstabelle4;
	}

	/**
	 * Sets the leistungstabelle4
	 *
	 * @param integer $leistungstabelle4
	 * @return void
	 */
	public function setLeistungstabelle4($leistungstabelle4) {
		$this->leistungstabelle4 = $leistungstabelle4;
	}

	/**
	 * Returns the ablagedatum4
	 *
	 * @return integer $ablagedatum4
	 */
	public function getAblagedatum4() {
		return $this->ablagedatum4;
	}

	/**
	 * Sets the ablagedatum4
	 *
	 * @param integer $ablagedatum4
	 * @return void
	 */
	public function setAblagedatum4($ablagedatum4) {
		$this->ablagedatum4 = $ablagedatum4;
	}

	/**
	 * Returns the pruefer4
	 *
	 * @return integer $pruefer4
	 */
	public function getPruefer4() {
		return $this->pruefer4;
	}

	/**
	 * Sets the pruefer4
	 *
	 * @param integer $pruefer4
	 * @return void
	 */
	public function setPruefer4($pruefer4) {
		$this->pruefer4 = $pruefer4;
	}

	/**
	 * Returns the ergebnis4
	 *
	 * @return integer $ergebnis4
	 */
	public function getErgebnis4() {
		return $this->ergebnis4;
	}

	/**
	 * Sets the ergebnis4
	 *
	 * @param integer $ergebnis4
	 * @return void
	 */
	public function setErgebnis4($ergebnis4) {
		$this->ergebnis4 = $ergebnis4;
	}

	/**
	 * Returns the punkte4
	 *
	 * @return integer $punkte4
	 */
	public function getPunkte4() {
		return $this->punkte4;
	}

	/**
	 * Sets the punkte4
	 *
	 * @param integer $punkte4
	 * @return void
	 */
	public function setPunkte4($punkte4) {
		$this->punkte4 = $punkte4;
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
	 * Returns the leistung1
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung1
	 */
	public function getLeistung1() {
		return $this->leistung1;
	}

	/**
	 * Sets the leistung1
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung1
	 * @return void
	 */
	public function setLeistung1(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung1) {
		$this->leistung1 = $leistung1;
	}

	/**
	 * Returns the leistung2
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung2
	 */
	public function getLeistung2() {
		return $this->leistung2;
	}

	/**
	 * Sets the leistung2
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung2
	 * @return void
	 */
	public function setLeistung2(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung2) {
		$this->leistung2 = $leistung2;
	}

	/**
	 * Returns the leistung3
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung3
	 */
	public function getLeistung3() {
		return $this->leistung3;
	}

	/**
	 * Sets the leistung3
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung3
	 * @return void
	 */
	public function setLeistung3(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung3) {
		$this->leistung3 = $leistung3;
	}

	/**
	 * Returns the leistung4
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung4
	 */
	public function getLeistung4() {
		return $this->leistung4;
	}

	/**
	 * Sets the leistung4
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung4
	 * @return void
	 */
	public function setLeistung4(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistung4) {
		$this->leistung4 = $leistung4;
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