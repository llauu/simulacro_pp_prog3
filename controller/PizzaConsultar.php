<?php
include_once('./models/Pizza.php');

if(isset($_POST['sabor']) && isset($_POST['tipo'])) {
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];

    $arrayPizzas = Pizza::LeerPizzasJson();
    
    if(Pizza::ValidarSaborExistente($sabor, $arrayPizzas)) {
        if(Pizza::ValidarTipoExistente($tipo, $sabor, $arrayPizzas)) {
            echo 'Si hay.';
        }
        else {
            echo 'El tipo ingresado no existe.';
        }
    } 
    else {
        echo 'El sabor ingresado no existe.';
    }
}
else {
    echo json_encode(['error' => 'Faltan parametros']);
}
?>