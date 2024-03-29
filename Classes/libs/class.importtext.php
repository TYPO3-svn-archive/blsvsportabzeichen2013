<?php 
class ImportText{
	var $lang = null;
	var $lang_file = "lib/locallang_import.xml";
	var $tbl_schueler = 'tx_blsvsa2013_domain_model_schueler';
	var $errors;
	var $good = null;
	var $bad = null;
	
	/**
	 * Konstruktor
	 */
	function __construct($extPath) {
		// Sprachobjekt erstellen
		$llfile = $extPath.$this->lang_file;
		$this->lang = t3lib_div::makeInstance('language');
		$this->lang->init($GLOBALS['TSFE']->config['config']['language']);
		$this->lang->includeLLFile($llfile);
	
		// cObj instanzieren
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		
		$this->errors = array();
	}
	
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
				$fehler[] = 'err_too_many_fields';
			} else {
				$fehler[] = 'err_too_less_fields';
			}
		} else {
			$sdaten = array(
					'vorname' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, 'field_firstname')),
					'name' => trim($this->getSchuelerFeldText($sdaten0[1], $fehler, 'field_lastname')),
					'geburtstag' => trim($this->getSchuelerFeldDatum($sdaten0[2], $fehler)),
					'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[3], $fehler)),
					'klasse' => trim($this->getSchuelerFeldText($sdaten0[4], $fehler, 'field_class')),
			);
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
				$fehler[] = 'err_too_many_fields';
			} else {
				$fehler[] = 'err_too_less_fields';
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
				$fehler[] = 'err_too_many_fields';
			} else {
				$fehler[] = 'err_too_less_fields';
			}
		} else {
			$nachname = array(
					trim($sdaten0[3]), // Zusatz davor
					trim($this->getSchuelerFeldText($sdaten0[1], $fehler, 'field_lastname')), // Name
					trim($sdaten0[4]) // Zusatz dahinter
			);
	
			$sdaten = array(
					'vorname' => trim($this->getSchuelerFeldText($sdaten0[2], $fehler, 'field_firstname')),
					'name' => implode(' ', $nachname),
					'geburtstag' => trim($this->getSchuelerFeldDatum($sdaten0[5], $fehler)),
					'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[6], $fehler)),
					'klasse' => trim($this->getSchuelerFeldText($sdaten0[7], $fehler, 'field_class')),
			);
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
			$fehler[] = 'err_empty_'. (!empty($feld)?$feld:'field');
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
		$fehler_datum = 'err_read_field_date';
	
	
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
				$fehler[] = $fehler_datum;
			}
				
			$erg_datum = mktime(0,0,0,$darr[2],$darr[1],$darr[3]);
		} else {
			$fehler[] = $fehler_datum;
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
			$fehler[] = 'err_read_field_gender';
		}
		return $erg_geschlecht;
	}

	
	/**
	 * Schueler aus String in SchuelerObjekt umwandeln
	 * 
	 * @param array $schuelerstring String mit Schuelern
	 * @param object $schule Schul Objekt
	 * @param object $feuser Fe_user Objekt
	 * @param arrray $schuelers Array mit Schueler Objekten
	 * @param array $errors Array mit Fehlern
	 * @return integer
	 */
	function getSchuelerFromString($schuelerstring, $schule, $feuser, &$schuelers, &$errors){
		$res = $this->getSchuelerArray($schuelerstring);
				
		$schuelers = $this->getSchuelers($this->good, $schule, $feuser);
		$errors = $this->bad;
		return $res;
	}
	
	/**
	 * Schuelerobjekt aus Array erzeugen
	 *
	 * @param array $schuelerArr Array mit Schueler
	 * @param Tx_Blsvsa2013_Domain_Model_Schule $schule Schule
	 * @param Tx_Blsvsa2013_Domain_Model_Feuser $feuser aktueller Bearbeiter
	 * @return array
	 */
	function getSchuelers($schuelerArr, $schule, $feuser) {

		$schuelers = array();
		foreach($schuelerArr as $key=>$schueler){
//t3lib_utility_Debug::debug($schueler, 'schueler');
			if(!empty($schueler)) {
				$newSchueler = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Schueler');
//				$newSchueler->setFeuser($feuser);
				$newSchueler->setSchule($schule);
				$newSchueler->setVorname($schueler['vorname']);
				$newSchueler->setName($schueler['name']);
				$newSchueler->setGeburtstag($schueler['geburtstag']);
				$newSchueler->setGeschlecht($schueler['geschlecht']);
				$newSchueler->setKlasse($schueler['klasse']);
//				$newSchueler->setPunktegesamt(isset($schueler['punktegesamt']) ? $schueler['punktegesamt']:0);
				$newSchueler->setAnzteilnahmen(isset($schueler['anz_teilnahmen']) ? $schueler['anz_teilnahmen']:0);
				$schuelers[] = $newSchueler;
			}
		}
		return $schuelers;
	}
	
	
}
?>