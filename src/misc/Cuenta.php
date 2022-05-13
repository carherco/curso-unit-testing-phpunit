<?php

namespace App\misc;

class Cuenta {
    
    private $saldo;
    
    public function __construct() {
        $this->saldo = 0;
    }
    
    public function getSaldo() {
        return $this->saldo;
    }
    
    public function ingreso($cantidad){
        $esValida = $this->validarCantidadIngresada($cantidad);
        if($esValida){ 
            $this->saldo += $cantidad;
        }
    }
    
    private function validarCantidadIngresada($cantidad){
        if(round($cantidad, 2)!=$cantidad) {
            return false;
        }
        
        if($cantidad < 0) {
            return false;
        }
        
        if($cantidad > 6000.00){
            return false;
        } 
        
        return true;
    }
    
    public function retirada($cantidad){
        $esValida = $this->validarCantidadRetirada($cantidad);
        if($esValida){ 
            $this->saldo -= $cantidad;
        }
    }
    
    private function validarCantidadRetirada($cantidad){
        if(round($cantidad, 2)!=$cantidad) {
            return false;
        }
        
        if($cantidad < 0) {
            return false;
        }
        
        if($cantidad > $this->saldo) {
            return false;
        }
        
        if($cantidad > 6000.00){
            return false;
        } 
        
        return true;
    }
    
    public function transferencia($cuenta_destino, $cantidad){
        $esValida = $this->validarCantidadTransferencia($cantidad);
        if($esValida){ 
            $this->retirada($cantidad);
            $cuenta_destino->ingreso($cantidad);
        }
   
    }
    
    private function validarCantidadTransferencia($cantidad){        
        if($cantidad < 0) {
            return false;
        }
        
        if($cantidad > $this->saldo) {
            return false;
        }
        
        if($cantidad > 3000){
            return false;
        } 
        
        return true;
    }
    
}
