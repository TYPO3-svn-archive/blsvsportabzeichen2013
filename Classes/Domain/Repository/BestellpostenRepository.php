<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Berti Golf <berti.golf@blsv.de>, BLSV
 *  Martin Gonschor <martin.gonschOr@blsv.de>, blsv
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
 * @package blsvsa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Domain_Repository_BestellpostenRepository extends Tx_Extbase_Persistence_Repository {

	
	/**
	 * Bestellposten insert/update von Bestellposten-Array
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @param array $arrBestellpostens
	 * @param Tx_Blsvsa2013_Domain_Repository_ArtikelRepository $artikelRepository
	 * @param integer $pidBestellposten
	 * @return array
	 */
	public function insupdByBestellposten(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung, $arrBestellpostens, Tx_Blsvsa2013_Domain_Repository_ArtikelRepository $artikelRepository, $pidBestellposten){
		$info = array('insert'=> NULL, 'update' => NULL);
		$persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
		$artikels = $artikelRepository->findall();
		
		// Bestellposten initialisieren
		$bestellpostens = array();
		foreach ($artikels as $artikel){
			$newBestellposten = t3lib_div::makeInstance('Tx_Blsvsa2013_Domain_Model_Bestellposten');
			$newBestellposten->setArtikel($artikel);
			$bestellpostens[$artikel->getUid()] = $newBestellposten;
		}
		
		// Bestellposten anlegen bzw. aktualisieren
		foreach ($arrBestellpostens as $artikelUid => $artikelAnzahl){
			$query = $this->createQuery();
			$query->matching(
					$query->logicalAnd(
							$query->equals('bestellung', $bestellung),
							$query->equals('artikel', $artikelUid)
					)
			);
			$query->setLimit(1);
			$res = $query->execute();
				
			switch (count($res)){
				case 0:
					$insBestellposten = $bestellpostens[$artikelUid];
					$insBestellposten->setBestellung($bestellung);
					$insBestellposten->setPid($pidBestellposten);
					$insBestellposten->setAnzahl($artikelAnzahl);
					$this->add($insBestellposten);
					$persistenceManager->persistAll();
					$info['insert'][] = $insBestellposten->getUid();
					break;
				case 1:
					$updBestellposten = $res->getFirst();
					$updBestellposten->setAnzahl($artikelAnzahl);
					// $this->update($updBestellposten);
					$info['update'][] = $updBestellposten->getUid();
					break;
				default:
					die('Fehler: Bestellposteneintrag darf nicht doppelt sein!');
					break;
			}
		}
		return $info;
	}
}
?>