<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\AvailPreferenceService;

/** Para testeo de métodos protected */
class AvailPreferenceServiceChild extends AvailPreferenceService {
  public function __call($method, array $args = array()) {
      if (!method_exists($this, $method))
          throw new BadMethodCallException("method '$method' does not exist");
      return call_user_func_array(array($this, $method), $args);
  }
}

class AvailPreferenceServiceTest extends TestCase {
    public function testIsValidReturnsFalseWhenRuleTariffNotProvided() {
      
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportDummy = $this->createStub(App\Model\Transport::class);
      $transportDummy->method('checkTariff')->will($this->returnValue(true));
      $transportDummy->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => '',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportDummy, $rule);
      $this->assertFalse($isValid);
    }

    public function testIsValidReturnsFalseWhenRuleClassNotProvided() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportDummy = $this->createStub(App\Model\Transport::class);
      $transportDummy->method('checkTariff')->will($this->returnValue(true));
      $transportDummy->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => 'not empty',
        'class' => ''
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportDummy, $rule);
      $this->assertFalse($isValid);
    }

    public function testIsValidReturnsFalseWhenTransportCheckTariffReturnsFalse() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportDummy = $this->createStub(App\Model\Transport::class);
      $transportDummy->method('checkTariff')->will($this->returnValue(false));
      $transportDummy->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => 'not empty',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportDummy, $rule);
      $this->assertFalse($isValid);
    }
}
  