<?php

// CODIGO EN GDB: https://onlinegdb.com/wS9dceJgO

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET['action'])) {
            switch($_GET['action']) {
                // case 'cargarPizza':
                //     include_once('./controller/PizzaCarga.php');
                //     break;

                default:
                    echo json_encode(['error' => 'Accion no valida']);
                    break;
            }
        }
        else {
            echo json_encode(['error' => 'Falta el parametro action']);
        }

        break;

    case 'POST':
        if(isset($_POST['action'])) {
            switch($_POST['action']) {
                case 'cargarPizza':
                    include_once('./controller/PizzaCarga.php');
                    break;
                    
                case 'consultarPizza':
                    include_once('./controller/PizzaConsultar.php');
                    break;

                case 'altaVenta':
                    include_once('./controller/AltaVenta.php');
                    break;

                case 'consultarVentas': 
                    include_once('./controller/ConsultasVentas.php');
                    break;
                    
                default:
                    echo json_encode(['error' => 'Accion no valida']);
                    break;
            }
        }
        else {
            echo json_encode(['error' => 'Falta el parametro action']);
        }

        break;
        
    case 'PUT':
        include_once('./controller/ModificarVenta.php');
        break;

    default:
        echo json_encode(['error' => 'Request no valida']);
        break;
}

?>