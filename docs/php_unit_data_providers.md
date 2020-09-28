# La anotación @dataProvider

La anotación @dataProvider permite parametrizar un test para reutilizarlo múltiples veces con diferentes juegos de pruebas.

La anotación va acompañada del nombre de una función. En el caso del ejemplo, la función es _calcularLetraProvider_. 

PHPUnit ejecutará una vez la función proveedora de datos, que devuelve un array de arrays, que se denomina un array de SETS DE DATOS DE PRUEBA. Luego ejecutará el test, en el caso del ejemplo, _testCalcularLetra_ TANTAS VECES COMO SETS DE PRUEBA haya provisto el data provider.

Se ve mucho mejor con código del ejemplo:

```php
/**
 * @dataProvider calcularLetraProvider
 */
public function testCalcularLetra($dni, $expectedOtuput){
  $myClass = new DNI();
  $output = $myClass->calcularLetra($dni);
  $this->assertEquals($expectedOtuput, $output);  
}

public function calcularLetraProvider()
{
  return [
    [15454423, 'X'],
    [15454424, 'B'],
    [43253425, 'Q'],
    [24391544, 'K'],
    [70878790, 'N'],
    [39696838, 'B'],
    [23,       'T'],
    [10101010, 'P'],
    [10101020, 'H'],
    [12345678, 'Z'],
    [11111116, 'T']
  ];
}
```

En la primera ejecución, se coge el primer SET: [15454423, 'X']. Cada elemento del array de este set se convierte en un argumento de entrada del test. Dichos argumentos se asignan por posición. Así, 15454423 se convertirá en el argumento $dni, y 'X' se convertirá en el argumento $expectedOtuput. Si hubiera más elementos en el array se van asignando por posición.

En la segunda ejecución se coge el segundo set: [15454424, 'B'], en la tercera ejecución el tercer set, y así hasta terminar con todos los sets.

Con esta anotación conseguimos:

- Añadir casos de prueba de forma muy fácil.
- Reducir duplicidades de código.
- Mejorar el mantenimiento de los tests.
- Mantener la complejidad del test al mínimo.
