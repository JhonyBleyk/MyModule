<?php
global $smarty;
require('../../config/config.inc.php');
include( '../../header.php' );
$smarty->assign('pagoPSESubmit', Tools::getValue('pagoPSESubmit'));

function object2array($object) { return @json_decode(@json_encode($object),1); } 


	//Tools::redirect(Context::getContext()->link->getModuleLink('../autenticacion?back=my-account',false));
	//Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$mymodule->id.'&id_order='.$mymodule->currentOrder.'&key='.$customer->secure_key);

$datos_enviados = Tools::getValue('envio_datos');
if ($datos_enviados != 1280) 
{
	if ($customer->id == null or Tools::getValue('validacion_pasos') != "fbe36168a761d416eb993fbfb252c564")
	{
		Tools::redirect(Context::getContext()->link->getModuleLink('../autenticacion?back=my-account',false));		
	}
	//echo "entro 1 php";

	$dato1 = Tools::getValue('Bancos_list');
	$dato2 = Tools::getValue('typePerson');
	$dato3 = Tools::getValue('typeDocument');
	$dato4 = Tools::getValue('numberDocument');
	$dato5 = Tools::getValue('namesAndLastnames');
	$dato6 = Tools::getValue('phone');
	$dato7 = Tools::getValue('email');
	$dato8 = Tools::getValue('accountId');
	$dato9 = Tools::getValue('merchantId');
	$dato10 = Tools::getValue('apiKey');
	$dato11 = Tools::getValue('description');
	$dato12 = Tools::getValue('referenceCode');
	$dato13 = Tools::getValue('tax');
	$dato14 = Tools::getValue('taxReturnBase');
	$dato15 = Tools::getValue('signature');
	$dato16 = Tools::getValue('currency');
	$dato17 = Tools::getValue('buyerEmail');
	$dato18 = Tools::getValue('test');
	$dato19 = Tools::getValue('extra1');
	$dato20 = Tools::getValue('responseUrl');
	$dato21 = Tools::getValue('confirmationUrl');
	$dato22 = Tools::getValue('payerFullName');
	$dato23 = Tools::getValue('billingAddress');
	$dato24 = Tools::getValue('shippingAddress');
	$dato25 = Tools::getValue('telephone');
	$dato26 = Tools::getValue('billingCity');
	$dato27 = Tools::getValue('shippingCity');
	$dato28 = Tools::getValue('billingCountry');
	$dato29 = Tools::getValue('shippingCountry');
	$dato30 =  number_format(Tools::getValue('amount'), 0,',','');
	$ipAddress2 = getenv(REMOTE_ADDR);

if ($dato18==0) 
{
	$dato18 = 'false';
}
else
{
	$dato18 = 'true';
}

	/*echo "<br>Bancos ".$dato1;
	echo "<br>Type Persona ".$dato2;
	echo "<br>Type Document ".$dato3;
	echo "<br>Num Document ".$dato4;
	echo "<br>Nombres y apellidos  ".$dato5;
	echo "<br>Telefono  ".$dato6;
	echo "<br>Email  ".$dato7;
	echo "<br>accountId  ".$dato8;
	echo "<br>merchantId  ".$dato9;
	echo "<br>apiKey  ".$dato10;
	echo "<br>description  ".$dato11;
	echo "<br>referenceCode  ".$dato12;
	echo "<br>tax  ".$dato13;
	echo "<br>taxReturnBase  ".$dato14;
	echo "<br>signature  ".$dato15;
	echo "<br>currency  ".$dato16;
	echo "<br>buyerEmail  ".$dato17;
	echo "<br>test  ".$dato18;
	echo "<br>extra1  ".$dato19;
	echo "<br>responseUrl  ".$dato20;
	echo "<br>confirmationUrl  ".$dato21;
	echo "<br>payerFullName  ".$dato22;
	echo "<br>billingAddress  ".$dato23;
	echo "<br>shippingAddress  ".$dato24;
	echo "<br>telephone  ".$dato25;
	echo "<br>billingCity  ".$dato26;
	echo "<br>shippingCity  ".$dato27;
	echo "<br>billingCountry  ".$dato28;
	echo "<br>shippingCountry  ".$dato29;
	echo "<br>Amont  ".$dato30;*/


	//die();



	if ($dato4 == '' or $dato5 == '' or $dato6 == '' or $dato7 == '') 
	{
		$smarty->assign('mensajeNullo', "ERROR no ha diligenciado todos los campos del formulario por favor haga click en volver");
	}
	else
	{
		$smarty->assign('mensajeNullo', '');
		try 
		{
			$soap_do = curl_init();


			if (FALSE === $soap_do) 
			{
				throw new Exception('failed to initialize');
			}
			else
			{
				//cambiar esto por el car->id.

				$referencecode2 = $cart->id;
				$apykey2 = $dato10;
				$merchantId2 = $dato9;
				$amount2 = $dato30;
				$currency2 = $dato16;
				$sign2 = md5("".$apykey2."~".$merchantId2."~".$referencecode2."~".$amount2."~".$currency2."");
				//echo " ENTRO IGNATURE".$sign2;
				$jsondata = '{
						"language": "es",
					   	"command": "SUBMIT_TRANSACTION",
					   	"merchant": 
					   	{
					      	"apiKey": "'.$dato10.'",
					      	"apiLogin": "8PW8XRb2nUHyUa2"
					   	},
					   	"transaction": 
					   	{
					      	"order": 
					      	{
					        	"accountId": "'.$dato8.'",
					         	"referenceCode": "'.$referencecode2.'",
					         	"description": "'.$dato11.'",
					         	"language": "es",
					         	"signature": "'.$sign2.'",
					         	"notifyUrl": "https://azaleia.com.co/modules/mymodule/confirmationpse.php",
					         	"additionalValues": 
					         	{
					            	"TX_VALUE": 
					            	{
					               	"value": "'.$dato30.'",
					               	"currency": "COP"
					            	}
					         	},
					         	"buyer": 
					         	{
					            	"emailAddress": "'.$dato7.'"
					         	}
					      	},
					      	"payer": 
					      	{
					         	"fullName": "'.$dato22.'",
					         	"emailAddress": "'.$dato17.'",
					         	"contactPhone": "'.$dato25.'"
					      	},
					      	"extraParameters": 
					      	{
					         	"RESPONSE_URL": "https://azaleia.com.co/modules/mymodule/respuestapse.php",
					         	"PSE_REFERENCE1": "'.$ipAddress2.'",
					         	"FINANCIAL_INSTITUTION_CODE": "'.$dato1.'",
					         	"USER_TYPE": "'.$dato2.'",
					         	"PSE_REFERENCE2": "'.$dato3.'",
					         	"PSE_REFERENCE3": "'.$dato4.'"
					      	},
					      	"type": "AUTHORIZATION_AND_CAPTURE",
					      	"paymentMethod": "PSE",
					      	"paymentCountry": "CO",
					      	"ipAddress": "'.$ipAddress2.'",
					      	"cookie": "pt1t38347bs6jc9ruv2ecpv7o2",
					      	"userAgent": "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
					   	},
					   	"test": '.$dato18.'
					}';

			
			
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
			curl_close($soap_do);
			
			//echo "<br> respuesta ".$respuesta."<br>";
			if (FALSE === $respuesta)
			{
				throw new Exception(curl_error($soap_do), curl_errno($soap_do));
			}
			else
			{
				
				

				$result = array();
				$xml = simplexml_load_string($respuesta);
				$xml_array = object2array($xml);
				$array_bancos = array();

				var_dump($xml_array);
				
				foreach ($xml_array as $key1 => $value1) 
				{					
					//echo "<br> key1: ".$key1." value1: ".$value1;
					
					var_dump($value1);
					if (is_array($value1)) 
					{
						foreach ($value1 as $key2 => $value2) 
						{
							//echo "<br> key2: ".$key2." value2: ".$value2;
							if (is_array($value2)) 
							{
								//echo " es un array 2";
								foreach ($value2 as $key3 => $value3) 
								{
									if (is_array($value3)) 
									{
										
										foreach ($value3 as $key4 => $value4) 
										{
											if (is_array($value4)) 
											{
												//echo " es un array 4";
												foreach ($value4 as $key5 => $value5) 
												{
													if (is_array($value5)) 
													{
														//echo " es un array 5";
														foreach ($value5 as $key6 => $value6) 
														{
															if (is_array($value6)) 
															{
																//echo " es un array 6";
															}
															else
															{
																$array_datos[$key2][$key3][$key4][$key5][$key6] = $value6;			
															}
														}
													}
													else
													{
														$array_datos[$key2][$key3][$key4][$key5] = $value5;
													}	
												}
											}	
											else
											{
												$array_datos[$key2][$key3][$key4] = $value4;
											}
										}
									}
									else
									{
										$array_datos[$key2][$key3] = $value3;
									}
								}
							}
							else
							{
								$array_datos[$key2] = $value2;

							}
						}
					}
					else
					{
						$array_datos[$key1] = $value1;
					}					
				}
				
					//echo "<br><br><br>";
					var_dump($array_datos);

					//echo "<br>".$array_datos['extraParameters']['entry'][0]['string'][1];

				
					//print_r($array_bancos);

					//var_dump($array_bancos[1]["id"]);
					/*echo "<br> dato 1  ".$dato1;
					echo "<br> muestra ".$array_bancos[1]["id"];*/

				

				//echo "<br>dato1: ".$result->code;		
				/*echo '<script type="text/javascript">';
				echo "MiFuncionJS(".$array_datos['extraParameters']['entry'][0]['string'][1].");";
				echo "</script>";*/

				
				
				
				if ($array_datos['code'] == "ERROR") 
				{
					$smarty->assign("ERROR_RESPUESTA", "<br><h1> Error De Comunicación Con El Medio De Pago Por Favor Haga Click <a href='index.php?controller=order&step=1'<p  style=color:#a6c307;>AQUI</a></p> Para Intentar con otro <br>");

				}
				elseif ($array_datos['code'] == "SUCCESS") 
				{
					if ($array_datos['state'] == "DECLINED") 
					{
						$smarty->assign("ERROR_RESPUESTA", "<br><h1> Error De Comunicación Con El Medio De Pago Por Favor Haga Click <a href='index.php?controller=order&step=1'<p  style=color:#a6c307;>AQUI</a></p> Para Intentar con otro 2 <br>");
						
					}	
					else
					{
						
							Tools::redirect($array_datos['extraParameters']['entry'][0]['string'][1],false);
						
					}
					
				}				
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

	}



	$smarty->display( dirname(__FILE__) . '/form_pse.tpl' );
}
else
{
	
	//echo "entro 2 php ";

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

	$apykey2 = Tools::getValue('apiKey');
	$apiLogin2 = "8PW8XRb2nUHyUa2";
	try 
	{
		$soap_do = curl_init();


		if (FALSE === $soap_do) 
		{
			throw new Exception('failed to initialize');
		}
		else
		{
			$jsondata = 
			'{
				   "language": "es",
				   "command": "GET_BANKS_LIST",
				   "merchant": 
				   {
				      "apiLogin": "'.$apiLogin2.'",
				      "apiKey": "'.$apykey2.'"
				   },
				   "test": false,
				   "bankListInformation": 
				   {
				      "paymentMethod": "PSE",
				      "paymentCountry": "CO"
				   	}
			}';


			//var_dump(json_decode($jsondata));
			


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
				$xml = simplexml_load_string($respuesta);
				$xml_array = object2array($xml);
				$array_bancos = array();
				
				foreach ($xml_array as $key1 => $value1) 
				{
					//echo "<br>";
					//echo "<br> key1: ".$key1." value1: ".$value1;
					//var_dump($value1);
					//echo "";					
					$dato1 = $value1;
					foreach ($value1 as $key2 => $value2) 
					{
						//var_dump($value2);						
						//echo "<br> key2: ".$key2." value1: ".$value2;						

						$echoerror = $value2;
						$cantidad = 0;
						foreach ($value2 as $key3 => $value3) 
						{
							//echo "<br> posicion ".$cantidad;
							//echo "<br> key3: ".$key3." value3: ".$value3;														
							foreach ($value3 as $key4 => $value4) 
							{
								$array_bancos[$cantidad][$key4] = $value4;
							}
							$cantidad++;							
						}						
					}
				}
					
					//echo "<br><br><br>";

				

					//print_r($array_bancos);

					//var_dump($array_bancos[1]["id"]);
					/*echo "<br> dato 1  ".$dato1;
					echo "<br> muestra ".$array_bancos[1]["id"];*/

				$smarty->assign('Banks_list', $array_bancos);

				//echo "<br>dato1: ".$result->code;		
				
				
				if ($dato1 == "ERROR") 
				{
					$smarty->assign("ERROR_RESPUESTA", "<br><h1> Error De Comunicación Con El Medio De Pago Por Favor Haga Click <a href='index.php?controller=order&step=1'<p  style=color:#a6c307;>AQUI</a></p> Para Intentar Con Otro <br>");

				}
				
				
				
				
				



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



	$smarty->display( dirname(__FILE__) . '/form_pse.tpl' );
}
	

?>

<?php


include( '../../footer.php' );
?>