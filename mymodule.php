<?php
if ( !defined( '_PS_VERSION_' ) )
  exit;
 
class MyModule extends PaymentModule
{
	public $id_customer;

  	public function __construct()
    {
	    $this->name = 'MyPayUCo';
	    $this->tab = 'Test';
	    $this->version = 1.0;
	    $this->author = 'Jhony Morales';
	    $this->need_instance = 0;
	 
	    parent::__construct();
	 
	    $this->displayName = $this->l( 'My PayU Colombia' );
	    $this->description = $this->l( 'Payment gateway for demo Colombia (All rights reserved by Jhony Morales).' );
	    $this->extra_mail_vars = array(
										'{mymodule_owner}' => Configuration::get('BANK_WIRE_OWNER'),
										'{mymodule_details}' => nl2br(Configuration::get('BANK_WIRE_DETAILS')),
										'{mymodule_address}' => nl2br(Configuration::get('BANK_WIRE_ADDRESS'))
										);
    }



public function install()
{
	$this->_createStates();

	if (!parent::install()
		|| !$this->registerHook('payment')
		|| !$this->registerHook('paymentReturn'))
		return false;
	return true;
}	

public function assignCountriesMymodule()
{
	// Get selected country
	if (Tools::isSubmit('id_country') && !is_null(Tools::getValue('id_country')) && is_numeric(Tools::getValue('id_country')))
		$selected_country = (int)Tools::getValue('id_country');
	else if (isset($this->_address) && isset($this->_address->id_country) && !empty($this->_address->id_country) && is_numeric($this->_address->id_country))
		$selected_country = (int)$this->_address->id_country;
	else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		// get all countries as language (xy) or language-country (wz-XY)
		$array = array();
		/*preg_match("#(?<=-)\w\w|\w\w(?!-)#",$_SERVER['HTTP_ACCEPT_LANGUAGE'],$array);
		if (!Validate::isLanguageIsoCode($array[0]) || !($selected_country = Country::getByIso($array[0])))*/
			$selected_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
	}
	else
		$selected_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');

	// Generate countries list
	if (Configuration::get('PS_RESTRICT_DELIVERED_COUNTRIES'))
		$countries = Carrier::getDeliveredCountries($this->context->language->id, true, true);
	else
		$countries = Country::getCountries($this->context->language->id, false);

	// @todo use helper
	$list = '';
	foreach ($countries as $country)
	{
		$selected = ($country['id_country'] == $selected_country) ? 'selected="selected"' : '';
		$list .= '<option value="'.$country['id_country'].'" '.$selected.'>'.htmlentities($country['name'], ENT_COMPAT, 'UTF-8').'</option>';
	}

	// Assign vars
	$this->context->smarty->assign(array(
		'countries_list' => $list,
		'countries' => $countries,
	));
}


public function uninstall()
{
	if (!parent::uninstall()
		|| !Configuration::deleteByName('PAYU_LATAM_MERCHANT_ID')
		|| !Configuration::deleteByName('PAYU_LATAM_ACCOUNT_ID')
		|| !Configuration::deleteByName('PAYU_LATAM_API_KEY')
		|| !Configuration::deleteByName('PAYU_LATAM_TEST')
		|| !Configuration::deleteByName('PAYU_OS_PENDING')
		|| !Configuration::deleteByName('PAYU_OS_FAILED')
		|| !Configuration::deleteByName('PAYU_OS_REJECTED'))
		return false;
	return true;
}

public function getContent()
{
	$html = '';

	if (isset($_POST) && isset($_POST['submitPayU']))
	{
		$this->_postValidation();
		if (!count($this->_postErrors))
		{
			$this->_saveConfiguration();
			$html .= $this->displayConfirmation($this->l('Settings updated'));
		}
		else
			foreach ($this->_postErrors as $err)
				$html .= $this->displayError($err);
	}
	return $html.$this->_displayAdminTpl();
}

private function _displayAdminTpl()
{
	$this->context->smarty->assign(array(
		'tab' => array(
			'intro' => array(
				'title' => $this->l('How to configure'),
				'content' => $this->_displayHelpTpl(),
				'icon' => '../modules/mymodule/img/info-icon.gif',
				'tab' => 'conf',
				'selected' => (Tools::isSubmit('submitPayU') ? false : true),
				'style' => 'config_payu'
			),
			'credential' => array(
				'title' => $this->l('Credentials'),
				'content' => $this->_displayCredentialTpl(),
				'icon' => '../modules/mymodule/img/credential.png',
				'tab' => 'crendeciales',
				'selected' => (Tools::isSubmit('submitPayU') ? true : false),
				'style' => 'credentials_payu'
			),
		),
		'tracking' => 'http://www.prestashop.com/modules/pagosonline.png?url_site='.Tools::safeOutput($_SERVER['SERVER_NAME']).'&id_lang='.
		(int)$this->context->cookie->id_lang,
		'img' => '../modules/mymodule/img/',
		'css' => '../modules/mymodule/css/',
		'lang' => ($this->context->language->iso_code != 'en' || $this->context->language->iso_code != 'es' ? 'en' : $this->context->language->iso_code)
	));

	return $this->display(__FILE__, 'views/templates/admin/admin.tpl');
}

private function _displayHelpTpl()
{
	return $this->display(__FILE__, 'views/templates/admin/help.tpl');
}

private function _displayCredentialTpl()
{
	$this->context->smarty->assign(array(
		'formCredential' => './index.php?tab=AdminModules&configure=mymodule&token='.Tools::getAdminTokenLite('AdminModules').
		'&tab_module='.$this->tab.'&module_name=mymodule',
		'credentialTitle' => $this->l('Log in'),
		'credentialInputVar' => array(
			'merchant_id' => array(
				'name' => 'merchant_id',
				'required' => true,
				'value' => (Tools::getValue('merchant_id') ? Tools::safeOutput(Tools::getValue('merchant_id')) :
				Tools::safeOutput(Configuration::get('PAYU_LATAM_MERCHANT_ID'))),
				'type' => 'text',
				'label' => $this->l('Merchant'),
				'desc' => $this->l('You will find the Merchant ID in the section “Technical Information”').'<br>'.$this->l('of the Administrative Module.'),
			),
			'api_key' => array(
				'name' => 'api_key',
				'required' => true,
				'value' => (Tools::getValue('api_key') ? Tools::safeOutput(Tools::getValue('api_key')) :
				Tools::safeOutput(Configuration::get('PAYU_LATAM_API_KEY'))),
				'type' => 'text',
				'label' => $this->l('Api Key'),
				'desc' => $this->l('You will find the API Key in the section “Technical Information”').'<br>'.$this->l('of the Administrative Module.'),
			),
			'account_id' => array(
				'name' => 'account_id',
				'required' => false,
				'value' => (Tools::getValue('account_id') ? (int)Tools::getValue('account_id') : (int)Configuration::get('PAYU_LATAM_ACCOUNT_ID')),
				'type' => 'text',
				'label' => $this->l('Account ID'),
				'desc' => $this->l('You will find the Account ID in the section “Account”').'<br>'.$this->l('of the Administrative Module.'),
			),
			'test' => array(
				'name' => 'test',
				'required' => false,
				'value' => (Tools::getValue('test') ? Tools::safeOutput(Tools::getValue('test')) : Tools::safeOutput(Configuration::get('PAYU_LATAM_TEST'))),
				'type' => 'radio',
				'values' => array('true', 'false'),
				'label' => $this->l('Mode Test'),
				'desc' => $this->l(''),
			))));
	return $this->display(__FILE__, 'views/templates/admin/credential.tpl');
}


public function hookPayment($params)
{
	if (!$this->active)
		return;
		
	$this->context->smarty->assign(array(
		'css' => '../modules/mymodule/css/',
		'module_dir' => _PS_MODULE_DIR_.$this->name.'/'
	));

	return $this->display(__FILE__, 'views/templates/hook/mymodule.tpl');
}

private function _postValidation()
{
	if (!Validate::isCleanHtml(Tools::getValue('merchant_id'))
		|| !Validate::isGenericName(Tools::getValue('merchant_id')))
		$this->_postErrors[] = $this->l('You must indicate the merchant id');

	if (!Validate::isCleanHtml(Tools::getValue('account_id'))
		|| !Validate::isGenericName(Tools::getValue('account_id')))
		$this->_postErrors[] = $this->l('You must indicate the account id');

	if (!Validate::isCleanHtml(Tools::getValue('api_key'))
		|| !Validate::isGenericName(Tools::getValue('api_key')))
		$this->_postErrors[] = $this->l('You must indicate the API key');

	if (!Validate::isCleanHtml(Tools::getValue('test'))
		|| !Validate::isGenericName(Tools::getValue('test')))
		$this->_postErrors[] = $this->l('You must indicate if the transaction mode is test or not');

}
public static function consultar_token($id_customer)
{
	if (@!$context)
	$context = Context::getContext();
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);




	$attributes = array();
	$attributesArray = array();
	/*$imprimir = 'SELECT 	tok.id_token, 
												tok.four_number, 
												tok.type_target, 
												tok.id, 
												tok.name_pagador, 
												tok.iso_code_contry, 
												tok.document, 
												tok.email_pagador,
												country.name as pais 
									FROM 		'._DB_PREFIX_.'token tok	
									INNER JOIN '._DB_PREFIX_.'country_lang country ON country.id_country = tok.iso_code_contry and country.id_lang = 2
		WHERE tok.id_customer = '.(int)$id_customer.' and tok.status = 1 order by tok.id DESC';*/
	$attributesArray = $db->executeS('SELECT 	tok.id_token, 
												tok.four_number, 
												tok.type_target, 
												tok.id, 
												tok.name_pagador, 
												tok.iso_code_contry, 
												tok.document, 
												tok.email_pagador,
												country.name as pais 
									FROM 		'._DB_PREFIX_.'token tok	
									INNER JOIN '._DB_PREFIX_.'country_lang country ON country.id_country = tok.iso_code_contry 
		WHERE tok.id_customer = '.(int)$id_customer.' and tok.status = 1 GROUP BY id_token order by tok.id DESC');
		$i=0;
		foreach ($attributesArray as $attribute)
		{
			$attributes[$i]['id_token'] = $attribute['id_token'];
			$attributes[$i]['four_number'] = $attribute['four_number'];
			$attributes[$i]['type_target'] = $attribute['type_target'];
			$attributes[$i]['id'] = $attribute['id'];
			$attributes[$i]['name_pagador'] = $attribute['name_pagador'];
			$attributes[$i]['iso_code_contry'] = $attribute['iso_code_contry'];
			$attributes[$i]['document'] = $attribute['document'];
			$attributes[$i]['email_pagador'] = $attribute['email_pagador'];
			$attributes[$i]['pais'] = $attribute['pais'];

			$i++;
		}
			
		//return $imprimir;
		return $attributes;
}
public static function consultar_token_total($token_selected)
{
	if (@!$context)
	$context = Context::getContext();
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);




	$attributes = '';
	$attributesArray = $db->executeS('SELECT 	tok.id_token, 
												tok.four_number, 
												tok.type_target, 
												tok.id, 
												tok.name_pagador, 
												tok.iso_code_contry, 
												tok.document, 
												tok.email_pagador
									FROM 		'._DB_PREFIX_.'token tok										
		WHERE tok.id = '.(int)$token_selected.' and tok.status = 1 order by tok.id DESC');
		$i=0;
		foreach ($attributesArray as $attribute)
		{
			$attributes['id_token'] = $attribute['id_token'];
			$attributes['four_number'] = $attribute['four_number'];
			$attributes['type_target'] = $attribute['type_target'];
			$attributes['id'] = $attribute['id'];
			$attributes['name_pagador'] = $attribute['name_pagador'];
			$attributes['iso_code_contry'] = $attribute['iso_code_contry'];
			$attributes['document'] = $attribute['document'];
			$attributes['email_pagador'] = $attribute['email_pagador'];
			
			$i++;
		}
	return $attributes;
}

public static function delete_token($id_gotoken)
{
	if (!$context)
	$context = Context::getContext();
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
	$attributes = '';
	$attributesArray = $db->executeS('select tok.* from '._DB_PREFIX_.'token tok WHERE id = '.(int)$id_gotoken.' ');
	foreach ($attributesArray as $attribute)
	{
			$attributes['id_token'] = $attribute['id_token'];
			$attributes['four_number'] = $attribute['four_number'];
			$attributes['type_target'] = $attribute['type_target'];
			$attributes['id'] = $attribute['id'];
			$attributes['name_pagador'] = $attribute['name_pagador'];
			$attributes['iso_code_contry'] = $attribute['iso_code_contry'];
			$attributes['document'] = $attribute['document'];
			$attributes['email_pagador'] = $attribute['email_pagador'];
			$attributes['id_customer'] = $attribute['id_customer'];			
	}

	try 
	{
		$soap_do = curl_init();
		if (FALSE === $soap_do) 
		{
			throw new Exception('failed to initialize');
		}
		else
		{
			$apykey = Tools::safeOutput(Configuration::get('PAYU_LATAM_API_KEY'));
			$customerid = $attributes['id_customer'];
			$jsondata = '{
						   "language": "es",
						   "command": "REMOVE_TOKEN",
						   "merchant": {
						      "apiLogin": "8PW8XRb2nUHyUa2",
						      "apiKey": "i4NVA65yBzb85Benva991Q9796"
						   },
						   "removeCreditCardToken": {
						      "payerId": "'.$customerid.'",
						      "creditCardTokenId": "'.$attributes['id_token'].'"
						   }
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
		}		
		curl_close($soap_do);
	} 
	catch (Exception $e) 
	{
		trigger_error(sprintf('Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);
	}

	$DATOSeeLIMI= 'update '._DB_PREFIX_.'token set status = 0 WHERE id = '.(int)$id_gotoken.' ';
	$attributesArray = $db->executeS('update '._DB_PREFIX_.'token set status = 0 WHERE id = '.(int)$id_gotoken.' ');
	return $attributesArray;
	
}


private function _saveConfiguration()
{
	Configuration::updateValue('PAYU_LATAM_MERCHANT_ID', (string)Tools::getValue('merchant_id'));
	Configuration::updateValue('PAYU_LATAM_ACCOUNT_ID', (string)Tools::getValue('account_id'));
	Configuration::updateValue('PAYU_LATAM_API_KEY', (string)Tools::getValue('api_key'));
	Configuration::updateValue('PAYU_LATAM_TEST', Tools::getValue('test'));
}




public static function save_token($token,$target,$id,$type1,$nombre_pagador,$iso_card,$cedula,$email)
{
	if (!$context)
	$context = Context::getContext();
	$db = Db::getInstance(_PS_USE_SQL_SLAVE_);

	$attributes = 'INSERT INTO '._DB_PREFIX_.'token 
		(id_customer,id_token,four_number,type_target,status,name_pagador,iso_code_contry,document,email_pagador) values 
		("'.(int)$id.'","'.$token.'","'.(int)$target.'","'.$type1.'",1,"'.$nombre_pagador.'","'.$iso_card.'","'.$cedula.'","'.$email.'")';

	//echo "entro ".$attributes;	
	$attributesArray = $db->executeS($attributes);
	return $attributesArray;


	
}









private function _createStates()
{
	if (!Configuration::get('PAYU_OS_PENDING'))
	{
		$order_state = new OrderState();
		$order_state->name = array();
		foreach (Language::getLanguages() as $language)
			$order_state->name[$language['id_lang']] = 'Pending';

		$order_state->send_email = false;
		$order_state->color = '#FEFF64';
		$order_state->hidden = false;
		$order_state->delivery = false;
		$order_state->logable = false;
		$order_state->invoice = false;

		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/logo.jpg';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			copy($source, $destination);
		}
		Configuration::updateValue('PAYU_OS_PENDING', (int)$order_state->id);
	}

	if (!Configuration::get('PAYU_OS_FAILED'))
	{
		$order_state = new OrderState();
		$order_state->name = array();
		foreach (Language::getLanguages() as $language)
			$order_state->name[$language['id_lang']] = 'Failed Payment';

		$order_state->send_email = false;
		$order_state->color = '#8F0621';
		$order_state->hidden = false;
		$order_state->delivery = false;
		$order_state->logable = false;
		$order_state->invoice = false;

		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/logo.jpg';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			copy($source, $destination);
		}
		Configuration::updateValue('PAYU_OS_FAILED', (int)$order_state->id);
	}

	if (!Configuration::get('PAYU_OS_REJECTED'))
	{
		$order_state = new OrderState();
		$order_state->name = array();
		foreach (Language::getLanguages() as $language)
			$order_state->name[$language['id_lang']] = 'Rejected Payment';

		$order_state->send_email = false;
		$order_state->color = '#8F0621';
		$order_state->hidden = false;
		$order_state->delivery = false;
		$order_state->logable = false;
		$order_state->invoice = false;

		if ($order_state->add())
		{
			$source = dirname(__FILE__).'/img/logo.jpg';
			$destination = dirname(__FILE__).'/../../img/os/'.(int)$order_state->id.'.gif';
			copy($source, $destination);
		}
		Configuration::updateValue('PAYU_OS_REJECTED', (int)$order_state->id);
	}
}

  	
}
?>