<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Berti Golf <berti.golf@blsv.de>, BLSV
 *  Martin Gonschor <martin.gonschOr@blsv.de>, blsv
 *  
 *  All rights reservedetUid
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
class Tx_Blsvsa2013_Domain_Model_Teilnahmen extends Tx_Extbase_DomainObject_AbstractEntity {

	
	/**
	 * uid
	 *
	 * @uid integer
	 * @validate NotEmpty
	 */
	//protected $uid=0;
	protected $uid;
	
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
	protected $geschlecht=1;

	/**
	 * Geburtstag
	 *
	 * @var integer
	 */
	protected $geburtstag=0;

	/**
	 * Anzahl Teilnahmen
	 *
	 * @var integer
	 */
	protected $anzteilnahmen=1;

	/**
	 * Punkte gesamt
	 *
	 * @var integer
	 */
	protected $punktegesamt=0;

	/**
	 * Urkundenart
	 *
	 * @var integer
	 */
	protected $urkundenart=0;

	/**
	 * gedruckt
	 *
	 * @var integer
	 */
	protected $gedruckt=0;

	/**
	 * Drucktimestamp
	 *
	 * @var integer
	 */
	protected $drucktstamp=0;

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
	protected $grundschulwettbewerb=0;

	/**
	 * gültig bis
	 *
	 * @var integer
	 */
	protected $schwimmnachweisgueltigbis=0;

	/**
	 * Leistung Gruppe 1
	 *
	 * @var integer
	 */
	protected $leistung1=0;

	/**
	 * Ablagedatum Gruppe 1
	 *
	 * @var integer
	 */
	protected $ablagedatum1=0;

	/**
	 * Prüfer Gruppe 1
	 *
	 * @var integer
	 */
	protected $pruefer1=0;

	/**
	 * Ergebnis Gruppe 1
	 *
	 * @var integer
	 */
	protected $ergebnis1=0;

	/**
	 * Punkte Gruppe 1
	 *
	 * @var integer
	 */
	protected $punkte1=0;

	/**
	 * Leistung Gruppe 2
	 *
	 * @var integer
	 */
	protected $leistung2=0;

	/**
	 * Ablagedatum Gruppe 2
	 *
	 * @var integer
	 */
	protected $ablagedatum2=0;

	/**
	 * Prüfer Gruppe 2
	 *
	 * @var integer
	 */
	protected $pruefer2=0;

	/**
	 * Ergebnis Gruppe 2
	 *
	 * @var integer
	 */
	protected $ergebnis2=0;

	/**
	 * Punkte Gruppe 2
	 *
	 * @var integer
	 */
	protected $punkte2=0;

	/**
	 * Leistung Gruppe 3
	 *
	 * @var integer
	 */
	protected $leistung3=0;

	/**
	 * Ablagedatum Gruppe 3
	 *
	 * @var integer
	 */
	protected $ablagedatum3=0;

	/**
	 * Pr�fer Gruppe 3
	 *
	 * @var integer
	 */
	protected $pruefer3=0;

	/**
	 * Ergebnis Gruppe 3
	 *
	 * @var integer
	 */
	protected $ergebnis3=0;

	/**
	 * Punkte Gruppe 3
	 *
	 * @var integer
	 */
	protected $punkte3=0;

	/**
	 * Leistung Gruppe 4
	 *
	 * @var integer
	 */
	protected $leistung4=0;

	/**
	 * Ablagedatum Gruppe 4
	 *
	 * @var integer
	 */
	protected $ablagedatum4=0;

	/**
	 * Prüfer Gruppe 4
	 *
	 * @var integer
	 */
	protected $pruefer4=0;

	/**
	 * Ergebnis Gruppe 4
	 *
	 * @var integer
	 */
	protected $ergebnis4=0;

	/**
	 * Punkte Gruppe 4
	 *
	 * @var integer
	 */
	protected $punkte4=0;

	/**
	 * Jahr der Prüfung
	 *
	 * @var integer
	 */
	protected $pruefungsjahr=0;

	/**
	 * Schule
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schulen
	 */
	protected $schule;
	
	/**
	 * Schulnummer
	 *
	 * @var string
	 */
	protected $schulnummer='0';

	/**
	 * Leistungstabelle 1
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistungstabelle1;

	/**
	 * Leistungstabelle 2
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistungstabelle2;

	/**
	 * Leistungstabelle 3
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistungstabelle3;

	/**
	 * Leistungstabelle 4
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Leistungstabelle
	 * @lazy
	 */
	protected $leistungstabelle4;

	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Feusers
	 * @lazy
	 */
	protected $feuser;

	/**
	 * fe_user
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Schueler
	 * @lazy
	 */
	protected $schueler;

	/**
	 * bestellung
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Bestellung
	 */
	protected $bestellung;
	
	
	
	/**
	 * Sets the uid
	 *
	 * @param integer $uid
	 * @return void
	 */
	public function setUid( $uid  ) {
		$this->uid = $uid;
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
	 * Returns the leistung1
	 *
	 * @return integer $leistung1
	 */
	public function getLeistung1() {
		return $this->leistung1;
	}

	/**
	 * Sets the leistung1
	 *
	 * @param integer $leistung1
	 * @return void
	 */
	public function setLeistung1($leistung1) {
		$this->leistung1 = $leistung1;
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
	 * Returns the leistung2
	 *
	 * @return integer $leistung2
	 */
	public function getLeistung2() {
		return $this->leistung2;
	}

	/**
	 * Sets the leistung2
	 *
	 * @param integer $leistung2
	 * @return void
	 */
	public function setLeistung2($leistung2) {
		$this->leistung2 = $leistung2;
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
	 * Returns the leistung3
	 *
	 * @return integer $leistung3
	 */
	public function getLeistung3() {
		return $this->leistung3;
	}

	/**
	 * Sets the leistung3
	 *
	 * @param integer $leistung3
	 * @return void
	 */
	public function setLeistung3($leistung3) {
		$this->leistung3 = $leistung3;
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
	 * Returns the leistung4
	 *
	 * @return integer $leistung4
	 */
	public function getLeistung4() {
		return $this->leistung4;
	}

	/**
	 * Sets the leistung4
	 *
	 * @param integer $leistung4
	 * @return void
	 */
	public function setLeistung4($leistung4) {
		$this->leistung4 = $leistung4;
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
	 * Returns the pruefungsjahr
	 *
	 * @return integer $pruefungsjahr
	 */
	public function getPruefungsjahr() {
		return $this->pruefungsjahr;
	}

	/**
	 * Sets the pruefungsjahr
	 *
	 * @param integer $pruefungsjahr
	 * @return void
	 */
	public function setPruefungsjahr($pruefungsjahr) {
		$this->pruefungsjahr = $pruefungsjahr;
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
	 * Returns the leistungstabelle1
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle1
	 */
	public function getLeistungstabelle1() {
		return $this->leistungstabelle1;
	}

	/**
	 * Sets the leistungstabelle1
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle1
	 * @return void
	 */
	public function setLeistungstabelle1(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle1) {
		$this->leistungstabelle1 = $leistungstabelle1;
	}

	/**
	 * Returns the leistungstabelle2
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle2
	 */
	public function getLeistungstabelle2() {
		return $this->leistungstabelle2;
	}

	/**
	 * Sets the leistungstabelle2
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle2
	 * @return void
	 */
	public function setLeistungstabelle2(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle2) {
		$this->leistungstabelle2 = $leistungstabelle2;
	}

	/**
	 * Returns the leistungstabelle3
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle3
	 */
	public function getLeistungstabelle3() {
		return $this->leistungstabelle3;
	}

	/**
	 * Sets the leistungstabelle3
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle3
	 * @return void
	 */
	public function setLeistungstabelle3(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle3) {
		$this->leistungstabelle3 = $leistungstabelle3;
	}

	/**
	 * Returns the leistungstabelle4
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle4
	 */
	public function getLeistungstabelle4() {
		return $this->leistungstabelle4;
	}

	/**
	 * Sets the leistungstabelle4
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle4
	 * @return void
	 */
	public function setLeistungstabelle4(Tx_Blsvsa2013_Domain_Model_Leistungstabelle $leistungstabelle4) {
		$this->leistungstabelle4 = $leistungstabelle4;
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
	 * Returns the schueler
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Schueler $schueler
	 */
	public function getSchueler() {
		return $this->schueler;
	}

	/**
	 * Sets the schueler
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $schueler
	 * @return void
	 */
	public function setSchueler(Tx_Blsvsa2013_Domain_Model_Schueler $schueler) {
		$this->schueler = $schueler;
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
	 * Returns the schulnummer
	 *
	 * @return string $schulnummer
	 */
	public function getSchulnummer() {
		return $this->schulnummer;
	}

	/**
	 * liefert Info, ob ein Schwimmnachweis vorliegt
	 *
	 * @return integer $schwimmnachweis
	 */
	public function getSchwimmnachweis() {
		$schwimmnachweis = 2;
		if ( $this->schwimmnachweisgueltigbis >= time() ) {
			$schwimmnachweis = 1;
		}
		return $schwimmnachweis;
	}
	
	/**
	 * setzt Schwimmnachweis in Abhaengigkeit vom Alter/aktuellen Jahr
	 *  falls unter 18, dann Jahresende 18. Geburtstag
	 *  sonst 5 Jahre Gueltigkeit, d.h. Jahresende von aktuelles Jahr + 4
	 *
	 * @param integer $schwimmnachweis
	 * @return void
	 */
	public function setSchwimmnachweis($schwimmnachweis) {
		$gebJahr = date('Y', $this->getGeburtstag());
		$aktJahr = date('Y');
		$alter = $aktJahr - $gebJahr;
		if ($alter < 18 ){
			$ts = mktime(23, 59, 59, 12, 31, $gebJahr + 18);
		} else {
			
			$ts = mktime(23, 59, 59, 12, 31, $aktJahr + 4);
		}
		$this->setSchwimmnachweisgueltigbis($ts);
	}

	/**
	 * liefert laufende Nummer fuer Urkunden
	 *
	 * @return string $lfdnr
	 */
	public function getUrkundenLfdnr() {
		$lfdnr = $this->schule->getUid().'-'.$this->getUid();
		return $lfdnr;
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
	
}
?>