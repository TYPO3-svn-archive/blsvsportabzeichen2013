<?php
class tx_lib_typodb
{
	function get_array($query)
	{
		$daten = array();
		
		$res = $GLOBALS['TYPO3_DB']->sql_query($query);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $daten[] = $row; 
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);

		return $daten;
	}
}
?>