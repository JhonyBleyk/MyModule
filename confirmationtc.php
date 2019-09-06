<?php
/**
* 2014 PAYU LATAM
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PAYU LATAM <sac@mymodule.com>
*  @copyright 2014 PAYU LATAM
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

require('../../config/config.inc.php');
include('mymodule.php');
	
	/*echo "<br>response_code_pol: ".$_REQUEST['response_code_pol'];
	echo "<br>response_sale: ".$_REQUEST['reference_sale'];
	echo "<br>sign: ".$_REQUEST['sign'];
	echo "<br>test: ".$_REQUEST['test'];
	echo "<br>currency: ".$_REQUEST['currency'];
	echo "<br>payment_method_id: ".$_REQUEST['payment_method_id'];
	echo "<br>value: ".$_REQUEST['value'];
	echo "<br>pse_bank: ".$_REQUEST['pse_bank'];
	echo "<br>state_pol: ".$_REQUEST['state_pol'];*/

	
	if (isset($_REQUEST['payment_method_id']))
	{
		$payment_method_id = $_REQUEST['payment_method_id'];

	}

	if ($payment_method_id == 2) 	
	{
		//echo "<br> entro ";
		
		if (isset($_REQUEST['reference_sale']))
		{
			$reference_sale = $_REQUEST['reference_sale'];
		}
		if (isset($_REQUEST['response_code_pol']))
		{
			$response_code_pol = $_REQUEST['response_code_pol'];
		}
		if (isset($_REQUEST['sign']))
		{
			$signature = $_REQUEST['sign'];
		}
		if (isset($_REQUEST['test']))
		{
			$test = $_REQUEST['test'];
		}
		if (isset($_REQUEST['currency']))
		{
			$currency = $_REQUEST['currency'];
		}
		if (isset($_REQUEST['value']))
		{
			$value = $_REQUEST['value'];
			$New_value = number_format($value, 1, '.', '');
		}
		if (isset($_REQUEST['pse_bank']))
		{
			$pse_bank = $_REQUEST['pse_bank'];
		}
		if (isset($_REQUEST['merchant_id']))
		{
			$merchant_id = $_REQUEST['merchant_id'];
		}
		if (isset($_REQUEST['state_pol']))
		{
			$state_pol = $_REQUEST['state_pol'];
		}


		$mymodule = new MyModule();
		$api_key = Configuration::get('PAYU_LATAM_API_KEY');
		$firma_cadena = "$api_key~$merchant_id~$reference_sale~$New_value~$currency~$state_pol";
		$firmacreada = md5($firma_cadena);
		

		$reference_code = $reference_sale;

		$cart = new Cart((int)$reference_code);

		
			
			if ($state_pol == 4) 
			{
				$state = 2;
			}
			elseif ($state_pol == 6) 
			{
				$state = 15;
			}
			elseif ($state_pol == 104) 
			{
				$state = 8;
			}
			elseif ($state_pol == 7) 
			{
				$state = 20;
			}


			if (!Validate::isLoadedObject($cart))
			{
	    		$errors[] = $this->module->l('Invalid Cart ID');

	    	}
			else
			{               
				$currency_cart = new Currency((int)$cart->id_currency);

				if ($currency != $currency_cart->iso_code)
				{
					$errors[] = $this->module->l('Invalid Currency ID').' '.($currency.'|'.$currency_cart->iso_code);
				}
				else
				{
					
					if ($cart->orderExists())
					{
						$order = new Order((int)Order::getOrderByCartId($cart->id));
						
						if (_PS_VERSION_ < '1.5')
						{
							$current_state = $order->getCurrentState();
							if ($current_state != 2)
							{
								$history = new OrderHistory();
								$history->id_order = (int)$order->id;
								$history->changeIdOrderState($state, $order->id);
								$history->addWithemail(true);
							}
						}
						else
						{
							$current_state = $order->current_state;
							if ($current_state != 2)
							{
								$history = new OrderHistory();
								$history->id_order = (int)$order->id;
								$history->changeIdOrderState($state, $order, true);
								$history->addWithemail(true);
							}
						}
					}			
				}
			}
	}
?>