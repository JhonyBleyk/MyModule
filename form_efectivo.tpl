<h1>{l s='Welcome to Pay Cash' mod='mymodule'}</h1>
{$validacion_pasos = md5("JonathanAndEmersonAzaleia2015")}
{if $pagoEfectivoSubmit != 1280}

<form name="payu_latam_form_efectivo" method="post" action="form_efectivo.php">

<table  class="table table-responsive">

	<tr>
		<td class="text-center">
			{l s='User Name:' mod='mymodule'}
		</td>	
		<td class="text-center">			
			{$payerFullName}
		</td>		
	</tr>
	<tr>
		<td class="text-center">
			{l s='E-mail:' mod='mymodule'}
		</td>	
		<td class="text-center">			
			{$buyerEmail}
		</td>		
	</tr>
	<tr>
		<td class="text-center">
			{l s='Amount:' mod='mymodule'}
		</td>	
		<td class="text-center">	
			$ {$amontformat}
		</td>		
	</tr>

	<tr>
		<td colspan="2" class="text-center">
			<h2>{l s='choose a means of payment between Baloto and Efecty' mod='mymodule'}</h2>
		</td>		
	</tr>	
	
	<tr>
		<td class="text-center">
		<div class="cc-selector">
			<input  checked="checked" id="baloto2" type="radio" name="pagoEfectivo" value="BALOTO" />
        	<label class="drinkcard-cc baloto" for="baloto2"></label>
        
		</td>	
		<td class="text-center">
			
			<input id="efecty2" type="radio" name="pagoEfectivo" value="EFECTY" />
        	<label class="drinkcard-cc efecty" for="efecty2"></label>
        </div>
		</td>		
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<a>
				<button type="submit" name="pagoEfectivoSubmit" class="btn btn-default button button-small" value="1280">
					<span>{l s='Generate Code of Pay' mod='mymodule'}</span>
				</button>			
			</a>
		</td>		
	</tr>
</table>

<input type="hidden" name="accountId" id="accountId" value="{$accountId}"/>
<input type="hidden" name="merchantId" id="merchantId" value="{$merchantId}"/>
<input type="hidden" name="apiKey" id="apiKey" value="{$apiKey}"/>
<input type="hidden" name="description" id="description" value="{$description}"/>
<input type="hidden" name="referenceCode" id="referenceCode" value="{$referenceCode}"/>
<input type="hidden" name="amount" id="amount" value="{$amount}"/>
<input type="hidden" name="tax" id="tax" value="{$tax}"/>
<input type="hidden" name="taxReturnBase" id="taxReturnBase" value="{$taxReturnBase}"/>
<input type="hidden" name="signature" id="signature" value="{$signature}"/>
<input type="hidden" name="currency" id="currency" value="{$currency}"/>
<input type="hidden" name="buyerEmail" id="buyerEmail" value="{$buyerEmail}"/>
<input type="hidden" name="test" id="test" value="{$test}"/>
<input type="hidden" name="extra1" id="extra1" value="{$extra1}"/>
<input type="hidden" name="responseUrl" id="responseUrl" value="{$responseUrl}"/>
<input type="hidden" name="confirmationUrl" id="confirmationUrl" value="{$confirmationUrl}"/>
<input type="hidden" name="payerFullName" id="payerFullName" value="{$payerFullName}"/>
<input type="hidden" name="billingAddress" id="billingAddress" value="{$billingAddress}"/>
<input type="hidden" name="shippingAddress" id="shippingAddress" value="{$shippingAddress}"/>
<input type="hidden" name="telephone" id="telephone" value="{$telephone}"/>
<input type="hidden" name="billingCity" id="billingCity" value="{$billingCity}"/>
<input type="hidden" name="shippingCity" id="shippingCity" value="{$shippingCity}"/>
<input type="hidden" name="billingCountry" id="billingCountry" value="{$billingCountry}"/>
<input type="hidden" name="shippingCountry" id="shippingCountry" value="{$shippingCountry}"/>
<input type="hidden" name="validacion_pasos" id="validacion_pasos" value="{$validacion_pasos}"/>


</form>


{else}


	{if $ResultCode == "ERROR"}
		<table  class="table table-responsive">
		<tr>
			<td>{$ERROR_RESPUESTA}</td>
		</tr>			
		</table>

		

	{else}


	<div id="ImprimirArea">
		<table class="table table-bordered stock-management-on">
			<thead>
				<tr >
					<th  colspan="2" align="center">
						<h2>{l s='Pay in points   ' mod='mymodule'}  

						{if $ResultMedioPago == "BALOTO"}
							<img src="../../../~goshopaza1/modules/mymodule/img/baloto.png">
							{$convenio = 950110}
						{else}
							<img src="../../../~goshopaza1/modules/mymodule/img/efecty.png">
							{$convenio = 110528}
						{/if}
						</h2>
					</th>
				</tr>
				<tr >
					<th class="cart_product first_item">
						{l s='Convenio No. ' mod='mymodule'} {$convenio}
					</th>
					<th class="cart_product first_item">
						{l s='Number of Pay: ' mod='mymodule'} {$ResultOrderId}
					</th>
				</tr>
			</thead>
				<tbody>
					<tr class="cart_item last_item first_item address_5 odd" >
						<td class="cart_product" rowspan="2" >
							{l s='To name of :  Pagosonline.NET S.A.S' mod='mymodule'}
							<br>
							<img src="../../../~goshopaza1/modules/mymodule/img/logo.png" class="img-responsive">
						</td>
					
						<td class="cart_product">
							{l s='Compra realizada en: ' mod='mymodule'} {$shop_name}
							<br>
							{l s='Date of Bay : ' mod='mymodule'} {$ResultDateToday}
							<br>
							<h3><font color="red" weight="bold">
							{l s='Pay before of: ' mod='mymodule'} {$fechaExpiraDate} 
							{l s='Hour: ' mod='mymodule'} {$horaExpiraDate} 
							</font></h3>
						</td>

					</tr>
					<tr >
						<td style="background-color:gray; font-weight:bold; color: #fff" >
							<h3><font color="white" >${$ResultamoutPay}</font></h3>
						</td>
					</tr>
				</tbody>
		</table>
		<table class="table-responsive">
		<h1>{l s='Information of your interest' mod='mymodule'} </h1>
		<thead>
			<tr>
				<th width="33%">
					<img src="../../../~goshopaza1/modules/mymodule/img/pago.png" class="img-responsive">
				</th>
				<th width="33%">
					<img src="../../../~goshopaza1/modules/mymodule/img/pago2.png" class="img-responsive">
					
				</th>
				<th width="33%">
					<img src="../../../~goshopaza1/modules/mymodule/img/pago3.png" class="img-responsive">
				</th>
			</tr>
		</thead>	
		<tbody>
			<tr>
				<td width="33%">
					<h3>{l s='Present this voucher any point of the country for payment of your purchase (the voucher is valid only for payment described here).' mod='mymodule'}</h3>
				</td>
				<td width="33%">
					<h3>{l s='Please it is necessary make the pay in the dates before mentioned' mod='mymodule'}</h3>
				</td>
				<td width="33%">
					<h3>{l s='Upon receipt of your payment in Efecty, PayU will sent the payment confirmation to Azaleia; which shall deliver he product / service you are acquiring.' mod='mymodule'}</h3>
				</td>
			</tr>
		</tbody>		
		</table>

	</div>
		<table class="table-responsive" align="center" width="100%">
			<tbody>
			<tr align="center">
				<td width="50%" align="center">
					<button name="Imprimir" class="btn btn-default button button-small" onclick="javascript:imprSelec('ImprimirArea')">
						<span>{l s='IMPRIMIR' mod='mymodule'}</span>
					</button>	
				</td>				
				<td width="50%" align="center">
				<a href="pdfEfectivo.php?medioPago={$ResultMedioPago}&Convenio={$convenio}&CodigoPago={$ResultOrderId}&Fechahoy={$ResultDateToday}&Fecha_expira={$fechaExpiraDate}&horaExpira={$horaExpiraDate}&Monto={$ResultamoutPay}">
					<button  name="DESCARGAR" class="btn btn-default button button-small" value="12804315392jj">
						<span>{l s='DESCARGAR' mod='mymodule'}</span>
					</button>
				</a> 
				</td>
			</tr>
				
			</tbody>			
		</table>




{/if}








{/if}