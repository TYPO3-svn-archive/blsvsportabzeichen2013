<?php
$file = $this->extPath.'Classes/libs/class.tx_lib_export_xls.php';
require_once($file);

global $myformats;
$myformats = $this->extPath.'Classes/libs/formats.csv';

class tx_blsvschulwettbewerb_export_xls_ergebnisse extends tx_lib_export_xls
{
	var $ErgebnisArray;
	var $format = array();
	var $gruppenName = array(
		1 => 'Schwimmen',
		2 => 'Ausdauer',
		3 => 'Kraft',
		4 => 'Schnelligkeit',
		5 => 'Koordination',
	);
	/**
	 * Formate holen
	 *
	 * @return array Array mit Formaten
	*/

	function createNew($tmp_file, $bitmap,$ErgebnisArray){
		$this->ErgebnisArray = $ErgebnisArray;
		$this->create($tmp_file, $bitmap);
	}
	function create($tmp_file, $bitmap)
	{
		//echo '<pre>';print_r($this->ErgebnisArray);echo '</pre>';exit;
		$this->open($tmp_file);
		$this->xls->setCustomColor(15, 245, 245, 245);
		$this->xls->setCustomColor(16, 200, 200, 200);
		$i=0;
		foreach ($this->ErgebnisArray as $ag => $agArray) {
			//print_r($agArray);exit;
			$this->addPage($agArray['altersgruppe_kurz']);
				
			//schuetzen
			$this->worksheet->protect ('');
			$this->worksheet->setInputEncoding('UTF-8');
			$this->erstellepage($bitmap, $agArray);
			$i++;
		}
		$this->close();
	}

	function addFormats($formats){
		global $myformats;

		
		// Formate einlesen
		$formats = array();
		$rows = file($myformats);
		$cols = explode(';', array_shift($rows));
		foreach($rows as $row) {
			$vals = explode(';', $row);
			$fmts = array();
			$i=0;
			foreach ($vals as $val) {
				$fmt[trim($cols[$i])] = trim(str_replace('|', ';', $val));
				$i++;
			}
			$formats[] = $fmt;
		}

		// Formate definieren
		foreach ($formats as $options){
			$name = '';
			$format =& $this->xls->addFormat();
			foreach ($options as $option => $value) {
				if (!empty($value)){
					switch ($option){
						case 'name':			$name = $value;
						case 'bold':			$format->setBold(); break;
						case 'color':			$format->setColor($value); break;
						case 'fgColor':			$format->setFgColor($value); break;
						case 'border':			$format->setBorder($value); break;
						case 'align':			$format->setAlign($value); break;
						case 'valign':			$format->setVAlign($value); break;
						case 'locked':			$format->setLocked(); break;
						case 'left':			$format->setLeft($value); break;
						case 'right':			$format->setRight($value); break;
						case 'bottom':			$format->setBottom($value); break;
						case 'numFormat':		$format->setNumFormat($value); break;
						case 'size':			$format->setSize($value); break;
						case 'textRotation':	$format->setTextRotation($value); break;
						case 'pattern':			$format->setPattern($value); break;
						case 'textWrap':		$format->setTextWrap($value); break;
					}
				}
			}
			if (!empty($name)){
				$this->format[$name] = $format;
			}
		}
	}
	
	function setFormats(){
// formate einlesen		
		$this->addFormats();
/*		
		
		
		$this->format[locked] =& $this->xls->addFormat();
		$this->format[locked]->setlocked();
		$this->format[locked]->setColor('16');
		$this->format[locked]->setFgColor('16');
		$this->format[locked]->setSize(1);
		
		
		$this->format[rot_locked] =& $this->xls->addFormat();
		$this->format[rot_locked]->setlocked();
		$this->format[rot_locked]->setColor('black');
		$this->format[rot_locked]->setFgColor('15');
		$this->format[rot_locked]->setTextRotation(270);
		$this->format[rot_locked]->setVAlign('vcenter');
		$this->format[rot_locked]->setAlign('center');
		
		$this->format[title] =& $this->xls->addFormat();
		$this->format[title]->setBold();
		$this->format[title]->setColor('black');
		$this->format[title]->setPattern(1);
		$this->format[title]->setFgColor('42'); // gruen
		$this->format[title]->setBorder(1);
		$this->format[title]->setAlign('merge');
		$this->format[title]->setVAlign('vcenter');
		$this->format[title]->setlocked();
		//$this->format[title]->setSize(16);
			
		$this->format[title2] =& $this->xls->addFormat();
		$this->format[title2]->setBold();
		$this->format[title2]->setColor('black');
		$this->format[title2]->setFgColor('15');
		$this->format[title2]->setBorder(1);
		$this->format[title2]->setAlign('merge');
		$this->format[title2]->setVAlign('vcenter');
		$this->format[title2]->setlocked();
		
		$this->format[title3] =& $this->xls->addFormat();
		$this->format[title3]->setColor('black');
		$this->format[title3]->setFgColor('15');
		$this->format[title3]->setLeft(1);
		$this->format[title3]->setRight(1);
		$this->format[title3]->setAlign('center');
		$this->format[title3]->setVAlign('vcenter');
		$this->format[title3]->setTextWrap(1);
		$this->format[title3]->setlocked();
		
		
		$this->format[title_silver] =& $this->xls->addFormat();
		$this->format[title_silver]->setBold();
		$this->format[title_silver]->setColor('black');
		$this->format[title_silver]->setFgColor(22);
		//		$this->format[title_silver]->setBorder(1);
		$this->format[title_silver]->setAlign('merge');
		//		$this->format[title_silver]->setVAlign('vcenter');
		$this->format[title_silver]->setlocked();
		
		$this->format[title_bronze] =& $this->xls->addFormat();
		$this->format[title_bronze]->setBold();
		$this->format[title_bronze]->setColor('white');
		$this->format[title_bronze]->setFgColor(60);
		//		$this->format[title_bronze]->setBorder(1);
		$this->format[title_bronze]->setAlign('merge');
		//		$this->format[title_bronze]->setVAlign('vcenter');
		$this->format[title_bronze]->setlocked();
		
		
		$this->format[leistung_gold] =& $this->xls->addFormat();
		$this->format[leistung_gold]->setBold();
		$this->format[leistung_gold]->setColor('black');
		$this->format[leistung_gold]->setFgColor(51);
		$this->format[leistung_gold]->setBorder(1);
		$this->format[leistung_gold]->setAlign('merge');
		$this->format[leistung_gold]->setVAlign('vcenter');
		$this->format[leistung_gold]->setlocked();
		
		$this->format[leistung_silver] =& $this->xls->addFormat();
		$this->format[leistung_silver]->setBold();
		$this->format[leistung_silver]->setColor('black');
		$this->format[leistung_silver]->setFgColor(22);
		$this->format[leistung_silver]->setBorder(1);
		$this->format[leistung_silver]->setAlign('merge');
		$this->format[leistung_silver]->setVAlign('vcenter');
		$this->format[leistung_silver]->setlocked();
		
		$this->format[leistung_bronze] =& $this->xls->addFormat();
		$this->format[leistung_bronze]->setBold();
		$this->format[leistung_bronze]->setColor('white');
		$this->format[leistung_bronze]->setFgColor(60);
		$this->format[leistung_bronze]->setBorder(1);
		$this->format[leistung_bronze]->setAlign('merge');
		$this->format[leistung_bronze]->setVAlign('vcenter');
		$this->format[leistung_bronze]->setlocked();
		
		
		$this->format[data_locked] =& $this->xls->addFormat();
		$this->format[data_locked]->setColor('15');
		$this->format[data_locked]->setFgColor('15');
		$this->format[data_locked]->setLeft(1);
		$this->format[data_locked]->setRight(1);
		$this->format[data_locked]->setBottom(1);
		$this->format[data_locked]->setAlign('center');
		$this->format[data_locked]->setlocked();
		
		
		$this->format[integer_locked] =& $this->xls->addFormat();
		$this->format[integer_locked]->setColor('black');
		$this->format[integer_locked]->setFgColor('15');
		$this->format[integer_locked]->setLeft(1);
		$this->format[integer_locked]->setRight(1);
		$this->format[integer_locked]->setBottom(1);
		$this->format[integer_locked]->setAlign('center');
		$this->format[integer_locked]->setNumFormat('0');
		$this->format[integer_locked]->setlocked();
		$this->format[integer_locked]->setBold();
		
		$this->format[integer] =& $this->xls->addFormat();
		$this->format[integer]->setColor('black');
		$this->format[integer]->setFgColor('white');
		$this->format[integer]->setLeft(1);
		$this->format[integer]->setRight(1);
		$this->format[integer]->setBottom(1);
		$this->format[integer]->setAlign('center');
		$this->format[integer]->setNumFormat('[red][<=0]0;0');
		$this->format[integer]->setBold();
		
		$this->format[meter_locked] =& $this->xls->addFormat();
		$this->format[meter_locked]->setColor('black');
		$this->format[meter_locked]->setFgColor('15');
		$this->format[meter_locked]->setLeft(1);
		$this->format[meter_locked]->setRight(1);
		$this->format[meter_locked]->setBottom(1);
		$this->format[meter_locked]->setAlign('center');
		$this->format[meter_locked]->setNumFormat('0.00 [$m]');
		$this->format[meter_locked]->setlocked();
		$this->format[meter_locked]->setBold();
		
		
		$this->format[sekunden_locked] =& $this->xls->addFormat();
		$this->format[sekunden_locked]->setColor('black');
		$this->format[sekunden_locked]->setFgColor('15');
		$this->format[sekunden_locked]->setLeft(1);
		$this->format[sekunden_locked]->setRight(1);
		$this->format[sekunden_locked]->setBottom(1);
		$this->format[sekunden_locked]->setAlign('center');
		$this->format[sekunden_locked]->setNumFormat('0.0 [$s]');
		$this->format[sekunden_locked]->setlocked();
		$this->format[sekunden_locked]->setBold();
		
		
		$this->format[minuten_locked] =& $this->xls->addFormat();
		$this->format[minuten_locked]->setColor('black');
		$this->format[minuten_locked]->setFgColor('15');
		$this->format[minuten_locked]->setLeft(1);
		$this->format[minuten_locked]->setRight(1);
		$this->format[minuten_locked]->setBottom(1);
		$this->format[minuten_locked]->setAlign('center');
		$this->format[minuten_locked]->setNumFormat('[h]:mm');
		$this->format[minuten_locked]->setlocked();
		$this->format[minuten_locked]->setBold();
		
		$this->format[datum_locked] =& $this->xls->addFormat();
		$this->format[datum_locked]->setColor('black');
		$this->format[datum_locked]->setFgColor('15');
		$this->format[datum_locked]->setLeft(1);
		$this->format[datum_locked]->setRight(1);
		$this->format[datum_locked]->setBottom(1);
		$this->format[datum_locked]->setAlign('center');
		$this->format[datum_locked]->setNumFormat('DD.MM.YY');
		$this->format[datum_locked]->setlocked();
		$this->format[datum_locked]->setBold();
*/		
	}
	
	function erstellePage($bitmap, $agArray)
	{
		$this->setFormats();
		
		//Format und Hoehe der Zeilen
/*		$this->worksheet->setRow(0, 15, $this->format[locked]);
		$this->worksheet->setRow(1, 15, $this->format[locked]);
		$this->worksheet->setRow(2, 15, $this->format[locked]);
		$this->worksheet->setRow(3, 15, $this->format[locked]);
		$this->worksheet->setRow(4, 87, $this->format[locked]);
		$this->worksheet->setRow(5, 25);
		$this->worksheet->setRow(6,20);
		$this->worksheet->setRow(7,130);
		for ($i=9;$i<100;$i++) {$this->worksheet->setRow($i,30);}
*/

/*		
		//Format und Breite der Spalten
		$this->worksheet->setColumn(0, 0, 1, $this->format[locked]);
		$this->worksheet->setColumn(1, 1, 10, $this->format[locked]);
		$this->worksheet->setColumn(2, 2, 3, $this->format[locked]);
		$this->worksheet->setColumn(3, 3, 10, $this->format[locked]);
		$this->worksheet->setColumn(4, 4, 10, $this->format[locked]);
		$this->worksheet->setColumn(5, 5, 10, $this->format[locked]);
		$this->worksheet->setColumn(6, 6,10, $this->format[locked]);
		$this->worksheet->setColumn(7, 7, 3.5);
		$this->worksheet->setColumn(8, 8, 9);
		$this->worksheet->setColumn(9, 7+$agArray['COLSPAN'],7.5);
		$this->worksheet->setColumn(7+$agArray['COLSPAN'], 100,10, $this->format[locked]);


		// Bild einfuegen
		$this->worksheet->insertBitmap (0, 0, $bitmap, 0, 0, 1, 1);
*/

		$z=0; $s=0;
		$this->worksheet->write($z, $s++, 'tabdef',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.uid',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.geschlecht',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.name',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.vorname',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.geburtstag',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'comment',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.anz_teilnahmen',$this->format[locked]);
		for ($i=0;$i<$agArray['COLSPAN'];$i++){
			$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.'.$i.'.ergebnis',$this->format[locked]);
		}


		$z=1; $s=0;
		$this->worksheet->write($z, $s++, 'ZF',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);

		for ($gruppe=1; $gruppe<6;$gruppe++){
			for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
				$this->worksheet->write($z, $s++, 'leistungstabelle='.$agArray['spag'.$gruppe][$i]['leistung'],$this->format[locked]);
			}
		}



		$z=2; $s=0;
		$this->worksheet->write($z, $s++, 'ZF',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		for ($i=0;$i<$agArray['COLSPAN'];$i++){
			$this->worksheet->write($z, $s++, 'schueler=[tx_blsvschulwettbewerb_schueler.0.uid]',$this->format[locked]);
		}

		$z=3; $s=0;
		$this->worksheet->write($z, $s++, 'DW',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);

		$z=4; $s=0;
		$this->worksheet->write($z, $s++, 'factor',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, '', $this->format[locked]);
		$this->worksheet->write($z, $s++, '',$this->format[locked]);
		$this->worksheet->write($z, $s++, 'datum', $this->format[locked]);
		$this->worksheet->write($z, $s++, '', $this->format[locked]);
		$this->worksheet->write($z, $s++, '', $this->format[locked]);
		for ($gruppe=1; $gruppe<6;$gruppe++){
			for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
					
				switch ($agArray['spag'.$gruppe][$i]['ergebnisart']) {
					// wegen excel statt mm:ss hh:tenmm-format: Tage in  minuten -> Faktor 24*60
					case 1: $this->worksheet->write($z, $s++,(24*60), $this->format[locked]);
					break;
					// Sekunden in Zehtelsekunden -> faktor 10
					case 2: $this->worksheet->write($z, $s++,10,  $this->format[locked]);
					break;
					// Meter in Zentimeter -> faktor 100
					case 3: $this->worksheet->write($z, $s++,100, $this->format[locked]);
					break;
					default: $this->worksheet->write($z, $s++,-1,  $this->format[locked]);
				}
			}
		}

		// titlezeile 1
		$z=5;
		$this->worksheet->write($z, 0, 'comment',$this->format[locked]);
		$this->worksheet->write($z, 1, $GLOBALS['schule']['name'].' ('.$GLOBALS['schule']['schulnummer'].') - Altersgruppe '.$agArray['altersgruppe'], $this->format[title]);
		for ($i=2; $i < (8+$agArray['COLSPAN']); $i++) {
			$this->worksheet->write($z, $i, '', $this->format[title]);
		}

		// Titlezeile 2
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
		$this->worksheet->write($z, $s++, 'UID', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'm/w', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'Name', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'Vorname', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'Geburtstag', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'Klasse', $this->format[title2]);
		for ($gruppe=1; $gruppe<6;$gruppe++){
			$this->worksheet->write($z, $s++, $this->gruppenName[$gruppe], $this->format[title2]);
				
			for ($i=1;$i<$agArray['COLSPANG'.$gruppe];$i++){
				$this->worksheet->write($z, $s++, '', $this->format[title2]);
			}
		}
		$this->worksheet->write($z, $s++, 'gesamt', $this->format[title2]);
		$this->worksheet->write($z, $s++, 'Anz.', $this->format[title2]);
		

		// Titlezeile 4
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->write($z, $s++, '', $this->format[title3]);
		$this->worksheet->setInputEncoding('utf-8');
//		$this->worksheet->write($z, $s++, 'Anzahl Pr'."\xFC".'fungen', $this->format[rot_locked]);
		for ($gruppe=1; $gruppe<6;$gruppe++){
			for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
				$this->worksheet->write($z, $s++, $agArray['spag'.$gruppe][$i]['sa_name'], $this->format[title3]);
			}
		}
		$this->worksheet->write($z, $s++, 'Punkte', $this->format[title3]);
		$this->worksheet->write($z, $s++, 'Anz. Teilnahmen', $this->format[title3]);

		
// Ergebnisvorgaben
$locked = true;
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment', $this->format[data_locked]);
		$this->worksheet->write($z, $s++, 'Leistung um Gold zu erreichen', $this->format[gold_title]);
		for ($i=0; $i<5; $i++){
			$this->worksheet->write($z, $s++, '', $this->format[gold_title]);
		}
		for ($gruppe=1; $gruppe<6;$gruppe++){
			for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
				//berechnet die formatierte leiszng + format fuer spalte
				$mind_leistung= $this->erstelleFormatLeistung( $agArray['spag'.$gruppe][$i]['ergebnisart'], $agArray['spag'.$gruppe][$i]['mindLeistung'],$s+1);
		
				switch ($agArray['spag'.$gruppe][$i]['ergebnisart']) {
					case 1: 
						if($mind_leistung>0){
							$this->worksheet->write($z, $s++,$mind_leistung, $this->format[gold_minuten_locked]);
						}
						else{
							$this->worksheet->write($z, $s++,'bel. Zeit', $this->format[gold_minuten_locked]);
						}
					break;
					case 2: $this->worksheet->write($z, $s++,$mind_leistung, $this->format[gold_sekunden_locked]); break;
					case 3:
					case 5: $this->worksheet->write($z, $s++,$mind_leistung, $this->format[gold_meter_locked]);	break;
					default: $this->worksheet->write($z, $s++,$mind_leistung,  $this->format[gold_integer_locked]);
				}
			}
		}
		
		
		
		
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
		$this->worksheet->write($z, $s++, 'Leistung um Silber zu erreichen', $this->format[title_silver]);
		for ($i=0; $i<5; $i++){
			$this->worksheet->write($z, $s++, '', $this->format[title_silver]);
		}
		
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
		$this->worksheet->write($z, $s++, 'Leistung um Bronze zu erreichen', $this->format[title_bronze]);
		for ($i=0; $i<5; $i++){
			$this->worksheet->write($z, $s++, '', $this->format[title_bronze]);
		}
		
		$z++;


$z++; $s=0;
$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
$this->worksheet->write($z, $s++, '', $this->format[datum_locked]);
for ($gruppe=1; $gruppe<6;$gruppe++){
	for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
		//berechnet die formatierte leiszng + format fuer spalte
		$mind_leistung= $this->erstelleFormatLeistung( $agArray['spag'.$gruppe][$i]['ergebnisart'], $agArray['spag'.$gruppe][$i]['mindLeistung'],$s+1);

		switch ($agArray['spag'.$gruppe][$i]['ergebnisart']) {
			case 1: If($mind_leistung>0){
				$this->worksheet->write($z, $s++,$mind_leistung, $this->format[minuten_locked]);
			}
			else{
				$this->worksheet->write($z, $s++,'bel. Zeit', $this->format[minuten_locked]);
			}

			break;
			case 2: $this->worksheet->write($z, $s++,$mind_leistung,  $this->format[sekunden_locked]);
			break;
			case 3:
			case 5:$this->worksheet->write($z, $s++,$mind_leistung, $this->format[meter_locked]);
			break;
			default: $this->worksheet->write($z, $s++,$mind_leistung,  $this->format[integer_locked]);
		}
	}
}





		
		// Ergebnisvorgaben
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment',$this->format[data_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[integer_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[data_locked]);
		$this->worksheet->write($z, $s++, '', $this->format[datum_locked]);
		for ($gruppe=1; $gruppe<6;$gruppe++){
			for ($i=0;$i<$agArray['COLSPANG'.$gruppe];$i++){
				//berechnet die formatierte leiszng + format fuer spalte
				$mind_leistung= $this->erstelleFormatLeistung( $agArray['spag'.$gruppe][$i]['ergebnisart'], $agArray['spag'.$gruppe][$i]['mindLeistung'],$s+1);

				switch ($agArray['spag'.$gruppe][$i]['ergebnisart']) {
					case 1: If($mind_leistung>0){
						$this->worksheet->write($z, $s++,$mind_leistung, $this->format[minuten_locked]);
					}
					else{
						$this->worksheet->write($z, $s++,'bel. Zeit', $this->format[minuten_locked]);
					}
					 
					break;
					case 2: $this->worksheet->write($z, $s++,$mind_leistung,  $this->format[sekunden_locked]);
					break;
					case 3:
					case 5:$this->worksheet->write($z, $s++,$mind_leistung, $this->format[meter_locked]);
					break;
					default: $this->worksheet->write($z, $s++,$mind_leistung,  $this->format[integer_locked]);
				}
			}
		}

		
		// Schueler
		$z++;
		foreach( $agArray['schueler'] as $i => $schueler)
		{
			$s=0;
			$this->worksheet->write($z, $s++, $i, $this->format[data_locked]);
			$this->worksheet->write($z, $s++,  $agArray['schueler'][$i]['uid'], $this->format[integer_locked]);
			$this->worksheet->write($z, $s++,  $agArray['schueler'][$i]['geschlecht'], $this->format[integer_locked]);
			$this->worksheet->write($z, $s++, $agArray['schueler'][$i]['name'], $this->format[integer_locked]);
			$this->worksheet->write($z, $s++, $agArray['schueler'][$i]['vorname'], $this->format[integer_locked]);
			$this->worksheet->write($z, $s++, $agArray['schueler'][$i]['geburtstag'], $this->format[datum_locked]);
			$this->worksheet->write($z, $s++, $agArray['schueler'][$i]['klasse'], $this->format[integer_locked]);
			$this->worksheet->write($z, $s++,  0, $this->format[integer]);
			for ($gruppe=1; $gruppe<6;$gruppe++){
				for ($j=0;$j<$agArray['COLSPANG'.$gruppe];$j++){
					$this->worksheet->write($z, $s++,'',  $this->format['spalte_'.$s]);
				}
			}
			$z++;
		}

		for ($i=0; $i<100;$i++) {
				
			$this->worksheet->setRow($z, 10, $this->format[locked]);
			$z++;
		}
		$this->worksheet->setLandscape();
		$this->worksheet->fitToPages(1,0);
		$this->worksheet->hideGridLines();
		$this->worksheet->hideScreenGridlines();


	}

	/**
	 * formatiert
	 *
	 * @param 	integer	  	$ergebnisart
	 * 						 1: Zeit 1 (mm:ss): Minuten:Sekunden;
	 *             			 2: Zeit 2 (ss,z): Sekunden,Zehntelsekunden
	 *						 3: LÃ¤nge (mm,cc): Meter,Zentimeter
	 *              			 4: bestanden/geschafft

	 *
	 * @return	array		0->formatierte Leistung 1-> format;
	 */
	function erstelleFormatLeistung( $ergebnisart, $Leistung=0, $spalte=0 ) {
		 
		$this->format['spalte_'.$spalte] =& $this->xls->addFormat();
		$this->format['spalte_'.$spalte]->setColor('black');
		$this->format['spalte_'.$spalte]->setFgColor('white');
		$this->format['spalte_'.$spalte]->setLeft(1);
		$this->format['spalte_'.$spalte]->setRight(1);
		$this->format['spalte_'.$spalte]->setBottom(1);
		$this->format['spalte_'.$spalte]->setBold();
		$this->format['spalte_'.$spalte]->setAlign('center');
		switch ($ergebnisart) {
			case 1: if ($Leistung>0) {
				$leistung_formatiert = $Leistung/(24*60)+0.00000000001 ; // 60*24	minuten ->TageExcelformat tage
				$this->format['spalte_'.$spalte]->setNumFormat('[red][>'.$leistung_formatiert.'][h]:mm ;[green][<='.$leistung_formatiert.'][h]:mm;[h]:mm');
			}
			else {

				$leistung_formatiert = 0;
				$this->format['spalte_'.$spalte]->setNumFormat('[red][<=0][h]:mm ;[green][>0][h]:mm;[h]:mm');
			}
				
			break;
			case 2: $leistung_formatiert = $Leistung/10;
			$this->format['spalte_'.$spalte]->setNumFormat('[green][<='.$leistung_formatiert.']0.0 [$s];[red][>'.$leistung_formatiert.']0.0 [$s];0.0 [$s]');
			break;
			case 3: $leistung_formatiert = $Leistung/100;
			$this->format['spalte_'.$spalte]->setNumFormat('[green][>='.$leistung_formatiert.']0.00 [$m];[red][<'.$leistung_formatiert.']0.00 [$m];0.00 [$m]');
			break;
			case 5: $leistung_formatiert = $Leistung/100;
			$this->format['spalte_'.$spalte]->setNumFormat('[green][=1]ja;[red]"1 als ja";[red]"1 als ja";[red]"1 als ja"');
			break;
			default:$leistung_formatiert = $Leistung;
			$this->format['spalte_'.$spalte]->setNumFormat('[green][=1]ja;[red]"1 als ja";[red]"1 als ja";[red]"1 als ja"');

		}

		 
		return $leistung_formatiert;
	}


} // end class
?>