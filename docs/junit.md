JUnit
=====

Para escribir tests en Junit necesitamos al menos lo siguiente:

- Importar las Assertions necesarias (org.junit.jupiter.api.Assertions.*)
- Importar el decorador @Test (org.junit.jupiter.api.Test)
- Una **Test Class**
- Un **Test Method**

Ejemplo:

```java
import static org.junit.jupiter.api.Assertions.*;
import org.junit.jupiter.api.Test;

class HelloWorldTest {

	@Test
	void testSumPostive() {
		HelloWorld myclass = new HelloWorld();
		int output = myclass.sum(7, 15);
		assertEquals(22, output, "Sum positive values as expected");
	}

}
```

Test Class y Test Methods
-------------------------

**Test Class**: Una clase que contiene al menos un Test Method.

Las *Test Class* no pueden ser abstractas y solamente pueden tener un constructor.

**Test Method**: Cualquier método que tenga una de las siguientes anotaciones: @Test, @RepeatedTest, @ParameterizedTest, @TestFactory, or @TestTemplate.

**Lifecycle Method**: Cualquier método con una de las siguientes anotaciones @BeforeAll, @AfterAll, @BeforeEach, or @AfterEach.

Los *test methods* y los *lifecycle methods* no pueden ser abstractos y no pueden devolver ningún valor con return.

Ni las *Test Class* ni los *Test Method* ni los *Lifecycle Method* pueden ser privados.

Ejemplo básico con los 3 elementos:

```java
import static org.junit.jupiter.api.Assertions.fail;
import static org.junit.jupiter.api.Assumptions.assumeTrue;

import org.junit.jupiter.api.AfterAll;
import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Disabled;
import org.junit.jupiter.api.Test;

class StandardTests {

    @BeforeAll
    static void initAll() {
    		// Se ejecuta una única vez
    }

    @BeforeEach
    void init() {
    		// Se ejecuta antes de CADA test
    }

    @Test
    void succeedingTest() {
    }

    @Test
    void failingTest() {
        fail("a failing test");
    }

    @Test
    @Disabled("for demonstration purposes")
    void skippedTest() {
        // not executed
    }

    @AfterEach
    void tearDown() {
    		// Se ejecuta después de CADA test
    }

    @AfterAll
    static void tearDownAll() {
    		// Se ejecuta una única vez
    }

}
```

Assertions
----------

- [Assertions](./assertions.md)

Anotaciones
-----------

- [Anotaciones](./anotaciones.md)

Diferencias con JUnit v4
------------------------

- El mensaje de test fallido es el primer parámetro en JUnit 4

```java
assertEquals(expected, actual);
assertEquals("failure - strings are not equal", expected, actual);
```

- Aserciones de excepciones

El testeo de excepciones en JUnit 4 se realizaba a través de la anotación @Test

```java
@Test(expected = NullPointerException.class)
public void exceptionTesting() {
    String test = null;
    test.length();
}
```

En JUnit 5 existen assertions para ello:

```java
@Test
void exceptionTesting() {
    assertThrows(NullPointerException.class, () -> {
    		String test = null;
    		test.length();
    });
}
```
