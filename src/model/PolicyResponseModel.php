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