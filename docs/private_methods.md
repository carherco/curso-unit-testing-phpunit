# Cómo testear métodos privados

Aunque los métodos privados no forman parte de la API pública de la clase y se puedan testear a través de los métodos públicos, 
en caso de necesitar testear alguno de ellos, se puede recurrir a la técnica de Reflection.

Veámoslo con el siguiente ejemplo:

```php
class PolicyService {
    protected function getRequest( $request ) 
    {
        # datos hotel
        $rq['rate'] = ($request->query->has('rate')) 
            ? (int)$request->get('rate') : '';
        $rq['cn'] = $request->query->has('cn')
            ? (int)$request->get('cn')
            : '';
        $rq['checkin'] = ($request->query->has('checkin'))
            ? $request->get('checkin') : '';
        if ( empty($rq['rate']) || empty($rq['cn']) || empty($rq['checkin']) ) {
            throw new \Exception("Error Processing Request Parameters: Empty obligatory param", 1);
        }
        # procesar fechas.
        $checkin = \DateTime::createFromFormat( 'Y-m-d', $rq['checkin'] );
        if ( $rq['checkin'] != $checkin->format( 'Y-m-d' ) ) {
            throw new \Exception("Error Processing Request Parameters: From format", 2);
        }

        # return rq array.
        return $rq;
    }
}
```

## Uso de Reflection para testeo de un método privado

```php
class PolicyServiceTest extends PHPUnit_Framework_TestCase {

    protected static function getMethod($name) {
      $class = new ReflectionClass('App\PolicyService');
      $method = $class->getMethod($name);
      $method->setAccessible(true);
      return $method;
    }

    function testRateParamIsMandatory() {
        // Setup
        $containerDummy = $this->createStub(App\Deps\ContainerInterface::class);
        $requestMock = $this->createStub(App\Deps\Request::class);
        $queryMock = $this->createStub(App\Deps\ParameterBag::class);

        $hasMap = [
        ['rate', false],
        ['cn', true],
        ['checkin', true]
        ];

        $getMap = [
        ['rate', null, null],
        ['cn', null, 6],
        ['checkin', null, '2020-09-28']
        ];

        $queryMock->method('has')
        ->will($this->returnValueMap($hasMap));

        $requestMock->query = $queryMock;
        $requestMock->method('get')
        ->will($this->returnValueMap($getMap));

        // Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error Processing Request Parameters: Empty obligatory param');
        $this->expectExceptionCode(1);

        // Act
        $myClass = new PolicyService($containerDummy);
        $myMethod = self::getMethod('getRequest');
        $myMethod->invokeArgs($myClass, [$requestMock]);
    }
}
```

