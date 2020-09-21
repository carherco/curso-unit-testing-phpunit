Conceptos
=========

Tests de caja blanca
--------------------

Son aquellos tests que programamos mirando el código fuente. Con este tipo de tests nos ayudamos del propio código fuente para asegurarnos que estamos cubriendo todos los caminos posibles que puede seguir el código: ramificaciones por sentencias if-else, límites/fronteras en los bucles, cóndiciones lógicas...

Tests de caja negra
-------------------

Son aquellos tests que programamos sin mirar el código fuente del elemento que vamos a testear. Esto puede ser o bien porque no tenemos acceso a dicho código o bien porque no queremos mirarlo.

Para programar este tipo de tests nos tienen que decir cuál es el comportamiento esperado del elemento que hay que testear.

Funciones puras
---------------

En programación, se denomina función pura a aquella función que tiene las siguientes 2 propiedades: 

- Para los mismos parámetros de entrada, la función siempre devolverá el mismo resultado.

- No tiene efectos colaterales (side effects).

Una función no será pura si:

- utiliza variables estáticas
- utiliza variables externas
- utiliza información que no está en los argumentos de entrada (la hora del sistema, datos de una base de datos, datos en un fichero ...)
- interactúa con sistemas externos (escribe en ficheros, escribe en base de datos, envía correos, escribe en sistema de log ...)
- muta los argumentos de entrada o cualquier otra variable
- utilizar algún tipo de aleatoriedad

Query function
--------------

Son funciones cuyo objetivo es conseguir/calcular/procesar información y devolvérnosla en el return.

Ejemplo: 

```java
User u = UserService.getUser();
```

Command function
----------------

Son funciones cuyo objetivo es ejecutar alguna instrucción que altere el entorno (escribir/modificar en base de datos, enviar un correo, escribir en un fichero, cambiar el estado de un objeto en memoria...

Ejemplo: 

```java
login(username, password);
```

Se deberían evitar sin embargo ejemplos como este:

Ejemplo: 

```java
User u = UserService.login(username, password);
```

Tests de estado
---------------

Testear el estado implica comprobar que una función nos devuelve el resultado esperado según unas condiciones de partida o argumentos de entrada.

Este tipo de testeo se puede realizar tanto con la técnica de caja negra como con la técnica de caja blanca.

Tests de interacción
--------------------

En este tipo de tests se pretende verificar que el elemento bajo test invoca (o no invoca) algún método concreto con unos argumentos concretos.


