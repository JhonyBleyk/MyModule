<?php
global $smarty;
require('../../config/config.inc.php');
include( '../../header.php' );
$smarty->assign('pagoEfectivoSubmit', Tools::getValue('pagoEfectivoSubmit'));






$datos_enviados = Tools::getValue('envio_datos');
if ($datos_enviados != 1280) 
{

	if ($customer->id == null or Tools::getValue('validacion_pasos') != "fbe36168a761d416eb993fbfb252c564")
	{
		Tools::redirect(Context::getContext()->link->getModuleLink('../autenticacion?back=my-account',false));		
	}

	/* aqui se tramita el envio y recepción de datos de payulatam */

	//echo "<br> js ".Tools::getValue('validacion_pasos');
	$fecha = date('Y-m-d ');
	$hora = date("H:i:s");
	$nuevafecha = strtotime('+2 day' , strtotime($fecha));
	$nuevafecha = date('Y-m-d',$nuevafecha);

	$currency2 = Tools::getValue('currency');
	$referencecode2 =  $cart->id;
	$merchantId2 = Tools::getValue('merchantId');
	$apykey2 = Tools::getValue('apiKey');
	$apiLogin2 = "8PW8XRb2nUHyUa2";
	$amount2 = Tools::getValue('amount');
	$accountId2 = Tools::getValue('accountId');
	$description2 = Tools::getValue('description');
	$emailAddress2 = Tools::getValue('buyerEmail');
	$paymentMethod2 = Tools::getValue('pagoEfectivo');
	$paymentCountry2 = Tools::getValue('billingCountry');
	$ipAddress2 = getenv(REMOTE_ADDR);
	$test2 = Tools::getValue('test');
	//echo "<br> datos sign ".$apykey2."~".$accountId2."~".$referencecode2."~".$amount2."~".$currency2."<br>";



	 $sign2 = md5("".$apykey2."~".$merchantId2."~".$referencecode2."~".$amount2."~".$currency2."");

	$jsondata = '{
				   "language": "es",
				   "command": "SUBMIT_TRANSACTION",
				   "merchant": {
				      "apiKey": "'.$apykey2.'",
				      "apiLogin": "'.$apiLogin2.'"
				   },
				   "transaction": {
				      "order": {
				         "accountId": "'.$accountId2.'",
				         "referenceCode": "'.$referencecode2.'",
				         "description": "'.$description2.'",
				         "language": "es",
				         "signature": "'.$sign2.'",
				         "notifyUrl": "https://azaleia.com.co/modules/mymodule/confirmation.php",
				         "additionalValues": {
				            "TX_VALUE": {
				               "value": "'.$amount2.'",
				               "currency": "'.$currency2.'"
				            }
				         },
				         "buyer": {
				            "emailAddress": "'.$emailAddress2.'"
				         }
				      },
				      "type": "AUTHORIZATION_AND_CAPTURE",
				      "paymentMethod": "'.$paymentMethod2.'",
				      "expirationDate": "'.$nuevafecha.'T'.$hora.'",
				      "paymentCountry": "'.$paymentCountry2.'",
				      "ipAddress": "'.$ipAddress2.'"
				   },
				   "test": '.$test2.'
				}';

	//$jsondata = json_encode($jsondata);

	//echo "<br>entro ".$jsondata."<br>";


	try 
	{
		$soap_do = curl_init();


		if (FALSE === $soap_do) 
		{
			throw new Exception('failed to initialize');
		}
		else
		{
			curl_setopt($soap_do, CURLOPT_URL,"https://api.payulatam.com/payments-api/4.0/service.cgi");
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,array('Content-Type: application/json','Accept application/json','Content-Length: '.strlen($jsondata)));
			curl_setopt($soap_do, CURLOPT_POST,true);
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,$jsondata);
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($soap_do, CURLOPT_CAINFO, getcwd(). "/comercialesazaleia_com_a5d8e_837d3_1475158358_6f937784d9cee8452454817393590931.crt");
			curl_setopt($soap_do, CURLOPT_CAPATH, getcwd(). "/comercialesazaleia_com_a5d8e_837d3_1475158358_6f937784d9cee8452454817393590931.crt");
			//curl_setopt($soap_do, CURLOPT_AUTOREFERER, true);
			$respuesta=curl_exec($soap_do);
			//echo "<br> respuesta ".$respuesta."<br>";
			if (FALSE === $respuesta)
			{
				throw new Exception(curl_error($soap_do), curl_errno($soap_do));
			}
			else
			{
				
				

				$result = array();
				//var_dump($respuesta);				
				$result = new SimpleXMLElement($respuesta);	
				//var_dump($result);
				
				if ($result->code == "ERROR") 
				{
					$smarty->assign("ERROR_RESPUESTA", "<br><h1> ERROR DE COMUNICACÓN CON EL MEDIO DE PAGO HAGA CLICK <a href='index.php?controller=order&step=1'>AQUI</a> Y SELECCIONE OTRO MEDIO DE PAGO <br>");

				}
				
				$code = $result->code;
				$orderid = $result->transactionResponse->orderId;	
				/*
				echo "<br>dato1: ".$result->code;
				echo "<br>dato2: ".$result->transactionResponse->orderId;
				echo "<br>dato3: ".$result->transactionResponse->transactionId;		
				echo "<br>dato4: ".$result->transactionResponse->state;
				echo "<br>dato9: ".$result->transactionResponse->pendingReason;
				echo "<br>dato10: ".$result->transactionResponse->responseCode;
				echo "<br>dato11: ".$result->transactionResponse->extraParameters->entry[0]->string;
				echo "<br>dato12: ".$result->transactionResponse->extraParameters->entry[0]->date;
				echo "<br>dato13: ".$result->transactionResponse->extraParameters->entry[1]->string[1];
				echo "<br>dato14: ".$result->transactionResponse->extraParameters->entry[2]->int;*/


/*				ob_start();*/
				$smarty->assign('ResultCode', $result->code);
				$smarty->assign('ResultOrderId', $result->transactionResponse->orderId);
				$smarty->assign('ResultTransactionId', $result->transactionResponse->transactionId);
				$smarty->assign('ResultState', $result->transactionResponse->state);
				$smarty->assign('ResultPendingReason', $result->transactionResponse->pendingReason);
				$smarty->assign('ResultResponseCode', $result->transactionResponse->responseCode);
				$smarty->assign('ResultExtraParameters1', $result->transactionResponse->extraParameters->entry[0]->string);
				$smarty->assign('ResultExtraParameters2', $result->transactionResponse->extraParameters->entry[0]->date);
				$smarty->assign('ResultExtraParameters3', $result->transactionResponse->extraParameters->entry[1]->string[1]);
				$smarty->assign('ResultExtraParameters4', $result->transactionResponse->extraParameters->entry[2]->int);
				$smarty->assign('ResultMedioPago', $paymentMethod2);
				$smarty->assign('ResultDateToday', date("Y-m-d"));
				$smarty->assign('ResultamoutPay',  number_format(ceil($amount2), 0, ',', '.'));

				

				$fechaExpiraDate = substr($result->transactionResponse->extraParameters->entry[0]->date, 0,10);
				$horaExpiraDate = substr($result->transactionResponse->extraParameters->entry[0]->date, 11,8);

				$smarty->assign('fechaExpiraDate', $fechaExpiraDate);
				$smarty->assign('horaExpiraDate', $horaExpiraDate);



				$context = Context::getContext();
				$cart = $context->cart;
				$mymodule = Module::getInstanceByName('mymodule');
				$authorized = false;
				foreach (Module::getPaymentModules() as $module)
				{
					if ($module['name'] == 'mymodule')
					{
						$authorized = true;
						break;
					}
				}
				if (!$authorized)
				{
					die($mymodule->l('This payment method is not available.', 'validation'));	
				}
				//echo " autoriced ".$authorized;
				$customer = new Customer((int)$cart->id_customer);
				$currency = $context->currency;
				$total = (float)($cart->getOrderTotal(true, Cart::BOTH));
				
				$mymodule->validateOrder($cart->id, 19, $total, $mymodule->displayName, NULL, array(), (int)$currency->id, false, $customer->secure_key);
				$order = new Order($mymodule->currentOrder);
				//Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$mymodule->id.'&id_order='.$mymodule->currentOrder.'&key='.$customer->secure_key);

			}
		}
	} 
	catch (Exception $e) 
	{
		trigger_error(sprintf('Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);
	}
	curl_close($soap_do);
    
	$smarty->display( dirname(__FILE__) . '/form_efectivo.tpl' );
/*	require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->load_html(ob_get_clean());
	$dompdf->render();
	$pdf = $dompdf->output();
	$filename = "ejemplo".time().'.pdf';
	file_put_contents($filename, $pdf);
	$dompdf->stream($filename);*/
}
else
{
	$smarty->assign('merchantId', Tools::getValue('merchantId'));
	$smarty->assign('referenceCode', Tools::getValue('referenceCode'));
	$smarty->assign('description', Tools::getValue('description'));
	$smarty->assign('amount', Tools::getValue('amount'));
	$smarty->assign('tax', Tools::getValue('tax'));
	$smarty->assign('taxReturnBase', Tools::getValue('taxReturnBase'));
	$smarty->assign('signature', Tools::getValue('signature'));
	$smarty->assign('accountId', Tools::getValue('accountId'));
	$smarty->assign('apiKey', Tools::getValue('apiKey'));
	$smarty->assign('currency', Tools::getValue('currency'));
	$smarty->assign('buyerEmail', Tools::getValue('buyerEmail'));
	$smarty->assign('test', Tools::getValue('test'));
	$smarty->assign('extra1', Tools::getValue('extra1'));
	$smarty->assign('responseUrl', Tools::getValue('responseUrl'));
	$smarty->assign('confirmationUrl', Tools::getValue('confirmationUrl'));
	$smarty->assign('payerFullName', Tools::getValue('payerFullName'));
	$smarty->assign('billingAddress', Tools::getValue('billingAddress'));
	$smarty->assign('shippingAddress', Tools::getValue('shippingAddress'));
	$smarty->assign('telephone', Tools::getValue('telephone'));
	$smarty->assign('billingCity', Tools::getValue('billingCity'));
	$smarty->assign('shippingCity', Tools::getValue('shippingCity'));
	$smarty->assign('billingCountry', Tools::getValue('billingCountry'));
	$smarty->assign('shippingCountry', Tools::getValue('shippingCountry'));
	$smarty->assign('amontformat', number_format(ceil(Tools::getValue('amount')), 0, ',', '.'));

	$smarty->display( dirname(__FILE__) . '/form_efectivo.tpl' );
}
	

?>

<?php


include( '../../footer.php' );
?>