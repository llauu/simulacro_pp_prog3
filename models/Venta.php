<?php
include_once('./db/ManejadorArchivos.php');
include_once('./utils/Utils.php');

class Venta {
    private static $rutaDatos = './db/Ventas.json';
    public $numeroDePedido;
    public $saborPizzaVendida;
    public $tipoPizzaVendida;
    public $cantidadVendida;
    public $fechaDeVenta;
    public $usuario;

    public function __construct($saborPizzaVendida, $tipoPizzaVendida, $cantidadVendida, $usuario) {
        $this->numeroDePedido = Utils::GenerarNumero6Digitos();
        $this->fechaDeVenta = date('Y-m-d');
        $this->saborPizzaVendida = $saborPizzaVendida;
        $this->tipoPizzaVendida = $tipoPizzaVendida;
        $this->cantidadVendida = $cantidadVendida;
        $this->usuario = $usuario;
    }

    public function ModificarVenta($saborPizzaVendida, $tipoPizzaVendida, $cantidadVendida, $usuario) {
        $this->saborPizzaVendida = $saborPizzaVendida;
        $this->tipoPizzaVendida = $tipoPizzaVendida;
        $this->cantidadVendida = $cantidadVendida;
        $this->usuario = $usuario;
    }

    public static function ObtenerIndiceVenta($arrayVentas, $numeroDePedido) {
        $indice = -1;

        if(is_array($arrayVentas)) {
            for ($i = 0; $i < count($arrayVentas); $i++) { 
                if($arrayVentas[$i]->numeroDePedido == $numeroDePedido) {
                    $indice = $i;
                    break;
                }
            }
        }

        return $indice;
    }

    public static function GuardarVentasEnJson($arrayVentas) {
        $manejadorArchivosVentas = new ManejadorArchivos(Venta::$rutaDatos);

        return $manejadorArchivosVentas->GuardarArray($arrayVentas);
    }
    
    public static function LeerVentasJson() {
        $manejadorArchivosVentas = new ManejadorArchivos(Venta::$rutaDatos);

        return $manejadorArchivosVentas->LeerArray();
    }

    private static function CompararPorSabor($v1, $v2) {
        return strcmp($v1->saborPizzaVendida, $v2->saborPizzaVendida);
    } 

    public static function ContarPizzasVendidas($arrayVentas) {
        $pizzasVendidas = 0;

        if(is_array($arrayVentas)) {
            for ($i = 0; $i < count($arrayVentas); $i++) { 
                $pizzasVendidas += $arrayVentas[$i]->cantidadVendida;
            }
        }

        return $pizzasVendidas;
    }

    public static function FiltrarVentasEntreFechas($arrayVentas, $fechaInicio, $fechaFinal) {
        $arrVentasFiltradas = array();

        if(is_array($arrayVentas)) {
            for ($i = 0; $i < count($arrayVentas); $i++) { 
                if($arrayVentas[$i]->fechaDeVenta >= $fechaInicio && $arrayVentas[$i]->fechaDeVenta <= $fechaFinal) {
                    array_push($arrVentasFiltradas, $arrayVentas[$i]);
                }
            }

            // Ordenamos el array por sabor:
            usort($arrVentasFiltradas, [self::class, 'CompararPorSabor']);
            //El self::class representa la clase actual, y el CompararPorSabor el nombre del metodo que compara
        }

        return $arrVentasFiltradas;
    }

    public static function FiltrarVentasPorUsuario($arrayVentas, $usuario) {
        $arrVentasFiltradas = array();

        if(is_array($arrayVentas)) {
            for ($i = 0; $i < count($arrayVentas); $i++) { 
                if($arrayVentas[$i]->usuario == $usuario) {
                    array_push($arrVentasFiltradas, $arrayVentas[$i]);
                }
            }
        }

        return $arrVentasFiltradas;
    }

    public static function FiltrarVentasDeSabor($arrayVentas, $sabor) {
        $arrVentasFiltradas = array();

        if(is_array($arrayVentas)) {
            for ($i = 0; $i < count($arrayVentas); $i++) { 
                if($arrayVentas[$i]->saborPizzaVendida == $sabor) {
                    array_push($arrVentasFiltradas, $arrayVentas[$i]);
                }
            }
        }

        return $arrVentasFiltradas;
    }
    
    public static function MostrarVentas($arrayVentas) {
        if(is_array($arrayVentas)) {
            foreach($arrayVentas as $venta) {
                echo "<br>";
                echo "Numero de pedido: ".$venta->numeroDePedido."<br>";
                echo "Sabor: ".$venta->saborPizzaVendida."<br>";
                echo "Tipo: ".$venta->tipoPizzaVendida."<br>";
                echo "Cantidad: ".$venta->cantidadVendida."<br>";
                echo "Fecha de venta: ".$venta->fechaDeVenta."<br>";
                echo "Usuario: ".$venta->usuario."<br>";
            }
        }
    }
}

?>