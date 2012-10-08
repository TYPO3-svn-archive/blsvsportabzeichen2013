<?php
require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/class.tx_blsvschulwettbewerb_import.php");

/**
 * Sprachunterstuetzung
 */
require_once(t3lib_extMgm::extPath('lang', 'lang.php'));

/**
 * Klasse fuer den Import von Schuelern und Klassen 
 * Quelle: 	String mit csv-Daten (Name,Vorname,Geburtstag,Geschlecht,Klasse)
 * Ziel:	Tabellen fe_groups und tx_blsvschulwettbewerb_schueler
 */
class tx_blsvschulwettbewerb_import_100806 extends tx_blsvschulwettbewerb_import
{
	var $tbl_schueler = 'tx_blsvschulwettbewerb_schueler';
	var $tbl_schueler_hist = 'tx_blsvschulwettbewerb_schueler_history';
	var	$tbl_klassen = 'fe_groups';
	var $tbl_import_log = 'tx_blsvschulwettbewerb_import_log';

	var $tbl_schulen = 'tx_blsvschulwettbewerb_schulen';
	var $lang_file = "lib/locallang_import_100608.xml";  
	
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
		$res = -1;
		$this->pid = (int)$pid;
		$nachricht = '';
		
		if (!empty($tmp_table)) {
			$this->tbl_schueler_tmp = $tmp_table;
		}
		
		$sarray = $this->getSchuelerArray($schuelerstring);
		
		// Falls Fehler, dann Fehlermeldung
		if (!empty($sarray['bad'])) {
			$info = $this->getErrorMsg($sarray['bad']);
		}
		// Falls Daten ok, dann fortfahren
		else {
			$schueler_liste = $sarray['good'];

			switch ($aktion) {
				case 1: // Import, falls moeglich
					$erg = $this->importSchuelerliste($schueler_liste, $fe_user);
					$anzahl_gesamt = $erg['insert'] + $erg['update'];
					$anzahl_neu = $erg['insert'];
					$anzahl_akt = $erg['update'];

					// Bestaetigungsmeldung erzeugen
					$ersetzungen = array(
						'###ANZ_SCHUELER_GESAMT###'	=> $anzahl_gesamt,
						'###ANZ_SCHUELER_NEU###'	=> $erg['insert'],
						'###ANZ_SCHUELER_AKT###'	=> $erg['update']
					);
					$platzhalter = array();
					$ersetzung = array();
					foreach($ersetzungen as $p=>$e) {
						$platzhalter[] = $p;
						$ersetzung[] = $e;
					}
					$nachricht = str_replace($platzhalter, $ersetzung, $this->lang->getLL('imp_ok'));
					$info = compact('nachricht', 'anzahl_gesamt', 'anzahl_neu', 'anzahl_akt', 'schueler_liste');
					$res = 1;
					break;
			}
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
		$import_func = 'getSchuelerZeile_100608';
		return $import_func;		
	}
	
	/**
	 * csv-Zeile mit einem Schueler in einen Array umwandeln
	 *
	 * @param string $szeile csv-Zeile mit Daten
	 * @param  $sdaten Array mit Daten (umgewandelte Zeile)
	 * @return boolean true wenn ok, false wenn Fehler 
	 */
	function getSchuelerZeile_100608($szeile, &$sdaten) {
		$fehler = array();
		$sdaten0 = explode(',', $szeile);
	
		$count = count($sdaten0);
		if ($count!=7)	{
			if ($count>7) {
				$fehler[] = $this->lang->getLL('err_too_many_fields');  	
			} else {
				$fehler[] = $this->lang->getLL('err_too_less_fields'); 	
			}
		} else {
			$sdaten = array(
				'schulnummer' => trim($this->getSchuelerFeldText($sdaten0[0], $fehler, $this->lang->getLL('field_school_id'))),
				'geschlecht' => trim($this->getSchuelerFeldGeschlecht($sdaten0[1], $fehler)),
				'name' => trim($this->getSchuelerFeldText($sdaten0[2], $fehler, $this->lang->getLL('field_lastname'))),
				'vorname' => trim($this->getSchuelerFeldText($sdaten0[3], $fehler, $this->lang->getLL('field_firstname'))),
				'geburtsdatum' => trim($this->getSchuelerFeldDatum($sdaten0[4], $fehler)),
				'klasse' => trim($this->getSchuelerFeldText($sdaten0[5], $fehler, $this->lang->getLL('field_class'))),
				'pruefungen' => trim($this->getSchuelerFeldText($sdaten0[6], $fehler, $this->lang->getLL('field_tests'))),
				'klassen_id' => 0
			);
			$sdaten['klassen_id'] = $this->getSchuelerFeldKlassenId($sdaten['klasse'], $sdaten['schulnummer'], $fehler, $this->lang->getLL('field_class_id'));
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
	

	function importSchuelerliste($schueler_liste, $bearbeiter_id)
	{
		$insert = 0;
		$update = 0;
		
		if(!empty($schueler_liste)) {
			$pid = $this->pid;
			$time = time();
			
			foreach($schueler_liste as $schueler) {
				if (empty($this->tbl_schueler_tmp))	{
					$tabelle = $this->tbl_schueler; 
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
						'anz_teilnahmen' => $schueler['pruefungen'],
						'status_gesamt' => 4,
						'gedruckt'		=> 0,
					 );
					$spalten = implode(', ', array_keys($daten));
					$werte = "'" . implode("', '", $daten) . "'";
					
					$query = 
						"SELECT * FROM $tabelle".
						" WHERE fe_group={$schueler['klassen_id']}".
						" AND vorname='{$schueler['vorname']}'".
						" AND name='{$schueler['name']}'".
						" AND geschlecht={$schueler['geschlecht']}".
						" AND geburtstag='{$schueler['geburtsdatum']}'".
						"";
					$uid = 0;
					$res = $this->dbQuery($query,__METHOD__);
					if ($res) {
						$row = $this->dbFetchAssoc($res);
						$uid = (int)$row['uid'];
					}
					
					// update, falls vorhanden
					if ($uid>0) {
						foreach ($daten as $key=>$value) {
							$tmp_upd[] = "`$key` = '$value'";
						}
						$updates = implode(',', $tmp_upd);
						$query = "UPDATE $tabelle SET $updates WHERE uid=$uid";
						$update++;
						$res = $this->dbQuery($query,__METHOD__);
echo $query;						
					}
					// insert, falls neu
					else {
						$query = "INSERT INTO $tabelle ($spalten) VALUES ($werte)";
						$insert++;
						$res = $this->dbQuery($query,__METHOD__);
						$uid = $GLOBALS['TYPO3_DB']->sql_insert_id();
					} 
					
					// history schreiben
					$daten['uid'] = $uid;
					$erg = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tbl_schueler_hist, $daten);  
					if (!$erg) echo 'Fehler import_100806: '.$GLOBALS['TYPO3_DB']->sql_error(); 
				}
			}
		}
		return compact('insert', 'update');
	}
	
	/**
	 * Holen der Klassen-ID
	 *
	 * @param string $klasse Klasse
	 * @param integer $schulId SchulID
	 * @param array $fehler Fehler-Array
	 * @param string $feld
	 * @return $erg
	 */
	function getSchuelerFeldKlassenId($klasse, $schulId, &$fehler='', $feld='') {
		$erg = '';
		$klasse = addslashes(trim($klasse));
		$schulId = (int)$schulId;
		$query = 
			'SELECT fe_groups.uid'.
			" FROM {$this->tbl_klassen}".
			" INNER JOIN {$this->tbl_schulen} ON {$this->tbl_schulen}.fe_group = {$this->tbl_klassen}.subgroup".
			" WHERE title = '$klasse'".
			" AND schulnummer = $schulId";
		$res = $GLOBALS['TYPO3_DB']->sql_query($query);
		if ($res) {
			$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
			$erg = $row['uid'];
		}

		if (empty($erg)) {
			$fehler[] = str_replace('###FELD###', $feld, $this->lang->getLL('err_find_field_class_id'));
			$erg = 0;
		}
		return $erg;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_import_100806.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_import_100806.php']);
}
?>