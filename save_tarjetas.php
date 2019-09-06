<?php


require_once('../../config/config.inc.php');

include_once('/../../init.php');

include_once('mymodule.php');

$token = $_REQUEST['token'];

$target = $_REQUEST['target'];

$id = $_REQUEST['id'];

$type = $_REQUEST['type'];;

$nombre_pagador = $_REQUEST['name_card'];

$iso_card = $_REQUEST['iso'];

$cedula = $_REQUEST['document'];

$email = $_REQUEST['buyerEmail'];





if ($type == 250 or $type == 10 ) 
{

	$type1 = 'visa';

}
elseif ($type== 253 or $type == 22 ) 
{

	$type1 = 'dinersclub';

}
elseif ($type== 252  or $type == 12 ) 
{

	$type1 = 'american-express';

}
elseif ($type== 251  or $type == 28  or $type == 11 ) 
{

	$type1 = 'mastercard';

}



$datos_token1 = MyModule::save_token($token,$target,$id,$type1,$nombre_pagador,$iso_card,$cedula,$email);

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