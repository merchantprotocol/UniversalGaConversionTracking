<?php

require 'app/Mage.php';

umask(0);

Mage::app();

$client = new Zend_Http_Client('http://www.google-analytics.com/analytics.js', ['timeout' => 30]);
$client->setMethod(Zend_Http_Client::GET);

try {
    $response     = $client->request();
    $responseBody = $response->getBody();

    header('Content-type: ' . $response->getHeader('Content-type'));
} catch (Exception $e) {
    $responseBody = '';
}

echo <<<JS
$responseBody
JS;
