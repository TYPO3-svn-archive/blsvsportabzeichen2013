<?php
/**
 * Sprachunterstuetzung
 */
require_once(t3lib_extMgm::extPath('lang', 'lang.php'));

/**
 * Klasse fuer den Import von Schuelern und Klassen 
 * Quelle: 	String mit csv-Daten (Name,Vorname,Geburtstag,Geschlecht,Klasse)
 * Ziel:	Tabellen fe_groups und tx_blsvschulwettbewerb_schueler
 */
class tx_blsvschulwettbewerb_import
{
	var $pid = 0;
	var $tbl_schueler = 'sportabzeichen.tx_blsvschulwettbewerb_schueler';
	var $tbl_schueler_hist = 'sportabzeichen.tx_blsvschulwettbewerb_schueler_history';
	var	$tbl_klassen = 'sportabzeichen.fe_groups';
	var $tbl_import_log = 'sportabzeichen.tx_blsvschulwettbewerb_import_log';
	var $tbl_schueler_tmp = '';
	var $lang = null;
	var $lang_file = "lib/locallang_import.xml";  

	/**
	 * Konstruktor
	 */
	function __construct() {
		// Sprachobjekt erstellen
		$llfile = t3lib_extMgm::extPath('blsv_schulwettbewerb').$this->lang_file;
		$this->lang = t3lib_div::makeInstance('language');
		$this->lang->init($GLOBALS['TSFE']->config['config']['language']); 
		$this->lang->includeLLFile($llfile);
		
		// cObj instanzieren
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
	}

	/**
	 * Importiert Schueler in Datenbank
	 *
	 * @param string	$schuelerstring: gepastete Schueler
	 * @param integer	$fe_group_schule: uid der fe_group der Schule
	 * @param integer	$fe_user: importeur
	 * @param integer	$pid
	 * @param integer	$aktion 1:importieren, 2:bearbeitungsdaten ermitteln
	 * @param array		$info nachricht:Nachricht, fehlerzeilen
	 * @return integer	1 ok, 0 hinweis, -1 fehler
	 */
	function doImport($schuelerstring, $fe_group_schule, $fe_user, $pid, $aktion, &$info, $tmp_table='') {
		$res = -2;
		$this->pid = (int)$pid;
		$nachricht = '';
		
		if (!empty($tmp_table)) {
			$this->tbl_schueler_tmp = $tmp_table;
		}
		
		$sarray = $this->getSchuelerArray($schuelerstring);
		
		// Falls Fehler, dann Fehlermeldung
		if (!empty($sarray['bad'])) {
			$info_fehler = $this->getErrorMsg($sarray['bad']);
		        $res = -1;
		       
		}
		// Falls Daten ok, dann fortfahren
		 {
			$schueler_liste = $sarray['good'];
			$anzahl_gesamt = $sarray['count'];
	
			switch ($aktion) {
				case 1: // Import, falls moeglich
					// Neue Klassen importieren und Klasseninfo holen
					$klassen_neu = $this->getKlassenNeu($fe_group_schule, $schueler_liste);
					$this->importKlassen($fe_group_schule, $klassen_neu, $fe_user);
					$klassen = $this->getKlassen($fe_group_schule);
					
					// Ids der Klassen bei der Schuelerliste eintragen
					$schueler_liste = $this->updateSchuelerKlassen($klassen, $schueler_liste);
	
					// Neue Schueler importieren
					$schueler_neu = $this->getSchuelerNeu($fe_group_schule, $schueler_liste);
					$this->importSchuelerliste($fe_group_schule, $schueler_neu, $fe_user);
					
					// In tmp-Tabelle importieren, falls Tabelle angegeben
					if (!empty($this->tbl_schueler_tmp)) {
						$this->importSchuelerlisteTmp($fe_group_schule, $schueler_liste, $fe_user);
					}
					$anzahl_neu = count($schueler_neu);
					
					// Bestaetigungsmeldung erzeugen
					$ersetzungen = array(
						'###ANZ_SCHUELER_GESAMT###'	=> $anzahl_gesamt,
						'###ANZ_SCHUELER_NEU###'	=> $anzahl_neu,
					);
					$platzhalter = array();
					$ersetzung = array();
					foreach($ersetzungen as $p=>$e) {
						$platzhalter[] = $p;
						$ersetzung[] = $e;
					}
					
					if (0==$anzahl_neu) {
						$nachricht = str_replace($platzhalter, $ersetzung, $this->lang->getLL('imp_no_new_data'));
					} else {
						$nachricht = str_replace($platzhalter, $ersetzung, $this->lang->getLL('imp_ok'));
					}
					$nachricht.= '\n\n'.$info_fehler['nachricht'];
                                        $info = compact('nachricht', 'anzahl_gesamt', 'anzahl_neu', 'klassen_neu', 'schueler_neu');
					//print_r($info);
					$res = 1;
					break;

				case 2: // Bearbeitungsdaten
					$klassen_neu = $this->getKlassenNeu($fe_group_schule, $schueler_liste);
	
					$klassen = $this->getKlassen($fe_group_schule);
					$schueler_liste = $this->updateSchuelerKlassen($klassen, $schueler_liste);
					$schueler_neu = $this->getSchuelerNeu($fe_group_schule, $schueler_liste);
					$anzahl_neu = count($schueler_neu);
					
					// Bestaetigungsmeldung erzeugen
					$ersetzungen = array(
						'###ANZ_SCHUELER_GESAMT###'	=> $anzahl_gesamt,
						'###ANZ_SCHUELER_NEU###'	=> $anzahl_neu,
					);
					$platzhalter = array();
					$ersetzung = array();
					foreach($ersetzungen as $p=>$e) {
						$platzhalter[] = $p;
						$ersetzung[] = $e;
					}
					
					if (0==$anzahl_neu) {
						$nachricht = str_replace($platzhalter, $ersetzung, $this->lang->getLL('tst_no_new_data'));
					} else {
						$nachricht = str_replace($platzhalter, $ersetzung, $this->lang->getLL('tst_ok'));
					}
					$nachicht.= $info_fehler['nachricht'];
					$info = compact('nachricht', 'anzahl_gesamt', 'anzahl_neu', 'klassen_neu', 'schueler_neu');
					//print_r($info);
					if ($res===-2) 	$res = 0;
				break;
			}
		}
		
		
		return $res;
	}
	
	/**
	 * Fehlermeldungen holen
	 *
	 * @param array $fehlerzeilen Array mit Fehlerinfos
	 * @return array Array mit Fehlernachricht und Fehlerzeilen
	 */
	function getErrorMsg($bad_array)
	{
		foreach ($bad_array as $zeile_info) {
			$zeile_inf = str_replace('###IMP_ZEILE###', $zeile_info['zeile'], $this->lang->getLL('err_nok_line_inf'));
		
			$zeilen_arr = array();
			foreach ($zeile_info['fehler'] as $fehler) {
				$zeilen_arr[] = str_replace('###IMP_FEHLER###', $fehler, $this->lang->getLL('err_nok_line_msg'));
			}
			$zeile_msg = implode('', $zeilen_arr);
			$info_arr[] = str_replace(array('###INF###', '###MSG###'), array($zeile_inf, $zeile_msg), $this->lang->getLL('err_nok_line_blk'));
		}
		$imp_blk = (implode('', $info_arr));
		$nachricht = str_replace('###IMP_BLK###', $imp_blk, $this->lang->getLL('err_nok'));
		return compact('nachricht', 'fehlerzeilen');
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
		$count = 0;
		$good = array();
		$bad = array();
		foreach($sarray as $szeile) {
			if (!empty($szeile)) {
				$count++;
				$sdaten = array();
				if ($this->$import_func($szeile, $sdaten) == true) {
					$hash = $this->getSchuelerHash($sdaten);
					$good[$hash] = $sdaten;
				} else {
					$bad[] = $sdaten;
				}
			}
		}
	
		// Funktionsergebnis zusammenfassen und Rueckgabe
		$ret = compact('good', 'bad', 'count');		
		return $ret;
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
			case 6:  //mit  Anzprüfungen
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
				$fehler[] = $this->lang->getLL('err_too_many_fields');  	
			} else {
				$fehler[] = $this->lang->getLL('err_too_less_fields'); 	
			}
		} else {
			$sdaten = array(
				'vorname' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, $this->lang->getLL('field_firstname'))),
				'name' => trim($this->getSchuelerFeldText($sdaten0[1], $fehler, $this->lang->getLL('field_lastname'))),
				'geburtsdatum' => trim($this->getSchuelerFeldDatum($sdaten0[2], $fehler)),
				'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[3], $fehler)),
				'klasse' => trim($this->getSchuelerFeldText($sdaten0[4], $fehler, $this->lang->getLL('field_class'))),
				'klassen_id' => 0
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
				$fehler[] = $this->lang->getLL('err_too_many_fields');  	
			} else {
				$fehler[] = $this->lang->getLL('err_too_less_fields'); 	
			}
		} else {
			$sdaten = array(
				'vorname' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, $this->lang->getLL('field_firstname'))),
				'name' => trim($this->getSchuelerFeldText($sdaten0[1], $fehler, $this->lang->getLL('field_lastname'))),
				'geburtsdatum' => trim($this->getSchuelerFeldDatum($sdaten0[2], $fehler)),
				'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[3], $fehler)),
				'klasse' => trim($this->getSchuelerFeldText($sdaten0[4], $fehler, $this->lang->getLL('field_class'))),
				'klassen_id' => 0,
				'status_gesamt' => 4,
				'anz_teilnahmen' => trim($this->getSchuelerFeldText($sdaten0[5], $fehler, $this->lang->getLL('field_anz_teilnahmen')))
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
				$fehler[] = $this->lang->getLL('err_too_many_fields');  	
			} else {
				$fehler[] = $this->lang->getLL('err_too_less_fields'); 	
			}
		} else {
			$nachname = array(
				trim($sdaten0[3]), // Zusatz davor
				trim($this->getSchuelerFeldText($sdaten0[1], $fehler, $this->lang->getLL('field_lastname'))), // Name
				trim($sdaten0[4]) // Zusatz dahinter	
			);

			$sdaten = array(
				'vorname' => trim($this->getSchuelerFeldText($sdaten0[2], $fehler, $this->lang->getLL('field_firstname'))),
				'name' => implode(' ', $nachname), 
				'geburtsdatum' => trim($this->getSchuelerFeldDatum($sdaten0[5], $fehler)),
				'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[6], $fehler)),
				'klasse' => trim($this->getSchuelerFeldText($sdaten0[7], $fehler, $this->lang->getLL('field_class'))),
				'klassen_id' => 0
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
	 * Hash fuer eine Schuelerzeile erzeugen
	 *
	 * @param array $schueler Schueler-Array
	 * @return string SchuelerHash
	 */
	function getSchuelerHash($schueler) {
		// $zeile = array($schueler['name'], $schueler['vorname'], $schueler['geschlecht'], $schueler['geburtsdatum'], $schueler['klassen_id']);
		$zeile = array($schueler['name'], $schueler['vorname'], $schueler['geschlecht'], $schueler['geburtsdatum'], $schueler['klasse']);
		$hash = strtolower(implode(',',$zeile));
		return $hash;
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
			$fehler[] = str_replace('###FELD###', $feld, $this->lang->getLL('err_empty_field'));
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
		$fehler_datum = str_replace('###DATUM###', htmlentities($datum), $this->lang->getLL('err_read_field_date'));

		
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
			$fehler[] = str_replace('###GESCHLECHT###', htmlentities($geschlecht), $this->lang->getLL('err_read_field_gender'));
		}
		return $erg_geschlecht;
	}
	
	/**
	 * Klassen_Ids (fe_groups) in die Schuelerliste eintragen 
	 *
	 * @param array $klassen Array mit fe_groups_uid (=key) und Klassenname(=val)
	 * @param array $schueler_liste Array mit Schuelerinfos
	 * @return array Array mit aktualisierten Schuelerinfos
	 */
	function updateSchuelerKlassen($klassen, $schueler_liste) {
		if (!empty($schueler_liste) && !empty($klassen))
		{
			$klassen_id = array();
			foreach ($klassen as $id => $klasse) {
				$klassen_id[$klasse] = $id;
			}
			
			foreach ($schueler_liste as $sid => $sdaten) {
				$klasse = $schueler_liste[$sid]['klasse'];
				$schueler_liste[$sid]['klassen_id'] = $klassen_id[$klasse];
			}
		}
		return $schueler_liste;
	}
	
	/**
	 * Klassen einer Schule als Array holen
	 *
	 * @param integer $schule_id Id der Schule
	 * @return array Klassen der Schule
	 */
	function getKlassen($schule_id) {
		$tabelle = $this->tbl_klassen;
		$query = "SELECT * FROM $tabelle WHERE CONCAT(',',subgroup,',') REGEXP ',$schule_id,' ";
		$res = $this->dbQuery($query,__METHOD__);
		$klassen = array();
		while ($row = $this->dbFetchAssoc($res)) {
		    $klassen[$row['uid']] = $row['title']; 
		}
		$this->dbFreeResult($res);
		return $klassen;
	}

	/**
	 * Neue Klassen der Schule ermitteln
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schuelerliste Array mit Schuelerinfos
	 * @return array Array mit neuen Klassen der Schule
	 */
	function getKlassenNeu($schule_id, $schuelerliste) {
		$klassen_neu = array();
		if (!empty($schuelerliste))	{
			$klassen_db = $this->getKlassen($schule_id);
			foreach ($schuelerliste as $schueler) {
				if (!in_array($schueler['klasse'], $klassen_db)) {
					$klassen_neu[$schueler['klasse']] = 0;
				}
			}
		}
		return 	array_keys($klassen_neu);
	}
	
	/**
	 * Klassen fuer eine Schule importieren
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $klassen Array mit zu importierenden Klassen
	 * @param integer $bearbeiter_id Id des aktuellen Bearbeiters
	 */
	function importKlassen($schule_id, $klassen, $bearbeiter_id) {
		$pid = $this->pid;
		
		$time = time();
		
		if(!empty($klassen)) {
			foreach($klassen as $klasse) {
				$tabelle = $this->tbl_klassen;

				// Grundschulwettbewerb bei allen 3. und 4. Klassen vorbelegen
				// $gsw = (0<preg_match('/^(3|4)(.*)$/', $klasse, $test))?1:0;
				$gsw = (0<preg_match('/^([^0-9]*)(3|4)([^0-9]*)$/', $klasse, $test))?1:0;
				
				$daten = array(
					'pid'			=> $pid, 	
					'tstamp'		=> $time, 	
					'crdate'		=> $time, 	
					'cruser_id'	 	=> $bearbeiter_id,
					'title'			=> $klasse, 	
					'description' 	=> "Schulklasse (Schule=$schule_id)",
					'subgroup'		=> $schule_id,
					'TSconfig'		=> '',
					'tx_blsvschulwettbewerb_grundschulwettbewerb' => $gsw				
				);
				$spalten = implode(', ', array_keys($daten));
				$werte = "'" . implode("', '", $daten) . "'";

				$query = "INSERT INTO $tabelle ($spalten) VALUES ($werte)";
				$res = $this->dbQuery($query,__METHOD__);
			}
		}
	}

	/**
	 * Schueler einer Schule aus der DB holen
	 *
	 * @param integer $schule_id Id der Schule
	 * @return array Array mit Schuelern der Schule
	 */
	function getSchueler($schule_id) {
		$query = 
			"SELECT name, vorname, geschlecht, geburtstag geburtsdatum, title klasse, fe_group klassen_id FROM {$this->tbl_schueler}".
			" JOIN {$this->tbl_klassen} on {$this->tbl_klassen}.uid = {$this->tbl_schueler}.fe_group".
			" WHERE CONCAT(',',subgroup,',') REGEXP ',$schule_id,' ";
		$res = $this->dbQuery($query,__METHOD__);
		$schueler_arr = array();
		while ($row = $this->dbFetchAssoc($res)) {
			$hash = $this->getSchuelerHash($row);
		    $schueler_arr[] = $hash;
		}
		$this->dbFreeResult($res);
		return $schueler_arr;
	}

	/**
	 * Neue Schueler einer Schule ermitteln
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schueler_arr Array mit Schuelern
	 * @return array Array mit den neuen Schuelern
	 */
	function getSchuelerNeu($schule_id, $schueler_arr) {
		$schueler_neu = array();
		if (!empty($schueler_arr)) {
			$schueler_db = $this->getSchueler($schule_id);
			foreach ($schueler_arr as $schueler) {
				$hash = $this->getSchuelerHash($schueler);
				if (!in_array($hash, $schueler_db)) {
					$schueler_neu[] = $schueler;
				}
			}
		}
		return $schueler_neu;
	}

	/**
	 * Eine Liste mit Schuelern importieren (alt)
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schueler_liste Array mit Schuelern
	 * @param integer $bearbeiter_id Id des aktuellen Bearbeiters
	 */
	function importSchuelerliste_alt($schule_id, $schueler_liste, $bearbeiter_id) {
		$pid = $this->pid;
		
		if(!empty($schueler_liste))
		{
			$time = time();
			foreach($schueler_liste as $schueler)
			{
				// Wenn keine TMP-Tabelle, dann schreibe direkt in Schueler
				if (empty($this->tbl_schueler_tmp))	{
					$daten = array(
						'pid'			=> $pid,
						'tstamp'		=> $time, 
						'crdate'		=> $time, 
						'cruser_id'		=> $bearbeiter_id, 
						'fe_group'		=> $schueler['klassen_id'], 
						'vorname'		=> $schueler['vorname'], 
						'name'		=> $schueler['name'],
						'geschlecht'	=> $schueler['geschlecht'], 
						'geburtstag'	=> $schueler['geburtsdatum'],
						'status_gesamt'	=>(isset($schueler['status_gesamt']) ? $schueler['status_gesamt']:0) ,
						'anz_teilnahmen'=>(isset($schueler['anz_teilnahmen']) ? $schueler['anz_teilnahmen']:0) 
					 );
					$spalten = implode(', ', array_keys($daten));
					$werte = "'" . implode("', '", $daten) . "'";
					$query = "INSERT INTO $this->tbl_schueler ($spalten) VALUES ($werte)";
					$res = $this->dbQuery($query,__METHOD__);

					// history schreiben
					$daten['uid'] = $GLOBALS['TYPO3_DB']->sql_insert_id();
					$erg = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler_hist, $daten);  
					if (!$erg) echo 'Fehler import: '.$GLOBALS['TYPO3_DB']->sql_error(); 
				}
				// Wenn TMP-Tabelle vorhanden, dann Daten in TMP-Tabelle und uids in Schuelertabelle
				else {
					 $daten = array(
						'pid'			=> $pid,
						'tstamp'		=> $time, 
						'crdate'		=> $time, 
						'cruser_id'		=> $bearbeiter_id, 
						'fe_group'		=> $schueler['klassen_id'], 
						'vorname'		=> $schueler['vorname'], 
						'name'			=> $schueler['name'],
						'geschlecht'		=> $schueler['geschlecht'], 
						'geburtstag'		=> $schueler['geburtsdatum'],
					 );


					$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler, $daten);
					$lastID=$GLOBALS['TYPO3_DB']->sql_insert_id();

					// history schreiben
					$daten['uid'] = $lastID;
					$erg = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler_hist, $daten);  
					if (!$erg) echo 'Fehler import: '.$GLOBALS['TYPO3_DB']->sql_error(); 
					
					$daten_tmp = array(
						'uid'			=> $lastID,
						'pid'			=> $pid,
						'tstamp'		=> $time, 
						'crdate'		=> $time, 
						'cruser_id'		=> $bearbeiter_id, 
						'fe_group'		=> $schueler['klassen_id'], 
						'vorname'		=> $schueler['vorname'], 
						'name'			=> $schueler['name'],
						'geschlecht'		=> $schueler['geschlecht'], 
						'geburtstag'		=> $schueler['geburtsdatum'],
					 );
					$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler_tmp, $daten_tmp);
					if (!$res) {
						echo $GLOBALS['TYPO3_DB']->sql_error(); 
					}
				}
			}
		}
	}

	/**
	 * Eine Liste mit Schuelern importieren
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schueler_liste Array mit Schuelern
	 * @param integer $bearbeiter_id Id des aktuellen Bearbeiters
	 */
	function importSchuelerliste($schule_id, $schueler_liste, $bearbeiter_id) {
		$pid = $this->pid;
		
		if(!empty($schueler_liste))
		{
			$time = time();
			foreach($schueler_liste as $schueler)
			{
				// Daten in die Schuelertabelle schreiben
				$daten = array(
					'pid'			=> $pid,
					'tstamp'		=> $time, 
					'crdate'		=> $time, 
					'cruser_id'		=> $bearbeiter_id, 
					'fe_group'		=> $schueler['klassen_id'], 
					'vorname'		=> $schueler['vorname'], 
					'name'			=> $schueler['name'],
					'geschlecht'	=> $schueler['geschlecht'], 
					'geburtstag'	=> $schueler['geburtsdatum'],
					'status_gesamt'	=>(isset($schueler['status_gesamt']) ? $schueler['status_gesamt']:0) ,
					'anz_teilnahmen'=>(isset($schueler['anz_teilnahmen']) ? $schueler['anz_teilnahmen']:0) 
				);

				$erg = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler, $daten);
				if (!$erg) echo 'Fehler import: '.$GLOBALS['TYPO3_DB']->sql_error(); 

				// History schreiben
				$daten['uid'] = $GLOBALS['TYPO3_DB']->sql_insert_id();
				$erg = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler_hist, $daten);  
				if (!$erg) echo 'Fehler import: '.$GLOBALS['TYPO3_DB']->sql_error(); 
			}
		}
	}
	
	/**
	 * Eine Liste mit Schuelern von der Schueler-Tabelle in die tmp-Tabelle importieren
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schueler_liste Array mit Schuelern
	 * @param integer $bearbeiter_id Id des aktuellen Bearbeiters
	 */
	function importSchuelerlisteTmp($schule_id, $schueler_liste, $bearbeiter_id) {
		$pid = $this->pid;

		if(!empty($schueler_liste)) {
			// uids von Schuelern holen
			$uid_arr = array();
			foreach($schueler_liste as $schueler) {
					$fields = array(
						'pid'			=> $pid,
						'fe_group'		=> $schueler['klassen_id'], 
						'vorname'		=> $schueler['vorname'], 
						'name'			=> $schueler['name'],
						'geschlecht'	=> $schueler['geschlecht'], 
						'geburtstag'	=> $schueler['geburtsdatum'],
					 );
					 
					 $cond = array();
					 foreach($fields as $key=>$value) {
					 	$cond[] = "$key='$value'";
					 }
					$where = '('.implode(') AND (', $cond).')';
					$erg = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid', $this->tbl_schueler, $where);
					if (!$erg) die('Fehler import (tmp): '.$GLOBALS['TYPO3_DB']->sql_error());
					$row = $GLOBALS['TYPO3_DB']->sql_fetch_row($erg);
					$uid_arr[] = $row[0]; 
					$GLOBALS['TYPO3_DB']->sql_free_result($erg);
			}
			$uids = implode(',', $uid_arr);

			// Schueler in tmp-Tabelle kopieren
			$spalten = 'uid,pid,tstamp,crdate,cruser_id,fe_group,vorname,name,geschlecht,geburtstag'; 
			$query = 'insert into '.$this->tbl_schueler_tmp.'('.$spalten.') select '.$spalten.' from '.$this->tbl_schueler.' where uid in ('.$uids.')';
			$erg = $GLOBALS['TYPO3_DB']->sql_query($query);
			if (!$erg) die('Fehler import (tmp): '.$GLOBALS['TYPO3_DB']->sql_error());
		}
	}
	
	/**
	 * DB-Query ausfuehren
	 *
	 * @param string $query
	 * @return $res Ergebnis
	 */
	function dbQuery($query) {
		// $res = mysql_query($query);
		$res = $GLOBALS['TYPO3_DB']->sql_query($query);  
		if (!$res) {
			die(mysql_error());
		}
		return $res;		
	}
	
	/**
	 * Datensatz als assoz. Array holen
	 *
	 * @param resource $res
	 * @return $array assoz. Array mit Datensatz
	 */
	function dbFetchAssoc($res) {
		return $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		// return mysql_fetch_assoc($res);
	}
	
	/**
	 * Speicher freigeben
	 *
	 * @param resource $res
	 * @return $bool
	 */
	function dbFreeResult($res) {
		return $GLOBALS['TYPO3_DB']->sql_free_result($res);
		// return mysql_free_result($res);
	}
	
	
	/**
	 * Array aus einem String erzeugen
	 *
	 * @param string $sstring String, mit Tabs getrennt
	 * @return array Array, das aus dem String erzeugt wurde
	 */
	function getArrayFromString($sstring) {
		$daten = array();
		
		// Zeichen im String ersetzen
		$ersetzungen = array(
			"\r\n" => "\n",
	
			"\t" =>	'|',
			);
		$suchfelder = array(); $ersetzfelder = array();
		foreach($ersetzungen as $suchfeld => $ersetzfeld)	{
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
				if (0==$count)
				{
					$colnames = $sdaten;
				}
				else
				{
					$zeile = array();
					foreach($colnames as $id => $index)
					{
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
	 * Importdaten loggen
	 * 
	 * @param string $string String mit Importdaten
	 */
	function logString($string)
	{
		$id = 0;
		$time = time();
		$daten = array(
			'pid' => $GLOBALS['TSFE']->id,
			'tstamp' => $time,
			'crdate' => $time,
			'cruser_id' => $GLOBALS['TSFE']->fe_user->user['uid'],
			'daten' => $string,
			'ergebnis' => 0
		);
		$query = $GLOBALS['TYPO3_DB']->INSERTquery($this->tbl_import_log, $daten);
		$this->dbQuery($query);
		$id = $GLOBALS['TYPO3_DB']->sql_insert_id(); 
		return $id;
	}
	
	/**
	 * Ergebnis loggen
	 *
	 * @param integer $uid ID des Datensatzes
	 * @param integer $ergebnis Ergebnis des Imports
	 * @param string $meldung Ergebnisnachricht
	 */
	function logErgebnis($uid, $ergebnis, $meldung='')
	{
		$daten = array(
			'ergebnis' => $ergebnis,
			'info' => $meldung,
		);
		$query = $GLOBALS['TYPO3_DB']->UPDATEquery($this->tbl_import_log, 'uid='.$uid, $daten);
		$this->dbQuery($query);
		$id = $GLOBALS['TYPO3_DB']->sql_insert_id(); 
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_import.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_import.php']);
}
?>