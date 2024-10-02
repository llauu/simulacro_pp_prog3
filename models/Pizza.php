<?php
include_once('./db/ManejadorArchivos.php');
include_once('./utils/Utils.php');

class Pizza {
    private static $rutaDatos = './db/Pizza.json';
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;

    public function __construct($sabor, $precio, $tipo, $cantidad = 0) {
        $this->id = Utils::GenerarNumero6Digitos();
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public static function GuardarPizzasEnJson($arrayPizzas) {
        $manejadorArchivosPizza = new ManejadorArchivos(Pizza::$rutaDatos);

        return $manejadorArchivosPizza->GuardarArray($arrayPizzas);
    }
    
    public static function LeerPizzasJson() {
        $manejadorArchivosPizza = new ManejadorArchivos(Pizza::$rutaDatos);

        return $manejadorArchivosPizza->LeerArray();
    }

    static public function ObtenerIndicePizza($tipo, $sabor, $arrayPizzas) {
        $indicePizza = -1;

        if(is_array($arrayPizzas)) {
            for ($i = 0; $i < count($arrayPizzas); $i++) { 
                if($arrayPizzas[$i]->tipo == $tipo && $arrayPizzas[$i]->sabor == $sabor) {
                    $indicePizza = $i;
                    break;
                }
            }
        }

        return $indicePizza;
    }
    
    static public function ValidarSaborExistente($sabor, $arrayPizzas) {
        $retorno = false;

        if(is_array($arrayPizzas)) {
            for ($i = 0; $i < count($arrayPizzas); $i++) { 
                if($arrayPizzas[$i]->sabor == $sabor) {
                    $retorno = true;
                    break;
                }
            }
        }

        return $retorno;
    }

    static public function ValidarTipoExistente($tipo, $sabor, $arrayPizzas) {
        $retorno = false;

        if(is_array($arrayPizzas)) {
            for ($i = 0; $i < count($arrayPizzas); $i++) { 
                if($arrayPizzas[$i]->tipo == $tipo && $arrayPizzas[$i]->sabor == $sabor) {
                    $retorno = true;
                    break;
                }
            }
        }

        return $retorno;
    }

    public static function ActualizarDatosPizza($pizza, $precio, $cantidad) {
        $pizzaActualizada = false;

        if($precio >= 0 && $cantidad >= 0) {
            $pizza->precio = $precio;
            $pizza->cantidad += $cantidad;

            $pizzaActualizada = true;
        }

        return $pizzaActualizada;
    }
}


?>