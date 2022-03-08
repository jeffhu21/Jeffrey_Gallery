<?php
// set API Endpoint and API key
$endpoint = 'latest';
$access_key = 'API_KEY';

// Initialize CURL:
//$ch = curl_init('https://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'');
$ch = curl_init('https://api.exchangeratesapi.io/v1/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$exchangeRates = json_decode($json, true);

// Access the exchange rate values, e.g. GBP:
echo $exchangeRates['rates']['GBP'];
?>
