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
*  @author    PAYU LATAM <sac@payulatam.com>
*  @copyright 2014 PAYU LATAM
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/


include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/mymodule.php');
include(dirname(__FILE__).'/header.php');

$mymodule = new MyModule();

$cart = Context::getContext()->cart;
$customer = Context::getContext()->customer;
$billing_address = new Address(Context::getContext()->cart->id_address_invoice);
$billing_address->country = new Country($billing_address->id_country);
$delivery_address = new Address(Context::getContext()->cart->id_address_delivery);
$delivery_address->country = new Country($delivery_address->id_country);
$products = $cart->getProducts();
$cart_details = $cart->getSummaryDetails(null, true);

$description = '';
foreach ($products as $product)
	$description .= $product['name'].',';

$currency = new Currency((int)$cart->id_currency);

$test = 0;
$gateway_url = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'/modules/'.$mymodule->name.'/';
if (Configuration::get('PAYU_LATAM_TEST') == 'true')
{
	$test = 1;
	$gateway_url = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'/modules/'.$mymodule->name.'/';
}

if (!Validate::isLoadedObject($customer) || !Validate::isLoadedObject($billing_address) && !Validate::isLoadedObject($currency))
{
	Logger::addLog('Issue loading customer, address and/or currency data');
	die('An unrecoverable error occured while retrieving you data');
}

$signature = md5(Configuration::get('PAYU_LATAM_API_KEY').'~'.Configuration::get('PAYU_LATAM_MERCHANT_ID').'~'.(int)$cart->id.'~'.
$cart->getordertotal(true).'~'.$currency->iso_code);

if ($cart_details['total_tax'] != 0)
	$base = $cart_details['total_price_without_tax'] - $cart_details['total_shipping_tax_exc'];
else
	$base = 0;

if (Configuration::get('PS_SSL_ENABLED') || (!empty($_SERVER['HTTPS']) && Tools::strtolower($_SERVER['HTTPS']) != 'off'))
{
	if (method_exists('Tools', 'getShopDomainSsl'))
		$url = 'https://'.Tools::getShopDomainSsl().__PS_BASE_URI__.'/modules/'.$mymodule->name.'/';
	else
		$url = 'https://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/'.$mymodule->name.'/';
}
else
	$url = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'/modules/'.$mymodule->name.'/';

?>
<center>
	<img src="<?php echo $url; ?>img/ruedas.gif" height="209" width="184"/>
	</br>
	<img src="<?php echo $url; ?>img/logo.png" height="50" width="135"/>
	</br>	
	<?php echo $mymodule->l('You will redirect to gateway PayU'); ?>
</center>

<?php
	if (_PS_VERSION_ < '1.5')
		$response_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'modules/mymodule/pages/response.php';
	else
		$response_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'index.php?fc=module&module=mymodule&controller=response';

	$confirmation_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.
	'modules/mymodule/pages/confirmation.php';

$useSSL = true;

require('../../config/config.inc.php');
Tools::displayFileAsDeprecated();

// init front controller in order to use Tools::redirect
$controller = new FrontController();
//$controller->init();

if (Tools::getvalue('form') == 1) 
{
	/*Tools::redirect(Context::getContext()->link->getModuleLink('mymodule', 'form_efectivo'));*/

	?>
	<form class="md-form" id="payu_latam_form" name="payu_latam_form" method="post" action="../../modules/mymodule/form_efectivo.php">
	<?php
	
}
elseif (Tools::getvalue('form') ==2) 
{	
	$validacion_pasos = md5("JonathanAndEmersonAzaleia2015");
	
	?>
	<form class="md-form" id="payu_latam_form" name="payu_latam_form" method="post" action="../../modules/mymodule/form_pse.php">

	
	<?php
}
elseif (Tools::getvalue('form') == 3) 
{
	?>
<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
  <input name="merchantId"    type="hidden"  value="508029"   >
  <input name="accountId"     type="hidden"  value="512321" >
  <input name="description"   type="hidden"  value="Test PAYU"  >
  <input name="referenceCode" type="hidden"  value="TestPayU" >
  <input name="amount"        type="hidden"  value="20000"   >
  <input name="tax"           type="hidden"  value="3193"  >
  <input name="taxReturnBase" type="hidden"  value="16806" >
  <input name="currency"      type="hidden"  value="COP" >
  <input name="signature"     type="hidden"  value="7ee7cf808ce6a39b17481c54f2c57acc"  >
  <input name="test"          type="hidden"  value="1" >
  <input name="buyerEmail"    type="hidden"  value="test@test.com" >
  <input name="responseUrl"    type="hidden"  value="http://www.test.com/response" >
  <input name="confirmationUrl"    type="hidden"  value="http://www.test.com/confirmation" >
  <input name="Submit"        type="submit"  value="Enviar" >
</form>



<?php
include(dirname(__FILE__).'/footer.php');
?>
<script type="text/javascript">
	window.onload = function() 
	{
		document.payu_latam_form.submit();
	};
</script>
