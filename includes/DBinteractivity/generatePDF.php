<?php

header('Content-type: application/pdf');

$filename = "invoice_" . $_GET['t'] . "_" . date("d-m-Y") . ".pdf";

header('Content-Disposition: filename="' . $filename .'"');

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://invoice-generator.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_GET['data']);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
}
else
{
	// This is for downloading it instead of displaying
	// file_put_contents('result.pdf', $result);
	echo $result;
}

curl_close ($ch);

?>
