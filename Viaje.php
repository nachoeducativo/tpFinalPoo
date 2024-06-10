
<?php

class Viaje {
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $mensajeoperacion;

    public function __construct(){
        $this->idviaje = "";
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->idempresa = "";
        $this->rnumeroempleado = "";
        $this->vimporte = "";
    }

    public function cargar($idv, $dest, $cantmax, $idemp, $numemp, $importe){
        $this->setIdviaje($idv);
        $this->setVdestino($dest);
        $this->setVcantmaxpasajeros($cantmax);
        $this->setIdempresa($idemp);
        $this->setRnumeroempleado($numemp);
        $this->setVimporte($importe);
    }

    public function setIdviaje($idv){
        $this->idviaje = $idv;
    }

    public function setVdestino($dest){
        $this->vdestino = $dest;
    }

    public function setVcantmaxpasajeros($cantmax){
        $this->vcantmaxpasajeros = $cantmax;
    }

    public function setIdempresa($idemp){
        $this->idempresa = $idemp;
    }

    public function setRnumeroempleado($numemp){
        $this->rnumeroempleado = $numemp;
    }

    public function setVimporte($importe){
        $this->vimporte = $importe;
    }

    public function setMensajeOperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getIdviaje(){
        return $this->idviaje;
    }

    public function getVdestino(){
        return $this->vdestino;
    }

    public function getVcantmaxpasajeros(){
        return $this->vcantmaxpasajeros;
    }

    public function getIdempresa(){
        return $this->idempresa;
    }

    public function getRnumeroempleado(){
        return $this->rnumeroempleado;
    }

    public function getVimporte(){
        return $this->vimporte;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function buscar($idv){
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje WHERE idviaje = " . $idv;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row = $base->Registro()) {
                    $this->setIdviaje($row['idviaje']);
                    $this->setVdestino($row['vdestino']);
                    $this->setVcantmaxpasajeros($row['vcantmaxpasajeros']);
                    $this->setIdempresa($row['idempresa']);
                    $this->setRnumeroempleado($row['rnumeroempleado']);
                    $this->setVimporte($row['vimporte']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = ""){
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViajes = "SELECT * FROM viaje ";
        if ($condicion != "") {
            $consultaViajes = $consultaViajes . ' WHERE ' . $condicion;
        }
        $consultaViajes .= " ORDER BY idviaje ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloViaje = array();
                while ($row = $base->Registro()) {
                    $idv = $row['idviaje'];
                    $dest = $row['vdestino'];
                    $cantmax = $row['vcantmaxpasajeros'];
                    $idemp = $row['idempresa'];
                    $numemp = $row['rnumeroempleado'];
                    $importe = $row['vimporte'];
                    $viaje = new Viaje();
                    $viaje->cargar($idv, $dest, $cantmax, $idemp, $numemp, $importe);
                    array_push($arregloViaje, $viaje);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloViaje;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        // Insertar el nuevo viaje en la tabla viaje
        $consultaInsertar = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte) VALUES ('" . $this->getVdestino() . "'," . $this->getVcantmaxpasajeros() . "," . $this->getIdempresa() . "," . $this->getRnumeroempleado() . "," . $this->getVimporte() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $this->setIdviaje($base->devuelveIDInsercion($consultaInsertar));
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }
    
    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        // Modificar los datos del viaje en la tabla viaje
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getVdestino() . "', vcantmaxpasajeros=" . $this->getVcantmaxpasajeros() . ", idempresa=" . $this->getIdempresa() . ", rnumeroempleado=" . $this->getRnumeroempleado() . ", vimporte=" . $this->getVimporte() . " WHERE idviaje=" . $this->getIdviaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }
    
    public function eliminar(){
        $base = new BaseDatos();
        $resp = false;
        // Eliminar el viaje de la tabla viaje
        $consultaEliminar = "DELETE FROM viaje WHERE idviaje=" . $this->getIdviaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEliminar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }
    public function __toString(){
        $cadena = "ID Viaje: " . $this->getIdviaje() . "\n";
        $cadena .= "Destino: " . $this->getVdestino() . "\n";
        $cadena .= "Cantidad Máxima de Pasajeros: " . $this->getVcantmaxpasajeros() . "\n";
        $cadena .= "ID Empresa: " . $this->getIdempresa() . "\n";
        $cadena .= "Número de Empleado Responsable: " . $this->getRnumeroempleado() . "\n";
        $cadena .= "Importe: " . $this->getVimporte() . "\n";
        return $cadena;
    }
    


}    