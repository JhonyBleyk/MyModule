<h1>{l s='Welcome to Pay by transfer' mod='mymodule'}
&nbsp;&nbsp;
<img src="../../../~goshopaza1/modules/mymodule/img/pse.png" >
</h1>
{$validacion_pasos = md5("JonathanAndEmersonAzaleia2015")}
{if $pagoPSESubmit != 1280}
<h6><font color="red" weight="bold">{l s='(*) Todos los campos son obligatorios ' mod='mymodule'} </font></h6>
	<div class="center_column col-xs-12 col-sm-6" align="center">
		<form name="payu_latam_form_pse" method="post" action="form_pse.php" class="std box">

			
			<table width="100%">
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='select your bank ' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
						<select  name="Bancos_list"  class="form-control-pse" width='70%'>
					 		{foreach from=$Banks_list item=row}		 			
					 			<option value="{$row['pseCode']}">
					 				{$row['description']}
					 			</option>
					 		{/foreach}
						</select>
					</td>
				</tr>
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='Type of Person ' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
						<select  name="typePerson"  class="form-control-pse" width='70%'>
					 		
					 			<option value="N">
					 				{l s='NATURAL PERSON: ' mod='mymodule'}			
					 			</option>
					 			<option value="J">
					 				{l s='LEGAL PERSON: ' mod='mymodule'}			
					 			</option>
					 		
						</select>
					</td>
				</tr>
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='Type of Document' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
						<select  name="typeDocument"  class="form-control-pse" width='70%'>					 	
					 			<option value="CC">
					 				{l s='CC - Cédula de ciudadanía ' mod='mymodule'}			
					 			</option>
					 			<option value="CE">
					 				{l s='CE - Cédula de extranjería ' mod='mymodule'}			
					 			</option>
					 			<option value="NIT">
					 				{l s='NIT - En caso de ser una Empresa ' mod='mymodule'}			
					 			</option>
					 			<option value="TI">
					 				{l s='TI - Tarjeta de Identidad ' mod='mymodule'}			
					 			</option>
					 			<option value="PP">
					 				{l s='PP - Pasaporte ' mod='mymodule'}			
					 			</option>
					 			<option value="IDC">
					 				{l s='IDC - Identificador único de cliente ' mod='mymodule'}			
					 			</option>
					 			<option value="CEL">
					 				{l s='CEL- Identificacion de línea móvil ' mod='mymodule'}			
					 			</option>
					 			<option value="RC">
					 				{l s='RC- Registro civil de nacimiento ' mod='mymodule'}			
					 			</option>
					 			<option value="DE">
					 				{l s='DE - Documento de identificación extranjero ' mod='mymodule'}			
					 			</option>					 		
						</select>
					</td>
				</tr>
				<tr>
					
					<td class="page-subheading" width="50%">						
						<h4>{l s='Number of Document' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
					
						<input type="text" name="numberDocument" id="numberDocument" class="form-control-pse" maxlength="20" value=""/>
					
					</td>
					
				</tr>
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='Names and last-Names ' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
						<input type="text" name="namesAndLastnames" id="namesAndLastnames" class="form-control-pse" value="{$payerFullName}" />
					</td>
				</tr>
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='Phone' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">
						<input type="text" name="phone" id="phone" class="form-control-pse" value="{$telephone}" />
					</td>
				</tr>
				<tr>
					<td class="page-subheading" width="50%">
						<h4>{l s='E-mail ' mod='mymodule'}<font color="red" weight="bold">(*)</font>:</h4>
					</td>
					<td class="page-subheading" width="50%">						
						<input type="text" name="email" id="email"  class="form-control-pse" data-validate="isEmail" value="{$buyerEmail}"/>	
					</td>
				</tr>
				<tr >
					<td class="page-subheading" width="50%" style="text-align: center;">
					<br>
						<button name="volver"  class="button btn btn-default button-medium"  onclick="javascript:history.go(-3)">
							<span>{l s='Come back' mod='mymodule'}</span>
						</button>
					</td>				
					<td class="page-subheading" width="50%" style="text-align: center;">
					<br>
						<button type="submit" name="pagoPSESubmit"  class="button btn btn-default button-medium" value="1280">
							<span>{l s='Pay' mod='mymodule'}</span>
						</button>						
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
	</div>
{else}
	<h3></h3>

	{if $mensajeNullo != ''}
		<h2><font color="red" weight="bold">{$mensajeNullo}</font></h2>
		<button name="volver"  class="button btn btn-default button-medium" onclick="javascript:history.go(-3)" >
			<span>{l s='Come back' mod='mymodule'}</span>
		</button>
	{elseif $ERROR_RESPUESTA != ''}
		<h2><font color="red" weight="bold">{$ERROR_RESPUESTA}</font></h2>
		<button name="volver"  class="button btn btn-default button-medium" onclick="javascript:history.go(-3)">
			<span>{l s='Come back' mod='mymodule'}</span>
		</button>

	{else}


	{/if}
	
{/if}