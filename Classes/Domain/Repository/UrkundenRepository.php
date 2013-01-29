<?php
/**
 *
 *
 * @package blsvsa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Domain_Repository_UrkundenRepository extends Tx_Extbase_Persistence_Repository {
	public function confirmByBezirkAndSchule($bezirk, $schuleUid=0, $status=0, $druck=false) {
/*		echo $schuleUid;
		echo '<br>';
		echo $status;
		echo '<br>';*/
		
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		
		if ($druck){
			$sqlDruck = 'teilnahmen_gedruckt = teilnahmen_gedruckt+1,';
		} else {
			$sqlDruck = '';
		}
		
		$sql = 
			'UPDATE tx_blsvsa2013_domain_model_urkunden SET '.
			$sqlDruck.
			'teilnahmen_tstamp = unix_timestamp(),'.
			'teilnahmen_drucktstamp = unix_timestamp() '.
			'WHERE schule_bezirk=? AND schule_uid=? AND status=?';
		
		$query->statement($sql, array('schule_bezirk'=>$bezirk, 'schule_uid'=>$schuleUid, 'status'=>$status));
		$query->execute();
	}
	
	public function findByBezirkAndSchule($bezirk, $schuleUid=0, $status=0) {
		switch ($auswahl){
			case 'gedruckt':
				$cond = ' AND status=1 OR status=2';
				break;
			case 'ungedruckt':
				$cond = ' AND status=0';
				break;
			default:
				$cond = '';
		}
	
		// ! sql
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement('SELECT * FROM tx_blsvsa2013_domain_model_urkunden WHERE schule_bezirk=? AND schule_uid=? AND status=?', 
			array('schule_bezirk'=>$bezirk, 'schule_uid'=>$schuleUid, 'status'=>$status));
		$data = $query->execute();
		return $data;
	}
	
	/**
	 * 
	 * @param integer $bezirk
	 * @param string $auswahl
	 * @return array $data
	 */
	public function findByBezirk($bezirk, $auswahl=''){
		switch ($auswahl){
			case 'gedruckt':
				$cond = ' AND status=1 OR status=2';
				break;
			case 'ungedruckt':
				$cond = ' AND status=0';
				break;
			default:
				$cond = '';
		}

		// ! sql
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement('SELECT *, count(1) as anzurkunden FROM tx_blsvsa2013_domain_model_urkunden WHERE schule_bezirk=?'.$cond.' GROUP BY status, schule_uid', array($bezirk));
		$data = $query->execute();
		return $data;
	}
	
	/**
	 * 
	 * @param integer $bezirk
	 * @return array $statistik
	 */
	public function getStatistik($bezirk){
		// ! sql
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement('SELECT * FROM tx_blsvsa2013_domain_model_urkunden WHERE schule_bezirk=?', array($bezirk));
		$data = $query->execute();

		$schulen = array();
		$klassen = array();
		$teilnahmen = array();
		foreach ($data as $row){
			$teilnahmen['gesamt'][$row['teilnahmen_uid']] = 1;
			$klassen['gesamt'][$row['teilnahmen_klasse']] = 1;
			$schulen['gesamt'][$row['schule_uid']] = 1;
			if(0<$row['status']) {
				$teilnahmen['gedruckt'][$row['teilnahmen_uid']] = 1;
				$klassen['gedruckt'][$row['teilnahmen_klasse']] = 1;
				$schulen['gedruckt'][$row['schule_uid']] = 1;
			} else {
				$teilnahmen['ungedruckt'][$row['teilnahmen_uid']] = 1;
				$klassen['ungedruckt'][$row['teilnahmen_klasse']] = 1;
				$schulen['ungedruckt'][$row['schule_uid']] = 1;
			}		
		}

		$statistik = array(
				'bezirk' => $bezirk,
					
				'anzSchulen' => count($schulen['gesamt']),
				'anzSchulenUngedruckt' => count($schulen['ungedruckt']),
				'anzSchulenGedruckt' => count($schulen['gedruckt']),
		
				'anzKlassen' => count($klassen['gesamt']),
				'anzKlassenUngedruckt' => count($klassen['ungedruckt']),
				'anzKlassenGedruckt' => count($klassen['gedruckt']),
					
				'anzTeilnahmen' => count($teilnahmen['gesamt']),
				'anzTeilnahmenUngedruckt' => count($teilnahmen['ungedruckt']),
				'anzTeilnahmenGedruckt' => count($teilnahmen['gedruckt'])
		);
		return $statistik;
	}

	/**
	 * Urkunden fuer eine Bestellung finden
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @return unknown
	 */
	public function findByBestellung(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung) {
		// ! sql
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		$query->statement('SELECT * FROM tx_blsvsa2013_domain_model_urkunden WHERE teilnahmen_bestellung=?',
				array('bestellung'=>$bestellung->getUid())
		);
		$data = $query->execute();
		return $data;
	}
	
	/**
	 * Urkunden fuer Bestellung bestaetigen
	 * 
	 * @param Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung
	 * @param string $druck
	 */
	public function confirmByBestellung(Tx_Blsvsa2013_Domain_Model_Bestellung $bestellung, $druck=false) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);
		
		if ($druck){
			$sqlDruck = 'teilnahmen_gedruckt = teilnahmen_gedruckt+1,';
		} else {
			$sqlDruck = '';
		}
		
		$sql =
			'UPDATE tx_blsvsa2013_domain_model_urkunden SET '.
			$sqlDruck.
			'teilnahmen_tstamp = unix_timestamp(),'.
			'teilnahmen_drucktstamp = unix_timestamp() '.
			'WHERE teilnahmen_bestellung=?';
		
		$query->statement($sql, array('bestellung'=>$bestellung->getUid()));
		$query->execute();
		
		$bestellung->setStatus(4);
	}
}
?>