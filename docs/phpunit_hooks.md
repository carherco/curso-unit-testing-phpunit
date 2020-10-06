# Hooks

Para facilitar el trabajo de setup en nuestros tests y sobre todo evitar la duplicación de código, PHPUnit pone a nuestra disposición varios _template methods_ o _hooks_:

1. **setup**: Esta función se ejecuta justo ANTES DE CADA TEST.

2. **teardown**: Esta función se ejecuta justo DESPUÉS DE CADA TEST.

3. **assertPreCoditions**: Esta función se ejecuta justo antes de cada test pero después del setup.

4. **assertPostConditions**: Esta función se ejecuta inmediatamente después de cada test pero antes del teardown.

5. **setupBeforeClass**: Esta función se ejecuta UNA ÚNICA VEZ antes de cualquier test incluso antes del setup del primer test. Es la única función ESTÁTICA (static function) de la clase.

6. **teardownAfterClass**: Esta función se ejecuta UNA ÚNICA VEZ después de que se hayan ejecutado todos los tests y de que se haya ejecutado el último teardown.

7. **onNotSuccessfulTest**: Esta función se ejecuta cada vez que un test falle.

Cuando usemos PHPUnit para tests puramente unitarios, raramente utilizaremos un método distinto del setup().

Como nota adicional, remarcar que PHPUnit crea una instancia nueva de la clase de test por cada uno de los tests que tenga que hacer.

Lanzando el siguiente test, se puede ver por la consola el orden de ejecución de los tests y de los hooks.

```php
<?php
use PHPUnit\Framework\TestCase;

class TemplateMethodsTest extends TestCase
{
    public function __construct()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function setUp(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function assertPreConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function testOne()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(true);
    }

    public function testTwo()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(false);
    }

    public function testThree()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(true);
    }

    protected function assertPostConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function tearDown(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public static function tearDownAfterClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function onNotSuccessfulTest(Throwable $t): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        throw $t;
    }
}
```