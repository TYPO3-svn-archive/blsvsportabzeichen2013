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
 * @package blsv_sa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Service_Tools{


/**
	 * erstelelle erstelleLoopArray
	 *
	 * @param int $anzahl
	 */
	static function erstelleLoopArray($anzahl=1,$start=1) {
		$erg = array();
		for ($i=$start; $i < $anzahl+$start; $i++){
			//$erg[] = array('value' => $i . " ");
			$erg[$i] = $i;
			
		}
		 
		return $erg;
	}
	
	/**
	 * ermittelt das Alter aus dem Geburtsdatum
	 * @param integer $geburtstag
	 * @return integer
	 */
	static function getAlter($geburtstag){
		$alter = date('Y') - date('Y', $geburtstag);
		return $alter;
	}
	
}