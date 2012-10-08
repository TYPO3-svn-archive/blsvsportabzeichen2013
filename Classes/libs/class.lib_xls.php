<?php
class Lib_Xls {
	var $objPHPExcel = null;
	
	function __construct(){
		set_include_path('/www/typo6.blsv.de/htdocs/typo3conf/ext/phpexcel_service/Classes/');
		require_once 'PHPExcel.php';
		require_once 'PHPExcel/IOFactory.php';
	}
	
	function load($file){
		try {
			$this->objPHPExcel = PHPExcel_IOFactory::load($file);
		} catch(Exception $e) {
			die('Error loading file'); //.$e->getMessage());
		}
	}
	
	function save($file){
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
//		$objWriter->save($file);
	}
	
	/**
	 * 
	 * @param integer $col Spalte
	 * @param integer $row Zeile
	 * @param array $list Liste mit Eintraegen
	 * @param string $var aktuelle Variable
	 * @param string $insert Spalte bei der Zeilen eingefuegt werden
	 */
	function fillDown($col, $row, $list, $var, $insert='uid'){
		$anz = count($list);
		if ($var==$insert){
			$this->objPHPExcel->getActiveSheet()->insertNewRowBefore($row+1, $anz-1);
		}
		$i = 0;
		foreach ($list as $entry){
			if (array_key_exists($var, $entry)){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row+$i, $entry[$var]);
				$i++;
			}
		}
	}

	/**
	 *
	 * @param integer $col Spalte
	 * @param integer $row Zeile
	 * @param array $list Liste mit Eintraegen
	 * @param string $var aktuelle Variable
	 * @param string $insert Spalte bei der Zeilen eingefuegt werden
	 */
	function fillRight($col, $row, $list, $var, $insert='uid'){
		$anz = count($list);
		if ($var==$insert){
			$this->objPHPExcel->getActiveSheet()->insertNewColumnBeforeByIndex($col+1, $anz-1);
		}
		$i = 0;
		foreach ($list as $entry){
			if (array_key_exists($var, $entry)){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+$i, $row, $entry[$var]);
				$i++;
			}
		}
	}
	
/*	function fillTplVal($col, $row, $tplKeys, $tplVal, $daten){
		$newVal = $tplVal;
		foreach($tplKeys as $tplId => $tplKey){
			$ind = explode('.', $tplKey);
			if(array_key_exists($ind[1], $daten[$ind[0]])){
				$newVal = str_replace('{'.$tplKey.'}', $daten[$ind[0]][$ind[1]], $newVal);
			}
		}
echo $newVal."\n";
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $newVal);
	}
*/	
	
	function getTplVal($val){
		if (preg_match_all("/\{(.*)\}/U", $val, $tplKeys)){
	echo "$val\n";
			foreach($tplKeys[1] as $tplKey){
				// liste holen
				if (preg_match("/([a-z]*)\((.*),[ ]*(.*)\)/", $tplKey, $varKeys)){
/*					print_r($varKeys);

					$ind = explode('.', $varKeys[3]);
					print_r($ind);
					print_r($ind[0]);*/
						
										
				// feld holen
				} else {
					echo $tplKey."\n";
					$ind = explode('.', $tplKey);
					if(array_key_exists($ind[1], $this->daten[$ind[0]])){
						$val = str_replace('{'.$tplKey.'}', $this->daten[$ind[0]][$ind[1]], $val);
					}
				}
			}
	echo "=> $val\n\n";
		}
	}
	
	
	function fillTemplate($data){
		
		echo '<pre>';
		$schuelers = $data[28][schueler];
		$gruppen = $data[28][gruppen];
		$info = $data[28][info];
//		print_r($schuelers);
		$this->daten['info'] = $info;
		$this->daten['schueler'] = $schueler;
		
			$wsid=1;
		//foreach ($this->objPHPExcel->getWorksheetIterator() as $objWorksheet) {
			//		echo '- ' . $worksheet->getTitle();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
		
			$maxRow = $objWorksheet->getHighestRow();
			$maxColName = $objWorksheet->getHighestColumn();
			$maxCol = PHPExcel_Cell::columnIndexFromString($maxColName);

echo '<pre>';


			$table = array();
			for ($row = 1; $row <= $maxRow; ++$row) {
				for ($col = 0; $col <= $maxCol; ++$col) {
					$val = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

					// Wert holen
					$val = $this->getTplVal($val);
					// $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $val);
						
					
//					if (preg_match_all("/\{(.*)\}/U", $val, $m1)){
//print_r($m1[1]);						
//						$this->fillTplVal($row, $col, $m1[1], $val, $daten);
//					}
					
					
					
/*					
					if (preg_match('/\{(.*\..*)\}/', $val, $matches)){
						$ind = explode('.', $matches[1]);

						
						// gruppen einfuegen
						if ('gruppen' == $ind[0]){
							foreach ($gruppen as $gid=>$gruppe){
								if ($gid == $ind[1]){
									$this->fillRight($col, $row, $gruppen[1], $ind[2], 'saname');
								}
							}
						}
						
						// schueler einfuegen
						if('schueler' == $ind[0]){
							$this->fillDown($col, $row, $schuelers, $ind[1], 'uid');
						}
					}
					*/
				}
//			}
			$wsid++;
		}
		print_r($d);		
	}
}
?>