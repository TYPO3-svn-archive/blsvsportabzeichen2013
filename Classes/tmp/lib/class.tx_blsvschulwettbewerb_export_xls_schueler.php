<?php
/**
 * Sprachunterstuetzung
 */
require_once(t3lib_extMgm::extPath('lang', 'lang.php'));


require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/class.tx_lib_export_xls.php");

class tx_blsvschulwettbewerb_export_xls_schueler extends tx_lib_export_xls
{
	var $lang = null;
	
	function __construct() {
		// Sprachobjekt erstellen
		$llfile = t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/locallang_export.xml";
		$this->lang = t3lib_div::makeInstance('language');
		$this->lang->init($GLOBALS['TSFE']->config['config']['language']); 
		$this->lang->includeLLFile($llfile);
	}
	
	/**
	 * Formate holen
	 *
	 * @return array Array mit Formaten
	 */
	function get_formats() {
		$fmt = parent::get_formats();
		
		$fmt_name = '_status';
		$fmt[$fmt_name] = $fmt['_std'];
		
		$color = 'FgColor';
		$status_sges_col = array(26, 17, 2, 5);
		foreach($status_sges_col as $i => $col) {
			$fmt_name = 'sges_'.$i;
			$fmt[$fmt_name] = $fmt['_status'];
			$fmt[$fmt_name][$color] = $col; 
			$fmt[$fmt_name]['Bold'] = '1';
		}

		$status_grp_col = array(26, 17, 2);
		foreach($status_grp_col as $i => $col) {
			$fmt_name = 'sag_'.$i;
			$fmt[$fmt_name] = $fmt['_status'];
			$fmt[$fmt_name][$color] = $col; 
		}

		$status_abzeichen = array(26, 52, 22, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51);
		foreach($status_abzeichen as $i => $col) {
			$fmt_name = 'abzeichen_'.$i;
			$fmt[$fmt_name] = $fmt['_status'];
			$fmt[$fmt_name][$color] = $col; 
		}
		
		return $fmt;
	}
	
	
	/**
	 * Schreiben aller Tabellenzeilen
	 *
	 * @param array $tabelle Tabelle
	 */
	function write_tabelle(&$tabelle) {
		if (!empty($tabelle)) {
			$s = $this->s;
			foreach ($tabelle as $zeile) {
				$this->s = $s;
				$this->write_tabellenzeile($zeile);
			}
		}
	}
	

	/**
	 * Schreiben des Tabellenkopfs
	 *
	 * @param array $tabelle Tabelle
	 */
	function write_tabellenkopf(&$tabelle) {
		$s = $this->s;
		$z = $this->z;
		
		if (!empty($tabelle)) {
			foreach ($tabelle[$this->key0] as $spalte_name => $spalte_wert) {
				if (!preg_match('/format_([A-Za-z_]*)/', $spalte_name, $fname)) {
					$titel = $this->lang->getLL('col_'.$spalte_name);
					$this->write($titel, '_titel');
					$this->s++;
				}
			}
			$this->s = $s; $this->z++;
		}
	}
	
	/**
	 * Schreiben einer Tabellenzeile
	 *
	 * @param array $zeile Tabellenzeile
	 */
	function write_tabellenzeile($zeile) {
		$s = $this->s;
		if (!empty($zeile)) {
			$zeile['geburtstag'] = date('d.m.Y', $zeile['geburtstag']);
			$zeile['geschlecht'] = $this->lang->getLL('geschlecht_'.$zeile['geschlecht']);
				
			foreach ($zeile as $spalte_name => $spalte_wert) {
				$format = $spalte_name;
				if (isset($zeile['format_'.$spalte_name])) {
					$fname = preg_replace('/[0-9]*/', '', $spalte_name);
					$id = $zeile['format_'.$spalte_name];
					$format = $fname.'_'.$id;
				}
				
				if (!preg_match('/format_([A-Za-z_]*)/', $spalte_name, $fname)) {
					$this->write($spalte_wert, $format);
					$this->s++;
				}
			}
			$this->s = $s; $this->z++;
		}		
	}
	
	/**
	 * Spaltenbreiten mit Hilfe der Textlaengen von Tabelleninhalte setzen
	 *
	 * @param array $tabelle Tabelle
	 */
	function setColsFromTable(&$tabelle) {
		$this->cols = array();
		
		if (!empty($tabelle)) {
			$s = $this->s;
			
			// Ueberschriften durchlaufen 
			foreach ($tabelle[$this->key0] as $spalte_name => $spalte_wert) {
				if (!preg_match('/format_([A-Za-z_]*)/', $spalte_name, $fname)) {
					$titel = $this->lang->getLL('col_'.$spalte_name);
					$len = strlen($titel); 
					$this->cols[$this->s] = $len;
					$this->s++;
				}
			}

			// Zeilen durchlaufen 
			foreach ($tabelle as $zeile) {
				if (!empty($zeile)) {
					$this->s = $s;
					foreach ($zeile as $spalte_name => $spalte_wert) {
						if (!preg_match('/format_([A-Za-z_]*)/', $spalte_name, $fname)) {
							$len = strlen($spalte_wert); 
							if (!isset($this->cols[$this->s]) || ($len > $this->cols[$this->s])) {
								$this->cols[$this->s] = $len; 
							} 			
						}
						$this->s++;
					}
				}
			}
			$this->s = $s;
		}
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_xls_schueler.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_xls_schueler.php']);
}
?>