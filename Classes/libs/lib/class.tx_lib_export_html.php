<?php
class tx_lib_export_html
{
	function create($daten, &$opt = array())
	{
		ob_start();
		echo '<pre>';
		print_r($daten);
		echo '</pre>';
		$content = ob_get_clean();

		$opt['ausgabe'] = $content;
		$opt['ext'] = 'html';
	}
}
?>