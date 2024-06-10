<?php

class Responsable extends Persona {
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $mensajeoperacion;

    public function __construct(){
        parent::__construct(); // Llama al constructor de la clase padre (Persona)
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
    }

    public function cargar($nrodoc, $rnumemp, $rnumlic){
        parent::buscar($nrodoc); // Llama al método buscar de la clase padre (Persona) para cargar los datos personales del responsable
        $this->setRnumeroempleado($rnumemp);
        $this->setRnumerolicencia($rnumlic);
    }

    public function setRnumeroempleado($rnumemp){
        $this->rnumeroempleado = $rnumemp;
    }

    public function setRnumerolicencia($rnumlic){
        $this->rnumerolicencia = $rnumlic;
    }

    public function setMensajeOperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getRnumeroempleado(){
        return $this->rnumeroempleado;
    }

    public function getRnumerolicencia(){
        return $this->rnumerolicencia;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function buscar($numemp){
        $base = new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable WHERE rnumeroempleado = " . $numemp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaResponsable)) {
                if ($row = $base->Registro()) {
                    $this->setRnumeroempleado($row['rnumeroempleado']);
                    $this->setNrodoc($row['nrodoc']);
                    $this->setRnumerolicencia($row['rnumerolicencia']);
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

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        // Se insertan los datos del responsable en la tabla responsable
        $consultaInsertar = "INSERT INTO responsable (nrodoc, rnumerolicencia) VALUES ('" . $this->getNrodoc() . "','" . $this->getRnumerolicencia() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $this->setRnumeroempleado($base->devuelveIDInsercion($consultaInsertar));
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
        // Se actualizan los datos del responsable en la tabla responsable
        $consultaModifica = "UPDATE responsable SET nrodoc='" . $this->getNrodoc() . "', rnumerolicencia='" . $this->getRnumerolicencia() . "' WHERE rnumeroempleado=" . $this->getRnumeroempleado();
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
        // Se elimina el responsable de la tabla responsable
        $consultaEliminar = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getRnumeroempleado();
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
        $resultado = parent::__toString(); // Obtener la representación de la clase padre (Persona)
        $resultado .= "\nNúmero de empleado: " . $this->getRnumeroempleado();
        $resultado .= "\nNúmero de licencia: " . $this->getRnumerolicencia();
        return $resultado;
    }
    
}
