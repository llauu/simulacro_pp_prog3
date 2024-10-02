<?php
include_once('./models/Venta.php');

if(isset($_POST['desdeFecha']) && isset($_POST['hastaFecha']) && isset($_POST['usuario']) && isset($_POST['sabor'])) {
    $desdeFecha = $_POST['desdeFecha'];
    $hastaFecha = $_POST['hastaFecha'];
    $usuario = $_POST['usuario'];
    $sabor = $_POST['sabor'];

    if($desdeFecha <= $hastaFecha) {
        $fechaInicio = date($desdeFecha);
        $fechaFin = date($hastaFecha);

        $arrayVentas = Venta::LeerVentasJson();
        
        echo "<b>Cantidad de pizzas vendidas:</b> <br>".Venta::ContarPizzasVendidas($arrayVentas);
        echo "<br><br>";
        echo "<b>Listado de ventas entre dos fechas ordenado por sabor:</b>";
        Venta::MostrarVentas(Venta::FiltrarVentasEntreFechas($arrayVentas, $fechaInicio, $fechaFin));
        echo "<br>";
        echo "<b>Listado de ventas del usuario $usuario:</b>";
        Venta::MostrarVentas(Venta::FiltrarVentasPorUsuario($arrayVentas, $usuario));
        echo "<br>";
        echo "<b>Listado de ventas del sabor $sabor</b>";
        Venta::MostrarVentas(Venta::FiltrarVentasDeSabor($arrayVentas, $sabor));
        echo "<br>";
    }
    else {
        echo 'La fecha de fin no puede ser antes que la de inicio.';
    }
}
else {
    echo json_encode(['error' => 'Faltan parametros']);
}
?>