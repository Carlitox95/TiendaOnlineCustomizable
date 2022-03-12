<?php
//Credenciales de Mercado Pago
$publicKey="TEST-0ff443a1-c8c8-42d0-b5ac-521fc9fed8a7";
$accessToken="TEST-2913430827228064-030200-e97bc2e6bbed40438dae7af5f6d0b693-59366921";
// SDK de Mercado Pago
require '/vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken($accessToken);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

</body>
</html>