<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Martin Gonschor <gonschor@blsv.de>, BLSV
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
class Tx_Blsvsa2013_Service_SchuelerImport {
	var $tbl_schueler = 'tx_blsvsa2013_domain_model_schueler';
	var $errors = null;
	var $good = null;
	var $bad = null;
	var $extensionName = 'Blsvsa2013';
	
	/**
	 * Umwandeln des Schuelerstrings in einen Schuelerarray
	 *
	 * @param string $sstring csv-String
	 * @return array Ergebnisarray mit good=Schuelerliste, bad=Fehlerliste, anzahl=Anzahl der Zeilen)
	 */
	function getSchuelerArray($sstring) {
		// Zeichen im String ersetzen
		$ersetzungen = array(
				"\r\n" => "\n",

				'"' => '',
				"'" => '',

				';' =>	',',
				'|' =>	',',
				"\t" =>	',',
		);
		$suchfelder = array(); $ersetzfelder = array();
		foreach($ersetzungen as $suchfeld => $ersetzfeld)	{
			$suchfelder[] = $suchfeld; $ersetzfelder[] = $ersetzfeld;
		}
		$sstring = stripslashes($sstring);
		$sstring = str_replace($suchfelder, $ersetzfelder, $sstring);

		// String in Zeilen aufteilen
		$sarray = explode("\n", $sstring);

		// Import Funktion mit Hilfe der Spaltenanzahl bestimmen
		$import_func = $this->getImportFunc($sarray[0]);

		// Zeilen interpretieren
		$this->good = array();
		$this->bad = array();
		foreach($sarray as $szeile) {
			if (!empty($szeile)) {
				$count++;
				$sdaten = array();
				if ($this->$import_func($szeile, $sdaten) == true) {
					$this->good[] = $sdaten;
				} else {
					$this->bad[] = $sdaten;
				}
			}
		}

		if (!empty($this->bad)){
			$res = -1;	// -1: Fehler
		} else if (!empty($this->good)){
			$res = 1;	// 1: kein Fehler
		} else {
			$res = 0;	// 0: keine Daten
		}
		return $res;
	}

	/**
	 * Import Funktion bestimmen
	 *
	 * @param array $sarray Array mit erster Spalte
	 * @return string $import_func Importfunktion
	 */
	function getImportFunc($sarray) {
		$spalten = count(explode(',', $sarray));
		switch ($spalten) {
			case 9:   //BJS
				$import_func = 'getSchuelerZeileBJS';
				break;
			case 6:  //mit  Anzpr�fungen
				$import_func = 'getSchuelerZeileBestanden';
				break;
			default:
				$import_func = 'getSchuelerZeile';
		}
		return $import_func;
	}

	
	function setError($fehler, $errorName, $params=null){
		$fehler[$errorName] = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_schuelerimport.error_' . $errorName, $this->extensionName, $params);
		return $fehler;
	}
	
	/**
	 * csv-Zeile mit einem Schueler in einen Array umwandeln
	 *
	 * @param string $szeile csv-Zeile mit Daten
	 * @param  $sdaten Array mit Daten (umgewandelte Zeile)
	 * @return boolean true wenn ok, false wenn Fehler
	 */
	function getSchuelerZeile($szeile, &$sdaten) {
		$fehler = array();
		$sdaten0 = explode(',', $szeile);

		$count = count($sdaten0);
		if ($count!=5)	{
			if ($count>5) {
				$fehler = $this->setError($fehler, 'tooManyFields');
			} else {
				$fehler = $this->setError($fehler, 'tooLessFields');
			}
		} else {
			$sdaten = array(
					'vorname' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, 'field_firstname')),
					'name' => trim($this->getSchuelerFeldText($sdaten0[1], $fehler, 'field_lastname')),
					'geburtstag' => trim($this->getSchuelerFeldDatum($sdaten0[2], $fehler)),
					'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[3], $fehler)),
					'klasse' => trim($this->getSchuelerFeldText($sdaten0[4], $fehler, 'field_class')),
			);
			$this->getSchuelerFeldAltersgruppe($sdaten['geburtstag'], $sdaten['geschlecht'], $fehler);
		}
			
		if (!empty($fehler)) {
			$sdaten = array(
					'zeile' => htmlentities($szeile),
					'fehler' => $fehler
			);
			return $false;
		}
		return true;
	}

	/**
	 * csv-Zeile mit einem Schueler in einen Array umwandeln
	 *
	 * @param string $szeile csv-Zeile mit Daten
	 * @param  $sdaten Array mit Daten (umgewandelte Zeile)
	 * @return boolean true wenn ok, false wenn Fehler
	 */
	function getSchuelerZeileBestanden($szeile, &$sdaten) {
		$fehler = array();
		$sdaten0 = explode(',', $szeile);

		$count = count($sdaten0);
		if ($count!=6)	{
			if ($count>6) {
				$fehler = $this->setError($fehler, 'tooManyFields');
			} else {
				$fehler = $this->setError($fehler, 'tooLessFields');
			}
		} else {
			$sdaten = array(
					'vorname' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, 'field_firstname')),
					'name' => trim($this->getSchuelerFeldText($sdaten0[1], $fehler, 'field_lastname')),
					'geburtstag' => trim($this->getSchuelerFeldDatum($sdaten0[2], $fehler)),
					'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[3], $fehler)),
					'klasse' => trim($this->getSchuelerFeldText($sdaten0[4], $fehler, 'field_class')),
					'punktegesamt' => 4,
					'anz_teilnahmen' => trim($this->getSchuelerFeldText($sdaten0[5], $fehler, 'field_anz_teilnahmen'))
			);
			$this->getSchuelerFeldAltersgruppe($sdaten['geburtstag'], $sdaten['geschlecht'], $fehler);
		}
			
		if (!empty($fehler)) {
			$sdaten = array(
					'zeile' => htmlentities($szeile),
					'fehler' => $fehler
			);
			return $false;
		}
		return true;
	}
	/**
	 * csv-Zeile mit einem Schueler in einen Array umwandeln (BJS Format)
	 *
	 * @since 2010-04-27
	 * @param string $szeile csv-Zeile mit Daten
	 * @param  $sdaten Array mit Daten (umgewandelte Zeile)
	 * @return boolean true wenn ok, false wenn Fehler
	 */
	function getSchuelerZeileBJS($szeile, &$sdaten) {
		$fehler = array();
		$sdaten0 = explode(',', $szeile);

		$count = count($sdaten0);
		if ($count!=9)	{
			if ($count>9) {
				$fehler = $this->setError($fehler, 'tooManyFields');
			} else {
				$fehler = $this->setError($fehler, 'tooLessFields');
			}
		} else {
			$nachname = array(
					trim($sdaten0[3]), // Zusatz davor
					trim($this->getSchuelerFeldText($sdaten0[1], $fehler, 'field_lastname')), // Name
					trim($sdaten0[4]) // Zusatz dahinter
			);

			$sdaten = array(
					'vorname' => trim($this->getSchuelerFeldText($sdaten0[2], $fehler, 'field_firstname')),
					'name' => trim(implode(' ', $nachname)),
					'geburtstag' => trim($this->getSchuelerFeldDatum($sdaten0[5], $fehler)),
					'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[6], $fehler)),
					'klasse' => trim($this->getSchuelerFeldText($sdaten0[7], $fehler, 'field_class')),
			);
			$this->getSchuelerFeldAltersgruppe($sdaten['geburtstag'], $sdaten['geschlecht'], $fehler);
		}
			
		if (!empty($fehler)) {
			$sdaten = array(
					'zeile' => htmlentities($szeile),
					'fehler' => $fehler
			);
			return $false;
		}
		return true;
	}

	/**
	 * Inhalt des csv-Feldes als Text holen
	 * - das Feld darf nicht leer sein
	 *
	 * @param string $text Feldinhalt
	 * @param array $fehler Array mit Fehlern
	 * @return $erg Feldinhalt
	 */
	function getSchuelerFeldText($text, &$fehler='', $feld='') {
		$erg = '';
		if (empty($text)) {
			$fehler = $this->setError($fehler, 'empty_'. (!empty($feld)?$feld:'field'));
		} else {
			$erg = $text;
		}
		return $erg;
	}

	/**
	 * Inhalt des csv-Feldes als Datums-Timestamp interpretieren
	 *
	 * @param string $datum Datumsfeld
	 * @param array $fehler Array mit Fehlern
	 * @return $erg_datum Datums-Timestamp
	 */
	function getSchuelerFeldDatum($datum, &$fehler='') {
		$erg_datum = '';


		// Jahreszahl zu Datum ergaenzen
		if (preg_match('/^([0-9]{4})$/', $datum, $darr))
		{
			$datum = "01.01.$datum";
		}

		if (preg_match('/([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2,4})/', $datum, $darr))
		{
			// zweistellige Jahreszahl zu vierstelliger ergaenzen
			if ($darr[3]<100) {
				// <30 => 20xx
				if ($darr[3]<30) {
					$darr[3] += 2000;
				}
				// >=30 => 19xx
				else {
					$darr[3] += 1900;
				}
			}

			// vierstelliges Datum pruefen
			if (($darr[3]< 1900) || ($darr[3]>=date('Y')) || (checkdate($darr[2], $darr[1], $darr[3])==false)) {
				$fehler = $this->setError($fehler, 'datum', array($datum));
			}

			$erg_datum = mktime(12,0,0,$darr[2],$darr[1],$darr[3]);
		} else {
			$fehler = $this->setError($fehler, 'datum', array($datum));
		}

		return $erg_datum;
	}

	/**
	 * Inhalt des csv-Feldes als Geschlecht interpretieren
	 *
	 * @param string $geschlecht Feld mit Geschlechtsbezeichnung
	 * @param array $fehler Array mit Fehlern
	 * @return $erg_geschlecht Geschlecht (m=>1, w=>2)
	 */
	function getSchuelerFeldGeschlecht($geschlecht, &$fehler) {
		$geschlecht = trim(strtolower($geschlecht));

		$weiblich = array('w', 'f', 'weibl', 'weiblich', 2);
		$maennlich = array('m', 'maennl', 'maennlich', 1);

		$erg_geschlecht = 0;
		if (in_array($geschlecht, $weiblich)) {
			$erg_geschlecht = 2;
		} else if (in_array($geschlecht, $maennlich)) {
			$erg_geschlecht = 1;
		} else {
			$fehler = $this->setError($fehler, 'geschlecht', array($geschlecht));
		}
		return $erg_geschlecht;
	}
	
	/**
	 * 
	 * @param integer $geburtstag Geburtstag
	 * @param integer $geschlecht Geschlecht
	 * @param array $fehler Array mit Fehlern
	 * @return integer $erg_altersgruppe
	 */
	function getSchuelerFeldAltersgruppe($geburtstag, $geschlecht, &$fehler){
		$repAltersgruppen = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository');
		$objAltersgruppe = $repAltersgruppen->getByGeburtstagAndGeschlecht($geburtstag, $geschlecht);
		if (!$objAltersgruppe) {
			$fehler = $this->setError($fehler, 'altersgruppe', array(date('d.m.Y', $geburtstag), $geschlecht));
			$erg_altersgruppe = 0;
		} else {
			$erg_altersgruppe = $objAltersgruppe->getUid();
		}
		return $erg_altersgruppe;
	}


	/**
	 * Schuelerobjekt aus Array erzeugen
	 *
	 * @param array $schuelerArr Array mit Schueler
	 * @param Tx_Blsvsa2013_Domain_Model_Feusers $objFeuser aktueller Bearbeiter
	 * @return array
	 */
/*	
	function getSchuelers($schuelerArr, $objFeuser, $schule) {

		$schuelers = array();
		foreach($schuelerArr as $key=>$schueler){
			// t3lib_utility_Debug::debug($schueler, 'schueler');
			if(!empty($schueler)) {
				$newSchueler = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Schueler');
				$newSchueler->setFeuser($objFeuser);
				$newSchueler->setVorname($schueler['vorname']);
				$newSchueler->setName($schueler['name']);
				$newSchueler->setGeburtstag($schueler['geburtstag']);
				$newSchueler->setGeschlecht($schueler['geschlecht']);
				$newSchueler->setKlasse($schueler['klasse']);
				//				$newSchueler->setPunktegesamt(isset($schueler['punktegesamt']) ? $schueler['punktegesamt']:0);

				$newSchueler->setSchule($schule);
				$newSchueler->setSchulnummer($schule->getSchulnummer());

				$newSchueler->setAnzteilnahmen(isset($schueler['anz_teilnahmen']) ? $schueler['anz_teilnahmen']:0);
				$schuelers[] = $newSchueler;
			}
		}

		return $schuelers;
	}
*/	
	
	function getTeilnahmen($arrSchueler, $objFeuser, Tx_Blsvsa2013_Domain_Model_Schulen $schule){
		$fieldsTeilnahmen = array(
			'vorname', 'name', 'geschlecht', 'geburtstag', 'anzteilnahmen',
			'klasse', 'grundschulwettbewerb', 'schulnummer', 'schule',
			// 'punktegesamt', 'urkundenart', 'gedruckt', 'drucktstamp', 'schwimmnachweis', 'gueltigbis',
			// 'leistungstabelle1', 'ablagedatum1', 'pruefer1', 'ergebnis1'
		);

		$teilnahmen = array();
		foreach($arrSchueler as $key=>$schueler){
			if(!empty($schueler)) {
				// Schueler
				$newSchueler = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Schueler');
				$newSchueler->setVorname($schueler['vorname']);
				$newSchueler->setName($schueler['name']);
				$newSchueler->setGeburtstag($schueler['geburtstag']);
				$newSchueler->setGeschlecht($schueler['geschlecht']);
				$newSchueler->setKlasse($schueler['klasse']);
				$newSchueler->setSchule($schule);
				$newSchueler->setSchulnummer($schule->getSchulnummer());
				$newSchueler->setAnzteilnahmen(isset($schueler['anz_teilnahmen']) ? $schueler['anz_teilnahmen']:0);
				$newSchueler->setFeuser($objFeuser);

				// Teilnahme
				$newTeilnahme = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Teilnahmen');
				foreach ($fieldsTeilnahmen as $field){
					$ucName = ucfirst($field);
					$setMethod = 'set'.$ucName;
					$getMethod = 'get'.$ucName;
					$newTeilnahme->$setMethod($newSchueler->$getMethod());
				}
				$newTeilnahme->setSchueler($newSchueler);
				$newTeilnahme->setPruefungsjahr(date('Y'));
				$newTeilnahme->setFeuser($objFeuser);
				$teilnahmen[] = $newTeilnahme;
			}
		}
		return $teilnahmen;
	}
	
	
	/**
	 * Schueler und Teilnahmen importieren
	 * 
	 * @param unknown $strSchueler (null oder string)
	 * @param Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen
	 * @param Tx_Blsvsa2013_Domain_Model_Feusers $objFeuser
	 * @param Tx_Blsvsa2013_Domain_Model_Schulen $schule
	 * @param integer $pid
	 */
	function doImport($strSchueler, Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen, Tx_Blsvsa2013_Domain_Model_Feusers $objFeuser, Tx_Blsvsa2013_Domain_Model_Schulen $schule, $pid){
		$importInfo = null;
		$arrSchueler = null;
		$importiert = 0;
		$vorhanden = 0;
		
		if ($strSchueler){
			$erg = $this->getSchuelerArray($strSchueler);
			
			$arrTeilnahmen = $this->getTeilnahmen($this->good, $objFeuser, $schule);
			// Teilnahmen in DB eintragen
			foreach($arrTeilnahmen as $newTeilnahme){
				$newTeilnahme->setPid($pid);
				$newTeilnahme->getSchueler()->setPid($pid);
				$erg2 = $repTeilnahmen->addNew( $newTeilnahme );
				
				switch ($erg2){
					case 1: $importiert++; break;
					default: $vorhanden++;
				}
			}
		}
		
		$stat = array(
				'gesamt' => count($arrTeilnahmen),
				'importiert' => $importiert,
				'vorhanden' => $vorhanden,
				'fehlerhaft' => count($this->bad),
		);
		
		if ($stat['fehlerhaft']==0){
			$message = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_schuelerimport.message_ok', $this->extensionName, $stat);
			$res = true;
		} else {
			$message = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_schuelerimport.message_error', $this->extensionName, $stat);
			$res = false;
		}
		
		$importInfo = array(
				'message' => $message,
				'res' => $res,
				'stat' => $stat,
				'errors' => $this->bad,
		);
		return $importInfo;
	}
	
	

	/**
	 * SchuelerArray aus Einzeleingabe in String umwandel 
	 *
	 * @param 	array 	$einzeleingabe (null oder string)
	 * @return	string
	 */
	function erstelleStrAusEinzeleingabe( array $einzeleingabe=null ){
		$erg='';
		if( $einzeleingabe ){
			foreach ($einzeleingabe as $ind => $schueler){
				if (is_numeric($ind) && ( $schueler[ 'vorname' ] or  $schueler[ 'name' ] or  $schueler[ 'klasse' ])) {
					$erg .=  $schueler[ 'vorname' ]. '; ' .  $schueler[ 'name' ] . ';01.01.' .  $schueler[ 'geburtsjahr' ] . '; ' . $schueler[ 'geschlecht' ] . ' ; ' . $schueler[ 'klasse' ]. "\n";
				}
			} 
		}
		return $erg;
	}
}
?>