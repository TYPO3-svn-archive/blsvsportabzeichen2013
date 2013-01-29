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
	var $lang = null;
	var $lang_file = "lib/locallang_import.xml";
	  
	var $schueler;
	
	var $llltbl_schueler = 'sportabzeichen.tx_blsvschulwettbewerb_schueler';
	var $llltbl_schueler_hist = 'sportabzeichen.tx_blsvschulwettbewerb_schueler_history';
	var	$llltbl_klassen = 'sportabzeichen.fe_groups';
	var $llltbl_import_log = 'sportabzeichen.tx_blsvschulwettbewerb_import_log';
	var $llltbl_schueler_tmp = '';

	/**
	 * Konstruktor
	 */
	function __construct($extPath, $schuelerRepository) {
		// Sprachobjekt erstellen
		$llfile = $extPath.$this->lang_file;
		$this->lang = t3lib_div::makeInstance('language');
		$this->lang->init($GLOBALS['TSFE']->config['config']['language']); 
		$this->lang->includeLLFile($llfile);
		
		// cObj instanzieren
		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		
		// Schueler Repository
		$this->schueler = $schuelerRepository; 
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
	function doImport($schuelerstring, $fe_group_schule, $fe_user, $pid, $aktion, &$info) {
		$res = -2;
		$this->pid = (int)$pid;
		$nachricht = '';
		
		
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
					// Neue Schueler importieren
					$schueler_neu = $this->getSchuelerNeu($fe_group_schule, $schueler_liste);
					
//$schuelerNeu = $this->schueler->getN					
print_r($schueler_neu); return;					
					$this->importSchuelerliste($fe_group_schule, $schueler_neu, $fe_user);
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

/*				case 2: // Bearbeitungsdaten
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
				break;*/
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
	function lllgetErrorMsg($bad_array)
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
	
	
		
	
	
	/** lll
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
	 * Eine Liste mit Schuelern importieren (alt)
	 *
	 * @param integer $schule_id Id der Schule
	 * @param array $schueler_liste Array mit Schuelern
	 * @param integer $bearbeiter_id Id des aktuellen Bearbeiters
	 */
	function lllimportSchuelerliste_alt($schule_id, $schueler_liste, $bearbeiter_id) {
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
	function lllimportSchuelerliste($schule_id, $schueler_liste, $bearbeiter_id) {
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
	function lllimportSchuelerlisteTmp($schule_id, $schueler_liste, $bearbeiter_id) {
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
	
	/** lll
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
	
	/** lll
	 * Datensatz als assoz. Array holen
	 *
	 * @param resource $res
	 * @return $array assoz. Array mit Datensatz
	 */
	function dbFetchAssoc($res) {
		return $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		// return mysql_fetch_assoc($res);
	}
	
	/** lll
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
	function lllgetArrayFromString($sstring) {
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
	function llllogString($string)
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
	function llllogErgebnis($uid, $ergebnis, $meldung='')
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
?>