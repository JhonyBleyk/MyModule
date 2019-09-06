<table class="table table-responsive">
<tr>
	<td colspan="4" class="text-center">
		<h2>{l s='Choose your Credit Card Registred' mod='mymodule'}

		<a id="open_conditions" href="#conditions" title="Insertar Tarjeta" style="float: right;">
			<button  class="btn btn-default button button-small" >
				<span>{l s='+' mod='mymodule'}</span>
			</button>			
		</a>
		</h2>
	</td>		
</tr>
{$i=0}
{foreach $tarjetas as $contact}  					
	
	{if $i == 0}
	{$checked2 = 'checked'}
	{else}
	{$checked2 = ''}
	{/if}		
		{foreach $contact as $key => $value}	  				  		 					
		  	{if $key == "id_token" }
		  		{$id_token = $value}
		 	{elseif $key == "four_number"}
		 		{$four_number = $value}
		 	{elseif $key == "type_target"}
		 		{$type_target = $value}
		 	{elseif $key == "id"}
		 		{$id_goToken = $value}
		 	{elseif $key == "name_pagador"}
		 		{$name_pagador = $value}
		 	{elseif $key == "iso_code_contry"}
		 		{$iso_code_contry = $value}
		 	{elseif $key == "document"}
		 		{$document = $value}
		 	{elseif $key == "email_pagador"}
		 		{$email_pagador = $value}
		 	{elseif $key == "pais"}
		 		{$pais = $value}					
		 	{/if}

		{/foreach}
	<tr>
		<td  class="text-right" width="25%">
			<input type="radio" {$checked2} id="tarjetaAusar{$i}" name="tarjetaAusar" value="{$id_goToken}">
			<label for="tarjetaAusar{$i}" >
			<img src="../../../~goshopaza1/modules/mymodule/img/{$type_target}.png">		
			<span style="font-weight: bold;">  ***{$four_number}</span></label>

		</td>
		<td  class="text-left" width="25%">
			<label for="tarjetaAusar{$i}" >
			<span style="font-weight: bold;">Nombre del pagador: </span><span>{$name_pagador}</span>
			
			<br>
			<span style="font-weight: bold;">Documento: </span><span>{$document}</span>
			
			</label>			
		</td>
		<td  class="text-left" width="25%">			
			<label for="tarjetaAusar{$i}" >
			<span style="font-weight: bold;">País de la Tarjeta: </span><span>{$pais}</span>
			
			<br>
			<span style="font-weight: bold;">@Mail: </span><span>{$email_pagador}</span>		
			
			</label>
		</td>	
		<td width="25%">
			<a id="ncargar_target" href="javascript:deleteTarjeta({$id_goToken})" ><FONT COLOR=red>						
				<span style="float: right; margin-top: 7px;">{l s='Delete' mod='mymodule'}</span></FONT>			
			</a>
		</td>
	</tr>
		{$i = $i+1}
{/foreach}
	
</table>

<table  class="table table-responsive">
<tr>
	<td colspan="2"  class="text-center">
		<a>
			<button type="submit" class="btn btn-default button button-small" >
				<span>{l s='pay here' mod='mymodule'}</span>
			</button>			
		</a>
	</td>
</tr>