<?php
class tx_blsvschulwettbewerb_daten
{
	var $schule_gid = 0;
	
	function __construct()
	{
		require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb').'pi7/class.tx_blsvschulwettbewerb_pi7.php');
		$this->schule_gid = (int)$GLOBALS['schule']['fe_group'];
/*		$this->_extConfig  = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['blsv_schulwettbewerb']);
		echo '<pre>';
		print_r($this);
		exit;*/		
	}
	
	function get_schule_gid()
	{
		return $this->schule_gid;
	}

	function get_schueler($options=array()) {
		$spalten_arr = array(
//			'schule',
			'vorname','name','geburtstag','geschlecht','klasse','abzeichen',
			'sag1','sag2','sag3','sag4','sag5','ges','format_abzeichen','format_ges',
			'format_sag1','format_sag2','format_sag3','format_sag4','format_sag5'
		);
		$spalten = implode(',', $spalten_arr);
		$spalten ='*';		
		$query = "SELECT $spalten FROM qry_rpt_schueler";
		
		$and = array();
		$and[] = "gid_schule='" . $this->schule_gid . "'";
		
		// Option fuer bestanden/nicht bestanden
		if (isset($options['bestanden'])) {
			// bestanden
			if (true == $options['bestanden']) {
				$and[] = "format_sges=1";
			}
			// nicht bestanden
			else {
				$and[] = "format_sges!=0";
				$and[] = "format_sges!=1";
			}
		}
			
		// Option fuer teilgenommen/nicht teilgenommen
		if (isset($options['teilgenommen'])) {
			// teilgenommen
			if (true == $options['teilgenomen']) {
				$and[] = "format_sges>0";
			}
			// nicht teilgenommen
			else {
				$and[] = "format_sges=0";
			}
		}
		
		if (!empty($and)) {
			$query .= ' WHERE ('. implode(') AND (', $and) . ')';
		}
		return $query;
	}
	
	function get_lehrer()
	{
		$spalten = 'username Benutzername, usergroup Gruppen, name Name';
		$query = "SELECT $spalten FROM fe_users WHERE CONCAT( ',',usergroup, ',' ) REGEXP ',{$this->schule_gid},'";
		return $query;		
	}
	
	function get_teilnehmer($cfg)
	{
		$query = '';
		if (!empty($cfg['bezirk'])) {
			// Bezirk auswerten
			$bedingungen = array();
			$bedingungen[] = 'schule_bezirk='.(int)$cfg['bezirk'];

			// Kreis auswerten
			if (0<($cfg['kreis'])) {
				$bedingungen[] = 'schule_kreis='.(int)$cfg['kreis'];
			}
		
			// Id auswerten
			$table = 'qry_teilnehmer';
			$select = 'schule_bezirk, schule_kreis, schule_nummer, schule_name, klasse_name, schueler_anzahl';
			$group = 'schule_id, klasse_id';
			$order = 'schule_bezirk, schule_kreis, schule_name, klasse_name';
			
			// Bedingungen zusammensetzen und Query erstellen
			$where = '((' . implode(') AND (', $bedingungen) . '))';
			$query = $GLOBALS['TYPO3_DB']->SELECTquery($select, $table, $where, $group, $order);
		}
		return $query;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_daten.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_daten.php']);
}
?>