<?php 

namespace App;

use App\Deps\EntityManagerInterface;

class AgencyManager {
  
  protected $em;    

  public function __construct(EntityManagerInterface $em) {
      $this->em = $em;
  }  

  public function addSaldo( $agency, $amount) {
    return 2 * $amount;
  }
  
}
