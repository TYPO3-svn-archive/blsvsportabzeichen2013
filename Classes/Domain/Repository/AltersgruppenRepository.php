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
class Tx_Blsvsa2013_Domain_Repository_AltersgruppenRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Gibt die Altersgruppe fuer den uebergebenen Schueler zurueck
	 * 
	 * @param $schueler (Tx_Blsvsa2013_Domain_Model_Schueler oder TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy)
	 * @return Tx_Blsvsa2013_Domain_Model_Altersgruppen $erg
	 */
	public function getBySchueler($schueler){
		$erg = Null;
        if (empty($schueler)) throw new \Exception(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_repository_altersgruppenrepository.error_kein_schueler', 'blsvsa2013'), 1350922669);
        
		$geschlecht = $schueler->getGeschlecht();
		$alter = Tx_Blsvsa2013_Service_Tools::getAlter($schueler->getGeburtstag());
		$query = $this->createQuery();
		$query->matching( $query->logicalAnd($query->equals( 'geschlecht',$geschlecht ),$query->logicalAnd( $query->lessThanOrEqual( 'altervon',$alter ),$query->greaterThanOrEqual( 'alterbis',$alter ) ) ) );
		$erg = $query->execute()->getFirst();
//		if(!$erg) throw new \Exception(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_repository_altersgruppenrepository.error_keine_altersgruppe', 'blsvsa2013', array($schueler->getUid())), 1350922669);
		return $erg;
	}
	
	/**
	 * Gibt die Altersgruppe zurueck
	 * 
	 * @param integer $geburtstag Geburtstag
	 * @param integer $geschlecht Geschlecht
	 * @return Tx_Blsvsa2013_Domain_Model_Altersgruppen $erg
	 */
	public function getByGeburtstagAndGeschlecht($geburtstag, $geschlecht){
		$erg = Null;
		$alter = Tx_Blsvsa2013_Service_Tools::getAlter($geburtstag);
		$query = $this->createQuery();
		$query->matching( $query->logicalAnd($query->equals( 'geschlecht',$geschlecht ),$query->logicalAnd( $query->lessThanOrEqual( 'altervon',$alter ),$query->greaterThanOrEqual( 'alterbis',$alter ) ) ) );
		$erg = $query->execute()->getFirst();
		return $erg;
	}
	
}
?>