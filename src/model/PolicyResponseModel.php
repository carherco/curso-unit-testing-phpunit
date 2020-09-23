<?php

namespace App\Model;

use JMS\Serializer\Annotation\XmlRoot;
use JMS\Serializer\Annotation\SerializedName;

/** @XmlRoot("RatePolicy") */
class PolicyResponseModel
{
    /**
     * @SerializedName("Rate")
     */
	private $rate = null;

	public function setRate( $rate ) {
		$this->rate = $rate;
	}
	public function getRate() {
		return $this->rate;
	}
}