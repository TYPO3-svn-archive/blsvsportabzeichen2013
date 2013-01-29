<?php
$fpdfClass = PATH_typo3conf . 'ext/blsvsa2013/Classes/Lib/fpdf/fpdf.php';
if (!file_exists($fpdfClass)){
	throw new \Exception('Tx_Blsvsa2013_Service_Urkunden: error loading FPDF lib', 1353582862);
}
require_once $fpdfClass;

/**
 *
 *
 * @package blsv_sa2013
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Service_PdfUrkunden extends FPDF {
	var $extensionName = 'blsvsa2013';
	var $bild = null;
	var $inhalte = null;
	var $statistik = null;
	var $medaillen = null;

	
	public function __construct() {
		parent::__construct('P', 'mm', 'A5');
	}
	
	function sendData($data, $name, $ext) {
		$name = $name . '.' . $ext;
		$len = strlen($data);
	
		header('Content-Type: application/x-download');
		header('Content-Length: ' . $len);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Pragma: public');
		echo $data;
		exit;
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Hilfsfunktion fuer die Sortierung nach Schuelern
	 */
	function sort_schueler($za, $zb)
	{
		$a = $za['teilnahmen_vorname'].$za['teilnahmen_nachname'];
		$b = $zb['teilnahmen_vorname'].$zb['teilnahmen_nachname'];
		if($a==$b) { return 0; }
		return ($a<$b)?-1:+1;
	}
	
	/**
	 * Hilfsfunktion fuer die Sortierung nach Klassen und Schuelern ( nach Din 5007-2 ;-) )
	 */
	function sort_klassen($za, $zb)
	{
		//		$a = $za['teilnahmen_klasse'].$za['teilnahmen_vorname'].$za['teilnahmen_nachname'];
		//		$b = $zb['teilnahmen_klasse'].$zb['teilnahmen_vorname'].$zb['teilnahmen_nachname'];
	
		//		$a = $za['teilnahmen_klasse'].$za['teilnahmen_nachname'].$za['teilnahmen_vorname'];
		//		$b = $zb['teilnahmen_klasse'].$zb['teilnahmen_nachname'].$zb['teilnahmen_vorname'];
	
		$search = array('/ä/', '/ö/', '/ü/', '/ß/');
		$replace = array('ae', 'oe', 'ue', 'ss');
		$a = preg_replace($search, $replace, strtolower($za['teilnahmen_klasse'].$za['teilnahmen_nachname'].$za['teilnahmen_vorname']));
		$b = preg_replace($search, $replace, strtolower($zb['teilnahmen_klasse'].$zb['teilnahmen_nachname'].$zb['teilnahmen_vorname']));
	
		if($a==$b) { return 0; }
		return ($a<$b)?-1:+1;
	}
	
	function create($daten, &$opt)
	{
		$this->bild = isset($opt['bild']) ? $opt['bild'] : null;
		$this->inhalte = isset($opt['inhalte']) ? explode(',', $opt['inhalte']) : array('uebersicht', 'urkunden');
		$this->medaillen = isset($opt['medaillen']) ? $opt['medaillen'] : null;
		$tabelle =& $daten['tabelle'];
	
		foreach($this->inhalte as $inhalt) {
			switch($inhalt) {
				case 'packliste':
					$this->createStatistik($tabelle);
					$this->writeUebersichtEintrag($tabelle, $this->statistik['schule'], 'Allgemeine Infos (Schule)');
					foreach($this->statistik['klassen'] as $klasse => $eintrag_klasse) {
						$this->writeUebersichtEintrag($tabelle, $eintrag_klasse, 'Allgemeine Infos (Klasse '.$eintrag_klasse['infos']['Klasse'].')');
					}
					$this->writeSchuelerKlasse($tabelle);
					break;
	
				case 'urkunden':
					$this->writeUrkunden($tabelle);
					break;
	
				case 'ansicht':
					$this->writeUrkunden($tabelle);
					break;
			}
		}
		//		$this->writeUebersicht($tabelle);
	
		$this->SetDisplayMode('fullpage');

		$filename = isset($opt['name'])?$opt['name']:'export';
		$this->sendData($this->Output(null, 'S'), $filename, 'pdf');
	}
	
	
	function Cell($w, $h=0, $txt='', $border=null, $ln=null, $align=null, $fill=null, $link=null)
	{
		// $txt = utf8_encode($txt);
		parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
	}
	
	function writeXY($x, $y, $text)
	{
		$cs=8;
		$this->SetXY($x,$y-$cs);
		$this->Cell(0,$cs,$text,0,0);
	}
	
	function writeUebersicht($tabelle)
	{
		$x=10; $y=10;
	
		$this->AddPage();
		$this->SetFont('Arial','B', 16);
	
		$this->SetXY($x,$y);
		$this->Cell(0,6,'Urkunden - Deutsches Sportabzeichen');
		$y+=6;
	
		$this->SetFont('Arial','B', 10);
		 
		$uebersicht = array(
				'Bezirk-Nr.' 	=> $tabelle[0]['schule_bezirk'],
				'Kreis-Nr.'	 	=> $tabelle[0]['schule_kreis'],
				'Schule'		=>	$tabelle[0]['schule_name']."\n".
				$tabelle[0]['schule_strasse']."\n".
				$tabelle[0]['schule_plz'].' '.$tabelle[0]['schule_ort'],
				'Klasse'		=> $tabelle[0]['teilnahmen_klasse'],
				'Datum'			=> $tabelle[0]['datum'],
		);
	
		$y+=8;
		$this->SetXY($x,$y);
		$this->Cell(0,6,'Allgemeine Infos');
		$y+=6;
		foreach ($uebersicht as $name => $wert)
		{
			$this->SetXY($x,$y);
			if ('Schule' == $name)
			{
				$this->Cell(30, 6, $name,1);
	
				$this->SetXY($x+30,$y);
				$this->MultiCell(0, 6, $wert,1);
	
				$y+=2*12;
			}
			else
			{
				$this->Cell(0, 6, $name,1);
				$this->SetXY($x+30,$y);
				$this->MultiCell(0, 6, $wert,1);
				$y+=12;
			}
		}
	
		$statistik = $this->getMedaillen($tabelle);
		$y+=8;
		$this->SetXY($x,$y);
		$this->Cell(0, 6, 'Medaillen');
		$y+=6;
		foreach ($statistik as $name => $wert)
		{
			$this->SetXY($x,$y);
			$this->Cell(0, 6, $name, 1);
			$this->SetXY($x+30,$y);
			$this->Cell(0, 6, $wert, 1);
			$y+=6;
		}
	
		$i=0;
		$y+=8;
		$this->SetXY($x,$y);
		$this->AddPage();
		$y=10;
		$this->Cell(0,6,'Schüler');
		$y+=6;
		foreach ($tabelle as $eintrag)
		{
			$i++;
			if (0 == ($i-0)%29) {
				$this->AddPage();
				$y=10;
			}
	
			$this->SetXY($x,$y);
			//$this->Cell(0,6,$eintrag['teilnahmen_nachname'],1);
			//$this->SetXY($x+20,$y);
			//$this->Cell(0,6,$eintrag['teilnahmen_vorname'],1);
			$this->Cell(0,6,$eintrag['teilnahmen_nachname'].', '.$eintrag['teilnahmen_vorname'],1);
				
			$this->SetXY($x+65,$y);
			$this->Cell(0,6,$eintrag['teilnahmen_pruefungen'],1);
			$this->SetXY($x+72,$y);
			$this->Cell(0,6,$eintrag['teilnahmen_abzeichenname'],1);
			$this->SetXY($x+90,$y);
			$this->Cell(0,6,$this->getAbzeichenzusatz($eintrag['teilnahmen_abzeichenzusatz'], true),1);
			$this->SetXY($x+95,$y);
			$this->Cell(0,6,$eintrag['uid'],1);
			$y+=6;
		}
	}
	
	function getMedaillen($tabelle)
	{
		$statistik = array();
		 
		$tmp_stat = array();
		if (!empty($tabelle)) {
			foreach ($tabelle as $eintrag) {
				$ind = $eintrag['teilnahmen_abzeichenname'].' '.$this->getAbzeichenzusatz($eintrag['teilnahmen_abzeichenzusatz']);
				if (!isset($tmp_stat[$ind]['anzahl'])) {
					$tmp_stat[$ind]['anzahl'] = 1;
					$tmp_stat[$ind]['name'] = $eintrag['teilnahmen_abzeichenname'];
				} else {
					$tmp_stat[$ind]['anzahl'] += 1;
				}
			}
			ksort($tmp_stat);
	
			$gesamt = 0;
			$statistik['Gesamt'] = 0;
			foreach($tmp_stat as $stat) {
				$statistik[$stat['name']] = $stat['anzahl'];
				$gesamt += $stat['anzahl'];
			}
			$statistik['Gesamt'] = $gesamt;
		}
		return $statistik;
	}
	
	function writeUrkunden($tabelle)
	{
		usort($tabelle, array($this, 'sort_klassen'));
		if (!empty($tabelle)) {
			foreach ($tabelle as $eintrag) {
				$this->writeUrkunde($eintrag);
			}
		}
	}
	
	function writeUrkunde($eintrag)
	{
		$offs_x = 0;
		$offs_y = 0;
	
		$x = $offs_x + 65;
		$y = $offs_y + 80;
	
		$this->AddPage();
		if (!empty($this->bild))
		{
			//$this->Image(t3lib_extMgm::extPath('blsv_schulwettbewerb').'lib/urkunde.jpg',0,0,148);
			$this->Image($this->bild,0,0,148);
		}
	
		$this->SetFont('Arial','B', 20);
		$this->SetXY($x-10,$y);
		$this->cell(50,8,$eintrag['teilnahmen_abzeichenname'],0,0,'C');
		$this->SetFont('Arial','B', 14);
		$y  = $y + 8;
		$this->SetXY($x-10,$y);
		$this->cell(50,8,$this->getAbzeichenzusatz($eintrag['teilnahmen_abzeichenzusatz']),0,0,'C');
	
	
		$this->SetFont('Arial','B', 14);
		$y=105;
		$this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['teilnahmen_pruefungen'],0,0,'C');
		//$y = 105;		$this->writeXY($x,$y,$eintrag['teilnahmen_pruefungen']);
		$this->SetFont('Arial','B', 20);
		$y += 9;
		$this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['teilnahmen_vorname'].' '.$eintrag['teilnahmen_nachname'],0,0,'C');
		//$this->writeXY($x-18,$y,$eintrag['teilnahmen_vorname'].' '.$eintrag['teilnahmen_nachname']);
		$this->SetFont('Arial','B', 14);
		//$y += 9;		$this->writeXY($x-18,$y,$eintrag['uid']);
		$y += 9;
		$this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['uid'],0,0,'C');
	
		$this->SetFont('Arial','B', 14);
		$y += 66+0.5;		$this->writeXY($x-15,$y,$eintrag['datum']);
	}
	
	function writeTest($eintrag)
	{
		echo '<pre>';
		print_r($eintrag);
		echo '</pre>';
	}
	
	/**
	 * Funktion erstellt Statistik fuer Schule und fuer alle Klassen
	 */
	function createStatistik($tabelle)
	{
		$infos = array();
		$tmp_stat = array();
		$tmp_stat_ges = array();
	
		if (!empty($tabelle)) {
			foreach ($tabelle as $eintrag) {
				// Allgemeine Infos zur Klasse
				if(!isset($this->statistik['klassen'][$eintrag['teilnahmen_klasse']]['infos'])) {
					$this->statistik['klassen'][$eintrag['teilnahmen_klasse']]['infos'] = array(
							'Bezirk-Nr.' 	=> $eintrag['schule_bezirk'],
							'Kreis-Nr.' 	=> $eintrag['schule_kreis'],
							'Schule'	=> $eintrag['schule_name']."\n".
							$eintrag['schule_strasse']."\n".
							$eintrag['schule_plz'].' '.$tabelle[0]['schule_ort'],
							'Klasse'	=> $eintrag['teilnahmen_klasse'],
							'Datum'		=> $eintrag['datum'],
					);
				}
	
				$ind = $eintrag['teilnahmen_abzeichenname'].' '.$this->getAbzeichenzusatz($eintrag['teilnahmen_abzeichenzusatz']);
				// Medaillen fuer Klassenstatistik
				if (!isset($tmp_stat[$eintrag['teilnahmen_klasse']][$ind]['anzahl'])) {
					$tmp_stat[$eintrag['teilnahmen_klasse']][$ind]['anzahl'] = 1;
					$tmp_stat[$eintrag['teilnahmen_klasse']][$ind]['name'] = $ind;
				} else {
					$tmp_stat[$eintrag['teilnahmen_klasse']][$ind]['anzahl'] += 1;
				}
	
				// Medaillen fuer Gesamtstatistik
				if (!isset($tmp_stat_ges[$ind]['anzahl'])) {
					$tmp_stat_ges[	$ind	]	['anzahl'] = 1;
					$tmp_stat_ges[$ind]['name'] = $ind;
				} else {
					$tmp_stat_ges[$ind]['anzahl'] += 1;
				}
			}
		}
	
		ksort($this->statistik['klassen']);
		ksort($tmp_stat_ges);
		foreach($tmp_stat as $klasse => $stat_data) {
			ksort($tmp_stat[$klasse]);
		}
		
		// Medaillen fuer Klassen
		$gesamt = array();
		foreach($tmp_stat as $klasse => $stat_data) {
			$this->statistik['klassen'][$klasse]['medaillen'] = $this->medaillen;
			$this->statistik['klassen'][$klasse]['medaillen']['Gesamt'] = 0;
			foreach($tmp_stat[$klasse] as $stat) {
				$this->statistik['klassen'][$klasse]['medaillen'][$stat['name']] += $stat['anzahl'];
				$gesamt[$klasse] += $stat['anzahl'];
			}
			$this->statistik['klassen'][$klasse]['medaillen']['Gesamt'] = $gesamt[$klasse];
		}

		// Infos fuer Schule
		$this->statistik['schule']['infos'] = array(
				'Bezirk-Nr.'	=> $eintrag['schule_bezirk'],
				'Kreis-Nr.'	=> $eintrag['schule_kreis'],
				'Schule'	=> $eintrag['schule_name']."\n".
				$eintrag['schule_strasse']."\n".
				$eintrag['schule_plz'].' '.$tabelle[0]['schule_ort'],
				'Anz. Klassen'	=> count($tmp_stat),
				'Datum'		=> $eintrag['datum'],
		);
	
		// Medaillen fuer Schule
		$medaillen_ges = array();
		$gesamt_ges = 0;
		$this->statistik['schule']['medaillen'] = $this->medaillen;
		$this->statistik['schule']['medaillen']['Gesamt'] = 0;
		foreach($tmp_stat_ges as $stat) {
			$this->statistik['schule']['medaillen'][$stat['name']] += $stat['anzahl'];
			$gesamt_ges += $stat['anzahl'];
		}
		$this->statistik['schule']['medaillen']['Gesamt'] = $gesamt_ges;	
		// if($_GET['test']==1) { echo '<pre>'; print_r($this->statistik); print_r($tabelle); exit; }
	}
	
	function writeUebersichtEintrag($tabelle, $eintrag, $info)
	{
		$x=10; $y=10;
		$this->AddPage();
		$this->SetFont('Arial','B', 16);
	
		$this->SetXY($x,$y);
		$this->Cell(0,6,'Urkunden - Deutsches Sportabzeichen');
		$y+=6;
	
		$this->SetFont('Arial','B', 10);
		 
		$y+=8;
		$this->SetXY($x,$y);
		$this->Cell(0,6,$info);
		$y+=6;
		foreach ($eintrag['infos'] as $name => $wert)
		{
			$this->SetXY($x,$y);
			if ('Schule' == $name)
			{
				$this->Cell(30, 6, $name,1);
				$this->SetXY($x+30,$y);
				$this->MultiCell(0, 6, $wert,1);
				$y+=2*12;
			}
			else
			{
				$this->Cell(0, 6, $name,1);
				$this->SetXY($x+30,$y);
				$this->MultiCell(0, 6, $wert,1);
				$y+=12;
			}
		}
	
		$y+=8;
		$this->SetXY($x,$y);
		$this->Cell(0, 6, 'Medaillen');
		$y+=6;
		foreach ($eintrag['medaillen'] as $name => $wert)
		{
			if ($wert>0) {
				$this->SetXY($x,$y);
				$this->Cell(0, 6, $name, 1);
				$this->SetXY($x+80,$y);
				$this->Cell(0, 6, $wert, 1);
				$y+=6;
			}
		}
	}
	
	function writeSchuelerKlasse($tabelle)
	{
		usort($tabelle, array($this, 'sort_klassen'));
		$i=0;
		$klasse = '';
		foreach ($tabelle as $eintrag)
		{
			if ($klasse!=$eintrag['teilnahmen_klasse']) {
				$klasse = $eintrag['teilnahmen_klasse'];
				$this->AddPage();
	
				$x=10; $y=10;
				$this->SetXY($x,$y);
				$this->Cell(0,6,'Schüler - Klasse ('.$klasse.')');
				$y+=6;
			}
	
			$i++;
			if (0 == ($i-0)%29) {
				$this->AddPage();
				$y=10;
			}
			$this->SetXY($x,$y);
			//$this->Cell(0,6,$eintrag['teilnahmen_nachname'],1);
			//$this->SetXY($x+20,$y);
			//$this->Cell(0,6,$eintrag['teilnahmen_vorname'],1);
			$this->Cell(0,6,$eintrag['teilnahmen_nachname'].', '.$eintrag['teilnahmen_vorname'],1);
				
			$this->SetXY($x+65,$y);
			$this->Cell(0,6,$eintrag['teilnahmen_pruefungen'],1);
			$this->SetXY($x+72,$y);
			$this->Cell(0,6,$eintrag['teilnahmen_abzeichenname'],1);
			$this->SetXY($x+90,$y);
			$this->Cell(0,6,$this->getAbzeichenzusatz($eintrag['teilnahmen_abzeichenzusatz'],true),1);
			$this->SetXY($x+95,$y);
			$this->Cell(0,6,$eintrag['uid'],1);
			$y+=6;
		}
	}
	
	function getAbzeichenzusatz($abzeichenzusatz, $kurz=false){
		if ($kurz){
			$abzeichenzusatz = strtoupper($abzeichenzusatz);
		} else {
			$abzeichenzusatz = Tx_Extbase_Utility_Localization::translate('tx_blsvsa2013_urkunden_abzeichenzusatz.'.$abzeichenzusatz, $this->extensionName);
		}
		
		return $abzeichenzusatz;
	}	
}