<?php
class Tx_Blsvsa2013_Service_ErgebnisImport {
	var $commentAlias = array('comment','kommmentar','tabdef');
	var $zusatzfelder, $factor, $DeleteWhere;
	var $imported = null;
	var $passed = null;
	var $errors = null;
	var $extensionName = 'Blsvsa2013';
	var $bestandenAb = 4;
		
	/**
	 * ein Array aus einem String mit CSV-Daten erzeugen
	 * 
	 * @param string $sstring String mit CSV-Daten
	 * @return array Array mit CSV-Daten
	 */
	public function getArrayFromString($sstring){
		$daten = array();
	
		// Zeichen im String ersetzen
		$ersetzungen = array(
				"\r\n" => "\n",
				"\t" =>	'|',
				";" =>	'|',
		);
		$suchfelder = array(); $ersetzfelder = array();
		foreach($ersetzungen as $suchfeld => $ersetzfeld){
			$suchfelder[] = $suchfeld; $ersetzfelder[] = $ersetzfeld;
		}
		$sstring = stripslashes($sstring);
		$sstring = str_replace($suchfelder, $ersetzfelder, $sstring);
	
		// String in Zeilen aufteilen
		$sarray = explode("\n", $sstring);

		// Zeilen interpretieren
		$count = 0;
		foreach($sarray as $szeile) {
			if (!empty($szeile)) {
				$sdaten = explode('|', $szeile);
				if (0==$count) {
					$colnames = $sdaten;
				} else {
					$zeile = array();
					foreach($colnames as $id => $index) {
						$zeile[$index] = $sdaten[$id];
					}
					$daten[] = $zeile;
				}
				$count++;
			}
		}
		return $daten;
	}

	/**
	 * Methode zum Sortieren der Daten nach Tabellen $sotierteDaten[tabelle][spalte]
	 *
	 * @param array $arrayDaten Array mit Daten von Ergebnisliste
	 * @return array $sortierteDaten Array mit Daten sortiert nach Tabellen
	 */
	function sortData( $arrayDaten ) {
		$sortierteDaten = array();
		$index=0;
	
		for ( $i=0; $arrayDaten[$i]; $i++ ){
			// 1. Spalte ist eine zahl --> Daten
			if ( is_numeric($arrayDaten[$i]['tabdef'])){
				foreach ( $arrayDaten[$i] as $key => $spaltenvalue){
					//wenn keine Kommentarspalte
					if (!in_array($key , $this->commentAlias)) {
						$arraytabelle = explode(".", $key); //splitte tabelle.n.spalte
						$sortierteDaten[$index][ $arraytabelle[0] ][ $arraytabelle[1] ] [ $arraytabelle[2] ] = $spaltenvalue;
					}
				}
				$index++;
			}
			// Zusatzfelder
			else {
				if ($arrayDaten[$i]['tabdef']=='ZF'){  //wenn zusatzfeld
					foreach ( $arrayDaten[$i] as $key => $spaltenvalue){
						//wenn keine Kommentarspalte
						if (!in_array($key , $this->commentAlias)) {
							$arraytabelle = explode(".", $key); //splitte tabelle.n.spalte
							$arrayZusatzfeld = explode("=", $spaltenvalue); //splitte z.b. leistung=1
							if ($spaltenvalue)
								$this->zusatzfelder[ $arraytabelle[0] ][ $arraytabelle[1] ] [ $arraytabelle[2] ][$arrayZusatzfeld[0]] = $arrayZusatzfeld[1];
						}
					}
				}
	
				/*				// Whereclause für delete
					if ($arrayDaten[$i]['tabdef']=='DW'){  //wenn zusatzfeld
				foreach ( $arrayDaten[$i] as $key => $spaltenvalue){
				//wenn keine Kommentarspalte
				if (!in_array($key , $this->commentAlias)) {
				$arraytabelle = explode(".", $key); //splitte tabelle.n.spalte
				$arrayDeleteWhere = explode("=", $spaltenvalue); //splitte z.b. leistung=1
				if ($spaltenvalue)
					$this->DeleteWhere[ $arraytabelle[0] ][ $arraytabelle[1] ] [ 'where'] [$arrayDeleteWhere[0]]= $arrayDeleteWhere[1];
				}
				}
				}
				*/
				if ($arrayDaten[$i]['tabdef']=='factor'){  //wenn zusatzfeld
					foreach ( $arrayDaten[$i] as $key => $spaltenvalue){
						//wenn keine Kommentarspalte
						if (!in_array($key , $this->commentAlias)) {
							$arraytabelle = explode(".", $key); //splitte tabelle.n.spalte
							if ($spaltenvalue)
								$this->factor[ $arraytabelle[0] ][ $arraytabelle[1] ] [ $arraytabelle[2] ] = $spaltenvalue;
						}
					}
				}
			}
		}
		return $sortierteDaten;
	}
	
	/**
	 * Erstellt die Tabelle fuer den Ergebnisimport
	 * 
	 * @param array $sortierteDaten Array mit sortierten Daten
	 * @return array
	 */
	function formatData($sortierteDaten) {
		$erg = true;

		//loop ueber die einzelnen Datenaetze
		foreach ($sortierteDaten  as $zeilenummer => $zeile){
			//loop ueber Tabellen
	
			// $erg  = $this->deleteDaten($zeilenummer,$sortierteDaten);
			foreach ($zeile as $tabelle => $tabdaten){
				//loop ueber datensaetze
				foreach ($tabdaten as $dsnummer => $arrayDatensatz){
					$arrayEinfuegen = $arrayDatensatz;
					//loop ueber Tabellenfelder
					foreach ($arrayDatensatz as $feldname => $feldvalue){
						if ( $this->factor[$tabelle][$dsnummer][$feldname]=='schwimmnachweis'){
							$arrayEinfuegen[$feldname] = ('ja' == $arrayEinfuegen[$feldname])?1:0;
						}
						// falls Umrechnungfactor in xls-Zeile factor fuer Spalte definiert
						else if ( $this->factor[$tabelle][$dsnummer][$feldname]=='datum'){
							$arrayEinfuegen[$feldname] = (int)$this->getSchuelerFeldDatum($arrayEinfuegen[$feldname]);
						}
						else {
							if ( $this->factor[$tabelle][$dsnummer][$feldname]>0 ){
								// wenn kein Doppekpunkt (Zeit) im Wertg
								If( strrpos( $arrayEinfuegen[$feldname],  ':') ===false ){
									// Dezimal -Kommma durch Dezimalpunkt ersetzen
									$arrayEinfuegen[$feldname] = str_replace(",", ".", $arrayEinfuegen[$feldname]) * $this->factor[$tabelle][$dsnummer][$feldname];
								}
								else{ // falls Doppelpunkt (Zeit)
									$arrayZeit =  explode (':', $arrayEinfuegen[$feldname]); //Aufteilung von Minuten und Sekunden
									$arrayEinfuegen[$feldname] = 60 * $arrayZeit[0] + $arrayZeit[1];
								}
								//echo 'F: '.$arrayEinfuegen[$feldname].' - '.$this->factor[$tabelle][$dsnummer][$feldname].'<br />';
									
							}
							elseif ($this->factor[$tabelle][$dsnummer][$feldname]==-1){
								if ($arrayEinfuegen[$feldname]=='ja' ){
									$arrayEinfuegen[$feldname]=1;
								}
								else{
									$arrayEinfuegen[$feldname]=0;
								}
							}
						}
						// wenn zusatzfelder definiert
						if ( !empty($this->zusatzfelder[$tabelle][$dsnummer][$feldname]) ){
							//loop ueber zusatsfelder
							foreach ($this->zusatzfelder[$tabelle][$dsnummer][$feldname] as $ZFfeldname => $ZFfeldvalue){
	
								// wenn begriff in eckigen Klammern
								if ( $ZFfeldvalue[0] == '[' ) {
									$replace		= array('[',']');
									$value 			= str_replace($replace, '', $ZFfeldvalue);
									$arrayvalue 	= explode(".", $value); //splitte tabelle.n.spalte
									$arrayEinfuegen[$ZFfeldname] = $sortierteDaten[$zeilenummer][$arrayvalue[0]][$arrayvalue[1]][$arrayvalue[2]];
								}
								else{
									$arrayEinfuegen[$ZFfeldname] = $ZFfeldvalue;
								}
							}
						}
					}
					$formatierteDaten[$tabelle][]=$arrayEinfuegen;
				}
			}
		}
		return $formatierteDaten;
	}

	/**
	 * Teilnahmen-Array aus formatierten Daten erstellen
	 * 
	 * @param array $formatierteDaten
	 * @return array
	 */
	public function getTeilnahmenFromFmtData(array $formatierteDaten){
		for ($i=1; $i<5; $i++){
			// das erste Ergebnis holen
			foreach ($formatierteDaten['Teilnahmen'.$i] as $ergebnis){
				$uid = $ergebnis['teilnahmen'];
				unset($ergebnis['teilnahmen']);
				$ergebnis['leistung'] = (int)$ergebnis['leistung'];
					
				if (!$teilnahmeErgebnis[$uid][$i]){
					$teilnahmeErgebnis[$uid][$i] = $ergebnis;
				}
					
				if (empty($teilnahmeErgebnis[$uid][$i]['leistung'])){
					$teilnahmeErgebnis[$uid][$i] = $ergebnis;
				}
			}
		}
		
		// in Teilnahmen eintragen
		foreach($formatierteDaten['Teilnahmen'] as $nr=>$zeile){
			$uid = $zeile['uid'];
		
			foreach($teilnahmeErgebnis[$uid] as $i=>$teilnahme){
				foreach ($teilnahme as $var => $wert){
					$formatierteDaten['Teilnahmen'][$nr][$var.$i] = $wert;
				}
			}
		}
		return $formatierteDaten['Teilnahmen'];
	}

	/**
	 * Inhalt des csv-Feldes als Datums-Timestamp interpretieren
	 *
	 * @param string $datum Datumsfeld
	 * @param array $fehler Array mit Fehlern
	 * @return $erg_datum Datums-Timestamp
	 */
	function getSchuelerFeldDatum($datum) {
		$erg_datum = '';
	
		// Jahreszahl zu Datum ergaenzen
		if (preg_match('/^([0-9]{4})$/', $datum, $darr)) {
			$datum = "01.01.$datum";
		}
	
		if (preg_match('/([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2,4})/', $datum, $darr)) {
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
				$this->setError('datumNichtLesbar', array('datum' => $datum));
			}
	
			$erg_datum = mktime(12,0,0,$darr[2],$darr[1],$darr[3]);
		} else {
			$this->setError('datumNichtLesbar', array('datum' => $datum));
		}
	
		return $erg_datum;
	}
	
	/**
	 * Teilnahmen importieren
	 * 
	 * @param array $teilnahmen
	 * @param Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen
	 * @param Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $repLeistungstabelle
	 */
	function importTeilnahmen(array $teilnahmen, Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen, Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $repLeistungstabelle){
		$updFields = array(
				'schwimmnachweis', 'anzteilnahmen',
				'punkte1', 'punkte2', 'punkte3', 'punkte4', 'punktegesamt',
				'leistung1', 'leistung2', 'leistung3', 'leistung4',
		);
		$chkFields = array('name', 'vorname', 'geburtstag', 'klasse', 'geschlecht');
		
		foreach ( $teilnahmen as $arrTeilnahme ){
			// wenn Teilnehmer nicht vorhanden => Fehler
			$teilnahme = $repTeilnahmen->findByUid( $arrTeilnahme['uid'] );
			if ($teilnahme==null){
				$this->setErrorTeilnahme($arrTeilnahme['uid'], 'uidNichtVorhanden', array('uid'=>$arrTeilnahme['uid']));
			} else {
				// wenn Punktegesamt > 0 dann anzTeilnahmen > 0
				if (($arrTeilnahme['punktegesamt']>0) && ($arrTeilnahme['anzteilnahmen']<=0)){
					$arrTeilnahme['anzteilnahmen'] = 1;
				}
		
				// wenn gedruckt dann kein Update
				if ($teilnahme->getGedruckt()>0){
					$this->setErrorTeilnahme($teilnahme->getUid(), 'schuelerSchonGedruckt', array('uid'=>$teilnahme->getUid(),'name'=>$teilnahme->getName(),'vorname'=>$teilnahme->getVorname()));
				}
		
				foreach ($chkFields as $field){
					// wenn ungleiche Felder dann kein Update
					$getMethod = 'get' . ucfirst($field);
					if ($arrTeilnahme[$field]<>$teilnahme->$getMethod()){
						$this->setErrorTeilnahme($teilnahme->getUid(), 'ungleichesFeld', array('wert1' => $arrTeilnahme[$field], 'wert2'=>$teilnahme->$getMethod(), 'uid'=>$teilnahme->getUid(),'name'=>$teilnahme->getName(),'vorname'=>$teilnahme->getVorname()));
					}
				}
					
				// Felder setzen, falls keine Fehler
				if (!$this->errors) {
					for ($lTab=1; $lTab<5; $lTab++){
						$objLeistungstabelle = $repLeistungstabelle->findByUid($arrTeilnahme['leistungstabelle'.$lTab]);
						$setMethod = 'setLeistungstabelle'.$lTab;
						$teilnahme->$setMethod($objLeistungstabelle);
					}
		
					foreach ($updFields as $field){
						$setMethod = 'set' . ucfirst($field);
						$teilnahme->$setMethod($arrTeilnahme[$field]);
					}
					
					if ($teilnahme->getPunktegesamt() >= $this->bestandenAb){
						$this->passed[] = $arrTeilnahme['uid'];
					}
					
					$this->imported[] = $arrTeilnahme['uid'];
				}
			}
		}
	}
	

	/**
	 * Fehler fuer Teilnahme setzen
	 * 
	 * @param integer $uid
	 * @param string $errorName
	 * @param array $params
	 */
	private function setErrorTeilnahme($uid, $errorName, $params){
		$this->errors['teilnahme'][$uid][$errorName] = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_ergebnisimport.error_teilnehmer_' . $errorName, $this->extensionName, $params);
	}
	
	/**
	 * Fehler setzen 
	 * 
	 * @param string $errorName
	 * @param array $params
	 */
	private function setError($errorName, $params=null){
		$this->errors[] = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_ergebnisimport.error_' . $errorName, $this->extensionName, $params);
	}
	
	/**
	 * Importiert Teilnahmen von Ergebnislisten
	 *
	 * @param array $ergebnisListen Array mit Ergebnislisten
	 * @param Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen
	 * @param Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $repLeistungstabelle
	 * @return array arrImportInfo Array mit ImportInfos (errors, imported)
	 */
	function importFromErgebnisListen(array $ergebnisListen, Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository $repTeilnahmen, Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $repLeistungstabelle){
		$arrImportInfo = null;
	
		foreach ($ergebnisListen as $ergebnisListe){
			if (empty($ergebnisListe)){
				$this->setError('leereErgListe');
			} else {
				$arrErgebnisListe = $this->getArrayFromString($ergebnisListe);
				if (!$arrErgebnisListe[0]['tabdef']) {
					$this->setError('ungueltigeDaten');
				} else {
					$sortierteDaten = $this->sortData($arrErgebnisListe);
					$formatierteDaten = $this->formatData($sortierteDaten);
					$teilnahmen = $this->getTeilnahmenFromFmtData($formatierteDaten);
					$res = $this->importTeilnahmen($teilnahmen, $repTeilnahmen, $repLeistungstabelle);
				}
			}
		}

		// Ergebnisse des Imports
		$stat = array(
				'imported' => count($this->imported),
				'passed' => count($this->passed),
				'errors' => count($this->errors),
		);
		
		if ($stat['errors']==0){
			$message = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_ergebnisimport.message_ok', $this->extensionName, $stat);
			$res = true;
		} else {
			$message = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_service_ergebnisimport.message_error', $this->extensionName, $stat);
			$res = false;
		}

		$arrImportInfo = array (
				'res' => $res,
				'message' => $message,
				'stat' => $stat,
				'imported' => $this->imported,
				'passed' => $this->passed,
				'errors' => $this->errors,
		);
		return $arrImportInfo;
	}
}
?>