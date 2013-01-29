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
class Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Pruefen, ob die angegebene Teilnahme bereits in der DB vorhanden ist
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme Teilnahme die geprueft werden soll
	 * @return boolean
	 */
	public function inDb(Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme){
		$query = $this->createQuery();
		$query->matching(
				$query->logicalAnd(
						$query->equals('schulnummer', $teilnahme->getSchulnummer(), false),
						$query->equals('name', $teilnahme->getName(), false),
						$query->equals('vorname', $teilnahme->getVorname(), false),
						$query->equals('geschlecht', $teilnahme->getGeschlecht()),
						$query->equals('geburtstag', $teilnahme->getGeburtstag()),
						$query->equals('klasse', $teilnahme->getKlasse(), false)
				)
		);
		$query->setLimit(1);
	
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
	public function addNew(Tx_Blsvsa2013_Domain_Model_Teilnahmen $teilnahme){
		if (!$this->inDb($teilnahme)){
			$res = $this->add($teilnahme);
			return 1;
		}
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
		$teilnahmen = $query->execute();
		//t3lib_utility_debug::debug( $teilnahmen );
		return $teilnahmen;
	}

	/**
	 * Gibt die Anzahl der Teilnahmen zurueck
	 * 
	 * @param string $schulnummer
	 * @return $anzahl Anzahl der Teilnahmen
	 */
	public function getAnzahl($schulnummer){
		if ($schulnummer==0){
			throw new \Exception( "Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository invalid value for schulnummer (schulnummer={$schulnummer}}", 1352978511);
		}
		
		$query = $this->createQuery();
		$query->matching($query->equals('schulnummer', $schulnummer));
		return $query->execute()->count();
	}
	
	/**
	 * Gibt die Anzahl der bestandenen Teilnahmen zurueck
	 * 
	 * @param string $schulnummer
	 * @return $anzahl Anzahl der bestandenen Teilnahmen
	 */
	public function getAnzahlBestanden($schulnummer){
		if ($schulnummer==0){
			throw new \Exception( "Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository invalid value for schulnummer (schulnummer={$schulnummer}}", 1352978511);
		}
		
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
					$query->equals('schulnummer', $schulnummer),
					$query->greaterThan('punktegesamt', 0)
			)
		);
		return $query->execute()->count();
	}
	
	/**
	 * Adds an object to this repository.
	 *
	 * @param object $object The object to add
	 * @return void
	 */
/*	public function add($object){
		$repAltersgruppen = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository');
		$objAltersgruppe = $repAltersgruppen->getBySchueler($object->getSchueler());
 t3lib_utility_debug::debug($objAltersgruppe);		
		if (objAltersgruppe){
//			parent::add($object);
			return 1;
		}
		return -1;
	}*/
	
	/**
	 * Teilnahmen insert/update von Teilnahmen-Array
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @param array $teilnahmen
	 * @param Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $schuelerRepository
	 * @param Tx_Blsvsa2013_Domain_Model_Feusers $feuser
	 * @param integer $pidTeilnahmen
	 * @return array
	 */
	public function insupdByTeilnahmen(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung, $teilnahmen, Tx_Blsvsa2013_Domain_Repository_SchuelerRepository $schuelerRepository, Tx_Blsvsa2013_Domain_Model_Feusers $feuser, $pidTeilnahmen){
		$info = array('insert' => null, 'update' => null, 'delete' => null);
		$vars = explode(',', 'vorname,name,geschlecht,geburtstag,klasse,grundschulwettbewerb,schwimmnachweisgueltigbis,schulnummer,anzteilnahmen');
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		
		// alte Teilnahmen der Bestellung holen
		$query = $this->createQuery();
		$query->matching($query->equals('bestellung', $bestellung));
		$oldTeilnahmen = $query->execute();

		// uids der neuen Teilnahmen
		$uidsTeilnahmen = array();
		foreach ($teilnahmen as $teilnahme){
			$uidsTeilnahmen[] = $teilnahme['uid'];
		}
		
		// Teilnahmen loeschen, falls nicht
		foreach($oldTeilnahmen as $oldTeilnahme){
			if (!in_array($oldTeilnahme->getUid(), $uidsTeilnahmen)){
				$info['delete'][] = $oldTeilnahme->getUid();
				$this->remove($oldTeilnahme);
			}
		}

		// neue Teilnahmen in DB eintragen
		foreach ($teilnahmen as $uidSchueler => $teilnahme){
			$tsDatum = 0;
			if (preg_match('/([0-9]{2})\.([0-9]{2})\.([0-9]{4})/', $teilnahme['datum'], $m)){
				$tsDatum = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
			}

			// Schueler suchen und Daten aktualisieren
			$objSchueler = $schuelerRepository->findOneByUid($uidSchueler);
			if (!$objSchueler) {
				die('Fehler: Schueler nicht gefunden');				
				// $this->errorFind('errorFindSchueler', $uid);
			}
			$objSchueler->setAnzteilnahmen((int)$teilnahme['anzahlteilnahmen']);
			$objSchueler->setJahrderletztenpruefung((int)$teilnahme['jahrderletztenpruefung']);

			// Teilnahmeobjekt holen
			$action = '';
			if (0 < (int)$teilnahme['uid']){
				$objTeilnahme = $this->findOneByUid($teilnahme['uid']);
				$action = 'update';
				if (!$objTeilnahme){
					die('Fehler: Teilnahme nicht gefunden');
					// $this->errorFind('errorFindTeilnahme', $teilnahme['uid']);
				}
			} else {
				$objTeilnahme = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Teilnahmen');
				$action = 'insert';
			}
			
			// Schueler nach Teilnahme kopieren
			foreach ($vars as $var){
				$var = ucfirst($var);
				$getFunc = 'get'.$var;
				$setFunc = 'set'.$var;
				$objTeilnahme->$setFunc($objSchueler->$getFunc());
			}
			
			// zusaetzliche Variablen setzen
			$objTeilnahme->setAblagedatum1($tsDatum);
			$objTeilnahme->setPruefungsjahr((int)$teilnahme['jahrderletztenpruefung']);
			$objTeilnahme->setSchueler($objSchueler);
			$objTeilnahme->setPunktegesamt((int)$teilnahme['punktegesamt']);
			
			$objTeilnahme->setFeuser($feuser);
			$objTeilnahme->setBestellung($bestellung);
			$objTeilnahme->setPid($pidTeilnahmen);
						
			// Teilnahme anlegen
			switch ($action){
				case 'insert':
					$this->add($objTeilnahme);					
					$persistenceManager->persistAll();
					$info['insert'][] = $objTeilnahme->getUid();
					break;
				case 'update':
					$info['update'][] = $objTeilnahme->getUid();
					// $this->update($objTeilnahme); // update nicht noetig
					break;
			}
		}
		return $info;
	}
	
}
?>