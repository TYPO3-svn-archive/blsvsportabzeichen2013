<?php
/**
 * Sprachunterstuetzung
 */
require_once(t3lib_extMgm::extPath('lang', 'lang.php'));


require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/class.tx_lib_export_xls.php");

class tx_blsvschulwettbewerb_export_xls_teilnehmer extends tx_lib_export_xls
{
	var $lang = null;
	var $tbl_key = 'qry_teilnehmer';
	
	function __construct() {
		// Sprachobjekt erstellen
		$llfile = t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/locallang_export.xml";
		$this->lang = t3lib_div::makeInstance('language');
		$this->lang->init($GLOBALS['TSFE']->config['config']['language']); 
		$this->lang->includeLLFile($llfile);
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
					$titel = $this->lang->getLL($this->tbl_key.'_'.$spalte_name);
					$this->write($titel, '_titel');
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
					$titel = $this->lang->getLL($this->tbl_key.'_'.$spalte_name);
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

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_xls_teilnehmer.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_xls_teilnehmer.php']);
}
?>