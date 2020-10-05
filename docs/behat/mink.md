# Mink

## Interacción con el navegador

```php
// get the current page URL:
echo $session->getCurrentUrl();

// use history controls:
$session->reload();
$session->back();
$session->forward();

// set cookie:
$session->setCookie('cookie name', 'value');

// get cookie:
echo $session->getCookie('cookie name');

// delete cookie:
$session->setCookie('cookie name', null);

// get status code
echo $session->getStatusCode();

// setting browser language:
$session->setRequestHeader('Accept-Language', 'fr');

// retrieving response headers:
print_r($session->getResponseHeaders());

// manejo de Basic Auth
$session->setBasicAuth($user, $password);
$session->setBasicAuth(false);

// Execute JS
$session->executeScript('document.body.firstChild.innerHTML = "";');

// evaluate JS expression:
echo $session->evaluateScript(
    "return 'something from browser';"
);

// wait for n milliseconds or
// till JS expression becomes truthy:
$session->wait(
    5000,
    "$('.suggestions-results').children().length"
);

// soft-reset:
$session->reset();

// hard-reset:
$session->stop();
// or if you want to start again at the same time
$session->restart();
```

https://mink.behat.org/en/latest/guides/session.html

## Selectores

Para obtener elementos concretos de la página con los que interactuar o inspeccionar, el primer paso es conseguir la página con

```php
$page = $session->getPage();
```

Y sobre el objeto página, se puede utilizar cualquiera de los métodos indicados en la documentación de Mink:

- Traversing: https://mink.behat.org/en/latest/guides/traversing-pages.html
- Manipulating: https://mink.behat.org/en/latest/guides/manipulating-pages.html
- Interacting: https://mink.behat.org/en/latest/guides/interacting-with-pages.html