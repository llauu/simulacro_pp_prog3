<?php
include_once('./models/Pizza.php');

if(isset($_POST['sabor']) && isset($_POST['precio']) && isset($_POST['tipo']) && isset($_POST['cantidad'])) {
    $sabor = $_POST['sabor'];
    $precio = $_POST['precio'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];

    if($tipo == 'piedra' || $tipo == 'molde'){
        $pizza = new Pizza($sabor, $precio, $tipo, $cantidad);
        $arrayPizzas = Pizza::LeerPizzasJson();
    
        $indicePizza = Pizza::ObtenerIndicePizza($pizza->tipo, $pizza->sabor, $arrayPizzas);

        if($indicePizza >= 0) {
            Pizza::ActualizarDatosPizza($arrayPizzas[$indicePizza], $precio, $cantidad);
    
            echo 'Precio y stock actualizados.';
        }
        else {
            array_push($arrayPizzas, $pizza);

            // En caso de que se ingrese la pizza con imagen:
            if(isset($_FILES['imagenPizza']['name'])) {
                $destino = "./ImagenesDePizzas/".$tipo."_".$sabor.".png";
                move_uploaded_file($_FILES["imagenPizza"]["tmp_name"], $destino);
            }
    
            echo 'Pizza ingresada.';
        }
        
        Pizza::GuardarPizzasEnJson($arrayPizzas);
    }
    else {
        echo 'Tipo de la pizza no valido.';
    }
}
else {
    echo json_encode(['error' => 'Faltan parametros']);
}
?>