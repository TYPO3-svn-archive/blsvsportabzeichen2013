<?php
require_once(t3lib_extMgm::extPath('blsv_schulwettbewerb')."lib/class.tx_lib_export_xls.php");

class tx_blsvschulwettbewerb_export_xls_test extends tx_lib_export_xls
{
	/**
	 * Formate holen
	 *
	 * @return array Array mit Formaten
	 */
	function get_formats()
	{

		$fmt_name = '_std';
		$fmt[$fmt_name] = array();
		$fmt[$fmt_name]['Align']	= 'left';
		$fmt[$fmt_name]['Size']		= '8';
		$fmt[$fmt_name]['Border']	= '1';
		
		$fmt_name = '_info';
		$fmt[$fmt_name] = $fmt['_std'];
		$fmt[$fmt_name]['Align'] = 'left';
		$fmt[$fmt_name]['Bold'] = '1';
		$fmt[$fmt_name]['Size'] = '20';
		$fmt[$fmt_name]['Border']	= '0';
		
		$fmt_name = '_titel';
		$fmt[$fmt_name] = $fmt['_std'];
		$fmt[$fmt_name]['FgColor'] = '22';
		$fmt[$fmt_name]['Align'] = 'merge';
		$fmt[$fmt_name]['TextWrap'] = 'true';
		$fmt[$fmt_name]['Color'] = 'black';
		
		$fmt_name = '_titel_merge';
		$fmt[$fmt_name] = $fmt['_titel'];
		$fmt[$fmt_name]['Align'] = 'merge';
		
		$fmt_name = '_hinweis';
		$fmt[$fmt_name] = $fmt['_std'];
		$fmt[$fmt_name]['Align'] = 'left';
		$fmt[$fmt_name]['Bold'] = '1';
		$fmt[$fmt_name]['Color'] = 'red';
		$fmt[$fmt_name]['Border']	= '0';
		
		return $fmt;
	}
	
	function create($tmp_file, $bitmap)
	{
		$this->open($tmp_file);
		
		$this->addPage('T1');
		$this->test($bitmap);

		$this->addPage('T2');
		$this->test($bitmap);
		
		$this->addPage('T3');
		
		$this->close();
	}
	
	
	function test($bitmap)
	{
		$fmt = $this->get_formats();
		$format_title =& $this->xls->addFormat();
		$format_title->setBold();
		$format_title->setColor('black');
		$format_title->setPattern(1);
		$format_title->setFgColor('42'); // gruen 
		$format_title->setBorder(1);
		
		$format_title->setAlign('merge');
		
		
		$format_title2 =& $this->xls->addFormat();
		$format_title2->setBold();
		$format_title2->setColor('black');
		//$format_title->setPattern(1);
		$format_title2->setFgColor('white'); 
		$format_title2->setBorder(1);
		$format_title2->setAlign('merge');
		
		$format_title3 =& $this->xls->addFormat();
		$format_title3->setColor('black');
		$format_title3->setFgColor('white'); 
		$format_title3->setLeft(1);
		$format_title3->setRight(1);
		$format_title3->setAlign('center');
		$format_title3->setTextWrap(1);
		
		
		$format_data =& $this->xls->addFormat();
		$format_data->setColor('black');
		$format_data->setFgColor('white'); 
		$format_data->setLeft(1);
		$format_data->setRight(1);
		$format_data->setBottom(1);
		$format_data->setAlign('center');
		
		$format_data_integer =& $this->xls->addFormat();
		$format_data_integer->setColor('black');
		$format_data_integer->setFgColor('white'); 
		$format_data_integer->setLeft(1);
		$format_data_integer->setRight(1);
		$format_data_integer->setBottom(1);
		$format_data_integer->setAlign('center');
		$format_data_integer->setNumFormat('0');
		
		$format_data_meter =& $this->xls->addFormat();
		$format_data_meter->setColor('black');
		$format_data_meter->setFgColor('white'); 
		$format_data_meter->setLeft(1);
		$format_data_meter->setRight(1);
		$format_data_meter->setBottom(1);
		$format_data_meter->setAlign('center');
		$format_data_meter->setNumFormat('0.00 [$m]');
		
		$format_data_sekunden =& $this->xls->addFormat();
		$format_data_sekunden->setColor('black');
		$format_data_sekunden->setFgColor('white'); 
		$format_data_sekunden->setLeft(1);
		$format_data_sekunden->setRight(1);
		$format_data_sekunden->setBottom(1);
		$format_data_sekunden->setAlign('center');
		$format_data_sekunden->setNumFormat('0.0 [$s]');
		
		$format_data_minuten =& $this->xls->addFormat();
		$format_data_minuten->setColor('black');
		$format_data_minuten->setFgColor('white'); 
		$format_data_minuten->setLeft(1);
		$format_data_minuten->setRight(1);
		$format_data_minuten->setBottom(1);
		$format_data_minuten->setAlign('center');
		$format_data_minuten->setNumFormat('mm:ss');
		
		$format_data_datum =& $this->xls->addFormat();
		$format_data_datum->setColor('black');
		$format_data_datum->setFgColor('white'); 
		$format_data_datum->setLeft(1);
		$format_data_datum->setRight(1);
		$format_data_datum->setBottom(1);
		$format_data_datum->setAlign('center');
		$format_data_datum->setNumFormat('DD.MM.YY');
		
		
		
		
				
					
		$this->worksheet->setRow(0, 15);	
		$this->worksheet->setRow(1, 15);
		$this->worksheet->setRow(2, 15);	
		$this->worksheet->setRow(3, 15);
		$this->worksheet->setRow(4, 90);	
		
		//$this->worksheet->setCol(1, 10);
		//$this->worksheet->setCol(2, 10);
		
		// Bild einfügen
		$this->worksheet->insertBitmap (0, 1, $bitmap, 0, 0, 1, 1);
		
		$z=0; $s=0;
		$this->worksheet->write($z, $s++, 'tabdef');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.uid');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.anz');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.name');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.vorname');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_schueler.0.gebdatum');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.1.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.2.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.3.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.4.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.5.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.6.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.7.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.8.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.9.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.10.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.11.ergebnis');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.12.ergebnis');
		
		$z=1; $s=0;
		$this->worksheet->write($z, $s++, 'ZF');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.1.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.2.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.3.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.4.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.5.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.6.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.7.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.8.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.9.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.10.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.11.leistungstabelle = 12');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.12.leistungstabelle = 12');
		
		
		$z=2; $s=0;
		$this->worksheet->write($z, $s++, 'ZF');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.1.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.2.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.3.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.4.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.5.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.6.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.7.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.8.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.9.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.10.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.11.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		$this->worksheet->write($z, $s++, 'tx_blsvschulwettbewerb_ergebnisse.12.schueler = [tx_blsvschulwettbewerb_schueler.0.uid]');
		
		$z=3; $s=0;
		$this->worksheet->write($z, $s++, 'comment');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		
		$z=4; $s=0;
		$this->worksheet->write($z, $s++, 'comment');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
		$this->worksheet->write($z, $s++, '');
				
		
		$z=5;
		$this->worksheet->write($z, 0, 'comment');
		            $this->worksheet->write($z, 1, "Altersgruppe", $format_title);
		for ($i=2; $i<18; $i++)
		{
			$this->worksheet->write($z, $i, "", $format_title);
		}
					
					
		
					
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment');
		$this->worksheet->write($z, $s++, 'S-UID', $format_title2);
		$this->worksheet->write($z, $s++, 'Anz. Prf.', $format_title2);
		$this->worksheet->write($z, $s++, 'Name', $format_title2);
		$this->worksheet->write($z, $s++, 'Vorname', $format_title2);
		$this->worksheet->write($z, $s++, 'Geburtsdatum', $format_title2);
		$this->worksheet->write($z, $s++, 'Gruppe 1', $format_title2);
		$this->worksheet->write($z, $s++, 'Gruppe 2', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, 'Gruppe 3', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, 'Gruppe 4', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, 'Gruppe 5', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		$this->worksheet->write($z, $s++, '', $format_title2);
		
		
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment');
		$this->worksheet->write($z, $s++, '', $format_title3);
		$this->worksheet->write($z, $s++, '', $format_title3);
		$this->worksheet->write($z, $s++, '', $format_title3);
		$this->worksheet->write($z, $s++, '', $format_title3);
		$this->worksheet->write($z, $s++, '', $format_title3);
		$this->worksheet->write($z, $s++, '50m Schwimmen', $format_title3);
		$this->worksheet->write($z, $s++, 'Hocke über beli. Sprung- gerät längs 1,00m', $format_title3);
		$this->worksheet->write($z, $s++, 'Weitsprung', $format_title3);
		$this->worksheet->write($z, $s++, 'Hochsprung', $format_title3);
		$this->worksheet->write($z, $s++, '5000m Inline-Skating', $format_title3);
		$this->worksheet->write($z, $s++, '1000m Lauf', $format_title3);
		$this->worksheet->write($z, $s++, '50m Lauf', $format_title3);
		$this->worksheet->write($z, $s++, 'Wurfball 200g', $format_title3);
		$this->worksheet->write($z, $s++, '100m Schwimmen', $format_title3);
		$this->worksheet->write($z, $s++, '5000m Inline-Skating', $format_title3);
		$this->worksheet->write($z, $s++, '20km Radfahren', $format_title3);
		$this->worksheet->write($z, $s++, '800m Lauf', $format_title3);
		
		
		$anz_prf = '';
		$name = '';
		$vorname = '';
		$geb_dat = '';
		
		$gr1 = (60+23)/(24*60*60);
		
		$gr2_1 = 1.0;
		$gr2_2 = 4.5;
		$gr2_3 = 1.3;
		
		$gr3_1 = (1*60+31)/(24*60*60);
		$gr3_2 = (3*60+44)/(24*60*60);
		$gr3_3 = 9.2;
		$gr4_1 = 10.22222;
		$gr4_2 = (1*60+13)/(24*60*60);
		$gr5_1 = (4*60+56)/(24*60*60);
		
		$z++; $s=0;
		$this->worksheet->write($z, $s++, 'comment');
		$this->worksheet->write($z, $s++, '', $format_data_integer);
		$this->worksheet->write($z, $s++, $anz_prf, $format_data_integer);
		$this->worksheet->write($z, $s++, $name, $format_data);
		$this->worksheet->write($z, $s++, $vorname, $format_data);
		$this->worksheet->write($z, $s++, $geb_dat, $format_data_datum);
		$this->worksheet->write($z, $s++, $gr1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr2_1, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr2_2, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr2_3, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr3_1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr3_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr3_3, $format_data_sekunden);
		$this->worksheet->write($z, $s++, $gr4_1, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr4_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_3, $format_data_minuten);
		
		$anz_prf = 1;
		$suid	 = 67;
		$name	 = 'name';
		$vorname = 'vorname';
		$geb_dat = '1.2.1999';
		
		$gr1 = (60+23)/(24*60*60);
		
		$gr2_1 = 1.0;
		$gr2_2 = 4.5;
		$gr2_3 = 1.3;
		
		$gr3_1 = (1*60+31)/(24*60*60);
		$gr3_2 = (3*60+44)/(24*60*60);
		$gr3_3 = 9.2;
		$gr4_1 = 10.22222;
		$gr4_2 = (1*60+13)/(24*60*60);
		$gr5_1 = (4*60+56)/(24*60*60);
		
		
		$z++; $s=0;
		$this->worksheet->write($z, $s++, '0', $format_data_integer);
		$this->worksheet->write($z, $s++, $suid, $format_data_integer);
		$this->worksheet->write($z, $s++, $anz_prf, $format_data_integer);
		$this->worksheet->write($z, $s++, $name, $format_data);
		$this->worksheet->write($z, $s++, $vorname, $format_data);
		$this->worksheet->write($z, $s++, $geb_dat, $format_data_datum);
		$this->worksheet->write($z, $s++, $gr1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr2_1, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr2_2, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr2_3, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr3_1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr3_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr3_3, $format_data_sekunden);
		$this->worksheet->write($z, $s++, $gr4_1, $format_data_meter);
		$this->worksheet->write($z, $s++, $gr4_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_1, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_2, $format_data_minuten);
		$this->worksheet->write($z, $s++, $gr5_3, $format_data_minuten);
		
		
		$z++; 
		for ($i=1; $i<21; $i++)
		{
			$s=0;	
			$this->worksheet->write($z, $s++, $i, $format_data_integer);
			$this->worksheet->write($z, $s++,round($suid*$i/7), $format_data_integer);
			$this->worksheet->write($z, $s++, '', $format_data_integer);
			$this->worksheet->write($z, $s++, '', $format_data);
			$this->worksheet->write($z, $s++, '', $format_data);
			$this->worksheet->write($z, $s++, '', $format_data_datum);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_meter);
			$this->worksheet->write($z, $s++, '', $format_data_meter);
			$this->worksheet->write($z, $s++, '', $format_data_meter);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_sekunden);
			$this->worksheet->write($z, $s++, '', $format_data_meter);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$this->worksheet->write($z, $s++, '', $format_data_minuten);
			$z++;
		}
		
		$this->worksheet->setLandscape();
		$this->worksheet->fitToPages(1,0);
		$this->worksheet->hideGridLines();
		$this->worksheet->hideScreenGridlines();



	}
}
?>