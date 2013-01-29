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
 * @package blsvservicesxlstpl
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Service_Ergebnisse {
	/**
	 * function getErgebnisArray
	 * - Erstellt aus den Schuelern ein ErgebnisArray fuer den Export
	 * 
	 * @param array $teilnahmen Array mit Teilnahme-Objekten
	 * @param Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository $altersgruppen
	 * @param Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $leistungstabelle
	 * @return array
	 */
	public function getErgebnisArray($teilnahmen, Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository $altersgruppen, Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository $leistungstabelle) {
		$arrAg = array();
		foreach ($teilnahmen as $objTeilnahme) {
			$objAg = $altersgruppen->getBySchueler($objTeilnahme->getSchueler());
			if ($objAg){
				$arrLst = $leistungstabelle->getByAltersgruppe($objAg);
				$intAg = $objAg->getUid();
				if (!isset($arrAg[$intAg]['altersgruppe'])){
					$arrAg[$intAg]['altersgruppe']['Bezeichnung'] = $objAg->getBezeichnung();
				}
				
				if (!isset($arrAg[$intAg]['gruppen'])){
					$arrAg[$intAg]['gruppen'] = $this->getGruppenFromLeistungen($arrLst);
				}
				
				$arrAg[$intAg]['teilnahmen'][] = $this->getTeilnahmeFromObject($objTeilnahme);
				ksort($arrAg);
			}
		}
		return $arrAg;
	}
	
	/**
	 * Erzeugt einen Schueler-Array aus einem uebergebenen Teilnahmen-Objekt
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $objTeilnahmen
	 * @throws Tx_Blsvsa2013_Exception_Error
	 * @return array
	 */
	function getTeilnahmeFromObject(Tx_Blsvsa2013_Domain_Model_Teilnahmen $objTeilnahme){
		$arrSchueler = array();
		$fields = array('uid', 'name', 'vorname', 'geschlecht', 'geburtstag', 'klasse', 'anzteilnahmen', 'schwimmnachweis');
		
		foreach ($fields as $field){
			$getFunc = 'get'.ucfirst($field);
			if (method_exists($objTeilnahme, $getFunc)){
				$arrSchueler[$field] = $objTeilnahme->$getFunc();
			}
			else {
				throw new Tx_Blsvsa2013_Exception_Error('Tx_Blsvsa2013_Service_Ergebnisse: method does not exist: '.$getFunc, 1351159847);
			}
		}
		return $arrSchueler;
	}
	
	/**
	 * Erstellt einen Gruppen-Array aus einem Array mit Leistungstabellen-Objekten
	 * @param array $arrLeistungen
	 * @return array
	 */
	function getGruppenFromLeistungen($arrLeistungen){
		$arrGruppen = array();
		foreach ($arrLeistungen as $objLeistung){
			$gruppe = $objLeistung->getSportart()->getSportartgruppe();
			$reihenfolge = $objLeistung->getSportart()->getReihenfolge();
	
			$arrLeistung = array();
			$arrLeistung['sportartname'] = $objLeistung->getSportart()->getName();
			$arrLeistung['ergebnisart'] = $objLeistung->getSportart()->getErgebnisart();
			$arrLeistung['leistungbronze'] = $objLeistung->getLeistungbronzeAsInt();
			$arrLeistung['leistungsilber'] = $objLeistung->getLeistungsilberAsInt();
			$arrLeistung['leistunggold'] = $objLeistung->getLeistunggoldAsInt();
			$arrLeistung['sportart'] = $objLeistung->getSportart()->getUid();
			$arrLeistung['leistung'] = $objLeistung->getUid();
			$arrLeistung['reihenfolge'] = $reihenfolge;
			$arrGruppen[$gruppe][] = $arrLeistung;
		}
		
		foreach($arrGruppen as $intGruppe => $arrGruppe){
			usort($arrGruppe, array('Tx_Blsvsa2013_Service_Ergebnisse', 'cmpReihenfolge'));
			$arrGruppen[$intGruppe] = array_values($arrGruppe);
		}
		return $arrGruppen;
	}

	/**
	 * Vergleichsfunktion fuer die Sortierung von Sportarten innerhalb einer Gruppe
	 * 
	 * @param array $a
	 * @param array $b
	 * @return number
	 */
	function cmpReihenfolge($a, $b){
		if ($a['reihenfolge'] == $b['reihenfolge']){
			return 0;
		}
		return ($a['reihenfolge'] < $b['reihenfolge']) ? -1 : 1;
	}
}