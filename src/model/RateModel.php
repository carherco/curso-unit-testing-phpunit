<?php
/*
 * This file is part of the AcmeHotelBundle package.
 *
 * (c) SapiensSoftware <http://www.sapienssoftware.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Oliver Martin <om@sapienssoftware.com>
 * @since 2016-06-08
 */

namespace App\Model;

use JMS\Serializer\Annotation\XmlAttribute;
use JMS\Serializer\Annotation\XmlValue;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\SerializedName;

class RateModel
{
    /**
     * indice.
     * 
     * @var string
     *
     * @XmlAttribute
     */
    protected $id;
   
    /**
     * Nombre de la tarifa.
     * 
     * @var string
     *
     * @SerializedName("Name")
     */
    protected $name = '';

    /**
     * Release mínimo para la reserva.
     * 
     * @var integer
     *
     * @XmlAttribute
     */
    protected $release = 0;

    /**
     * Estancia mínima.
     * 
     * @var integer
     * 
     * @XmlAttribute
     */
    protected $minStay = 0;

    /**
     * Condiciones en formato texto
     * 
     * @var string     
     *
     * @SerializedName("Conditions")
     */
    protected $conditions = '';

    /**
     * Refundable o no
     * 
     * @var boolean
     *
     * @XmlAttribute
     */
    protected $refundable = true;

    /**
     * Penalties.
     * 
     * @var array
     *
     * @SerializedName("Penalties")
     * @XmlList(inline = false, entry = "Penalty")
     */
    protected $penalties = array();


	public function setId( $id ) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}

	public function setName( $name ) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}

    public function setRelease( $release ) {
        $this->release = $release;
    }
    public function getRelease() {
        return $this->release;
    }

    public function setMinStay( $minStay ) {
        $this->minStay = $minStay;
    }
    public function getMinStay() {
        return $this->minStay;
    }

    public function setConditions( $conditions ) {
        $this->conditions = $conditions;
    }
    public function getConditions() {
        return $this->conditions;
    }

    public function setRefundable( $refundable ) {
        $this->refundable = $refundable;
    }
    public function getRefundable() {
        return $this->refundable;
    }

    public function setPentalties( $penalties ) {
        $this->penalties = $penalties;
    }
    public function getPentalties() {
        return $this->penalties;
    }
    public function addPenalty( $penalty ){
        $this->penalties[] = $penalty;
    }

}