<?php

namespace App\Misc;
use DateTime;
//use DateTimeInterface;

class TimeUtils {
	
	public function getTimeOfDay($time)
	{
			// $time = new DateTime();
			$hour = $time->format('H');

	    if ($hour >= 0 && $hour < 6)
	    {
	        return "Night";
	    }
	    if ($hour < 12)
	    {
	        return "Morning";
	    }
	    if ($hour < 18)
	    {
	        return "Afternoon";
	    }
	    return "Evening";
	}
}

