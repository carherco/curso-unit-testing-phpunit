# Partial Mocks

En algunas ocasiones, nos encontramos dependencias que no han sido inyectadas y que, por la razón que sea, no podemos inyectarlas ni como argumento del método ni como argumento del constructor.

Véase un ejemplo en la funcion stringDiffDate() de AppExtension:

```php
class AppExtension
{    
    public function stringDiffDate($content)
    {
        $now = new \DateTime();
        $date = $content->diff($now);

        if ($date->days > 1) {
            return $content->format('d/m/Y');
        } else if ($date->days == 1) {
            return 'ayer';
        } else {
            if ($date->h > 1) {
                return 'Hace ' . $date->h . ' horas';
            } else if ($date->h == 1) {
                return 'Hace ' . $date->h . ' hora';
            } else if ($date->m == 1){
                return 'Hace ' . $date->i . ' minuto';
            } else {
                return 'Hace ' . $date->i . ' minutos';
            } 
        }
    }
}
```

Se trata de una extensión de Twig. Refactorizar la función para que la variable $now llegue como argumento llevaría a un uso engorroso de la extensión en los html de Twig.

Pero si lo dejamos como está, nuestros tests tendrán una dependencia con la fecha actual. En el caso de stringDiffDate será imposible testearlo.

Pero veamos otro ejemplo en el se simula un caso de uso en el que la fecha actual está entre dos fechas dadas:

```php
public function testGetLastTicketDateFuture(){
    // Setup
    // ...
    $lastTicketDate = new \DateTime('2020-09-01 12:08:00');
    $faresLastTicketDate = new DateTime('2021-01-02 12:09:00');
    // ...

    // Act
    $output = $myClass->getLastTicketDateFuture($bl);

    // Assert
    $this->assertEquals($expectedOutput, $output);
}
```

En este test se hace un setup en que la fecha actual esté dos fechas dadas: el 2020-09-01 y el 2021-01-02. Con lo que el test funcionará hasta el 2 de enero de 2021. Pasada esa fecha, el test empezará a fallar por si solo.

Los tests unitarios no pueden ser inestables.

Una solución muy recurrida cuando no podemos realizar inyección de dependencias es llevarnos la dependencia a otro método de la propia clase:

```diff
class AppExtension
{    
    public function stringDiffDate($content)
    {
-        $now = new \DateTime();
+        $now = $this->getDateTimeNow();
        $date = $content->diff($now);

        if ($date->days > 1) {
            return $content->format('d/m/Y');
        } else if ($date->days == 1) {
            return 'ayer';
        } else {
            if ($date->h > 1) {
                return 'Hace ' . $date->h . ' horas';
            } else if ($date->h == 1) {
                return 'Hace ' . $date->h . ' hora';
            } else if ($date->m == 1){
                return 'Hace ' . $date->i . ' minuto';
            } else {
                return 'Hace ' . $date->i . ' minutos';
            } 
        }
    }

+    protected function getDateTimeNow() 
+    {
+        return new \DateTime();
+    }
}
```

Con este simple cambio, que además no rompe nada, hemos convertido la dependencia hardcodeada en un INPUT. En este caso conseguimos la información necesaria a través de un método de nuestra propia clase que acaba llamando a un método de otra clase. Eso es un COLLABORATION INPUT (consultar la guía de testing unitario en google docs para ver los tipos de input).

Los collaboration input hay que mockearlos. Hay que mockear getDateTimeNow().

El "problema" viene en este caso que no podemos hacer un mock de la clase AppExtension para mockear el método getDateTimeNow() ya que justamente la clase AppExtension es la que queremos testear si funciona bien.

Aquí es donde entran en juego los denominados "Partial Mocks".

Un partial mock es una clase de la que vamos a mockear solamente una parte. 

## getMockBuilder

Un partial mock se construye con el método getMockBuilder() de PHPUnit.

GetMockBuilder() construye un objeto exactamente igual que el original, con el mismo comportamiento original de todos sus métodos. Se podría imaginar como si fuera una clase que simplemente extiende de la original, sin más. Con lo que se comporta igual que ella. 

```diff
public function testStringDiffDateOneMinuteOfDifference() 
{
  // Setup
-  $myClass = new AppExtension(null);
+  $myClass = $this->getMockBuilder(AppExtension::class)->getMock();

  // Act
  $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:01:08');
  $output = $myClass->stringDiffDate($input);

  // Assert
  $this->markTestIncomplete('Desactivado temporalmente.');
  $this->assertEquals('Hace 1 minuto', $output);
}
```

Visto así no es muy útil. Al llamar a stringDiffDate() en el Act, se estará ejecutando el método original, que llama al $now = $this->getDateTimeNow(); original.

Sin embargo getMockBuilder() nos permite anular el comportamiento original de los métodos que elijamos con setMethods(), obtener el mock con dichos metodos anulados y configurables, y configurarlos con el comportamiento que deseemos.


```diff
public function testStringDiffDateOneMinuteOfDifference() 
{
  // Setup
-  $myClass = $this->getMockBuilder(AppExtension::class)->getMock();
+  $myClass = $this->getMockBuilder(AppExtension::class) 
+    ->disableOriginalConstructor() // Anula el constructor original
+    ->setMethods(['getDateTimeNow']) // Anula el método getDateTimeNow y lo prepara para ser mockeado. 
+    ->getMock();

+  $date = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:02:10');
+  $myClass
+    ->method('getDateTimeNow')
+    ->willReturn($date);

  // Act
  $input = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-25 09:01:08');
  $output = $myClass->stringDiffDate($input);

  // Assert
  $this->markTestIncomplete('Desactivado temporalmente.');
  $this->assertEquals('Hace 1 minuto', $output);
}
```

Ahora cuando stringDiffDate() llame internamente a $this->getDateTimeNow(), el método mockeado le responderá con la fecha mockeada.
