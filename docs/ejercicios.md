# Ejercicios

## Primeros tests unitarios

Dado el método calcularLetra de la clase DNI:

A) ¿Cómo comprobaríais manual mente que funciona bien?

- ¿Cuántos DNIs distintos comprobaríais antes de subir el código a producción con total seguridad?
- ¿Cuánto tiempo os llevaría comprobar el métdodo?

B) Testear la clase con tests unitarios

- ¿Cuántos tests haríais?
- ¿Se tarda más en programar tests o en testear manualmente?
- ¿De qué tipo de tests os fiaríais más: del manual o del automatizado?
- ¿Alguna vez se os ha "roto algo en otro sitio" al cambiar cosas en un sitio que aparentemente nada tiene que ver?
- ¿Volvéis a testear manualmente de forma concienzuda TODO el código de la aplicación cada vez que hay un cambio en cualquier parte de la aplicación? 

 
## Más tests unitarios

Programar tests unitarios para todos los métodos de la clase Calculations

## Testeo de Exceptions

Programar un test unitario del método setAge() de la clase Customer que compruebe que se lanza la excepción IllegalArgumentException cuando el argumento de entrada es negativo.

## Testeo de cambios de estado internos a la clase

Programar un test unitario del método setAge() que compruebe que al llamar al método con una edad válida, es customer se actualiza con dicha edad.

## Interacción con el entorno

Programar tests unitarios para el método GetTimeOfDay de la clase TimeUtils

## Shopping Cart

Testear de forma unitaria la clase ShoppingCart

Las especificaciones de esta clase son las siguientes:

- Cuando se crea un carrito, el carrito tiene 0 productos.
- Cuando se vacía el carrito, el carrito tiene 0 productos.
- Cuando se añade un producto nuevo, el número de items se debe incrementar en 1.
- Cuando se añade un producto nuevo, el *balance* debe ser la suma del coste de este nuevo producto más el balance anterior.
- Cuando se elimina un producto, se debe decrementar el número de productos en 1.
- Cuando se elimina un producto, el balance debe actualizarse correctamente.
- Si se elimina un producto que NO está en el carrito, se debe lanzar una excepción ProductNotFoundException

## TDD: StringToInt Converter

Escribe una clase con un método estático que convierta un string en un valor numérico

Especificaciones: 

- El método debe aceptar un string y convertirlo en un número
- Los strings válidos contienen únicamente caracteres numéricos, espacios y el signo menos. Cualquier otro caracter en el string lo hace inválido y debe devolver una excepción
- No se admiten números decimales

```
SI: “500”, “-10”, “32767”, “ -3”, "457   ", "   -25   "
NO: “2 3”, “32768”, “A3”, “2.3", "57U56"
```


