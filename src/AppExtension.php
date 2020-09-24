<?php

namespace App;
 
class AppExtension
{    
    /**
     * @var EntityManager
     */
    protected $em;
 
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function durationdhm( $duration ) {    
        $dt1 = explode(':', $duration);
        $rs = '';
        if ($dt1[0] > 0)
            $rs = $dt1[0] . 'd, ';
        if ($dt1[1] > 0) {
            $rs .= $dt1[1] .'h y ';
        }
        $rs .= $dt1[2] . 'min';
        return $rs;
    }

    public function durationdays( $duration ) {    
        $dt1 = explode(':', $duration);
        $rs = '';
        if ( isset( $dt1[0]) )
            $rs = $dt1[0];
        return $rs;
    }
 
    public function stringDate($content, $format = '%e de %B')
    {
        /*$format = '%e de %B'; */
        return strftime($this->_winCrack($format), strtotime($content));
    }
 
    public function stringDiffDate($content)
    {
        // $now = new \DateTime();
        $now = $this->getDateTimeNow();
        $date = $content->diff($now);

        if ($date->days > 1) {
            return $content->format('d/m/Y');
        } else if ($date->days == 1) {
            return 'ayer';
        } else {
            if ($date->h > 1) {
                return 'Hace ' . $date->h . ' horas';
            } else if ($date->h == 1) {
                return 'Hace ' . $date->h . ' hora';
            } else if ($date->m == 1){
                return 'Hace ' . $date->i . ' minuto';
            } else {
                return 'Hace ' . $date->i . ' minutos';
            } 
        }
    }

    protected function getDateTimeNow() 
    {
        return new \DateTime();
    }

    public function onlyCity($content)
    {
        $city = explode(' (', $content);
        return $city[0];
    }

    public function currency($content)
    {
        switch (strtolower($content)) {
            case 'eur':
                $content = '&#8364;';
                break;
            case 'dollar':
                $content = '&#36;';
                break;
            default:
                $content = '&#8364;';
                break;
         } 
        return $content;
    }

    public function monthSelect($content)
    {
        $format = '%B de %Y';
        return strftime($this->_winCrack($format), strtotime("+". $content . "months"));
    }

    public function monthValue($content)
    {
        $format = '%Y-%m';
        return strftime($this->_winCrack($format), strtotime("+". $content . "months"));
    }

    public function paxtype2text($content)
    {
        switch ($content) {
            case 'ADT':
                return 'adulto';
                break;
            case 'CHD':
                return 'niño';
                break;
            case 'INF':
                return 'bebé';
                break;            
            default:
                return $content;
                break;
        }
    }

    public function getPassengersText($adults, $childs = 0, $infants = 0, $separator = '-')
    {
        $msg = '';
        if ($adults > 1) {
            $msg = $adults . ' Adultos';
        } else if ($adults == 1) {
            $msg = $adults . ' Adulto';
        }
        if ($childs > 1) {
            $msg .= ' '.$separator.' '.$childs.' Niños';
        } else if ($childs == 1) {
            $msg .= ' '.$separator.' '.$childs.' Niño';
        }
        if ($infants > 1) {
            $msg .= ' '.$separator.' '.$infants.' Bebés';
        } else if ($infants == 1) {
            $msg .= ' '.$separator.' '.$infants.' Bebe';
        }
        return $msg;
    }

    public function currencyValue( $value ) 
    {
        return number_format(floatval($value), 2, ',', '.');
    }

    public function sfCalculator( $value )
    {
        $rest = round( $value - floor( $value ) , 2);
        $decimals = round( (1 - $rest), 2, PHP_ROUND_HALF_DOWN);
        $sf_b2b = 20 + $decimals; 
        return $sf_b2b;
    }

    protected function _winCrack( $format )
    {
        // Comprobación para Windows para hallar y remplazar el 
        // modificador %e adecuadamente
        // el modificador %e si existen en el formato
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
        }
        return $format;     
    }

    public function getAgent( $user )
    {
        return $this->em->getRepository('AppBundle:Agents')->findOneBy( array('user' => $user) );
    } 
    public function getAdmin( $user )
    {
        return $this->em->getRepository('AppBundle:Admins')->findOneBy( array('user' => $user) );
    }    

    public function getFirstSurname( $passengers )
    {
        $first = array_values($passengers)[0];
        $surname = $first['surname'];
        if (isset($first['surname1'])) {
            $surname .= ' ' . $first['surname1'];
        }
        return strtolower($surname);
    }

}
