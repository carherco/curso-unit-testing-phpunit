<?php

namespace App\Misc;

use DateTime;

class SmartHomeController {

    private $timeUtils;
    private $backyardSwitcher;

    private DateTime $lastMotionTime;
    
    public function __construct($timeUtils, $backyardSwitcher) {
        $this->timeUtils = $timeUtils;
        $this->backyardSwitcher = $backyardSwitcher;
    }

	public function actuateLights($time, $motionDetected)
    {		
		// $time = new DateTime();
		
        // Update the time of last motion.
        if ($motionDetected) {
            $this->lastMotionTime = $time;
        }
        
        // If motion was detected in the evening or at night, turn the light on.
        //$timeUtils = new TimeUtils();
        $timeOfDay = $this->timeUtils->getTimeOfDay($time); 
        
        //$backyardSwitcher = new BackyardSwitcher();
        if ($motionDetected && ($timeOfDay == "Evening" || $timeOfDay == "Night")) {
        	$this->backyardSwitcher->turnOn();
        }
        // If no motion is detected for one minute, or if it is morning or day, turn the light off.
        else if ($this->lastMotionTime->modify("+1 minutes") < $time || ($timeOfDay == "Morning" || $timeOfDay == "Afternoon")){
        	$this->backyardSwitcher->turnOff();
        }
    }
	
}