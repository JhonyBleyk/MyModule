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



//echo "entro ";

$arreglo = unserialize($_GET['arreglo']); 



//var_dump($arreglo);





foreach ($arreglo as $key => $value) 

{

	if ($key=='Fecha') 

	{

		$Fecha = $value;

	}

	elseif ($key=='Refencecode') 

	{

		$referenceCode = $value;

	}

	elseif ($key=='transactionId') 

	{

		$transactionId = $value;

	}

	elseif ($key=='TX_VALUE') 

	{

		$TX_VALUE = $value;

	}

	elseif ($key=='transactionState') 

	{

		$transactionState = $value;

	}

	elseif ($key=='ipvisitante') 

	{

		$ipvisitante = $value;

	}

	elseif ($key=='state') 

	{

		if ($value == 'APPROVED') 

		{

			$estadoTx = 'Aprobada';

		}

		elseif ($value == 'DECLINED') 

		{

			$estadoTx = 'Declinada';

		}

		elseif ($value == 'ERROR') 

		{

			$estadoTx = 'Error';

		}

		elseif ($value == 'EXPIRED') 

		{

			$estadoTx = 'EXPIRO';

		}

		elseif ($value == 'PENDING') 

		{

			$estadoTx = 'Pendiente';

		}

		elseif ($value == 'SUBMITTED') 

		{

			$estadoTx = 'Pendiente';

		}

		

	}

	elseif ($key=='estadoTx') 

	{

		$estadoTxDetalle = $value;

	}

	elseif ($key=='color') 

	{

		$Color = $value;

	}

}



/*$mymodule = new MyModule();

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

*/

?>

<h1>Detalle del Pago Por Tarjeta Credito

&nbsp;&nbsp;

<img src="../../../~goshopaza1/modules/mymodule/img/tarjetas.png" >

</h1>

<div id="ImprimirArea">



	<div class="center_column col-xs-12 col-sm-6" align="center">		

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

		

		<tr>

		<td class="first_item footable-first-column" width="50%">Fecha</td>

		<td> <font weight="bold"><? echo $Fecha; ?></font></td>

		</tr>	



		<tr>

		<td class="first_item footable-first-column">Compra Realizada en:</td>

		<td >Azaleia.com.co</td>

		</tr>



		<tr>

		<td class="first_item footable-first-column" width="50%">Estado de la transaccion</td>

		<td> <font color="<? echo $Color; ?>" weight="bold"><? echo $estadoTx; ?></font></td>

		</tr>

		<tr>

		<td class="first_item footable-first-column" width="50%">Detalle Estado de la transaccion</td>

		<td> <font color="<? echo $Color; ?>" weight="bold"><? echo $estadoTxDetalle; ?></font></td>

		</tr>

		<!-- <tr>

		<td class="first_item footable-first-column" width="50%">ID de la transaccion</td>

		<td ><?php echo $transactionId; ?></td>

		</tr> -->

		<tr>

		<td class="first_item footable-first-column" width="50%">Referencia de la venta</td>

		<td><? echo $referenceCode; ?></td> 

		</tr>

		<!-- $reference_pol -->

		<tr>

		<td class="first_item footable-first-column">Referencia de la transaccion</td>

		<td ><? echo $transactionId; ?></td>

		</tr>		

		<tr>

		<td class="first_item footable-first-column">Valor total</td>

		<td><? echo $TX_VALUE; ?></td>

		</tr>

		<tr>

		<td class="first_item footable-first-column">Moneda</td>

		<td >Pesos</td>

		</tr>

		<tr>

		<td class="first_item footable-first-column">Descripción</td>

		<td ><? echo $transactionState; ?></td>

		</tr>

		<tr>

		<td class="first_item footable-first-column">IP Origen</td>

		<td ><? echo $ipvisitante; ?></td>

		</tr>



		</table class="table table-bordered footab default footable-loaded footable">

		<table class="table table-bordered footab default footable-loaded footable">

		<?php 

		if ($estadoTx == 'Error' || $estadoTx == 'Declinada') 

		{				

		?>	

			<tr align="center">

				<td colspan="2" style="text-align: center;" >

					<button name="reinternar"  class="button btn btn-default button-medium" onclick="javascript:history.go(-4)">

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

<?

include( '../../footer.php' );

?>

