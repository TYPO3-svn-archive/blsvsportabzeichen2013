<?php
class tx_lib_download
{
	function send_data($data, $name, $ext)
	{
		$name = $name . '.' . $ext;
		$len = strlen($data);
		$this->send_headers($name, $len);
		echo $data;
		exit;
	}
	
	function send_file($file, $name, $ext)
	{
		$name = $name . '.' . $ext;
		$len = filesize($file);
		$this->send_headers($name, $len);
		readfile($file);
		exit;
	}
	
	function send_headers($name, $len)
	{
		header('Content-Type: application/x-download');
		header('Content-Length: ' . $len);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header('Cache-Control: private, max-age=0, must-revalidate');
		header('Pragma: public');
	}
}
?>