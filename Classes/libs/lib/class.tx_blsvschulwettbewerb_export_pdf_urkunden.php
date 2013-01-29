<?php
require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb').'lib/fpdf/fpdf.php');
// require_once('fpdf/fpdf.php');

class tx_blsvschulwettbewerb_export_pdf_urkunden extends FPDF
{	
	var $bild = null;
	var $inhalte = null;
	var $statistik = null;
	var $medaillen = null;
	
	function __construct()
	{
		parent::__construct('P', 'mm', 'A5');
	}

	/** 
	 * Hilfsfunktion fuer die Sortierung nach Schuelern
	 */
	function sort_schueler($za, $zb)
	{
		$a = $za['schueler_vorname'].$za['schueler_nachname'];
		$b = $zb['schueler_vorname'].$zb['schueler_nachname'];
		if($a==$b) { return 0; }
		return ($a<$b)?-1:+1;
	}

	/**
	 * Hilfsfunktion fuer die Sortierung nach Klassen und Schuelern ( nach Din 5007-2 ;-) )
	 */
	function sort_klassen($za, $zb)
	{
//		$a = $za['klasse_name'].$za['schueler_vorname'].$za['schueler_nachname'];
//		$b = $zb['klasse_name'].$zb['schueler_vorname'].$zb['schueler_nachname'];

//		$a = $za['klasse_name'].$za['schueler_nachname'].$za['schueler_vorname'];
//		$b = $zb['klasse_name'].$zb['schueler_nachname'].$zb['schueler_vorname'];
		
		$search = array('/ä/', '/ö/', '/ü/', '/ß/');
		$replace = array('ae', 'oe', 'ue', 'ss');
		$a = preg_replace($search, $replace, strtolower($za['klasse_name'].$za['schueler_nachname'].$za['schueler_vorname']));
		$b = preg_replace($search, $replace, strtolower($zb['klasse_name'].$zb['schueler_nachname'].$zb['schueler_vorname']));
		
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
		$opt['ext'] = 'pdf';
		$opt['ausgabe'] = $this->Output(null, 'S');
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
			'Klasse'		=> $tabelle[0]['klasse_name'],
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
			//$this->Cell(0,6,$eintrag['schueler_nachname'],1);
	    		//$this->SetXY($x+20,$y);
			//$this->Cell(0,6,$eintrag['schueler_vorname'],1);
			$this->Cell(0,6,$eintrag['schueler_nachname'].', '.$eintrag['schueler_vorname'],1);
			
	    	$this->SetXY($x+65,$y);
			$this->Cell(0,6,$eintrag['schueler_pruefungen'],1);
	    	$this->SetXY($x+72,$y);
			$this->Cell(0,6,$eintrag['abzeichen_name'],1);
	    	$this->SetXY($x+90,$y);
			$this->Cell(0,6,substr($eintrag['abzeichen_zusatz'],1,1),1);
	    	$this->SetXY($x+95,$y);
			$this->Cell(0,6,$eintrag['lfd_nr'],1);
	    	$y+=6;
		}
	}

	function getMedaillen($tabelle)
	{
	    $statistik = array();
	    
	    $tmp_stat = array();
		if (!empty($tabelle)) {
	    	foreach ($tabelle as $eintrag) {
	    		if (!isset($tmp_stat[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'])) {
	    			$tmp_stat[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'] = 1;
	    			$tmp_stat[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['name'] = $eintrag['abzeichen_name'];
	    		} else {
	    			$tmp_stat[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'] += 1;
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
		$this->cell(50,8,$eintrag['abzeichen_name'],0,0,'C');
	        $this->SetFont('Arial','B', 14);
	        $y  = $y + 8;
	        $this->SetXY($x-10,$y);
		$this->cell(50,8,$eintrag['abzeichen_zusatz'],0,0,'C');
		
		
	    	$this->SetFont('Arial','B', 14);
	    	$y=105;
	    	 $this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['schueler_pruefungen'],0,0,'C');
		//$y = 105;		$this->writeXY($x,$y,$eintrag['schueler_pruefungen']);
		$this->SetFont('Arial','B', 20);
		$y += 9;		
		$this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['schueler_vorname'].' '.$eintrag['schueler_nachname'],0,0,'C');
		//$this->writeXY($x-18,$y,$eintrag['schueler_vorname'].' '.$eintrag['schueler_nachname']);
		$this->SetFont('Arial','B', 14);
		//$y += 9;		$this->writeXY($x-18,$y,$eintrag['lfd_nr']);
		$y += 9;
		$this->SetXY($x-10,$y-8);
		$this->cell(50,8,$eintrag['lfd_nr'],0,0,'C');

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
				if(!isset($this->statistik['klassen'][$eintrag['klasse_name']]['infos'])) {
					$this->statistik['klassen'][$eintrag['klasse_name']]['infos'] = array(
						'Bezirk-Nr.' 	=> $eintrag['schule_bezirk'],
						'Kreis-Nr.' 	=> $eintrag['schule_kreis'],
						'Schule'	=> $eintrag['schule_name']."\n".
									$eintrag['schule_strasse']."\n".
									$eintrag['schule_plz'].' '.$tabelle[0]['schule_ort'],
						'Klasse'	=> $eintrag['klasse_name'],
					    	'Datum'		=> $eintrag['datum'],
					);
				}

				// Medaillen fuer Klassenstatistik
		    		if (!isset($tmp_stat[$eintrag['klasse_name']][$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'])) {
		    			$tmp_stat[$eintrag['klasse_name']][$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'] = 1;
		    			$tmp_stat[$eintrag['klasse_name']][$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['name'] = $eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz'];
		    		} else {
		    			$tmp_stat[$eintrag['klasse_name']][$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'] += 1;
		    		}

		    		// Medaillen fuer Gesamtstatistik
				if (!isset($tmp_stat_ges[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'])) {
		    			$tmp_stat_ges[	$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']	]	['anzahl'] = 1;
		    			$tmp_stat_ges[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['name'] = $eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz'];
		    		} else {
		    			$tmp_stat_ges[$eintrag['abzeichen_name'].$eintrag['abzeichen_zusatz']]['anzahl'] += 1;
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
			if ($klasse!=$eintrag['klasse_name']) {
				$klasse = $eintrag['klasse_name'];
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
			//$this->Cell(0,6,$eintrag['schueler_nachname'],1);
	    		//$this->SetXY($x+20,$y);
			//$this->Cell(0,6,$eintrag['schueler_vorname'],1);
			$this->Cell(0,6,$eintrag['schueler_nachname'].', '.$eintrag['schueler_vorname'],1);
			
			$this->SetXY($x+65,$y);
			$this->Cell(0,6,$eintrag['schueler_pruefungen'],1);
			$this->SetXY($x+72,$y);
			$this->Cell(0,6,$eintrag['abzeichen_name'],1);
			$this->SetXY($x+90,$y);
			$this->Cell(0,6,substr($eintrag['abzeichen_zusatz'],1,1),1);
			$this->SetXY($x+95,$y);
			$this->Cell(0,6,$eintrag['lfd_nr'],1);
			$y+=6;
		}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_pdf_urkunden.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/blsv_schulwettbewerb/lib/class.tx_blsvschulwettbewerb_export_pdf_urkunden.php']);
}
?>