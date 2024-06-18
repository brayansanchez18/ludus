<?php

require __DIR__ . '/vendor/autoload.php';

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

$tabla = 'comercio';

$respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);

$clientePaypal = $respuesta['clienteIdPaypal'];
$llaveSecretaPaypal = $respuesta['llaveSecretaPaypal'];
$modoPaypal = $respuesta['modoPaypal'];

$apiContext = new ApiContext (
	new OAuthTokenCredential (
        $clientePaypal,
        $llaveSecretaPaypal
    )
);

 $apiContext->setConfig(
    array(
        'mode' => $modoPaypal,
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
        // 'cache.enabled' => true,
        //'cache.FileName' => '/PaypalCache' // for determining paypal cache directory
        'http.CURLOPT_CONNECTTIMEOUT' => 30
        // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
        //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
    )
);