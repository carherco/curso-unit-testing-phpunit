# Instalación

```bash
> composer require behat/behat

> vendor/bin/behat --init

+d features - place your *.feature files here
+d features/bootstrap - place your context classes here
+f features/bootstrap/FeatureContext.php - place your definitions, transformations and hooks here

> composer require --dev behat/mink-extension

> composer require behat/mink-goutte-driver
```

GoutteDriver = cURL, 
Selenium2Driver = Real Browser
ChromeDriver = Real Browser

Para selenium:

> java -jar selenium-server-standalone-3.141.59.jar -port 4444

> brew install geckodriver


Para Chrome:

> webdriver-manager clean

> webdriver-manager update

> webdriver-manager start

> /Applications/Google\ Chrome.app/Contents/MacOS/Google\ Chrome --remote-debugging-address=0.0.0.0 --remote-debugging-port=9222