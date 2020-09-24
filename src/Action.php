<?php 

namespace App;

use App\Deps\ContainerInterface as Container;

class Action {
  protected $container;    

  public function __construct(Container $container) {
      $this->container = $container;
  }  

  public function addSaldo( $agency, $amount )
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

