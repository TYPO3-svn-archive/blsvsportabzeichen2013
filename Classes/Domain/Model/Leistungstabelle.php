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
class Tx_Blsvsa2013_Domain_Model_Leistungstabelle extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Leistung Bronze
	 *
	 * @var string
	 */
	protected $leistungbronze=1;

	/**
	 * Leistung Silber
	 *
	 * @var string
	 */
	protected $leistungsilber=2;

	/**
	 * Leistung Gold
	 *
	 * @var string
	 */
	protected $leistunggold=3;

	/**
	 * Sportart
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Sportarten
	 * @lazy
	 */
	protected $sportart;

	/**
	 * Altersgruppe
	 *
	 * @var Tx_Blsvsa2013_Domain_Model_Altersgruppen
	 * @lazy
	 */
	protected $altersgruppe;

	/**
	 * Returns the leistungbronze
	 *
	 * @return string $leistungbronze
	 */
	public function getLeistungbronze() {
		return $this->leistungbronze;
	}

	/**
	 * Sets the leistungbronze
	 *
	 * @param string $leistungbronze
	 * @return void
	 */
	public function setLeistungbronze($leistungbronze) {
		$this->leistungbronze = $leistungbronze;
	}

	/**
	 * Returns the leistungsilber
	 *
	 * @return string $leistungsilber
	 */
	public function getLeistungsilber() {
		return $this->leistungsilber;
	}

	/**
	 * Sets the leistungsilber
	 *
	 * @param string $leistungsilber
	 * @return void
	 */
	public function setLeistungsilber($leistungsilber) {
		$this->leistungsilber = $leistungsilber;
	}

	/**
	 * Returns the leistunggold
	 *
	 * @return string $leistunggold
	 */
	public function getLeistunggold() {
		return $this->leistunggold;
	}

	/**
	 * Sets the leistunggold
	 *
	 * @param string $leistunggold
	 * @return void
	 */
	public function setLeistunggold($leistunggold) {
		$this->leistunggold = $leistunggold;
	}

	/**
	 * Returns the sportart
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Sportarten $sportart
	 */
	public function getSportart() {
		if ('object' != gettype($this->sportart)){
			throw new \Exception(Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_domain_repository_leistungstabellenrepository.error_sportart_wert', 'blsvsa2013', array($this->getUid())), 1355327031);
		}
		return $this->sportart;
	}

	/**
	 * Sets the sportart
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Sportarten $sportart
	 * @return void
	 */
	public function setSportart(Tx_Blsvsa2013_Domain_Model_Sportarten $sportart) {
		$this->sportart = $sportart;
	}

	/**
	 * Returns the altersgruppe
	 *
	 * @return Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe
	 */
	public function getAltersgruppe() {
		return $this->altersgruppe;
	}

	/**
	 * Sets the altersgruppe
	 *
	 * @param Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe
	 * @return void
	 */
	public function setAltersgruppe(Tx_Blsvsa2013_Domain_Model_Altersgruppen $altersgruppe) {
		$this->altersgruppe = $altersgruppe;
	}


	/**
	 * liefert die Leistung als Integer
	 * 
	 * @param string $strLeistung
	 * @return string $intLeistung
	 */
	private function getLeistungAsInt($strLeistung){
		$intErgebnisart = $this->sportart->getErgebnisart();
		
		if (!(($intErgebnisart>0) && ($intErgebnisart<6))){
			throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for ergebnisart (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart", 1352812850);					
		}
		
		switch($intErgebnisart){
			// mm:ss Zeit in Sekunden
			case 1:
				if (preg_match('/([0-9]*):([0-9]{1,2})/', $strLeistung, $m)){
					$intLeistung = $m[1]*60 + $m[2];
				} else {
					throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for leistung (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart, leistung=$strLeistung", 1352812850);					
				}
				break;
				
			// ss,z Zeit in Zehntelsekunden 
			case 2:
				if (preg_match('/([0-9]*),([0-9])/', $strLeistung, $m)){
					$intLeistung = $m[1]*10 + $m[2];
				} else {
					throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for leistung (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart, leistung=$strLeistung", 1352812850);					
				}
				break;
				
			// mm,cc m Laenge in cm
			case 3:
				if (preg_match('/([0-9]*),([0-9]{1,2})/', $strLeistung, $m)){
					$intLeistung = $m[1]*100 + $m[2];
				} else {
					throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for leistung (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart, leistung=$strLeistung", 1352812850);					
				}
				break;
				
			//	4	xx	Punkte/Anzahl
			case 4:
				if (preg_match('/([0-9]{1,2})/', $strLeistung, $m)){
					$intLeistung = $m[1];
				} else {
					throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for leistung (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart, leistung=$strLeistung", 1352812850);					
				}
				break;
				
			//	5	mm:ss
			case 5:
				if (preg_match('/([0-9]*):([0-9]{1,2})/', $strLeistung, $m)){
					$intLeistung = $m[1]*60 + $m[2];
				} else {
					throw new \Exception( "Tx_Blsvsa2013_Domain_Model_Leistungstabelle invalid value for leistung (leistungstabelle={$this->uid}, ergebnisart=$intErgebnisart, leistung=$strLeistung", 1352812850);					
				}
				break;
		}
		
		return $intLeistung;
	}	
	
	/**
	 * Returns the leistungbronze
	 *
	 * @return integer $leistungbronze
	 */
	public function getLeistungbronzeAsInt() {
		return $this->getLeistungAsInt($this->leistungbronze);
	}

	/**
	 * Returns the leistungsilber
	 *
	 * @return integer $leistungsilber
	 */
	public function getLeistungsilberAsInt() {
		return $this->getLeistungAsInt($this->leistungsilber);
	}

	/**
	 * Returns the leistunggold
	 *
	 * @return integer $leistunggold
	 */
	public function getLeistunggoldAsInt() {
		return $this->getLeistungAsInt($this->leistunggold);
	}
}
?>