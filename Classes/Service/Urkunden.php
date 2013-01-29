<?php 
class Tx_Blsvsa2013_Service_Urkunden {
	public function __construct(){
	}
	
	public function getDaten($schule){
		$repTeilnahmen = t3lib_div::makeinstance('Tx_Blsvsa2013_Domain_Repository_TeilnahmenRepository');
		$teilnahmen = $repTeilnahmen->findAll();
		
		$urkunden = array();
		foreach($teilnahmen as $teilnahme){
			$urkunden[] = 
				array(
					'klasse_id' => 0,
					'klasse_name' => $teilnahme->getKlasse(),
					'schueler_id' => $teilnahme->getUid(),
					'schueler_nachname' => $teilnahme->getName(),
					'schueler_vorname' => $teilnahme->getVorname(),
					'schueler_geschlecht' => $teilnahme->getGeschlecht(),
					'schueler_pruefungen' => $teilnahme->getAnzteilnahmen(),
					'schueler_gedruckt' => $teilnahme->getGedruckt(),
					'schueler_alter' => 0, //$teilnahme->getAlter(),
			
					'abzeichen_name' => 'abzeichen',
					'abzeichen_zusatz' => '(zusatz)',
					'lfd_nr' => $teilnahme->getUrkundenLfdnr(),
			
					'schueler_druck_tstamp' => 0, //$teilnahme->getDruckstamp(),
					'schueler_tstamp' => 0, //$teilnahme->getTstamp(),
			
					'datum' => date('d.m.Y'),
				);
		}
		return $urkunden;
	}
}
?>