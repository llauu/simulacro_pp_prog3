<?php
include_once('./models/Venta.php');

parse_str(file_get_contents("php://input"), $putData);

if(isset($putData['numeroDePedido']) && isset($putData['email']) && isset($putData['sabor']) && isset($putData['tipo']) && isset($putData['cantidad'])) {
    $numeroDePedido = $putData['numeroDePedido'];
    $email = $putData['email'];
    $sabor = $putData['sabor'];
    $tipo = $putData['tipo'];
    $cantidad = $putData['cantidad'];

    $arrayVentas = Venta::LeerVentasJson();
    $indice = Venta::ObtenerIndiceVenta($arrayVentas, $numeroDePedido);

    $usuario = substr($email, 0, strpos($email, '@'));

    if($indice >= 0) {
        $arrayVentas[$indice]->ModificarVenta($sabor, $tipo, $cantidad, $usuario);
        
        Venta::GuardarVentasEnJson($arrayVentas);
        echo 'Venta modificada con exito.';
    }
    else {
        echo 'El numero de pedido ingresado no existe.';
    }
}
else {
    echo json_encode(['error' => 'Faltan parametros']);
}
?>