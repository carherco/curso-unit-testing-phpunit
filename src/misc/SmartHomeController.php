<?php

namespace App\misc;

use DateTime;

class SmartHomeController {

    private DateTime $lastMotionTime;

    private MotionDetectorInterface $motionDetector;
    private SwitcherInterface $backyardSwitcher;

    public function __construct(MotionDetectorInterface $motionDetector, SwitcherInterface $backyardSwitcher)
    {
        $this->motionDetector = $motionDetector;
        $this->backyardSwitcher = $backyardSwitcher;
    }

	public function actuateLights(DateTime $time)
    {
        $motionDetected = $this->motionDetector->detect();
        // Update the time of last motion.
        if ($motionDetected) {
            $this->lastMotionTime = $time;
        }

        $timeUtils = new TimeUtils();
        $timeOfDay = $timeUtils->getTimeOfDay($time);

        // If motion was detected in the evening or at night, turn the light on.
        if ($motionDetected && ($timeOfDay == "Evening" || $timeOfDay == "Night")) {
        	$this->backyardSwitcher->turnOn();
        }
        // If no motion is detected for one minute, or if it is morning or day, turn the light off.
        else if ( (isset($this->lastMotionTime) && $this->lastMotionTime->modify("+1 minutes") < $time) || ($timeOfDay == "Morning" || $timeOfDay == "Afternoon")){
        	$this->backyardSwitcher->turnOff();
        }
    }
	
}
