<?php
class Empresa {
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;

    public function __construct(){
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
    }

    public function cargar($idemp, $nom, $dir){
        $this->setIdempresa($idemp);
        $this->setEnombre($nom);
        $this->setEdireccion($dir);
    }

    public function setIdempresa($idemp){
        $this->idempresa = $idemp;
    }

    public function setEnombre($nom){
        $this->enombre = $nom;
    }

    public function setEdireccion($dir){
        $this->edireccion = $dir;
    }

    public function setMensajeOperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getIdempresa(){
        return $this->idempresa;
    }

    public function getEnombre(){
        return $this->enombre;
    }

    public function getEdireccion(){
        return $this->edireccion;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function buscar($idemp){
        $base = new BaseDatos();
        $consultaEmpresa = "SELECT * FROM empresa WHERE idempresa = " . $idemp;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresa)) {
                if ($row = $base->Registro()) {
                    $this->setIdempresa($row['idempresa']);
                    $this->setEnombre($row['enombre']);
                    $this->setEdireccion($row['edireccion']);
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
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresas = "SELECT * FROM empresa ";
        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . ' WHERE ' . $condicion;
        }
        $consultaEmpresas .= " ORDER BY idempresa ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresas)) {
                $arregloEmpresa = array();
                while ($row = $base->Registro()) {
                    $idemp = $row['idempresa'];
                    $nom = $row['enombre'];
                    $dir = $row['edireccion'];
                    $empresa = new Empresa();
                    $empresa->cargar($idemp, $nom, $dir);
                    array_push($arregloEmpresa, $empresa);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloEmpresa;
    }

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa (enombre, edireccion) VALUES ('" . $this->getEnombre() . "','" . $this->getEdireccion() . "')";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $this->setIdempresa($base->devuelveIDInsercion($consultaInsertar));
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
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->getEnombre() . "', edireccion='" . $this->getEdireccion() . "' WHERE idempresa=" . $this->getIdempresa();
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
        if ($base->Iniciar()) {
            $consultaBorrar = "DELETE FROM empresa WHERE idempresa=" . $this->getIdempresa();
            if ($base->Ejecutar($consultaBorrar)) {
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
        return "ID Empresa: " . $this->getIdempresa() . "\nNombre: " . $this->getEnombre() . "\nDirección: " . $this->getEdireccion() . "\n";
    }
}
