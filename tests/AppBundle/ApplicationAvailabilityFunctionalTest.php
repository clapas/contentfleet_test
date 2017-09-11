<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase {

    protected static $client;
    protected static $loggedIn = false;

    public static function setUpBeforeClass() {
        self::$client = self::createClient();
    }

    /**
     * @dataProvider protectedUrlProvider
     */
    public function testPageIsRedirect($url) {
        self::$client->request('GET', $url);
        $this->assertTrue(self::$client->getResponse()->isRedirect());
    }

    /**
     * @dataProvider publicUrlProvider
     */
    public function testPageIsSuccessful($url) {
        self::$client->request('GET', $url);
        $this->assertTrue(self::$client->getResponse()->isSuccessful());
    }

    public function testLoginLogout() {
        $this->doLogin('user', 'user');
        $this->doLogout();
    }
    /**
     * @dataProvider protectedUrlProvider
     */
    public function testAfterLoginPageIsSuccessful($url) {
        $this->doLogin('user', 'user');
        self::$client->request('GET', $url);
        $this->assertTrue(self::$client->getResponse()->isSuccessful());
    }

    public function publicUrlProvider() {
        return array(
            array('/login'),
        );
    }

    public function protectedUrlProvider() {
        return array(
            array('/'),
            array('/loadmore'),
            array('/book/Doctor With Big Eyes'),
            array('/genre/Police'),
        );
    }

    public function doLogin($username, $password) {
        if (self::$loggedIn) return;
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form([
            '_username'  => $username,
            '_password'  => $password,
        ]);     
        self::$client->submit($form);
        $this->assertTrue(self::$client->getResponse()->isRedirect());
        self::$client->followRedirect();
        self::$loggedIn = true;
    }

    public function doLogout() {
        self::$client->request('GET', '/logout');
        $this->assertTrue(self::$client->getResponse()->isRedirect());
        self::$loggedIn = false;
    }
}
