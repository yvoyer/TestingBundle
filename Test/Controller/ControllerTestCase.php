<?php

namespace Ka\Bundle\TestingBundle\Test\Controller;

use Ka\Bundle\TestingBundle\Test\Constraint\HtmlContainsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\RedirectConstraint;
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
    private static $client;

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
     * Performs a GET request with the client
     *
     * @param string $url
     *
     * @return Crawler
     */
    public static function get($url)
    {
        self::$client = static::createClient();

        return self::$client->request('GET', $url);
    }
}
