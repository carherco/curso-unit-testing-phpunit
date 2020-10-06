# PhpUnit

Para escribir tests en PHPUnit necesitamos al menos lo siguiente:

- Una **Test Class**
- Un **Test Method**

Ejemplo:

```php
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\AppExtension;

class AppExtensionTest extends TestCase 
{
  public function testSfCalculator() {
    $myClass = new AppExtension(null);

    $input = 100;
    $expectedOutput = 21;

    $output = $myClass->sfCalculator($input);

    $this->assertEquals($expectedOutput, $output);
  }
}
```

## Test Class y Test Methods

**Test Class**: Una clase que extiende de PHPUnit\Framework\TestCase y tiene al menos un test method. El nombre de esta clase debe tener el sufijo Test.

**Test Method**: Cualquier método público que empiece con el prefijo test o que tenga la anotación @Test.

**Hooks**: Cualquiera de estos métodos:

- setUpBeforeClass()
- setUp()
- assertPreConditions()
- onNotSuccessfulTest()
- assertPostConditions()
- tearDown()
- tearDownAfterClass()

## Hooks

- [Hooks](./phpunit_hooks.md)

## Assertions

- [Assertions](./assertions.md)

## Anotaciones

- [Anotaciones](./anotaciones.md)

## Leyenda

```
.   Printed when the test succeeds.
F   Printed when an assertion fails while running the test method.
E   Printed when an error occurs while running the test method.
R   Printed when the test has been marked as risky (see Chapter 6).
S   Printed when the test has been skipped (see Chapter 7).
I   Printed when the test is marked as being incomplete or not yet implemented (see Chapter 7).
W   Printed when the test has warnings
```
