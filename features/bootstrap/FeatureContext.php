<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext /*implements Context*/ extends MinkContext
{
    private $baseUrl = 'https://staging.------.com';
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     * 
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct()
    {
        // Choose a Mink driver. More about it in later chapters.
        // $driver = new \Behat\Mink\Driver\GoutteDriver();
        // $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $driver = new DMore\ChromeDriver\ChromeDriver('http://localhost:9222', null, $this->baseUrl);

        $this->session = new \Behat\Mink\Session($driver);

        // start the session
        $this->session->start();
    }

    // /**
    //  * @When I log in with an agency
    //  */
    // public function iLogInWithAnAgency()
    // {
    //     $this->session->visit($this->baseUrl . '/login');
    //     $page = $this->session->getPage();
    //     // findField busca por: label, placeholder, id or name 
    //     $page->findField('username')->setValue('op@------.es'); 
    //     $page->findField('password')->setValue('123456'); 
    //     // Busca por: text, title, id, name attribute or alt attribute (for images used inside buttons).
    //     $page->pressButton('Entrar');
        
    //     $this->session->wait(2000);
    //     $page->pressButton('Ok');
    //     // $page->findById('js-error-button')->click();
    // }

    // /**
    //  * @When I search
    //  */
    // public function iSearch()
    // {
    //     $searchUrl = '/panel/vuelos-disponibles/agp-mad-20201010-20201020-100-0000-01110-00-2020100410360027';
    //     $this->session->visit($this->baseUrl . $searchUrl);
    //     $this->session->wait(12000);
    //     // $this->waitForThePageToBeLoaded();
    // }

    // /**
    //  * @When I click Reservar
    //  */
    // public function iClickReservar()
    // {
    //     $page = $this->session->getPage();
    //     $reservarButtons = $page->findAll('named', array('button', 'Reservar'));
    //     $reservarButtons[0]->click();
    //     $this->session->wait(1000);
 
    //     // if() 
    //     // $page->pressButton('Ok');

    // }

    // /**
    //  * @When I add baggages
    //  */
    // public function iAddBaggages()
    // {
    //     $page = $this->session->getPage();
    //     $this->session->wait(1000);
    //     $baggageSection = $page->find('css', 'div.add-ancillaries h2');
    //     $baggageSection->click();
    //     $this->session->wait(1000);
    //     $checkboxes = $page->findAll('css', '#ancillary-baggage input[type=checkbox]');
    //     $checkboxes[0]->check();
    //     $checkboxes[1]->click();
    // }

    // /**
    //  * @Then I should see a total price of :expectedPrice
    //  */
    // public function iShouldSeeATotalPriceOf($expectedPrice)
    // {
    //     $page = $this->session->getPage();
    //     $totalPrice = $page->find('css', 'span.precio-desglose-link')->getText();
    //     Assert::AssertSame($expectedPrice, $totalPrice);
    // }

    // /**
    //  * @Then I should go to url :expectedUrl
    //  */
    // public function iShouldGoToUrl($expectedUrl)
    // {
    //     $currentUrl = $this->session->getCurrentUrl();
    //     Assert::assertSame($expectedUrl, $currentUrl);
    // }

    // /**
    //  * @When I visit :url
    //  */
    // public function iVisit($url)
    // {
    //     $this->session->visit($this->baseUrl . $url);
    // }

    // /**
    //  * @When I click on link :link
    //  */
    // public function iClickOnLink($link)
    // {
    //     $this->session->getPage()->clickLink($link);
    // }

    // /**
    //  * @Then I should see text :arg1
    //  */
    // public function iShouldSeeText($arg1)
    // {
    //     throw new PendingException();
    // }

    // /**
    //  * @When wait :arg1
    //  */
    // public function wait($arg1)
    // {
    //     $this->session->wait($arg1);
    // }

    // /**
    //  * @When /^wait for the page to be loaded$/
    //  */
    // public function waitForThePageToBeLoaded()
    // {
    //     $this->session->wait(20000, "document.readyState === 'complete'");
    // }
}
