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
class Tx_Blsvsa2013_Domain_Repository_LeistungstabelleRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Gibt die Leistungen fuer die uebergebene Altersgruppe zurueck
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Altersgruppen $objAltersgruppe
	 * @throws Tx_Blsvsa2013_Exception_Error
	 * @return array $erg
	 */
	public function getByAltersgruppe(Tx_Blsvsa2013_Domain_Model_Altersgruppen $objAltersgruppe){
		$erg = null;
		if (empty($objAltersgruppe)) {
			throw new Tx_Blsvsa2013_Exception_Error('Es muss eine Altersgruppe übergeben werden', 1351159647);
		}
		
		$query = $this->createQuery();
		$query->matching( $query->equals('altersgruppe', $objAltersgruppe->getUid() ) );
		$erg = $query->execute();
				
		if(!$erg) {
			throw new Tx_Blsvsa2013_Exception_Error('Für die Altersgruppe konnte keine Leistungstabelle zugeordnet werden!',1351159675 );
		}
		return $erg;
	}
}
?>