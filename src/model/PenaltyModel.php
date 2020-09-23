<?php

namespace App\Model;

use JMS\Serializer\Annotation\XmlAttribute;

class PenaltyModel
{
	/**
	 * Fecha desde
	 * 
	 * @var string
	 *
	 * @XmlAttribute
	 */
	protected $dateFrom = '';

	/**
	 * Fecha hasta
	 * 
	 * @var string
	 *
	 * @XmlAttribute
	 */
	protected $dateTo = '';

	/**
	 * Cantidad de penalización
	 * 
	 * @var integer
	 *
	 * @XmlAttribute
	 */
	protected $amount = 0;

	/**
	 * Tipo de penalización
	 * 
	 * @var string
	 *
	 * @XmlAttribute
	 */
	protected $type = 'percent';

	public function setDateFrom( $dateFrom ) {
		$this->dateFrom = $dateFrom;
	}
	public function getDateFrom() {
		return $this->dateFrom;
	}

	public function setDateTo( $dateTo ) {
		$this->dateTo = $dateTo;
	}
	public function getDateTo() {
		return $this->dateTo;
	}

	public function setAmount( $amount ) {
		$this->amount = $amount;
	}
	public function getAmount() {
		return $this->amount;
	}

	public function setType( $type ) {
		$this->type = $type;
	}
	public function getType() {
		return $this->type;
	}
}