<h1>{l s='Welcome to Pay by Credit Card' mod='mymodule'}
&nbsp;&nbsp;
<img src="../../../~goshopaza1/modules/mymodule/img/tarjetas.png" >
</h1>

<!-- <p style="background:url(https://maf.pagosonline.net/ws/fp?id={$deviceSessionID}80200)"></p>
  <img src="https://maf.pagosonline.net/ws/fp/clear.png?id={$deviceSessionID}80200">
  <script src="https://maf.pagosonline.net/ws/fp/check.js?id={$deviceSessionID}80200"></script>
  <object type="application/x-shockwave-flash"
  data="https://maf.pagosonline.net/ws/fp/fp.swf?id={$deviceSessionID}80200" width="1" height="1"
  id="thm_fp">
  <param name="movie" value="https://maf.pagosonline.net/ws/fp/fp.swf?id={$deviceSessionID}80200" /> -->
</object>
{$validacion_pasos = md5("JonathanAndEmersonAzaleia2015")}
{if $pagoTarjetaCredito != 1280}

		<form name="payu_latam_form_tcp" method="post" action="form_tcd.php" class="std box">
			<table  class="table table-responsive">
				<tr >
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='User Name:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">			
						{$payerFullName}
					</td>		
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='E-mail:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">			
						{$buyerEmail}
					</td>
				</tr>
				
				<tr>
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='Amount:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">	
						$ {$amontformat}
					</td>		
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='address:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">			
						{$billingAddress}
					</td>
				</tr>
				<tr>
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='City:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">	
						{$billingCity}
					</td>		
					<td class="text-right" width="25%">
						<span style="font-weight: bold;">{l s='Country:' mod='mymodule'}</span>
					</td>	
					<td class="text-left" width="25%">			
						{$billingCountry}
					</td>
				</tr>
				</table>
				<table class="table table-responsive">
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
				<input type="hidden" name="pagoTarjetaCredito" id="pagoTarjetaCredito" value="1280"/>
				<input type="hidden" name="validacion_pasos" id="validacion_pasos" value="{$validacion_pasos}"/>
				<input type="hidden" name="cedula" id="validacion_pasos" value="{$documentoCedula}"/>
				<input type="hidden" name="divice33" id="divice33" value="{$deviceSessionID}"/>
				<table  class="table table-responsive">

				{if $tarjetastiene == 1}
				
				
				<div id="poll"></div>														
				
				{else}
				<table  class="table table-responsive">
				<tr>
					<td colspan="2" class="text-center">
						<a id="open_conditions" href="#conditions" title="Insertar Tarjeta">
							<button  class="btn btn-default button button-small" >
								<span>{l s='Register your Credit Card here' mod='mymodule'}</span>
							</button>			
						</a>
					</td>		
				</tr>	
				{/if}

				<tr>
					<td colspan="2" class="text-center">
						<a>
							<button name="pagoEfectivoSubmit" class="btn btn-default button button-small" onclick="javascript:history.go(-3)">
								<span>{l s='Back' mod='mymodule'}</span>
							</button>			
						</a>
					</td>		
				</tr>
			</table>
			
		</form>	

	<div style="display: none;">
	<div id="conditions" style="width:600px;height:450px;overflow:auto;">
	<div class="caja_tarjeta_credito">        
		
		
        <form action="" method="POST" id="create-form" class="clearfix">
        <div id="mylistID"></div>

            <img src="../../../~goshopaza1/modules/mymodule/img/tarjetas.png"  width='200' height='76' >
            <br>                        
        <table style="background:#f7f7f7;" >
			<tr >
				<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					<input type="hidden" id="id_customer" value="{$id_customer}"/>
					<label><span>Número de la tarjeta de crédito</span></label>
					<input type="text" size="30" payu-content="number" id="tarjeta12" onkeyup="payU.validateCard(this.value);">
					
                </td>
				
			</tr>

			<tr>
				<td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;" >
					<label>Expiración (MM/AAAA)</label> 
                </td>
                <td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;" >
                	
					 <label>Documento</label>
					
                </td>				
			</tr>
			<tr>
				<td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;" >
					
					<input type="text" size="2" payu-content="exp_month"><span> / </span>  <input type="text" size="4" payu-content="exp_year">
					
                </td>
                <td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					 <input type="text" size="25" payu-content="document" id="document" name="document" >
					 <input payu-content="payer_id" value="MI PAYER ID" type="hidden">
                </td>				
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 10px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					
					<label> <span>Nombre</span></label>
                	<input type="text" size="30" payu-content="name_card" id="name_pagador" >
                	
                	<label> <span>CVV</span></label>
                	<input type="text" size="8" payu-content="cvc">

                </td>
				
			</tr>
			<tr>
				<td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;" >
					<span>@Mail del Pagador</span>
                </td>
                <td style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					<span>País de la Tarjeta</span>
                </td>				
			</tr>
			<tr>
				<td>
					<input type="text" id="emailComprador" name="emailComprador"   value="{$buyerEmail}" />
                </td>
                <td>
					<select id="iso_Code_contry" name="iso_Code_contry">{$countries_list}</select>			
                </td>				
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					<span class="form-row create-errors" style="color:red"></span>
            		<div class="clear"></div>
                </td>				
			</tr>
			<tr >
				<td colspan="2" class="text-center" style="padding-top: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px;">
					  <button class="btn btn-default button button-small" type="submit">Guardar Tarjeta</button>
                </td>				
			</tr>
		</table>
           
<!-- 
            <div class="form-row first_row">
                



                <label> <span>Número de la tarjeta de crédito</span> 
                             </label>
                
                    <input type="text" size="30" payu-content="number" onkeyup="payU.validateCard(this.value);">
            </div>
              
                <div class="form-row">
                    <div class="expiracion">
                <label>Expiración (MM/AAAA)</label> 
                 <input type="text" size="2" payu-content="exp_month"><span> / </span>  <input type="text" size="4" payu-content="exp_year">
            </div>
                    <div class="documento">
                <label>Documento</label>
                   <input type="text" size="25" payu-content="document">
                    </div>
            </div>
                     
                 
            <input payu-content="payer_id" value="MI PAYER ID" type="hidden">
         

            <div class="form-row">
                <label> <span>Nombre</span></label>
                <input type="text" size="30" payu-content="name_card">
            </div>
            <div class="form-row">
                 <label> <span>CVV</span> 
                </label>
                <input type="text" size="8" payu-content="cvc">
                
            </div>

          
             
             <span class="form-row create-errors" style="color:red"></span>
            <div class="clear"></div>
            
            <button type="submit"></button> -->
            
        </form>
    
     </div>
    </div>
    </div>


{else}






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