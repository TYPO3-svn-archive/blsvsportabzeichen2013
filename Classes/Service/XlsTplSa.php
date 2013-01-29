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
 * @package blsvservicesxlstpl
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Blsvsa2013_Service_XlsTplSa extends Tx_Blsvservicesxlstpl_Service_XlsTpl {
	function getLeistung($ergebnisArt, $value=0){
		$lst = array();
		
		switch($ergebnisArt){
			// mm:ss	Zeit 1 schneller als  (mm,ss): Minuten:Sekunden
			case 1:
				$op = '<=';
				$factor = 24*60; // minuten ->TageExcelformat tage
				$value = $value/$factor;
				$valueL = $value + 0.00000000000001;
				$unit = ' [h]:mm';
				$limit = "[green][<=$valueL]$unit;[red][>$valueL]$unit;$unit";
				break;
			// ss,zz	Zeit 2 schneller als (ss,zz): Sekunde,Zentel
			case 2:
				$op = '<=';
				$factor = 10;
				$value = $value/$factor;
				$unit = '0.0 [$s]'; 
				$limit = "[green][<=$value]$unit;[red][>$value]$unit;$unit";
				break;
			// m,c m	Laenge weiter als (mm,cc): Meter,Zentimeter
			case 3:
				$value = str_replace(',', '.', $value);
				$op = '>=';
				$factor = 100;
				$value = $value/$factor;
				$unit = '0.00 [$m]';
				$limit = "[green][>=$value]$unit;[red][<$value]$unit;$unit";
				break;
			//	4	xx	Punkte/Anzahl
			case 4:
				$op = '>=';
				$factor = 1;
				$unit = '0';
				$limit = "[green][>=$value]$unit;[red][<$value]$unit;$unit";
				break;
			//	5	mm:ss	Zeit 3 laenger als  (mm,ss): Minuten:Sekunden
			case 5:
				$op = '>=';
				$factor = 24*60; //	minuten ->TageExcelformat tage
				$value = $value/$factor;
				$unit = ' [h]:mm';
				$valueL = $value - 0.00000000000001;
				$limit = "[green][>=$valueL]$unit;[red][<$valueL]$unit;$unit";
				break;
			default: 
				$unit = '';
				$factor = 1;
				$format = '';
		 }
		
		 $ret = compact('op', 'value', 'factor', 'unit', 'limit');
		 return $ret;
	}
	
	function cellFunc_formatDate($param=''){
		$this->debug(__METHOD__, $param);
		
		$intDate = $this->getData($this->arrCellData['content']);
		$strDate = date('d.m.Y', $intDate);
		$this->objCell->setValue($strDate);
	}
	
	function cellFunc_formatLeistung($param=''){
		$this->debug(__METHOD__, $param);
		
		$leistung = $this->getData($this->arrCellData['content']);
		$ergebnisArt = $this->getData($param);
		$arrLeistung = $this->getLeistung($ergebnisArt, $leistung);
		$this->objCell->setValue($arrLeistung['value']);
		$this->objWorksheet->getStyleByColumnAndRow($this->arrCellData['dstCol'],$this->arrCellData['dstRow'])->getNumberFormat()->setFormatCode($arrLeistung['unit']);
	}

	function cellFunc_formatErgebnis($param=''){
		$this->debug(__METHOD__, $param);
	
		$leistung = $this->getData($this->arrCellData['content']);
		$ergebnisArt = $this->getData($param);
		$arrLeistung = $this->getLeistung($ergebnisArt, $leistung);
		//$this->objCell->setValue($arrLeistung['value']);
		$this->objCell->setValue('');
		
		$style = $this->objWorksheet->getStyleByColumnAndRow($this->arrCellData['dstCol'],$this->arrCellData['dstRow']);
		$style->getNumberFormat()->setFormatCode($arrLeistung['limit']);
		$style->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	}

	function cellFunc_formatUnlocked($param=''){
		$this->debug(__METHOD__, $param);

		$content = $this->arrCellData['content'];
		$value = $this->getData($content);
		$this->objCell->setValue($value);
		
		$style = $this->objWorksheet->getStyleByColumnAndRow($this->arrCellData['dstCol'],$this->arrCellData['dstRow']);
		$style->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	}
	
	function cellFunc_getPunkteGruppe($param=''){
		$this->debug(__METHOD__, $param);
		
		$arrParam = explode(',', $param);
		
		$arrGruppen = $this->getData($arrParam[0]);
		$rowBro = 0+$arrParam[1];
		$rowSil = 0+$arrParam[2];
		$rowGol = 0+$arrParam[3];
		$op = '>=';
		
		$anz = count($arrGruppen);
		$cellPunkte = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol'], $this->arrCellData['dstRow'])->getCoordinate();
		
		$i=0;
		foreach ($arrGruppen as $arrGruppe){
			$leistung = $this->getLeistung($arrGruppe['ergebnisart']);
			$op = $leistung['op'];
			$col = $this->arrCellData['dstCol']-$anz+$i;
			
			$cell = $this->objWorksheet->getCellByColumnAndRow($col, $this->arrCellData['dstRow'])->getCoordinate();

			$cellLimitBro = $this->objWorksheet->getCellByColumnAndRow($col, $rowBro)->getCoordinate();
			$cellLimitSil = $this->objWorksheet->getCellByColumnAndRow($col, $rowSil)->getCoordinate();
			$cellLimitGol = $this->objWorksheet->getCellByColumnAndRow($col, $rowGol)->getCoordinate();

//			$cellValueSch = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol'], $rowSch)->getCoordinate();
			$cellValueBro = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol'], $rowBro)->getCoordinate();
			$cellValueSil = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol'], $rowSil)->getCoordinate();
			$cellValueGol = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol'], $rowGol)->getCoordinate();

			$formula = "0";
			$formula = "IF({$cell}{$op}{$cellLimitBro},{$cellValueBro},$formula)";
			$formula = "IF({$cell}{$op}{$cellLimitSil},{$cellValueSil},$formula)";
			$formula = "IF({$cell}{$op}{$cellLimitGol},{$cellValueGol},$formula)";
			$formula = "IF({$cell}>0,{$formula})";
			
			$arrFormula[] = $formula;
			$i++;
		}		
		$formula = 'max('.implode(',', $arrFormula).')';		
		$this->objCell->setValue('='.$formula);
	}

	function cellFunc_getPunkteGesamt($param=''){
		$this->debug(__METHOD__, $param);

		$arrGruppen = $this->getData($param);
		
		$cols = array();
		$cols[4] = $this->arrCellData['dstCol']-1;
		$cols[3] = $cols[4]-1-count($arrGruppen[4]);
		$cols[2] = $cols[3]-1-count($arrGruppen[3]);
		$cols[1] = $cols[2]-1-count($arrGruppen[2]);
		$colsSNW = $cols[1]-1-count($arrGruppen[1]);
		
		$cells = array();
		foreach ($cols as $col){
			$cells[] = $this->objWorksheet->getCellByColumnAndRow($col, $this->arrCellData['dstRow'])->getCoordinate();
		}
		$cellsSNW = $this->objWorksheet->getCellByColumnAndRow($colsSNW, $this->arrCellData['dstRow'])->getCoordinate();
		
		$formula = implode('+', $cells);
		$formula = "IF({$cellsSNW}=1,{$formula},0)";
		
		$this->objCell->setValue('='.$formula);
	}
	
	function cellFunc_getAbzeichen($param=''){
		$this->debug(__METHOD__, $param);
	
		$arrGruppen = $this->getData($param);
	
		$cols = array();
		$cols[4] = $this->arrCellData['dstCol']-3;
		$cols[3] = $cols[4]-1-count($arrGruppen[4]);
		$cols[2] = $cols[3]-1-count($arrGruppen[3]);
		$cols[1] = $cols[2]-1-count($arrGruppen[2]);
		$cols[0] = $cols[1]-1-count($arrGruppen[1]);
		
		$cells = array();
		foreach ($cols as $key=>$col){
			$cells[$key] = $this->objWorksheet->getCellByColumnAndRow($col, $this->arrCellData['dstRow'])->getCoordinate();
		}

		
		$arrFormula = array();
		
		$cell = $this->objWorksheet->getCellByColumnAndRow($this->arrCellData['dstCol']-2, $this->arrCellData['dstRow'])->getCoordinate();
		$op = '>=';
		
		$cellLimitBro = 4;
		$cellLimitSil = 8;
		$cellLimitGol = 11;
		
		$cellValueBro = '"Bronze"'; 
		$cellValueSil = '"Silber"';
		$cellValueGol = '"Gold"';
		
		$formula = '""';
		$formula = "IF({$cell}{$op}{$cellLimitBro},{$cellValueBro},$formula)";
		$formula = "IF({$cell}{$op}{$cellLimitSil},{$cellValueSil},$formula)";
		$formula = "IF({$cell}{$op}{$cellLimitGol},{$cellValueGol},$formula)";
		$formula = "IF({$cell}>0,{$formula},\"\")";
		$formula = "IF(".implode('*', $cells).">0,{$formula},\"\")";
		
		$this->objCell->setValue('='.$formula);
	}

	function cellFunc_setEnd($param=''){
		
		$objPHPExcel =& $this->objPHPExcel;
//		$objPHPExcel->getActiveSheet()->getRowDimension('10')->setVisible(false);


		
		// Zellschutz
		// $this->objWorksheet->getStyle('A20')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

		// Blattschutz
		$protection = $this->objWorksheet->getProtection();
		$protection->setSheet(true);
		$protection->setSelectLockedCells(false);
		$protection->setSelectUnlockedCells(false);
		
//		$protection->setPassword('');
//		$protection->setSort(true);
//		$protection->setInsertRows(true);
//		$protection->setFormatCells(true);
	
		// Dokumentenschutz
		$this->objPHPExcel->getSecurity()->setLockWindows(true);
		$this->objPHPExcel->getSecurity()->setLockStructure(true);
		// $this->objPHPExcel->getSecurity()->setWorkbookPassword('');

		
		/*
		$objPHPExcel->getProperties()->setCreator('');
		$objPHPExcel->getProperties()->setLastModifiedBy('');
		$objPHPExcel->getProperties()->setTitle('');
		$objPHPExcel->getProperties()->setSubject('');
		$objPHPExcel->getProperties()->setDescription('');
		$objPHPExcel->getProperties()->setKeywords('');
		$objPHPExcel->getProperties()->setCategory('');
		*/
		
		
		$cols = PHPExcel_Cell::columnIndexFromString($this->objWorksheet->getHighestColumn())-2;
		$rows = $this->objWorksheet->getHighestRow()-1;

		$objPageSetup = new PHPExcel_Worksheet_PageSetup();
		$objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPageSetup->setHorizontalCentered(true);
		$objPageSetup->setPrintAreaByColumnAndRow(0,1,$cols,$rows);
		$objPageSetup->setFitToWidth(1);
		
		$this->objWorksheet->getSheetView()->setZoomScale(75);

		for ($col = $this->objWorksheet->getHighestColumn(); $col <= 'IV'; $col++){
			$this->objPHPExcel->getActiveSheet()->getColumnDimension($col)->setVisible(false);
		}		
		
//		$highestColumn = "Z"; $highestRow ="20";
//		$this->objWorksheet->getStyle('A1:' .$highestColumn.$highestRow)->getFill()->getFillType(PHPExcel_Style_Fill::FILL_NONE);
//		$this->objWorksheet->getStyle('A1:' .$highestColumn.$highestRow)->getFill()->getStartColor()->setRGB('FFFFFF');
	}
	
	function cellFunc_formatGrpErgTab($param=''){
		$this->debug(__METHOD__, $param);
		$p = explode(',', $param);
		$this->objCell->setValue('Teilnahmen'.$p[0].'.'.$p[1].'.leistung');
	}
	
	function cellFunc_formatGrpErgLstTab($param=''){
		$this->debug(__METHOD__, $param);
				
		$id = $this->getData($this->arrCellData['content']);
		$this->objCell->setValue('leistungstabelle='.$id);
	}
	
	function cellFunc_formatGrpErgJoin($param=''){
		$this->debug(__METHOD__, $param);
		$this->objCell->setValue('teilnahmen=[Teilnahmen.0.uid]'.$id);
	}
	
	function cellFunc_formatGrpErgFaktor($param=''){
		$this->debug(__METHOD__, $param);
				
		$ergebnisArt = $this->getData($this->arrCellData['content']);		
		$arrLeistung = $this->getLeistung($ergebnisArt, $leistung);
		$factor = $arrLeistung['factor'];
		if ($factor==1) {
			$factor = ''; 
		};
		$this->objCell->setValue($factor);
	}
	
	function cellFunc_formatText($param=''){
		$this->debug(__METHOD__, $param);
			
		$this->objCell->setValue($param);
	}
	
	function fillTemplateAndSend($data0, $import, $export, $xls){
		if (empty($data0)){
			$this->error('no export data', 1352379100);
		}
		ini_set('max_execution_time', 300);
		
		foreach ($data0 as $sheet){
			$data[$sheet['altersgruppe']['Bezeichnung']] = $sheet;
		}
		unset($data0);
		
		$sheet = 0;
		$names = array_keys($data);
		
		$this->open($import);
		$this->cloneSheet($sheet, $names);
		
		ob_start();
			foreach ($data as $sheetName => $sheetData){
				$this->objWorksheet = $this->objPHPExcel->setActiveSheetIndexByName($sheetName);
				$this->parseSheet();
				$this->writeSheet($sheetData);
				// echo $this->getSheetHtml();
			}
			$this->objPHPExcel->removeSheetByIndex($sheet);
			$this->objPHPExcel->setActiveSheetIndex(0);
			$xlsData = $this->getXls($export);
		$content = ob_get_contents();
		ob_end_clean();
		
//		echo $content; exit;
		
		preg_match('/(.*)\.(.*)/', $xls, $xlsFile);
		$this->sendData($xlsData,$xlsFile[1], $xlsFile[2]);
	}
	
	function debug($method, $message=''){
		// echo "<b>$method:</b> $message<br />";
	}
	
}
?>