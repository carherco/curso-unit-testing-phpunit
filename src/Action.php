<?php 

class Action {
  
  protected function addSaldo( $agency, $amount )
  {
    try {

      $saldoAvail = $this->container->get('ws.agency.manager')
          ->addSaldo( $agency, $amount);
      return $saldoAvail;

    } catch( \Exception $e ) {

      $this->container->get('monolog.logger.AppException')
          ->info( $e->getTraceAsString() );
    }
  }

}

