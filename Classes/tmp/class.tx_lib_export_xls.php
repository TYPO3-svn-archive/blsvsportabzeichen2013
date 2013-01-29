<?php
/**
 * Datei enthaelt Klasse fuer die Erzeugung von xls-Tabellen 
 */
require_once 'Spreadsheet/Excel/Writer.php';

/**
 * Klasse fuer die Erzeugung von xls-Tabellen 
 */
class tx_lib_export_xls
//class BLSV_Export_xls
{
	var $filename = '';				// Name der Exportdatei
	var $xls = null;				// xls-Objekt
	var $worksheet = null;			// aktuelles Worksheet 
	var $format = null;				// Objekt mit Formatierung fuer die einzelnen Zellen
	var $z=0;						// aktuelle Zeilennummer
	var $s=0;						// aktuelle Spaltennummer
	var $key0 = 0;					// erste Tabellenzeile
	var $cols;						// Spaltenbreiten
	var $cols_default;				// Standartwerte fuer Spaltenbreiten
	
	/**
	 * Anlegen eines neuen xls-Objektes
	 *
	 * @param string $filename
	 */
	function open($filename)
	{
		$this->filename = $filename;
		if (file_exists($filename)) { unlink($filename); }
		$this->xls = new Spreadsheet_Excel_Writer($filename);
		$this->xls->setVersion(8);
	}
	
	/**
	 * Schliessen des Workbooks
	 */
	function close()
	{
		$this->xls->close();
	}

	/**
	 * Hinzufuegen einer neuen Seite (eines neuen Worksheets)
	 *
	 * @param string $name Name der Seite
	 */
	function addPage($name)
	{
		$this->worksheet =& $this->xls->addWorksheet($name);
//		$this->worksheet->setInputEncoding('UTF-8');
	}

	/**
	 * Namen der ersten Spalte ermitteln
	 *
	 * @param array $tabelle
	 */
	function get_key0($tabelle)
	{
		if (!empty($tabelle))
		{
			$keys = array_keys($tabelle);
			$this->key0 = $keys[0];
		}
	}

	/**
	 * Formate fuer die Zellen erzeugen
	 */
	function set_formats()
	{
		$fmt = $this->get_formats();
		if (!empty($fmt))
		{
			foreach ($fmt as $fmt_name => $fmt_arr)
			{
				$this->format[$fmt_name] =& $this->xls->addFormat($fmt[$fmt_name]);
			}
		}
	}

	/**
	 * Spaltenbreiten anhand einer uebergebenen Tabelle setzen
	 *
	 * @param array $width Array mit Spaltenbreiten
	 * @param integer $start Startspalte
	 */
	function setCols($width, $start=0)
	{
		if (is_array($width) && !empty($width))
		{
			foreach ($width as $col => $size)
			{
				$pos = $start + $col;
				$this->worksheet->setColumn($pos, $pos, $size);
			}
		}
	}
	
	/**
	 * Spaltenbreiten anhand eines uebergebenen Arrays setzen
	 *
	 * @param array $array Array mit Spaltenbreiten
	 */
	function setColsFromArray($array)
	{
		if (!empty($array))
		{
			foreach ($array as $spalte => $breite)
			{
				$this->cols[$spalte] = $breite;
			}
		}
	}
	
	/**
	 * Spaltenbreiten mit Hilfe der Textlaengen von Tabelleninhalte setzen
	 *
	 * @param array $tabelle Tabelle
	 */
	function setColsFromTable(&$tabelle)
	{
		$this->cols = array();
		
		if (!empty($tabelle))
		{
			$s = $this->s;
			
			// Ueberschriften durchlaufen 
			foreach ($tabelle[$this->key0] as $spalte_name => $spalte_wert)
			{
				$len = strlen($spalte_name); 
				$this->cols[$this->s] = $len;
				$this->s++;
			}

			// Zeilen durchlaufen 
			foreach ($tabelle as $zeile)
			{
				if (!empty($zeile))
				{
					$this->s = $s;
					foreach ($zeile as $spalte_name => $spalte_wert)
					{
						$len = strlen($spalte_wert); 
						if (!isset($this->cols[$this->s]) || ($len > $this->cols[$this->s])) 
						{
							$this->cols[$this->s] = $len; 
						} 			
						$this->s++;
					}
				}
			}
			$this->s = $s;
		}
	}
	
	/**
	 * Zoomfaktor des aktuellen Worksheets setzen
	 *
	 * @param integer $scale Zoomfaktor
	 */
	function setZoom($scale=100)
	{
		$this->worksheet->setZoom($scale);
	}
	
	/**
	 * Schreiben einer Zelle
	 *
	 * @param string $text Text der Zelle
	 * @param string $format Format der Zelle
	 * @param integer $s Spaltenanzahl
	 * @param integer $z Zeilenanzahl
	 */
	function write($text, $format = '_std', $s=0, $z=0)
	{
		// UTF8 Korrektur
		// $text = utf8_decode($text);
		
		$format = isset($this->format[$format]) ? $format : '_std';		
		$this->worksheet->write($this->z, $this->s, $text, $this->format[$format]);
		$this->s += $s;
		$this->z += $z;
	}
	
	/**
	 * Schreiben des Tabellenkopfs
	 *
	 * @param array $tabelle Tabelle
	 */
	function write_tabellenkopf(&$tabelle)
	{
		$s = $this->s;
		$z = $this->z;
		
		if (!empty($tabelle))
		{
			foreach ($tabelle[$this->key0] as $spalte_name => $spalte_wert)
			{
				$this->write($spalte_name, '_titel');
				$this->s++;
			}
			$this->s = $s; $this->z++;
		}
	}

	/**
	 * Schreiben einer Tabellenzeile
	 *
	 * @param array $zeile Tabellenzeile
	 */
	function write_tabellenzeile($zeile)
	{
		$s = $this->s;
		if (!empty($zeile))
		{
			foreach ($zeile as $spalte_name => $spalte_wert)
			{
				$this->write($spalte_wert, $spalte_name);
				$this->s++;
			}
			$this->s = $s; $this->z++;
		}		
	}
	
	/**
	 * Schreiben aller Tabellenzeilen
	 *
	 * @param array $tabelle Tabelle
	 */
	function write_tabelle(&$tabelle)
	{
		if (!empty($tabelle))
		{
			$s = $this->s;
			foreach ($tabelle as $zeile)
			{
				$this->s = $s;
				$this->write_tabellenzeile($zeile);
			}
		}
	}
	
	/**
	 * Titel ausgeben
	 *
	 * @param string $titel Titeltext
	 */
	function write_titel($titel)
	{
		$this->write($titel, '_info', 0, 1);
	}

	/**
	 * Hinweis ausgeben
	 *
	 * @param string $txt_file Name der Hinweis-Datei
	 */
	function write_hinweis($txt_file)
	{
		if (file_exists($txt_file))
		{
			$file = file($txt_file);
			if (!empty($file))
			{
				foreach ($file as $text)
				{
					$text = preg_replace("/\r|\n/s", "", $text);
					$text = $text;
					$this->write($text, '_hinweis', 0, 1);
				}
			}
		}
	}

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
	
	/**
	 * Inhalt der Datei holen und die Datei loeschen
	 * (Methode erst nach dem Erstellen, d.h. nach close() aufrufen)
	 * 
	 * @return string $content Inhalt der Datei
	 */
	function get_content()
	{
		$content = '';
		if (file_exists($this->filename))
		{
			$content = file_get_contents($this->filename);
			unlink($this->filename);
		}
		return $content;
	}
	
	/**
	 * Erstellen eines kompletten Exports
	 * 
	 * Daten:
	 *  'info'				Info zum Export
	 *  'tabelle'			Datentabelle
	 * 
	 * Optionen:
	 *  'titel'				Titel der Tabelle
	 * 	'sheet'				Bezeichnung fuer das Tabellen-Sheet
	 *  'datei_hinweis'		Datei mit Hinweistext fuer den oberen Bereich
	 *  'fusszeile'			Fusszeilen-Text		
	 *
	 * @param array $daten Info und Tabelle
	 * @param array $opt Optionen
	 * @return string $content fertiges xls
	 */
	function create($daten, &$opt = array())
	{
		$content = '';
		$info =& $daten['info'];
		$tabelle =& $daten['tabelle'];
		
		$felder = array(
			'titel'	=> 'titel',
			'seite'	=> 'bname',
			'name'	=> 'bname'
		);
		
		// Optionen von Infofeldern setzen
		foreach ($felder as $f_opt => $f_inf)
		{
			if (!isset($opt[$f_opt]) && isset($info[$f_inf]))
			{
				$opt[$f_opt] = $info[$f_inf];
			}
		}
		
		if (isset($opt['datei_tmp']))
		{
			$filename = $opt['datei_tmp'];
			$this->open($filename);
			$this->set_formats();
			
			// Worksheet hinzu
			$seite = isset($opt['seite']) ? $opt['seite'] : 'Tabelle1';
			$this->addPage($seite);
	
			// Titel schreiben
			if (isset($opt['titel']))
			{
				$this->write_titel($opt['titel']);
			}
			
			// Hinweis oben schreiben
			if (isset($opt['datei_hinweis']))
			{
				$this->write_hinweis($opt['datei_hinweis']);
			}
			
			// erste Tabellenzeile bestimmen
			$this->get_key0($tabelle);
			
			// Tabellenueberschrift
			$this->write_tabellenkopf($tabelle);
			$z_freeze = $this->z;
			
			// Tabelle
			$this->write_tabelle($tabelle);
	
			// Spaltenbreiten setzen
			$this->setColsFromTable($tabelle);
			$this->setColsFromArray($this->cols_default);
			$this->setCols($this->cols);
	
			// Fusszeile schreiben
			if (isset($opt['fusszeile']))
			{
				$this->worksheet->setFooter($opt['fusszeile']);
			}
			
			// Seiteneinstellungen
//			$this->worksheet->repeatRows (0, $z_freeze);
			$this->worksheet->freezePanes(array($z_freeze));		
			
			// $this->worksheet->setLandscape();
			$this->worksheet->fitToPages(1,0);
			$this->worksheet->hideGridLines();
			$this->worksheet->hideScreenGridlines();
			
			$this->close();
			
			// Inhalt der xls-Datei holen 
			$content = $this->get_content();
		}

		$opt['ausgabe'] = $content;
		$opt['ext'] = 'xls';
	}
}
?>
