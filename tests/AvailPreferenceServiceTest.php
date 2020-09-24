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
    public function testIsValidShouldReturnFalseWhenRuleTariffNotProvided() {
      
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportStub = $this->createStub(App\Model\Transport::class);
      $transportStub->method('checkTariff')->will($this->returnValue(true));
      $transportStub->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => '',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportStub, $rule);
      $this->assertFalse($isValid);
    }

    public function testIsValidShouldReturnFalseWhenRuleClassNotProvided() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportStub = $this->createStub(App\Model\Transport::class);
      $transportStub->method('checkTariff')->will($this->returnValue(true));
      $transportStub->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => 'not empty',
        'class' => ''
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportStub, $rule);
      
      $this->assertFalse($isValid);
    }

    public function testIsValidShouldReturnFalseWhenTransportCheckTariffReturnsFalse() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportStub = $this->createStub(App\Model\Transport::class);
      $transportStub->method('checkTariff')->will($this->returnValue(false));
      $transportStub->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => 'not empty',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportStub, $rule);
      
      $this->assertFalse($isValid);
    }

    public function testIsValidShouldReturnFalseWhenTransportCheckClassReturnsFalse() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportStub = $this->createStub(App\Model\Transport::class);
      $transportStub->method('checkTariff')->will($this->returnValue(true));
      $transportStub->method('checkClass')->will($this->returnValue(false));

      $rule = [
        'tariff' => 'not empty',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportStub, $rule);
      
      $this->assertFalse($isValid);
    }

    public function testIsValidShouldReturnTrueWhenThereArentAnyPrefferredAirlains() {
      $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
      $transportStub = $this->createStub(App\Model\Transport::class);
      $transportStub->method('checkTariff')->will($this->returnValue(true));
      $transportStub->method('checkClass')->will($this->returnValue(true));

      $rule = [
        'tariff' => 'not empty',
        'class' => 'not empty'
      ];

      $sut = new AvailPreferenceServiceChild($containerDummy);
      $isValid = $sut->isValid($transportStub, $rule);
      
      $this->assertTrue($isValid);
    }
}
  