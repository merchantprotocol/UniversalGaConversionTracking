<?php

require 'app/Mage.php';

umask(0);

Mage::app();

$trackingId = Mage::helper('i4gaconversiontrack')->getAccount();
$client     = new Zend_Http_Client('http://www.googletagmanager.com/gtag/js?id=' . $trackingId, ['timeout' => 30]);

try {
    $client->setMethod(Zend_Http_Client::GET);

    $response     = $client->request();
    $responseBody = $response->getBody();

    header('Content-type: ' . $response->getHeader('Content-type'));
} catch (Exception $e) {
    $responseBody = '';
}

echo <<<JS
$responseBody
JS;
