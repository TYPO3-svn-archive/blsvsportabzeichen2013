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
		$query = $this->createQuery();
		$query->matching(
				$query->logicalAnd(
						$query->equals('name', $schueler->getName(), false),
						$query->equals('vorname', $schueler->getVorname(), false),
						$query->equals('geschlecht', $schueler->getGeschlecht()),
						$query->equals('geburtstag', $schueler->getGeburtstag()),
						$query->equals('klasse', $schueler->getKlasse(), false)
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
	public function addNew(Tx_Blsvsa2013_Domain_Model_Schueler $schueler){
		if (!$this->inDb($schueler)){
			$this->add($schueler);
			return 1;
		}
		return 0;
	}
}
?>