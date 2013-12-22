<?php

namespace Ka\Bundle\TestingBundle\Test\Controller;

use Ka\Bundle\TestingBundle\Test\Constraint\HtmlContainsConstraint;
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
     * Performs a GET request with the client
     *
     * @param string $url
     *
     * @return Crawler
     */
    public static function get($url)
    {
        $client = static::createClient();

        return $client->request('GET', $url);
    }
}
