<?php
require __DIR__ . '/../vendor/autoload.php';

use App\TimeUtils;
use PHPUnit\Framework\TestCase;

class TimeUtilsTest extends TestCase {
	
	public function testEntreLas0YLas6DevuelveNight() {
		$this->markTestIncomplete();
		$t = new TimeUtils();
		$output = $t->getTimeOfDay();
		$this->assertEquals("Night", $output);
	}

	public function testEntreLas6YLas12DevuelveMorning() {
		$this->markTestIncomplete();
	}

	public function testEntreLas12YLas18DevuelveAfternoon() {
		$this->markTestIncomplete();
	}

	public function testEntreLas18YLas0DevuelveEvening() {
		$this->markTestIncomplete();
	}
}
