<?php
define("INSTITUTIONSART_SCHULE", 2);

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
class Tx_Blsvsa2013_Domain_Repository_SchulenRepository extends Tx_Extbase_Persistence_Repository {
	
	
	/**
	 * Findet Schulen nach Status und Suchtext
	 * 
	 * @param array $bezirke Bezirke
	 * @param integer $status Status (0:alle, 1:mit Urk, 2:ohne Urk, 3:nicht Angem)
	 * @param string $suchtext
	 * @return Tx_Extbase_Persistence_QueryResultInterface
	 */
	public function findByAdmSearch($bezirke, $status, $suchtext=''){
		$arrOrderings = array(
//				'name' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING,
				'schulnummer' => Tx_Extbase_Persistence_Query::ORDER_DESCENDING,
		);
		$query = $this->createQuery();


		// cond fuer bezirk
		$boolFirst = false;
		if (!is_array($bezirke)){
			throw new \Tx_Blsvsa2013_Exception_Error('Tx_Blsvsa2013_Domain_Repository_SchulenRepository: Dem User ist kein Bezirk zugeordnet - ' . $GLOBALS['TSFE']->fe_user->user['uid'] , 1353598137 );
		}
		foreach ($bezirke as $bezirk){
			if ($boolFirst==false){
				$condBezirk = $query->equals('bezirk', $bezirk);
			} else {
				$condBezirk = $query->logicalOr(
						$condBezirk,
						$query->equals('bezirk', $bezirk)
				);
			}
		}
		$conditions = $condBezirk;
				
		// cond fuer status
		switch($status) {
			case 1: // mit urkunden
				$condStatus = $query->greaterThan('anzbestanden', 0); 
				break;
			
			case 2: // ohne urkunden
				$condStatus = $query->logicalAnd(
					$query->equals('anzbestanden', 0),
					$query->greaterThan('tstamp', 0)
				);
				break;
			
			case 3: // nicht angemeldet
				$condStatus = $query->logicalAnd(
					$query->equals('anzbestanden', 0),
					$query->equals('tstamp', 0)
				);
				break;
				
			default: // alle
				$condStatus = null;
		}
		if ($condStatus != null) {
			$conditions = $query->logicalAnd($conditions, $condStatus);
		}		
		
		// cond fuer suche
		$condSuche = 
			$query->logicalAnd(
				$query->equals('institutionsartart', INSTITUTIONSART_SCHULE),
				$query->logicalOr(
					$query->like('name', '%'.$suchtext.'%'),
					$query->like('schulnummer', '%'.$suchtext.'%')
				)
			);
		$conditions = $query->logicalAnd($conditions, $condSuche);

		// query
		$query->matching($conditions);
		$query->setOrderings($arrOrderings);
		$schulen = $query->execute();
		return $schulen;
	}
	
	/**
	 * 
	 * Debitor für Einzelbestellung finden
	 * Schule ist Insttitutionsart = 2
	 * @param array $debitorwahl
	 * 
	 */
	public function findDebitor($debitorwahl = NUll){
		$schulen= NULL;
		
		// echo $debitorwahl['debitorsuche'];
		if ( $debitorwahl !== NULL ){
			if ( is_numeric( $debitorwahl['debitorsuche'] ) ){
				
				$schulen[0] = $this->findByUid($debitorwahl['debitorsuche']);
				
				
			}
			else{
				$query = $this->createQuery();
				$arrOrderings = array(
						'name' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING);
				
				
				if	( $debitorwahl['institutionen'] == 0 ){    //alle auuser Schulen 2
					if ( $debitorwahl['bezirk'] == 0 ){
						$query->matching(
								$query->logicalAnd(
										$query->logicalNot($query->equals( 'institutionsartart', 2 ) ),
										$query->logicalOr(
												$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' ),
												$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' )
										)
								)
					
						);
					}
					else{
						$query->matching(
								$query->logicalAnd(
										$query->equals( 'bezirk', $debitorwahl[ 'bezirk' ] ),
										$query->logicalAnd(
												$query->logicalNot($query->equals( 'institutionsartart', 2 ) ),
												$query->logicalOr(
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' ),
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' )
												)
										)
								)
						);
							
					}
					
				}
				else 
				{
				
					if ( $debitorwahl['bezirk'] == 0 ){
						$query->matching(
								$query->logicalAnd(
												$query->equals( 'institutionsartart',$debitorwahl['institutionen'] ),
												$query->logicalOr(
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' ),
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' )
												)
								)
								
						);
					}
					else{
						$query->matching(
							$query->logicalAnd(
									$query->equals( 'bezirk', $debitorwahl[ 'bezirk' ] ),
									$query->logicalAnd(
											$query->equals( 'institutionsartart',$debitorwahl['institutionen'] ),
												$query->logicalOr(
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' ),
														$query->like( 'name','%' . $debitorwahl['debitorsuche'] . '%' )
												)
									)
							)
						);
									
					}
				}
					
				$query->setOrderings($arrOrderings);
				
				$schulen = $query->execute();
				$GLOBALS['TYPO3_DB']->debugOutput = true;
			}
		
		
				
		
		}
		
		return $schulen;
	}
}
?>