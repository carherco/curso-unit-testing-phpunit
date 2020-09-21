<?php

namespace App\Misc;

use DateTime;

class SmartHomeController {

	private DateTime $lastMotionTime;

	public function actuateLights($motionDetected)
    {		
		    $time = new DateTime();
		
        // Update the time of last motion.
        if ($motionDetected) {
            $this->lastMotionTime = $time;
        }
        
        // If motion was detected in the evening or at night, turn the light on.
        $timeUtils = new TimeUtils();
        $timeOfDay = $timeUtils->getTimeOfDay(); 
        
        $backyardSwitcher = new BackyardSwitcher();
        if ($motionDetected && ($timeOfDay == "Evening" || $timeOfDay == "Night")) {
        	$backyardSwitcher->turnOn();
        }
        // If no motion is detected for one minute, or if it is morning or day, turn the light off.
        else if ($this->lastMotionTime > $time->modify("+1 minutes") || ($timeOfDay == "Morning" || $timeOfDay == "Afternoon")){
        	$backyardSwitcher->turnOff();
        }
    }
	
}