<?php

require_once '../modelos/rutas.php';
require_once "../modelos/carrito.modelo.php";

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Paypal {

	static public function mdlPagoPaypal($datos) {

		require __DIR__ . '/bootstrap.php';

		$tituloArray = explode(',', $datos['tituloArray']);
		$cantidadArray = explode(',', $datos['cantidadArray']);
		$valorItemArray = explode(',', $datos['valorItemArray']);
		$idProductos = str_replace(',','-', $datos['idProductoArray']);
		$cantidadProductos = str_replace(",","-", $datos["cantidadArray"]);
		$pagoProductos = str_replace(",","-", $datos["valorItemArray"]);
		
		#SELECCIONAMOS EL METODO DE PAGO
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");

		$item = array();
		$variosItems = array();

		for ($i = 0; $i < count($tituloArray); $i++) {

			$item[$i] = new Item();
			$item[$i]->setName($tituloArray[$i])
			    ->setCurrency($datos['divisa'])
			    ->setQuantity($cantidadArray[$i])
			    //->setSku("123123") // Similar to `item_number` in Classic API
			    ->setPrice($valorItemArray[$i]/$cantidadArray[$i]);

			    array_push($variosItems, $item[$i]);

		}

		#AGRUPAMOS LOS ITEMS EN UNA LISTA DE ITEMS
		$itemList = new ItemList();
		$itemList->setItems($variosItems);

		# AGREGAMOS LOS DETALLES DEL PAGO (IMPUESTO ENVIO ETC)
		$details = new Details();
		$details->setShipping($datos['envio'])
				->setTax($datos['impuesto'])
				->setSubtotal($datos['subtotal']);

		# DEFINIMOS EL PAGO TOTAL CON SUS DETALLES
		$amount = new Amount();
		$amount->setCurrency($datos['divisa'])
				->setTotal($datos['total'])
				->setDetails($details);

		# AGREGAMOS LAS CARACTERISTICAS DE LA TRANSACCION
		$transaction = new Transaction();
		$transaction->setAmount($amount)
					->setItemList($itemList)
					->setDescription("Descripción de Pago")
					->setInvoiceNumber(uniqid());

		/* AGREGAR LAS URL'S DESPUES DE REALIZAR EL PAGO O CUANDO EL PAGO ES CANCELADO 
		   IMPORTANTE AGREGAR LA URL PRINCIPAL EN LA API DEVELOPERS DE PAYPAL */
		$url = Ruta::ctrRuta();
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("https://localhost/ecommerce/frontend/index.php?ruta=finalizar-compra&paypal=true&productos=".$idProductos."&cantidad=".$cantidadProductos."&pago=".$pagoProductos)
					->setCancelUrl("https://localhost/ecommerce/frontend/carrito-de-compras");

		# AGREGAMOS TODAS LAS CARACTERISTICAS DEL PAGO
		$payment = new Payment();
		$payment->setIntent("sale")
				->setPayer($payer)
				->setRedirectUrls($redirectUrls)
				->setTransactions(array($transaction));

		# TRATAR DE EJECUTAR UN PROCESO Y SI FALLA EJECUTAR UNA RUTINA DE ERROR
		try {
		    // traemos las credenciales $apiContext
		    $payment->create($apiContext);   
		   	//var_dump($payment);
		}catch(PayPal\Exception\PayPalConnectionException $ex){

			echo $ex->getCode(); // Prints the Error Code
			echo $ex->getData(); // Prints the detailed error message 
			die($ex);
			return "https://localhost/ecommerce/frontend/error";

		}

		# utilizamos un foreach para iterar sobre $payment, utilizamos el método llamado getLinks() para obtener todos los enlaces que aparecen en el array $payment y caso de que $Link->getRel() coincida con 'approval_url' extraemos dicho enlace, finalmente enviamos al usuario a esa dirección que guardamos en la variable $redirectUrl on el método getHref();

		foreach($payment->getLinks() as $link){
			
			if($link->getRel() == "approval_url"){

				$redirectUrl = $link->getHref();

			}
		}

		return $redirectUrl;

	}

}