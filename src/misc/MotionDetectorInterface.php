<?php

namespace App\misc;

interface MotionDetectorInterface
{
    public function detect(): bool;
}
