<?php 

namespace App;

use App\Deps\EntityManagerInterface;

class RateManager {
  protected $em;    

  public function __construct(EntityManagerInterface $em) {
      $this->em = $em;
  }   

  public function find($rq)
  {
    // try {
    $query = "SELECT *
        FROM lod_rates
        WHERE id = :rate
        AND consolidator_id = :consolidador";
    
    $stmt = $this->em->getConnection()->prepare($query);
    $stmt->bindValue( 'rate', $rq['rate'] );
    $stmt->bindValue( 'consolidador', $rq['cn'] );
    $stmt->execute();
    $rs = $stmt->fetchAll();
  
    if (!is_array($rs) || empty($rs)) {
      throw new \Exception("Rate does not found!!", 1014);
    }
    
    return array_shift( $rs );
      
    // } catch (\Exception $e) {
    //   throw $e;            
    // }
  }
  
}
