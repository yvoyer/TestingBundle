<?php

namespace Ka\Bundle\TestingBundle\Test\Controller;

use Ka\Bundle\TestingBundle\Test\Constraint\Controller\HtmlContainsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Controller\RedirectConstraint;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * TODO: will need to allow passing of additional parameters to client requests
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ControllerTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    public static $client;

    /**
     * @var bool
     */
    public static $isolatedClient = true;

    /**
     * @var string
     */
    private static $lastAuthenticationHash;

    /**
     * Asserts that the HTML Response from a Url contains a given text
     *
     * @param string $text
     * @param string $url
     * @param string $message
     */
    public static function assertHtmlContains($text, $url, $message = '')
    {
        $crawler = static::get($url);

        self::assertThat($text, new HtmlContainsConstraint($crawler), $message);
    }

    /**
     * Asserts that the HTML Response from a Url does not contain a given text
     *
     * @param string $text
     * @param string $url
     * @param string $message
     */
    public static function assertHtmlNotContains($text, $url, $message = '')
    {
        $crawler = static::get($url);

        self::assertThat(
            $text,
            self::logicalNot(
                new HtmlContainsConstraint($crawler)
            ),
            $message
        );
    }

    /**
     * Asserts that the Requested Url redirects
     *
     * @param string $url
     * @param string $message
     */
    public static function assertRedirect($url, $message = '')
    {
        static::get($url);

        self::assertThat(null, new RedirectConstraint(self::$client), $message);
    }

    /**
     * Asserts that the Requested Url does not redirect
     *
     * @param string $url
     * @param string $message
     */
    public static function assertNotRedirect($url, $message = '')
    {
        static::get($url);

        self::assertThat(
            null,
            self::logicalNot(
                new RedirectConstraint(self::$client)
            ),
            $message
        );
    }

    /**
     * Asserts that the Requested Url redirects to another Url
     *
     * @param string $url
     * @param string $redirectUrl
     * @param string $message
     */
    public static function assertRedirectTo($url, $redirectUrl, $message = '')
    {
        static::get($url);

        self::assertThat($redirectUrl, new RedirectConstraint(self::$client), $message);
    }

    /**
     * Asserts that the Requested Url does not redirect to another Url
     *
     * @param string $url
     * @param string $redirectUrl
     * @param string $message
     */
    public static function assertNotRedirectTo($url, $redirectUrl, $message = '')
    {
        static::get($url);

        self::assertThat(
            $redirectUrl,
            self::logicalNot(
                new RedirectConstraint(self::$client)
            ),
            $message
        );
    }

    /**
     * Assert that the Request Url redirects to a login page
     *
     * Note: assertAuthenticationIsNotRequired was omitted because it would be a fragile test. It would still pass
     * even if the page required authentication but was simply using a different login Url. Additionally asserting that
     * the page is absolutely not a redirect would be to rigid.
     *
     * TODO: Support Http Basic authentication
     *
     * @param string $url
     * @param string $loginUrl
     * @param string $message
     */
    public static function assertAuthenticationIsRequired($url, $loginUrl, $message = '')
    {
        self::assertRedirectTo($url, $loginUrl, $message);
    }

    /**
     * Performs a GET request with the client
     *
     * @param string $url
     *
     * @return Crawler
     */
    public static function get($url)
    {
        if (!self::$client || self::$isolatedClient) {
            // TODO: will need to pass options and server parameters to the client
            self::$client = static::createClient(array(
                'debug' => true,
            ));
        }

        return self::$client->request('GET', $url);
    }

    /**
     * Authenticate the client
     *
     * TODO: form button should not be hard-coded
     * TODO: support Http Basic authentication
     *
     * @param string $loginUrl
     * @param string|array $username|$values
     * @param string|null $password
     */
    public static function authenticate($loginUrl, $username, $password = null)
    {
        if (is_array($username)) {
            $values = $username;
        } else {
            $values = array(
                '_username' => $username,
                '_password' => $password,
            );
        }

        $currentAuthenticationHash = md5(serialize($values));

        if ($currentAuthenticationHash !== self::$lastAuthenticationHash) {
            self::$lastAuthenticationHash = $currentAuthenticationHash;
            self::$isolatedClient = true;

            $crawler = self::get($loginUrl);
            $form = $crawler->selectButton('Login')->form($values);
            self::$client->submit($form);

        }

        self::$isolatedClient = false;
    }
}
