<?php
global $smarty;
require_once('../../config/config.inc.php');
include_once('/../../init.php');
include_once('mymodule.php');

$mymodule = new MyModule();
$customer = Context::getContext()->customer;
$datos_token = MyModule::consultar_token($customer->id);


/*var_dump($datos_token);
die();


*/
$apy = Tools::safeOutput(Configuration::get('PAYU_LATAM_API_KEY'));
$fechaano = date('Y-m-d').'T'.date('h:m:s');
//echo " string ".$fechaano;


if (empty($datos_token)) 
{
	$smarty->assign('tarjetastiene', 0);
}
else
{
	$smarty->assign('tarjetastiene', 1);
	$smarty->assign('tarjetas', $datos_token);
}
$smarty->display( dirname(__FILE__) . '/cons_tarjetas.tpl' );
?>