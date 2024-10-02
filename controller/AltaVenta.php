<?php
include_once('./models/Venta.php');
include_once('./models/Pizza.php');

if(isset($_POST['email']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES['imagenVenta']['name'])) {
    $email = $_POST['email'];
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];
    
    $usuario = substr($email, 0, strpos($email, '@'));

    $arrayPizzas = Pizza::LeerPizzasJson();
    $indicePizza = Pizza::ObtenerIndicePizza($tipo, $sabor, $arrayPizzas);

    if($indicePizza >= 0) {
        $pizzaAVender = $arrayPizzas[$indicePizza];

        if($pizzaAVender->cantidad >= $cantidad) {
            $arrayVentas = Venta::LeerVentasJson();

            $pizzaAVender->cantidad -= $cantidad;

            $venta = new Venta($sabor, $tipo, $cantidad, $usuario);
            array_push($arrayVentas, $venta);

            $destino = "./ImagenesDeLaVenta/".$tipo."_".$sabor."_".$usuario."_".date('Y-m-d').".png";
            move_uploaded_file($_FILES["imagenVenta"]["tmp_name"], $destino);
            
            Venta::GuardarVentasEnJson($arrayVentas);
            Pizza::GuardarPizzasEnJson($arrayPizzas);

            echo "Venta realizada al usuario $usuario.";
        }
        else {
            echo 'No se encuentra esa cantidad de pizzas disponibles para la venta.';
        }
    }
    else {
        echo 'La pizza ingresada no se encuentra disponible.';
    }

}
else {
    echo json_encode(['error' => 'Faltan parametros']);
}

?>