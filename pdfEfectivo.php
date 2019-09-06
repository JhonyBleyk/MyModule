<?php 
ob_start();
global $smarty;
require('../../config/config.inc.php');

$ResultMedioPago = Tools::getValue('medioPago');
$Convenio = Tools::getValue('Convenio');
$ResultOrderId = Tools::getValue('CodigoPago');
$ResultDateToday = Tools::getValue('Fechahoy');
$fechaExpiraDate = Tools::getValue('Fecha_expira');
$horaExpiraDate = Tools::getValue('horaExpira');
$ResultamoutPay = Tools::getValue('Monto');

//echo "medio pago ".$ResultMedioPago;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<img src="./img/goshopcomco-1437170505.jpg" class="img-responsive">
<table class="table table-bordered stock-management-on">
			<thead>
				<tr >
					<th  colspan="2" align="center">
						<h2> Pague su Pedido en Puntos     

						<?php
						 if ($ResultMedioPago == "BALOTO") 
						 {
							?>
							<img src="./img/baloto.png">
							
							
							<?php
						}
						else
						{
							?>
							<img src="./img/efecty.png">
							<?php
						}
						?>
						</h2>
					</th>
				</tr>
				<tr >
					<th class="cart_product first_item">
						CONVENIO No. <?php echo $Convenio;?>
					</th>
					<th class="cart_product first_item">
						NUMERO DE PAGO <?php echo $ResultOrderId; ?>
					</th>
				</tr>
			</thead>
				<tbody>
					<tr class="cart_item last_item first_item address_5 odd" >
						<td class="cart_product" rowspan="4" >
							A NOMBRE DE Pagosonline.NET S.A.S
							<br>
							<img src="./img/logo.png" class="img-responsive">
						</td>
					
						<td class="cart_product">
							COMPRA REALIZADA EN azaleia.com.co							
						</td>

					</tr>
					<tr>
						<td>							
							Fecha de La Compra: <?php echo $ResultDateToday;?>
						</td>
					</tr>
					<tr>
						<td>
							
							<font color="red" weight="bold">							
							PAGUE ANTES DEL : <?php echo $fechaExpiraDate;?>
							a LAS : <?php echo $horaExpiraDate;?> HORAS
							</font>
						</td>
					</tr>

					<tr>
						<td align="center" style="background-color:gray; font-weight:bold; color: #fff" >
							<font color="white" >$<?php echo $ResultamoutPay;?></font>
						</td>
					</tr>
				</tbody>
		</table>
		<h1>INFORMACI&Oacute;N DE SU INTERES</h1>
		<table class="table-responsive">
		<thead>
			<tr>
				<th width="33%">
					<img src="./img/pago.png" class="img-responsive">
				</th>
				<th width="33%">
					<img src="./img/pago2.png" class="img-responsive">
					
				</th>
				<th width="33%">
					<img src="./img/pago3.png" class="img-responsive">
				</th>
			</tr>
		</thead>	
		<tbody>
			<tr>
				<td width="33%">
					<h3>Presenta este comprobante en
cualquier punto Efecty del país
para realizar el pago de tu
compra (el comprobante es válido
solo para el pago aquí descrito).
</h3>
				</td>
				<td width="33%">
					<h3>Ten en cuenta la fecha de
vencimiento de este
comprobante ya que no podrás
utilizarlo si se encuentra vencido.
</h3>
				</td>
				<td width="33%">
					<h3>Una vez recibido tu pago en
Efecty, PayU enviará la
confirmación del pago a azaleia.com.co; el cuál procederá a
hacer entrega del
producto/servicio que estás
adquiriendo.
</h3>
				</td>
			</tr>
		</tbody>		
</table>
<?php
require_once("dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->load_html(ob_get_clean());
	$dompdf->render();
	$pdf = $dompdf->output();
	$filename = "pagos/codigo_aprobacion".$ResultOrderId.'.pdf';
	file_put_contents($filename, $pdf);
	$dompdf->stream($filename);

Tools::redirect(Context::getContext()->link->getModuleLink('../autenticacion?back=my-account',false));
?>