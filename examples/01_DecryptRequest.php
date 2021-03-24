<?php

require __DIR__.'/../vendor/autoload.php'; // Autoloader

/*
 * Data
 */
$MY_KEY_ID = '0-080j09R3QcM125';
$MY_KEY = 'A25p573435609wDI';

/*
 * Request data
 * Encrypted string
 */
$MY_REQUEST = '0-080j09R3QcM125bMIoFRuKNlPC-CiX7CXKAEG_ezwY7wAOML8yzJVjEuzSDxDcjyXFM5aIh84IOaqDaYrCRwGt2OgxwbCIBgxJGWj6IoYyPKERGi1OU9Dvkj8=';

/*
 * Init decrypt class
 * Passing values: Crypto Key ID & Crypto Key
 */
$RequestDecrypt = new SF_Crypto\Request\RequestDecrypt($MY_KEY_ID, $MY_KEY); // Init decrypt class

/*
 * Request decryption
 * Decrypted data returned as RequestData class
 */
$decrypt_data = $RequestDecrypt->decryptRequest($MY_REQUEST);

/*
 * Print decrypted data
 */
echo "<h1>Decrypted data</h1>";
echo "<b>Session:</b> {$decrypt_data->getSession()}<br/>"; # string
echo "<b>Action:</b> {$decrypt_data->getAction()}<br/>"; # string
echo "<b>Parameters:</b> <pre>".print_r($decrypt_data->getParameters(), true)."</pre><br/>"; # array