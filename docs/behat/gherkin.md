# Gherkin Language

Las Features se definen en archivos *.feature y con sintaxis Gherkin.

## Gherkin Syntax

```gherkin
Feature: Some terse yet descriptive text of what is desired
  In order to realize a named business value
  As an explicit system actor
  I want to gain some beneficial outcome which furthers the goal

  Additional text...

  Scenario: Some determinable business situation
    Given some precondition
    And some other precondition
    When some action by the actor
    And some other action
    And yet another action
    Then some testable outcome is achieved
    And something else we can check happens too

  Scenario: A different situation
    ...


```

Por ejemplo:

```gherkin
Feature: Descuentos por residencia en las Islas Canarias
  Cuando una agencia hace reservas
  Si todos los pasajeros de la reserva son residentes en las islas
  Tienen un descuento si el origen o el destino es un aeropuerto de las islas

  Scenario: Vuelo con origen Gran Canaria (LPA) y pasajero canario
    Given Hay un vuelo disponible de LPA a MAD con ID UAX94589 con precio 50,47€
      And Estoy logueado como la agencia XXXXX. 
    When Hago un reserva del vuelo UAX94589
     And Relleno los datos de cliente con
     ***
     Calle
     Ciudad
     Código Postal
     País
     ***
     And Relleno los datos de XXXX con AAAAA
     And Relleno los datos de YYYY con BBBBB
     And Relleno los datos de ZZZZ con CCCCC
     And Completo la reserva
    Then El descuento debería ser de 10,94€
     And El precio final debería ser de 39,53€

  Scenario: Vuelo con origen Gran Canaria (LPA) y pasajero no canario
    Given Hay un vuelo disponible de LPA a MAD con ID UAX94589 con precio 50,47€
      And Estoy logueado como la agencia XXXXX. 
    When Hago un reserva del vuelo UAX94589
     And Relleno los datos de cliente con 
     ***
     Calle
     Ciudad
     Código Postal
     País
     ***
     And Relleno los datos de XXXX con AAAAA
     And Relleno los datos de YYYY con BBBBB
     And Relleno los datos de ZZZZ con CCCCC
     And Completo la reserva
    Then El descuento debería ser de 0€
     And El precio final debería ser de 50,47€

  Scenario: Vuelo con destino Gran Canaria (LPA) y pasajero canario
    ...
```

Feature: La funcionalidad
Scenario: Cada caso de uso
Step: Given/When/Then/And...

- Given => Precondiciones (ARRANGE/SETUP)
- When => Las acciones del usuario/testeador (ACT)
- Then => Las comprobaciones (ASSERTS)

## Givens

https://docs.behat.org/en/latest/user_guide/writing_scenarios.html#givens

## Whens

https://docs.behat.org/en/latest/user_guide/writing_scenarios.html#whens

## Thens

The purpose of Then steps is to observe outcomes. The observations should be related to the business value/benefit in your feature description. The observations should inspect the output of the system (a report, user interface, message, command output) and not something deeply buried inside it (that has no business value and is instead part of the implementation).

While it might be tempting to implement Then steps to just look in the database – resist the temptation. You should only verify output that is observable by the user (or external system). Database data itself is only visible internally to your application, but is then finally exposed by the output of your system in a web browser, on the command-line or an email message.

https://docs.behat.org/en/latest/user_guide/writing_scenarios.html#whens

## And y But

https://docs.behat.org/en/latest/user_guide/writing_scenarios.html#and-but

## Backgrounds

Backgrounds allows you to add some context to all scenarios in a single feature. 

The background is run before each of your scenarios, but after your BeforeScenario Hooks.

```gherkin
Feature: Descuentos por residencia en las Islas Canarias
  Cuando una agencia hace reservas
  Si todos los pasajeros de la reserva son residentes en las islas
  Tienen un descuento si el origen o el destino es un aeropuerto de las islas

  Background:
    Given Hay un vuelo disponible de LPA a MAD con ID UAX94589 con precio 50,47€
      And Estoy logueado como la agencia XXXXX.

  Scenario: Vuelo con origen Gran Canaria (LPA) y pasajero canario
    When Hago un reserva del vuelo UAX94589
     And Relleno los datos de cliente con
     ***
     Calle
     Ciudad
     Código Postal
     País
     ***
     And Relleno los datos de XXXX con AAAAA
     And Relleno los datos de YYYY con BBBBB
     And Relleno los datos de ZZZZ con CCCCC
     And Completo la reserva
    Then El descuento debería ser de 10,94€
     And El precio final debería ser de 39,53€

  Scenario: Vuelo con origen Gran Canaria (LPA) y pasajero no canario
    When Hago un reserva del vuelo UAX94589
     And Relleno los datos de cliente con 
     ***
     Calle
     Ciudad
     Código Postal
     País
     ***
     And Relleno los datos de XXXX con AAAAA
     And Relleno los datos de YYYY con BBBBB
     And Relleno los datos de ZZZZ con CCCCC
     And Completo la reserva
    Then El descuento debería ser de 0€
     And El precio final debería ser de 50,47€

  Scenario: Vuelo con destino Gran Canaria (LPA) y pasajero canario
    ...
```

## Scenario Outlines

Son como unas plantillas de Scenarios parametrizables

```gherkin
Scenario: Eat 5 out of 12
  Given there are 12 cucumbers
  When I eat 5 cucumbers
  Then I should have 7 cucumbers

Scenario: Eat 5 out of 20
  Given there are 20 cucumbers
  When I eat 5 cucumbers
  Then I should have 15 cucumbers
```

Es equivalente a 

```gherkin
Scenario Outline: Eating
  Given there are <start> cucumbers
  When I eat <eat> cucumbers
  Then I should have <left> cucumbers

  Examples:
    | start | eat | left |
    |  12   |  5  |  7   |
    |  20   |  5  |  15  |
```

## Tablas

```gherkin
Scenario:
  Given the following people exist:
    | name  | email           | phone |
    | Aslak | aslak@email.com | 123   |
    | Joe   | joe@email.com   | 234   |
    | Bryan | bryan@email.org | 456   |
```

```php
/**
 * @Given the following people exist:
 */
public function thePeopleExist(TableNode $table)
{
    foreach ($table as $row) {
        // $row['name'], $row['email'], $row['phone']
    }
}
```

## Pystrings

```gherkin
Scenario:
  Given a blog post named "Random" with:
    """
    Some Title, Eh?
    ===============
    Here is the first paragraph of my blog post.
    Lorem ipsum dolor sit amet, consectetur adipiscing
    elit.
    """
```

```php
/**
 * @Given a blog post named :title with:
 */
public function blogPost($title, PyStringNode $markdown)
{
    $this->createPost($title, $markdown->getRaw());
}
```

https://docs.behat.org/en/latest/user_guide/writing_scenarios.html#pystrings
