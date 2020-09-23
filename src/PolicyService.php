<?php

// namespace Acme\HotelBundle\Services;

// use Symfony\Component\DependencyInjection\ContainerInterface as Container;

// use Acme\HotelBundle\Services\ElasticServiceAbstract;
// use Acme\HotelBundle\Util\ElasticUtil;

// use Acme\HotelBundle\Model\Policy\PenaltyModel;
// use Acme\HotelBundle\Model\Policy\RateModel;
// use Acme\HotelBundle\Model\Policy\PolicyResponseModel;

namespace App;
use App\Deps\ContainerInterface as Container;
use App\Model\PenaltyModel;
use App\Model\RateModel;
use App\Model\PolicyResponseModel;

// Testeo de métodos protected a través de los públicos
// Nuestra "Unit" no es la función, es la clase 

/**
 * Class ElasticService
 *
 * http://acmeapi2.localhost.com/app_dev.php/api/v1/hotel/policy.xml?rate=446&cn=4&us=vistatravel
 * 
 * This is the class that communicates with elasticSearch
 */
class PolicyService
{
    protected $container;    

    public function __construct(Container $container) {
        $this->container = $container;
    }   

    /**
     * Realiza la petición de reserva.
     * 
     * @param  Request $request parámetros recibidos
     * @return BookingResponse 
     */
    public function policy( $request )
    {
        # tratar la petición
        $rq = $this->getRequest( $request );
        # sacar la info de la bbdd.
        $rate = $this->container->get('acme.hotel.rate.manager')
                                    ->find( $rq );
        # crear el objeto para el render xml.
        $rateObj = $this->renderObject( $rate, $rq );
        # crear la respuesta.
        $rs = new PolicyResponseModel();
        $rs->setRate( $rateObj );
        # devolver la respuesta.
        return $rs;
    }

    /**
     * Controla los parámetros de entrada
     * @param  Request $request petición recibida
     * @return array array con los parámetros tratados.
     *
     * @throws Exception Si algún parámetro no es correcto
     */
    protected function getRequest( $request ) 
    {
        # datos hotel
        $rq['rate'] = ($request->query->has('rate')) 
            ? (int)$request->get('rate') : '';
        $rq['cn'] = $request->query->has('cn')
            ? (int)$request->get('cn')
            : '';
        $rq['checkin'] = ($request->query->has('checkin'))
            ? $request->get('checkin') : '';

        if ( empty($rq['rate']) || empty($rq['cn']) || empty($rq['checkin']) ) {
            throw new \Exception("Error Processing Request Parameters: Empty obligatory param", 1);
        }
        
        # procesar fechas.
        $checkin = \DateTime::createFromFormat( 'Y-m-d', $rq['checkin'] );
        if ( $rq['checkin'] != $checkin->format( 'Y-m-d' ) ) {
            throw new \Exception("Error Processing Request Parameters: From format", 2);
        }

        # return rq array.
        return $rq;
    }

    /**
     * Crea el objeto del rate para pintar el 
     * xml en el formato deseado
     * @param  array $rate Array con los datos de la rate sacado
     *        de la base de datos.
     * @return \Model\Policy\Rate
     */
    protected function renderObject( $rate, $rq )
    {
        $rateObj = new RateModel();
        $rateObj->setId( $rate['id'] );
        $rateObj->setName( $rate['name'] );
        $rateObj->setRelease( $rate['release_days'] );
        $rateObj->setMinStay( $rate['min_stay'] );     
        $rateObj->setConditions( $rate['conditions'] );
        $rateObj->setRefundable( ((int)$rate['reembolsable'] == 1) );
    
        # crear los penalties. 
        if ((int)$rate['reembolsable'] != 1 ) {
            $rateObj->addPenalty( $this->createPenaltyNoRefund($rq['checkin']) );
        } else {
            $rateObj->addPenalty( 
                $this->createPenaltyDaysBefore( $rq['checkin'], 
                            $rate['penalizacion_reembolso'],
                            $rate['limite_reembolso'] )
                )
            ;
            $rateObj->addPenalty( 
                $this->createPenaltyNoShow( $rq['checkin'], $rate['penalizacion'] )
                )
            ;
        }
        return $rateObj;
    }

    protected function createPenaltyNoRefund( $checkin )
    {
        return $this->createPenalty( date('Y-m-d'), $checkin, 100 );     
    }

    protected function createPenaltyNoShow( $checkin, $amount )
    {
        return $this->createPenalty( $checkin, null, $amount );
    }

    protected function createPenaltyDaysBefore( $checkin, $amount, $daysBefore )
    {
        $date = date('Y-m-d', strtotime("-".$daysBefore."days", strtotime($checkin)));
        return $this->createPenalty( $date, $checkin, $amount );   
    }

    protected function createPenalty( $checkin, $dateTo, $amount, $type = 'percent')
    {
        $penalty = new PenaltyModel();
        $penalty->setDateFrom( $checkin );
        $penalty->setDateTo( $dateTo );
        $penalty->setAmount( $amount );
        $penalty->setType( $type );
        return $penalty;                
    }
}
