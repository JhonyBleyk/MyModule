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
include_once('../../header.php');



$mymodule = new MyModule();
$api_key = Configuration::get('PAYU_LATAM_API_KEY');
$merchant_id = $_REQUEST['merchantId'];
$referenceCode = $_REQUEST['referenceCode'];
$TX_VALUE = $_REQUEST['TX_VALUE'];
$New_value = number_format($TX_VALUE, 1, '.', '');
$currency = $_REQUEST['currency'];
$muestraCurrency = $currency;
$transactionState = $_REQUEST['transactionState'];
$firma_cadena = "$api_key~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$firmacreada = md5($firma_cadena);
$firma = $_REQUEST['signature'];
$reference_pol = $_REQUEST['reference_pol'];
$cus = $_REQUEST['cus'];
$extra1 = $_REQUEST['description'];
$pseBank = $_REQUEST['pseBank'];
$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
$transactionId = $_REQUEST['transactionId'];
$ipvisitante = $_SERVER["REMOTE_ADDR"];
/*
echo "<br> firma ".$firma;
echo "<br> firma Creada ".$firmacreada;
echo "<br> entro ".$_REQUEST['transactionState'];*/

if (Tools::strtoupper($firma) == Tools::strtoupper($firmacreada))
{	
	
	if ($transactionState == 4 ) 
	{
		$estadoTx = "Transacción aprobada";
		$state = 2; /* pago aceptado es el estado*/
		$color = "green";			
	}
	elseif ($transactionState == 6 ) 
	{
		$estadoTx = "Transacción rechazada";
		$state = 15; /* pago rechazado es el estado*/
		$color = "red";		
	}
	elseif ($transactionState == 104 ) 
	{
		$estadoTx = "Error";
		$state = 8; /* Error En pago es el estado*/
		$color = "red";		
	}
	elseif ($transactionState == 7 ) 
	{
		$estadoTx = "Transacción pendiente";
		$state = 20; /* Error En pago es el estado*/
		$color = "orange";		
	}
	else 
	{
		$estadoTx=$_REQUEST['mensaje'];
	}

	?>
	<div id="ImprimirArea">
	
	<div class="center_column col-xs-12 col-sm-6" align="center">
		<img src="/~goshopaza1/modules/mymodule/img/pse.png" class="img-responsive">
		<h2>Resumen Transacción</h2>
		<table class="table table-bordered footab default footable-loaded footable">
		
		<tr>
		<td class="first_item footable-first-column" width="50%">Empresa</td>
		<td> <font weight="bold">Calzados Azaleia de Colombia</font></td>
		</tr>

		<tr>
		<td class="first_item footable-first-column" width="50%">NIT</td>
		<td> <font weight="bold">830057082-0</font></td>
		</tr>
		<?php

		$Fecha = date("d-m-Y");

		?>

		<tr>
		<td class="first_item footable-first-column" width="50%">Fecha</td>
		<td> <font weight="bold"><?php echo $Fecha; ?></font></td>
		</tr>	

		<tr>
		<td class="first_item footable-first-column">Compra Realizada en:</td>
		<td >Azaleia.com.co</td>
		</tr>

		<tr>
		<td class="first_item footable-first-column" width="50%">Estado de la transaccion</td>
		<td> <font color="<?php echo $color; ?>" weight="bold"><?php echo $estadoTx; ?></font></td>
		</tr>
		<tr>
		<!-- <tr>
		<td class="first_item footable-first-column" width="50%">ID de la transaccion</td>
		<td ><?php echo $transactionId; ?></td>
		</tr> -->
		<tr>
		<td class="first_item footable-first-column" width="50%">Referencia de la venta</td>
		<td><?php echo $referenceCode; ?></td> 
		</tr>
		<!-- $reference_pol -->
		<tr>
		<td class="first_item footable-first-column">Referencia de la transaccion</td>
		<td ><?php echo $transactionId; ?></td>
		</tr>		
		<?php
		if($pseBank != null) 
		{
		?>
			<tr>
			<td class="first_item footable-first-column">Numero de Transacción /CUS</td>
			<td ><?php echo $cus; ?> </td>
			</tr>
			<tr>
			<td class="first_item footable-first-column">Banco </td>
			<td><?php echo $pseBank; ?> </td>
			</tr>
		<?php
		}
		?>
		<tr>
		<td class="first_item footable-first-column">Valor total</td>
		<td>$<?php echo number_format($TX_VALUE,0,',','.'); ?></td>
		</tr>
		<tr>
		<td class="first_item footable-first-column">Moneda</td>
		<td ><?php echo $muestraCurrency; ?></td>
		</tr>
		<tr>
		<td class="first_item footable-first-column">Descripción</td>
		<td ><?php echo ($extra1); echo "-".$transactionState; ?></td>
		</tr>
		<tr>
		<td class="first_item footable-first-column">Entidad</td>
		<td ><?php echo ($lapPaymentMethod); ?></td>
		</tr>

		<tr>
		<td class="first_item footable-first-column">IP Origen</td>
		<td ><?php echo ($ipvisitante); ?></td>
		</tr>

		</table class="table table-bordered footab default footable-loaded footable">
		<table class="table table-bordered footab default footable-loaded footable">
		
		<?php
		if ($transactionState == 6 || $transactionState == 104) 
		{
			?>
			<tr align="center">
				<td colspan="2" style="text-align: center;" >
					<button name="reinternar"  class="button btn btn-default button-medium" onclick="javascript:history.go(-8)">
						<span>Reintentar Transacción</span>
					</button>
				</td>
			</tr>
			<?php
		}
		?>
			<tr>		
				<td>
				<a href="/~goshopaza1/historial-de-pedidos">
					<button name="finalizar_transaccion"  class="button btn btn-default button-medium" style="text-align: center;" >
						<span>Finalziar Transaccion</span>
					</button>
				</a>	
				</td>
				<td>
					<button name="imprimir_comprobante"  class="button btn btn-default button-medium" style="text-align: center;" onclick="javascript:imprSelec('ImprimirArea')">
						<span>Imprimir Comprobante</span>
					</button>					
				</td>
			</tr>
			
		</table>
	</div>
	</div>	
	<?php
}
else
{
	?>
	<h1>Error validando firma digital.</h1>
	<?php
}
include( '../../footer.php' );
if ($transactionState==4 || $transactionState==7) 
{
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
	$customer = new Customer((int)$cart->id_customer);		
	$currency = $context->currency;		
	$total = (float)($cart->getOrderTotal(true, Cart::BOTH));		
	
	$mymodule->validateOrder($cart->id, $state, $total, $mymodule->displayName, $referenceCode, array(), (int)$currency->id, false, $customer->secure_key);		
	$order = new Order($mymodule->currentOrder);	
	Tools::redirect(Context::getContext()->link->getModuleLink("../modules/mymodule/respuestapse.php".$_SERVER['REQUEST_URI'],false));	
}
?>
