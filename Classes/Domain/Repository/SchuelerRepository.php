<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
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
 * @package blsvsa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Domain_Repository_SchuelerRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Pruefen, ob der angegebene Schueler bereits in der DB vorhanden ist
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Schueler $schueler Schueler der geprueft werden soll
	 * @return boolean
	 */
	public function inDb(Tx_Blsvsa2013_Domain_Model_Schueler $schueler){
		$query = $this->createQuery();		$query->matching(			$query->logicalAnd(
				$query->equals('schulnummer', $schueler->getSchulnummer(), false),
				$query->equals('name', $schueler->getName(), false),				$query->equals('vorname', $schueler->getVorname(), false),				$query->equals('geschlecht', $schueler->getGeschlecht()),				$query->equals('geburtstag', $schueler->getGeburtstag()),				$query->equals('klasse', $schueler->getKlasse(), false)			)		);		$query->setLimit(1);
		if ($query->execute()->count() > 0){
			return true;
		}
		return false;
	}
	
	/**
	 * Fuegt einen Schueler hinzu, falls noch nicht vorhanden
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Feuser $schueler hinzuzufuegender Schueler
	 * @return integer
	 */
	public function addNew(Tx_Blsvsa2013_Domain_Model_Schueler $schueler){
		if (!$this->inDb($schueler)){
			$res = $this->add($schueler);
			return 1;		}
		return 0;
	}
	
	/**
	 * Schueler nach Schulnummer und Klasse finden 
	 * und Sortieren nach name, vorname, geburtstag
	 * 
	 * @param string $schulnummer
	 * @param Tx_Blsvsa2013_Domain_Model_Klassen $klasse
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findBySchulnummerOrKlasseSorted($schulnummer, Tx_Blsvsa2013_Domain_Model_Klassen $klasse=null){
		$arrOrderings = array(
				'name' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING,
				'vorname' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING,
				'geburtstag' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING
		);
		$query = $this->createQuery();
		if (is_null($klasse)){
			$query->matching($query->equals('schulnummer', $schulnummer));
		} else {
			$query->matching(
				$query->logicalAnd(
					$query->equals('schulnummer', $schulnummer),
					$query->logicalAnd(
						$query->equals('geschlecht', $klasse->getGeschlecht()),
						$query->equals('klasse', $klasse->getKlasse())
					)
				)
			);
		}
		$query->setOrderings($arrOrderings);
		$schuelers = $query->execute();		
		return $schuelers;
	}
	
	/**
	 * Gibt die Anzahl der Schueler zurueck
	 * 
	 * @param string $schulnummer
	 * @return $anzahl Anzahl der Schueler
	 */
	public function getAnzahl($schulnummer){
		if ($schulnummer==0){
			throw new \Exception( "Tx_Blsvsa2013_Domain_Repository_SchuelerRepository invalid value for schulnummer (schulnummer={$schulnummer}}", 1352978551);
		}
		
		$query = $this->createQuery();
		$query->matching($query->equals('schulnummer', $schulnummer));
		return $query->execute()->count();
	}
	
	/**
	 * Gibt die Schueler gefiltert bei Namen zurück
	 *
	 * @param string $suchtext
	 * @return void
	 */
	public function findByName( $suchtext ){
		if ($suchtext==''){
			$erg="";
		}
		else{
			$query = $this->createQuery();
			$query->matching($query->like('name', $suchtext . '%' ));
								
			if(	$query->execute()->count() == 0 ){
				$erg='';
			}
			else{
				$erg = $query->setOrderings ( Array( 'name' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING,  'vorname' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING ) )->execute();
			}
		}
			return $erg;
	}
	
	
}
?>