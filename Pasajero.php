<?php

class Pasajero extends Persona {
    private $pdocumento;
    private $ptelefono;
    private $idviaje;
    private $mensajeoperacion;

    public function __construct(){
        parent::__construct(); // Llama al constructor de la clase padre (Persona)
        $this->pdocumento = "";
        $this->ptelefono = "";
        $this->idviaje = "";
    }

    public function cargar($nrodoc, $pdoc, $ptel, $idv){
        parent::buscar($nrodoc); // Llama al método buscar de la clase padre (Persona) para cargar los datos personales del pasajero
        $this->setPdocumento($pdoc);
        $this->setPtelefono($ptel);
        $this->setIdviaje($idv);
    }

    public function setPdocumento($pdoc){
        $this->pdocumento = $pdoc;
    }

    public function setPtelefono($ptel){
        $this->ptelefono = $ptel;
    }

    public function setIdviaje($idv){
        $this->idviaje = $idv;
    }

    public function setMensajeOperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getPdocumento(){
        return $this->pdocumento;
    }

    public function getPtelefono(){
        return $this->ptelefono;
    }

    public function getIdviaje(){
        return $this->idviaje;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        // Se insertan los datos del pasajero en la tabla pasajero
        $consultaInsertar = "INSERT INTO pasajero (nrodoc, pdocumento, ptelefono, idviaje) VALUES ('" . $this->getNrodoc() . "','" . $this->getPdocumento() . "'," . $this->getPtelefono() . "," . $this->getIdviaje() . ")";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
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
        // Se actualizan los datos del pasajero en la tabla pasajero
        $consultaModifica = "UPDATE pasajero SET pdocumento='" . $this->getPdocumento() . "', ptelefono=" . $this->getPtelefono() . ", idviaje=" . $this->getIdviaje() . " WHERE nrodoc='" . $this->getNrodoc() . "'";
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
        // Se elimina el pasajero de la tabla pasajero
        $consultaEliminar = "DELETE FROM pasajero WHERE nrodoc='" . $this->getNrodoc() . "'";
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
        $resultado .= "\nDocumento de pasajero: " . $this->getPdocumento();
        $resultado .= "\nTeléfono de pasajero: " . $this->getPtelefono();
        $resultado .= "\nID del viaje: " . $this->getIdviaje();
        return $resultado;
    }
    
}