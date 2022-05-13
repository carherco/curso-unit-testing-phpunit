<?php

namespace App\misc;
use DateTime;

class TimeUtils {
	
	public function getTimeOfDay(): string
	{
		$time = new DateTime();
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

