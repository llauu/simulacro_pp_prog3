<?php
class ManejadorArchivos {
    private $rutaArchivo;

    public function __construct($rutaArchivo) {
        $this->rutaArchivo = $rutaArchivo;
    }

    public function GuardarArray($array) {
        $guardados = -1;

        if(is_array($array) && count($array) > 0) {
            $archivo = fopen($this->rutaArchivo, 'w');

            $json = json_encode($array);

            $guardados = fwrite($archivo, $json);

            fclose($archivo);   
        }

        return $guardados;
    }

    public function LeerArray() {
        $arrayLeido = array();

        if(file_exists($this->rutaArchivo)) {
            $archivo = fopen($this->rutaArchivo, "r");

            $json = fgets($archivo);
    
            $arrayLeido = json_decode($json);
    
            fclose($archivo);
        }

        return $arrayLeido;
    }
}
?>