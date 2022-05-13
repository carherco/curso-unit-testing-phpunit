<?php

namespace App\misc;

class MotionDetector implements MotionDetectorInterface
{
    public function detect(): bool
    {
        return (bool)rand(0,1);
    }
}
