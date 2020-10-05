# Instalación

```bash
> composer require behat/behat

> vendor/bin/behat --init

+d features - place your *.feature files here
+d features/bootstrap - place your context classes here
+f features/bootstrap/FeatureContext.php - place your definitions, transformations and hooks here
```

Para aplicaciones web tenemos la extensión Mink y sus drivers para controlar navegadores:

```bash
> composer require --dev behat/mink-extension

> composer require behat/mink-goutte-driver

> composer require behat/mink-selenium2-driver

> composer require dmore/chrome-mink-driver
```

GoutteDriver = cURL,
Selenium2Driver = Real Browser,
ChromeDriver = Real Browser

Lista de Drivers: https://mink.behat.org/en/latest/guides/drivers.html

## Para selenium

```bash
> java -jar selenium-server-standalone-3.141.59.jar -port 4444

> brew install geckodriver
```

## Para Chrome

```bash
> webdriver-manager clean

> webdriver-manager update

> webdriver-manager start

> /Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222
```