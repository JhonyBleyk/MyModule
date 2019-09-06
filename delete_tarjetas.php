<?php
require_once('../../config/config.inc.php');
include_once('/../../init.php');
include_once('mymodule.php');
$vote = $_REQUEST['vote'];

$datos_token1 = MyModule::delete_token($vote);

/*
var_dump($datos_token1);
die();
*/
$customer = Context::getContext()->customer;
$datos_token = MyModule::consultar_token($customer->id);

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